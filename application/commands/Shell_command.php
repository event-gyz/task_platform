<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 15/11/19
 * Time: 下午12:11
 */

/**
 * Class Shell_command
 *
 * @author zhaochunyang <chunyang_zhao@event.com.cn>
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Shell_command extends CI_Controller {

    public function close_task() {

        $result = $this->__get_task_model()->getCloseData();

        if (empty($result)) {
            return false;
        }

        foreach ($result as $value) {

            $close_reason = '任务付款超时自动关闭。';

            if ($value['audit_status'] == 2) {
                $close_reason = '任务超过修改时间自动关闭。';
            }

            $info['release_status'] = 9;
            $info['close_reason']   = $close_reason;

            $this->__get_task_model()->updateInfo($value['task_id'], $info);
        }

    }

    /**
     * @return Platform_task_model
     */
    private function __get_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }

}
