<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/Admin_Controller.php';

class Auth extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where4_list();

        $auth_arr = $this->__get_sys_auth_model()->get_sys_auth_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($auth_arr['total'], $form_data['where']['limit']);

        return $this->load->view('admin/auth/index',
            [
                'form_data' => $form_data,
                'list'      => $auth_arr['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where4_list() {
        $auth_name = $this->input->get('auth_name', true);
        $level     = $this->input->get('level', true);

        $where = [];
        if (!empty($auth_name)) {
            $where['auth_name'] = $auth_name;
        }

        if (is_numeric($level)) {
            $where['level'] = $level;
        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'auth_name' => $auth_name,
            'level'     => $level,
            'where'     => $where,
        ];
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

        $auth_list = $this->__get_sys_auth_model()->select_level0_level1_auth_list();

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/auth/add', array('auth_list' => $auth_list));
        }

        $req_data = $this->input->post();

        $data = array(
            'pid'       => $req_data['pid'],
            'auth_name' => $req_data['auth_name'],
            'class'     => $req_data['class'],
            'action'    => $req_data['action'],
            'level'     => $this->__calc_level($req_data['pid']),
        );

        $result = $this->__get_sys_auth_model()->insert($data);

        if ($result) {
            return redirect("{$this->host}/admin/auth/home");
        }

        return $this->load->view('admin/auth/add', array('auth_list' => $auth_list));
    }

    public function update() {

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

        $auth_list = $this->__get_sys_auth_model()->select_level0_level1_auth_list();

        $sys_auth_id = $this->input->get_post('id', true);

        if (empty($sys_auth_id)) {
            return redirect("{$this->host}/admin/auth/home");
        }

        $auth_info = $this->__get_sys_auth_model()->select_by_id($sys_auth_id);

        if (empty($auth_info)) {
            return redirect("{$this->host}/admin/auth/home");
        }

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/auth/update', array('auth_list' => $auth_list, 'auth_info' => $auth_info));
        }

        $req_data = $this->input->post();

        $info = array(
            'pid'       => $req_data['pid'],
            'auth_name' => $req_data['auth_name'],
            'class'     => $req_data['class'],
            'action'    => $req_data['action'],
            'level'     => $this->__calc_level($req_data['pid']),
        );

        $result = $this->__get_sys_auth_model()->update_sys_auth($sys_auth_id, $info);

        if ($result) {
            return redirect("{$this->host}/admin/auth/home");
        }

        return $this->load->view('admin/auth/update', array('auth_list' => $auth_list, 'auth_info' => $auth_info));
    }

    public function del() {

        $sys_auth_id = $this->input->get('id', true);

        if (empty($sys_auth_id)) {
            return redirect("{$this->host}/admin/auth/home");
        }

        $this->__get_sys_auth_model()->del($sys_auth_id);

        return redirect("{$this->host}/admin/auth/home");
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
