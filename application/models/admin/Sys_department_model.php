<?php

/**
 * Class Sys_department_model
 */
class Sys_department_model extends MY_Model {

    public $table = 'sys_department';

    const DATA_STATUS_NORMAL  = 0;
    const DATA_STATUS_DELETED = 1;

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_department_list_by_condition($where = array(), $fields = "sd.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS sd WHERE 1 = 1 ";

        // 拼接查询条件

        $sql .= sprintf(" AND sd.status = %d", self::DATA_STATUS_NORMAL);

        if (isset($where['dept_name']) && $where['dept_name']) {
            $sql .= sprintf(" AND sd.dept_name = '%s'", $where['dept_name']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY sd.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'sd.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS sd, ( %s ) AS T2 WHERE sd.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY sd.update_time DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $this->__deal_list($_list)];
        return $data;
    }

    // 处理列表数据,创建人,修改人,以及部门名称
    private function __deal_list($list) {

        $result = [];
        foreach ($list as $value) {

            $value['user_count'] = $this->__get_user_count_by_dept_id($value['id']);

            $result[] = $value;

        }

        return $result;
    }

    // 查询部门下的未删除用户数
    private function __get_user_count_by_dept_id($dept_id) {
        $sql   = "SELECT count(*) AS c from sys_user where `status` = 0 AND `dept_id` = {$dept_id};";
        $query = $this->db->query($sql);
        return $query->row_array()['c'];
    }

    public function update_sys_department($sys_department_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $sys_department_id);
        return $this->update($info, $where);
    }

    public function select_by_id($sys_department_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $sys_department_id));
        return $query->row_array();
    }

    // 查询所有的部门列表
    public function select_all_dept_list() {
        $query = $this->db->get_where($this->getTableName(), "status = " . self::DATA_STATUS_NORMAL);
        return $query->result_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

