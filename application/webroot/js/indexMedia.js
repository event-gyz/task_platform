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
                task_id: task_id
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


// 接受任务
$('.accept').click(function(){
    var task_id = window.location.search.substr(1).split('=')[1];
    var task_name = $("#task_name").text();
    util.confirm('确认执行该操作吗？',function(){
        $.ajax({
            url: "/media/index/acceptTask",
            dataType: 'json',
            type:"post",
            data:{
                task_id: task_id
            },
            success: function(res) {
                if(res.errorno > 0){
                    util.tips("领取任务"+task_name+"成功，请按时完成任务并提交完成结果");
                    location.href='/media/index/taskDetail?task_id='+task_id;
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



// 拒绝任务
$('.refuse').click(function(){
    var task_id = window.location.search.substr(1).split('=')[1];
    var task_name = $("#task_name").text();
    util.confirm('确定要拒绝任务'+task_name+'吗，拒绝后不可再领取!',function(){
        $.ajax({
            url: "/media/index/refuseTask",
            dataType: 'json',
            type:"post",
            data:{
                task_id: task_id
            },
            success: function(res) {
                if(res.errorno > 0){
                    location.href='/media/index/getMissionHallView';
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