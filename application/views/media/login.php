<!DOCTYPE html>
<html>
    <head>
        <title>媒体人登录</title>
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
                            <td class="border_bottom"><input type="text" v-model="userName" placeholder="用户名或手机号"></td>
                        </tr>
                        <tr>
                            <th align="left">密码</th>
                            <td><input type="password" v-model="password" placeholder="请输入密码"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <p class="button-box"><input type="button" @click="save" value="登录" class="common_button"></p>
                <p class="login-text">
                    <a class="left" href="./register.html">立即注册</a>
                    <a class="right" href="./forget.html">忘记密码</a>
                </p>
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/login_media.js"></script>
    </body>
</html>