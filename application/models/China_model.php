<?php

/**
 * Class China_model
 */
class China_model extends MY_Model {

    public $table = 'china';

    public function __construct() {
        parent::__construct();
    }


    public function select_name_by_id($id) {
        //剔除北京上海重庆
        if(($id == 110000) || ($id == 310000) || ($id == 500000)){
            return '';
        }
        $query = $this->db->get_where($this->getTableName(), array('id' => $id));
        $result =  $query->row_array();
        return $result['name'];

    }
    public function select_by_pid($pid){
        if(empty($pid)){
            $pid = 0;
        }
        $query = $this->db->get_where($this->getTableName(), array('pid' => $pid));
        return $query->result_array();
    }


}

