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
                'form_data'                          => $form_data,
                'list'                               => $data['list'],
                'page_link'                          => $page_link,
                'media_man_list_finance_status_list' => $this->config->item('media_man_list_finance_status'),
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

    /**
     * @return Platform_task_receivables_model
     */
    private function __get_platform_task_receivables_model() {
        $this->load->model('Platform_task_receivables_model');
        return $this->Platform_task_receivables_model;
    }

}
