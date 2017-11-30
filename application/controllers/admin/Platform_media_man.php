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
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where_list() {
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

    /**
     * @return Platform_media_man_model
     */
    private function __get_platform_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }

}
