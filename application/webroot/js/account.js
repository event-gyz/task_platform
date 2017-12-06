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
                    wx:this.wx,//微信号
                    wxType:this.wxTransform(this.wxType),//微信号类型
                    wxNumber:this.wxNumber,//微信最高粉丝量
                    wb:this.wb,//微博昵称
                    wbType:this.wbTransform(this.wbType),//微博号类型
                    wbNumber:this.wbNumber,//微博最高粉丝量
                    wbUrl:this.wbUrl//微博链接
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
