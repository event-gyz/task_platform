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

        $this->load->library('session');
        $this->load->helper(array('url'));

        $this->__check_login();
        $this->__init();
        $this->__check_auth();
    }

    // 检测用户是否登录
    private function __check_login() {
        if (!isset($_SESSION['sys_user_info'])) {
            return redirect("{$this->get_server_address_and_port()}/admin/login/login");
        }
    }

    private function __init() {
        $this->host = $this->get_server_address_and_port();

        $this->load->model('admin/Sys_auth_model');
        $_SESSION['menu_auth_list'] = $this->Sys_auth_model->select_level0_level1_auth_list();

        $my_auth_id = $this->input->get('my_auth_id', true);
        if (!empty($my_auth_id)) {
            $_SESSION['my_auth_id'] = $my_auth_id;
        }

        $this->sys_user_info = $this->get_user_info();
    }

    // 检测用户是否具有操作权限
    private function __check_auth() {

        $request_uri = strtolower($_SERVER['REQUEST_URI']);
        $request_uri = substr($request_uri, '6');// 去掉/admin取其后面的uri

        // 白名单,直接放行
        $white_list = [
            '/index/home',
            '/index/error_403',
        ];

        if ($this->__has_auth($request_uri, $white_list)) {
            return true;
        }

        // 继续检测,判断访问的uri是否在用户的权限数组中
        $user_auth_path = $this->sys_user_info['user_auth_path'];

        if ($this->__has_auth($request_uri, $user_auth_path)) {
            return true;
        }

        return redirect("{$this->get_server_address_and_port()}/admin/index/error_403");
    }

    private function __has_auth($request_uri, $auth_path_arr) {
        $is_has_auth = false;
        foreach ($auth_path_arr as $value) {
            $cur_path = strtolower($value);
            $pos      = strpos($request_uri, $cur_path);

            if ($pos !== false) {
                $is_has_auth = true;
                break;
            }
        }
        return $is_has_auth;
    }

    // 从登录的session中获取用户信息
    protected function get_user_info() {
        return $_SESSION['sys_user_info'];
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
