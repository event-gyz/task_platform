<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public $_model = 'ad_plat_code';
    public $_pwd_phone = 'ad_pwd_phone';
    public $_pwdmodel = 'ad_plat_pwd_code';
    public $_user_info = 'ad_user_info';

    public function __construct(){
        parent::__construct ();
        $this->load->helper ( array (
            'form',
            'url',
            'Wap'
        ) );
        $this->load->library('session');
    }
    // 返回规范
    private $_return = array(
        'errorno' => 0,
        'msg' => '',
        'data' => array()
    );

    //登录
    public function login() {
        if (empty($_POST)) {
            $this->load->view('advertiser/login');
        } else {

            if(!isset($_POST ['userName']) || empty($_POST ['userName'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户名不能为空';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['password']) || empty($_POST ['password'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码不能为空';
                echo json_encode($this->_return);exit;
            }
            $password = Wap::generate_wap_user_password($_POST ['password']);
            $data = array (
                'advertiser_login_name' => trim($_POST['userName']),
                'advertiser_password' => $password
            );

            $userInfo = $this->__get_advertiser_model()->selectByLoginName($data['advertiser_login_name']);
            if(empty($userInfo)){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户不存在';
                echo json_encode($this->_return);exit;
            }
            if ($userInfo['advertiser_password'] != $password) {
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码错误';
                echo json_encode($this->_return);exit;
            }else{
                $this->session->set_userdata($this->_user_info,$userInfo);
                if($userInfo['audit_status']==1 && $userInfo['status']==2) {
                    $this->_return['errorno'] = '1';
                    $this->_return['msg'] = '登录成功';
                    echo json_encode($this->_return);
                    exit;
                }else if($userInfo['status']==0){
                    $this->_return['errorno'] = '2';
                    $this->_return['msg'] = '未完善基础信息';
                    echo json_encode($this->_return);exit;
                }else if($userInfo['audit_status']==0){
                    $this->_return['errorno'] = '3';
                    $this->_return['msg'] = '待审核';
                    echo json_encode($this->_return);exit;
                }else if($userInfo['audit_status']==2){
                    $this->_return['errorno'] = '4';
                    $this->_return['msg'] = '驳回';
                    //驳回原因
                    $this->_return['data'] = $userInfo['reasons_for_rejection'];
                    echo json_encode($this->_return);exit;
                }else if($userInfo['status']==9){
                    $this->_return['errorno'] = '5';
                    $this->_return['msg'] = '冻结';
                    //冻结原因
                    $this->_return['data'] = $userInfo['freezing_reason'];
                    echo json_encode($this->_return);exit;
                }else{
                    $this->_return['errorno'] = '-1';
                    $this->_return['msg'] = '账户异常，请联系管理员';
                    echo json_encode($this->_return);exit;
                }

            }

        }
    }

    //注册
    public function register() {
        if (empty($_POST)) {
            $this->load->view('advertiser/register');
        } else {
            if(!isset($_POST ['userName']) || empty($_POST ['userName'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户名不能为空';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['password']) || empty($_POST ['password'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码不能为空';
                echo json_encode($this->_return);exit;
            }
            if($_POST ['password'] != $_POST ['againPassword']){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '两次密码不一致';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['phone']) || empty($_POST ['phone'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '手机号码不能为空';
                echo json_encode($this->_return);exit;
            }

            $pattern = '/^1[3|4|5|7|8][0-9]\d{8}$/';
            if( !preg_match($pattern, $_POST ['phone']) ) {
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '手机号格式有误';
                echo json_encode($this->_return);exit;
            }

            if(!isset($_POST ['verification']) || empty($_POST ['verification'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '验证码不能为空';
                echo json_encode($this->_return);exit;
            }

            $re = $this->__verifyCode($_POST ['phone'], $_POST ['verification'],$this->_model);
            if($re['errorno'] < 0){
                $this->_return = array_merge($this->_return,$re);
                echo json_encode($this->_return);exit;
            }

            $password = Wap::generate_wap_user_password($_POST ['password']);
            $data = array (
                'advertiser_login_name' => trim($_POST['userName']),
                'advertiser_password' => $password,
                'advertiser_phone' => trim($_POST['phone'])
            );
            $re = $this->__get_advertiser_model()->insert ($data );
            if($re){
                $data['advertiser_id'] = $re;
                $this->session->set_userdata($this->_user_info,$data);
                $this->_return['errorno'] = 1;
                $this->_return['msg'] = '注册成功';
                //删除注册时用到的session
                $this->session->unset_userdata($this->_model.$_POST ['phone']);
                echo json_encode($this->_return);exit;
            }
        }
    }

    //找回密码
    public function updatePwd(){
        $pwd = $_POST['password'];
        $rel_pwd = $_POST['rel_password'];
        if(empty($pwd) || empty($rel_pwd)){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '密码不能为空';
            echo json_encode($this->_return);exit;
        }
        if($pwd != $rel_pwd){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '两次密码不一致，请修改后重试';
            echo json_encode($this->_return);exit;
        }
        //兼容忘记密码功能
        $phone = $this->session->userdata($this->_pwd_phone);
        if(empty($phone)){
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '数据异常';
            echo json_encode($this->_return);exit;
        }else{
            $re = $this->__get_advertiser_model()->updateInfoByPhone($phone,['advertiser_password'=>Wap::generate_wap_user_password($pwd)]);
            if($re){
                //清除掉当前的登录信息
                $this->session->unset_userdata($this->_user_info);
                $this->session->unset_userdata($this->_pwd_phone);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '修改成功';
                echo json_encode($this->_return);exit;
            }
        }

    }

    //退出登录
    public function logout(){
        $this->session->sess_destroy();
        $this->load->view ( 'advertiser/login' );
    }

    /**
     * 发送登录验证码
     */
    public function sendCode()
    {
//        $_POST['phone'] = '157100612488';
//        $_POST['type'] = 'pwd';
        // 判断传递参数是否为空
        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '手机号不能为空';
            echo json_encode($this->_return);exit;
        }

        if (isset($_POST['type']) && ($_POST['type']=='pwd')) {
            $model = $this->_pwdmodel;
            //验证当前手机号是否注册过
            $res = $this->__get_advertiser_model()->selectByPhone($_POST['phone']);
            if(empty($res)){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '手机号还未注册过';
                echo json_encode($this->_return);exit;
            }

        }else{
            $model = $this->_model;
        }

        $phone = $_POST['phone'];

        // 判断是否可以正常发送
        $check = $this->__checkSendCode($phone,$model);
        if ($check !== true) {
            $this->_return['errorno'] = $check['status'];
            $this->_return['msg'] = $check['msg'];
            echo json_encode($this->_return);exit;
        }
        $code = mt_rand(100000, 999999);

        //todo 发送验证码
//        $this->__sendPhoneMsg($phone,$code ,1);

        $model = $model . $phone;

        $this->__recordSendCodeTimes($phone);

        $this->session->set_userdata($model, ['sendTime' => time(), 'code' => $code]);

        $this->_return['msg'] = '发送成功';
        echo json_encode($this->_return);exit;

    }


    //记录当前用户发送验证码次数
    private function __recordSendCodeTimes($phone){
        $timemodel = 'times' . $phone;
        $userTimes = $this->session->userdata($timemodel);
        if(!empty($userTimes['times'])){
            $times = $userTimes['times']+1;
        }else{
            $times = 1;
        }
        $this->session->set_userdata($timemodel, ['times'=>$times]);
    }

    //获取当前用户发送验证码次数
    private function __getSendCodeTimes($phone){
        $timemodel = 'times'. $phone;
        $userTimes = $this->session->userdata($timemodel);
        return $userTimes['times'];
    }

    //获取当前用户发送验证码次数
    private function __delSendCodeTimes($phone){
        $timemodel = 'times'. $phone;
        $this->session->unset_userdata($timemodel);
    }

    /**
     * 校验验证码
     * @param $phone
     * @param $code
     * @param $model
     * @return array|bool
     */
    private function __verifyCode($phone,$code,$model){
        $code = (int)$code;
        $model = $model.$phone;
        $codeInSession = $this->session->userdata($model);
        $interval = 0;
        if( !empty( $codeInSession ) ){
            $interval = time() - $codeInSession['sendTime'];
        }
        $res = array( 'errorno'=>-9,'msg'=>'验证异常' );
        if( $code < 100000 || $code > 999999){
            $res = array( 'errorno'=>-3,'msg'=>'验证码有误' );
        }else if( $interval > 1800 ){
            $res = array( 'errorno'=>-5,'msg'=>'验证码已失效' );
        }else if( $codeInSession['code'] != $code ){
            $res = array( 'errorno'=>-7,'msg'=>'验证码错误' );
        }else if( $codeInSession['code'] == $code ){
            return true;
        }
        return $res;
    }

    /**
     * 校验验证码API
     */
    public function verifyCodeApi(){
        $phone = (int)$_POST['phone'];
        $code  = (int)$_POST['code'];

        if (isset($_POST['type']) && ($_POST['type']=='pwd')) {
            $model = $this->_pwdmodel;
        }else{
            $model = $this->_model;
        }

        $re = $this->__verifyCode($phone,$code,$model);
        if($re['errorno'] < 0){
            $this->_return = array_merge($this->_return,$re);
            echo json_encode($this->_return);exit;
        }
        //删除掉验证码
        $this->session->unset_userdata($model.$phone);
        if (isset($_POST['type']) && ($_POST['type']=='pwd')) {
            //保存当天用户校验过的手机号
            $this->session->set_userdata($this->_pwd_phone,$phone);
        }
        $this->_return['errorno'] = '1';
        $this->_return['msg'] = '验证成功';
        echo json_encode($this->_return);exit;

    }

    /**
     * 发送验证码是验证手机号
     * @param $phone
     * @return array|bool
     */
    private function __checkSendCode($phone,$model){
        $pattern = '/^1[3|4|5|7|8][0-9]\d{8}$/';
        $model = $model.$phone;

        if( !preg_match($pattern, $phone) ) {
            return array( 'status'=>-1,'msg'=>'手机号格式有误' );
        }
        $codeInSession = $this->session->userdata($model);
        $userTimes = $this->__getSendCodeTimes($phone);
        if(empty($codeInSession)){
            return true;
        }
        //每天限制10条，判断该session如果是前一天生成的，unset掉
        if($codeInSession['sendTime'] < (strtotime(date("Y-m-d"),time())) ){
            $this->session->unset_userdata($model);
            $this->__delSendCodeTimes($phone);
            return true;
        }
        //一天只能发送10条验证码
        if($userTimes > 10){
            return array( 'status'=>-1,'msg'=>'一天只能发送10条验证码' );
        }
        $interval = -1;
        if( !empty( $codeInSession ) ){
            $interval = time() - $codeInSession['sendTime'];
        }
        //60秒发送一次
        if( $interval != -1 && $interval < 60 ){
            return array( 'status'=>-5,'msg'=>'发送频率过快，请稍候再试' );
        }
        return true;
    }


    /**
     * 发送验证码
     * @param string $number
     * @param $code
     * @param int $template_id
     */
    private function __sendPhoneMsg($number='',$code ,$template_id = 1){

//        $contents = ['code'=>$code];//短信分段内容
//        $this->load->library('JSMS');
//        $this->JSMS = new JSMS();
//        return $this->JSMS->sendMessage($number,$template_id,$contents);

    }

    /**
     * @return Platform_advertiser_model
     */
    private function __get_advertiser_model() {
        $this->load->model('Platform_advertiser_model');
        return $this->Platform_advertiser_model;
    }
}
