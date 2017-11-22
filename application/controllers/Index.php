<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function home()
	{

		$this->load->model('Platform_task_payment_model');
		$data = $this->Platform_task_payment_model->get_task_payment_list_by_condition(111);
		echo '<pre>';print_r($data);exit;
		$this->load->view('index/index');
	}
}
