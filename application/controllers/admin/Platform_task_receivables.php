<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../core/ADMIN_Controller.php';

/**
 * 自媒体人任务收款表
 * Class Platform_task_receivables
 */
class Platform_task_receivables extends ADMIN_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function home() {

        $form_data = $this->__build_where_list();

        $data = $this->__get_platform_task_receivables_model()->get_task_receivables_list_by_condition($form_data['where']);

        $page_link = $this->get_page_link($data['total'], $form_data['where']['limit']);

        return $this->load->view('admin/platform_task_receivables/index',
            [
                'form_data'             => $form_data,
                'list'                  => $data['list'],
                'page_link'             => $page_link,
                'finance_status_list'   => $this->config->item('media_man_list_finance_status'),
                'platform_pay_way_list' => $this->config->item('media_man_list_platform_pay_way'),
            ]
        );
    }

    private function __build_where_list() {
        $media_man_login_name = $this->input->get('media_man_login_name', true);
        $school_name          = $this->input->get('school_name', true);
        $zfb_nu               = $this->input->get('zfb_nu', true);
        $m_finance_status     = $this->input->get('m_finance_status', true);

        $where = [];
        if (!empty($media_man_login_name)) {
            $where['media_man_login_name'] = $media_man_login_name;
        }

        if (!empty($school_name)) {
            $where['school_name'] = $school_name;
        }

        if (!empty($zfb_nu)) {
            $where['zfb_nu'] = $zfb_nu;
        }

        if (!empty($m_finance_status)) {

            // '1' => '待付款',---> 财务待付款 finance_status = 0
            // '2' => '待确认收款',---> 自媒体人待确认收款 finance_status = 1 & receivables_status = 0
            // '3' => '已完成',---> 财务确认付款,自媒体人确认收款 finance_status = 1 & receivables_status = 1

            switch ($m_finance_status) {
                case 1:
                    $where['finance_status'] = 0;
                    break;
                case 2:
                    $where['finance_status']     = 1;
                    $where['receivables_status'] = 0;
                    break;
                case 3:
                    $where['finance_status']     = 1;
                    $where['receivables_status'] = 1;
                    break;
                default:
            }

        }

        $page_arr = $this->get_list_limit_and_offset_params();
        $where    = array_merge($page_arr, $where);

        return [
            'media_man_login_name' => $media_man_login_name,
            'school_name'          => $school_name,
            'zfb_nu'               => $zfb_nu,
            'm_finance_status'     => $m_finance_status,
            'where'                => $where,
        ];
    }

    public function confirm_pay_money() {
        $req_json = file_get_contents("php://input");
        $req_data = json_decode($req_json, true);

        $receivables_id = $req_data['receivables_id'];

        if (empty($receivables_id)) {
            return $this->response_json(1, 'receivables_id不能为空');
        }

        $info = $this->__get_platform_task_receivables_model()->selectById($receivables_id);

        if (empty($info)) {
            return $this->response_json(1, '查找不到对应的信息');
        }

        $task_map_info = $this->__get_platform_task_map_model()->selectById($info['task_map_id']);

        if (empty($task_map_info)) {
            return $this->response_json(1, '查找不到对应的自媒体人提交的任务交付信息');
        }

        $task_info = $this->__get_platform_task_model()->selectById($task_map_info['task_id']);

        if (empty($task_info)) {
            return $this->response_json(1, '查找不到对应任务的信息');
        }

        $this->db->trans_begin();

        $update_info['finance_status']     = 1;// 设定自媒体人结账记录为财务已确认付款
        $update_info['platform_pay_money'] = $task_info['platform_price'];
        $update_info['confirming_person']  = $this->sys_user_info['id'];
        $sys_log_content                   = sprintf(
            $this->lang->line('finance_confirm_pay_money4_sys'),
            "{$this->sys_user_info['user_name']}",
            $task_map_info['media_man_user_name']
        );
        $message_content                   = sprintf($this->lang->line('finance_confirm_pay_money4_user'), $task_info['task_name']);

        $result = $this->__get_platform_task_receivables_model()->updateInfo($receivables_id, $update_info);

        if ($result === 1) {

            $this->add_sys_log(13, $sys_log_content, $receivables_id, json_encode($info), json_encode($update_info));

            $this->add_user_message($task_map_info['media_man_user_id'], 2, 2, $message_content, $task_map_info['task_id']);

        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response_json(1, '操作失败,请稍候再试');
        }

        $this->db->trans_commit();

        return $this->response_json(0, '操作成功');

    }

    public function prepare_export_receivables() {

        $sub_file_name = "自媒体人结账列表-" . date('YmdHis') . ".csv";

        header("Content-type:application/json;;charset=utf-8");
        $result = array(
            'error_no' => 0,
            'msg'      => '操作成功',
            'data'     => ['file_path' => "/excel/" . date('Ymd') . "/{$sub_file_name}"],
        );
        echo json_encode($result);

        fastcgi_finish_request();
        // 异步调用
        $csv_file_path = FCPATH . "/excel/" . date('Ymd') . "/{$sub_file_name}";
        $this->__prepare_excel($csv_file_path);
    }

    private function __prepare_excel($csv_file_path) {
        set_time_limit(0);
        $list = $this->__get_platform_task_receivables_model()->get_all_task_receivables_list();
        // 生成excel文件
        $this->_export_csv($list, $csv_file_path);
    }

    // 导出自媒体人结账记录到CSV文件
    private function _export_csv($data, $csv_file_path) {
        set_time_limit(0);
        wap::create_folders(dirname($csv_file_path));

        // 导出CSV
        $title_arr = [
            '任务ID', '任务名称', '用户ID', '用户名', '姓名', '性别', '电话',
            '学校名称', '支付宝', '真实姓名', '支付方式', '付款金额', '财务状态', '财务确认时间',
        ];
        $str       = implode(",", $title_arr);
        $str       = $str . PHP_EOL;
        $str       = iconv('utf-8', "gb2312//IGNORE", $str);// '一'bug 必须带上//IGNORE
        file_put_contents($csv_file_path, $str);

        $platform_pay_way_list = $this->config->item('media_man_list_platform_pay_way');

        foreach ($data as $k => $v) {

            $task_id              = 'RW' . $v['task_id'];
            $task_name            = $v['task_name'];
            $media_man_id         = 'KPS' . $v['media_man_id'];
            $media_man_login_name = $v['media_man_login_name'];
            $media_man_name       = $v['media_man_name'];
            $sex                  = $v['sex'] === "1" ? "男" : "女";
            $media_man_phone      = $v['media_man_phone'];
            $school_name          = $v['school_name'];
            $zfb_nu               = $v['zfb_nu'];
            $zfb_realname         = $v['zfb_realname'];
            $platform_pay_way     = $platform_pay_way_list[$v['platform_pay_way']];
            $platform_pay_money   = $v['platform_pay_money'];

            $finance_status = '未知';
            if (($v['finance_status'] === "0")) {
                $finance_status = '待付款';
            } elseif (($v['finance_status'] === "1") && ($v['receivables_status'] === "0")) {
                $finance_status = '待确认收款';
            } elseif (($v['finance_status'] === "1") && ($v['receivables_status'] === "1")) {
                $finance_status = '已完成';
            }

            $pay_time = $v['pay_time'];

            $value_arr = [
                $task_id, $task_name, $media_man_id, $media_man_login_name,
                $media_man_name, $sex, $media_man_phone, $school_name, $zfb_nu,
                $zfb_realname, $platform_pay_way, $platform_pay_money, $finance_status, $pay_time,
            ];

            $value = implode(",", $value_arr);
            $value = $value . PHP_EOL;
            $value = iconv('utf-8', "gb2312//IGNORE", $value);// '一'bug 必须带上//IGNORE
            file_put_contents($csv_file_path, $value, FILE_APPEND);

        }

        wap::write_file_complete_flag($csv_file_path);

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

    /**
     * @return Platform_task_receivables_model
     */
    private function __get_platform_task_receivables_model() {
        $this->load->model('Platform_task_receivables_model');
        return $this->Platform_task_receivables_model;
    }

    /**
     * @return Platform_task_map_model
     */
    private function __get_platform_task_map_model() {
        $this->load->model('Platform_task_map_model');
        return $this->Platform_task_map_model;
    }

    /**
     * @return Platform_task_model
     */
    private function __get_platform_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }

}
