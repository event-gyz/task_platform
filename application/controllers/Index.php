<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function home()
    {

//        $this->load->library('page');
//        $url                = '/order/companyOrder/order_list?';
//        $page               = $this->page->get_page($total, $number, $url);
//        $data['show_page']  = $page ['show_page'];
        $this->load->model('Platform_task_payment_model');
        $data = $this->Platform_task_payment_model->get_task_payment_list_by_condition(111);
        echo '<pre>';print_r($data);exit;
        $this->load->view('index/index');
    }
}
