<!DOCTYPE html>
<html>
    <head>
        <title>我的消息</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexAdvert.css" />
    </head>
    <body>
        <div class="main" style="padding-top: 10px;">
            <table class="my_msg_table">
                <?php if(($total<1) && empty($list)){?>
                    <div class="statu_box">
                        <p class="icon-box"><img src="/images/status/dts.png"></p>
                        <p class="text">还没有消息哦</p>
                        <p class="bg_line"></p>
                        <p class="button1">
                        </p>
                    </div>
                <?php } ?>


                <?php if(!empty($list) && is_array($list)){
                    foreach($list as $value){
                        if($value['message_type']==1){
                    ?>
                            <tr>
                                <td align="center" class="border_bottom icon" width="50px;"><p><img src="/images/shtz.png"></p></td>
                                <td class="border_bottom msg">
                                    <div>
                                        <h2>账户通知</h2>
                                        <p><?=$value['message_content']?></p>
                                    </div>
                                </td>
                                <td class="border_bottom time" width="70"><?=$value['create_time'];?></td>
                            </tr>
                    <?php }else{?>
                            <tr onclick="location.href='/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>'">
                                <td align="center" class="border_bottom icon" width="50"><p><img src="/images/rwtz.png">
<!--                                        <span>--><?//=$total?><!--</span>-->
                                    </p></td>
                                <td class="border_bottom msg">
                                    <div>
                                        <h2>任务通知</h2>
                                        <p><?=$value['message_content']?></p>
                                    </div>
                                </td>
                                <td class="border_bottom time" width="70"><?=$value['create_time'];?></td>
                            </tr>
                <?php }
                    }
                }?>
            </table>

        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>