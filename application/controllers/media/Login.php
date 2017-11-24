<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public $_salt = 'media';
    public $_model = 'plat_code';
    public function __construct(){
        parent::__construct ();
        $this->load->helper ( array (
            'form',
            'url'
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
            $this->load->view('media/login');
        } else {

            if(!isset($_POST ['username']) || empty($_POST ['username'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户名不能为空';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['password']) || empty($_POST ['password'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码不能为空';
                echo json_encode($this->_return);exit;
            }

            $password = $this->generate_wap_user_password($_POST ['password']);
            $data = array (
                'media_man_login_name' => trim($_POST['username']),
                'media_man_password' => $password
            );

            $userInfo = $this->__get_media_man_model()->select_by_login_name($data['media_man_login_name']);
            if(empty($userInfo)){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户不存在';
                echo json_encode($this->_return);exit;
            }
            if ($userInfo['media_man_password'] != $password) {
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码错误';
                echo json_encode($this->_return);exit;
            }else{
                $this->session->set_userdata($userInfo);
                $this->_return['errorno'] = '1';
                $this->_return['msg'] = '登录成功';
                echo json_encode($this->_return);exit;
            }

        }
    }

    //注册
    public function register() {
        if (empty($_POST)) {
            $this->load->view('media/register');
        } else {
            if(!isset($_POST ['username']) || empty($_POST ['username'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '用户名不能为空';
                echo json_encode($this->_return);exit;
            }
            if(!isset($_POST ['password']) || empty($_POST ['password'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '密码不能为空';
                echo json_encode($this->_return);exit;
            }
            if($_POST ['password'] != $_POST ['re_password']){
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

            if(!isset($_POST ['code']) || empty($_POST ['code'])){
                $this->_return['errorno'] = '-1';
                $this->_return['msg'] = '验证码不能为空';
                echo json_encode($this->_return);exit;
            }

            $re = $this->verifyCode($_POST ['phone'], $_POST ['code']);
            if(!$re){
                $this->_return['errorno'] = $re['status'];
                $this->_return['msg'] = $re['msg'];
                echo json_encode($this->_return);exit;
            }

            $password = $this->generate_wap_user_password($_POST ['password']);
            $data = array (
                'media_man_login_name' => trim($_POST['username']),
                'media_man_password' => $password,
                'media_man_phone' => trim($_POST['phone'])
            );
            $re = $this->__get_media_man_model()->insert ($data );
            if($re){
                $data['media_man_id'] = $re;
                $this->session->set_userdata($data);
                $this->_return['errorno'] = 1;
                $this->_return['msg'] = '注册成功';
                echo json_encode($this->_return);exit;
            }
        }
    }


    //退出登录
    public function logout(){
        $this->session->sess_destroy();
        $this->load->view ( 'media/login' );
    }

    /**
     * 发送验证码
     */
    public function sendCode()
    {

        // 判断传递参数是否为空
        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            $this->_return['errorno'] = '-1';
            $this->_return['msg'] = '手机号不能为空';
            echo json_encode($this->_return);exit;
        }

        $phone = $_POST['phone'];

        // 判断是否可以正常发送
        $check = $this->checkSendCode($phone, $this->_model);
        if ($check !== true) {
            $this->_return['errorno'] = $check['status'];
            $this->_return['msg'] = $check['msg'];
            echo json_encode($this->_return);exit;
        }
        $code = mt_rand(100000, 999999);

        //todo 发送验证码
//        $this->sendPhoneMsg($phone,$code ,1);
//        $phone = 15710061246;
        $sessionName = $this->_model . $phone;
        $this->session->set_userdata($sessionName, ['sendTime' => time(), 'code' => $code]);
        $this->_return['msg'] = '发送成功';
        echo json_encode($this->_return);exit;

    }

    public function generate_wap_user_password($password) {
        $toBeEncrypt = $this->_salt . md5($password);
        return md5($toBeEncrypt);
    }


    /**
     * 校验验证码
     * @param $phone
     * @param $code
     * @return array|bool
     */
    public function verifyCode($phone,$code){
        $code = (int)$code;

        $model = $this->_model.$phone;
        $codeInSession = $this->session->set_userdata($model);
        $interval = 0;
        if( !empty( $codeInSession ) ){
            $interval = time() - $codeInSession['sendTime'];
        }
        $res = array( 'status'=>-9,'msg'=>'验证异常' );
        if( $code < 100000 || $code > 999999){
            $res = array( 'status'=>-3,'msg'=>'验证码有误' );
        }else if( $interval > 1200 ){
            $res = array( 'status'=>-5,'msg'=>'验证码已失效' );
        }else if( $codeInSession['code'] != $code ){
            $res = array( 'status'=>-7,'msg'=>'验证码错误' );
        }else if( $codeInSession['code'] == $code ){
            return true;
        }
        return $res;
    }

    /**
     * 发送验证码是验证手机号
     * @param $phone
     * @return array|bool
     */
    public function checkSendCode($phone){
        $pattern = '/^1[3|4|5|7|8][0-9]\d{8}$/';
        $model = $this->_model.$phone;
        if( !preg_match($pattern, $phone) ) {
            return array( 'status'=>-1,'msg'=>'手机号有误' );
        }
        $codeInSession = $this->session->set_userdata($model);
        $interval = -1;
        if( !empty( $codeInSession ) ){
            $interval = time() - $codeInSession['sendTime'];
        }

        if( $interval != -1 && $interval < 90 ){
            return array( 'status'=>-5,'msg'=>'发送次数过多，请稍候再试' );
        }
        return true;
    }


    /**
     * 发送验证码
     * @param string $number
     * @param $code
     * @param int $template_id
     */
    public function sendPhoneMsg($number='',$code ,$template_id = 1){

//        $contents = ['code'=>$code];//短信分段内容
//        $this->load->library('JSMS');
//        $this->JSMS = new JSMS();
//        return $this->JSMS->sendMessage($number,$template_id,$contents);

    }

    /**
     * @return Platform_media_man_model
     */
    private function __get_media_man_model() {
        $this->load->model('Platform_media_man_model');
        return $this->Platform_media_man_model;
    }
}
