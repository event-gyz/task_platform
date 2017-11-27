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

        $this->checkUserLogin();

    }
    // 返回规范
    private $_return = array(
        'errorno' => 0,
        'msg' => '',
        'data' => array()
    );

    private function checkUserLogin(){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info['media_man_id']){
            redirect('/media/login/login');
        }
        if(($user_info['audit_status'] != 1) || ($user_info['status'] != 2)){
            $userInfo = $this->__get_media_man_model()->select_by_id($user_info['media_man_id']);
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
            $userInfo = $this->session->userdata('user_info');
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

    // 保存自媒体人基础信息
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
            $userInfo = $this->session->userdata('user_info');
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
        $result      = $this->__get_media_man_model()->select_by_id($sys_user_id);
        print_r($result);
    }

    /**
     * @return Platform_media_man_model
     */
    private function __get_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }
















}
