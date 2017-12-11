<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 自媒体人任务收款表
 * Class Platform_task_receivables
 */
class Platform_task_receivables extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_receivables_model()->get_task_receivables_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_task_receivables/index',
            [
                'form_data'             => $form_data,
                'list'                  => $data['list'],
                'page_link'             => $page_link,
                'finance_status_list'   => $this->config->item('media_man_list_finance_status'),
                'platform_pay_way_list' => $this->config->item('media_man_list_platform_pay_way'),
            ]
        );
    }

    private function __build_where_list() {
        $media_man_login_name = $this->input->get('media_man_login_name', true);
        $school_name          = $this->input->get('school_name', true);
        $zfb_nu               = $this->input->get('zfb_nu', true);
        $m_finance_status     = $this->input->get('m_finance_status', true);

        $where = [];
        if (!empty($media_man_login_name)) {
            $where['media_man_login_name'] = $media_man_login_name;
        }

        if (!empty($school_name)) {
            $where['school_name'] = $school_name;
        }

        if (!empty($zfb_nu)) {
            $where['zfb_nu'] = $zfb_nu;
        }

        if (!empty($m_finance_status)) {

            // '1' => '待付款',---> 财务待付款 finance_status = 0
            // '2' => '待确认收款',---> 自媒体人待确认收款 finance_status = 1 & receivables_status = 0
            // '3' => '已完成',---> 财务确认付款,自媒体人确认收款 finance_status = 1 & receivables_status = 1

            switch ($m_finance_status) {
                case 1:
                    $where['finance_status'] = 0;
                    break;
                case 2:
                    $where['finance_status']     = 1;
                    $where['receivables_status'] = 0;
                    break;
                case 3:
                    $where['finance_status']     = 1;
                    $where['receivables_status'] = 1;
                    break;
                default:
            }

        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'media_man_login_name' => $media_man_login_name,
            'school_name'          => $school_name,
            'zfb_nu'               => $zfb_nu,
            'm_finance_status'     => $m_finance_status,
            'where'                => $where,
        ];
    }

    public function confirm_pay_money() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $receivables_id = $req_data['receivables_id'];

        if (empty($receivables_id)) {
            return $this->response_json(1, 'receivables_id不能为空');
        }

        $info = $this->__get_platform_task_receivables_model()->selectById($receivables_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $update_info['finance_status']    = 1;// 设定自媒体人结账记录为财务已确认付款
        $update_info['confirming_person'] = $this->sys_user_info['id'];
        $sys_log_content                  = "{$this->sys_user_info['user_name']}确认了付款";

        $result = $this->__get_platform_task_receivables_model()->updateInfo($receivables_id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(13, $sys_log_content, $receivables_id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    /**
     * @return Platform_task_receivables_model
     */
    private function __get_platform_task_receivables_model() {
        $this->load->model('Platform_task_receivables_model');
        return $this->Platform_task_receivables_model;
    }

}
