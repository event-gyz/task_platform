<?php

/**
 * Class Platform_task_payment_model
 */
class Platform_task_payment_model extends MY_Model{

    public $table = 'platform_task_payment';

    public function __construct(){
        parent::__construct();
    }

    public function get_task_payment_list_by_condition($where) {

        $param = "pt.*,ptp.*,pa.advertiser_id,pa.advertiser_login_name,pa.advertiser_name,pa.advertiser_phone,pa.company_name";
        $task_table = 'platform_task';
        $advertiser_table = 'platform_advertiser';
        $sql = "SELECT [*] FROM `{$task_table}` AS pt left join `{$this->table}` AS ptp on pt.task_id=ptp.task_id LEFT JOIN `{$advertiser_table}` AS pa ON pt.advertiser_user_id=pa.advertiser_id where 1=1 ";

        // 拼接查询条件

        // 根据任务id
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND ptp.task_id = %d", $where['task_id']);
        }

        // 根据用户名
        if (isset($where['advertiser_login_name']) && $where['advertiser_login_name']) {
            $sql .= sprintf(" AND pa.advertiser_login_name = '%s'", $where['advertiser_login_name']);
        }

        // 根据姓名/公司名称
        if (isset($where['name']) && $where['name']) {
            $name = $where['name'];
            $sql .= sprintf(" AND (pa.advertiser_name like '%s%%' or pa.company_name like '%s%%' ) ", $name,$name);
        }

        // 根据电话
        if (isset($where['advertiser_phone']) && $where['advertiser_phone']) {
            $sql .= sprintf(" AND pa.advertiser_phone like '%s%%'", $where['advertiser_phone']);
        }

        // 根据财务审核状态
        if (isset($where['finance_status']) && $where['finance_status']) {
            $sql .= sprintf(" AND ptp.finance_status = %d", $where['finance_status']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptp.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptp.task_map_id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    /**
     * 修改广告主支付财务审核状态
     * @return bool
     */
    public function update($where,$status){
        if(!isset($where['payment_id']) || empty($where['payment_id'])){
            return false;
        }else if(!isset($where['task_id']) || empty($where['task_id'])){
            return false;
        }
        return $this->db
            ->where($where)
            ->update($this->table, ['finance_status'=>1]);
    }

    public function select_by_id($task_id) {
        $query = $this->db->get_where($this->getTableName(), array('task_id' => $task_id));
        return $query->row_array();
    }

    public function insert($data){
        if(!isset($data['task_id']) || empty($data['task_id'])){
            return false;
        }
        if(!isset($data['pay_money']) && empty($data['pay_money'])){
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

