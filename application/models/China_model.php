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
        // 剔除北京上海重庆
        if (($id == 110000) || ($id == 310000) || ($id == 500000)) {
            return '';
        }
        $query  = $this->db->get_where($this->getTableName(), array('id' => $id));
        $result = $query->row_array();
        return $result['name'];

    }

    public function select_by_pid($pid) {
        if (empty($pid)) {
            $pid = 0;
        }
        $query = $this->db->get_where($this->getTableName(), array('pid' => $pid));
        return $query->result_array();
    }

    public function get_by_pid_arr($pid_arr) {
        if (empty($pid_arr)) {
            return [];
        }
        $id_str = implode(',', array_unique($pid_arr));
        $sql    = "SELECT * FROM `{$this->table}` AS cn WHERE pid IN ( {$id_str} )";
        return $this->getList($sql);
    }

    // 获取封装好的地区列表
    public function get_area_list() {

        $province = $this->get_by_pid_arr([0]);// 省
        $city     = $this->get_by_pid_arr(array_column($province, 'id'));// 市
        $area     = $this->get_by_pid_arr(array_column($city, 'id'));// 区

        $result = [];
        foreach ($province as $k => $v) {

            $tmp = [
                'value'    => $v['id'],
                'label'    => $v['name'],
                'children' => [],
            ];

            foreach ($city as $kk => $vv) {

                if ($v['id'] === $vv['pid']) {

                    $tmp2 = [
                        'value'    => $vv['id'],
                        'label'    => $vv['name'],
                        'children' => [],
                    ];

                    foreach ($area as $kkk => $vvv) {

                        if ($vv['id'] === $vvv['pid']) {

                            $tmp3 = [
                                'value' => $vvv['id'],
                                'label' => $vvv['name'],
                            ];

                            array_push($tmp2['children'], $tmp3);
                        }

                    }

                    array_push($tmp['children'], $tmp2);

                }

            }

            array_push($result, $tmp);

        }

        return $result;

    }

}

