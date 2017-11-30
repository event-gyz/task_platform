<?php


class Wap {
    protected $CI;
    const SALT = 'plat';
    public function __construct() {
        $this->CI =& get_instance();
    }

    public static function generate_wap_user_password($password) {
        $toBeEncrypt = self::SALT . md5($password);
        return md5($toBeEncrypt);
    }

    /**
     * 获取剩余时间
     *
     * @param int $begin_time
     * @param int $end_time
     * @return array
     */
    public static function timediff($end_time){
        $remain = ($end_time) - time();
        if($remain < 0 ){
            return $remain;
        }
//        return '剩余'.floor(($remain/3600)).'小时'.floor($remain/60).'分';
        return ['hours'=>floor(($remain/3600)),'min'=>floor($remain/60)];
    }

}