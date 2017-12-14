<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台
 */
class ADMIN_Controller extends CI_Controller {

    protected $host          = '';
    protected $sys_user_info = [];

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'wap'));

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

        $this->load->model('admin/Sys_log_model');
        $this->load->model('admin/Sys_auth_model');
        $this->load->model('User_message_model');

        if (empty($_SESSION['menu_auth_list'])) {
            $_SESSION['menu_auth_list'] = $this->Sys_auth_model->select_level0_level1_auth_list();
        }

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

    /**
     * 输出json信息
     *
     * @param int    $code 返回码
     * @param string $msg  返回消息
     * @param array  $data 返回数据
     *
     * @return json
     */
    protected function response_json($code, $msg = '', $data = array()) {
        if (!is_numeric($code)) {
            return '';
        }
        $result = array(
            'error_no' => $code,
            'msg'      => $msg,
            'data'     => $data,
        );
        header("Content-type:application/json;;charset=utf-8");
        die(json_encode($result));
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

    /**
     * 添加系统操作日志
     *
     * @param int    $sys_log_type    系统日志类型,
     *                                1登录,2审核广告主,3审核自媒体人,4审核任务,
     *                                5冻结广告主,6冻结自媒体人,7确认广告主付款,8修改任务价格,
     *                                9手工作废,10修改自媒体人信息,11任务设置为已完成,
     *                                12审核自媒体人交付的任务,13确认付款给自媒体人,
     *                                14确认收到广告主付款
     * @param string $sys_log_content 日志内容
     * @param int    $operate_data_id 所操作的数据id
     * @param string $old_data        原数据
     * @param string $new_data        新数据
     */
    protected function add_sys_log($sys_log_type, $sys_log_content = '', $operate_data_id = 0, $old_data = '', $new_data = '') {
        try {

            $data = [
                'sys_user_id'     => $this->sys_user_info['id'],
                'sys_user_name'   => $this->sys_user_info['user_name'],
                'operate_data_id' => $operate_data_id,
                'sys_log_type'    => $sys_log_type,
                'sys_log_content' => $sys_log_content,
                'old_data'        => $old_data,
                'new_data'        => $new_data,
            ];

            $this->Sys_log_model->insert($data);

        } catch (Exception $e) {
        }
    }

    /**
     * 添加用户站内信消息
     *
     * @param int    $user_id         自媒体人或者广告主主键id
     * @param int    $user_type       1广告主,2自媒体人
     * @param int    $message_type    1审核通知,2任务通知
     * @param string $message_content 消息内容
     * @param int    $task_id         关连的任务ID，message_type=1该字段为0
     * @param string $message_url     消息对应的链接地址
     */
    protected function add_user_message($user_id, $user_type = 1, $message_type = 2, $message_content = '', $task_id = 0, $message_url = '') {
        try {

            $data = [
                'user_id'         => $user_id,
                'user_type'       => $user_type,
                'message_type'    => $message_type,
                'message_content' => $message_content,
                'message_url'     => $message_url,
                'task_id'         => $task_id,
            ];

            $this->User_message_model->insert($data);

        } catch (Exception $e) {
        }
    }

}
