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
    protected function get_list_limit_and_offset_params() {
        $_page           = $this->input->get('page');
        $page            = empty($_page) ? 1 : $_page;
        $limit           = 10;
        $where['offset'] = ($page - 1) * $limit;
        $where['limit']  = $limit;
        return $where;
    }

    /**
     * 获取分页链接
     *
     * @param $total 总记录数
     * @param $limit 每页显示记录数
     *
     * @return string
     */
    protected function get_page_link($total, $limit) {
        $this->load->library('Page');
        return $this->page->get_page($total, $limit);
    }

}
