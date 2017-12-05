<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require dirname(FCPATH) . '/core/ADMIN_Controller.php';

/**
 * 自媒体人管理
 * Class Platform_media_man
 */
class Platform_media_man extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 自媒体人列表
    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_media_man_model()->get_media_man_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_media_man/index',
            [
                'form_data'            => $form_data,
                'list'                 => $data['list'],
                'page_link'            => $page_link,
                'media_audit_status'   => $this->config->item('media_audit_status'),
                'media_account_status' => $this->config->item('media_account_status'),
            ]
        );
    }

    private function __build_where_list() {
        $media_man_name  = $this->input->get('media_man_name', true);
        $school_name     = $this->input->get('school_name', true);
        $audit_status    = $this->input->get('audit_status', true);
        $create_time     = $this->input->get('create_time', true);
        $sex             = $this->input->get('sex', true);
        $media_man_phone = $this->input->get('media_man_phone', true);
        $status          = $this->input->get('status', true);
        $tag             = $this->input->get('tag', true);

        $where = [];
        if (!empty($media_man_name)) {
            $where['media_man_name'] = $media_man_name;
        }

        if (!empty($school_name)) {
            $where['school_name'] = $school_name;
        }

        if ($audit_status !== '' && $audit_status !== null) {
            $where['audit_status'] = $audit_status;
        }

        if (!empty($create_time)) {
            $time_arr            = explode(' - ', $create_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($sex)) {
            $where['sex'] = $sex;
        }

        if (!empty($media_man_phone)) {
            $where['media_man_phone'] = $media_man_phone;
        }

        if ($status !== '' && $status !== null) {
            $where['status'] = $status;
        }

        if (!empty($tag)) {
            // todo 根据媒体人标签进行搜索
            $where['tag'] = $tag;
        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'media_man_name'  => $media_man_name,
            'school_name'     => $school_name,
            'audit_status'    => $audit_status,
            'create_time'     => $create_time,
            'sex'             => $sex,
            'media_man_phone' => $media_man_phone,
            'status'          => $status,
            'tag'             => $tag,
            'where'           => $where,
        ];
    }

    public function media_man_detail() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        $where    = ['operate_data_id' => $id, 'sys_log_type' => "3,6,10", "offset" => 0, "limit" => 200];
        $log_list = $this->Sys_log_model->get_sys_log_list_by_condition($where);

        return $this->load->view('admin/platform_media_man/media_man_detail',
            [
                'info'                 => $info,
                'log_list'             => $log_list['list'],
                'media_audit_status'   => $this->config->item('media_audit_status'),
                'media_account_status' => $this->config->item('media_account_status'),
                'school_type_list'     => $this->config->item('school_type'),
                'school_level_list'    => $this->config->item('school_level'),
                'age_list'             => $this->config->item('age'),
                'hobby_list'           => $this->config->item('hobby'),
                'industry_list'        => $this->config->item('industry'),
                'wx_type_list'         => $this->config->item('wx_type'),
                'weibo_type_list'      => $this->config->item('weibo_type'),
            ]
        );
    }

    // 跳转到修改自媒体人页
    public function to_update_media_man() {

        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/platform_media_man/home");
        }

        return $this->load->view('admin/platform_media_man/update_media_man',
            [
                'info'                 => $info,
                'media_audit_status'   => $this->config->item('media_audit_status'),
                'media_account_status' => $this->config->item('media_account_status'),
                'school_type_list'     => $this->config->item('school_type'),
                'school_level_list'    => $this->config->item('school_level'),
                'age_list'             => $this->config->item('age'),
                'hobby_list'           => $this->config->item('hobby'),
                'industry_list'        => $this->config->item('industry'),
                'wx_type_list'         => $this->config->item('wx_type'),
                'weibo_type_list'      => $this->config->item('weibo_type'),
            ]
        );
    }

    // 修改自媒体人信息
    public function do_update_media_man() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id = $req_data['media_man_id'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $req_data['hobby']              = implode(',', $req_data['hobby']);
        $req_data['industry']           = implode(',', $req_data['industry']);
        $req_data['last_operator_id']   = $this->sys_user_info['id'];
        $req_data['last_operator_name'] = $this->sys_user_info['user_name'];
        $sys_log_content                = '修改了媒体人信息';

        $result = $this->__get_platform_media_man_model()->updateInfo($id, $req_data);

        if ($result === 1) {

            $this->add_sys_log(10, $sys_log_content, $id, json_encode($info), json_encode($req_data));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(0, '操作成功');
    }

    // 自媒体人的审核
    public function update_media_audit_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id                    = $req_data['id'];
        $audit_status          = $req_data['audit_status'];
        $reasons_for_rejection = $req_data['reasons_for_rejection'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($audit_status)) {
            return $this->response_json(1, 'audit_status不能为空');
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($audit_status, [1, 2])) {
            return $this->response_json(1, '非法操作');
        }

        $update_info['last_operator_id']      = $this->sys_user_info['id'];
        $update_info['last_operator_name']    = $this->sys_user_info['user_name'];
        $update_info['audit_status']          = $audit_status;
        $update_info['reasons_for_rejection'] = empty($reasons_for_rejection) ? '' : $reasons_for_rejection;
        $sys_log_content                      = '媒体人审核驳回,驳回的原因是:' . $update_info['reasons_for_rejection'];

        if ($audit_status === "1") {
            $update_info['reasons_for_rejection'] = "";
            $update_info['status']                = 2;// 当审核通过后需要将status设置为2正常
            $sys_log_content                      = '媒体人审核通过';
        }

        $result = $this->__get_platform_media_man_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(3, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    // 自媒体人的账户状态变更
    public function update_media_account_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id              = $req_data['id'];
        $account_status  = $req_data['account_status'];
        $freezing_reason = $req_data['freezing_reason'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($account_status)) {
            return $this->response_json(1, 'account_status不能为空');
        }

        $info = $this->__get_platform_media_man_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($account_status, [2, 9])) {
            return $this->response_json(1, '非法操作');
        }

        $update_info['last_operator_id']   = $this->sys_user_info['id'];
        $update_info['last_operator_name'] = $this->sys_user_info['user_name'];
        $update_info['status']             = $account_status;
        $update_info['freezing_reason']    = empty($freezing_reason) ? '' : $freezing_reason;
        $sys_log_content                   = '媒体人账户被冻结,冻结的原因是:' . $update_info['freezing_reason'];

        if ($account_status === "2") {
            $update_info['freezing_reason'] = "";
            $sys_log_content                = '媒体人账户被解冻';
        }

        $result = $this->__get_platform_media_man_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(6, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    /**
     * @return Platform_media_man_model
     */
    private function __get_platform_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }

}
