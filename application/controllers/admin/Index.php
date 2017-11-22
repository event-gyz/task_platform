<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function home() {
        $result = $this->__get_sys_user_model()->get_sys_user_list_by_condition();
        $this->load->view('admin/index/index');
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

    /**
     * @return Sys_user_model
     */
    private function __get_sys_user_model() {
        $this->load->model('admin/Sys_user_model');
        return $this->Sys_user_model;
    }


}
