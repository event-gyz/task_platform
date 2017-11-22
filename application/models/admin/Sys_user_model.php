<?php

/**
 * Class Sys_user_model
 */
class Sys_user_model extends MY_Model {

    public $table = 'sys_user';

    public function __construct() {
        parent::__construct();
    }

    public function get_sys_user_list_by_condition($where = array()) {

        $param = "T1.*";
        $sql   = "SELECT [*] FROM `{$this->table}` AS T1 WHERE 1 = 1 ";

        // 拼接查询条件

        if (isset($where['user_name']) && $where['user_name']) {
            $sql .= sprintf(" AND T1.user_name = '%s'", $where['user_name']);
        }

        if (isset($where['nick_name']) && $where['nick_name']) {
            $sql .= sprintf(" AND T1.nick_name = '%s'", $where['nick_name']);
        }

        if (isset($where['user_status']) && $where['user_status']) {
            $sql .= sprintf(" AND T1.user_status = %d", $where['user_status']);
        }

        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND T1.create_time >= '%s'", $where['start_time']);
        }

        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND T1.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sql_count = str_replace('[*]', 'count(*) AS c', $sql);
        $total     = $this->getCount($sql_count);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY T1.id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d , %d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'T1.id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS T1, ( %s ) AS T2 WHERE T1.id = T2.id", $this->table, $get_id_sql);
        $_sql       = str_replace('[*]', $param, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
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

