<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台
 */
class ADMIN_Controller extends CI_Controller {

    public $_return = array('error_no' => 0, 'msg' => '', 'data' => array());

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    protected function response($response = null) {
        header('Content-Type:application/json;charset=utf-8');
        if (!empty($response) && $response != null) {
            echo json_encode($response);
        } else {
            echo json_encode($this->_return);
        }
        die();
    }

    // 获取列表页需要的参数limit和offset
    protected function get_list_page_and_list() {
        $_page           = $this->input->get('page');
        $page            = empty($_page) ? 1 : $_page;
        $limit           = 1;
        $where['offset'] = ($page - 1) * $limit;
        $where['limit']  = $limit;
        return $where;
    }

}
