<!DOCTYPE html>
<html>
<head>
    <?php $userSession =  isset($_SESSION['ad_user_info'])?$_SESSION['ad_user_info']:[];?>
    <title><?php if(isset($userSession['advertiser_id']) && !empty($userSession['advertiser_id'])){?>

                <?php
                if(isset($userSession['advertiser_type']) && $userSession['advertiser_type']==1){
                    echo (!empty($userSession['advertiser_name'])?$userSession['advertiser_name']:'未设置');
                }else{
                    echo (!empty($userSession['company_name'])?$userSession['company_name']:'未设置');
                }
                ?>

        <?php }else{ ?>
            未登录
        <?}?></title>
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
                <li class="img"><Img src="/images/ggz.png"></li>
                <?php if(isset($userSession['advertiser_id']) && !empty($userSession['advertiser_id'])){?>
                    <li class="text">
                        <?php
                        if(isset($userSession['advertiser_type']) && $userSession['advertiser_type']==1){
                            echo (!empty($userSession['advertiser_name'])?$userSession['advertiser_name']:'未设置');
                        }else{
                            echo (!empty($userSession['company_name'])?$userSession['company_name']:'未设置');
                        }
  ?>
                    </li>
                <?php }else{ ?>
                <li class="text">未登录</li>
                <?}?>
            </ul>
        </div>
        <!--head-end-->
        <table class="my_index_table">
            <tr onclick="window.location.href='/advertiser/index/taskList'">
                <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/rw1.png"></th>
                <td class="border_bottom">我的任务</td>
                <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
            </tr>
            <tr onclick="window.location.href='/advertiser/index/message'">
                <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/xx.png"></th>
                <td class="border_bottom">我的消息</td>
                <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
            </tr>
            <tr onclick="window.location.href='/advertiser/index/userInfo'">
                <th align="center" width="35px">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/zl.png"></th>
                <td class="border_bottom">我的资料</td>
                <td align="right" class="border_bottom" width="30px"><i class="iconfont">&#xe610;</i></td>
            </tr>
            <tr onclick="window.location.href='/advertiser/login/forget'">
                <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/mm.png"></th>
                <td class="border_bottom">修改密码</td>
                <td align="right" class="border_bottom" width="30px;"><i class="iconfont">&#xe610;</i></td>
            </tr>
            <tr onclick="window.location.href='tel:18610925812'">
                <th align="center">&nbsp;&nbsp;&nbsp;<img class="icon" src="/images/kf.png"></th>
                <td>联系客服</td>
                <td align="right" width="30px;"><i class="iconfont">&#xe610;</i></td>
            </tr>
        </table>
        <?php if(isset($userSession['advertiser_id']) && !empty($userSession['advertiser_id'])){?>
            <p class="logout"><a href="/advertiser/login/logout">退出登录</a></p>
        <?php } ?>
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