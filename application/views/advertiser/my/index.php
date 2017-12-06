<!DOCTYPE html>
<html>
    <head>
        <title>我的</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexAdvert.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_vo1nszstgavh1tt9.css">
    </head>
    <body>
        <div class="main">
            <div class="my">
                <!--head-->
                <div class="my_head">
                    <ul>
                        <li class="img"><Img src="/images/wx.png"></li>
                        <li class="text">孙悟空</li>
                    </ul>
                </div>
                <!--head-end-->
                <table class="my_index_table">
                    <tr onclick="window.location.href='/advertiser/index/userInfo'">
                        <th align="center" width="35px">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/zl.png"></th>
                        <td class="border_bottom">我的资料</td>
                        <td align="right" class="border_bottom" width="30px"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/advertiser/index/message'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/xx.png"></th>
                        <td class="border_bottom">我的消息</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/advertiser/index/taskList'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/rw.png"></th>
                        <td class="border_bottom">我的任务</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/advertiser/login/new_pwd'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/mm.png"></th>
                        <td class="border_bottom">修改密码</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href=''">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/kf.png"></th>
                        <td>联系客服</td>
                        <td align="right" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                </table>
                <p class="logout"><a href="#">退出登录</a></p>
            </div>
        </div>
        <!--nav-->
        <div class="nav">
            <p><a href="/advertiser/index/home"><i class="iconfont">&#xe661;</i><br>首页</a></p>
            <p><a href="/advertiser/index/taskView"><i class="iconfont">&#xe621;</i><br>开始推广</a></p>
            <p class="cur"><a href="/advertiser/index/my"><i class="iconfont">&#xe600;</i><br>我的</a></p>
        </div>
        <!--nav-end-->
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>