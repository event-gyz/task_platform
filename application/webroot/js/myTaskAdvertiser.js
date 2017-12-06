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
                url: "/advertiser/index/taskListApi",
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
        //当前状态
        task_status: function(obj){
            function time(){return parseInt(moment().valueOf()/1000);}
            if(obj.release_status == 2){
                return '已完成';
            }else if(obj.release_status==7){
                return '已结束';
            }else if(obj.release_status==8){
                return '手工作废';
            }else if(obj.release_status==9){
                return '已关闭';
            }else if((obj.audit_status == 0) && (obj.release_status == 0)){
                return '待提交';
            }else if((obj.audit_status == 1) && (boj.release_status == 0)){
                return '待审核';
            }else if((obj.audit_status == 2) && (obj.release_status == 0)){
                return '驳回';
            }else if((obj.audit_status == 3) && (obj.release_status == 0) && (obj.pay_status == 0)){
                return '待付款';
            }else if((obj.audit_status == 3) && (obj.release_status == 0) && (obj.pay_status == 1) && (obj.finance_status != 1)){
                return '待财务确认收款';
            }else if((obj.audit_status == 3) && (obj.release_status == 0) && (obj.pay_status == 1) && (obj.finance_status == 1)){
                return '待发布';
            }else if(obj.release_status == 1 && (time()>obj.start_time)){
                return '待开始';
            }else if(obj.release_status == 1 && (time()<obj.start_time) && (time()>obj.end_time)){
                return '执行中';
            }
        },
        //状态class
        task_status_class: function(obj){
            function time(){return parseInt(moment().valueOf()/1000);}
            if(obj.release_status == 2){
                return 'end';
            }else if(obj.release_status == 1 && (time()<obj.start_time) && (time()>obj.end_time)){
                return 'proceed';
            }else if(obj.release_status==9){
                return 'close';
            }else{
                return 'wait';
            }
        }
    }
});





/*
 已完成
 $release_status == 2

 已结束
 $release_status == 7

 手工作废
 $release_status == 8

 已关闭
 $release_status == 9

待提交(修改，提交，结束)
($audit_status == 0) && ($release_status == 0)

待审核
($audit_status == 1) && ($release_status == 0)

驳回(修改，结束)
($audit_status == 2) && ($release_status == 0)

待付款(确认付款，结束)
($audit_status == 3) && ($release_status == 0) && ($pay_status == 0)

待财务确认收款(结束)
    ($audit_status == 3) && ($release_status == 0) && ($pay_status == 1) && ($finance_status != 1)

待发布(当前时间减$start_time大于12小时，显示结束按钮)
($audit_status == 3) && ($release_status == 0) && ($pay_status == 1) && ($finance_status == 1)

待开始
$release_status == 1 && (time()>$start_time)

执行中
$release_status == 1 && (time()<$start_time) && (time()>$end_time)
*/
