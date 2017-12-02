<!DOCTYPE html>
<html>
    <head>
        <title>项目名称</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app">
            <div class="login-title"><img src="/images/title_bg.png"><span>基本信息</span></div>
            <div class="login-style" style="padding-top: 0;">
                <div class="input-box" style="margin: 0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="80px;">姓名</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="name" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >性别</th>
                            <td class="border_bottom"><input id="sex" style="text-align: right;" type="text" v-model="sex" placeholder="请选择>"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >电话</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="phone" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" width="60px;">学校名称</th>
                            <td class="border_bottom"><input style="text-align: right;" type="text" v-model="schoolName" placeholder="请输入"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" width="60px;">学校类型</th>
                            <td class="border_bottom"><input id="schoolType" style="text-align: right;" type="text" v-model="schoolType" placeholder="请选择>"></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" width="60px;">学校地区</th>
                            <td class="border_bottom"><input id="schoolAdress" style="text-align: right;" type="text" v-model="schoolAdress" placeholder="请选择>"></td>
                        </tr>
                        <tr>
                            <th align="left" width="60px;">学校层次</th>
                            <td><input id="schoolLevel" style="text-align: right;" type="text" v-model="schoolLevel" placeholder="请选择>"></td>
                        </tr>
                    </table>
                </div>
                <div class="min-title">朋友眼中的你<span>请为自己选择标签，有助于接更多的任务哦</span></div>
                <div class="input-box" style="margin: 0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="40px;">年龄</th>
                            <td class="border_bottom">
                                <p class="text-box">
                                    <span @click="setAge('18岁以下')" :class="{cur:age=='18岁以下'}">18岁以下</span>
                                    <span @click="setAge('18-30岁')" :class="{cur:age=='18-30岁'}">18-30岁</span>
                                    <span @click="setAge('31-50岁')" :class="{cur:age=='31-50岁'}">31-50岁</span>
                                    <span @click="setAge('50岁以上')" :class="{cur:age=='50岁以上'}">50岁以上</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >爱好</th>
                            <td class="border_bottom">
                                <p class="text-box">
                                    <span @click="setLiking('美食')" :class="{cur:liking.indexOf('美食')!=-1}">美食</span>
                                    <span @click="setLiking('旅游')" :class="{cur:liking.indexOf('旅游')!=-1}">旅游</span>
                                    <span @click="setLiking('健身')" :class="{cur:liking.indexOf('健身')!=-1}">健身</span>
                                    <span @click="setLiking('减肥')" :class="{cur:liking.indexOf('减肥')!=-1}">减肥</span>
                                    <span @click="setLiking('理财')" :class="{cur:liking.indexOf('理财')!=-1}">理财</span>
                                    <span @click="setLiking('美妆')" :class="{cur:liking.indexOf('美妆')!=-1}">美妆</span>
                                    <span @click="setLiking('宠物')" :class="{cur:liking.indexOf('宠物')!=-1}">宠物</span>
                                    <span @click="setLiking('购物')" :class="{cur:liking.indexOf('购物')!=-1}">购物</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">行业</th>
                            <td>
                                <p class="text-box">
                                    <span @click="setIndustry('学生')" :class="{cur:industry=='学生'}">学生</span>
                                    <span @click="setIndustry('互联网')" :class="{cur:industry=='互联网'}">互联网</span>
                                    <span @click="setIndustry('传媒/营销')" :class="{cur:industry=='传媒/营销'}">传媒/营销</span>
                                    <span @click="setIndustry('金融/财经')" :class="{cur:industry=='金融/财经'}">金融/财经</span>
                                    <span @click="setIndustry('电商/微商')" :class="{cur:industry=='电商/微商'}">电商/微商</span>
                                    <span @click="setIndustry('文娱')" :class="{cur:industry=='文娱'}">文娱</span>
                                    <span @click="setIndustry('母婴')" :class="{cur:industry=='母婴'}">母婴</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="min-title">收款账号信息<span>请绑定支付宝账号，以方便为您结算任务收入</span></div>
                <div class="input-box">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">支付宝账号</th>
                            <td class="border_bottom">
                                <input style="text-align: right;" type="text" v-model="zfbNumber" placeholder="请输入">
                            </td>
                        </tr>
                        <tr>
                            <th align="left">真实姓名</th>
                            <td>
                                <input style="text-align: right;" type="text" v-model="zfbName"  placeholder="请输入">
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div style="padding-bottom:30px;">
                <p class="button-box"><input type="button" @click="save" value="下一步" class="common_button1"></p>
            </div>
        </div>
        <script type="text/javascript" src="/js/third/zepto.min.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
        <script type="text/javascript" src="/js/base.js"></script>
    </body>
</html>