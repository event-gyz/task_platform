/**
 * Created by Zhang on 17/7/17.
 */
var css = '#tips{z-index:9999;background: rgba(0,0,0,0.1);width:100%;height:100%;position:fixed;display:none;left:0;top:0;text-align:center;}#tips span{background:#fff;border-radius: 2px;padding:8px 10px;display: inline-block;line-height:20px;color:#333;margin-top:150px;}#global-confirm,#global-alert{background: rgba(0,0,0,0.1);width:100%;height:100%;position:fixed;display:none;left:0;top:0;text-align:center;z-index:9999;}#global-confirm .box,#global-alert .box{background:#fff;border-radius: 2px;padding:5px;display: inline-block;color:#333;margin-top:150px;width:70%;}#global-confirm .title,#global-alert .title{border-bottom: 1px solid #eee;padding: 20px 20px;line-height: 25px;text-align: center;}.global-confirm-button{position:relative;height:45px;overflow:hidden;width:100%;}.confirm-cancel{float:right;width:50%;height:45px;text-align:center;font-size:20px;line-height:45px;}.confirm-submit{float:left;width:49.5%;height:45px;line-height:45px;text-align:center;font-size:20px;color: #40CE7D;border-right:1px solid #eee;}.global-alert-button{position:relative;height:45px;overflow:hidden;width:100%;line-height:45px;text-align:center;font-size:20px;color: #40CE7D;}';

$('head').append('<style type="text/css">'+css+'</style>');
var util = {
    //正则表达式
    regexp: {
        "tel": /^(\({0,1}\d{3,4})\){0,1}(-){0,1}(\d{7,8})$/,
        "mail": /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/,
        "mobile": /^1[0-9]{10}$/,
        "number": /^[0-9]*$/,
        "isNum": /[0-9]+/,
        "isZM": /[a-zA-Z]+/,
        "float": /^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/,
        "url": /^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/,
        "time": /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/,
        "idCard": /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/
    },
    //去除字符串所以空格
    "trim": function(str){
        var reg = /\s/g;
        str = str.replace(reg,'');
        return str;
    }
};
util.tips = function(text){
    var isTips = $('#tips').length;
    if(isTips){
        $('#tips span').text(text);
    }else{
        var tips = '<div id="tips"><span>'+text+'</span></div>';
        $('body').append(tips);
    }
    $('#tips').show();
    setTimeout(function(){$('#tips').hide();},2000);
};
/**
 * 自定义移动端的confirm
 */
util.confirm = function(text,submit,cancel){
    if($('#global-confirm').length){
        $('#global-confirm .title').html(text);
    }else{
        var html = '<div id="global-confirm"><div class="box"><div class="title">'+text+'</div><div class="global-confirm-button"><p class="confirm-submit">确 定</p><p class="confirm-cancel">取 消</p></div></div></div>';
        $('body').append(html);
    }
    $('#global-confirm').show();
    $('#global-confirm .confirm-cancel').unbind('click').click(function(){$('#global-confirm').hide();cancel();});
    $('#global-confirm .confirm-submit').unbind('click').click(function(){$('#global-confirm').hide();submit();});
};

util.alert = function(text,fn){
    if($('#global-alert').length){
        $('#global-alert .title').html(text);
    }else{
        var html = '<div id="global-alert"><div class="box"><div class="title">'+text+'</div><div class="global-alert-button">确 定</div></div></div>';
        $('body').append(html);
    }

    $('#global-alert').show();
    $('#global-alert .global-alert-button').unbind('click').click(function(){$('#global-alert').hide();if(fn){fn()}});
};