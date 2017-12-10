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

    // 任务列表
    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_model()->get_task_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_task_payment/index',
            [
                'form_data'                => $form_data,
                'list'                     => $data['list'],
                'page_link'                => $page_link,
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'release_task_status'      => $this->config->item('release_task_status'),
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

            // '1' => '待发布',---> release_status = 0
            // '2' => '执行中',---> release_status = 1
            // '3' => '待确认完成',---> release_status = 1

            switch ($task_status) {
                case 1:
                    $where['release_status'] = 0;
                    break;
                case 2:
                    // 在任务发布后，结束时间到达前(即搜索当前时间小于platform_task.end_time的记录)，状态均为执行中
                    $where['release_status'] = 1;
                    $where['task_status']    = 'execute';
                    $where['cur_time_stamp'] = time();
                    break;
                case 3:
                    // 当任务结束时间到达后，(即搜索当前时间大于platform_task.end_time的记录)，则状态变更为待确认完成
                    $where['release_status'] = 1;
                    $where['task_status']    = 'to_be_confirm';
                    $where['cur_time_stamp'] = time();
                    break;
                default:
            }

        }

        // 财务已确认收款
        $where['pay_status']     = 1;
        $where['audit_status']   = 3;
        $where['finance_status'] = 1;

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

    /**
     * @return Platform_task_model
     */
    private function __get_platform_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }

}
