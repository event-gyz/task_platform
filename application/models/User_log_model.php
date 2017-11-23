<?php

/**
 * Class User_log_model
 */
class User_log_model extends MY_Model {

    public $table = 'user_log';

    public function __construct() {
        parent::__construct();
    }

    public function get_user_log_list_by_condition($where = array(), $fields = "ul.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS ul WHERE 1 = 1 ";

        // 拼接查询条件

        if (isset($where['user_id']) && $where['user_id']) {
            $sql .= sprintf(" AND ul.user_id = %d", $where['user_id']);
        }

        if (isset($where['user_log_type']) && $where['user_log_type']) {
            $sql .= sprintf(" AND ul.user_log_type = %d", $where['user_log_type']);
        }

        if (isset($where['user_type']) && $where['user_type']) {
            $sql .= sprintf(" AND ul.user_type = %d", $where['user_type']);
        }

        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND ul.create_time >= '%s'", $where['start_time']);
        }

        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND ul.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'ul.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS ul, ( %s ) AS T2 WHERE ul.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY ul.id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function update_user_log($user_log_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $user_log_id);
        return $this->update($info, $where);
    }

    public function select_by_id($user_log_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $user_log_id));
        return $query->row_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

