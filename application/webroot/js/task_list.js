/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
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
    }
});
