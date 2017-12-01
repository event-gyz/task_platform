<!DOCTYPE html>
<html>
    <head>
        <title>项目名称</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="../assets/css/common.css" />
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app">
            <div class="login-title"><img src="../assets/images/title_bg.png"><span>账号信息</span></div>
            <div class="login-style" style="padding-top: 0;">
                <div class="min-title">推广账号信息<span>请至少绑定一个推广账号，否则将无法领取任务</span></div>
                <div class="input-box" style="margin-bottom: 20px">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="80px;">微信号</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="wx" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >账号类型</th>
                            <td class="border_bottom"><input id="wx_type" style="text-align: right;" type="text" readonly="readonly" v-model="wxType" placeholder="请选择>"></td>
                        </tr>
                        <tr>
                            <th align="left">最高粉丝量</th>
                            <td><input style="text-align: right;" type="number" v-model="wxNumber" placeholder="请输入"></td>
                        </tr>
                    </table>
                </div>
                <div class="input-box">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">微博昵称</th>
                            <td class="border_bottom">
                                <input style="text-align: right;" type="text" v-model="wb" placeholder="请输入">
                            </td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">账号类型</th>
                            <td class="border_bottom">
                                <input id="wb_type" style="text-align: right;" type="text" readonly="readonly" v-model="wbType" placeholder="请选择>">
                            </td>
                        </tr>
                        <tr>
                            <th class="border_bottom" align="left">最高粉丝量</th>
                            <td class="border_bottom">
                                <input style="text-align: right;" type="number" v-model="wbNumber" placeholder="请输入">
                            </td>
                        </tr>
                        <tr>
                            <th align="left">微博链接</th>
                            <td>
                                <input style="text-align: right;" type="text" v-model="wbUrl" placeholder="请输入">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="padding-bottom:30px;">
                <p class="button-box"><input type="button" @click="save" value="确认提交" class="common_button"></p>
            </div>
        </div>
        <script type="text/javascript" src="../assets/js/third/zepto.min.js"></script>
        <script type="text/javascript" src="../assets/js/third/vue.js"></script>
        <script type="text/javascript" src="../assets/js/util.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="../assets/js/account.js"></script>
    </body>
</html>