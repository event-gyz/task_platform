<?php

/**
 * Class User_message_model
 */
class User_message_model extends MY_Model {

    public $table = 'user_message';

    public function __construct() {
        parent::__construct();
    }

    public function get_user_message_list_by_condition($where = array(), $fields = "um.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS um WHERE 1 = 1 ";

        // 拼接查询条件

        if (isset($where['user_id']) && $where['user_id']) {
            $sql .= sprintf(" AND um.user_id = %d", $where['user_id']);
        }

        if (isset($where['user_type']) && $where['user_type']) {
            $sql .= sprintf(" AND um.user_type = %d", $where['user_type']);
        }

        if (isset($where['message_status']) && $where['message_status']) {
            $sql .= sprintf(" AND um.message_status = %d", $where['message_status']);
        }

        if (isset($where['message_type']) && $where['message_type']) {
            $sql .= sprintf(" AND um.message_type = %d", $where['message_type']);
        }

        if (isset($where['read_status']) && $where['read_status']) {
            $sql .= sprintf(" AND um.read_status = %d", $where['read_status']);
        }

        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND um.create_time >= '%s'", $where['start_time']);
        }

        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND um.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY um.id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'um.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS um, ( %s ) AS T2 WHERE um.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY um.id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function update_user_message($user_message_id, $info) {
        $where               = array('id' => $user_message_id);
        return $this->update($info, $where);
    }

    public function select_by_id($user_message_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $user_message_id));
        return $query->row_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

