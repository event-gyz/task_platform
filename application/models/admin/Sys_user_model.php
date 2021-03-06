<?php

/**
 * Class Sys_user_model
 */
class Sys_user_model extends MY_Model {

    public $table = 'sys_user';

    const DATA_STATUS_NORMAL  = 0;
    const DATA_STATUS_DELETED = 1;

    const USER_STATUS_DISABLED = 0;
    const USER_STATUS_ACTIVE   = 1;

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_user_list_by_condition($where = array(), $fields = "su.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS su WHERE 1 = 1 ";

        // 拼接查询条件

        $sql .= sprintf(" AND su.status = %d", self::DATA_STATUS_NORMAL);

        if (isset($where['user_name']) && $where['user_name']) {
            $sql .= sprintf(" AND su.user_name = '%s'", $where['user_name']);
        }

        if (isset($where['user_status']) && $where['user_status']) {
            $sql .= sprintf(" AND su.user_status = %d", $where['user_status']);
        }

        if (isset($where['mobile']) && $where['mobile']) {
            $sql .= sprintf(" AND su.mobile = '%s'", $where['mobile']);
        }

        if (isset($where['nick_name']) && $where['nick_name']) {
            $sql .= sprintf(" AND su.nick_name = '%s'", $where['nick_name']);
        }

        if (isset($where['dept_id']) && $where['dept_id']) {
            $sql .= sprintf(" AND su.dept_id = %d", $where['dept_id']);
        }

        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND su.create_time >= '%s'", $where['start_time']);
        }

        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND su.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY su.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'su.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS su, ( %s ) AS T2 WHERE su.id = T2.id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY su.update_time DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $this->__deal_list($_list)];
        return $data;
    }

    // 处理列表数据,创建人,修改人,以及部门名称
    private function __deal_list($list) {
        $create_id_arr   = array_column($list, 'create_sys_user_id');
        $create_name_arr = $this->__get_operate_user_name_arr($create_id_arr);

        $modify_id_arr   = array_column($list, 'last_modify_sys_user_id');
        $modify_name_arr = $this->__get_operate_user_name_arr($modify_id_arr);

        $dept_id_arr   = array_column($list, 'dept_id');
        $dept_name_arr = $this->__get_dept_name_arr($dept_id_arr);

        $role_id_arr   = array_column($list, 'role_id');
        $role_name_arr = $this->__get_role_name_arr($role_id_arr);

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

            $value['dept_name'] = '';
            foreach ($dept_name_arr as $value3) {

                if ($value['dept_id'] === $value3['id']) {
                    $value['dept_name'] = $value3['dept_name'];
                    break;
                }
            }

            $value['role_name'] = '';
            foreach ($role_name_arr as $value4) {

                if ($value['role_id'] === $value4['id']) {
                    $value['role_name'] = $value4['role_name'];
                    break;
                }
            }

            $result[] = $value;

        }

        return $result;
    }

    private function __get_operate_user_name_arr($id_arr) {
        if (empty($id_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($id_arr));
        $sql    = "SELECT su.user_name , su.id FROM `{$this->table}` AS su WHERE id IN ( {$id_str} )";
        return $this->getList($sql);
    }

    private function __get_dept_name_arr($id_arr) {
        if (empty($id_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($id_arr));
        $sql    = "SELECT sd.dept_name , sd.id FROM `sys_department` AS sd WHERE id IN ( {$id_str} )";
        return $this->getList($sql);
    }

    private function __get_role_name_arr($id_arr) {
        if (empty($id_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($id_arr));
        $sql    = "SELECT sr.role_name , sr.id FROM `sys_role` AS sr WHERE id IN ( {$id_str} )";
        return $this->getList($sql);
    }

    public function update_sys_user($sys_user_id, $info) {
        $info['update_time'] = date('Y-m-d H:i:s', time());
        $where               = array('id' => $sys_user_id);
        return $this->update($info, $where);
    }

    public function select_by_id($sys_user_id) {
        $query = $this->db->get_where($this->getTableName(), array('id' => $sys_user_id));
        return $query->row_array();
    }

    public function select_by_user_name($user_name) {
        $this->db->select('su.*, sr.role_name, sr.auth_ids ,sd.dept_name');
        $this->db->from("`{$this->getTableName()}` AS su");
        $this->db->join(' sys_role AS sr', 'sr.id = su.role_id', 'LEFT');
        $this->db->join(' sys_department AS sd', 'sd.id = su.dept_id', 'LEFT');
        $this->db->where(
            array(
                'su.user_name'   => $user_name,
                'su.user_status' => self::USER_STATUS_ACTIVE,
                'su.status'      => self::DATA_STATUS_NORMAL,
            )
        );
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insert($data) {
        $data['create_time'] = date("Y-m-d H:i:s", time());
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * 根据密码和盐生成密码
     *
     * @param $password
     * @param $salt
     *
     * @return string
     */
    public function generate_admin_password($password, $salt) {
        $toBeEncrypt = $salt . md5($password);
        return md5($toBeEncrypt);
    }

    /**
     * 检查用户提交的密码是否正确
     *
     * @param $userPostPassword
     * @param $dbPassword
     * @param $salt
     *
     * @return bool
     */
    public function check_admin_password($userPostPassword, $dbPassword, $salt) {
        $encryptUserPostPassword = $this->generate_admin_password($userPostPassword, $salt);
        return $dbPassword === $encryptUserPostPassword;
    }

    /**
     * 生成指定长度的随机字符串
     *
     * @param $length
     *
     * @return string
     */
    public function random_str($length = 4) {
        $output = '';
        for ($a = 0; $a < $length; $a++) {
            $output .= chr(mt_rand(35, 126));
        }
        return $output;
    }

}

