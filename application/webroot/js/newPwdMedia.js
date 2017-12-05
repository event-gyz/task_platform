/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        password:'',
        againPassword:''
    },
    mounted:function(){},
    methods:{
        //提交
        save: function(){
            if(!this.password || !(this.password.length>=6 && this.password.length<=12) || !(util.regexp.isNum.test(this.password) && util.regexp.isZM.test(this.password))){
                util.tips('密码必须是6-12位英文和数字组合！');
                return;
            }
            if(this.againPassword !== this.password){
                util.tips('两次密码不同！');
                return;
            }
            $.ajax({
                url: "/media/login/updatePwd",
                dataType: 'json',
                type:"post",
                data:{
                    password:this.password,
                    againPassword:this.againPassword
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/media/index/home';
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
