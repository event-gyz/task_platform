/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        userName:'',
        password:''
    },
    mounted:function(){},
    methods:{
        save: function(){
            var _this = this;
            if(this.userName && this.password){
                $.ajax({
                    url: "/advertiser/login/login",
                    dataType: 'json',
                    type:"post",
                    data:{
                        userName: this.userName,
                        password: this.password
                    },
                    success: function(res) {
                        if(res.errorno > 0){
                            // 登录成功
                            if(res.errorno == 1){
                                location.href='/advertiser/index/home';
                                // 未完善基础信息
                            }else if (res.errorno == 2){
                                location.href='/advertiser/index/person?phone='+ res.data.advertiser_phone + '&flag=2';
                                // 待审核
                            }else if (res.errorno == 3){
                                location.href='/advertiser/login/accountStatus3';
                                // 驳回
                            }else if (res.errorno == 4){
                                location.href='/advertiser/login/accountStatus4';
                                // 冻结
                            }else if (res.errorno == 5){
                                location.href='/advertiser/login/accountStatus5';
                            }
                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            }else{
                util.tips('请输入用户名和密码！');
            }
        }
    }
});
