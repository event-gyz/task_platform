<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public $_salt = 'media';
    public $_model = 'plat_code';

    public function __construct(){
        parent::__construct ();
        $this->load->helper ( array (
            'form',
            'url'
        ) );
        $this->load->library('session');
        $this->load->helper('Wap');
        $this->checkUserLogin();

    }
    // 返回规范
    private $_return = array(
        'errorno' => 0,
        'msg' => '',
        'data' => array()
    );

    private function checkUserLogin(){
        $user_info = $this->__get_user_session();
        if(!$user_info['media_man_id']){
            redirect('/media/login/login');
        }
        if(($user_info['audit_status'] != 1) || ($user_info['status'] != 2)){
            $userInfo = $this->__get_media_man_model()->selectById($user_info['media_man_id']);
            $this->session->set_userdata('user_info',$userInfo);
            if($userInfo['status']==0){
                //跳到完善基础信息页面
//                $this->_return['errorno'] = '2';
//                $this->_return['msg'] = '未完善基础信息';
//                echo json_encode($this->_return);exit;
            }else if($userInfo['audit_status']==0){
                //跳到待审核页面
//                $this->_return['errorno'] = '3';
//                $this->_return['msg'] = '待审核';
//                echo json_encode($this->_return);exit;
            }else if($userInfo['audit_status']==2){
                //跳到驳回页面
//                $this->_return['errorno'] = '4';
//                $this->_return['msg'] = '驳回';
//                //驳回原因
//                $this->_return['data'] = $userInfo['reasons_for_rejection'];
                echo json_encode($this->_return);exit;
            }else if($userInfo['status']==9){
                //跳到冻结页面
//                $this->_return['errorno'] = '9';
//                $this->_return['msg'] = '冻结';
//                //冻结原因
//                $this->_return['data'] = $userInfo['freezing_reason'];
//                echo json_encode($this->_return);exit;
            }else if($userInfo['audit_status']==1 && $userInfo['status']==2){
                    return true;
            }
        }
    }


    public function home() {
        $where  = ['offset' => 0, 'limit' => 1];
        $result = $this->__get_media_man_model()->get_media_man_list_by_condition($where);
        $this->load->view('media/index');
    }



    // 保存自媒体人基础信息
    public function saveBaseInfo() {
        if (empty($_POST)) {
            $this->load->view('media/baseInfo');
        } else {

            if(!isset($_POST ['name']) || empty($_POST ['name'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '名字不能为空';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['sex']) || empty($_POST ['sex'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '性别不能为空';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['zfb_nu']) || empty($_POST ['zfb_nu'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '支付宝账号不能为空';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['zfb_realname']) || empty($_POST ['zfb_realname'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '真实姓名不能为空';
                echo json_encode($this->_return);exit;
            }


            $data = array (
                'media_man_name' => trim($_POST['name']),
                'sex' => (int)($_POST['sex']),
                'zfb_nu' => trim($_POST['zfb_nu']),
                'zfb_realname' => trim($_POST['zfb_realname']),
                'school_name' => trim($_POST['school_name']),
                'school_type' => (int)$_POST['school_type'],
                'school_province' => (int)$_POST['school_province'],
                'school_city' => (int)$_POST['school_city'],
                'school_area' => (int)$_POST['school_area'],
                'school_level' => (int)$_POST['school_level'],
                'age' => (int)($_POST['age']),
                'local' => json_encode($_POST['local']),
                'hobby' => json_encode($_POST['hobby']),
            );

            //通过session获取用户信息
            $userInfo = $this->__get_user_session();
            $re = $this->__get_media_man_model()->updateInfo($userInfo['media_man_id'],$data);
            if ($re) {
//                $userInfo = array_merge($userInfo,$data);
//                $this->session->set_userdata('user_info',$userInfo);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
            }

        }
    }

    // 保存自媒体人账户信息
    public function savePromotedInfo() {
        if (empty($_POST)) {
            $this->load->view('media/promotedInfo');
        } else {

            if((!isset($_POST ['wx_code']) || empty($_POST ['wx_code']) || !isset($_POST ['wx_type']) || empty($_POST ['wx_type']) || !isset($_POST ['wx_max_fans']) || empty($_POST ['wx_max_fans'])) || (!isset($_POST ['weibo_nickname']) || empty($_POST ['weibo_nickname']) || !isset($_POST ['weibo_type']) || empty($_POST ['weibo_type']) || !isset($_POST ['weibo_max_fans']) || empty($_POST ['weibo_max_fans']) || !isset($_POST ['weibo_link']) || empty($_POST ['weibo_link']))){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请至少完善一个推广账号，否则将无法提交审核';
                echo json_encode($this->_return);exit;
            }

            $data = array (
                'wx_code' => trim($_POST['wx_code']),
                'wx_type' => (int)$_POST['wx_type'],
                'wx_max_fans' => (int)$_POST['wx_max_fans'],
                'weibo_nickname' => trim($_POST['weibo_nickname']),
                'weibo_type' => (int)$_POST['weibo_type'],
                'weibo_max_fans' => (int)$_POST['weibo_max_fans'],
                'weibo_link' => trim($_POST['weibo_link']),
                'status' => 1,  //进入后台审核列表
            );

            //通过session获取用户信息
            $userInfo = $this->__get_user_session();
            $re = $this->__get_media_man_model()->updateInfo($userInfo['media_man_id'],$data);
            if ($re) {
//                $userInfo = array_merge($userInfo,$data);
//                $this->session->set_userdata('user_info',$userInfo);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
            }
        }
    }

    // 更新自媒体人
    public function update_sys_user() {
//        $result      = $this->__get_media_man_model()->update_sys_user($sys_user_id, $info);
    }

    // 查询自媒体人
    public function select_by_id() {
        $sys_user_id = 1;
        $result      = $this->__get_media_man_model()->selectById($sys_user_id);
        print_r($result);
    }

    // 任务大厅
    public function getMissionHall(){

        $page = (isset($_POST['page'])&&!empty($_POST['page'])) ? $_POST['page'] : 0;
        $user_info = $this->__get_user_session();
        $media_man_id = $user_info['media_man_id'];

        //超时未领取的任务置为超时
        $this->__get_task_map_model()->updateTimeOutTaskMap($media_man_id);
        $result = $this->__get_task_map_model()->getMissionHall($media_man_id,$page);
        unset($result['sql']);
        foreach($result['list'] as $key => &$value){
            $allot_time = $this->__timediff(strtotime($value['allot_time']));
            if($allot_time){
                $value['allot_time']  = $allot_time;
            }else{
                unset($result['list'][$key]);
            }
        }
        if(is_array($result['list']) && !empty($result['list'])){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '成功';
            $this->_return['data'] = $result;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '暂无分配的任务';
            echo json_encode($this->_return);exit;
        }
    }

    // 任务大厅任务详情
    public function getMissionHallTaskDetail(){
        $map_id = (isset($_POST['map_id'])&&!empty($_POST['map_id'])) ? $_POST['map_id'] : 0;
        $user_info = $this->__get_user_session();
        $media_man_id = $user_info['media_man_id'];

        //超时未领取的任务置为超时
        $this->__get_task_map_model()->updateTimeOutTaskMap($media_man_id);

        $where['map_id'] = $map_id;
        $where['receive_status'] = 0;
        $where['release_status'] = 1;
        $result = $this->__get_task_map_model()->getTaskDetail($media_man_id,$where);
        $result['allot_time'] = $this->__timediff(strtotime($result['allot_time']));
        if(is_array($result) && !empty($result)){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '成功';
            $this->_return['data'] = $result;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '任务已失效';
            echo json_encode($this->_return);exit;
        }
    }

    /**
     * 接受任务
     */
    public function acceptTask(){
        $map_id = (isset($_POST['map_id'])&&!empty($_POST['map_id'])) ? $_POST['map_id'] : 1;
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 1;
        $where['task_map_id'] = $map_id;
        $where['task_id'] = $task_id;
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $where['receive_status'] = 0;
        $info ['receive_status'] = 1;
        $result = $this->__get_task_map_model()->updateStatus($where,$info);
        if(!empty($result)){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '领取成功';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }

    }

    /**
     * 拒绝任务
     */
    public function refuseTask(){
        $map_id = (isset($_POST['map_id'])&&!empty($_POST['map_id'])) ? $_POST['map_id'] : 1;
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 1;
        $where['task_map_id'] = $map_id;
        $where['task_id'] = $task_id;
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $where['receive_status'] = 0;
        $info ['receive_status'] = 2;
        $result = $this->__get_task_map_model()->updateStatus($where,$info);
        if(!empty($result)){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '拒绝成功';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }
    }


    /**
     * 我的列表 （我的资料）
     */
    public function getMediaManInfo(){
        $user_info = $this->__get_user_session();
        $media_man_id = $user_info['media_man_id'];
        $result = $this->__get_media_man_model()->selectById($media_man_id);
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }

    /**
     * 我的列表 （我的消息）
     */
    public function myMessage(){
        $user_info = $this->__get_user_session();
        $where['user_id'] = $user_info['media_man_id'];
        $where['user_type'] = '2';
        $where['message_status'] = '0';
        $result = $this->__get_user_message_model()->get_user_message_list_by_condition($where);
        if(empty($result['total'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '没有新的消息';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }
    /**
     * 我的列表 （我的消息-删除消息）
     */
    public function delMessage(){
        $user_message_id = $_POST['message_id'];
        if(empty($user_message_id)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '非法参数';
            echo json_encode($this->_return);exit;
        }
        $info['message_status'] = '1';
        $result = $this->__get_user_message_model()->update_user_message($user_message_id, $info);
        if($result){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '成功';
            echo json_encode($this->_return);exit;
        }
    }

    /**
     *  我的列表 （我的任务）
     */
    public function myTaskList(){
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $result = $this->__get_task_map_model()->get_media_man_task_list_by_condition($where);
        if(empty($result['total'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '没有已领取的任务';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }

    /**
     *  我的任务详情 （我的任务）
     */
    public function myTaskDetail(){
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $_POST['task_map_id'] = 1;
        if(!isset($_POST['task_map_id']) || empty($_POST['task_map_id'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数错误';
            echo json_encode($this->_return);exit;
        }
        $where['task_map_id'] = $_POST['task_map_id'];
        $result = $this->__get_task_map_model()->get_media_man_task_detail_by_condition($where);
        if(isset($result['total'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '没有待领取任务';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }


    /**
     * 获取剩余时间
     * @param $allot_time
     * @return bool|string
     */
    private function __timediff($allot_time){
        $result = Wap::timediff($allot_time+7200);
        if(!is_array($result) || $result<0){
            //任务已经超时，修改任务状态
            return false;
        }
        return '剩余'.$result['hours'].'小时'.$result['min'].'分';

    }













    private function __get_user_session(){
        $userSession = $this->session->userdata('user_info');
        if(empty($userSession) || !is_array($userSession)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '用户信息有误请重新登录';
            //todo 跳到登录页面
            echo json_encode($this->_return);exit;
        }
        return $userSession;
    }



    /**
     * @return Platform_media_man_model
     */
    private function __get_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }

    /**
     * @return Platform_task_map_model
     */
    private function __get_task_map_model() {
        $this->load->model('Platform_task_map_model');
        return $this->Platform_task_map_model;
    }

    /**
     * @return User_message_model
     */
    private function __get_user_message_model() {
        $this->load->model('User_message_model');
        return $this->User_message_model;
    }









}
