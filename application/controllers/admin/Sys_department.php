<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

class Sys_department extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where4_list();

        $data = $this->__get_sys_department_model()->get_sys_department_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/sys_department/index',
            [
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
            ]
        );
    }

    private function __build_where4_list() {
        $dept_name = $this->input->get('dept_name', true);

        $where = [];
        if (!empty($dept_name)) {
            $where['dept_name'] = $dept_name;
        }


        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'dept_name' => $dept_name,
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
            return $this->load->view('admin/sys_department/add');
        }

        $req_data = $this->input->post();

        $data = array(
            'dept_name'          => $req_data['dept_name'],
            'create_sys_user_id' => $this->sys_user_info['id'],
            'create_by_name'     => $this->sys_user_info['user_name'],
        );

        $result = $this->__get_sys_department_model()->insert($data);

        if ($result) {
            return redirect("{$this->host}/admin/sys_department/home");
        }

        return $this->load->view('admin/sys_department/add');
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
            return redirect("{$this->host}/admin/sys_department/home");
        }

        $info = $this->__get_sys_department_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_department/home");
        }

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_department/update', array('info' => $info));
        }

        $req_data = $this->input->post();

        $info   = ['dept_name' => $req_data['dept_name']];
        $result = $this->__get_sys_department_model()->update_sys_department($id, $info);

        if ($result) {
            return redirect("{$this->host}/admin/sys_department/home");
        }

        return $this->load->view('admin/sys_department/update', array('info' => $info));
    }

    public function del() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_department/home");
        }

        $info = $this->__get_sys_department_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_department/home");
        }

        $info = ['status' => Sys_department_model::DATA_STATUS_DELETED];
        $this->__get_sys_department_model()->update_sys_department($id, $info);

        return redirect("{$this->host}/admin/sys_department/home");
    }

    /**
     * @return Sys_department_model
     */
    private function __get_sys_department_model() {
        $this->load->model('admin/Sys_department_model');
        return $this->Sys_department_model;
    }

}
