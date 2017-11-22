<?php

/**
 * Class Platform_advertiser_model
 */
class Platform_advertiser_model extends MY_Model{

    public $_table = 'platform_advertiser';

    public function __construct(){
        parent::__construct();
    }


    public function get_advertiser_list_by_condition($where) {

        $param = "pa.*";

        $sql = "SELECT [*] FROM `{$this->_table}` AS pa where 1=1 ";


        // 拼接查询条件
        // 根据广告主电话
        if (isset($where['advertiser_phone']) && $where['advertiser_phone']) {
            $sql .= sprintf(" AND pa.advertiser_phone = '%s'", $where['advertiser_phone']);
        }

        // 根据广告主登录名
        if (isset($where['advertiser_login_name']) && $where['advertiser_login_name']) {
            $sql .= sprintf(" AND pa.advertiser_login_name = '%s'", $where['advertiser_login_name']);
        }
        // 根据广告主姓名
        if (isset($where['advertiser_name']) && $where['advertiser_name']) {
            $sql .= sprintf(" AND pa.advertiser_name = '%s'", $where['advertiser_name']);
        }
        // 根据广告主审核状态
        if (isset($where['audit_status']) && $where['audit_status']) {
            $sql .= sprintf(" AND pa.audit_status = %d", $where['audit_status']);
        }
        // 根据广告主账户状态
        if (isset($where['status']) && $where['status']) {
            $sql .= sprintf(" AND pa.status = %d", $where['status']);
        }
        // 根据广告主身份证号
        if (isset($where['id_card']) && $where['id_card']) {
            $sql .= sprintf(" AND pa.id_card = '%s'", $where['id_card']);
        }
        // 根据广告主类型
        if (isset($where['advertiser_type']) && $where['advertiser_type']) {
            $sql .= sprintf(" AND pa.advertiser_type = %d", $where['advertiser_type']);
//            $sql .= " AND pa.orderId in ({$where['order_ids']})";
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

        $offset = $where['offset'] ? $where['offset'] : 0;
        $limit  = $where['limit'] ? $where['limit'] : 10;

        $sql .= ' ORDER BY pa.advertiser_id DESC';
        $sql .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);

        $data = array(
//            'sql'   => $_sql,
            'total' => $total,
            'list'  => $_list,
        );
        return $data;
    }

    public function update($advertiser_id,$info){
        $where = array('advertiser_id'=>$advertiser_id);
        return $this->update($info,$where);
    }

    public function select_by_id($advertiser_id) {

        $query = $this->db->get_where($this->getTableName(), array('advertiser_id' => $advertiser_id));
        return $query->row_array();
    }

    public function insert($data){

        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

}
