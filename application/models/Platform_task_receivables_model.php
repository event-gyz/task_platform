<?php

/**
 * Class Platform_task_receivables_model
 */
class Platform_task_receivables_model extends MY_Model{

    public $table = 'platform_task_receivables';

    public function __construct(){
        parent::__construct();
    }

    public function get_task_receivables_list_by_condition($where) {

        $param = "pt.*,pmm.*,ptr.platform_pay_money,ptr.platform_pay_way,ptr.finance_status,ptr.pay_time";
        $task_table = 'platform_task';
        $task_map_table = 'platform_task_map';
        $media_man_table = 'platform_media_man';
        $sql = "SELECT [*] FROM `{$task_map_table}` AS ptm LEFT JOIN `{$this->table}` AS ptr on ptr.task_map_id=ptm.task_map_id LEFT JOIN `{$task_table}` AS pt ON pt.task_id=ptm.task_id LEFT JOIN `{$media_man_table}` AS pmm on pmm.media_man_id=ptm.media_man_user_id where 1=1 ";

        // 拼接查询条件
        // 根据用户名
        if (isset($where['login_name']) && $where['login_name']) {
            $sql .= sprintf(" AND pmm.media_man_login_name like '%s%%'", $where['login_name']);
        }

        // 根据学校名称
        if (isset($where['school_name']) && $where['school_name']) {
            $sql .= sprintf(" AND pmm.school_name like '%s%%'", $where['school_name']);
        }

        // 根据支付宝账号
        if (isset($where['zfb_nu']) && $where['zfb_nu']) {
            $sql .= sprintf(" AND pmm.zfb_nu like '%s%%'", $where['zfb_nu']);
        }

        // 根据财务审核状态
        if (isset($where['finance_status']) && $where['finance_status']) {
            $sql .= sprintf(" AND ptr.finance_status = %d", $where['finance_status']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptm.task_map_id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    /**
     * 修改广告主支付财务审核状态
     * @return bool
     */
    public function updateStatus($where){
        if(!isset($where['payment_id']) || empty($where['payment_id'])){
            return false;
        }else if(!isset($where['task_id']) || empty($where['task_id'])){
            return false;
        }
        return $this->update(['finance_status'=>1], $where );
    }

    public function select_by_id($task_id) {
        $query = $this->db->get_where($this->getTableName(), array('task_id' => $task_id));
        return $query->row_array();
    }

    public function insert($data){
        if(!isset($data['task_id']) || empty($data['task_id'])){
            return false;
        }
        if(!isset($data['pay_money']) && empty($data['pay_money'])){
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

