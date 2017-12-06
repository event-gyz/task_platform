/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        loading:false,//状态标记
        total:100,
        page:1,
        lists:[]
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this = this;
            this.initAjax(1);
            $(document.body).infinite().on("infinite", function() {
                if(!_this.loading&&_this.total>_this.page*10){
                    _this.loading = true;
                    _this.initAjax(_this.page++);
                }
            });
        });
    },
    methods:{
        initAjax:function(n){
            var _this = this;
            $.ajax({
                url: "/media/index/getMissionHall",
                dataType: 'json',
                type:"post",
                data:{page:n},
                success: function(res) {
                    if(res.errorno >= 0){
                        //开始初始化赋值
                        _this.lists = _this.lists.concat(res.data.list);
                        _this.total = res.data.total;
                        _this.page = res.data.page;
                        if(_this.total<=_this.page*10){
                            $('.weui-loadmore').hide();
                        }
                    }else if(res.errorno<0 ){//无任务
                        $('.weui-loadmore').hide();
                    }
                    _this.loading = false;
                    $('.my_task').show();
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        },
        //任务类型
        typeFn: function(n){
            if(n==1){
                return '线下执行';
            }else if(n==2){
                return '线上传播';
            }else if(n==3){
                return '调查收集';
            }else if(n==4){
                return '其他';
            }
        },
        //平台
        platformFn: function(str){
            var arr = str.split(',');
            var strArr = [];
            arr.forEach(function(item){
                if(item == 1){
                    strArr.push('微信');
                }
                if(item == 2){
                    strArr.push('微博');
                }
            });
            return strArr.join('、');
        },
        //时间
        timeFn: function(s,e){
            var s = moment(Number(s)).format('MM-DD');
            var e = moment(Number(e)).format('MM-DD');
            return s+' ~ '+e;
        },
        //领取
        pick: function(id){
            $.ajax({
                url: "/media/index/acceptTask  ",
                dataType: 'json',
                type:"post",
                data:{task_id:id},
                success: function(res) {
                    if(res.errorno >= 0){
                        util.alert('任务领取成功！',function(){
                            location.reload();
                        })
                    }else{
                        util.alert('操作失败，请稍后再试！')
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        },
        reject: function(id){
            util.confirm('确认要此执行操作吗？',function(){
                $.ajax({
                    url: "/media/index/refuseTask",
                    dataType: 'json',
                    type:"post",
                    data:{task_id:id},
                    success: function(res) {
                        if(res.errorno >= 0){
                            util.alert('任务已拒绝！',function(){
                                location.reload();
                            })
                        }else{
                            util.alert('操作失败，请稍后再试！')
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            },function(){})
        }
    }
});
