<?php

/**
 * Class Platform_task_model
 */
class Platform_task_model extends MY_Model{

    public $table = 'platform_task';

    public function __construct(){
        parent::__construct();
    }


    public function get_task_list_by_condition($where, $fields = "pt.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS pt where 1=1 ";

        // 拼接查询条件
        // 根据任务名称
        if (isset($where['title']) && $where['title']) {
            $sql .= sprintf(" AND pt.title like '%s%%'", $where['title']);
        }
        // 根据任务类型
        if (isset($where['task_type']) && $where['task_type']) {
            $sql .= sprintf(" AND pt.task_type = %d", $where['task_type']);
        }
        // 根据任务状态
        if (isset($where['release_status']) && $where['release_status']) {
            $sql .= sprintf(" AND pt.release_status = %d", $where['release_status']);
        }
        // 根据审核状态
        if (isset($where['audit_status']) && $where['audit_status']) {
            $sql .= sprintf(" AND pt.audit_status = %d", $where['audit_status']);
        }
        // 根据发布平台
        if (isset($where['publishing_platform']) && $where['publishing_platform']) {
            $sql .= sprintf(" AND pt.status = %d", $where['publishing_platform']);
        }
        // 根据任务提交开始时间
        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND pt.create_time >= '%s'", $where['start_time']);
        }
        // 根据任务提交结束时间
        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND pt.create_time <= '%s'", $where['end_time']);
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

        $get_id_sql = str_replace('[*]', 'pt.task_id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS pt, ( %s ) AS T2 WHERE pt.task_id = T2.task_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY pt.task_id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }


    public function updateInfo($task_id,$info){
        $where = array('task_id'=>$task_id);
        return $this->update($info, $where );
    }

    public function selectById($task_id) {
        if(empty($task_id)){
            return false;
        }
        $query = $this->db->get_where($this->getTableName(), array('task_id' => $task_id));
        return $query->row_array();
    }

    public function selectByCondition($where) {
        if(empty($where)){
            return false;
        }
        $query = $this->db->get_where($this->getTableName(), $where);
        return $query->row_array();
    }

    public function insert($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

