<?php

/**
 * Class Sys_auth_model
 */
class Sys_auth_model extends MY_Model {

    public $table = 'sys_auth';

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_auth_list_by_condition($where = array(), $fields = "sa.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS sa WHERE 1 = 1 ";

        // 拼接查询条件

        if (isset($where['auth_name']) && $where['auth_name']) {
            $sql .= sprintf(" AND sa.auth_name like '%s%%'", $where['auth_name']);
        }

        if (isset($where['level'])) {
            $sql .= sprintf(" AND sa.level = %d", $where['level']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY sa.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'sa.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS sa, ( %s ) AS T2 WHERE sa.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY sa.update_time DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function update_sys_auth($sys_auth_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $sys_auth_id);
        return $this->update($info, $where);
    }

    public function select_by_id($sys_auth_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $sys_auth_id));
        return $query->row_array();
    }

    public function get_auth_list_by_auth_ids($auth_ids) {
        if (empty($auth_ids)) {
            return [];
        }
        $sql = "SELECT sa.* FROM `{$this->table}` AS sa WHERE id IN ( {$auth_ids} )";
        return $this->getList($sql);
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // 查询level = 0 或者 1 的权限列表
    public function select_level0_level1_auth_list() {
        $this->db->from("`{$this->getTableName()}` AS sa");
        $this->db->where('level = 0 OR level = 1');
        $this->db->order_by('sort', 'DESC');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // 查询所有的权限列表
    public function select_all_auth_list() {
        $query = $this->db->get_where($this->getTableName());
        return $query->result_array();
    }

    public function del($sys_auth_id) {
        return $this->delete(['id' => $sys_auth_id]);
    }

    // 获取待处理的工作数量
    public function get_job_count() {

        // 公司广告主审核列表--广告主待审核数量
        $sql1              = "SELECT COUNT(*) AS c FROM `platform_advertiser` AS pa WHERE pa.status != 0 AND pa.audit_status = 0 AND pa.advertiser_type = 2";
        $c_adv_audit_count = $this->db->query($sql1);

        // 个人广告主审核列表--个人广告主待审核数量
        $sql2              = "SELECT COUNT(*) AS c FROM `platform_advertiser` AS pa WHERE pa.status != 0 AND pa.audit_status = 0 AND pa.advertiser_type = 1";
        $p_adv_audit_count = $this->db->query($sql2);

        // 自媒体人审核列表--自媒体人待审核数量
        $sql3              = "SELECT COUNT(*) AS c FROM `platform_media_man` AS pm WHERE pm.status != 0 AND pm.audit_status = 0";
        $media_audit_count = $this->db->query($sql3);

        // 任务管理---任务待审核数量
        $sql4             = "SELECT COUNT(*) AS c FROM `platform_task` pt WHERE pt.release_status = 0 AND pt.audit_status = 1";
        $task_audit_count = $this->db->query($sql4);

        // 发布管理---待发布任务数量
        $sql5
                                  = "SELECT COUNT(*) AS c FROM `platform_task` AS pt 
            LEFT JOIN `platform_task_payment` AS ptp on pt.task_id = ptp.task_id 
            WHERE pt.release_status = 0 AND pt.audit_status = 3 AND pt.pay_status = 1  AND ptp.finance_status = 1";
        $task_to_be_release_count = $this->db->query($sql5);

        // 发布管理---待确认完成
        $cur_time_stamp                  = time();
        $sql6
                                         = "SELECT COUNT(*) AS c FROM `platform_task` AS pt 
            LEFT JOIN `platform_task_payment` AS ptp on pt.task_id = ptp.task_id 
            WHERE pt.release_status = 1 AND pt.audit_status = 3 AND pt.pay_status = 1 AND ptp.finance_status = 1 AND pt.end_time <= {$cur_time_stamp}";
        $task_to_be_confirm_finish_count = $this->db->query($sql6);

        // 自媒体人结账列表---待付款
        $sql7                  = "SELECT COUNT(*) AS c FROM `platform_task_receivables` AS ptr WHERE ptr.finance_status = 0";
        $media_to_be_pay_count = $this->db->query($sql7);

        // 广告主付款列表---待财务确认
        $sql8                            = "SELECT COUNT(*) AS c FROM `platform_task_payment` AS ptp WHERE ptp.finance_status = 0";
        $adv_to_be_finance_confirm_count = $this->db->query($sql8);

        // key 的命名规则是根据 控制器-方法 来命名的,所以看起来有些奇怪,不要在意这些细节...


        return [

            // 一级菜单
            'Platform_advertiser'                   => $c_adv_audit_count->row_array()['c'] + $p_adv_audit_count->row_array()['c'],
            'Platform_media_man'                    => $media_audit_count->row_array()['c'],
            'Platform_task'                         => $task_audit_count->row_array()['c'],
            'Release_task'                          => $task_to_be_release_count->row_array()['c'] + $task_to_be_confirm_finish_count->row_array()['c'],
            'Finance'                               => $media_to_be_pay_count->row_array()['c'] + $adv_to_be_finance_confirm_count->row_array()['c'],

            // 二级菜单
            'Platform_advertiser-company_adv_home'  => $c_adv_audit_count->row_array()['c'],
            'Platform_advertiser-personal_adv_home' => $p_adv_audit_count->row_array()['c'],
            'Platform_media_man-home'               => $media_audit_count->row_array()['c'],
            'Platform_task-home'                    => $task_audit_count->row_array()['c'],
            'Release_task-home'                     => $task_to_be_release_count->row_array()['c'] + $task_to_be_confirm_finish_count->row_array()['c'],
            'Platform_task_receivables-home'        => $media_to_be_pay_count->row_array()['c'],
            'Platform_task_payment-home'            => $adv_to_be_finance_confirm_count->row_array()['c'],
        ];

    }

}

