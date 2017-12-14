<?php

/**
 * Class Platform_advertiser_model
 */
class Platform_advertiser_model extends MY_Model {

    public $table = 'platform_advertiser';

    const ADVERTISER_TYPE_PERSONAL = 1;// 广告主类型,个人
    const ADVERTISER_TYPE_COMPANY  = 2;// 广告主类型,企业

    public function __construct() {
        parent::__construct();
    }


    public function get_advertiser_list_by_condition($where, $fields = "pa.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS pa where 1=1 ";

        // 拼接查询条件

        // 根据公司名称
        if (isset($where['company_name']) && $where['company_name']) {
            $sql .= sprintf(" AND pa.company_name like '%s%%'", $where['company_name']);
        }

        // 根据公司联系人姓名
        if (isset($where['content_name']) && $where['content_name']) {
            $sql .= sprintf(" AND pa.content_name like '%s%%'", $where['content_name']);
        }

        // 根据公司联系人电话
        if (isset($where['content_phone']) && $where['content_phone']) {
            $sql .= sprintf(" AND pa.content_phone like '%s%%'", $where['content_phone']);
        }

        // 根据用户id
        if (isset($where['advertiser_id']) && $where['advertiser_id']) {
            $sql .= sprintf(" AND pa.advertiser_id = %d", $where['advertiser_id']);
        }

        // 根据广告主电话
        if (isset($where['advertiser_phone']) && $where['advertiser_phone']) {
            $sql .= sprintf(" AND pa.advertiser_phone like '%s%%'", $where['advertiser_phone']);
        }

        // 根据广告主登录名
        if (isset($where['advertiser_login_name']) && $where['advertiser_login_name']) {
            $sql .= sprintf(" AND pa.advertiser_login_name like '%s%%'", $where['advertiser_login_name']);
        }

        // 根据广告主姓名
        if (isset($where['advertiser_name']) && $where['advertiser_name']) {
            $sql .= sprintf(" AND pa.advertiser_name like '%s%%'", $where['advertiser_name']);
        }

        // 根据广告主审核状态
        if (isset($where['audit_status']) && $where['audit_status'] !== '') {
            $sql .= sprintf(" AND pa.audit_status = %d", $where['audit_status']);
        }

        // 根据广告主账户状态
        if (isset($where['status']) && $where['status'] !== '') {
            $sql .= sprintf(" AND pa.status = %d", $where['status']);
        }

        if (isset($where['no_draft']) && $where['no_draft'] !== '') {
            $sql .= sprintf(" AND pa.status != %d", $where['no_draft']);
        }

        // 根据广告主身份证号
        if (isset($where['id_card']) && $where['id_card']) {
            $sql .= sprintf(" AND pa.id_card like '%s%%'", $where['id_card']);
        }

        // 根据广告主类型
        if (isset($where['advertiser_type']) && $where['advertiser_type']) {
            $sql .= sprintf(" AND pa.advertiser_type = %d", $where['advertiser_type']);
        }

        // 根据广告主创建开始时间
        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND pa.create_time >= '%s'", $where['start_time']);
        }

        // 根据广告主创建结束时间
        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND pa.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(pa.advertiser_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY pa.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'pa.advertiser_id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS pa, ( %s ) AS T2 WHERE pa.advertiser_id = T2.advertiser_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY pa.update_time DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }


    public function updateInfo($advertiser_id, $info) {
        if (empty($advertiser_id)) {
            return false;
        }
        $where = array('advertiser_id' => $advertiser_id);
        return $this->update($info, $where);
    }

    public function updateInfoByPhone($phone, $info) {
        $where = array('advertiser_phone' => $phone);
        return $this->update($info, $where);
    }

    public function selectByPhone($phone) {

        $query = $this->db->get_where($this->getTableName(), array('advertiser_phone' => $phone));
        return $query->row_array();
    }

    public function selectById($advertiser_id) {

        $query = $this->db->get_where($this->getTableName(), array('advertiser_id' => $advertiser_id));
        return $query->row_array();
    }

    public function selectByLoginName($login_name) {

        $query = $this->db->get_where($this->getTableName(), array('advertiser_login_name' => $login_name));
        return $query->row_array();
    }

    public function selectByUserName($login_name) {
        $query  = $this->db->get_where($this->getTableName(), array('advertiser_login_name' => $login_name));
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            $query = $this->db->get_where($this->getTableName(), array('advertiser_phone' => $login_name));
            return $query->row_array();
        }
    }

    public function insert($data) {

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

