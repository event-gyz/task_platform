<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 广告主任务付款表
 * Class Platform_task_payment
 */
class Platform_task_payment extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_payment_model()->get_task_payment_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_task_payment/index',
            [
                'form_data'             => $form_data,
                'list'                  => $data['list'],
                'page_link'             => $page_link,
                'finance_status_list'   => $this->config->item('adv_list_finance_status'),
                'platform_pay_way_list' => $this->config->item('adv_list_pay_way'),
            ]
        );
    }

    private function __build_where_list() {
        $advertiser_login_name = $this->input->get('advertiser_login_name', true);
        $u_name_or_c_name      = $this->input->get('u_name_or_c_name', true);
        $u_phone_or_c_phone    = $this->input->get('u_phone_or_c_phone', true);
        $adv_finance_status    = $this->input->get('adv_finance_status', true);

        $where = [];
        if (!empty($advertiser_login_name)) {
            $where['advertiser_login_name'] = $advertiser_login_name;
        }

        if (!empty($u_name_or_c_name)) {
            $where['u_name_or_c_name'] = $u_name_or_c_name;
        }

        if (!empty($u_phone_or_c_phone)) {
            $where['u_phone_or_c_phone'] = $u_phone_or_c_phone;
        }

        if (!empty($adv_finance_status)) {

            // '1' => '待财务确认',---> 待财务确认 finance_status = 0
            // '2' => '已支付',---> 自媒体人待确认收款 finance_status = 1

            switch ($adv_finance_status) {
                case 1:
                    $where['finance_status'] = 0;
                    break;
                case 2:
                    $where['finance_status'] = 1;
                    break;
                default:
            }

        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'advertiser_login_name' => $advertiser_login_name,
            'u_name_or_c_name'      => $u_name_or_c_name,
            'u_phone_or_c_phone'    => $u_phone_or_c_phone,
            'adv_finance_status'    => $adv_finance_status,
            'where'                 => $where,
        ];
    }

    public function upload_file() {

        $task_id       = $this->input->post('task_id');
        $img_timestamp = $this->input->post('img_timestamp');

        if (empty($task_id)) {
            return $this->response_json(1, '缺少必要参数,请刷新页面再试', ['file_path' => '']);
        }

        $sub_upload_path = "/upload/pay_voucher/{$task_id}";
        $upload_path     = FCPATH . $sub_upload_path;
        if (!file_exists($upload_path)) {
            wap::create_folders($upload_path);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '2048';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors('', '');
            return $this->response_json(1, $error, ['file_path' => '']);
        } else {
            $data      = $this->upload->data();
            $file_path = $sub_upload_path . '/' . $data['file_name'];
            return $this->response_json(0, '上传成功',
                [
                    'file_path'     => $file_path,
                    'img_timestamp' => $img_timestamp,
                ]
            );
        }
    }

    public function confirm_receive_money() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $task_id        = $req_data['task_id'];
        $payment_id     = $req_data['payment_id'];
        $pay_money      = $req_data['pay_money'];
        $fileList       = $req_data['fileList'];
        $confirm_remark = $req_data['confirm_remark'];

        if (empty($task_id)) {
            return $this->response_json(1, 'task_id不能为空');
        }

        if (empty($payment_id)) {
            return $this->response_json(1, 'payment_id不能为空');
        }

        if (!is_numeric($pay_money)) {
            return $this->response_json(1, '请输入有效确认金额');
        }

        if ($pay_money <= 0) {
            return $this->response_json(1, '确认金额只能是正数');
        }

        if (empty($fileList)) {
            return $this->response_json(1, '请上传凭证');
        }

        $info = $this->__get_platform_task_model()->selectById($task_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $task_payment_info = $this->__get_platform_task_payment_model()->selectById($payment_id);

        if (empty($task_payment_info)) {
            return $this->response_json(1, '查找不到对应的付款信息');
        }

        $update_info['finance_status']    = 1;// 设定广告主付款状态为财务已确认
        $update_info['pay_money']         = $pay_money;
        $update_info['pay_voucher']       = json_encode(array_column($fileList, 'file_path'));// 支付凭证
        $update_info['confirming_person'] = $this->sys_user_info['id'];
        $update_info['confirm_remark']    = $confirm_remark;
        $sys_log_content                  = "{$this->sys_user_info['user_name']}确认了收款";

        $result = $this->__get_platform_task_payment_model()->updateInfo($payment_id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(14, $sys_log_content, $task_id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');

    }

    /**
     * @return Platform_task_payment_model
     */
    private function __get_platform_task_payment_model() {
        $this->load->model('Platform_task_payment_model');
        return $this->Platform_task_payment_model;
    }

    /**
     * @return Platform_task_model
     */
    private function __get_platform_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }

}
