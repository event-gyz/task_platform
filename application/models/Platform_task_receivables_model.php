<?php

/**
 * Class Platform_task_receivables_model
 */
class Platform_task_receivables_model extends MY_Model {

    public $table = 'platform_task_receivables';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 自媒体人结账列表
     *
     * @param $where
     *
     * @return array
     */
    public function get_task_receivables_list_by_condition($where) {

        $param_arr       = [
            'pt.*', 'pmm.*',
            'ptm.receivables_status',
            'ptr.platform_pay_money',
            'ptr.platform_pay_way',
            'ptr.finance_status',
            'ptr.pay_time',
        ];
        $param           = implode(',', $param_arr);
        $task_table      = 'platform_task';
        $task_map_table  = 'platform_task_map';
        $media_man_table = 'platform_media_man';
        $sql             = "SELECT [*] FROM `{$this->table}` AS ptr ";
        $sql             .= "LEFT JOIN `{$task_map_table}` AS ptm on ptr.task_map_id = ptm.task_map_id ";
        $sql             .= "LEFT JOIN `{$task_table}` AS pt ON pt.task_id = ptm.task_id ";
        $sql             .= "LEFT JOIN `{$media_man_table}` AS pmm on pmm.media_man_id = ptm.media_man_user_id where 1=1 ";

        // 拼接查询条件

        // 根据用户名
        if (isset($where['media_man_login_name']) && $where['media_man_login_name']) {
            $sql .= sprintf(" AND pmm.media_man_login_name like '%s%%'", $where['media_man_login_name']);
        }

        // 根据学校名称
        if (isset($where['school_name']) && $where['school_name']) {
            $sql .= sprintf(" AND pmm.school_name like '%s%%'", $where['school_name']);
        }

        // 根据支付宝账号
        if (isset($where['zfb_nu']) && $where['zfb_nu']) {
            $sql .= sprintf(" AND pmm.zfb_nu like '%s%%'", $where['zfb_nu']);
        }

        // 根据财务确认状态
        if (isset($where['finance_status']) && $where['finance_status'] !== '') {
            $sql .= sprintf(" AND ptr.finance_status = %d", $where['finance_status']);
        }

        // 根据自媒体人确认收款状态
        if (isset($where['receivables_status']) && $where['receivables_status'] !== '') {
            $sql .= sprintf(" AND ptm.receivables_status = %d", $where['receivables_status']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptr.receivables_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptm.create_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function updateInfo($receivables_id, $info) {
        $where = array('receivables_id' => $receivables_id);
        return $this->update($info, $where);
    }

    public function selectById($receivables_id) {
        $query = $this->db->get_where($this->getTableName(), array('receivables_id' => $receivables_id));
        return $query->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

