<?php
require_once dirname(__FILE__)."./../../controllers/Jssdk.php";
$jssdk = new JSSDK("wx286bc47fc04c2a25", "587babff126cb893ad86e58d04cbdf30");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>广告-公司</title>
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
                                    <a :href="setUrlPerson"><img src="/images/icon2.png">&nbsp;个人</a>
                                    <a :href="setUrlCompany" class="cur"><img src="/images/icon1.png">&nbsp;企业</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">公司名称</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="companyName" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">公司地址</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="companyAdress" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">联系人姓名</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="name" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">联系人电话</th>
                            <td class="border_bottom"><input style="text-align: right;" type="number" v-model="phone" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th class="border_bottom" align="left" valign="top">营业执照</th>
                            <td class="border_bottom">
                                <p v-if="companyImg" class="person_upload_img">
                                <img :src="companyImg"><i class="iconfont" @click="removeImg('companyImg')">&#xe601;</i>
                                </p>
                                <p v-show="!companyImg" class="person_page_img1" @click="uploadImg"><img src="/images/icon6.png"></p>
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
        <script type="text/javascript" src="/js/company.js"></script>
    </body>
</html>


