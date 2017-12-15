<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public $host = '';

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('form', 'url'));

        $this->host = $this->get_server_address_and_port();
    }

    public function login() {
        $this->load->library('form_validation');

        $info   = [];
        $config = array(
            array(
                'field'  => 'user_name',
                'label'  => '用户名',
                'rules'  => array(
                    'required',
                    array(
                        'user_not_exists',
                        function ($val) {
                            global $info;
                            $info = $this->__get_sys_user_model()->select_by_user_name($val);
                            return !empty($info);
                        },
                    ),
                ),
                'errors' => array(
                    'required'        => '请填写%s',
                    'user_not_exists' => '用户名不存在,或者被禁用',
                ),
            ),
            array(
                'field'  => 'pwd',
                'label'  => '密码',
                'rules'  => array(
                    'required',
                    array(
                        'wrong_pwd',
                        function ($val) {
                            global $info;
                            return $this->__get_sys_user_model()->check_admin_password($val, $info['pwd'], $info['salt']);
                        },
                    ),
                ),
                'errors' => array(
                    'required'  => '请填写%s',
                    'wrong_pwd' => '密码错误',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('/admin/login/login');
        }

        global $info;

        // 存储认证信息

        $sys_user_info = [
            'id'        => $info['id'],
            'user_name' => $info['user_name'],
            'nick_name' => $info['nick_name'],
            'mobile'    => $info['mobile'],
            'salt'      => $info['salt'],
            'role_id'   => $info['role_id'],
            'role_name' => $info['role_name'],
            'dept_id'   => $info['dept_id'],
            'dept_name' => $info['dept_name'],
            'auth_ids'  => $info['auth_ids'],
        ];

        $user_auth_list = [];
        if (!empty($info['auth_ids'])) {
            $user_auth_list = $this->__get_sys_auth_model()->get_auth_list_by_auth_ids($info['auth_ids']);
        }

        $user_auth_path = [];
        foreach ($user_auth_list as $value) {
            $user_auth_path[] = strtolower("/{$value['class']}/{$value['action']}");
        }

        $sys_user_info['user_auth_path'] = $user_auth_path;

        $_SESSION['sys_user_info'] = $sys_user_info;

        return redirect("{$this->host}/admin/index/home");
    }

    public function logout() {
        unset($_SESSION['sys_user_info']);
        unset($_SESSION['auth_list']);
        session_destroy();
        return redirect("{$this->host}/admin/login/login");
    }

    public function modify_pwd() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $sys_user_id = $this->input->get_post('id', true);

        if (empty($sys_user_id)) {
            return redirect("{$this->host}/admin/index/home");
        }

        $sys_user_info = $this->__get_sys_user_model()->select_by_id($sys_user_id);

        if (empty($sys_user_info)) {
            return redirect("{$this->host}/admin/index/home");
        }

        $GLOBALS['sys_user_info'] = $sys_user_info;

        $config = array(
            array(
                'field'  => 'pwd',
                'label'  => '原密码',
                'rules'  => array(
                    'required',
                    array(
                        'wrong_pwd',
                        function ($val) {
                            return $this->__get_sys_user_model()->check_admin_password($val, $GLOBALS['sys_user_info']['pwd'], $GLOBALS['sys_user_info']['salt']);
                        },
                    ),
                ),
                'errors' => array(
                    'required'  => '请填写%s',
                    'wrong_pwd' => '原密码错误',
                ),
            ),
            array(
                'field'  => 're_pwd',
                'label'  => '新密码',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 're2_pwd',
                'label'  => '确认新密码',
                'rules'  => 'required|matches[re_pwd]',
                'errors' => array(
                    'required' => '请填写%s',
                    'matches'  => '新密码必须一致',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/login/modify_pwd', ['info' => $sys_user_info]);
        }

        $req_data = $this->input->post();
        $pwd      = $req_data['re2_pwd'];
        $salt     = $this->__get_sys_user_model()->random_str(4);

        $update_info = array(
            'salt'                    => $salt,
            'pwd'                     => $this->__get_sys_user_model()->generate_admin_password($pwd, $salt),
            'last_modify_sys_user_id' => $sys_user_info['id'],
        );

        $result = $this->__get_sys_user_model()->update_sys_user($sys_user_id, $update_info);

        if ($result) {

            unset($GLOBALS['sys_user_info']);

            return redirect("{$this->host}/admin/login/logout");
        }

        return $this->load->view('admin/login/modify_pwd', ['info' => $sys_user_info]);
    }

    /**
     * @return Sys_user_model
     */
    private function __get_sys_user_model() {
        $this->load->model('admin/Sys_user_model');
        return $this->Sys_user_model;
    }

    /**
     * @return Sys_auth_model
     */
    private function __get_sys_auth_model() {
        $this->load->model('admin/Sys_auth_model');
        return $this->Sys_auth_model;
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
