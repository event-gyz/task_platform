var swiper = new Swiper('.swiper-container', {
    pagination : '.swiper-pagination',
    loop : true,
    autoplay: 5000
});

// 确认收款
$('.confirmReceivables').click(function(){
    var task_id = window.location.search.substr(1).split('=')[1];
    util.confirm('确认执行该操作吗？',function(){
        $.ajax({
            url: "/media/index/receivables",
            dataType: 'json',
            type:"post",
            data:{
                task_id: task_id,
            },
            success: function(res) {
                if(res.errorno > 0){
                    location.reload();
                }else{
                    util.tips(res.msg)
                }
            },
            error:function(){
                util.tips('网络异常，请尝试刷新！');
            }
        })
    },function(){})
});