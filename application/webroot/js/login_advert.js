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
                    url: "xxx",
                    dataType: 'json',
                    type:"post",
                    data:{
                        userName: this.userName,
                        password: this.password
                    },
                    success: function(res) {
                        if(res.errorno > 0){

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
