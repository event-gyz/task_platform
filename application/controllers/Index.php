<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function home()
	{

		$this->load->model('Text_model');
		$data = $this->Text_model->test();
		echo '<pre>';print_r($data);exit;
		$this->load->view('index/index');
	}
}
