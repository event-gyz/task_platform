<!DOCTYPE html>
<html>
    <head>
        <title>任务保存成功</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/statu.css" />
    </head>
    <body>
        <div class="main">
            <div class="statu_style">
                <!--任务保存成功-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/cg.png"></p>
                    <h2>任务保存成功</h2>
                    <p class="text">任务保存成功，您可对该任务进行修改，关闭等操作</p>
                    <p class="bg_line"></p>
                    <p class="button3">
                        <a style="border-right: 1px solid #E5E5E5;" href="/advertiser/index/taskInfo?task_id=<?=$_GET['task_id']?>">查看任务</a>
                        <a style="border-right: 1px solid #E5E5E5;" href="/advertiser/index/taskView">继续发布任务</a>
                        <a href="/advertiser/index/home">返回首页</a>
                    </p>
                </div>
                <!--任务保存成功-end-->
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>