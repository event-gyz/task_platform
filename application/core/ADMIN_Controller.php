<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台
 */
class ADMIN_Controller extends CI_Controller {

    protected $_return = array('error_no' => 0, 'msg' => '', 'data' => array());
    protected $host    = '';

    public function __construct() {
        parent::__construct();
        $this->__init();
    }

    private function __init() {
        $this->load->helper('url');
        $this->host = $this->get_server_address_and_port();

        $this->load->model('admin/Sys_auth_model');
        $this->load->library('session');
        $_SESSION['auth_list'] = $this->Sys_auth_model->select_level0_level1_auth_list();
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

    /**
     * 获得当前的域名
     *
     * @return string
     */
    protected function get_server_address_and_port() {
        /* 协议 */
        $protocol = (isset($_SERVER ['HTTPS']) && (strtolower($_SERVER ['HTTPS']) != 'off')) ? 'https://' : 'http://';
        /* 域名或IP地址 */
        if (isset($_SERVER ['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER ['HTTP_X_FORWARDED_HOST'];
        } elseif (isset($_SERVER ['HTTP_HOST'])) {
            $host = $_SERVER ['HTTP_HOST'];
        } else {
            /* 端口 */
            if (isset($_SERVER ['SERVER_PORT'])) {
                $port = ':' . $_SERVER ['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol)) {
                    $port = '';
                }
            } else {
                $port = '';
            }
            if (isset($_SERVER ['SERVER_NAME'])) {
                $host = $_SERVER ['SERVER_NAME'] . $port;
            } elseif (isset($_SERVER ['SERVER_ADDR'])) {
                $host = $_SERVER ['SERVER_ADDR'] . $port;
            }
        }
        return $protocol . $host;
    }

}
