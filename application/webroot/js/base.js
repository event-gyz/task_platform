/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        city:[],
        name:'',//姓名
        sex:'',//性别
        phone:'',//电话
        schoolName:'',//学校名称
        schoolType:'',//学校类型
        schoolAddress:'',//学校地址
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
            var params = window.location.search.substr(1).split('&');
            params.forEach(function(item){
                var name = item.split('=')[0];
                var val = item.split('=')[1];
                if(name == 'phone'){
                    _this.phone = val;
                }
            });
            $.ajax({
                url: "/js/third/city.json",
                dataType: 'json',
                success: function(res) {
                    _this.city = res.RECORDS;
                    setCity();
                }
            });
            function setCity(){
                var params = window.location.search.substr(1).split('&');
                params.forEach(function(item){
                    var name = item.split('=')[0];
                    var val = item.split('=')[1];
                    if(name == 'flag'){
                        _this.flag = val;
                    }
                });
                if(_this.flag == 2){
                    function schoolType(n){
                        if(n==1){
                            return '工科';
                        }else if(n==2){
                            return '医药';
                        }else if(n==3){
                            return '财经';
                        }else if(n==4){
                            return '师范';
                        }else if(n==5){
                            return '综合';
                        }else if(n==6){
                            return '农业';
                        }else if(n==7){
                            return '理工';
                        }else if(n==8){
                            return '化工';
                        }else if(n==9){
                            return '海洋';
                        }else if(n==10){
                            return '艺术';
                        }else if(n==11){
                            return '政法';
                        }
                    }
                    function schoolLevel(n){
                        if(n==1){
                            return '211/985';
                        }else if(n==2){
                            return '本科';
                        }else if(n==3){
                            return '专科';
                        }
                    }
                    function schoolCity(s,c,q){
                        var s1 = {};
                        var s2 = {};
                        var s3 = {};
                        _this.city.forEach(function(item){
                            if(s == item.id){
                                s1 = item;
                            }
                        });
                        _this.city.forEach(function(item){
                            if(c == item.id && s1.id == item.pid ){
                                s2 = item;
                            }
                        });
                        _this.city.forEach(function(item){
                            if(q == item.id && s2.id == item.pid ){
                                s3 = item;
                            }
                        });
                        return s1.name+' '+s2.name+' '+s3.name;
                    }
                    $.ajax({
                        url: "/media/index/userInfoApi",
                        dataType: 'json',
                        type:"post",
                        data:{},
                        success: function(res) {
                            if(res.errorno > 0){
                                var data = res.data;
                                _this.name=data.media_man_name;//姓名
                                _this.sex=data.sex==1?'男':'女';//性别
                                _this.phone=data.media_man_phone;//电话
                                _this.schoolName=data.school_name;//学校名称
                                _this.schoolType=schoolType(data.school_type);//学校类型
                                _this.schoolAddress=schoolCity(data.school_province,data.school_city,data.school_area);//学校地址
                                _this.schoolLevel=schoolLevel(data.school_level);//学校层次
                                _this.age=data.age;//年龄
                                _this.liking=data.hobby.split(',');//爱好
                                _this.industry=data.industry;//行业
                                _this.zfbNumber=data.zfb_nu;//支付宝账号
                                _this.zfbName=data.zfb_realname;//支付宝真实姓名
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


            $("#sex").picker({
                title: "请选择性别",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['男','女']
                    }
                ],
                onOpen:function(){
                    $('input').blur();
                },
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
                onOpen:function(){
                    $('input').blur();
                },
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
                onOpen:function(){
                    $('input').blur();
                },
                onChange:function(p, values, displayValues){
                    _this.schoolLevel = values[0];
                }
            });
            $("#schoolAddress").cityPicker({
                title: "请选择学校地区",
                onOpen:function(){
                    $('input').blur();
                },
                onChange:function(p, values, displayValues){
                    _this.schoolAddress = displayValues.join(' ');
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
            if(!this.schoolAddress){
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
                url: "/media/index/saveBaseInfo",
                dataType: 'json',
                type:"post",
                data:{
                    name:this.name,//姓名
                    sex:this.sexFn(),//性别
                    phone:this.phone,//电话
                    schoolName:this.schoolName,//学校名称
                    schoolType:this.schoolTypeFn(),//学校类型
                    schoolAddress:this.schoolAddressFn(),//学校地址
                    schoolLevel:this.schoolLevelFn(),//学校层次
                    age:this.age,//年龄
                    liking:this.liking,//爱好
                    industry:this.industry,//行业
                    zfbNumber:this.zfbNumber,//支付宝账号
                    zfbName:this.zfbName//支付宝真实姓名
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/media/index/savePromotedInfo?flag=2';
                    }else{
                        util.tips(res.msg)
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        },
        //学校类型转换
        schoolTypeFn: function(){
            if(this.schoolType == '工科'){
                return 1;
            }else if(this.schoolType == '医药'){
                return 2;
            }else if(this.schoolType == '财经'){
                return 3;
            }else if(this.schoolType == '师范'){
                return 4;
            }else if(this.schoolType == '综合'){
                return 5;
            }else if(this.schoolType == '农业'){
                return 6;
            }else if(this.schoolType == '理工'){
                return 7;
            }else if(this.schoolType == '化工'){
                return 8;
            }else if(this.schoolType == '海洋'){
                return 9;
            }else if(this.schoolType == '艺术'){
                return 10;
            }else if(this.schoolType == '政法'){
                return 11;
            }
        },
        //地址转换
        schoolAddressFn: function(){
            var arr = this.schoolAddress.split(' ');
            var s1 = {};
            var s2 = {};
            var s3 = {};
            this.city.forEach(function(item){
                if(arr[0] == item.name){
                    s1 = item;
                }
            });
            this.city.forEach(function(item){
                if(arr[1] == item.name && s1.id == item.pid ){
                    s2 = item;
                }
            });
            this.city.forEach(function(item){
                if(arr[2] == item.name && s2.id == item.pid ){
                    s3 = item;
                }
            });
            var str = s1.id+','+s2.id+','+s3.id;
            return str;
        },
        //转换学校层次
        schoolLevelFn:function(){
            if(this.schoolLevel == '211/985'){
                return 1;
            }else if(this.schoolLevel == '本科'){
                return 2;
            }else if(this.schoolLevel == '专科'){
                return 3;
            }
        },
        //转换性别
        sexFn:function(){
            if(this.sex == '男'){
                return 1;
            }else if(this.sex == '女'){
                return 2;
            }
        }
    }
});
