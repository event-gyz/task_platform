/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        audit_status:0,
        taskName:'',//任务名称
        taskType:'',//任务类型
        taskTitle:'',//任务标题
        taskUrl:'',//任务链接
        taskImg:[],//任务图片
        taskDes:'',//任务描述
        taskPrice:'',//任务单价
        numAsk:2,//账号要求（1=有要求，2=无要求）
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
        initCity:[{'name':'北京',id:1},{'name':'上海',id:2},{'name':'广州',id:3}],
        city:[]//地域
    },
    mounted:function(){
        this.$nextTick(function(){
            $('.index_advert').show();
            var _this =this;
            this.initAjax();//初始化获取值
            this.setTime();
            $.ajax({
                url: "/advertiser/index/getAllUseCity",
                dataType: 'json',
                type:"post",
                data:{},
                success: function(res) {
                    if(res.errorno >= 0){
                        _this.initCity = res.data;
                    }else{
                        util.tips(res.msg)
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            });
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
                debug: false,
                appId: $('#appId').val(),
                timestamp: $('#timestamp').val(),
                nonceStr: $('#nonceStr').val(),
                signature: $('#signature').val(),
                jsApiList: [
                    'chooseImage',
                    'uploadImage',
                    'downloadImage',
                    'previewImage'
                ]
            });
        })
    },
    methods:{
        initAjax: function(){
            var _this = this;
            var task_id = window.location.search.substr(1).split('=')[1];
            if(task_id){
                $.ajax({
                    url: "/advertiser/index/taskInfoApi",
                    dataType: 'json',
                    type:"post",
                    data:{task_id:task_id},
                    success: function(res) {
                        if(res.errorno >= 0){
                            var data = res.data;
                            var task_type = [];
                            data.task_type.split(',').forEach(function(item){
                                if(item == 1){
                                    task_type = '线下执行';
                                }else if(item == 2){
                                    task_type = '线上传播';
                                }else if(item == 3){
                                    task_type = '调查收集';
                                }else if(item == 4){
                                    task_type = '其他';
                                }
                            });
                            _this.audit_status = data.audit_status;
                            _this.taskName= data.task_name;//任务名称
                            _this.taskType= task_type;//任务类型
                            _this.taskTitle= data.title;//任务标题
                            _this.taskUrl= data.link;//任务链接
                            _this.taskImg= JSON.parse(data.pics);//任务图片
                            _this.taskDes= data.task_describe;//任务描述
                            _this.taskPrice= data.price;//任务单价
                            _this.numAsk= data.media_man_require;//账号要求（1=有要求，2=无要求）
                            _this.startTime= moment(Number(data.start_time)*1000).format('YYYY-MM-DD');//任务开始时间
                            _this.endTime= moment(Number(data.end_time)*1000).format('YYYY-MM-DD');//任务结束时间
                            _this.platform= data.publishing_platform.split(',');//发布平台
                            _this.number= data.media_man_number;//账号数量
                            _this.endStandard= data.completion_criteria.split(',');//完成标准
                            _this.sex= data.require_sex;//性别(0=不限，1=男，2=女)（账号要求）
                            _this.age= data.require_age.split(',');//年龄（账号要求）
                            _this.liking= data.require_hobby.split(',');//兴趣爱好（账号要求）
                            _this.industry= data.require_industry.split(',');//行业（账号要求）
                            _this.city= data.require_local.split(',');//地域
                            _this.task_id = task_id;//id
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
            var index= this.taskImg.indexOf(item);
            this.taskImg.splice(index,1);
        },
        uploadImg: function(){
            var _this = this;
            wx.chooseImage({
                count: 9,
                sizeType: ['compressed'],
                sourceType: ['album', 'camera'],
                success: function (res) {
                    var localIds = res.localIds.split(','); // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    _this.taskImg.concat(localIds);
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
        //转换
        strByNum: function(str){
            if(str == '线下执行'){
                return 1;
            }else if(str == '线上传播'){
                return 2;
            }else if(str == '调查收集'){
                return 3;
            }else if(str == '其他'){
                return 4;
            }
        },
        save: function(n){//n==0是保存，n==1是提交
            var _this = this;
            if(n==1){
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
                    audit_status:n,//0是保存，1是提交
                    task_id: this.task_id,
                    taskName:this.taskName,//任务名称
                    taskType:this.strByNum(this.taskType),//任务类型
                    taskTitle:this.taskTitle,//任务标题
                    taskUrl:this.taskUrl,//任务链接
                    taskImg:this.taskImg,//任务图片
                    taskDes:this.taskDes,//任务描述
                    taskPrice:this.taskPrice,//任务单价
                    numAsk:this.numAsk,//账号要求（1=有要求，2=无要求）
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
                    if(res.errorno >= 0){
                        if(n==1){
                            location.href='/advertiser/index/taskSubmitSuccessView?task_id='+res.data;
                        }else {
                            location.href='/advertiser/index/taskSaveSuccessView?task_id='+res.data;
                        }

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
