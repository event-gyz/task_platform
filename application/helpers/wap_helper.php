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
     *
     * @return array
     */
    public static function timediff($end_time) {
        $remain = ($end_time) - time();
        if ($remain < 0) {
            return $remain;
        }
        $day = floor($remain / 86400);
        if ($day > 0) {
            $remain -= $day * 86400;
        }
        $hours = floor($remain / 3600);
        if ($hours > 0) {
            $remain -= $hours * 3600;
        };
        $min = floor($remain / 60);
        return ['day' => $day, 'hours' => $hours, 'min' => $min];
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

    // 递归创建多级文件夹
    public static function create_folders($dir) {
        return is_dir($dir) or (self::create_folders(dirname($dir)) and mkdir($dir, 0777));
    }

    // 写入文件完成标识
    public static function write_file_complete_flag($file_path) {

        $dir_name = dirname($file_path);
        if (!is_dir($dir_name)) {
            self::create_folders($dir_name);
        }

        file_put_contents("{$file_path}.json", json_encode(['is_write_complete' => true]));
    }

    // 读取文件完成标识
    public static function read_file_complete_flag($file_path) {

        $json_file_path = "{$file_path}.json";

        if (!is_file($json_file_path)) {
            return false;
        }

        $file_content = file_get_contents($json_file_path);
        if (empty($file_content)) {
            return false;
        }

        $complete_flag = json_decode($file_content, true);
        if (empty($complete_flag)) {
            return false;
        }

        if (!isset($complete_flag['is_write_complete'])) {
            return false;
        }

        return $complete_flag['is_write_complete'] === true ? true : false;
    }

}