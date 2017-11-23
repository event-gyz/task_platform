<?php

/**
 * Class Platform_task_map_model
 */
class Platform_task_map_model extends MY_Model{

    public $table = 'platform_task_map';

    public function __construct(){
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

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'ptm.task_map_id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS ptm, ( %s ) AS T2 WHERE ptm.task_map_id = T2.task_map_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY ptm.task_map_id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    /**
     * 根据task_map_id或者 task_id和media_man_user_id 修改数据
     * @param array|null $where
     * @param array|null $info
     * @return bool
     */
    //todo 要写脚本修改状态为忽略
    //todo 自媒体人交付任务的时候将map表的deliver_status改为1
    public function updateStatus($where,$info){
        if(!isset($where['task_map_id']) || empty($where['task_map_id'])){
            return false;
        }else if((!isset($where['task_id']) || empty($where['task_id'])) && !isset($where['media_man_user_id']) || empty($where['media_man_user_id'])){
            return false;
        }
        return $this->update($info, $where );
    }

    public function select_by_id($task_map_id) {
        $query = $this->db->get_where($this->getTableName(), array('task_map_id' => $task_map_id));
        return $query->row_array();
    }

    //todo 封装方法匹配自媒体人
    public function insert($data){
        if(!isset($data['task_id']) || empty($data['task_id'])){
            return false;
        }
        if(!isset($data['media_man_user_id']) && empty($data['media_man_user_id'])){
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}

