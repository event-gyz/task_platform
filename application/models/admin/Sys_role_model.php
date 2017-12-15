<?php

/**
 * Class Sys_role_model
 */
class Sys_role_model extends MY_Model {

    public $table = 'sys_role';

    const DATA_STATUS_NORMAL  = 0;
    const DATA_STATUS_DELETED = 1;

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_role_list_by_condition($where = array(), $fields = "sr.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS sr WHERE 1 = 1 ";

        // 拼接查询条件

        $sql .= sprintf(" AND sr.status = %d", self::DATA_STATUS_NORMAL);

        if (isset($where['role_name']) && $where['role_name']) {
            $sql .= sprintf(" AND sr.role_name = '%s'", $where['role_name']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY sr.id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'sr.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS sr, ( %s ) AS T2 WHERE sr.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY sr.id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $this->__deal_list($_list)];
        return $data;
    }

    // 处理列表数据,创建人,修改人,以及部门名称
    private function __deal_list($list) {
        $create_id_arr = array_column($list, 'create_sys_user_id');
        $modify_id_arr = array_column($list, 'last_modify_sys_user_id');

        $create_name_arr = $this->__get_operate_user_name_arr($create_id_arr);
        $modify_name_arr = $this->__get_operate_user_name_arr($modify_id_arr);

        $result = [];
        foreach ($list as $value) {

            $value['create_by_name'] = '';
            foreach ($create_name_arr as $value1) {

                if ($value['create_sys_user_id'] === $value1['id']) {
                    $value['create_by_name'] = $value1['user_name'];
                    break;
                }

            }

            $value['modify_by_name'] = '';
            foreach ($modify_name_arr as $value2) {

                if ($value['last_modify_sys_user_id'] === $value2['id']) {
                    $value['modify_by_name'] = $value2['user_name'];
                    break;
                }
            }

            $value['user_count'] = $this->__get_user_count_by_role_id($value['id']);

            $result[] = $value;

        }

        return $result;
    }

    // 查询角色下的未删除用户数
    private function __get_user_count_by_role_id($role_id) {
        $sql   = "SELECT count(*) AS c from sys_user where `status` = 0 AND `role_id` = {$role_id};";
        $query = $this->db->query($sql);
        return $query->row_array()['c'];
    }

    private function __get_operate_user_name_arr($id_arr) {
        if (empty($id_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($id_arr));
        $sql    = "SELECT su.user_name , su.id FROM `sys_user` AS su WHERE id IN ( {$id_str} )";
        return $this->getList($sql);
    }

    public function update_sys_role($sys_role_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $sys_role_id);
        return $this->update($info, $where);
    }

    public function select_by_id($sys_role_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $sys_role_id));
        return $query->row_array();
    }

    // 查询所有的角色列表
    public function select_all_role_list() {
        $query = $this->db->get_where($this->getTableName(), "status = " . self::DATA_STATUS_NORMAL);
        return $query->result_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

