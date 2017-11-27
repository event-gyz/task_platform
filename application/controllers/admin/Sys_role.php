<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/Admin_Controller.php';

class Sys_role extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where4_list();

        $data = $this->__get_sys_role_model()->get_sys_role_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/sys_role/index',
            [
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where4_list() {
        $role_name = $this->input->get('role_name', true);

        $where = [];
        if (!empty($role_name)) {
            $where['role_name'] = $role_name;
        }


        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'role_name' => $role_name,
            'where'     => $where,
        ];
    }

    public function add() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
            array(
                'field'  => 'dept_name',
                'label'  => '部门名称',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_role/add');
        }

        $req_data = $this->input->post();

        $create_sys_user_id = 1;// todo 需要根据当前登录用户取其id

        $data = array(
            'dept_name'          => $req_data['dept_name'],
            'create_sys_user_id' => $create_sys_user_id,
        );

        $result = $this->__get_sys_role_model()->insert($data);

        if ($result) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        return $this->load->view('admin/sys_role/add');
    }

    public function update() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
            array(
                'field'  => 'dept_name',
                'label'  => '部门名称',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        $id = $this->input->get_post('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        $info = $this->__get_sys_role_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_role/update', array('info' => $info));
        }

        $req_data = $this->input->post();

        $info   = ['dept_name' => $req_data['dept_name']];
        $result = $this->__get_sys_role_model()->update_sys_role($id, $info);

        if ($result) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        return $this->load->view('admin/sys_role/update', array('info' => $info));
    }

    public function del() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        $info = $this->__get_sys_role_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        $info = ['status' => 1];
        $this->__get_sys_role_model()->update_sys_role($id, $info);

        return redirect("{$this->host}/admin/sys_role/home");
    }

    /**
     * @return Sys_role_model
     */
    private function __get_sys_role_model() {
        $this->load->model('admin/Sys_role_model');
        return $this->Sys_role_model;
    }

}
