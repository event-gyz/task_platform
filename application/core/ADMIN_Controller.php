<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台
 */
class ADMIN_Controller extends CI_Controller {

    protected $_return       = array('error_no' => 0, 'msg' => '', 'data' => array());
    protected $host          = '';
    protected $sys_user_info = [];

    public function __construct() {
        parent::__construct();
        $this->__check_login();
        $this->__init();
        $this->__check_auth();
    }

    // todo 检测用户是否登录
    private function __check_login() {

    }

    private function __init() {
        $this->load->helper('url');
        $this->host = $this->get_server_address_and_port();

        $this->load->model('admin/Sys_auth_model');
        $this->load->library('session');
        $_SESSION['auth_list'] = $this->Sys_auth_model->select_level0_level1_auth_list();

        $this->sys_user_info = $this->get_user_info();
    }

    // todo 检测用户是否具有操作权限
    private function __check_auth() {

    }

    // todo 从登录的session中获取用户信息
    protected function get_user_info() {
        $sys_user_info = [
            'id'        => 1,
            'user_name' => 'admin',
            'nick_name' => '超级管理员',
            'mobile'    => '18600833853',
        ];
        return $sys_user_info;
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
