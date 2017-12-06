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

                <?php if(!empty($taskMessage) && is_array($taskMessage)){
                    foreach($taskMessage as $value){
                    ?>
                <tr onclick="location.href='/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>'">
                    <td align="center" class="border_bottom icon" width="50px;"><p><img src="/images/shtz.png"></p></td>
                    <td class="border_bottom msg">
                        <div>
                            <h2>任务</h2>
                            <p><?=$value['message_content']?></p>
                        </div>
                    </td>
                    <td class="border_bottom time" valign="bottom" width="100px"><?=$value['create_time'];?></td>
                </tr>
                <?php }
                }?>
            </table>

        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>