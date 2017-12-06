<?php


class wap {
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
        $day = floor($remain/86400);
        if($day>0){
            $remain -= $day*86400;
        }
        $hours = floor($remain/3600);
        if($hours>0){
            $remain -= $hours*3600;
        };
        $min = floor($remain/60);
        return ['day'=>$day,'hours'=>$hours,'min'=>$min];
    }

}