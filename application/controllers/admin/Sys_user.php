<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require dirname(FCPATH) . '/core/Admin_Controller.php';

class Sys_user extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where4_list();

        $data = $this->__get_sys_user_model()->get_sys_user_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/sys_user/index',
            [
                'form_data' => $form_data,
                'list'      => $data['list'],
                'page_link' => $page_link,
                'dept_list' => $this->__get_sys_department_model()->select_all_dept_list(),
            ]
        );
    }

    private function __build_where4_list() {
        $user_name = $this->input->get('user_name', true);
        $dept_id   = $this->input->get('dept_id', true);
        $mobile    = $this->input->get('mobile', true);

        $where = [];
        if (!empty($user_name)) {
            $where['user_name'] = $user_name;
        }

        if (!empty($dept_id)) {
            $where['dept_id'] = $dept_id;
        }

        if (!empty($mobile)) {
            $where['mobile'] = $mobile;
        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'user_name' => $user_name,
            'dept_id'   => $dept_id,
            'mobile'    => $mobile,
            'where'     => $where,
        ];
    }

    public function add() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
            array(
                'field'  => 'user_name',
                'label'  => '用户名称',
                'rules'  => 'required|is_unique[sys_user.user_name]',
                'errors' => array(
                    'required'  => '请填写%s',
                    'is_unique' => '用户名称已经存在了，换个名字再试试吧',
                ),
            ),
            array(
                'field'  => 'nick_name',
                'label'  => '姓名',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'mobile',
                'label'  => '联系电话',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'pwd',
                'label'  => '密码',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 're_pwd',
                'label'  => '确认密码',
                'rules'  => 'required|matches[pwd]',
                'errors' => array(
                    'required' => '请填写%s',
                    'matches'  => '两次密码必须一致',
                ),
            ),
            array(
                'field'  => 'role_id',
                'label'  => '所属角色',
                'rules'  => array(
                    'required',
                    array(
                        'can_not_eq0',
                        function ($val) {
                            return $val !== "0";
                        },
                    ),
                ),
                'errors' => array(
                    'required'    => '请选择%s',
                    'can_not_eq0' => '请选择%s',
                ),
            ),
            array(
                'field'  => 'dept_id',
                'label'  => '所属部门',
                'rules'  => array(
                    'required',
                    array(
                        'can_not_eq0',
                        function ($val) {
                            return $val !== "0";
                        },
                    ),
                ),
                'errors' => array(
                    'required'    => '请选择%s',
                    'can_not_eq0' => '请选择%s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        $dept_list = $this->__get_sys_department_model()->select_all_dept_list();
        $role_list = $this->__get_sys_role_model()->select_all_role_list();

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_user/add', ['dept_list' => $dept_list, 'role_list' => $role_list]);
        }

        $req_data = $this->input->post();
        $pwd      = $req_data['pwd'];
        $salt     = $this->__get_sys_user_model()->random_str(4);

        $data = array(
            'user_name'               => $req_data['user_name'],
            'nick_name'               => $req_data['nick_name'],
            'mobile'                  => $req_data['mobile'],
            'salt'                    => $salt,
            'pwd'                     => $this->__get_sys_user_model()->generate_admin_password($pwd, $salt),
            'role_id'                 => $req_data['role_id'],
            'dept_id'                 => $req_data['dept_id'],
            'create_sys_user_id'      => $this->sys_user_info['id'],
            'last_modify_sys_user_id' => $this->sys_user_info['id'],
        );

        $result = $this->__get_sys_user_model()->insert($data);

        if ($result) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        return $this->load->view('admin/sys_user/add', ['dept_list' => $dept_list, 'role_list' => $role_list]);
    }

    public function update() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
            array(
                'field'  => 'nick_name',
                'label'  => '姓名',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'mobile',
                'label'  => '联系电话',
                'rules'  => 'required',
                'errors' => array(
                    'required' => '请填写%s',
                ),
            ),
            array(
                'field'  => 'role_id',
                'label'  => '所属角色',
                'rules'  => array(
                    'required',
                    array(
                        'can_not_eq0',
                        function ($val) {
                            return $val !== "0";
                        },
                    ),
                ),
                'errors' => array(
                    'required'    => '请选择%s',
                    'can_not_eq0' => '请选择%s',
                ),
            ),
            array(
                'field'  => 'dept_id',
                'label'  => '所属部门',
                'rules'  => array(
                    'required',
                    array(
                        'can_not_eq0',
                        function ($val) {
                            return $val !== "0";
                        },
                    ),
                ),
                'errors' => array(
                    'required'    => '请选择%s',
                    'can_not_eq0' => '请选择%s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);

        $sys_user_id = $this->input->get_post('id', true);

        if (empty($sys_user_id)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $sys_user_info = $this->__get_sys_user_model()->select_by_id($sys_user_id);

        if (empty($sys_user_info)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $dept_list = $this->__get_sys_department_model()->select_all_dept_list();
        $role_list = $this->__get_sys_role_model()->select_all_role_list();

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('admin/sys_user/update', ['dept_list' => $dept_list, 'role_list' => $role_list, 'info' => $sys_user_info]);
        }

        $req_data = $this->input->post();

        $info = array(
            'nick_name'               => $req_data['nick_name'],
            'mobile'                  => $req_data['mobile'],
            'role_id'                 => $req_data['role_id'],
            'dept_id'                 => $req_data['dept_id'],
            'last_modify_sys_user_id' => $this->sys_user_info['id'],
        );

        $result = $this->__get_sys_user_model()->update_sys_user($sys_user_id, $info);

        if ($result) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        return $this->load->view('admin/sys_user/update', ['dept_list' => $dept_list, 'role_list' => $role_list, 'info' => $sys_user_info]);
    }

    public function del() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $info = $this->__get_sys_user_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $info = ['status' => Sys_user_model::DATA_STATUS_DELETED];
        $this->__get_sys_user_model()->update_sys_user($id, $info);

        return redirect("{$this->host}/admin/sys_user/home");
    }

    public function manager_reset_pwd() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $info = $this->__get_sys_user_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $pwd  = '123456';
        $salt = $this->__get_sys_user_model()->random_str(4);
        $info = [
            'salt' => $salt,
            'pwd'  => $this->__get_sys_user_model()->generate_admin_password($pwd, $salt),
        ];

        $this->__get_sys_user_model()->update_sys_user($id, $info);

        return redirect("{$this->host}/admin/sys_user/home");
    }

    public function update_user_status() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $info = $this->__get_sys_user_model()->select_by_id($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $user_status = $this->input->get('user_status', true);

        if (!in_array($user_status, [0, 1])) {
            return redirect("{$this->host}/admin/sys_user/home");
        }

        $info = ['user_status' => $user_status];
        $this->__get_sys_user_model()->update_sys_user($id, $info);

        return redirect("{$this->host}/admin/sys_user/home");
    }

    /**
     * @return Sys_user_model
     */
    private function __get_sys_user_model() {
        $this->load->model('admin/Sys_user_model');
        return $this->Sys_user_model;
    }

    /**
     * @return Sys_department_model
     */
    private function __get_sys_department_model() {
        $this->load->model('admin/Sys_department_model');
        return $this->Sys_department_model;
    }

    /**
     * @return Sys_role_model
     */
    private function __get_sys_role_model() {
        $this->load->model('admin/Sys_role_model');
        return $this->Sys_role_model;
    }

}
