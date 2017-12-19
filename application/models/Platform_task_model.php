<?php

/**
 * Class Platform_task_model
 */
class Platform_task_model extends MY_Model {

    public $table = 'platform_task';

    public function __construct() {
        parent::__construct();
    }

    public function get_task_list_by_condition($where, $fields = "pt.*, T2.finance_status") {

        $sql = "SELECT [*] FROM `{$this->table}` AS pt LEFT JOIN `platform_task_payment` AS ptp on pt.task_id = ptp.task_id where 1=1 ";

        // 拼接查询条件

        // 根据任务审核状态
        if (isset($where['audit_status']) && $where['audit_status'] !== '') {
            $sql .= sprintf(" AND pt.audit_status = %d", $where['audit_status']);
        }

        // 根据任务发布状态
        if (isset($where['release_status']) && $where['release_status'] !== '') {
            $sql .= sprintf(" AND pt.release_status = %d", $where['release_status']);
        }

        // 广告主付费状态
        if (isset($where['pay_status']) && $where['pay_status'] !== '') {
            $sql .= sprintf(" AND pt.pay_status = %d", $where['pay_status']);
        }

        // 根据财务确认状态
        if (isset($where['finance_status']) && $where['finance_status'] !== '') {
            $sql .= sprintf(" AND ptp.finance_status = %d", $where['finance_status']);
        }

        // 根据任务类型
        if (isset($where['task_type']) && $where['task_type']) {
            $sql .= sprintf(" AND pt.task_type = %d", $where['task_type']);
        }

        // 根据发布平台
        if (isset($where['publishing_platform']) && $where['publishing_platform']) {
            $sql .= sprintf(" AND pt.publishing_platform = '%s'", $where['publishing_platform']);
        }

        // 根据任务名称
        if (isset($where['task_name']) && $where['task_name']) {
            $sql .= sprintf(" AND pt.task_name like '%s%%'", $where['task_name']);
        }

        // 根据任务标题
        if (isset($where['title']) && $where['title']) {
            $sql .= sprintf(" AND pt.title like '%s%%'", $where['title']);
        }

        // 根据任务提交开始时间
        if (isset($where['start_time']) && $where['start_time']) {
            // $sql .= sprintf(" AND pt.submit_audit_time >= '%s'", $where['start_time']);
        }

        // 根据任务提交结束时间
        if (isset($where['end_time']) && $where['end_time']) {
            // $sql .= sprintf(" AND pt.submit_audit_time <= '%s'", $where['end_time']);
        }

        // 根据任务结束时间搜索
        if (isset($where['task_status']) && $where['cur_time_stamp']) {

            if ($where['task_status'] === 'execute') {
                // 执行中的任务
                $sql .= sprintf(" AND pt.end_time > %d", $where['cur_time_stamp']);
            }

            if ($where['task_status'] === 'to_be_confirm') {
                // 待确认完成的任务
                $sql .= sprintf(" AND pt.end_time <= %d", $where['cur_time_stamp']);
            }

        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(pt.task_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY pt.task_id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'pt.task_id, ptp.finance_status', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS pt, ( %s ) AS T2 WHERE pt.task_id = T2.task_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY pt.task_id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $this->__deal_list($_list)];

        return $data;
    }

    // 处理列表数据,任务提交人
    private function __deal_list($list) {
        $advertiser_user_id_arr   = array_column($list, 'advertiser_user_id');
        $advertiser_user_name_arr = $this->__get_advertiser_user_name_arr($advertiser_user_id_arr);

        $result = [];
        foreach ($list as $value) {

            $value['advertiser_user_name'] = '';
            foreach ($advertiser_user_name_arr as $value1) {

                if ($value['advertiser_user_id'] === $value1['advertiser_id']) {
                    $value['advertiser_user_name'] = $value1['advertiser_name'];
                    break;
                }

            }

            $result[] = $value;

        }

        return $result;
    }

    private function __get_advertiser_user_name_arr($id_arr) {
        if (empty($id_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($id_arr));
        $sql    = "SELECT pa.advertiser_name , pa.advertiser_id FROM `platform_advertiser` AS pa WHERE advertiser_id IN ( {$id_str} )";
        return $this->getList($sql);
    }

    public function updateInfo($task_id, $info) {
        $where = array('task_id' => $task_id);
        return $this->update($info, $where);
    }

    public function selectById($task_id) {
        if (empty($task_id)) {
            return false;
        }
        $this->db->select('pt.*, ptp.finance_status');
        $this->db->from("`{$this->getTableName()}` AS pt");
        $this->db->join(' platform_task_payment AS ptp', 'pt.task_id = ptp.task_id', 'LEFT');
        $this->db->where(array('pt.task_id' => $task_id,));
        $query = $this->db->get();
        return $query->row_array();
    }

    public function selectByCondition($where) {
        if (empty($where)) {
            return false;
        }
        $query = $this->db->get_where($this->getTableName(), $where);
        return $query->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function getAdvertiserTaskListByCondition($where, $fields = "pt.*,ptp.finance_status,ptp.finance_status") {

        $sql = "SELECT [*] FROM `{$this->table}` AS pt LEFT JOIN `platform_task_payment` AS ptp on pt.task_id=ptp.task_id where 1=1 ";

        if (empty($where['advertiser_user_id'])) {
            return false;
        }
        // 拼接查询条件
        // 根据任务名称
        if (isset($where['advertiser_user_id']) && $where['advertiser_user_id']) {
            $sql .= sprintf(" AND pt.advertiser_user_id = %d", $where['advertiser_user_id']);
        }


        // 总数
        $sqlCount = str_replace('[*]', 'count(pt.task_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }
        $sql    .= ' ORDER BY pt.task_id DESC';
        $limit  = 10;
        $offset = !empty($where['page']) ? (($where['page'] - 1) * $limit) : 0;

        $sql .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $fields, $sql);

        $_list = $this->getList($_sql);

        $data['total'] = $total;
        $data['list']  = $_list;
        $data['page']  = $where['page'];
        return $data;
    }

    public function getAdvertiserTaskDetailByCondition($where, $fields = "pt.*,ptp.finance_status,ptp.finance_status") {

        $sql = "SELECT [*] FROM `{$this->table}` AS pt LEFT JOIN `platform_task_payment` AS ptp on pt.task_id=ptp.task_id where 1=1 ";

//        if (empty($where['advertiser_user_id'])) {
//            return false;
//        }
        if (empty($where['task_id'])) {
            return false;
        }
        // 拼接查询条件
        // 根据任务名称
        if (isset($where['advertiser_user_id']) && $where['advertiser_user_id']) {
            $sql .= sprintf(" AND pt.advertiser_user_id = %d", $where['advertiser_user_id']);
        }
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND pt.task_id = %d", $where['task_id']);
        }

        $_sql = str_replace('[*]', $fields, $sql);

        return $this->getRow($_sql);

    }


    public function selectAllByCondition($where) {
        if (empty($where)) {
            return false;
        }
        $query = $this->db->get_where($this->getTableName(), $where);
        return $query->result_array();
    }


    public function getCloseData() {
        $time = time();
        $sql  = "SELECT * FROM `{$this->table}` where start_time<$time and release_status=0 and (audit_status=2 or pay_status=0) ";

        return $this->getList($sql);

    }

}
