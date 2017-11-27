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
            $sql .= sprintf(" AND sa.auth_name = '%s'", $where['auth_name']);
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

        $sql .= ' ORDER BY sa.id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'sa.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS sa, ( %s ) AS T2 WHERE sa.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY sa.id DESC';
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

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // 查询level = 0 或者 1 的权限列表
    public function select_level0_level1_auth_list() {
        $query = $this->db->get_where($this->getTableName(), 'level = 0 OR level = 1');
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

}

