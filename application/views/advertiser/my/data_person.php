<!DOCTYPE html>
<html>
    <head>
        <title>我的资料-个人</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexAdvert.css" />
    </head>
    <body>
        <div class="main">
            <div class="login-style">
                <div class="input-box">
                    <table>
                        <tr>
                            <?php $userInfo = $_SESSION['ad_user_info']?>
                            <th align="left" class="border_bottom" width="80px;">类型</th>
                            <td class="border_bottom" align="right">个人</td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">姓名</th>
                            <td class="border_bottom" align="right"><?=$userInfo['advertiser_name']?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">手机号</th>
                            <td align="right" class="border_bottom"><?=$userInfo['advertiser_phone']?></td>
                        </tr>
                        <tr>
                            <th align="left">身份证号</th>
                            <td align="right"><?=$userInfo['advertiser_name']?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>