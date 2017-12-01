/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        name:'',//姓名
        sex:'',//性别
        phone:'',//电话
        schoolName:'',//学校名称
        schoolType:'',//学校类型
        schoolAdress:'',//学校地址
        schoolLevel:'',//学校层次
        age:'',//年龄
        liking:[],//爱好
        industry:'',//行业
        zfbNumber:'',//支付宝账号
        zfbName:''//支付宝真实姓名
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this = this;
            $("#sex").picker({
                title: "请选择性别",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['男','女']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.sex = values[0];
                }
            });
            $("#schoolType").picker({
                title: "请选择学校类型",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['工科','医药','财经','师范','综合','农业','理工','化工','海洋','艺术','政法']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.schoolType = values[0];
                }
            });
            $("#schoolLevel").picker({
                title: "请选择学校层次",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['211/985','本科','专科']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.schoolLevel = values[0];
                }
            });
            $("#schoolAdress").cityPicker({
                title: "请选择学校地区",
                onChange:function(p, values, displayValues){
                    _this.schoolAdress = displayValues.join(' ');
                }
            });
        });
    },
    methods:{
        //设置年龄
        setAge: function(name){
            this.age= name;
        },
        //设置兴趣爱好
        setLiking: function(name){
            if(this.liking.indexOf(name)!=-1){
                var index= this.liking.indexOf(name);
                this.liking.splice(index,1);
            }else{
                this.liking.push(name);
            }
        },
        //设置行业
        setIndustry: function(name){
            this.industry= name;
        },
        save: function(){
            var _this = this;
            if(!this.name){
                util.tips('请输入您的姓名！');
                return;
            }
            if(!this.phone){
                util.tips('请输入您的手机号！');
                return;
            }else if(!util.regexp.mobile.test(this.phone)){
                util.tips('手机号格式错误！');
                return;
            }
            if(!this.sex){
                util.tips('请选择性别！');
                return;
            }
            if(!this.schoolName){
                util.tips('请输入学校名称！');
                return;
            }
            if(!this.schoolType){
                util.tips('请选择学校类型！');
                return;
            }
            if(!this.schoolAdress){
                util.tips('请选择学校地址！');
                return;
            }
            if(!this.schoolLevel){
                util.tips('请选择学校层次！');
                return;
            }
            if(!this.age){
                util.tips('请选择朋友眼中的年龄！');
                return;
            }
            if(!this.liking.length){
                util.tips('请选择爱好！');
                return;
            }
            if(!this.industry){
                util.tips('请选择行业！');
                return;
            }
            if(!this.zfbNumber){
                util.tips('请输入支付宝账号！');
                return;
            }
            if(!this.zfbName){
                util.tips('请输入真实姓名！');
                return;
            }
            $.ajax({
                url: "xxx",
                dataType: 'json',
                type:"post",
                data:{
                    name:this.name,//姓名
                    sex:this.sex,//性别
                    phone:this.phone,//电话
                    schoolName:this.schoolName,//学校名称
                    schoolType:this.schoolType,//学校类型
                    schoolAdress:this.schoolAdress,//学校地址
                    schoolLevel:this.schoolLevel,//学校层次
                    age:this.age,//年龄
                    liking:this.liking,//爱好
                    industry:this.industry,//行业
                    zfbNumber:this.zfbNumber,//支付宝账号
                    zfbName:this.zfbName//支付宝真实姓名
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
        }
    }
});
