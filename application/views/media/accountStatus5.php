<!DOCTYPE html>
<html>
    <head>
        <title>已被冻结</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/statu.css" />
    </head>
    <body>
    <div class="main">
        <div class="statu_style">

            <!--已被冻结-->
            <div class="statu_box">
                <p class="icon-box"><img src="/images/status/sb.png"></p>
                <?php $userSession = $_SESSION['user_info'];?>
                <h2>抱歉，您的账号已被冻结，请联系管理员解决，电话：*****。</h2>
                <p class="text">冻结原因：<?=!empty($userSession)?$userSession['freezing_reason']:''?></p>
                <p class="bg_line"></p>
                <p class="button2">
                    <a style="border-right: 1px solid #E5E5E5;" href="/media/index/saveBaseInfo">立即修改</a>
                    <a href="/media/index/home">返回首页</a>
                </p>
            </div>
            <!--已被冻结-end-->
        </div>
    </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>