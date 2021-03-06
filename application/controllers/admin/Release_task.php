<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 发布管理
 * Class Release_task
 */
class Release_task extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 任务列表
    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_model()->get_task_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/release_task/index',
            [
                'form_data'                => $form_data,
                'list'                     => $data['list'],
                'page_link'                => $page_link,
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'release_task_status'      => $this->config->item('release_task_status'),
            ]
        );
    }

    private function __build_where_list() {
        $task_name           = $this->input->get('task_name', true);
        $publishing_platform = $this->input->get('publishing_platform', true);
        $task_type           = $this->input->get('task_type', true);
        $submit_audit_time   = $this->input->get('submit_audit_time', true);
        $task_status         = $this->input->get('task_status', true);

        $where = [];
        if (!empty($task_name)) {
            $where['task_name'] = $task_name;
        }

        if (!empty($publishing_platform)) {
            $where['publishing_platform'] = $publishing_platform;
        }

        if ($task_type !== '' && $task_type !== null) {
            $where['task_type'] = $task_type;
        }

        if (!empty($submit_audit_time)) {
            $time_arr            = explode(' - ', $submit_audit_time);
            $where['start_time'] = date('Y-m-d H:i:s', strtotime($time_arr[0]));
            $where['end_time']   = date('Y-m-d H:i:s', strtotime($time_arr[1] . "+1 day -1 seconds"));
        }

        if (!empty($task_status)) {

            // '1' => '待发布',---> release_status = 0
            // '2' => '执行中',---> release_status = 1
            // '3' => '待确认完成',---> release_status = 1
            // '4' => '已关闭',---> release_status = 8|9

            switch ($task_status) {
                case 1:
                    $where['release_status'] = 0;
                    break;
                case 2:
                    // 在任务发布后，结束时间到达前(即搜索当前时间小于platform_task.end_time的记录)，状态均为执行中
                    $where['release_status'] = 1;
                    $where['task_status']    = 'execute';
                    $where['cur_time_stamp'] = time();
                    break;
                case 3:
                    // 当任务结束时间到达后，(即搜索当前时间大于platform_task.end_time的记录)，则状态变更为待确认完成
                    $where['release_status'] = 1;
                    $where['task_status']    = 'to_be_confirm';
                    $where['cur_time_stamp'] = time();
                    break;
                case 4:
                    $where['release_status'] = [8, 9];
                    break;
                default:
            }

        }

        // 财务已确认收款
        $where['pay_status']     = 1;
        $where['audit_status']   = 3;
        $where['finance_status'] = 1;

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'task_name'           => $task_name,
            'publishing_platform' => $publishing_platform,
            'task_type'           => $task_type,
            'submit_audit_time'   => $submit_audit_time,
            'task_status'         => $task_status,
            'where'               => $where,
        ];
    }

    // 任务详情
    public function task_detail() {
        $id = $this->input->get('id', true);

        if (empty($id)) {
            return redirect("{$this->host}/admin/release_task/home");
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return redirect("{$this->host}/admin/release_task/home");
        }

        return $this->load->view('admin/release_task/task_detail',
            [
                'info'                     => $info,
                'log_list'                 => json_encode($this->__get_log_list($id)),
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'task_audit_status'        => $this->config->item('task_audit_status'),
                'task_completion_criteria' => $this->config->item('task_completion_criteria'),
            ]
        );
    }

    private function __get_log_list($task_id) {
        if (empty($task_id)) {
            return [];
        }

        // 系统操作日志
        $where    = ['operate_data_id' => $task_id, 'sys_log_type' => "4,8,9,11,12,13,14", "offset" => 0, "limit" => 500];
        $log_list = $this->Sys_log_model->get_sys_log_list_by_condition($where);

        // 用户操作日志
        $where1    = ['operate_data_id' => $task_id, 'user_log_type' => "3,4,5,6,7,9,10,12,13", "offset" => 0, "limit" => 500];
        $log_list1 = $this->__get_user_log_model()->get_user_log_list_by_condition($where1);

        // 合并日志
        $log_list2 = array_merge($log_list['list'], $log_list1['list']);
        uasort($log_list2, function ($value1, $value2) {
            if (strtotime($value1['create_time']) == strtotime($value2['create_time'])) {
                return 0;
            }
            return (strtotime($value1['create_time']) < strtotime($value2['create_time'])) ? 1 : -1;
        });

        $result = [];
        foreach ($log_list2 as $value) {

            $name = '';
            if (isset($value['sys_user_name'])) {
                $name = $value['sys_user_name'];
            }
            if (isset($value['user_name'])) {
                $name = $value['user_name'];
            }

            $content = '';
            if (isset($value['sys_log_content'])) {
                $content = $value['sys_log_content'];
            }
            if (isset($value['user_log_content'])) {
                $content = $value['user_log_content'];
            }

            $result[] = [
                'id'          => $value['id'],
                'name'        => $name,
                'create_time' => $value['create_time'],
                'content'     => $content,
            ];
        }

        return $result;
    }

    // 确认完成
    public function confirm_finish() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id = $req_data['id'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $update_info['release_status'] = 2;// 设定任务发布状态为已完成
        $sys_log_content               = '任务设置为已完成';

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(11, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    // 发布任务
    public function release_task() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id             = $req_data['id'];
        $platform_price = $req_data['platform_price'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (!is_numeric($platform_price)) {
            return $this->response_json(1, '请输入有效的价格');
        }

        if ($platform_price <= 0) {
            return $this->response_json(1, '任务单价只能是正数');
        }

        $tmp_num_arr = explode('.', $platform_price);
        if (isset($tmp_num_arr[1]) && strlen($tmp_num_arr[1]) > 1) {
            return $this->response_json(1, '仅支持小数点后一位');
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $this->db->trans_begin();

        $actual_media_man_number = $this->__sys_auto_release($info);
        // todo 需要确认实际发布数量为0时是否还需要发布

        $update_info['actual_media_man_number'] = $actual_media_man_number;
        $update_info['platform_price']          = $platform_price;
        $update_info['release_status']          = 1;// 设定任务发布状态为已发布
        $sys_log_content                        = sprintf($this->lang->line('admin_release_task4_sys'), "{$this->sys_user_info['user_name']}", $platform_price);
        $message_content                        = sprintf($this->lang->line('admin_release_task4_user'), $info['task_name']);

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(8, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            $this->add_user_message($info['advertiser_user_id'], 1, 2, $message_content, $info['task_id']);

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response_json(1, '操作失败,请稍候再试');
        }

        $this->db->trans_commit();

        return $this->response_json(0, '操作成功');

    }

    // 系统自动发布规则
    private function __sys_auto_release($task_info) {

        $media_man_number = $task_info['media_man_number'];// 广告主要求的自媒体人数量

        // media_man_require 自媒体人帐号要求 1有 2无
        if ($task_info['media_man_require'] === '2') {
            // 发送给全量的自媒体帐号
            $data0 = $this->__get_platform_media_man_model()->get_media_man_list_by_task_require([]);
            $this->__get_platform_task_map_model()->do_sys_auto_release($task_info['task_id'], $data0['list']);
            return $data0['total'];
        }

        // 根据自媒体人帐号要求计算符合条件的自媒体人帐号

        // 根据发布任务时的账号要求捞取符合条件的自媒体人账号，只要满足账号要求中的一条即视为符合条件的账号。

        $where = [];

        // require_sex 性别要求
        if (!empty($task_info['require_sex'])) {
            $where['require_sex'] = $task_info['require_sex'];
        }

        // require_age 自媒体人年龄要求
        if (!empty($task_info['require_age'])) {
            $where['require_age'] = $task_info['require_age'];
        }

        // require_local 自媒体人地域要求
        if (!empty($task_info['require_local'])) {
            $where['require_local'] = $task_info['require_local'];
        }

        // require_industry 行业要求
        if (!empty($task_info['require_industry'])) {
            $where['require_industry'] = $task_info['require_industry'];
        }

        // require_hobby 自媒体人爱好要求
        if (!empty($task_info['require_hobby'])) {
            $where['require_hobby'] = $task_info['require_hobby'];
        }

        $data = $this->__get_platform_media_man_model()->get_media_man_list_by_task_require($where);

        $actual_media_man_number = $data['total'];

        if ($actual_media_man_number < $media_man_number) {

            if ($actual_media_man_number <= ($media_man_number * 0.5)) {
                // 当捞取的自媒体账号数小于等于账号数量的50%时，则视同平台无法满足账号要求，给全部自媒体账号发送此条任务信息。
                // 发送给全量的自媒体帐号
                $data0 = $this->__get_platform_media_man_model()->get_media_man_list_by_task_require([]);
                $this->__get_platform_task_map_model()->do_sys_auto_release($task_info['task_id'], $data0['list']);
                return $data0['total'];
            }

            // 发送给符合条件的自媒体人帐号,虽然不完全满足数量的要求
            $this->__get_platform_task_map_model()->do_sys_auto_release($task_info['task_id'], $data['list']);
            return $actual_media_man_number;

        }

        if ($actual_media_man_number >= $media_man_number) {

            // 当捞取的自媒体账号超过发布任务时的账号数量时，
            // 则根据发布的平台将自媒体人对应平台的粉丝数倒序，将此任务发给粉丝数多的自媒体账号，
            // 如发送的平台是微博+微信平台，则将两个平台粉丝数相加后的结果倒序。
            // 如遇到粉丝数相同的情况，则发给注册时间较早的账号。

            // publishing_platform 发布平台 1,微信 2,微博 1,2,微信微博
            if (!empty($task_info['publishing_platform'])) {

                if ($task_info['publishing_platform'] === '1') {
                    $where['order_by'] = 'wx_max_fans';
                }

                if ($task_info['publishing_platform'] === '2') {
                    $where['order_by'] = 'weibo_max_fans';
                }

                if ($task_info['publishing_platform'] === '1,2') {
                    $where['order_by'] = 'wx_or_weibo_max_fans';
                }

                $where['offset'] = 0;
                $where['limit']  = $media_man_number;

            }

            $data2 = $this->__get_platform_media_man_model()->get_media_man_list_by_task_require($where);
            $this->__get_platform_task_map_model()->do_sys_auto_release($task_info['task_id'], $data2['list']);
            return $media_man_number;

        }

    }

    // 根据task_id分页查询自媒体人
    public function view_self_media_man() {
        $id     = $this->input->get('id');
        $_page  = $this->input->get('page');
        $_limit = $this->input->get('limit');

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        $page             = empty($_page) ? 1 : $_page;
        $limit            = empty($_limit) ? 10 : $_limit;
        $where['offset']  = ($page - 1) * $limit;
        $where['limit']   = $limit;
        $where['task_id'] = $id;

        $data = $this->__get_platform_task_map_model()->get_task_map_list_by_condition($where);

        return $this->response_json(0, '操作成功', [
            'list'  => $data['list'],
            'total' => intval($data['total']),
            'page'  => intval($page),
            'limit' => intval($limit),
        ]);
    }

    // 手工作废任务
    public function update_task_release_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id             = $req_data['id'];
        $release_status = $req_data['release_status'];
        $close_reason   = $req_data['close_reason'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($release_status)) {
            return $this->response_json(1, 'release_status不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        if (!in_array($release_status, [8])) {
            return $this->response_json(1, '非法操作');
        }

        $this->db->trans_begin();

        $update_info['release_status'] = $release_status;
        $update_info['close_reason']   = empty($close_reason) ? '' : $close_reason;
        $update_info['close_time']     = date('Y-m-d H:i:s');
        $sys_log_content               = sprintf($this->lang->line('admin_zuo_fei_task4_sys'), "{$this->sys_user_info['user_name']}", $update_info['close_reason']);
        $message_content               = sprintf($this->lang->line('admin_zuo_fei_task4_user'), $info['task_name'], $update_info['close_reason']);

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(9, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            $this->add_user_message($info['advertiser_user_id'], 1, 2, $message_content, $info['task_id']);

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response_json(1, '操作失败,请稍候再试');
        }

        $this->db->trans_commit();

        return $this->response_json(0, '操作成功');

    }

    // 审核自媒体人交付的任务
    public function update_deliver_audit_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id                    = $req_data['id'];
        $deliver_audit_status  = $req_data['deliver_audit_status'];
        $task_map_id           = $req_data['task_map_id'];
        $reasons_for_rejection = $req_data['reasons_for_rejection'];

        if (empty($id)) {
            return $this->response_json(1, 'id不能为空');
        }

        if (empty($deliver_audit_status)) {
            return $this->response_json(1, 'deliver_audit_status不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应任务的信息');
        }

        if (!in_array($deliver_audit_status, [1, 2])) {
            return $this->response_json(1, '非法操作');
        }

        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);

        if (empty($task_map_info)) {
            return $this->response_json(1, '查找不到对应的自媒体人提交的任务交付信息');
        }

        $update_info['deliver_audit_status'] = $deliver_audit_status;
        $sys_log_content                     = sprintf($this->lang->line('media_submit_task_audit_pass4_sys'), "{$task_map_info['media_man_user_name']}-{$task_map_info['media_man_user_id']}");
        $message_content                     = sprintf($this->lang->line('media_submit_task_audit_pass4_user'), $info['task_name']);

        if ($deliver_audit_status === "2") {
            $update_info['reasons_for_rejection'] = $reasons_for_rejection;
            $sys_log_content                      = sprintf($this->lang->line('media_submit_task_audit_reject4_sys'), "{$task_map_info['media_man_user_name']}-{$task_map_info['media_man_user_id']}");
            $message_content                      = sprintf($this->lang->line('media_submit_task_audit_reject4_user'), $info['task_name'], $reasons_for_rejection);
        }

        $this->db->trans_begin();

        if ($deliver_audit_status === "1") {
            // 自媒体人交付的任务审核通过后,需要向platform_task_receivables表中插入数据
            $this->__get_platform_task_receivables_model()->insert(['task_map_id' => $task_map_id]);
        }

        $result = $this->__get_platform_task_map_model()->updateInfo($task_map_id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(12, $sys_log_content, $id, json_encode($task_map_info), json_encode($update_info));

            $this->add_user_message($task_map_info['media_man_user_id'], 2, 2, $message_content, $task_map_info['task_id']);

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response_json(1, '操作失败,请稍候再试');
        }

        $this->db->trans_commit();

        return $this->response_json(0, '操作成功');
    }

    // 检测文件是否写入完毕
    public function is_file_write_completed() {
        $file_path = $this->input->get('file_path');

        $result = wap::read_file_complete_flag(FCPATH . $file_path);

        if ($result) {
            return $this->response_json(0, '文件生成完毕');
        }

        return $this->response_json(1, '文件正在生成中...请稍候');
    }

    // 根据task_id和task_map_id来生成图片压缩包
    public function prepare_images_zip_by_map_id() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $task_id     = $req_data['task_id'];
        $task_map_id = $req_data['task_map_id'];

        if (empty($task_id)) {
            return $this->response_json(1, 'task_id不能为空');
        }

        if (empty($task_map_id)) {
            return $this->response_json(1, 'task_map_id不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($task_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应任务的信息');
        }

        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);

        if (empty($task_map_info)) {
            return $this->response_json(1, '查找不到对应的自媒体人提交的任务交付信息');
        }

        if (empty($task_map_info['deliver_images'])) {
            return $this->response_json(1, '对应的自媒体人提交的任务交付信息里不含图片');
        }

        $image_arr = json_decode($task_map_info['deliver_images'], true);
        if (empty($image_arr)) {
            return $this->response_json(1, '对应的自媒体人提交的任务交付信息里不含图片');
        }

        $sub_file_name = "{$info['task_name']}-{$task_id}-{$task_map_info['media_man_user_name']}-{$task_map_id}";
        $zip_file_name = "{$sub_file_name}-images.zip";

        header("Content-type:application/json;;charset=utf-8");
        $result = array(
            'error_no' => 0,
            'msg'      => '操作成功',
            'data'     => ['file_path' => "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name],
        );
        echo json_encode($result);

        fastcgi_finish_request();
        // 异步调用
        $image_file_zip_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name;
        $this->__create_image_zip($task_map_info, $image_file_zip_path);
    }

    // 下载单个交付任务的完成结果
    public function prepare_download_finish_result() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $task_id     = $req_data['task_id'];
        $task_map_id = $req_data['task_map_id'];

        if (empty($task_id)) {
            return $this->response_json(1, 'task_id不能为空');
        }

        if (empty($task_map_id)) {
            return $this->response_json(1, 'task_map_id不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($task_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应任务的信息');
        }

        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);

        if (empty($task_map_info)) {
            return $this->response_json(1, '查找不到对应的自媒体人提交的任务交付信息');
        }

        $sub_file_name = "{$info['task_name']}-{$task_id}-{$task_map_info['media_man_user_name']}-{$task_map_id}";
        $zip_file_name = "{$sub_file_name}.zip";

        header("Content-type:application/json;;charset=utf-8");
        $result = array(
            'error_no' => 0,
            'msg'      => '操作成功',
            'data'     => ['file_path' => "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name],
        );
        echo json_encode($result);

        fastcgi_finish_request();
        // 异步调用
        $zip_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name;
        $this->__prepare_images_zip_and_excel_by_map_id($task_id, $task_map_id, $zip_file_path);
    }

    // 下载全部交付任务的完成结果
    public function prepare_download_all_by_task_id() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $task_id = $req_data['task_id'];

        if (empty($task_id)) {
            return $this->response_json(1, 'task_id不能为空');
        }

        $info = $this->__get_platform_task_model()->selectById($task_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应任务的信息');
        }

        $sub_file_name = "{$info['task_name']}-{$task_id}";
        $zip_file_name = "{$sub_file_name}.zip";

        header("Content-type:application/json;;charset=utf-8");
        $result = array(
            'error_no' => 0,
            'msg'      => '操作成功',
            'data'     => ['file_path' => "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name],
        );
        echo json_encode($result);

        fastcgi_finish_request();
        // 异步调用
        $zip_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . $zip_file_name;
        $this->__prepare_download_all_by_task_id($task_id, $zip_file_path);
    }

    // 根据task_id来生成图片和excel压缩包
    private function __prepare_download_all_by_task_id($task_id, $zip_file_path) {
        set_time_limit(0);
        $info          = $this->__get_platform_task_model()->selectById($task_id);
        $task_map_list = $this->__get_platform_task_map_model()->get_task_map_list_by_task_id($task_id);

        $sub_file_name = "{$info['task_name']}-{$task_id}";

        // 生成excel文件
        $csv_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}.csv";
        $this->_export_csv4task_map($task_map_list, $csv_file_path);

        // 根据单个任务生成图片压缩包
        $image_file_zip_path_arr = [];
        foreach ($task_map_list as $task_map_info) {
            $image_arr = json_decode($task_map_info['deliver_images'], true);
            if (empty($image_arr)) {
                continue;
            }

            $task_map_id         = $task_map_info['task_map_id'];
            $image_sub_file_name = "{$info['task_name']}-{$task_id}-{$task_map_info['media_man_user_name']}-{$task_map_id}";
            $image_file_zip_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$image_sub_file_name}-images.zip";
            $this->__create_image_zip4download_all($task_map_info, $image_file_zip_path);
            $image_file_zip_path_arr[] = $image_file_zip_path;
        }

        foreach ($image_file_zip_path_arr as $v) {
            $this->zip->read_file($v);
        }

        // 打包excel文件和图片压缩包到一个文件
        $this->zip->read_file($csv_file_path);
        $this->zip->archive($zip_file_path);
        wap::write_file_complete_flag($zip_file_path);
    }

    // 根据task_id和task_map_id来生成图片和excel压缩包
    private function __prepare_images_zip_and_excel_by_map_id($task_id, $task_map_id, $zip_file_path) {
        set_time_limit(0);
        $info          = $this->__get_platform_task_model()->selectById($task_id);
        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);

        $sub_file_name = "{$info['task_name']}-{$task_id}-{$task_map_info['media_man_user_name']}-{$task_map_id}";

        // 生成excel文件
        $csv_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}.csv";
        $this->_export_csv4task_map([$task_map_info], $csv_file_path);

        // 生成图片压缩包
        $image_file_zip_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}-images.zip";
        $this->__create_image_zip($task_map_info, $image_file_zip_path);

        // 打包excel文件和图片压缩包到一个文件
        $this->zip->read_file($csv_file_path);
        $this->zip->read_file($image_file_zip_path);
        $this->zip->archive($zip_file_path);
        wap::write_file_complete_flag($zip_file_path);

    }

    // 创建单个任务交付记录的图片压缩包
    private function __create_image_zip($task_map_info, $image_file_zip_path) {
        set_time_limit(0);
        wap::create_folders(dirname($image_file_zip_path));

        $image_arr = json_decode($task_map_info['deliver_images'], true);

        $this->load->library('zip');

        $data = [];
        foreach ($image_arr as $image) {
            $image_file_path = FCPATH . $image;
            if (is_file($image_file_path)) {
                $image_file_key        = basename($image_file_path);
                $data[$image_file_key] = file_get_contents($image_file_path);
            }
        }

        if (empty($data)) {
            $this->zip->add_data('没有图片.txt', '本文件夹中没有任务图片');
        }

        $this->zip->add_data($data);
        $this->zip->archive($image_file_zip_path);
        $this->zip->clear_data();// 清除压缩包缓存,防止其他打包操作会产生多余文件
        wap::write_file_complete_flag($image_file_zip_path);

    }

    private function __create_image_zip4download_all($task_map_info, $image_file_zip_path) {
        set_time_limit(0);
        wap::create_folders(dirname($image_file_zip_path));

        $image_arr = json_decode($task_map_info['deliver_images'], true);

        $this->load->library('zip');

        $data = [];
        foreach ($image_arr as $image) {
            $image_file_path = FCPATH . $image;
            if (is_file($image_file_path)) {
                $image_file_key        = basename($image_file_path);
                $data[$image_file_key] = file_get_contents($image_file_path);
            }
        }

        if (empty($data)) {
            $this->zip->add_data('没有图片.txt', '本文件夹中没有任务图片');
        }

        $this->zip->add_data($data);
        $this->zip->archive($image_file_zip_path);
        $this->zip->clear_data();// 清除压缩包缓存,防止其他打包操作会产生多余文件

    }

    // 导出任务交付记录到CSV文件
    private function _export_csv4task_map($data, $csv_file_path) {
        set_time_limit(0);
        wap::create_folders(dirname($csv_file_path));

        // 导出CSV
        $title_arr = [
            '序号', '用户名', '状态', '发送时间', '领取/拒绝时间', '完成时间', '链接',
        ];
        $str       = implode(",", $title_arr);
        $str       = $str . PHP_EOL;
        $str       = iconv('utf-8', "gb2312//IGNORE", $str);// '一'bug 必须带上//IGNORE
        file_put_contents($csv_file_path, $str);

        foreach ($data as $k => $v) {

            $task_map_id         = $v['task_map_id'];
            $media_man_user_name = $v['media_man_user_name'];
            $status              = $v['status'];
            $create_time         = $v['create_time'];
            $receive_time        = $v['receive_time'];
            $deliver_time        = $v['deliver_time'];
            $deliver_link        = $v['deliver_link'];

            $value_arr = [
                $task_map_id, $media_man_user_name, $status, $create_time,
                $receive_time, $deliver_time, $deliver_link,
            ];

            $value = implode(",", $value_arr);
            $value = $value . PHP_EOL;
            $value = iconv('utf-8', "gb2312//IGNORE", $value);// '一'bug 必须带上//IGNORE
            file_put_contents($csv_file_path, $value, FILE_APPEND);

        }

    }

    /**
     * @return Platform_media_man_model
     */
    private function __get_platform_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }

    /**
     * @return Platform_task_model
     */
    private function __get_platform_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }

    /**
     * @return User_log_model
     */
    private function __get_user_log_model() {
        $this->load->model('User_log_model');
        return $this->User_log_model;
    }

    /**
     * @return Platform_task_map_model
     */
    private function __get_platform_task_map_model() {
        $this->load->model('Platform_task_map_model');
        return $this->Platform_task_map_model;
    }

    /**
     * @return Platform_task_receivables_model
     */
    private function __get_platform_task_receivables_model() {
        $this->load->model('Platform_task_receivables_model');
        return $this->Platform_task_receivables_model;
    }

}
