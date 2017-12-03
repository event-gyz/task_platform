/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        taskName:'',//任务名称
        taskType:'',//任务类型
        taskTitle:'',//任务标题
        taskUrl:'',//任务链接
        taskImg:[1],//任务图片
        taskDes:'',//任务描述
        taskPrice:'',//任务单价
        numAsk:0,//账号要求（1=有要求，0=无要求）
        startTime:'',//任务开始时间
        endTime:'',//任务结束时间
        platform:[],//发布平台
        number:'',//账号数量
        total:'',//任务总价
        endStandard:[],//完成标准
        sex:0,//性别(0=不限，1=男，2=女)（账号要求）
        age:[],//年龄（账号要求）
        liking:[],//兴趣爱好（账号要求）
        industry:[],//行业（账号要求）
        city:[]//地域
    },
    mounted:function(){
        this.$nextTick(function(){
            $('.index_advert').show();
            var _this =this;
            this.initAjax();//初始化获取值
            this.setTime();

            $("#task_type").picker({
                title: "请选择任务类型",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['线下执行','线上传播','调查收集','其他']
                    }
                ],
                onChange:function(p, values, displayValues){
                    _this.taskType = values[0];
                }
            });
            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: 'aaa', // 必填，企业号的唯一标识，此处填写企业号corpid
                timestamp: '123123', // 必填，生成签名的时间戳
                nonceStr: 'sdfsdfsfd', // 必填，生成签名的随机串
                signature: 'eeee',// 必填，签名，见附录1
                jsApiList: [
                    'chooseImage',
                    'uploadImage',
                    'downloadImage',
                    'previewImage'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });
        })
    },
    methods:{
        initAjax: function(){
            var id = window.location.search.substr(1).split('=')[1];
            if(id){
                $.ajax({
                    url: "xxx",
                    dataType: 'json',
                    type:"post",
                    data:{},
                    success: function(res) {
                        if(res.errorno > 0){
                            //开始初始化赋值
                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            }
        },
        setTime: function(){
            var _this = this;
            $("#start_time").calendar({
                minDate: moment().subtract(1, 'day').format('YYYY-MM-DD'),
                onChange:function(p, values, displayValues){
                    _this.startTime=values[0];
                    var endTime = values;
                    if(_this.endTime){
                        if(moment(_this.endTime).valueOf()>moment(values[0]).valueOf()){
                            endTime = [_this.endTime];
                        }else{
                            endTime = values;
                            _this.endTime = values[0];
                        }
                    }
                    $("#end_time").calendar({
                        value: endTime,
                        minDate: moment(moment(values[0]).valueOf()).subtract(1, 'day').format('YYYY-MM-DD'),
                        onChange:function(p, values, displayValues){
                            _this.endTime=values[0];
                        },
                        onClose: function(){
                            $('.weui-picker-container').remove();
                        }
                    });
                },
                onClose: function(){
                    $('.weui-picker-container').remove();
                }
            });
            $("#end_time").calendar({
                minDate: moment().subtract(1, 'day').format('YYYY-MM-DD'),
                onChange:function(p, values, displayValues){
                    _this.endTime=values[0];
                },
                onClose: function(){
                    $('.weui-picker-container').remove();
                }
            });
        },
        removeImg: function(item){
            var index= this.taskImg.indexOf(name);
            this.taskImg.splice(index,1);
        },
        uploadImg: function(){
            var _this = this;
            wx.chooseImage({
                count: 1,
                sizeType: ['compressed'],
                sourceType: ['album', 'camera'],
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    _this.taskImg.push(localIds);
                }
            });
        },
        //设置发布平台
        setPlatform: function(name){
            if(this.platform.indexOf(name)!=-1){
                var index= this.platform.indexOf(name);
                this.platform.splice(index,1);
            }else{
                this.platform.push(name);
            }
        },
        //设置完成标准
        setEndStandard: function(name){
            if(this.endStandard.indexOf(name)!=-1){
                var index= this.endStandard.indexOf(name);
                this.endStandard.splice(index,1);
            }else{
                this.endStandard.push(name);
            }
        },
        //设置年龄
        setAge: function(name){
            if(this.age.indexOf(name)!=-1){
                var index= this.age.indexOf(name);
                this.age.splice(index,1);
            }else{
                this.age.push(name);
            }
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
            if(this.industry.indexOf(name)!=-1){
                var index= this.industry.indexOf(name);
                this.industry.splice(index,1);
            }else{
                this.industry.push(name);
            }
        },
        //设置地域
        setCity: function(name){
            if(this.city.indexOf(name)!=-1){
                var index= this.city.indexOf(name);
                this.city.splice(index,1);
            }else{
                this.city.push(name);
            }
        },
        //设置性别
        setSex: function(n){
            this.sex = n;
        },
        save: function(n){//n==1是保存，n==2是提交
            var _this = this;
            if(n==2){
                if(!this.taskName){
                    util.tips('请输入任务名称！');
                    return;
                }
                if(!this.taskType){
                    util.tips('请选择任务类型！');
                    return;
                }
                if(!this.taskTitle){
                    util.tips('请输入任务标题！');
                    return;
                }
                if(!this.taskUrl){
                    util.tips('请输入任务链接！');
                    return;
                }else if(!util.regexp.url.test(this.taskUrl)){
                    util.tips('任务链接格式错误！');
                    return;
                }
                if(!this.taskImg.length){
                    util.tips('请上传任务照片！');
                    return;
                }
                if(!this.taskDes){
                    util.tips('请输入任务描述！');
                    return;
                }
                if(!this.taskPrice){
                    util.tips('请输入任务单价！');
                    return;
                }
                if(!this.startTime){
                    util.tips('请选择任务开始时间！');
                    return;
                }
                if(!this.endTime){
                    util.tips('请选择任务结束时间！');
                    return;
                }
                if(!this.platform.length){
                    util.tips('请选择任务发布平台！');
                    return;
                }
                if(!this.number){
                    util.tips('请输入账号数量！');
                    return;
                }
                if(!this.endStandard.length){
                    util.tips('请选择任务完成标准！');
                    return;
                }
                if(this.numAsk == 1){

                    if(!this.age.length){
                        util.tips('请选择账号要求年龄！');
                        return;
                    }
                    if(!this.liking.length){
                        util.tips('请选择账号要求兴趣爱好！');
                        return;
                    }
                    if(!this.industry.length){
                        util.tips('请选择账号要求行业！');
                        return;
                    }
                    if(!this.city.length){
                        util.tips('请选择账号要求地域！');
                        return;
                    }
                }
            }
            $.ajax({
                url: "/advertiser/index/saveTask",
                dataType: 'json',
                type:"post",
                data:{
                    taskName:this.taskName,//任务名称
                    taskType:this.taskType,//任务类型
                    taskTitle:this.taskTitle,//任务标题
                    taskUrl:this.taskUrl,//任务链接
                    taskImg:this.taskImg,//任务图片
                    taskDes:this.taskDes,//任务描述
                    taskPrice:this.taskPrice,//任务单价
                    numAsk:this.numAsk,//账号要求（1=有要求，0=无要求）
                    startTime:this.startTime+' 00:00:00',//任务开始时间
                    endTime:this.endTime+' 23:59:59',//任务结束时间
                    platform:this.platform,//发布平台
                    number:this.number,//账号数量
                    total:this.total,//任务总价
                    endStandard:this.endStandard,//完成标准
                    sex:this.sex,//性别(0=不限，1=男，2=女)（账号要求）
                    age:this.age,//年龄（账号要求）
                    liking:this.liking,//兴趣爱好（账号要求）
                    industry:this.industry,//行业（账号要求）
                    city:this.city//地域
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/advertiser/index/taskSubmitSuccessView?task_id='+res.data;
                    }else{
                        util.tips(res.msg)
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        }
    },
    watch:{
        number: function (curVal,oldVal) {
            if(this.taskPrice){
                this.total = '￥'+parseInt(this.taskPrice*curVal);
            }
        },
        taskPrice: function(curVal,oldVal){
            if(this.number){
                this.total = '￥'+parseInt(this.taskPrice*curVal);
            }
        }
    }
});
