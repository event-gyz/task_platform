var swiper = new Swiper('.swiper-container', {

});
var docWid = $('#pt_box').width();
var ele = $('#pt_box').html();
var eleWid = $('#pt_box>li').width();
$('#pt_box').append(ele);

$('#pt_box').scrollLeft(75).scroll(function(){
    var left = $(this).scrollLeft();
    if(left==0){
        $(this).scrollLeft(eleWid);
    }
    if(left+docWid>=eleWid*2){
        $('#pt_box').scrollLeft(left-eleWid);
    }
});
$('i.left').click(function(){
    var left = $('#pt_box').scrollLeft();
    var w = $('#pt_box').width();
    $('#pt_box').stop().animate({scrollLeft:left-w},300);
});
$('i.right').click(function(){
    var left = $('#pt_box').scrollLeft();
    var w = $('#pt_box').width();
    $('#pt_box').stop().animate({scrollLeft:left+w},300);
});




