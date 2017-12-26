<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {
        $this->load->helper(array('url', 'wap'));
        return redirect(wap::get_server_address_and_port() . '/advertiser/index/home');
    }

    // 发送短信，可用
    public function testsms() {
        // $this->load->library('JSMS');
        // $this->JSMS = new JSMS();
        // $this->JSMS->sendMessage('15710061246',1,['code'=>'4178']);
    }
}
