<!DOCTYPE html>
<html>
<head>
    <title>广告人注册</title>
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
                    <th align="left" class="border_bottom" width="60px;">用户名</th>
                    <td class="border_bottom" colspan="2"><input type="text" v-model="userName" placeholder="6-20个字符，支持数字、中\英文大小写"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom" >密码</th>
                    <td class="border_bottom" colspan="2"><input type="password" v-model="password" placeholder="请输入密码（6-12位英文和数字组合）"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom" >确认密码</th>
                    <td class="border_bottom" colspan="2"><input type="password" v-model="againPassword" placeholder="再次输入密码（需与上面输入的一致）"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom" width="60px;">手机号码</th>
                    <td class="border_bottom" colspan="2"><input type="number" v-model="phone" placeholder="请输入手机号用来接收验证码"></td>
                </tr>
                <tr>
                    <th align="left" width="60px;">验证码</th>
                    <td><input type="text" v-model="verification" placeholder="请输入收到的验证码"></td>
                    <td><a v-show="!time" href="#" @click="getVerCode">获取验证码</a><a style="display: none" v-show="time" href="javascript:;" >{{time}}S后获取</a></td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <p class="button-box"><input type="button" @click="save" value="下一步" class="common_button1"></p>
        <p class="login-text" style="text-align: center;font-size: 12px;">点击下一步，即表示已阅读并同意<a href="/html/advertiser/protocol.html">《网站用户协议》</a></p>
    </div>
</div>
<script type="text/javascript" src="/js/third/jquery.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/registerAdvert.js"></script>
</body>
</html>