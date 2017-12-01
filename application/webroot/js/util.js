/**
 * Created by Zhang on 17/7/17.
 */
var css = '#tips{background: rgba(0,0,0,0.1);width:100%;height:100%;position:fixed;display:none;left:0;top:0;text-align:center;}#tips span{background:#fff;border-radius: 2px;padding:8px 10px;display: inline-block;line-height:20px;color:#333;margin-top:150px;}';

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
