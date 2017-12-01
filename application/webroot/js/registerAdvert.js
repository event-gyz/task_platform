/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        time:0,
        userName:'',
        password:'',
        againPassword:'',
        phone:'',
        verification:''
    },
    mounted:function(){},
    methods:{
        //发送验证码
        getVerCode:function(){
            var _this = this;
            if(util.regexp.mobile.test(_this.phone)){
                $.ajax({
                    url: "/advertiser/login/sendCode",
                    dataType: 'json',
                    type:"post",
                    data:{
                        phone: this.phone
                    },
                    success: function(res) {
                        if(res.errorno >0){
                            _this.time = 90;
                            var timer = setInterval(function(){_this.time--;if(_this.time<1){clearInterval(timer)}},1000);
                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            }else{
                util.tips('手机号码错误！');
            }
        },
        //提交
        save: function(){
            var _this = this;
            if(!this.userName || !(this.userName.length>=6 && this.userName.length<=20)){
                util.tips('用户名必须是6-20个字符！');
                return;
            }
            if(!this.password || !(this.password.length>=6 && this.password.length<=12) || !(util.regexp.isNum.test(this.password) && util.regexp.isZM.test(this.password))){
                util.tips('密码必须是6-12位英文和数字组合！');
                return;
            }
            if(this.againPassword !== this.password){
                util.tips('两次密码不同！');
                return;
            }
            if(!util.regexp.mobile.test(this.phone)){
                util.tips('手机号码错误！');
                return;
            }
            if(this.verification.length<1){
                util.tips('请输入验证码！');
                return;
            }
            $.ajax({
                url: "/advertiser/login/register",
                dataType: 'json',
                type:"post",
                data:{
                    userName:this.userName,
                    password:this.password,
                    againPassword:this.againPassword,
                    phone:this.phone,
                    verification:this.verification
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/advertiser/index/saveInfo';
                    }else{
                        util.tips(res.msg)
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        }
    }
});
