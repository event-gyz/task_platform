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
                <?php if(($taskMessage['total']<1) && empty($userMessage)){?>
                    <div class="statu_box">
                        <p class="icon-box"><img src="/images/status/dts.png"></p>
                        <p class="text">还没有消息哦</p>
                        <p class="bg_line"></p>
                        <p class="button1">
                        </p>
                    </div>
                <?php } ?>
                <?php if($taskMessage['total']>0){?>
                <tr onclick="location.href='/advertiser/index/taskMessage'">
                    <td align="center" class="border_bottom icon" width="50"><p><img src="/images/rwtz.png"><span><?=$taskMessage['total']?></span></p></td>
                    <td class="border_bottom msg">
                        <div>
                        <h2>任务通知</h2>
                        <p><?=$taskMessage['list'][0]['message_content']?></p>
                        </div>
                    </td>
                    <td class="border_bottom time" width="70"><?=$taskMessage['list'][0]['create_time'];?></td>
                </tr>
                <?php }?>

                <?php if(!empty($userMessage) && is_array($userMessage)){
                    foreach($userMessage as $value){
                    ?>
                <tr>
                    <td align="center" class="border_bottom icon" width="50px;"><p><img src="/images/shtz.png"></p></td>
                    <td class="border_bottom msg">
                        <div>
                            <h2>审核通知</h2>
                            <p><?=$value['message_content']?></p>
                        </div>
                    </td>
                    <td class="border_bottom time" width="70"><?=$value['create_time'];?></td>
                </tr>
                <?php }
                }?>
            </table>

        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>