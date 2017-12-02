<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/Admin_Controller.php';

/**
 * 任务管理
 * Class Platform_task
 */
class Platform_task extends Admin_Controller {

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
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where_list() {
        $media_man_name  = $this->input->get('media_man_name', true);
        $school_name     = $this->input->get('school_name', true);
        $audit_status    = $this->input->get('audit_status', true);
        $create_time     = $this->input->get('create_time', true);
        $sex             = $this->input->get('sex', true);
        $media_man_phone = $this->input->get('media_man_phone', true);
        $status          = $this->input->get('status', true);
        $tag             = $this->input->get('tag', true);

        $where = [];
        if (!empty($media_man_name)) {
            $where['media_man_name'] = $media_man_name;
        }

        if (!empty($school_name)) {
            $where['school_name'] = $school_name;
        }

        if ($audit_status !== '' && $audit_status !== null) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($create_time)) {
            $time_arr            = explode(' - ', $create_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($sex)) {
            $where['sex'] = $sex;
        }

        if (!empty($media_man_phone)) {
            $where['media_man_phone'] = $media_man_phone;
        }

        if ($status !== '' && $status !== null) {
            $where['status'] = $status;
        }

        if (!empty($tag)) {
            $where['tag'] = $tag;
        }

        $page_arr                 = $this->get_list_limit_and_offset_params();
        $where['advertiser_type'] = 1;
        $where                    = array_merge($page_arr, $where);

        return [
            'media_man_name'  => $media_man_name,
            'school_name'     => $school_name,
            'audit_status'    => $audit_status,
            'create_time'     => $create_time,
            'sex'             => $sex,
            'media_man_phone' => $media_man_phone,
            'status'          => $status,
            'tag'             => $tag,
            'where'           => $where,
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
