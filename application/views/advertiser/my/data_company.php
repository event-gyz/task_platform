<!DOCTYPE html>
<html>
    <head>
        <title>我的资料-企业</title>
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
                        <?php $userInfo = $_SESSION['ad_user_info']?>
                        <tr>
                            <th align="left" class="border_bottom" width="80px;">类型</th>
                            <td class="border_bottom" align="right">公司</td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" width="80px;">公司名称</th>
                            <td class="border_bottom" align="right"><?=$userInfo['company_name']?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">公司地址</th>
                            <td class="border_bottom" align="right"><?=$userInfo['company_address']?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">联系人姓名</th>
                            <td align="right" class="border_bottom"><?=$userInfo['content_name']?></td>
                        </tr>
                        <tr>
                            <th align="left">联系人电话</th>
                            <td align="right"><?=$userInfo['content_phone']?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>