<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台
 */
class Admin_Controller extends CI_Controller {
    public $_return = array('errorno' => 0, 'msg' => '', 'data' => array());

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
	public function response($response = null)
	{
		header('Content-Type:application/json;charset=utf-8'); 
		if(!empty($response) && $response!=null){
		    echo json_encode($response);
		}else{
		    echo json_encode($this->_return);
		}
		die();
	}
}
