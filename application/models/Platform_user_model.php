<?php

/**
 * Class Platform_user_model
 */
class Platform_user_model extends CI_Model{

    var $_table = 'platform_user';

    public function __construct(){
        parent::__construct();
    }


    public function select($where,$offset=20,$limit=0){
        $where['id >'] = '0';
        $total = $this->count($where);
        $query = $this->db->from($this->_table);
        if(!empty($where['shop_ids'])){
            $query->where_in('id',$where['shop_ids']);
            unset($where['shop_ids']);
        }

        if(!empty($where['shop_name'])){
            $query->like('shop_name',$where['shop_name']);
            unset($where['shop_name']);
        }

        $data = $query->where($where)->limit($offset,$limit)->order_by('id desc')->get()->result_array();
        $data['total'] = $total;
        return $data;
    }
    public function count($where){
        $where['id >'] = '0';
        $query = $this->db->from($this->_table);
        if(!empty($where['shop_ids'])){
            $query->where_in('id',$where['shop_ids']);
            unset($where['shop_ids']);
        }

        if(!empty($where['shop_name'])){
            $query->like('shop_name',$where['shop_name']);
            unset($where['shop_name']);
        }

        return $query->where($where)->count_all_results();
    }

    public function update($place_id,$info){
        $info['update_time'] = date('Y-m-d H:i:s',time());
        $where = array('place_id'=>$place_id);
        return $this->update($info,$where);
    }

    public function select_by_id($place_id) {
        $query = $this->db->get_where($this->getTableName(), array('place_id' => $place_id));
        return $query->row_array();
    }

    public function insert($data)
    {
        $data['create_time'] = date("Y-m-d H:i:s",time());
        if ($this->db->insert($this->_table, $data) === false) {
            throw new SystemError(SystemError::DB_SQL_FAIL);
        }
        return $this->db->insert_id();
    }

}

