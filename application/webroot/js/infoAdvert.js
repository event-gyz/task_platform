/**
 * Created by Zhang on 17/11/28.
 */
$('#exec_ing_button').click(function(){
    var display =$('#exec_ing_con').css('display');
    if(display == 'none'){
        $('#exec_ing_con').show();
        $(this).find('p').removeClass('left');
        $(this).find('p').addClass('right');
    }else{
        $('#exec_ing_con').hide();
        $(this).find('p').addClass('left');
        $(this).find('p').removeClass('right');
    }
});

var task_id = window.location.search.substr(1).split('=')[1];
// 提交
$('.common_button2').click(function(){
    util.confirm('确认执行该操作吗？',function(){
        $.ajax({
            url: "/advertiser/index/submitAudit",
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

// 确认付款
$('.common_button3').click(function(){
    util.confirm('确认执行该操作吗？',function(){
        $.ajax({
            url: "/advertiser/index/payTask",
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

// 结束
$('.common_button4').click(function(){
    util.confirm('确认结束该任务吗？',function(){
        $.ajax({
            url: "/advertiser/index/endTask",
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
