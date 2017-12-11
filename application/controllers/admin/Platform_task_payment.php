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

    /**
     * @return Platform_task_payment_model
     */
    private function __get_platform_task_payment_model() {
        $this->load->model('Platform_task_payment_model');
        return $this->Platform_task_payment_model;
    }

}
