<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 广告主管理,个人广告主,公司广告主
 * Class Platform_advertiser
 */
class Platform_advertiser extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 个人广告主列表
    public function personal_adv_home() {

        $form_data = $this->__build_where4_personal_adv_home_list();

        $data = $this->__get_platform_advertiser_model()->get_advertiser_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_advertiser/personal_adv_home_index',
            [
                'form_data'          => $form_data,
                'list'               => $data['list'],
                'page_link'          => $page_link,
                'adv_audit_status'   => $this->config->item('adv_audit_status'),
                'adv_account_status' => $this->config->item('adv_account_status'),
            ]
        );
    }

    // 公司广告主列表
    public function company_adv_home() {

        $form_data = $this->__build_where4_company_adv_home_list();

        $data = $this->__get_platform_advertiser_model()->get_advertiser_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_advertiser/company_adv_home_index',
            [
                'form_data'          => $form_data,
                'list'               => $data['list'],
                'page_link'          => $page_link,
                'adv_audit_status'   => $this->config->item('adv_audit_status'),
                'adv_account_status' => $this->config->item('adv_account_status'),
            ]
        );
    }

    private function __build_where4_personal_adv_home_list() {
        $advertiser_name  = $this->input->get('advertiser_name', true);
        $advertiser_phone = $this->input->get('advertiser_phone', true);
        $audit_status     = $this->input->get('audit_status', true);
        $create_time      = $this->input->get('create_time', true);
        $id_card          = $this->input->get('id_card', true);
        $advertiser_id    = $this->input->get('advertiser_id', true);
        $status           = $this->input->get('status', true);

        $where = [];
        if (!empty($advertiser_name)) {
            $where['advertiser_name'] = $advertiser_name;
        }

        if (!empty($advertiser_phone)) {
            $where['advertiser_phone'] = $advertiser_phone;
        }

        if ($audit_status !== '' && $audit_status !== null) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($create_time)) {
            $time_arr            = explode(' - ', $create_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($id_card)) {
            $where['id_card'] = $id_card;
        }

        if (!empty($advertiser_id)) {
            $where['advertiser_id'] = $advertiser_id;
        }

        if ($status !== '' && $status !== null) {
            $where['status'] = $status;
        }

        $page_arr                 = $this->get_list_limit_and_offset_params();
        $where['advertiser_type'] = 1;
        $where['no_draft']        = 0;// 去掉status = 草稿0状态的数据
        $where                    = array_merge($page_arr, $where);

        return [
            'advertiser_name'  => $advertiser_name,
            'advertiser_phone' => $advertiser_phone,
            'audit_status'     => $audit_status,
            'create_time'      => $create_time,
            'id_card'          => $id_card,
            'advertiser_id'    => $advertiser_id,
            'status'           => $status,
            'where'            => $where,
        ];
    }

    private function __build_where4_company_adv_home_list() {
        $company_name  = $this->input->get('company_name', true);
        $content_name  = $this->input->get('content_name', true);
        $audit_status  = $this->input->get('audit_status', true);
        $create_time   = $this->input->get('create_time', true);
        $advertiser_id = $this->input->get('advertiser_id', true);
        $content_phone = $this->input->get('content_phone', true);
        $status        = $this->input->get('status', true);

        $where = [];
        if (!empty($company_name)) {
            $where['company_name'] = $company_name;
        }

        if (!empty($content_name)) {
            $where['content_name'] = $content_name;
        }

        if ($audit_status !== '' && $audit_status !== null) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($create_time)) {
            $time_arr            = explode(' - ', $create_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($advertiser_id)) {
            $where['advertiser_id'] = $advertiser_id;
        }

        if (!empty($content_phone)) {
            $where['content_phone'] = $content_phone;
        }

        if ($status !== '' && $status !== null) {
            $where['status'] = $status;
        }

        $page_arr                 = $this->get_list_limit_and_offset_params();
        $where['advertiser_type'] = 2;
        $where['no_draft']        = 0;// 去掉status = 草稿0状态的数据
        $where                    = array_merge($page_arr, $where);

        return [
            'company_name'  => $company_name,
            'content_name'  => $content_name,
            'audit_status'  => $audit_status,
            'create_time'   => $create_time,
            'advertiser_id' => $advertiser_id,
            'content_phone' => $content_phone,
            'status'        => $status,
            'where'         => $where,
        ];
    }

    // 个人广告主详情
    public function personal_adv_detail() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_advertiser/personal_adv_home_index");
        }

        $info = $this->__get_platform_advertiser_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_advertiser/personal_adv_home_index");
        }

        return $this->load->view('admin/platform_advertiser/personal_adv_detail',
            [
                'info'               => $info,
                'log_list'           => json_encode($this->__get_log_list($id)),
                'adv_audit_status'   => $this->config->item('adv_audit_status'),
                'adv_account_status' => $this->config->item('adv_account_status'),
            ]
        );
    }

    // 公司广告主详情
    public function company_adv_detail() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_advertiser/company_adv_home_index");
        }

        $info = $this->__get_platform_advertiser_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_advertiser/company_adv_home_index");
        }

        return $this->load->view('admin/platform_advertiser/company_adv_detail',
            [
                'info'               => $info,
                'log_list'           => json_encode($this->__get_log_list($id)),
                'adv_audit_status'   => $this->config->item('adv_audit_status'),
                'adv_account_status' => $this->config->item('adv_account_status'),
            ]
        );
    }

    private function __get_log_list($advertiser_id) {
        if (empty($advertiser_id)) {
            return [];
        }

        // 系统操作日志
        $where    = ['operate_data_id' => $advertiser_id, 'sys_log_type' => "2,5", "offset" => 0, "limit" => 500];
        $log_list = $this->Sys_log_model->get_sys_log_list_by_condition($where);

        // 用户操作日志
        $where1    = ['operate_data_id' => $advertiser_id, 'user_type' => 1, 'user_log_type' => "1,2,3,4,5,10,11.13", "offset" => 0, "limit" => 500];
        $log_list1 = $this->__get_user_log_model()->get_user_log_list_by_condition($where1);

        // 合并日志
        $log_list2 = array_merge($log_list['list'], $log_list1['list']);
        uasort($log_list2, function ($value1, $value2) {
            if (strtotime($value1['create_time']) == strtotime($value2['create_time'])) {
                return 0;
            }
            return (strtotime($value1['create_time']) < strtotime($value2['create_time'])) ? 1 : -1;
        });

        $result = [];
        foreach ($log_list2 as $value) {

            $name = '';
            if (isset($value['sys_user_name'])) {
                $name = $value['sys_user_name'];
            }
            if (isset($value['user_name'])) {
                $name = $value['user_name'];
            }

            $content = '';
            if (isset($value['sys_log_content'])) {
                $content = $value['sys_log_content'];
            }
            if (isset($value['user_log_content'])) {
                $content = $value['user_log_content'];
            }

            $result[] = [
                'id'          => $value['id'],
                'name'        => $name,
                'create_time' => $value['create_time'],
                'content'     => $content,
            ];
        }

        return $result;
    }

    // 个人广告主和公司广告主的审核
    public function update_adv_audit_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id                    = $req_data['id'];
        $audit_status          = $req_data['audit_status'];
        $reasons_for_rejection = $req_data['reasons_for_rejection'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($audit_status)) {
            return $this->response_json(1, 'audit_status不能为空');
        }

        $info = $this->__get_platform_advertiser_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($audit_status, [1, 2])) {
            return $this->response_json(1, '非法操作');
        }

        $this->db->trans_begin();

        $update_info['last_operator_id']      = $this->sys_user_info['id'];
        $update_info['last_operator_name']    = $this->sys_user_info['user_name'];
        $update_info['audit_status']          = $audit_status;
        $update_info['reasons_for_rejection'] = empty($reasons_for_rejection) ? '' : $reasons_for_rejection;
        $sys_log_content                      = sprintf($this->lang->line('adv_audit_reject4_sys'), $update_info['reasons_for_rejection']);
        $message_content                      = sprintf($this->lang->line('adv_audit_reject4_user'), $update_info['reasons_for_rejection']);

        if ($audit_status === "1") {
            $update_info['reasons_for_rejection'] = "";
            $update_info['status']                = 2;// 当审核通过后需要将status设置为2正常
            $sys_log_content                      = $this->lang->line('adv_audit_pass4_sys');
            $message_content                      = $this->lang->line('adv_audit_pass4_user');
        }

        $result = $this->__get_platform_advertiser_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(2, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            $this->add_user_message($info['advertiser_id'], 1, 1, $message_content);

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response_json(1, '操作失败,请稍候再试');
        }

        $this->db->trans_commit();

        return $this->response_json(0, '操作成功');

    }

    // 个人广告主和公司广告主的账户状态变更
    public function update_adv_account_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id              = $req_data['id'];
        $account_status  = $req_data['account_status'];
        $freezing_reason = $req_data['freezing_reason'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($account_status)) {
            return $this->response_json(1, 'account_status不能为空');
        }

        $info = $this->__get_platform_advertiser_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($account_status, [2, 9])) {
            return $this->response_json(1, '非法操作');
        }

        $update_info['last_operator_id']   = $this->sys_user_info['id'];
        $update_info['last_operator_name'] = $this->sys_user_info['user_name'];
        $update_info['status']             = $account_status;
        $update_info['freezing_reason']    = empty($freezing_reason) ? '' : $freezing_reason;
        $sys_log_content                   = '广告主账户被冻结,冻结的原因是:' . $update_info['freezing_reason'];

        if ($account_status === "2") {
            $update_info['freezing_reason'] = "";
            $sys_log_content                = '广告主账户被解冻';
        }

        $result = $this->__get_platform_advertiser_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(5, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    /**
     * @return Platform_advertiser_model
     */
    private function __get_platform_advertiser_model() {
        $this->load->model('Platform_advertiser_model');
        return $this->Platform_advertiser_model;
    }

    /**
     * @return User_log_model
     */
    private function __get_user_log_model() {
        $this->load->model('User_log_model');
        return $this->User_log_model;
    }

}
