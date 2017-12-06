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

    /**
     * 获得当前的域名
     *
     * @return string
     */
    public static function get_server_address_and_port() {
        /* 协议 */
        $protocol = (isset($_SERVER ['HTTPS']) && (strtolower($_SERVER ['HTTPS']) != 'off')) ? 'https://' : 'http://';
        /* 域名或IP地址 */
        if (isset($_SERVER ['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER ['HTTP_X_FORWARDED_HOST'];
        } elseif (isset($_SERVER ['HTTP_HOST'])) {
            $host = $_SERVER ['HTTP_HOST'];
        } else {
            /* 端口 */
            if (isset($_SERVER ['SERVER_PORT'])) {
                $port = ':' . $_SERVER ['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol)) {
                    $port = '';
                }
            } else {
                $port = '';
            }
            if (isset($_SERVER ['SERVER_NAME'])) {
                $host = $_SERVER ['SERVER_NAME'] . $port;
            } elseif (isset($_SERVER ['SERVER_ADDR'])) {
                $host = $_SERVER ['SERVER_ADDR'] . $port;
            }
        }
        return $protocol . $host;
    }

}