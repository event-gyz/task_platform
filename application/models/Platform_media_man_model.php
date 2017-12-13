<?php

/**
 * Class Platform_media_man_model
 */
class Platform_media_man_model extends MY_Model {

    public $table = 'platform_media_man';

    public function __construct() {
        parent::__construct();
    }

    public function get_media_man_list_by_condition($where, $fields = "mm.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS mm where 1=1 ";

        // 拼接查询条件

        // 根据自媒体人电话
        if (isset($where['media_man_phone']) && $where['media_man_phone']) {
            $sql .= sprintf(" AND mm.media_man_phone like '%s%%'", $where['media_man_phone']);
        }

        // 根据自媒体人登录名
        if (isset($where['media_man_login_name']) && $where['media_man_login_name']) {
            $sql .= sprintf(" AND mm.media_man_login_name like '%s%%'", $where['media_man_login_name']);
        }

        // 根据自媒体人姓名
        if (isset($where['media_man_name']) && $where['media_man_name']) {
            $sql .= sprintf(" AND mm.media_man_name like '%s%%'", $where['media_man_name']);
        }

        // 根据自媒体人审核状态
        if (isset($where['audit_status']) && $where['audit_status'] !== '') {
            $sql .= sprintf(" AND mm.audit_status = %d", $where['audit_status']);
        }

        // 根据自媒体人行吧
        if (isset($where['sex']) && $where['sex']) {
            $sql .= sprintf(" AND mm.sex = %d", $where['sex']);
        }

        // 根据自媒体人账户状态
        if (isset($where['status']) && $where['status'] !== '') {
            $sql .= sprintf(" AND mm.status = %d", $where['status']);
        }

        // 根据自媒体人学校名称
        if (isset($where['school_name']) && $where['school_name']) {
            $sql .= sprintf(" AND mm.school_name like '%s%%'", $where['school_name']);
        }

        // 根据自媒体人创建开始时间
        if (isset($where['start_time']) && $where['start_time']) {
            $sql .= sprintf(" AND mm.create_time >= '%s'", $where['start_time']);
        }

        // 根据自媒体人创建结束时间
        if (isset($where['end_time']) && $where['end_time']) {
            $sql .= sprintf(" AND mm.create_time <= '%s'", $where['end_time']);
        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(mm.media_man_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        $sql .= ' ORDER BY mm.media_man_id DESC';

        $offset = isset($where['offset']) ? $where['offset'] : 0;
        $limit  = isset($where['limit']) ? $where['limit'] : 10;
        $sql    .= sprintf(" LIMIT %d,%d", $offset, $limit);

        $get_id_sql = str_replace('[*]', 'mm.media_man_id', $sql);
        $final_sql  = sprintf("SELECT [*] FROM `%s` AS mm, ( %s ) AS T2 WHERE mm.media_man_id = T2.media_man_id", $this->table, $get_id_sql);
        $final_sql  .= ' ORDER BY mm.media_man_id DESC';
        $_sql       = str_replace('[*]', $fields, $final_sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    // 根据任务要求获取符合条件的自媒体人帐号
    public function get_media_man_list_by_task_require($where, $fields = "mm.*") {

        $sql = "SELECT [*] FROM `{$this->table}` AS mm where 1=1 ";

        // 拼接查询条件

        // 性别要求
        if (isset($where['require_sex']) && $where['require_sex']) {
            $sql .= sprintf(" AND mm.sex = %d ", $where['require_sex']);
        }

        // 自媒体人年龄要求
        if (isset($where['require_age']) && $where['require_age']) {
            $sql .= sprintf(" AND mm.age IN (%s) ", $where['require_age']);
        }

        // 自媒体人地域要求
        if (isset($where['require_local']) && $where['require_local']) {
            $sql .= sprintf(" AND mm.school_province IN (%s) ", $where['require_local']);
        }

        // 行业要求
        if (isset($where['require_industry']) && $where['require_industry']) {
            $sql .= sprintf(" AND mm.industry IN (%s) ", $where['require_industry']);
        }

        // 自媒体人爱好要求
        if (isset($where['require_hobby']) && $where['require_hobby']) {

            $require_hobby_arr = explode(',', $where['require_hobby']);

            $tmp = 'AND ( ';

            if (!empty($require_hobby_arr)) {

                foreach ($require_hobby_arr as $v) {
                    $tmp .= sprintf(" OR mm.hobby LIKE '%%%s%%' ", $v);
                    // todo 去除or
                }

            }

            $tmp .= ' ) ';

            $sql .= $tmp;

        }

        // 总数
        $sqlCount = str_replace('[*]', 'count(mm.media_man_id) AS c', $sql);
        $total    = $this->getCount($sqlCount);

        if ($total === '0') {
            return ['total' => $total, 'list' => []];
        }

        if (isset($where['order_by']) && $where['order_by']) {

            switch ($where['order_by']) {
                case 'wx_max_fans':
                    $sql .= ' ORDER BY mm.wx_max_fans DESC , mm.create_time ASC ';
                    break;
                case 'weibo_max_fans':
                    $sql .= ' ORDER BY mm.weibo_max_fans DESC , mm.create_time ASC ';
                    break;
                case 'wx_or_weibo_max_fans':
                    $sql .= ' ORDER BY (mm.weibo_max_fans + mm.wx_max_fans) DESC , mm.create_time ASC ';
                    break;
                default:
                    break;
            }

            $sql .= sprintf(" LIMIT %d,%d", 0, $where['limit']);

        }

        $_sql = str_replace('[*]', $fields, $sql);

        $_list = $this->getList($_sql);

        $data = ['sql' => $_sql, 'total' => $total, 'list' => $_list];
        return $data;
    }

    public function updateInfo($media_man_id, $info) {
        $where = array('media_man_id' => $media_man_id);
        return $this->update($info, $where);
    }

    public function updateInfoByPhone($phone, $info) {
        $where = array('media_man_phone' => $phone);
        return $this->update($info, $where);
    }

    public function selectById($media_man_id) {
        $query = $this->db->get_where($this->getTableName(), array('media_man_id' => $media_man_id));
        return $query->row_array();
    }

    public function selectByLoginName($login_name) {
        $query  = $this->db->get_where($this->getTableName(), array('media_man_login_name' => $login_name));
        $result = $query->row_array();
        return $result;

    }

    public function selectByUserName($login_name) {
        $query  = $this->db->get_where($this->getTableName(), array('media_man_login_name' => $login_name));
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            $query = $this->db->get_where($this->getTableName(), array('media_man_phone' => $login_name));
            return $query->row_array();
        }
    }

    public function selectByPhone($phone) {
        $query = $this->db->get_where($this->getTableName(), array('media_man_phone' => $phone));
        return $query->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function getUseMediaMan() {
        $where['status'] = 2;
        $query           = $this->db->get_where($this->getTableName(), $where);
        return $query->result_array();
    }
}

