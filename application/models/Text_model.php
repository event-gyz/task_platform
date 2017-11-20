<?php

/**
 * Class Shop_model
 * shop model
 */
class Text_model extends CI_Model{

    var $table = 'test';

    public function __construct(){
        parent::__construct();
    }

    /**
     * 验证有效店铺id
     * @param $shop_id 店铺id
     * @return bool
     */
    public function test()
    {
        $this->db->select("*");//1、返回一个db类实例化对象 2、将实例化对象作为模型类的db属性
        $this->db->from($this->table);
        $this->db->where("id",1);
        $this->db->order_by("id","desc");
        $query = $this->db->get();
        return $query->result_array();
    }



}

