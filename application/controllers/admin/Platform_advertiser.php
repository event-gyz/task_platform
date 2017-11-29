<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/Admin_Controller.php';

/**
 * 广告主管理,个人广告主,公司广告主
 * Class Platform_advertiser
 */
class Platform_advertiser extends Admin_Controller {

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
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
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
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where4_personal_adv_home_list() {
        $advertiser_name  = $this->input->get('advertiser_name', true);
        $advertiser_phone = $this->input->get('advertiser_phone', true);
        $audit_status     = $this->input->get('audit_status', true);
        $start_time       = $this->input->get('start_time', true);
        $end_time         = $this->input->get('end_time', true);
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

        if (!empty($audit_status)) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($start_time)) {
            $where['start_time'] = $start_time;
        }

        if (!empty($end_time)) {
            $where['end_time'] = $end_time;
        }

        if (!empty($id_card)) {
            $where['id_card'] = $id_card;
        }

        if (!empty($advertiser_id)) {
            $where['advertiser_id'] = $advertiser_id;
        }

        if (!empty($status)) {
            $where['status'] = $status;
        }

        $page_arr                 = $this->get_list_limit_and_offset_params();
        $where['advertiser_type'] = 1;
        $where                    = array_merge($page_arr, $where);

        return [
            'advertiser_name'  => $advertiser_name,
            'advertiser_phone' => $advertiser_phone,
            'audit_status'     => $audit_status,
            'start_time'       => $start_time,
            'end_time'         => $end_time,
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
        $start_time    = $this->input->get('start_time', true);
        $end_time      = $this->input->get('end_time', true);
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

        if (!empty($audit_status)) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($start_time)) {
            $where['start_time'] = $start_time;
        }

        if (!empty($end_time)) {
            $where['end_time'] = $end_time;
        }

        if (!empty($advertiser_id)) {
            $where['advertiser_id'] = $advertiser_id;
        }

        if (!empty($content_phone)) {
            $where['content_phone'] = $content_phone;
        }

        if (!empty($status)) {
            $where['status'] = $status;
        }

        $page_arr                 = $this->get_list_limit_and_offset_params();
        $where['advertiser_type'] = 2;
        $where                    = array_merge($page_arr, $where);

        return [
            'company_name'  => $company_name,
            'content_name'  => $content_name,
            'audit_status'  => $audit_status,
            'start_time'    => $start_time,
            'end_time'      => $end_time,
            'advertiser_id' => $advertiser_id,
            'content_phone' => $content_phone,
            'status'        => $status,
            'where'         => $where,
        ];
    }

    /**
     * @return Platform_advertiser_model
     */
    private function __get_platform_advertiser_model() {
        $this->load->model('Platform_advertiser_model');
        return $this->Platform_advertiser_model;
    }

}
