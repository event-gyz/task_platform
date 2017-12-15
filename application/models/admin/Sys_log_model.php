<?php

/**
 * Class Sys_log_model
 */
class Sys_log_model extends MY_Model {

    public $table = 'sys_log';

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_log_list_by_condition($where = array(), $fields = "sl.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS sl WHERE 1 = 1 ";

        // 拼接查询条件

        if (isset($where['sys_user_id']) && $where['sys_user_id']) {
            $sql .= sprintf(" AND sl.sys_user_id = %d", $where['sys_user_id']);
        }

        if (isset($where['operate_data_id']) && $where['operate_data_id']) {
            $sql .= sprintf(" AND sl.operate_data_id = %d", $where['operate_data_id']);
        }

        if (isset($where['sys_log_type']) && $where['sys_log_type']) {
            $sql .= sprintf(" AND sl.sys_log_type IN (%s)", $where['sys_log_type']);
        }

        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND sl.create_time >= '%s'", $where['start_time']);
        }

        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND sl.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY sl.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'sl.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS sl, ( %s ) AS T2 WHERE sl.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY sl.update_time DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function update_sys_log($sys_log_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $sys_log_id);
        return $this->update($info, $where);
    }

    public function select_by_id($sys_log_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $sys_log_id));
        return $query->row_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

