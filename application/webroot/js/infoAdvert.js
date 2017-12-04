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
