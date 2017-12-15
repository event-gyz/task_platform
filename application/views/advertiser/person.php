<?php
require_once dirname(__FILE__)."./../../controllers/Jssdk.php";
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
    <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_xnfkadft2e7y14i.css">
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
                        <p v-if="frontCard" class="person_upload_img">
                        <img :src="frontCard"><i class="iconfont" @click="removeImg('frontCard')">&#xe601;</i>
                        </p>
                        <p class="person_page_img1" @click="uploadImg('frontCard')"><img src="/images/icon3.png"></p>
                    </td>
                </tr>
                <tr>
                    <th class="border_bottom" align="left" valign="top"><br>身份证反面</th>
                    <td class="border_bottom">
                        <p v-if="backCard" class="person_upload_img">
                        <img :src="backCard"><i class="iconfont" @click="removeImg('backCard')">&#xe601;</i>
                        </p>
                        <p class="person_page_img1" @click="uploadImg('backCard')"><img src="/images/icon4.png"></p>
                    </td>
                </tr>
                <tr>
                    <th align="left" valign="top"><br>手持身份证</th>
                    <td>
                        <p v-if="card" class="person_upload_img">
                        <img :src="card"><i class="iconfont" @click="removeImg('card')">&#xe601;</i>
                        </p>
                        <p class="person_page_img1" @click="uploadImg('card')"><img src="/images/icon5.png"></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="padding-bottom: 20px;">
        <p class="button-box"><input type="button" @click="save" value="确认提交" class="common_button"></p>
    </div>
    <input type="hidden" id="appId" value='<?php echo $signPackage["appId"];?>'>
    <input type="hidden" id="timestamp" value='<?php echo $signPackage["timestamp"];?>'>
    <input type="hidden" id="nonceStr" value='<?php echo $signPackage["nonceStr"];?>'>
    <input type="hidden" id="signature" value='<?php echo $signPackage["signature"];?>'>
</div>
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript" src="/js/third/jquery.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/person.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</body>
</html>