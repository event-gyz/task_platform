<!DOCTYPE html>
<html>
<head>
    <title>媒体人-新密码</title>
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
                    <th align="left" class="border_bottom" width="60px;">新密码</th>
                    <td class="border_bottom"><input type="password" v-model="password" placeholder="请输入密码（6-12位英文和数字组合）"></td>
                </tr>
                <tr>
                    <th align="left" width="60px;">确认密码</th>
                    <td><input type="password" v-model="againPassword" placeholder="再次输入密码（需与上面输入的一致）"></td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <p class="button-box"><input type="button" @click="save" value="确认" class="common_button"></p>
    </div>
</div>
<script type="text/javascript" src="/js/third/jquery.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/newPwdMedia.js"></script>
</body>
</html>