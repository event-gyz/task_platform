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
                'field'  => 'role_name',
                'label'  => '角色名称',
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

        $data = array(
            'role_name'               => $req_data['role_name'],
            'create_sys_user_id'      => $this->sys_user_info['id'],
            'last_modify_sys_user_id' => $this->sys_user_info['id'],
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
                'field'  => 'role_name',
                'label'  => '角色名称',
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

        $_auth_list = $this->__get_sys_auth_model()->select_all_auth_list();
        $auth_list  = $this->__deal_auth_list($_auth_list);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_role/update', array('info' => $info, 'auth_list_json' => json_encode($auth_list)));
        }

        $req_data = $this->input->post();

        $info   = [
            'role_name'               => $req_data['role_name'],
            'last_modify_sys_user_id' => $this->sys_user_info['id'],
        ];
        $result = $this->__get_sys_role_model()->update_sys_role($id, $info);

        if ($result) {
            return redirect("{$this->host}/admin/sys_role/home");
        }

        return $this->load->view('admin/sys_role/update', array('info' => $info, 'auth_list_json' => $auth_list));
    }

    // 处理权限列表返回前端页面需要的tree结构
    private function __deal_auth_list($auth_list) {
        $result = [];

        $key0 = 0;
        foreach ($auth_list as $level0) {

            if ($level0['level'] === '0') {

                $result[$key0]['id']       = $level0['id'];
                $result[$key0]['label']    = $level0['auth_name'];
                $result[$key0]['children'] = [];

                $key1 = 0;
                foreach ($auth_list as $level1) {

                    if (($level1['level'] === '1') && $level1['pid'] === $level0['id']) {

                        $result[$key0]['children'][$key1]['id']       = $level1['id'];
                        $result[$key0]['children'][$key1]['label']    = $level1['auth_name'];
                        $result[$key0]['children'][$key1]['children'] = [];

                        $key2 = 0;
                        foreach ($auth_list as $level2) {

                            if (($level2['level'] === '2') && $level2['pid'] === $level1['id']) {
                                $result[$key0]['children'][$key1]['children'][$key2]['id']       = $level2['id'];
                                $result[$key0]['children'][$key1]['children'][$key2]['label']    = $level2['auth_name'];
                                $result[$key0]['children'][$key1]['children'][$key2]['children'] = [];
                                $key2++;
                            }

                        }

                        $key1++;
                    }

                }

                $key0++;
            }

        }

        return $result;
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

        $info = ['status' => Sys_role_model::DATA_STATUS_DELETED];
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

    /**
     * @return Sys_auth_model
     */
    private function __get_sys_auth_model() {
        $this->load->model('admin/Sys_auth_model');
        return $this->Sys_auth_model;
    }

}
