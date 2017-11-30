<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public $_user_info = 'ad_user_info';

    public $_update = 'update';
    public $_submitAudit = 'audit';
    public $_endTask = 'endTask';
    public function __construct(){
        parent::__construct ();
        $this->load->helper ( array (
            'form',
            'url'
        ) );
        $this->load->library('session');
        $this->load->helper('Wap');
//        $this->checkUserLogin();

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
            redirect('/advertiser/login/login');
        }
        if(($user_info['audit_status'] != 1) || ($user_info['status'] != 2)){
            $userInfo = $this->__get_advertiser_model()->selectById($user_info['advertiser_id']);
            $this->session->set_userdata($this->_user_info,$userInfo);
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
//                echo json_encode($this->_return);exit;
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
        return false;
    }


    public function home() {
//        $where  = ['offset' => 0, 'limit' => 1];
//        $result = $this->__get_advertiser_model()->get_advertiser_list_by_condition($where);
//        $this->load->view('advertiser/index');
    }

    // 保存广告主基础信息
    public function saveInfo() {
        if (empty($_POST)) {
            $this->load->view('advertiser/baseInfo');
        } else {
            if(!isset($_POST ['type']) || empty($_POST ['type'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '请选择类型';
                echo json_encode($this->_return);exit;
            }
            //个人
            if($_POST ['type'] == 1){
                if(!isset($_POST ['name']) || empty($_POST ['name'])){
                    $this->_return['errorno'] = '-1';
                    $this->_return['msg'] = '请填写姓名';
                    echo json_encode($this->_return);exit;
                }
                if(!isset($_POST ['id_card']) || empty($_POST ['id_card'])){
                    $this->_return['errorno'] = '-1';
                    $this->_return['msg'] = '请填写身份证号';
                    echo json_encode($this->_return);exit;
                }

                if(!isset($_POST ['id_card_positive_pic']) || empty($_POST ['id_card_positive_pic'])){
                    $this->_return['errorno'] = '-1';
                    $this->_return['msg'] = '请上传身份证正面照片';
                    echo json_encode($this->_return);exit;
                }

                if(!isset($_POST ['id_card_back_pic']) || empty($_POST ['id_card_back_pic'])){
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
                    'id_card' => $_POST['id_card'],
                    'id_card_positive_pic' => $_POST['id_card_positive_pic'],
                    'id_card_back_pic' => (int)$_POST['id_card_back_pic'],
                    'handheld_id_card_pic' => $_POST['handheld_id_card_pic'],
                );
            //企业
            }else{
                if(!isset($_POST ['company_name']) || empty($_POST ['company_name'])){
                    $this->_return['errorno'] = '-1';
                    $this->_return['msg'] = '请填写公司名称';
                    echo json_encode($this->_return);exit;
                }
                if(!isset($_POST ['company_address']) || empty($_POST ['company_address'])){
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
                    'company_name' => trim($_POST['company_name']),
                    'company_address' => $_POST['company_address'],
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
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '保存成功';
                echo json_encode($this->_return);
                exit;
            }

        }
    }



    /**
     * 开始推广
     */
    public function extension(){

    }

    /**
     * 开始推广
     */
    public function getTaskInfo(){
//        $_POST['task_id'] = 1;
        $task_id = $_POST['task_id'];

        if(empty($task_id)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '任务ID不能为空';
            echo json_encode($this->_return);exit;
        }

        $this->__checkTaskWhetherBelongUser($task_id,$this->_update);

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

    // 保存任务/修改任务 接口
    public function saveTask(){
        $task_id = $_POST['task_id'];
        $task_type = $_POST['task_type'];
        $title = $_POST['title'];
        $link = $_POST['link'];
        $pics = $_POST['pics'];
        $task_describe = $_POST['task_describe'];
        $price = $_POST['price'];
        $media_man_number = $_POST['media_man_number'];
        $total_price = $_POST['price']*$_POST['media_man_number'];
        $require_age = $_POST['require_age'];
        $require_local = $_POST['require_local'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $publishing_platform = $_POST['publishing_platform'];
        $completion_criteria = $_POST['completion_criteria'];
        $audit_status = $_POST['audit_status'];

        $data['task_type'] = $task_type;
        $data['title'] = $title;
        $data['link'] = $link;
        $data['pics'] = $pics;
        $data['task_describe'] = $task_describe;
        $data['price'] = $price;
        $data['media_man_number'] = $media_man_number;
        $data['total_price'] = $total_price;
        $data['require_age'] = $require_age;
        $data['require_local'] = $require_local;
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $data['publishing_platform'] = $publishing_platform;
        $data['completion_criteria'] = $completion_criteria;
        $data['audit_status'] = $audit_status; //审核状态 0、1

        //新增
        if(empty($task_id)){
            $userInfo = $this->__get_user_session();
            $data['advertiser_user_id'] = $userInfo['advertiser_id'];
            $re = $this->__get_task_model()->insert($data);
        //修改
        }else{
            $this->__checkTaskWhetherBelongUser($task_id,$this->_update);

            $re = $this->__get_task_model()->updateInfo($task_id,$data);
        }

        if(empty($re)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '操作失败';
            echo json_encode($this->_return);exit;
        }else{
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '操作成功';
            echo json_encode($this->_return);exit;
        }

    }


    /**
     * 我的任务 提交审核
     */
    public function submitAudit(){
        $task_id = (isset($_POST['task_id'])&&!empty($_POST['task_id'])) ? $_POST['task_id'] : 0;
        $info ['audit_status'] = 1;

        $this->__checkTaskWhetherBelongUser($task_id,$this->_submitAudit);

        $result = $this->__get_task_model()->updateInfo($task_id,$info);
        if(!empty($result)){
            $this->_return['errorno'] = 1;
            $this->_return['msg'] = '提交成功';
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

        $this->__checkTaskWhetherBelongUser($task_id,$this->_endTask);

        $result = $this->__get_task_model()->updateInfo($task_id,$info);
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
    public function myMessage(){
        $user_info = $this->__get_user_session();
        $where['user_id'] = $user_info['advertiser_id'];
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
        if(isset($_POST['page']) && !empty($_POST['page'])){
            $where['offset'] = $_POST['page'];
        }
        $user_info = $this->__get_user_session();
        $where['advertiser_user_id'] = $user_info['advertiser_id'];
        $result = $this->__get_task_map_model()->get_advertiser_task_list_by_condition($where);
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
    public function myTaskDetail(){
        $user_info = $this->__get_user_session();
        $where['advertiser_user_id'] = $user_info['advertiser_id'];
        $_POST['task_map_id'] = 1;
        if(!isset($_POST['task_map_id']) || empty($_POST['task_map_id'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '参数错误';
            echo json_encode($this->_return);exit;
        }
        $where['task_map_id'] = $_POST['task_map_id'];
        $result = $this->__get_task_map_model()->get_advertiser_task_detail_by_condition($where);
        if(isset($result['total'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '没有任务';
            echo json_encode($this->_return);exit;
        }
        $this->_return['errorno'] = 1;
        $this->_return['msg'] = '成功';
        $this->_return['data'] = $result;
        echo json_encode($this->_return);exit;
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

        if( $handle == $this->_update ){
            if($result['release_status'] != 0 || ($result['audit_status'] != 2 && $result['audit_status'] != 2 && $result['audit_status'] != 0)){
                $this->_return['errorno'] = -1;
                $this->_return['msg'] = '当前任务不可以进行修改';
                echo json_encode($this->_return);exit;
            }
        }

        if( $handle == $this->_submitAudit ){
            if($result['audit_status'] != 0){
                $this->_return['errorno'] = -1;
                $this->_return['msg'] = '当前任务不可以提交审核';
                echo json_encode($this->_return);exit;
            }
        }

        if( $handle == $this->_endTask ){
            if($result['start_time'] - time() < 43200){
                $this->_return['errorno'] = -1;
                //todo 文案补全
                $this->_return['msg'] = '距离任务开始小于12小时不可结束任务，如需结束任务请联系';
                echo json_encode($this->_return);exit;
            }
        }

        if($result['advertiser_user_id'] != $userInfo['advertiser_id']){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '该任务不属于你，不可以进行操作';
            echo json_encode($this->_return);exit;
        }else{
            return true;
        }
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






    private function __get_user_session(){
        $userSession = $this->session->userdata($this->_user_info);
        if(empty($userSession) || !is_array($userSession)){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '用户信息有误请重新登录';
            //todo 跳到登录页面
            echo json_encode($this->_return);exit;
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








}
