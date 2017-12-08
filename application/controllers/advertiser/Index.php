<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public $_user_info = 'ad_user_info';

    public $_update = 'update';
    public $_submitAudit = 'audit';
    public $_endTask = 'endTask';
    public $_payTask = 'payTask';
    public function __construct(){
        parent::__construct ();
        $this->load->library('session');
        $this->load->helper('Wap');
        if(!strpos($_SERVER["REQUEST_URI"],'home') && !strpos($_SERVER["REQUEST_URI"],'/my') && !strpos($_SERVER["REQUEST_URI"],'/person') && !strpos($_SERVER["REQUEST_URI"],'/company') && !strpos($_SERVER["REQUEST_URI"],'userInfoApi')){
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
        if(!$user_info['advertiser_id']){
            redirect(wap::get_server_address_and_port().'/advertiser/login/login');
        }
        if(($user_info['audit_status'] != 1) || ($user_info['status'] != 2)){
            $userInfo = $this->__get_advertiser_model()->selectById($user_info['advertiser_id']);
            $this->session->set_userdata($this->_user_info,$userInfo);
            if($userInfo['status']==0){
                //跳到完善基础信息页面
                redirect(wap::get_server_address_and_port().'/advertiser/login/accountStatus2');
            }else if($userInfo['audit_status']==0){
                //跳到待审核页面
                redirect(wap::get_server_address_and_port().'advertiser/login/accountStatus3');
            }else if($userInfo['audit_status']==2){
                //跳到驳回页面
                redirect(wap::get_server_address_and_port().'advertiser/login/accountStatus4');
            }else if($userInfo['status']==9){
                //跳到冻结页面
                redirect(wap::get_server_address_and_port().'advertiser/login/accountStatus5');
            }else if($userInfo['audit_status']==1 && $userInfo['status']==2){
                return true;
            }
        }
        return false;
    }


    public function home() {
        $this->load->view('advertiser/index');
    }

    public function company(){
        $this->load->view('advertiser/company');
    }

    public function person(){
        $this->load->view('advertiser/person');
    }

    // 保存广告主基础信息
    public function saveInfo() {
        if(!isset($_POST ['type']) || empty($_POST ['type'])){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '请选择类型';
            echo json_encode($this->_return);exit;
        }
        //个人
        if($_POST ['type'] == 'person'){
            if(!isset($_POST ['name']) || empty($_POST ['name'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写姓名';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['idCard']) || empty($_POST ['id_card'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写身份证号';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['frontCard']) || empty($_POST ['frontCard'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请上传身份证正面照片';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['backCard']) || empty($_POST ['backCard'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请上传身份证反面照片';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['handheld_id_card_pic']) || empty($_POST ['handheld_id_card_pic'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请上传手持身份证照片';
                echo json_encode($this->_return);exit;
            }
            $data = array (
                'name' => trim($_POST['name']),
                'id_card' => $_POST['idCard'],
                'advertiser_type' => 1,
                'id_card_positive_pic' => $_POST['frontCard'],
                'id_card_back_pic' => (int)$_POST['backCard'],
                'handheld_id_card_pic' => $_POST['handheld_id_card_pic'],
            );
            //企业
        }else{
            if(!isset($_POST ['companyName']) || empty($_POST ['companyName'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写公司名称';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['companyAdress']) || empty($_POST ['companyAdress'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写公司地址';
                echo json_encode($this->_return);exit;
            }
            //todo 跟现有的广告主电话不能重复
            if(!isset($_POST ['content_name']) || empty($_POST ['content_name'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写联系人姓名';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['content_phone']) || empty($_POST ['content_phone'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请填写联系人电话';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['business_license_pic']) || empty($_POST ['business_license_pic'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请上传营业执照';
                echo json_encode($this->_return);exit;
            }
            $data = array (
                'advertiser_type' => 2,
                'company_name' => trim($_POST['companyName']),
                'company_address' => $_POST['companyAdress'],
                'content_name' => $_POST['content_name'],
                'content_phone' => (int)$_POST['content_phone'],
                'business_license_pic' => $_POST['business_license_pic'],
            );
        }
        //进入后台审核列表
        $data['status'] = 1;

        //通过session获取用户信息
        $userInfo = $this->__get_user_session();
        $re = $this->__get_advertiser_model()->updateInfo($userInfo['advertiser_id'],$data);
        if ($re) {
            $this->__saveLog($userInfo['advertiser_id'],11,'保存广告主基础信息','',$data);
            $this->_return['errorno'] = '1';
            $this->_return['msg'] = '保存成功';
            echo json_encode($this->_return);
            exit;
        }
    }





    /**
     * 获取任务详情
     */
    public function taskInfoApi(){
        $task_id = $_POST['task_id'];
        if(empty($task_id)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '任务ID不能为空';
            echo json_encode($this->_return);exit;
        }

        $this->__checkTaskWhetherBelongUser($task_id,TRUE);

        $where['task_id'] = $task_id;
        $result = $this->__get_task_model()->selectByCondition($where);

        if(empty($result)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数有误，请重试';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '成功';
            $this->_return['data'] = $result;
            echo json_encode($this->_return);exit;
        }
    }

    //测试用
    public function statusView(){
        $this->load->view('advertiser/status');
    }
    /**
     * 任务提交审核成功页面
     */
    public function taskSubmitSuccessView(){
        $data['task_id'] = $_GET['task_id'];
        $this->load->view('advertiser/taskSubmitSuccess',$data);
    }

    /**
     * 任务保存成功页面
     */
    public function taskSaveSuccessView(){
        $data['task_id'] = $_GET['task_id'];
        $this->load->view('advertiser/taskSaveSuccess',$data);
    }

    /**
     * 开始推广
     */
    public function taskView(){
        $this->load->view('advertiser/generalize');
    }

    // 保存任务/修改任务 接口
    public function saveTask(){
        $task_id = $_POST['task_id'];
        $task_name = $_POST['taskName'];
        $task_type = $_POST['taskType'];
        $title = $_POST['taskTitle'];
        $link = $_POST['taskUrl'];
        $pics = json_encode($_POST['taskImg']);
        $task_describe = $_POST['taskDes'];
        $price = $_POST['taskPrice'];
        $media_man_number = $_POST['number'];
        $total_price = $_POST['taskPrice']*$_POST['number'];
        $media_man_require = $_POST['numAsk'];
        if($media_man_require == 1){
            $require_sex = $_POST['sex'];
            $require_age = implode(',',$_POST['age']);
            $require_local = implode(',',$_POST['city']);
            $require_hobby = implode(',',$_POST['liking']);
            $require_industry = implode(',',$_POST['industry']);
        }
        $start_time = strtotime($_POST['startTime']);
        $end_time = strtotime($_POST['endTime']);
        $publishing_platform = implode(',',$_POST['platform']);
        $completion_criteria = implode(',',$_POST['endStandard']);
        $audit_status = $_POST['audit_status'];

        $data['task_name'] = $task_name;
        $data['task_type'] = $task_type;
        $data['title'] = $title;
        $data['link'] = $link;
        $data['pics'] = $pics;
        $data['task_describe'] = $task_describe;
        $data['price'] = $price;
        $data['media_man_number'] = $media_man_number;
        $data['total_price'] = $total_price;
        $data['media_man_require'] = $media_man_require;
        if($media_man_require == 1){
            $data['require_sex'] = $require_sex;
            $data['require_age'] = $require_age;
            $data['require_local'] = $require_local;
            $data['require_industry'] = $require_industry;
            $data['require_hobby'] = $require_hobby;
        }
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $data['publishing_platform'] = $publishing_platform;
        $data['completion_criteria'] = $completion_criteria;
        $data['audit_status'] = $audit_status; //审核状态 0、1

        if($audit_status==1){
            $data['submit_audit_time'] = date('Y-m-d H:i:s',time());
        }
        //新增
        if(empty($task_id)){
            $userInfo = $this->__get_user_session();
            $data['advertiser_user_id'] = $userInfo['advertiser_id'];
            $re = $this->__get_task_model()->insert($data);
            $this->__saveLog($re,3,'提交任务','',$data);
            //修改
        }else{
            $this->__checkTaskWhetherBelongUser($task_id,$this->_update);
            $this->__get_task_model()->updateInfo($task_id,$data);
            $this->__saveLog($task_id,4,'修改任务','',$data);
            $re = $task_id;
        }

        if(empty($re)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '操作成功';
            $this->_return['data'] = $re;
            echo json_encode($this->_return);exit;
        }

    }

    public function data_person(){
        $this->load->view('advertiser/my/data_person');
    }
    public function data_company(){
        $this->load->view('advertiser/my/data_company');
    }

    public function userInfo(){
        $user_info = $this->__get_user_session();
        if($user_info['advertiser_type'] == 1){
            redirect(wap::get_server_address_and_port().'/advertiser/index/data_person');
        }else{
            redirect(wap::get_server_address_and_port().'/advertiser/index/data_company');
        }
    }

    /**
     * 我的资料
     */
    public function getAdvertiserInfo(){
        $user_info = $this->__get_user_session();
        $advertiser_id = $user_info['advertiser_id'];
        $result = $this->__get_advertiser_model()->selectById($advertiser_id);
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
    }


    /**
     * 我的列表 （我的消息）
     */
    public function message(){
        $user_info = $this->__get_user_session();
        $taskWhere['user_id'] = $user_info['advertiser_id'];
        $taskWhere['user_type'] = 1;
        $taskWhere['message_type'] = 2;
        $taskWhere['message_status'] = '0';
        $taskResult = $this->__get_user_message_model()->get_user_message_list_by_condition($taskWhere);

        $userWhere['user_id'] = $user_info['advertiser_id'];
        $userWhere['user_type'] = 1;
        $userWhere['message_status'] = '0';
        $userWhere['message_type'] = 1;
        $userResult = $this->__get_user_message_model()->get_user_message_list_by_condition($userWhere);
        $result['taskMessage'] = $taskResult;
        $result['userMessage'] = $userResult['list'];
        $this->load->view('advertiser/my/message',$result);
    }

    public function taskMessage(){
        $user_info = $this->__get_user_session();
        $taskWhere['user_id'] = $user_info['advertiser_id'];
        $taskWhere['user_type'] = 1;
        $taskWhere['message_type'] = 2;
        $taskWhere['message_status'] = '0';
        $taskResult = $this->__get_user_message_model()->get_user_message_list_by_condition($taskWhere);
        $result['taskMessage'] = $taskResult['list'];
        $this->load->view('advertiser/my/task_message',$result);
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
        $this->load->view('advertiser/my/task');
    }

    /**
     *  我的列表 （我的任务）
     */
    public function taskListApi(){
        if(isset($_POST['page']) && !empty($_POST['page'])){
            $where['page'] = $_POST['page'];
        }else {
            $where['page'] = 1;
        }
        $user_info = $this->__get_user_session();
        $where['advertiser_user_id'] = $user_info['advertiser_id'];
        $result = $this->__get_task_model()->getAdvertiserTaskListByCondition($where);

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
     * 我的任务 提交审核
     */
    public function submitAudit(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 0;
        $info ['audit_status'] = 1;

        $data = $this->__checkTaskWhetherBelongUser($task_id,$this->_submitAudit);

        $result = $this->__get_task_model()->updateInfo($task_id,$info);
        if(!empty($result)){
            $this->__saveLog($task_id,3,'提交审核','','');
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '提交成功';
            $this->_return['data'] = $data;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '提交失败';
            echo json_encode($this->_return);exit;
        }

    }

    /**
     * 我的任务 结束任务
     */
    public function endTask(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 0;
        $info ['release_status'] = 7;

        $data = $this->__checkTaskWhetherBelongUser($task_id,$this->_endTask);

        $result = $this->__get_task_model()->updateInfo($task_id,$info);
        if(!empty($result)){
            $this->__saveLog($task_id,10,'结束任务','','');
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '操作成功';
            $this->_return['data'] = $data;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }
    }


    /**
     *  我的列表 （我的任务详情）
     */
    public function taskInfo(){
        $user_info = $this->__get_user_session();
        $where['advertiser_user_id'] = $user_info['advertiser_id'];
        if(!isset($_GET['task_id']) || empty($_GET['task_id'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数错误';
            echo json_encode($this->_return);exit;
        }
        $task_id = (int)$_GET['task_id'];
        $where['task_id'] = $task_id;
        $result = $this->__get_task_model()->getAdvertiserTaskDetailByCondition($where);
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

        if(($result['audit_status'] == 2) || ($result['audit_status'] == 5)){
            $result['allot_time'] = $this->__timediff($result['start_time']);
        }else{
            $result['allot_time'] = 0;
        }
        $result['total_person'] = $this->__get_task_map_model()->getRoweceiveTaskCount($task_id);
        $this->load->view('advertiser/my/info',$result);
//        echo '<pre>';print_r($result);exit;

    }

    /**
     *  确认付款
     */
    public function payTask(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 0;

        $info ['pay_status'] = 1;

        $data = $this->__checkTaskWhetherBelongUser($task_id,$this->_payTask);

        $result = $this->__get_task_model()->updateInfo($task_id,$info);
        if(!empty($result)){
            $this->__saveLog($task_id,13,'确认付款','','');
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '操作成功';
            $this->_return['data'] = $data;
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }
    }


    public function my(){
        $result = [];
        $this->load->view('advertiser/my/index',$result);
    }
    /**
     * 检查该任务是否属于当前用户
     * @param $task_id
     * @param $handle
     * @return bool
     */
    public function __checkTaskWhetherBelongUser($task_id,$handle){
        $userInfo = $this->__get_user_session();
        if(empty($task_id)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '任务ID不能为空';
            echo json_encode($this->_return);exit;
        }
        $where['task_id'] = $task_id;
        $result = $this->__get_task_model()->selectByCondition($where);

        if( $handle === $this->_update ){
            if($result['release_status'] != 0 || ($result['audit_status'] != 2 && $result['audit_status'] != 2 && $result['audit_status'] != 0)){
                $this->_return['errorno'] = -1;
                $this->_return['msg'] = '当前任务不可以进行修改';
                echo json_encode($this->_return);exit;
            }
        }
        if( $handle === $this->_submitAudit ){
            if($result['audit_status'] != 0){
                $this->_return['errorno'] = -1;
                $this->_return['msg'] = '当前任务不可以提交审核';
                echo json_encode($this->_return);exit;
            }
        }

        if( $handle === $this->_endTask ){
            if($result['start_time'] - time() < 43200){
                $this->_return['errorno'] = -1;
                //todo 文案补全
                $this->_return['msg'] = '距离任务开始小于12小时不可结束任务，如需结束任务请联系客服';
                echo json_encode($this->_return);exit;
            }
        }

        if( $handle === $this->_payTask ){
            if($result['audit_status'] != 3){
                $this->_return['errorno'] = -1;
                $this->_return['msg'] = '任务审核通过才可以付款';
                echo json_encode($this->_return);exit;
            }
        }

        if($result['advertiser_user_id'] != $userInfo['advertiser_id']){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '该任务不属于你，不可以进行操作';
            echo json_encode($this->_return);exit;
        }else{
            return $result;
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
    private function __timediff($allot_time){
        $result = Wap::timediff($allot_time);
        if(!is_array($result) || $result<0){
            //任务已经超时，修改任务状态为关闭
            return false;
        }
        $str = '剩余';
        if(!empty($result['day'])){
            $str .=$result['day'].'天';
        }
        if(!empty($result['hours'])){
            $str .=$result['hours'].'小时';
        }
        if(!empty($result['min'])){
            $str .=$result['min'].'分';
        }
        return $str;

    }


//    public function do_upload() {
//        //上传配置
//        $config['upload_path']      = './uploads/';
//        $config['allowed_types']    = 'gif|jpg|png';
//        $config['max_size']     = 100000;
//
//        //加载上传类
//        $this->load->library('upload', $config);
//
//        //执行上传任务
//        if($this->upload->do_upload('userfile')){
//            echo '上传成功';  //如果上传成功返回成功信息
//        }
//        else{
//            echo '上传失败，请重试'; //如果上传失败返回错误信息
//        }
//    }



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


    private function __get_user_session(){
        $userSession = $this->session->userdata($this->_user_info);
        if(empty($userSession) || !is_array($userSession)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '用户信息有误请重新登录';
            redirect(wap::get_server_address_and_port().'/advertiser/login/login');
        }
        return $userSession;
    }



    /**
     * @return Platform_advertiser_model
     */
    private function __get_advertiser_model() {
        $this->load->model('Platform_advertiser_model');
        return $this->Platform_advertiser_model;
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
     * @return Platform_task_model
     */
    private function __get_task_model() {
        $this->load->model('Platform_task_model');
        return $this->Platform_task_model;
    }


    private function __saveLog($operate_data_id,$user_log_type,$user_log_content,$old_data,$new_data){
        $user_info = $this->__get_user_session();
        $data = [
            'user_id'     => $user_info['advertiser_id'],
            'user_name'   => $user_info['advertiser_name'],
            'operate_data_id' => $operate_data_id,
            'user_type'    => 1,
            'user_log_type' => $user_log_type,
            'user_log_content'        => $user_log_content,
            'old_data'        => json_encode($old_data),
            'new_data'        => json_encode($new_data),
        ];
        $this->__get_log_model()->insert($data);
    }

    /**
     * @return User_log_model
     */
    private function __get_log_model() {
        $this->load->model('User_log_model');
        return $this->User_log_model;
    }


}
