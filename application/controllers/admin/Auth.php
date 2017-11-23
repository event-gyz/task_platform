<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function home() {
        $auth_list = $this->__get_sys_auth_model()->get_sys_auth_list_by_condition();
        $this->load->view('admin/auth/index', array('auth_list' => $auth_list['list']));
    }

    public function add() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
            array(
                'field'  => 'auth_name',
                'label'  => '权限名称',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'class',
                'label'  => '类',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'action',
                'label'  => '方法',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        $req_data  = $this->input->post();
        $auth_list = $this->__get_sys_auth_model()->select_level0_level1_auth_list();

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/auth/add', array('auth_list' => $auth_list));
        }

        $data = array(
            'pid'       => $req_data['pid'],
            'auth_name' => $req_data['auth_name'],
            'class'     => $req_data['class'],
            'action'    => $req_data['action'],
            'level'     => $this->__calc_level($req_data['pid']),
        );

        $result = $this->__get_sys_auth_model()->insert($data);

        if ($result) {
            return $this->load->view('admin/auth/home');
        }

        return $this->load->view('admin/auth/add', array('auth_list' => $auth_list));
    }

    public function home2() {
        $this->load->view('admin/index/index2');
    }

    // 插入系统用户
    public function insert() {
        $pwd    = '123456';
        $salt   = $this->__get_sys_user_model()->random_str(4);
        $data   = array(
            'user_name' => 'zhaohongyu',
            'nick_name' => '老王',
            'salt'      => $salt,
            'pwd'       => $this->__get_sys_user_model()->generate_admin_password($pwd, $salt),
        );
        $result = $this->__get_sys_user_model()->insert($data);
    }

    // 更新系统用户
    public function update_sys_user() {
        $sys_user_id = 1;
        $info        = ['nick_name' => '老王1'];
        $result      = $this->__get_sys_user_model()->update_sys_user($sys_user_id, $info);
    }

    // 查询系统用户
    public function select_by_id() {
        $sys_user_id = 1;
        $result      = $this->__get_sys_user_model()->select_by_id($sys_user_id);
    }

    // 根据用户选择的pid来计算即将入库的菜单等级
    private function __calc_level($pid) {

        // pid为0的为一级菜单即level = 0

        if ($pid == 0) {
            return 0;
        }

        // pid为其他值的需要查询其权限详情然后获取其level在此基础上+1
        $auth_info = $this->__get_sys_auth_model()->select_by_id($pid);

        return empty($auth_info) ? 0 : ($auth_info['level'] + 1);
    }

    /**
     * @return Sys_auth_model
     */
    private function __get_sys_auth_model() {
        $this->load->model('admin/Sys_auth_model');
        return $this->Sys_auth_model;
    }


}
