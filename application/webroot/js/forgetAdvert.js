/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        time:0,
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
                        phone: this.phone,
                        password: this.password
                    },
                    success: function(res) {
                        if(res.errorno >0){
                            _this.time = 90;
                            var timer = setInterval(function(){_this.time--;if(_this.time<1){clearInterval(timer)}},1000);
                        }else{
                            util.tips()
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
            if(!util.regexp.mobile.test(this.phone)){
                util.tips('手机号码错误！');
                return;
            }
            if(this.verification.length<1){
                util.tips('请输入验证码！');
                return;
            }
            $.ajax({
                url: "xxx",
                dataType: 'json',
                type:"post",
                data:{
                    phone:this.phone,
                    verification:this.verification
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/new_pwd.html';
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
