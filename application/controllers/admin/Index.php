<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require dirname(FCPATH) . '/core/Admin_Controller.php';

class Index extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {
        return $this->load->view('admin/index/index');
    }

    public function error_403() {
        return $this->load->view('admin/errors/403');
    }

}
