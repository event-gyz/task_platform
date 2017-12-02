<!DOCTYPE html>
<html>
<head>
    <title>媒体人-忘记密码</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="/css/common.css" />
    <link rel="stylesheet" href="/css/login.css" />
</head>
<body>
<div class="main" id="app">
    <div class="login-style">
        <div class="input-box">
            <table>
                <tr>
                    <th align="left" class="border_bottom" width="60px;">手机号码</th>
                    <td class="border_bottom" colspan="2"><input type="text" v-model="phone" placeholder="请输入注册时使用的手机号"></td>
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
    </div>
</div>
<script type="text/javascript" src="/js/third/jquery.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/forget_media.js"></script>
</body>
</html>