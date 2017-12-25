var swiper = new Swiper('.swiper-container', {

});
var docWid = $('#pt_box').width();
var ele = $('#pt_box').html();
var eleWid = $('#pt_box>li').width();
$('#pt_box').append(ele);

$('#pt_box').scrollLeft(40).scroll(function(){
    var left = $(this).scrollLeft();
    if(left==0){
        $(this).scrollLeft(eleWid);
    }
    if(left+docWid>=eleWid*2){
        $('#pt_box').scrollLeft(left-eleWid);
    }
});





