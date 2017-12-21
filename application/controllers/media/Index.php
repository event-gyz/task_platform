<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public $_user_info = 'user_info';

    public function __construct(){
        parent::__construct ();
        $this->load->library('session');
        $this->load->helper(array('url', 'wap'));
        if(!strpos($_SERVER["REQUEST_URI"],'home') && !strpos($_SERVER["REQUEST_URI"],'my') && !strpos($_SERVER["REQUEST_URI"],'saveBaseInfo') && !strpos($_SERVER["REQUEST_URI"],'my') && !strpos($_SERVER["REQUEST_URI"],'savePromotedInfo') && !strpos($_SERVER["REQUEST_URI"],'userInfoApi')){
            $this->checkUserLogin();
        }


    }
    // 返回规范
    private $_return = array(
        'errorno' => 0,
        'msg' => '',
        'data' => array()
    );

    private function checkUserLogin(){
        $user_info = $this->__get_user_session();
        if(empty($user_info['media_man_id'])){
            redirect(wap::get_server_address_and_port().'/media/login/login');
        }
        if(($user_info['audit_status'] != 1) || ($user_info['status'] != 2)){
            $userInfo = $this->__get_media_man_model()->selectById($user_info['media_man_id']);
            $this->session->set_userdata($this->_user_info,$userInfo);
            if($userInfo['status']==0){
                //跳到完善基础信息页面
                redirect(wap::get_server_address_and_port().'/media/login/accountStatus2');
            }else if($userInfo['audit_status']==0){
                //跳到待审核页面
                redirect(wap::get_server_address_and_port().'/media/login/accountStatus3');
            }else if($userInfo['audit_status']==2){
                //跳到驳回页面
                redirect(wap::get_server_address_and_port().'/media/login/accountStatus4');
            }else if($userInfo['status']==9){
                //跳到冻结页面
                redirect(wap::get_server_address_and_port().'/media/login/accountStatus5');
            }else if($userInfo['audit_status']==1 && $userInfo['status']==2){
                return true;
            }
        }
    }


    public function my(){
        $result = [];
        $this->load->view('media/my/index',$result);
    }

    public function home() {
        $where  = ['offset' => 0, 'limit' => 1];
        $result = $this->__get_media_man_model()->get_media_man_list_by_condition($where);
        $this->load->view('media/index');
    }

    public function joinButton(){
        redirect(wap::get_server_address_and_port().'/media/index/getMissionHallView');
    }
    // 保存自媒体人基础信息
    public function saveBaseInfo() {
        if (empty($_POST)) {
            $this->load->view('media/base');
        } else {
            if(!isset($_POST ['name']) || empty($_POST ['name'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写姓名';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['sex']) || empty($_POST ['sex'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请选择性别';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['zfbNumber']) || empty($_POST ['zfbNumber'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写支付宝账号';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['zfbName']) || empty($_POST ['zfbName'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写真实姓名';
                echo json_encode($this->_return);exit;
            }


            $data = array (
                'media_man_name' => trim($_POST['name']),
                'sex' => (int)($_POST['sex']),
                'zfb_nu' => trim($_POST['zfbNumber']),
                'zfb_realname' => trim($_POST['zfbName']),
                'school_name' => trim($_POST['schoolName']),
                'school_type' => (int)$_POST['schoolType'],
                'school_level' => (int)$_POST['schoolLevel'],
                'age' => (int)$_POST['age'],
                'industry' => (int)$_POST['industry'],
                'hobby' => implode(',',$_POST['liking']),
            );
            $schoolAddress = explode(',',$_POST['schoolAddress']);
            $data['school_province'] = $schoolAddress[0];
            $data['school_city'] = $schoolAddress[1];
            $data['school_area'] = $schoolAddress[2];
            //通过session获取用户信息
            $userInfo = $this->__get_user_session();
            $re = $this->__get_media_man_model()->updateInfo($userInfo['media_man_id'],$data);
            if ($re) {
                $userInfo = array_merge($userInfo,$data);
                $this->session->set_userdata($this->_user_info,$userInfo);
                $this->__saveLog($userInfo['media_man_id'],11,'保存自媒体人基础信息',$userInfo,$data);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
            }else{
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
//                $this->_return['errorno'] = '-1';
//                $this->_return['msg'] = '请修改信息后再提交';
//                echo json_encode($this->_return);
//                exit;
            }

        }
    }

    // 保存自媒体人账户信息
    public function savePromotedInfo() {
        if (empty($_POST)) {
            $this->load->view('media/account');
        } else {

            if((!isset($_POST ['wx_code']) || empty($_POST ['wx_code']) || !isset($_POST ['wx_type']) || empty($_POST ['wx_type']) || !isset($_POST ['wx_max_fans']) || empty($_POST ['wx_max_fans']))
                && (!isset($_POST ['weibo_nickname']) || empty($_POST ['weibo_nickname']) || !isset($_POST ['weibo_type']) || empty($_POST ['weibo_type']) || !isset($_POST ['weibo_max_fans']) || empty($_POST ['weibo_max_fans']) || !isset($_POST ['weibo_link']) || empty($_POST ['weibo_link']))
            ){
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
                'audit_status' => 0,  //进入后台审核列表
            );

            $userInfo = $this->__get_user_session();
            $re = $this->__get_media_man_model()->updateInfo($userInfo['media_man_id'],$data);
            if ($re) {
                $userInfo = array_merge($userInfo,$data);
                $this->session->set_userdata($this->_user_info,$userInfo);
                $this->__saveLog($userInfo['media_man_id'],11,'保存自媒体人账户信息',$userInfo,$data);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
            }
        }
    }


    public function getMissionHallView(){
        $this->load->view('media/task_list');
    }
    /**
     * 任务大厅
     */
    public function getMissionHall(){

        $page = (isset($_POST['page'])&&!empty($_POST['page'])) ? $_POST['page'] : 1;
        $user_info = $this->__get_user_session();
        $media_man_id = $user_info['media_man_id'];

        //超时未领取的任务置为超时
        $this->__get_task_map_model()->updateTimeOutTaskMap($media_man_id);
        $result = $this->__get_task_map_model()->getMissionHall($media_man_id,$page);
        unset($result['sql']);
        foreach($result['list'] as $key => &$value){
            $allot_time = $this->__timediff(strtotime($value['allot_time']),7200);
            if($allot_time){
                $value['allot_time']  = $allot_time;
            }
        }
        if(is_array($result['list']) && !empty($result['list'])){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '成功';
            $this->_return['data'] = $result;
            echo json_encode($this->_return);exit;
        }
        if($result['total']>0 && empty($result['list'])){
            $this->_return['errorno'] = -2;
            $this->_return['msg'] = '没有数据了';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '暂时没有可以领取的任务';
            echo json_encode($this->_return);exit;
        }

    }

    //
    /**
     * 任务大厅任务详情
     */
    public function getMissionHallTaskDetail(){
        $task_id = (isset($_GET['task_id'])&&!empty($_GET['task_id'])) ? $_GET['task_id'] : 0;
        $user_info = $this->__get_user_session();
        $media_man_id = $user_info['media_man_id'];

        //超时未领取的任务置为超时
        $this->__get_task_map_model()->updateTimeOutTaskMap($media_man_id);

        $where['task_id'] = $task_id;
        $where['receive_status'] = 0;
        $where['release_status'] = 1;
        $result = $this->__get_task_map_model()->getUnclaimedTaskDetail($media_man_id,$where);
        if(empty($result)){
            $result = ['flag'=>2];
        }else{
            if($result['media_man_require'] == 1){
                $hobbyConfig = $this->config->item('hobby');
                $industryConfig = $this->config->item('industry');
                $ageConfig = $this->config->item('age');

                $result['require_age'] = $this->__handleNuToName($result['require_age'],$ageConfig);
                $result['require_industry'] = $this->__handleNuToName($result['require_industry'],$industryConfig);
                $result['require_hobby'] = $this->__handleNuToName($result['require_hobby'],$hobbyConfig);
            }
            $completionCriteriaConfig = $this->config->item('task_completion_criteria');
            $publishingPlatformConfig = $this->config->item('publishing_platform');
            $result['publishing_platform'] = $this->__handleNuToName($result['publishing_platform'],$publishingPlatformConfig);
            $result['completion_criteria'] = $this->__handleNuToName($result['completion_criteria'],$completionCriteriaConfig);
            $result['surplus_time'] = $this->__timediff(strtotime($result['allot_time']),7200);

        }
        $this->load->view('/media/task_info',$result);
    }

    /**
     * 任务大厅 接受任务
     */
    public function acceptTask(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 1;
        $where['task_id'] = $task_id;
        $userInfo = $this->__get_user_session();
        $where['media_man_user_id'] = $userInfo['media_man_id'];
        $where['receive_status'] = 0;
        $info ['receive_status'] = 1;
        $info ['receive_time'] = date('Y-m-d H:i:s');
        //todo 领取之前判断一下任务状态
        $result = $this->__get_task_map_model()->updateMapInfo($where,$info);
        if(!empty($result)){
            $this->__saveLog($task_id,6,'接受任务','','');
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
     * 任务大厅 拒绝任务
     */
    public function refuseTask(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 1;
        $where['task_id'] = $task_id;
        $userInfo = $this->__get_user_session();
        $where['media_man_user_id'] = $userInfo['media_man_id'];
        $where['receive_status'] = 0;
        $info ['receive_status'] = 2;
        $result = $this->__get_task_map_model()->updateMapInfo($where,$info);
        if(!empty($result)){
            $this->__saveLog($task_id,7,'拒绝任务','','');
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
        $hobbyConfig = $this->config->item('hobby');
        $industryConfig = $this->config->item('industry');
        $ageConfig = $this->config->item('age');
        $schoolLevelConfig = $this->config->item('school_level');
        $result['school_province'] = $this->__get_china_model()->select_name_by_id($result['school_province']);
        $result['school_city'] = $this->__get_china_model()->select_name_by_id($result['school_city']);
        $result['school_area'] = $this->__get_china_model()->select_name_by_id($result['school_area']);
        $result['school_level'] = $this->__handleNuToName($result['school_level'],$schoolLevelConfig);
        $result['industry'] = $this->__handleNuToName($result['industry'],$industryConfig);
        $result['age'] = $this->__handleNuToName($result['age'],$ageConfig);
        $result['hobby'] = $this->__handleNuToName($result['hobby'],$hobbyConfig);

        if(!empty($result['wx_type'])){
            $result['wx_type'] = $this->config->item('wx_type')[$result['wx_type']];
        }else{
            $result['wx_type'] = '';
        }

        if(!empty($result['weibo_type'])){
            $result['weibo_type'] = $this->config->item('weibo_type')[$result['weibo_type']];
        }else{
            $result['weibo_type'] = '';
        }

        $result['characteristic'] = $result['industry'].','.$result['hobby'];
        $this->load->view('media/my/data',$result);
    }

    /**
     * 我的列表 （我的消息）
     */
    public function message(){
        $user_info = $this->__get_user_session();
        $taskWhere['user_id'] = $user_info['media_man_id'];
        $taskWhere['user_type'] = 2;
        $taskWhere['message_type'] = 2;
        $taskWhere['message_status'] = '0';
        $taskResult = $this->__get_user_message_model()->get_user_message_list_by_condition($taskWhere);

        $userWhere['user_id'] = $user_info['media_man_id'];
        $userWhere['user_type'] = 1;
        $taskWhere['message_type'] = 1;
        $userWhere['message_status'] = '0';
        $userResult = $this->__get_user_message_model()->get_user_message_list_by_condition($userWhere);
        $result['taskMessage'] = $taskResult;
        $result['userMessage'] = $userResult['list'];
        $this->load->view('media/my/message',$result);
    }

    public function taskMessage(){
        $user_info = $this->__get_user_session();
        $taskWhere['user_id'] = $user_info['media_man_id'];
        $taskWhere['user_type'] = 2;
        $taskWhere['message_type'] = 2;
        $taskWhere['message_status'] = '0';
        $taskResult = $this->__get_user_message_model()->get_user_message_list_by_condition($taskWhere);

        $result['taskMessage'] = $taskResult['list'];
        $this->load->view('media/my/task_message',$result);
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
    public function taskList(){
        $this->load->view('media/my/task');
    }

    /**
     *  我的列表 （我的任务api）
     */
    public function taskListApi(){
        if(isset($_POST['page']) && !empty($_POST['page'])){
            $where['page'] = $_POST['page'];
        }else {
            $where['page'] = 1;
        }
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $result = $this->__get_task_map_model()->get_media_man_task_list_by_condition($where);
//        echo '<pre>';print_r($result);exit;
        if(empty($result['total']) && $_POST['page']>0){
            $this->_return['errorno'] = -2;
            $this->_return['msg'] = '没有数据了';
            echo json_encode($this->_return);exit;
        }
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
     *  我的列表 （我的任务详情）
     */
    public function taskDetail(){
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        if(!isset($_GET['task_id']) || empty($_GET['task_id'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数错误';
            echo json_encode($this->_return);exit;
        }
        $where['task_id'] = (int)$_GET['task_id'];
        $result = $this->__get_task_map_model()->getMediaManTaskDetailByCondition($where);
        //交付任务被驳回需要显示距任务结束还有多久
        if($result['release_status']==1 && $result['receive_status']==1 && $result['deliver_status']==1 && $result['deliver_audit_status']==2){
            $result['allot_time'] = $this->__timediff($result['end_time'],0);
        }
        $completionCriteriaConfig = $this->config->item('task_completion_criteria');
        $publishingPlatformConfig = $this->config->item('publishing_platform');
        $result['publishing_platform'] = $this->__handleNuToName($result['publishing_platform'],$publishingPlatformConfig);
        $result['completion_criteria'] = $this->__handleNuToName($result['completion_criteria'],$completionCriteriaConfig);

//        echo '<pre>';
//        print_r($result);exit;
        $this->load->view('media/my/info',$result);
//        exit;
//        if(isset($result['total'])){
//            $this->_return['errorno'] = -1;
//            $this->_return['msg'] = '没有任务';
//            echo json_encode($this->_return);exit;
//        }
//        $this->_return['errorno'] = 1;
//        $this->_return['msg'] = '成功';
//        $this->_return['data'] = $result;
//        echo json_encode($this->_return);exit;
    }


    /**
     *  我的列表  （交付任务页面）
     */
    public function giveTask(){
        $this->load->view('media/my/give_task');
    }

    public function getGiveInfo(){
        $task_id = $_POST['task_id'];
        if(empty($task_id)){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = 'task_id不能为空';
            echo json_encode($this->_return);exit;
        }
        $user_info = $this->__get_user_session();
        $where ['media_man_user_id'] = $user_info['media_man_id'];
        $where ['task_id'] = $task_id;
        $info = $this->__get_task_map_model()->getMediaManTaskDetailByCondition($where);
        if(empty($info)){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '数据异常请联系客服';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = '1';
        $this->_return['msg'] = '获取数据成功';
        $this->_return['data'] = $info;
        echo json_encode($this->_return);exit;
    }

    /**
     *  我的列表（post交付任务）
     */
    public function giveTaskApi() {
        if(!isset($_POST ['task_id']) || empty($_POST ['task_id'])){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '任务ID不能为空';
            echo json_encode($this->_return);exit;
        }

        if(isset($_POST ['deliver_link']) && !empty($_POST ['deliver_link'])){
            $info ['deliver_link'] = $_POST ['deliver_link'];
        }
        if(isset($_POST ['deliver_images']) && !empty($_POST ['deliver_images'])){
            $info ['deliver_images'] = json_encode($_POST ['deliver_images']);
        }
        $user_info = $this->__get_user_session();
        $where['task_id'] = (int)$_POST['task_id'];
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $info ['deliver_status'] = 1;
        $info ['deliver_audit_status'] = 0;
        $result = $this->__get_task_map_model()->updateMapInfo($where,$info);
        if(!$result){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '交付失败';
            echo json_encode($this->_return);exit;
        }
        $this->__saveLog($_POST['task_id'],9,'交付任务','',$info);
        $this->_return['errorno'] = '1';
        $this->_return['msg'] = '交付成功';
        echo json_encode($this->_return);exit;
    }

    public function getAreaApi(){
        $pid = $_POST['pid'];
        $result = $this->__get_china_model()->select_by_pid($pid);
        if(empty($result) || !is_array($result)){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '查询失败';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = '1';
        $this->_return['msg'] = '查询成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }

    /**
     *  我的列表 （我的收入）
     */
    public function incomeList(){
//        if(isset($_POST['page']) && !empty($_POST['page'])){
//            $where['page'] = $_POST['page'];
//        }
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $where['finance_status'] = 1;
        $result = $this->__get_task_map_model()->get_media_man_task_list_by_condition($where);
//        echo '<pre>';
//        print_r($result);exit;
        $this->load->view('/media/my/income',$result);
//        if(empty($result['total'])){
//            $this->_return['errorno'] = -1;
//            $this->_return['msg'] = '暂时还没有收入哦，快去完成任务吧';
//            echo json_encode($this->_return);exit;
//        }
//        $this->_return['errorno'] = 1;
//        $this->_return['msg'] = '成功';
//        $this->_return['data'] = $result;
//        echo json_encode($this->_return);exit;
    }

    //确认收款按钮
    public function receivables(){
        $task_id = (int)$_POST['task_id'];
        if(empty($task_id)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数错误';
            echo json_encode($this->_return);exit;
        }
        $where['task_id'] = $task_id;
        $user_info = $this->__get_user_session();
        $where['media_man_user_id'] = $user_info['media_man_id'];
        $info['receivables_status'] = '1';
        $result = $this->__get_task_map_model()->updateMapInfo($where, $info);
        $data = $this->__get_task_map_model()->getMediaManTaskDetailByCondition($where);
        if(!empty($result)){
            $this->__saveLog($task_id,12,'确认收款','','');
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '确认成功';
            $this->_return['data'] = $data;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '确认失败';
            echo json_encode($this->_return);exit;
        }
    }

    public function userInfoApi(){
        $data = $this->__get_user_session();
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $data;
        echo json_encode($this->_return);
    }


    /**
     * 获取剩余时间
     * @param $allot_time
     * @return bool|string
     */
    private function __timediff($allot_time,$time){
        $result = Wap::timediff($allot_time+$time);
        if(!is_array($result) || $result<0){
            //任务已经超时，修改任务状态
            return false;
        }
        $str = '剩余：';
        if(!empty($result['day'])){
            $str .='<span>'.$result['day'].'</span><b>天</b>';
        }
        if(!empty($result['hours'])){
            $str .='<span>'.$result['hours'].'</span><b>小时</b>';
        }
        if(!empty($result['min'])){
            $str .='<span>'.$result['min'].'</span><b>分</b>';
        }
        return $str;

    }













    private function __get_user_session(){
        $userSession = $this->session->userdata($this->_user_info);
        if(empty($userSession) || !is_array($userSession)){
            redirect(wap::get_server_address_and_port().'/media/login/login');
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

    /**
     * @return China_model
     */
    private function __get_china_model() {
        $this->load->model('China_model');
        return $this->China_model;
    }

    private function __handleNuToName($str,$configArr){
        if(empty($str)){
            return '';
        }
        $arr = explode(',',$str);
        $nStr = '';
        if(!empty($arr)){
            foreach($arr as $value){
                $nStr .= $configArr[$value].',';
            }
        }
        $nStr = rtrim($nStr,',');
        return $nStr;
    }


    private function __saveLog($operate_data_id,$user_log_type,$user_log_content,$old_data,$new_data){
        $user_info = $this->__get_user_session();
        $data = [
            'user_id'     => $user_info['media_man_id'],
            'user_name'   => !empty($user_info['media_man_name'])?$user_info['media_man_name']:'',
            'operate_data_id' => $operate_data_id,
            'user_type'    => 2,
            'user_log_type' => $user_log_type,
            'user_log_content' => $user_log_content,
            'old_data'        => json_encode($old_data),
            'new_data'        => json_encode($new_data),
        ];
        $this->__get_log_model()->insert($data);
        return true;
    }

    /**
     * @return User_log_model
     */
    private function __get_log_model() {
        $this->load->model('User_log_model');
        return $this->User_log_model;
    }


}
