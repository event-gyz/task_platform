<!DOCTYPE html>
<html>
    <head>
        <title>任务发布成功</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/statu.css" />
    </head>
    <body>
        <div class="main">
            <div class="statu_style">
                <!--任务发布成功-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/cg.png"></p>
                    <h2>任务发布成功</h2>
                    <p class="text">任务发布成功，我们将尽快完成审核，请随时关注审核结果，请在审核后及时付款。</p>
                    <p class="bg_line"></p>
                    <p class="button3">
                        <a style="border-right: 1px solid #E5E5E5;" href="/advertiser/index/taskInfo?task_id=<?=$_GET['task_id']?>">查看任务</a>
                        <a style="border-right: 1px solid #E5E5E5;" href="/advertiser/index/taskView">继续发布任务</a>
                        <a href="/advertiser/index/home">返回首页</a>
                    </p>
                </div>
                <!--任务发布成功-end-->
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>