<!DOCTYPE html>
<html>
    <head>
        <title>媒体人-我的</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_vo1nszstgavh1tt9.css">
    </head>
    <body>
    <?php $userSession = isset($_SESSION['user_info'])?$_SESSION['user_info']:[];?>
        <div class="main">
            <div class="my">
                <!--head-->
                <div class="my_head">
                    <ul>
                        <li class="img"><Img src="/images/wb.png"></li>
                        <?php if(isset($userSession['media_man_id']) && !empty($userSession['media_man_id'])){?>
                            <li class="text"><?=(!empty($userSession['media_man_name'])?$userSession['media_man_name']:'未设置')?></li>
                        <?php } ?>
                        <li class="text">未登录</li>
                    </ul>
                </div>
                <!--head-end-->
                <table class="my_index_table">
                    <tr onclick="window.location.href='/media/index/getMediaManInfo'">
                        <th align="center" width="35px;">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/zl.png"></th>
                        <td class="border_bottom">我的资料</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/media/index/message'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/xx.png"></th>
                        <td class="border_bottom">我的消息</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/media/index/taskList'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/rw.png"></th>
                        <td class="border_bottom">我的任务</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/media/index/incomeList'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/rw.png"></th>
                        <td class="border_bottom">我的收入</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='/media/login/forget'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/mm.png"></th>
                        <td class="border_bottom">修改密码</td>
                        <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                    <tr onclick="window.location.href='#'">
                        <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/kf.png"></th>
                        <td>联系客服</td>
                        <td align="right" width="30px;"><i class="iconfont">&#xe610;</i></td>
                    </tr>
                </table>

                <?php if(isset($userSession['media_man_id']) && !empty($userSession['media_man_id'])){?>
                <p class="logout"><a href="/media/login/logout">退出登录</a></p>
                <?php } ?>
            </div>
        </div>
        <!--nav-->
        <div class="nav">
            <p><a href="/media/index/home"><i class="iconfont">&#xe661;</i><br>首页</a></p>
            <p><a href="/media/index/getMissionHallView"><i class="iconfont">&#xe653;</i><br>任务大厅</a></p>
            <p  class="cur"><a href="/media/index/my"><i class="iconfont">&#xe600;</i><br>我的</a></p>
        </div>
        <!--nav-end-->
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>