/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        wx:'',//微信号
        wxType:'',//微信号类型
        wxNumber:'',//微信最高粉丝量
        wb:'',//微博昵称
        wbType:'',//微博号类型
        wbNumber:'',//微博最高粉丝量
        wbUrl:''//微博链接
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this =this;
            var params = window.location.search.substr(1).split('&');
            params.forEach(function(item){
                var name = item.split('=')[0];
                var val = item.split('=')[1];
                if(name == 'flag'){
                    _this.flag = val;
                }
            });
            if(_this.flag == 2){
                function wxType(n){
                    if(n==1){
                        return '个人账号';
                    }else if(n==2){
                        return '企业号';
                    }else if(n==3){
                        return '订阅号';
                    }else if(n==4){
                        return '服务号';
                    }
                }
                function wbType(n){
                    if(n==1){
                        return '普通用户';
                    }else if(n==2){
                        return '个人认证微博号';
                    }else if(n==3){
                        return '机构认证微博号';
                    }
                }
                $.ajax({
                    url: "/media/index/userInfoApi",
                    dataType: 'json',
                    type:"post",
                    data:{},
                    success: function(res) {
                        if(res.errorno > 0){
                            var data = res.data;
                            _this.wx=data.wx_code;//微信号
                            _this.wxType=wxType(data.wx_type);//微信号类型
                            _this.wxNumber=data.wx_max_fans;//微信最高粉丝量
                            _this.wb=data.weibo_nickname;//微博昵称
                            _this.wbType=wbType(data.weibo_type);//微博号类型
                            _this.wbNumber=data.weibo_max_fans;//微博最高粉丝量
                            _this.wbUrl=data.weibo_link;//微博链接
                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            }
            $("#wx_type").picker({
                title: "请选择微信账号类型",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['个人账号','企业号','订阅号','服务号']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.wxType = values[0];
                }
            });
            $("#wb_type").picker({
                title: "请选择微博账号类型",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['普通用户','个人认证微博号','机构认证微博号']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.wbType = values[0];
                }
            });
        });
    },
    methods:{
        //微信转换
        wxTransform: function(str){
            if(str =='个人账号'){
                return 1;
            }else if(str =='企业号'){
                return 2;
            }else if(str =='订阅号'){
                return 3;
            }else if(str =='服务号'){
                return 4;
            }
        },
        //微博转换
        wbTransform: function(str){
            if(str =='普通用户'){
                return 1;
            }else if(str =='个人认证微博号'){
                return 2;
            }else if(str =='机构认证微博号'){
                return 3;
            }
        },
        save: function(){
            var _this = this;
            if(!this.wx){
                util.tips('请输入微信号！');
                return;
            }
            if(!this.wxType){
                util.tips('请选择微信号类型！');
                return;
            }
            if(!this.wxNumber){
                util.tips('请输入微信最高粉丝量！');
                return;
            }
            if(!this.wb){
                util.tips('请输入微博昵称！');
                return;
            }
            if(!this.wbType){
                util.tips('请选择微博类型！');
                return;
            }
            if(!this.wbNumber){
                util.tips('请输入微博最高粉丝量！');
                return;
            }
            if(!this.wbUrl){
                util.tips('请输入微博链接！');
                return;
            }else if(!util.regexp.url.test(this.wbUrl)){
                util.tips('微博链接格式错误！');
                return;
            }
            $.ajax({
                url: "/media/index/savePromotedInfo",
                dataType: 'json',
                type:"post",
                data:{
                    wx_code:this.wx,//微信号
                    wx_type:this.wxTransform(this.wxType),//微信号类型
                    wx_max_fans:this.wxNumber,//微信最高粉丝量
                    weibo_nickname:this.wb,//微博昵称
                    weibo_type:this.wbTransform(this.wbType),//微博号类型
                    weibo_max_fans:this.wbNumber,//微博最高粉丝量
                    weibo_link:this.wbUrl//微博链接
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/media/login/accountStatus6';
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
