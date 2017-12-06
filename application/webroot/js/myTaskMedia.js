/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        total:0,
        page:1,
        lists:[]
    },
    mounted:function(){
        this.$nextTick(function(){
            this.initAjax();
            var loading = false;  //状态标记
            $(document.body).infinite().on("infinite", function() {
                if(loading) return;
                loading = true;
                setTimeout(function() {

                    loading = false;
                }, 1500);   //模拟延迟
            });
        });
    },
    methods:{
        initAjax:function(){
            var _this = this;
            $.ajax({
                url: "/media/index/taskListApi",
                dataType: 'json',
                type:"post",
                data:{page:1},
                success: function(res) {
                    if(res.errorno >= 0){
                        //开始初始化赋值
                        _this.lists = _this.lists.concat(res.data.list);
                        _this.total = res.data.total;
                    }else if(res.errorno == -1){
                        _this.lists = [];
                    }
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
        //当前状态
        task_status: function(obj){
            function time(){return parseInt(moment().valueOf()/1000);}
            if(obj.release_status == 9){
                return '已关闭';
            }else if(obj.release_status==7){
                return '已结束';
            }else if(obj.release_status==1 && obj.receive_status==1 && (obj.time>obj.start_time)){
                return '未开始';
            }else if(obj.release_status==1 && obj.receive_status==1 && (time()>obj.start_time)&&time()<obj.end_time&&obj.deliver_status!=1){
                return '执行中';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==0){
                return '交付待审核';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==2){
                return '交付审核失败';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==1 && obj.finance_status!=1){
                return '待财务确认';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==1 && obj.finance_status==1 && obj.receivables_status!=1){
                return '待确认收款';
            }else if(obj.receive_status==1 && obj.deliver_status==1 && obj.finance_status==1 && obj.receivables_status==1){
                return '已完成';
            }else if(obj.receive_status==1 && obj.deliver_audit_status!=1 && (time()>obj.end_time)){
                return '未完成';
            }else if(obj.receive_status==2){
                return '已拒绝';
            }
        },
        //状态class
        task_status_class: function(obj){
            function time(){return parseInt(moment().valueOf()/1000);}
            if(obj.release_status == 9){
                return 'close';
            }else if(obj.release_status==7){
                return 'close';
            }else if(obj.release_status==1 && obj.receive_status==1 && (obj.time>obj.start_time)){
                return 'wait';
            }else if(obj.release_status==1 && obj.receive_status==1 && (time()>obj.start_time)&&time()<obj.end_time&&obj.deliver_status!=1){
                return 'proceed';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==0){
                return 'wait';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==2){
                return 'wait';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==1 && obj.finance_status!=1){
                return 'wait';
            }else if(obj.release_status==1 && obj.receive_status==1 && obj.deliver_status==1 && obj.deliver_audit_status==1 && obj.finance_status==1 && obj.receivables_status!=1){
                return 'wait';
            }else if(obj.receive_status==1 && obj.deliver_status==1 && obj.finance_status==1 && obj.receivables_status==1){
                return 'end';
            }else if(obj.receive_status==1 && obj.deliver_audit_status!=1 && (time()>obj.end_time)){
                return 'wait';
            }else if(obj.receive_status==2){
                return 'close';
            }
        }

    }
});