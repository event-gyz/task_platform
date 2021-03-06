<!DOCTYPE html>
<html>
    <head>
        <title>媒体人-我的资料</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
    </head>
    <body>
        <div class="main" style="margin-bottom: 0">
            <div class="login-style" style="padding-top: 0;">
                <div class="min-title">基本信息</div>
                <div class="input-box" style="margin-bottom: 0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="100px;">姓名</th>
                            <td class="border_bottom" align="right"><?=$media_man_name?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >电话</th>
                            <td class="border_bottom" align="right"><?=$media_man_phone?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >年龄</th>
                            <td class="border_bottom" align="right"><?=$age?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">学校名称</th>
                            <td class="border_bottom" align="right"><?=$school_name?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">学校地区</th>
                            <td class="border_bottom" align="right"><?=$school_province,' ',$school_city,' ',$school_area?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >办学层次</th>
                            <td class="border_bottom" align="right"><?=$school_level?></td>
                        </tr>
                        <tr>
                            <th align="left">朋友眼中的我</th>
                            <td align="right"><?=$characteristic?></td>
                        </tr>
                    </table>
                </div>
                <div class="min-title">收款账号信息</div>
                <div class="input-box" style="margin-bottom: 0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">支付宝账号</th>
                            <td class="border_bottom" align="right"><?=$zfb_nu?></td>
                        </tr>
                        <tr>
                            <th align="left">真实姓名</th>
                            <td align="right"><?=$zfb_realname?></td>
                        </tr>
                    </table>
                </div>
                <div class="min-title">绑定的账号信息</div>
                <div class="input-box" style="margin-bottom: 10px;">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">微信号</th>
                            <td class="border_bottom" align="right"><?= !empty($wx_code)?$wx_code:""?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">账号类型</th>
                            <td class="border_bottom" align="right"><?=!empty($wx_type)?$wx_type:""?></td>
                        </tr>
                        <tr>
                            <th align="left">最高粉丝量</th>
                            <td align="right"><?=!empty($wx_max_fans)?$wx_max_fans:""?></td>
                        </tr>
                    </table>
                </div>
                <div class="input-box" style="margin-bottom: 0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">微博昵称</th>
                            <td class="border_bottom" align="right"><?=!empty($weibo_nickname)?$weibo_nickname:""?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">账号类型</th>
                            <td class="border_bottom" align="right"><?=!empty($weibo_type)?$weibo_type:""?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">最高粉丝量</th>
                            <td class="border_bottom" align="right"><?=!empty($weibo_max_fans)?$weibo_max_fans:""?></td>
                        </tr>
                        <tr>
                            <th align="left">微博链接</th>
                            <td align="right"><?=!empty($weibo_link)?$weibo_link:""?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>