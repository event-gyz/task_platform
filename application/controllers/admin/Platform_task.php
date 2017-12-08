<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 任务管理
 * Class Platform_task
 */
class Platform_task extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 任务列表
    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_model()->get_task_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_task/index',
            [
                'form_data'                => $form_data,
                'list'                     => $data['list'],
                'page_link'                => $page_link,
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'task_status_list'         => $this->config->item('task_status'),
            ]
        );
    }

    private function __build_where_list() {
        $task_name           = $this->input->get('task_name', true);
        $publishing_platform = $this->input->get('publishing_platform', true);
        $task_type           = $this->input->get('task_type', true);
        $submit_audit_time   = $this->input->get('submit_audit_time', true);
        $task_status         = $this->input->get('task_status', true);

        $where = [];
        if (!empty($task_name)) {
            $where['task_name'] = $task_name;
        }

        if (!empty($publishing_platform)) {
            $where['publishing_platform'] = $publishing_platform;
        }

        if ($task_type !== '' && $task_type !== null) {
            $where['task_type'] = $task_type;
        }

        if (!empty($submit_audit_time)) {
            $time_arr            = explode(' - ', $submit_audit_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($task_status)) {

            // '1' => '待审核',---> audit_status = 1
            // '2' => '待广告主付款',---> pay_status = 0 && audit_status = 3
            // '3' => '待财务确认',---> pay_status = 1 && audit_status = 3 && platform_task_payment.finance_status = 0
            // '4' => '财务已确认',---> pay_status = 1 && audit_status = 3 && platform_task_payment.finance_status = 1
            // '5' => '驳回',---> audit_status = 2

            switch ($task_status) {
                case 1:
                    $where['audit_status'] = 1;
                    break;
                case 2:
                    $where['pay_status']   = 0;
                    $where['audit_status'] = 3;
                    break;
                case 3:
                    $where['pay_status']     = 1;
                    $where['audit_status']   = 3;
                    $where['finance_status'] = 0;
                    break;
                case 4:
                    $where['pay_status']     = 1;
                    $where['audit_status']   = 3;
                    $where['finance_status'] = 1;
                    break;
                case 5:
                    $where['audit_status'] = 2;
                    break;
                default:
            }

        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'task_name'           => $task_name,
            'publishing_platform' => $publishing_platform,
            'task_type'           => $task_type,
            'submit_audit_time'   => $submit_audit_time,
            'task_status'         => $task_status,
            'where'               => $where,
        ];
    }

    // 任务详情
    public function task_detail() {
        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_task/home");
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_task/home");
        }

        $advertiser_info = [];
        if (!empty($info['advertiser_user_id'])) {
            $advertiser_info = $this->__get_platform_advertiser_model()->selectById($info['advertiser_user_id']);
        }

        $where    = ['operate_data_id' => $id, 'sys_log_type' => "4,8,9,11,12", "offset" => 0, "limit" => 200];
        $log_list = $this->Sys_log_model->get_sys_log_list_by_condition($where);

        $where1    = ['operate_data_id' => $id, 'user_log_type' => "3,4,5,6,7,9", "offset" => 0, "limit" => 200];
        $log_list1 = $this->__get_user_log_model()->get_user_log_list_by_condition($where1);

        $log_list2 = array_merge($log_list['list'], $log_list1['list']);
        uasort($log_list2, function ($value1, $value2) {
            if (strtotime($value1['create_time']) == strtotime($value2['create_time'])) {
                return 0;
            }
            return (strtotime($value1['create_time']) < strtotime($value2['create_time'])) ? 1 : -1;
        });

        return $this->load->view('admin/platform_task/task_detail',
            [
                'info'                     => $info,
                'log_list'                 => $log_list2,
                'advertiser_info'          => $advertiser_info,
                'adv_audit_status'         => $this->config->item('adv_audit_status'),
                'adv_account_status'       => $this->config->item('adv_account_status'),
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'task_audit_status'        => $this->config->item('task_audit_status'),
                'task_completion_criteria' => $this->config->item('task_completion_criteria'),
            ]
        );
    }

    // 任务审核
    public function update_task_audit_status() {
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

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($audit_status, [2, 3])) {
            return $this->response_json(1, '非法操作');
        }

        $update_info['audit_status']          = $audit_status;
        $update_info['reasons_for_rejection'] = empty($reasons_for_rejection) ? '' : $reasons_for_rejection;
        $sys_log_content                      = '任务审核驳回,驳回的原因是:' . $update_info['reasons_for_rejection'];

        if ($audit_status === "3") {
            $update_info['reasons_for_rejection'] = "";
            $sys_log_content                      = '任务审核通过';
        }

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(4, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    // 手工作废任务
    public function update_task_release_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id             = $req_data['id'];
        $release_status = $req_data['release_status'];
        $close_reason   = $req_data['close_reason'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($release_status)) {
            return $this->response_json(1, 'release_status不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($release_status, [8])) {
            return $this->response_json(1, '非法操作');
        }

        $update_info['release_status'] = $release_status;
        $update_info['close_reason']   = empty($close_reason) ? '' : $close_reason;
        $sys_log_content               = '任务发布状态被更新';

        if ($release_status === "8") {
            $sys_log_content = '任务被手工作废';
        }

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(9, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    /**
     * @return Platform_task_model
     */
    private function __get_platform_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
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
