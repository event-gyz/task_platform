<?php

/**
 * Class Platform_task_model
 */
class Platform_task_model extends MY_Model{

    var $_table = 'platform_task';

    public function __construct(){
        parent::__construct();
    }


    public function get_task_list_by_condition($where) {

        $param = "pt.*";

        $sql = "SELECT [*] FROM `{$this->_table}` AS pt where 1=1 ";


        // 拼接查询条件
        // 根据任务名称
        if (isset($where['title']) && $where['title']) {
            $sql .= sprintf(" AND pt.title = '%d'", $where['title']);
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
            $sql .= sprintf(" AND pt.create_time >= '%d'", $where['start_time']);
        }
        // 根据任务提交结束时间
        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND pt.create_time <= '%d'", $where['end_time']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(pt.task_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        $offset = $where['offset'] ? $where['offset'] : 0;
        $limit  = $where['limit'] ? $where['limit'] : 10;

        $sql .= ' ORDER BY pt.task_id DESC';
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


    public function update($task_id,$info){
        $where = array('task_id'=>$task_id);
        return $this->update($info,$where);
    }

    public function select_by_id($task_id) {
        $query = $this->db->get_where($this->getTableName(), array('task_id' => $task_id));
        return $query->row_array();
    }

    public function insert($data){
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

}

