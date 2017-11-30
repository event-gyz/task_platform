<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/Admin_Controller.php';

/**
 * 自媒体人管理
 * Class Platform_media_man
 */
class Platform_media_man extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 自媒体人列表
    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_media_man_model()->get_media_man_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_media_man/index',
            [
                'form_data'            => $form_data,
                'list'                 => $data['list'],
                'page_link'            => $page_link,
                'media_audit_status'   => $this->config->item('media_audit_status'),
                'media_account_status' => $this->config->item('media_account_status'),
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

    public function media_man_detail() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        return $this->load->view('admin/platform_media_man/media_man_detail',
            [
                'info'                 => $info,
                'media_audit_status'   => $this->config->item('media_audit_status'),
                'media_account_status' => $this->config->item('media_account_status'),
            ]
        );
    }

    /**
     * @return Platform_media_man_model
     */
    private function __get_platform_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }

}
