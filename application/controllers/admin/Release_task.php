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

        $where    = ['operate_data_id' => $id, 'sys_log_type' => "4,8,9,11,12", "offset" => 0, "limit" => 200];
        $log_list = $this->Sys_log_model->get_sys_log_list_by_condition($where);

        $where1    = ['operate_data_id' => $id, 'user_log_type' => "3,4,5,6,7,9", "offset" => 0, "limit" => 200];
        $log_list1 = $this->__get_user_log_model()->get_user_log_list_by_condition($where1);

        $log_list2 = array_merge($log_list['list'], $log_list1['list']);
        uasort($log_list2, function ($value1, $value2) {
            if (strtotime($value1['create_time']) == strtotime($value2['create_time'])) {
                return 0;
            }
            return (strtotime($value1['create_time']) < strtotime($value2['create_time'])) ? 1 : -1;
        });

        return $this->load->view('admin/release_task/task_detail',
            [
                'info'                     => $info,
                'log_list'                 => $log_list2,
                'publishing_platform_list' => $this->config->item('publishing_platform'),
                'task_type_list'           => $this->config->item('task_type'),
                'task_audit_status'        => $this->config->item('task_audit_status'),
                'task_completion_criteria' => $this->config->item('task_completion_criteria'),
            ]
        );
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

        $update_info['platform_price'] = $platform_price;
        $update_info['release_status'] = 1;// 设定任务发布状态为已发布
        $sys_log_content               = '修改任务价格为:' . $platform_price;

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(8, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
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

        $update_info['release_status'] = $release_status;
        $update_info['close_reason']   = empty($close_reason) ? '' : $close_reason;
        $sys_log_content               = '任务发布状态被更新';

        if ($release_status === "8") {
            $sys_log_content = '任务被手工作废';
        }

        $result = $this->__get_platform_task_model()->updateInfo($id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(9, $sys_log_content, $id, json_encode($info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
    }

    // 审核自媒体人交付的任务
    public function update_deliver_audit_status() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $id                   = $req_data['id'];
        $deliver_audit_status = $req_data['deliver_audit_status'];
        $task_map_id          = $req_data['task_map_id'];

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
        $sys_log_content                     = "自媒体人{$task_map_info['media_man_user_name']}-{$task_map_info['media_man_user_id']}提交的任务交付,被审核通过了";

        if ($deliver_audit_status === "2") {
            $sys_log_content = "自媒体人{$task_map_info['media_man_user_name']}-{$task_map_info['media_man_user_id']}提交的任务交付,被审核驳回了";
        }

        $result = $this->__get_platform_task_map_model()->updateInfo($task_map_id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(12, $sys_log_content, $id, json_encode($task_map_info), json_encode($update_info));

            return $this->response_json(0, '操作成功');
        }

        return $this->response_json(1, '非法操作');
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
        $this->__create_image_zip($task_map_id, $image_file_zip_path);
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
        $info          = $this->__get_platform_task_model()->selectById($task_id);
        $task_map_list = $this->__get_platform_task_map_model()->get_task_map_list_by_task_id($task_id);

        $sub_file_name = "{$info['task_name']}-{$task_id}";

        // 生成excel文件
        $csv_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}.csv";
        $this->_export_csv4task_map($task_map_list, $csv_file_path);

        // 根据单个任务生成图片压缩包
        // $image_file_zip_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}-images.zip";
        // $this->__create_image_zip($task_map_id, $image_file_zip_path);

        // 打包excel文件和图片压缩包到一个文件
        // $this->zip->clear_data();// 清除压缩包缓存,防止打包会产生多余文件
        $this->load->library('zip');
        $this->zip->read_file($csv_file_path);
        // $this->zip->read_file($image_file_zip_path);
        $this->zip->archive($zip_file_path);
        wap::write_file_complete_flag($zip_file_path);
    }

    // 根据task_id和task_map_id来生成图片和excel压缩包
    private function __prepare_images_zip_and_excel_by_map_id($task_id, $task_map_id, $zip_file_path) {
        $info          = $this->__get_platform_task_model()->selectById($task_id);
        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);

        $sub_file_name = "{$info['task_name']}-{$task_id}-{$task_map_info['media_man_user_name']}-{$task_map_id}";

        // 生成excel文件
        $csv_file_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}.csv";
        $this->_export_csv4task_map([$task_map_info], $csv_file_path);

        // 生成图片压缩包
        $image_file_zip_path = FCPATH . "/zip/{$info['task_name']}-{$task_id}/" . "{$sub_file_name}-images.zip";
        $this->__create_image_zip($task_map_id, $image_file_zip_path);

        // 打包excel文件和图片压缩包到一个文件
        $this->zip->clear_data();// 清除压缩包缓存,防止打包会产生多余文件
        $this->zip->read_file($csv_file_path);
        $this->zip->read_file($image_file_zip_path);
        $this->zip->archive($zip_file_path);
        wap::write_file_complete_flag($zip_file_path);

    }

    // 创建单个任务交付记录的图片压缩包
    private function __create_image_zip($task_map_id, $image_file_zip_path) {
        set_time_limit(0);
        wap::create_folders(dirname($image_file_zip_path));

        $task_map_info = $this->__get_platform_task_map_model()->selectById($task_map_id);
        $image_arr     = json_decode($task_map_info['deliver_images'], true);

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
        wap::write_file_complete_flag($image_file_zip_path);

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

}
