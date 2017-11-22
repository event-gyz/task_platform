<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model {

    protected $db;
    protected $ci;
    protected $table = null;

    public function __construct() {
        $CI = &get_instance();
        $CI->load->database(); // 默认读取database.php里的$active_group
        $this->db = $CI->db;
        $this->ci = $CI;
    }

    /**
     * 执行sql返回总记录数
     *
     * @param $sql
     *
     * @return mixed
     */
    public function getCount($sql) {
        $_query_count = $this->db->query($sql);
        $res          = $_query_count->result_array();
        return $res[0]['c'];
    }

    /**
     * 执行sql返回列表
     *
     * @param $sql
     *
     * @return mixed
     */
    public function getList($sql) {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 返回limit,offset.
     *
     * @param string $key
     * @param        $page_size
     * @param        $page_num
     *
     * @return mixed
     */
    public function get_limit($key = 'limit', $page_size, $page_num) {
        $return = $page_num * $page_size;
        if ($key === 'offset') {
            $return = ($page_num - 1) * $page_size;
        }

        return $return;
    }


    /**
     * 添加数据
     *
     * @param array  $data       插入数据
     * @param string $table_name 表名
     * @param        return      int 成功返回插入id
     */
    public function insert($data) {
        if ($this->db->insert($this->getTableName(), $data) === false) {
            throw new SystemError(SystemError::DB_SQL_FAIL);
        }
        return $this->db->insert_id();
    }


    /**
     * 查询结果集
     *
     * @param string $fields    查询字段
     * @param string $condition 查询条件
     *                          1:array('name' => $name, 'title' => $title, 'status' => $status);
     *                          2:array('name !=' => $name, 'id <' => $id, 'date >' => $date);
     *                          3:"name='Joe' AND status='boss' OR status='active'";
     * @param int    $limit
     * @param int    $offset
     *
     * @return array
     */
    public function fetch($fields = '*', $condition = null, $limit = null, $offset = null) {
        $this->db->select($fields);
        $this->db->where($condition);
        return $this->db->get($this->getTableName(), $limit, $offset);
    }

    /**
     * 查询结果数量
     *
     * @param string $condition 查询条件
     *                          1:array('name' => $name, 'title' => $title, 'status' => $status);
     *                          2:array('name !=' => $name, 'id <' => $id, 'date >' => $date);
     *                          3:"name='Joe' AND status='boss' OR status='active'";
     *
     * @return int
     */
    public function count($condition = null) {
        $this->db->where($condition);
        return $this->db->count_all_results($this->getTableName());
    }

    /**
     * 修改数据
     *
     * @param array $set       更新的数据
     * @param mixed $condition 更新条件
     *                         1:array('name' => $name, 'title' => $title, 'status' => $status);
     *                         2:array('name !=' => $name, 'id <' => $id, 'date >' => $date);
     *                         3:"name='Joe' AND status='boss' OR status='active'";
     *
     * @return bool
     */
    public function update($set = null, $condition = null) {
        $effect = $this->db->update($this->getTableName(), $set, $condition);
        if ($effect === false) {
            throw new SystemError(SystemError::DB_SQL_FAIL);
        }
        return $effect;
    }

    /**
     * 删除数据
     *
     * @param mixed $condition 删除条件
     *                         1:array('name' => $name, 'title' => $title, 'status' => $status);
     *                         2:array('name !=' => $name, 'id <' => $id, 'date >' => $date);
     *                         3:"name='Joe' AND status='boss' OR status='active'";
     *
     * @return mixed
     */
    public function delete($condition = null) {
        return $this->db->delete($this->getTableName(), $condition);
    }

    /**
     * 获取当前Dao的表名,如需分表请在子类重载此方法
     *
     * @return string 数据库表名称
     */
    protected function getTableName() {
        if (is_null($this->table)) throw new RuntimeException('Dao的$_table_name未设置');
        return $this->table;
    }

}
