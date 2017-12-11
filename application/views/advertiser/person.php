<?php
require_once dirname(__FILE__)."./../../controllers/wx/Jssdk.php";
$jssdk = new JSSDK("wx286bc47fc04c2a25", "587babff126cb893ad86e58d04cbdf30");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
<head>
    <title>广告-个人</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="/css/common.css" />
</head>
<body>
<div class="main" id="app">
    <div class="login-style">
        <div class="input-box">
            <table>
                <tr>
                    <th align="left" class="border_bottom" width="90px;">类型</th>
                    <td class="border_bottom" align="center">
                        <p class="person_page_img">
                            <a :href="setUrlPerson" class="cur"><img src="/images/icon1.png">&nbsp;个人</a>
                            <a :href="setUrlCompany"><img src="/images/icon2.png">&nbsp;企业</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">姓名</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" v-model="name" placeholder="请输入"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">手机号码</th>
                    <td class="border_bottom"><input style="text-align: right;" type="number" v-model="phone" readonly="readonly" placeholder="请输入"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">身份证号码</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" v-model="idCard" placeholder="请输入"></td>
                </tr>
                <tr>
                    <th class="border_bottom" align="left" valign="top"><br>身份证正面</th>
                    <td class="border_bottom">
                        <p v-if="frontCard" class="person_upload_img"><img :src="frontCard"></p>
                        <p class="person_page_img1" @click="uploadImg('frontCard')"><img src="/images/icon3.png"></p>
                    </td>
                </tr>
                <tr>
                    <th class="border_bottom" align="left" valign="top"><br>身份证反面</th>
                    <td class="border_bottom">
                        <p v-if="backCard" class="person_upload_img"><img :src="backCard"></p>
                        <p class="person_page_img1" @click="uploadImg('backCard')"><img src="/images/icon4.png"></p>
                    </td>
                </tr>
                <tr>
                    <th align="left" valign="top"><br>手持身份证</th>
                    <td>
                        <p v-if="card" class="person_upload_img"><img :src="card"></p>
                        <p class="person_page_img1" @click="uploadImg('card')"><img src="/images/icon5.png"></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="padding-bottom: 20px;">
        <p class="button-box"><input type="button" @click="save" value="确认提交" class="common_button"></p>
    </div>
</div>
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript" src="/js/third/jquery.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/person.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */
    wx.config({
        debug: true,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
    });
</script>
</body>
</html>