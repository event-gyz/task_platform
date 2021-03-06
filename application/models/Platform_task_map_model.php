<?php

/**
 * Class Platform_task_map_model
 */
class Platform_task_map_model extends MY_Model {

    public $table = 'platform_task_map';

    public function __construct() {
        parent::__construct();
    }

    public function get_task_map_list_by_condition($where, $fields = "ptm.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS ptm where 1=1 ";

        // 拼接查询条件

        // 根据任务id
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND ptm.task_id = %d", $where['task_id']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptm.task_map_id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'ptm.task_map_id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS ptm, ( %s ) AS T2 WHERE ptm.task_map_id = T2.task_map_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY ptm.task_map_id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $this->__deal_list($_list)];
        return $data;
    }

    // 根据task_id查询所有任务交付记录
    public function get_task_map_list_by_task_id($task_id) {
        $this->db->from("`{$this->getTableName()}` AS ptm");
        $this->db->where(
            array(
                'ptm.task_id' => $task_id,
            )
        );
        $query = $this->db->get();
        $list  = $query->result_array();

        if (!empty($list)) {
            $list = $this->__deal_list($list);
        }
        return $list;
    }

    // 处理任务交付列表数据,交付状态,领取/拒绝时间,完成时间
    private function __deal_list($list) {

        $result = [];
        foreach ($list as $k => $info) {

            $status       = '';// 交付状态
            $receive_time = '';// 领取/拒绝时间
            $deliver_time = '';// 完成时间

            // 待领取：当系统将任务发送给自媒体人时，状态显示待领取，发送时间显示具体的发送时间。
            // 已领取：当自媒体人在wap端操作领取时，则状态显示为已领取，领取/拒绝时间显示操作领取的具体时间。
            // 超时：当自媒体人超过任务领取时间时，则状态显示为超时。
            // 已拒绝：当自媒体人在wap端操作拒绝时，则状态显示为已拒绝，领取/拒绝时间显示操作拒绝的具体时间。
            // 待结果确认：当自媒体人在wap端交付了任务时，则状态变更为待结果确认。
            // 已完成：当自媒体人交付的结果审核通过时，则状态变更为已完成，完成时间显示操作通过的具体时间。
            // 审核驳回：当自媒体人交付的结果审核不通过时，则状态变更为审核驳回，完成时间显示操作驳回的具体时间，当审核结果二次提交审核后，则状态变更为待审核(待结果确认)。

            if ($info['receive_status'] === "0") {
                $status = '待领取';
            }

            if ($info['receive_status'] === "1") {
                $status       = '已领取';
                $receive_time = $info['receive_time'];
            }

            if ($info['receive_status'] === "3") {
                $status = '超时';
            }

            if ($info['receive_status'] === "2") {
                $status       = '已拒绝';
                $receive_time = $info['receive_time'];
            }

            if (
                ($info['receive_status'] === "1") &&
                ($info['deliver_status'] === "1") &&
                ($info['deliver_audit_status'] === "0")
            ) {
                $status       = '待结果确认';
                $receive_time = $info['receive_time'];
            }

            if (
                ($info['receive_status'] === "1") &&
                ($info['deliver_status'] === "1") &&
                ($info['deliver_audit_status'] === "1")
            ) {
                $status       = '已完成';
                $receive_time = $info['receive_time'];
                $deliver_time = $info['update_time'];
            }

            if (
                ($info['receive_status'] === "1") &&
                ($info['deliver_status'] === "1") &&
                ($info['deliver_audit_status'] === "2")
            ) {
                $status       = '审核驳回';
                $receive_time = $info['receive_time'];
                $deliver_time = $info['update_time'];
            }

            $info['status']       = $status;
            $info['receive_time'] = $receive_time;
            $info['deliver_time'] = $deliver_time;

            $result[] = $info;

        }

        return $result;
    }

    /**
     * 自媒体人我的任务列表(已接受的任务)
     *
     * @param $where
     *
     * @return array
     */
    public function get_media_man_task_list_by_condition($where) {
        $data = [];
        if (!isset($where['media_man_user_id']) || empty($where['media_man_user_id'])) {
            return ['total' => 0, 'list' => []];
        }
        $param                  = "pt.*,pmm.*,ptr.platform_pay_money,ptr.platform_pay_way,ptr.finance_status,ptr.pay_time,ptm.task_map_id,ptm.receive_status,ptm.deliver_status,ptm.deliver_audit_status,ptm.receivables_status";
        $task_table             = 'platform_task';
        $task_receivables_table = 'platform_task_receivables';
        $media_man_table        = 'platform_media_man';
        $sql                    = "SELECT [*] FROM `{$this->table}` AS ptm LEFT JOIN `{$task_receivables_table}` AS ptr on ptr.task_map_id=ptm.task_map_id LEFT JOIN `{$task_table}` AS pt ON pt.task_id=ptm.task_id LEFT JOIN `{$media_man_table}` AS pmm on pmm.media_man_id=ptm.media_man_user_id where 1=1 ";

        // 拼接查询条件
        // 根据用户名
        if (isset($where['media_man_user_id']) && $where['media_man_user_id']) {
            $sql .= sprintf(" AND ptm.media_man_user_id = %d", $where['media_man_user_id']);
        }

        //根据finance_status
        if (isset($where['finance_status']) && $where['finance_status']) {
            $notInComeSql  = $sql;
            $moneyCountSql = $sql;
            $sql           .= sprintf(" AND ptr.finance_status = %d", $where['finance_status']);
            $sql           .= sprintf(" AND ptm.receive_status = %d", 1);

            $moneyCountSql .= sprintf(" AND ptm.receivables_status = %d", 1);
            //超时
            $notInComeSql .= sprintf(" AND ptm.receive_status = %d", 3);

            $moneyCount          = str_replace('[*]', 'sum(pt.platform_price) AS c', $moneyCountSql);
            $notInComeMoneyCount = str_replace('[*]', 'sum(pt.platform_price) AS c', $notInComeSql);
//            错过
            $data['notInComeMoneyTotal'] = $this->getCount($notInComeMoneyCount);
//            总收入
            $data['moneyTotal'] = $this->getCount($moneyCount);
        }
        $sql .= ' and (ptm.receive_status=1 or ptm.receive_status=2)';
        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);

        $total = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptm.task_map_id DESC';

        $limit  = 10;
        $offset = (isset($where['page']) && !empty($where['page'])) ? (($where['page'] - 1) * $limit) : 0;

        $sql .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);
//        echo $_sql;
        $data['total'] = $total;
        $data['list']  = $_list;
        $data['page']  = (isset($where['page']) && !empty($where['page'])) ? $where['page'] : 1;
        return $data;
    }

    /**
     * 自媒体人我的任务详情(已接受的任务)
     *
     * @param $where
     *
     * @return array
     */
    public function getMediaManTaskDetailByCondition($where) {

        $param                  = "pt.*,ptm.*,ptr.platform_pay_money,ptr.platform_pay_way,ptr.finance_status,ptr.pay_time,ptm.reasons_for_rejection as tm_reasons_for_rejection";
        $task_table             = 'platform_task';
        $task_receivables_table = 'platform_task_receivables';
        $sql                    = "SELECT [*] FROM `{$this->table}` AS ptm  LEFT JOIN `{$task_table}` AS pt ON pt.task_id=ptm.task_id LEFT JOIN `{$task_receivables_table}` AS ptr on ptr.task_map_id=ptm.task_map_id where 1=1 ";

        // 拼接查询条件
        // 根据用户id
        if (isset($where['media_man_user_id']) && $where['media_man_user_id']) {
            $sql .= sprintf(" AND ptm.media_man_user_id = %d", $where['media_man_user_id']);
        }
        //根据map_id
        if (isset($where['task_map_id']) && $where['task_map_id']) {
            $sql .= sprintf(" AND ptm.task_map_id = %d", $where['task_map_id']);
        }
        //根据task_id
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND ptm.task_id = %d", $where['task_id']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);
        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $_sql = str_replace('[*]', $param, $sql);
//        echo $_sql;exit;
        return $this->getRow($_sql);
    }

    /**
     * 根据task_map_id或者 task_id和media_man_user_id 修改数据
     *
     * @param array|null $where
     * @param array|null $info
     *
     * @return bool
     */
    //todo 要写脚本修改状态为忽略
    //todo 自媒体人交付任务的时候将map表的deliver_status改为1
    public function updateMapInfo($where, $info) {
        if ((!isset($where['task_id']) || empty($where['task_id'])) && !isset($where['media_man_user_id']) || empty($where['media_man_user_id'])) {
            return false;
        }
        return $this->update($info, $where);
    }

    public function selectById($task_map_id) {
        $query  = $this->db->get_where($this->getTableName(), array('task_map_id' => $task_map_id));
        $result = $query->row_array();
        if (!empty($result)) {
            $list   = $this->__deal_list([$result]);
            $result = $list[0];
        }
        return $result;
    }

    //todo 封装方法匹配自媒体人
    public function insert($data) {
        if (!isset($data['task_id']) || empty($data['task_id'])) {
            return false;
        }
        if (!isset($data['media_man_user_id']) && empty($data['media_man_user_id'])) {
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    //超过两个小时未领取的任务全部置为超时
    public function updateTimeOutTaskMap() {
        $new_time = date('Y-m-d H:i:s', (time() - 7200));
        $where    = ['allocation_time<' => $new_time, 'receive_status' => '0'];
        $query = $this->db->get_where($this->getTableName(), $where);
        $total_num = $query->num_rows();
        if($total_num>0){
            return $this->update(['receive_status' => 3], $where);
        }else{
            return true;
        }

    }

    //未领取的有效的任务列表
    public function getMissionHall($media_man_id, $page) {
        if (empty($media_man_id)) {
            return false;
        }
        $param = "pt.task_name,pt.title,pt.task_id,pt.task_type,pt.platform_price,pt.publishing_platform,pt.start_time,pt.end_time,ptm.create_time as allot_time";
        $sql   = "SELECT [*] FROM `{$this->table}` AS ptm LEFT JOIN platform_task as pt ON ptm.task_id=pt.task_id where 1=1 ";

        // 拼接查询条件

        // 根据media_man_id
        $sql .= sprintf(" AND ptm.media_man_user_id = %d", $media_man_id);

        $sql .= sprintf(" AND ptm.receive_status = %d", 0);
        $sql .= sprintf(" AND pt.release_status = %d", 1);

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY ptm.task_map_id DESC';

        $limit  = 10;
        $offset = !empty($page) ? (($page - 1) * $limit) : 0;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $_sql = str_replace('[*]', $param, $sql);

        $_list = $this->getList($_sql);
        $data  = ['sql' => $_sql, 'total' => $total, 'page' => $page, 'list' => $_list];
        return $data;
    }

    //未领取的任务详情
    //todo 增加广告主关闭判断
    public function getUnclaimedTaskDetail($media_man_id, $where) {
        if (empty($media_man_id)) {
            return false;
        }
        $param = "pt.*,ptm.create_time as allot_time,ptm.task_map_id";
        $sql   = "SELECT [*] FROM `{$this->table}` AS ptm LEFT JOIN platform_task as pt ON ptm.task_id=pt.task_id where 1=1 ";

        // 拼接查询条件

        // 根据media_man_id
        $sql .= sprintf(" AND ptm.media_man_user_id = %d", $media_man_id);
        if (isset($where['task_id']) && $where['task_id']) {
            $sql .= sprintf(" AND ptm.task_id = %d", $where['task_id']);
        }
        if (isset($where['receive_status'])) {
            $sql .= sprintf(" AND ptm.receive_status = %d", $where['receive_status']);
        }
        if (isset($where['release_status']) && $where['release_status']) {
            $sql .= sprintf(" AND pt.release_status = %d", $where['release_status']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(ptm.task_map_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return false;
        }

        $_sql = str_replace('[*]', $param, $sql);

        return $this->getRow($_sql);
    }

    public function getRoweceiveTaskCount($task_id) {
        $sqlCount = "select count(task_map_id) as c from `{$this->table}` where task_id=$task_id and receive_status=1";
        $total    = $this->getCount($sqlCount);
        return $total;
    }

    // 根据主键更新map信息
    public function updateInfo($task_map_id, $info) {
        $where = array('task_map_id' => $task_map_id);
        return $this->update($info, $where);
    }

    /**
     * 插入数据到platform_task_map
     *
     * @param $task_id
     * @param $list
     *
     * @return bool
     */
    public function do_sys_auto_release($task_id, $list) {

        if (empty($list)) {
            return false;
        }

        // INSERT INTO `task_platform`.`platform_task_map` ( `media_man_user_id`, `media_man_user_name`, `media_man_name`, `task_id`,`receive_time`,`allocation_time`) values ( '1', '高规格', '高规格1', '2','0000-00-00 00:00:00','2017-12-13 21:34:06')

        $sql = 'INSERT INTO `task_platform`.`platform_task_map` ( `media_man_user_id`, `media_man_user_name`, `media_man_name`, `task_id`, `receive_time`, `allocation_time`)  VALUES ';
        foreach ($list as $k => $v) {
            $cur_time = date('Y-m-d H:i:s');
            $sql      .= "( '{$v['media_man_id']}', '{$v['media_man_login_name']}', '{$v['media_man_name']}', '{$task_id}', '0000-00-00 00:00:00', '{$cur_time}'),";
        }

        $sql = rtrim($sql, ',');

        return $this->db->query($sql);

    }

}

