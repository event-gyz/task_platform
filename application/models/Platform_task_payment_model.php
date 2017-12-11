<?php

/**
 * Class Platform_task_payment_model
 */
class Platform_task_payment_model extends MY_Model {

    public $table = 'platform_task_payment';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 广告主付款列表
     *
     * @param $where
     *
     * @return array
     */
    public function get_task_payment_list_by_condition($where) {

        $param_arr        = [
            'pt.*', 'ptp.*',
            'pa.advertiser_type', 'pa.advertiser_id', 'pa.advertiser_login_name',
            'pa.advertiser_name', 'pa.advertiser_phone',
            'pa.company_name', 'pa.content_phone', 'ptp.create_time as pay_time',
        ];
        $param            = implode(',', $param_arr);
        $task_table       = 'platform_task';
        $advertiser_table = 'platform_advertiser';
        $sql              = "SELECT [*] FROM `{$this->table}` AS ptp ";
        $sql              .= "LEFT JOIN `{$task_table}` AS pt ON pt.task_id = ptp.task_id ";
        $sql              .= "LEFT JOIN `{$advertiser_table}` AS pa ON pt.advertiser_user_id = pa.advertiser_id WHERE 1=1 ";

        // 拼接查询条件

        // 根据任务id
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND ptp.task_id = %d", $where['task_id']);
        }

        // 根据用户名
        if (isset($where['advertiser_login_name']) && $where['advertiser_login_name']) {
            $sql .= sprintf(" AND pa.advertiser_login_name LIKE '%s%%'", $where['advertiser_login_name']);
        }

        // 根据姓名/公司名称
        if (isset($where['u_name_or_c_name']) && $where['u_name_or_c_name']) {
            $name = $where['u_name_or_c_name'];
            $sql  .= sprintf(" AND (pa.advertiser_name LIKE '%s%%' OR pa.company_name LIKE '%s%%' ) ", $name, $name);
        }

        // 根据个人电话/公司电话
        if (isset($where['u_phone_or_c_phone']) && $where['u_phone_or_c_phone']) {
            $phone = $where['u_phone_or_c_phone'];
            $sql   .= sprintf(" AND (pa.advertiser_phone LIKE '%s%%' OR pa.content_phone LIKE '%s%%' ) ", $phone, $phone);
        }

        // 根据财务审核状态
        if (isset($where['finance_status']) && $where['finance_status'] !== '') {
            $sql .= sprintf(" AND ptp.finance_status = %d", $where['finance_status']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptp.payment_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptp.update_time DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function updateInfo($payment_id, $info) {
        $where = array('payment_id' => $payment_id);
        return $this->update($info, $where);
    }

    public function selectById($payment_id) {
        $query = $this->db->get_where($this->getTableName(), array('payment_id' => $payment_id));
        return $query->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

