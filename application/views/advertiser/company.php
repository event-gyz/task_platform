<!DOCTYPE html>
<html>
    <head>
        <title>广告-公司</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="../assets/css/common.css" />
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
                                    <a href="./person.html"><img src="../assets/images/icon2.png">&nbsp;个人</a>
                                    <a href="./company.html" class="cur"><img src="../assets/images/icon1.png">&nbsp;企业</a>
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
                                <p v-if="companyImg" class="person_upload_img"><img :src="companyImg"></p>
                                <p class="person_page_img1" @click="uploadImg"><img src="../assets/images/icon6.png"></p>
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
        <script type="text/javascript" src="../assets/js/third/jquery.js"></script>
        <script type="text/javascript" src="../assets/js/util.js"></script>
        <script type="text/javascript" src="../assets/js/third/vue.js"></script>
        <script type="text/javascript" src="../assets/js/company.js"></script>
    </body>
</html>


