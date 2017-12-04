<!DOCTYPE html>
<html>
    <head>
        <title>项目名称</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_ujqqb18j5hruow29.css">

        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app" style="margin: 0;">
            <ul class="my_task">
                <!--list-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">待领取</p>
                        <p class="time">
                            剩余：<span>12</span><b>小时</b><span>12</span><b>分</b>
                        </p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>11.14 ~ 11.06</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box pass" href="#">领取</a></td>
                            <td><a class="a_box warn" href="#">拒绝</a></td>
                        </tr>
                    </table>
                </li>
                <!--list-end-->
                <!--list-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">待领取</p>
                        <p class="time">
                            剩余：<span>12</span><b>小时</b><span>12</span><b>分</b>
                        </p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box pass" href="#">领取</a></td>
                            <td><a class="a_box warn" href="#">拒绝</a></td>
                        </tr>
                    </table>
                </li>
                <!--list-end-->
                <!--list-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">待领取</p>
                        <p class="time">
                            剩余：<span>12</span><b>小时</b><span>12</span><b>分</b>
                        </p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box pass" href="#">领取</a></td>
                            <td><a class="a_box warn" href="#">拒绝</a></td>
                        </tr>
                    </table>
                </li>
                <!--list-end-->
            </ul>
            <p class="no_task"><img src="/images/zwnr.png"><br>暂无分配的任务</p>
            <!--滚动加载-->
            <div class="weui-loadmore">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>
            <!--滚动加载-end-->
        </div>
        <!--nav-->
        <div class="nav">
            <p><a href="./index.html"><i class="iconfont">&#xe661;</i><br>首页</a></p>
            <p class="cur"><a href="./task_list.html"><i class="iconfont">&#xe653;</i><br>任务大厅</a></p>
            <p><a href="./my/index.html"><i class="iconfont">&#xe600;</i><br>我的</a></p>
        </div>
        <!--nav-end-->
        <script type="text/javascript" src="/js/third/zepto.min.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>

        <script src="http://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/task_list.js"></script>
    </body>
</html>