<!DOCTYPE html>
<html>
    <head>
        <title>基本信息</title>
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
                            <td class="border_bottom"><input id="schoolAddress" style="text-align: right;" type="text" v-model="schoolAddress" placeholder="请选择>"></td>
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
                                    <span @click="setAge('1')" :class="{cur:age=='1'}">18岁以下</span>
                                    <span @click="setAge('2')" :class="{cur:age=='2'}">18-30岁</span>
                                    <span @click="setAge('3')" :class="{cur:age=='3'}">31-50岁</span>
                                    <span @click="setAge('4')" :class="{cur:age=='4'}">50岁以上</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >爱好</th>
                            <td class="border_bottom">
                                <p class="text-box">
                                    <span @click="setLiking('1')" :class="{cur:liking.indexOf('1')!=-1}">美食</span>
                                    <span @click="setLiking('2')" :class="{cur:liking.indexOf('2')!=-1}">旅游</span>
                                    <span @click="setLiking('3')" :class="{cur:liking.indexOf('3')!=-1}">健身</span>
                                    <span @click="setLiking('4')" :class="{cur:liking.indexOf('4')!=-1}">减肥</span>
                                    <span @click="setLiking('5')" :class="{cur:liking.indexOf('5')!=-1}">理财</span>
                                    <span @click="setLiking('6')" :class="{cur:liking.indexOf('6')!=-1}">美妆</span>
                                    <span @click="setLiking('7')" :class="{cur:liking.indexOf('7')!=-1}">宠物</span>
                                    <span @click="setLiking('8')" :class="{cur:liking.indexOf('8')!=-1}">购物</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">行业</th>
                            <td>
                                <p class="text-box">
                                    <span @click="setIndustry('1')" :class="{cur:industry=='1'}">学生</span>
                                    <span @click="setIndustry('2')" :class="{cur:industry=='2'}">互联网</span>
                                    <span @click="setIndustry('3')" :class="{cur:industry=='3'}">传媒/营销</span>
                                    <span @click="setIndustry('4')" :class="{cur:industry=='4'}">金融/财经</span>
                                    <span @click="setIndustry('5')" :class="{cur:industry=='5'}">电商/微商</span>
                                    <span @click="setIndustry('6')" :class="{cur:industry=='6'}">文娱</span>
                                    <span @click="setIndustry('7')" :class="{cur:industry=='7'}">母婴</span>
                                    <span @click="setIndustry('8')" :class="{cur:industry=='8'}">体育</span>
                                    <span @click="setIndustry('9')" :class="{cur:industry=='9'}">旅游/酒店</span>
                                    <span @click="setIndustry('10')" :class="{cur:industry=='10'}">餐饮/服务</span>
                                    <span @click="setIndustry('11')" :class="{cur:industry=='11'}">汽车</span>
                                    <span @click="setIndustry('12')" :class="{cur:industry=='12'}">政府/企事业单位</span>
                                    <span @click="setIndustry('13')" :class="{cur:industry=='13'}">医疗/健康</span>
                                    <span @click="setIndustry('14')" :class="{cur:industry=='14'}">房地产</span>
                                    <span @click="setIndustry('15')" :class="{cur:industry=='15'}">零售/商超</span>
                                    <span @click="setIndustry('16')" :class="{cur:industry=='16'}">IT通讯</span>
                                    <span @click="setIndustry('17')" :class="{cur:industry=='17'}">物流</span>
                                    <span @click="setIndustry('18')" :class="{cur:industry=='18'}">游戏动漫</span>
                                    <span @click="setIndustry('19')" :class="{cur:industry=='19'}">IT数码</span>
                                    <span @click="setIndustry('20')" :class="{cur:industry=='20'}">司法</span>
                                    <span @click="setIndustry('21')" :class="{cur:industry=='21'}">母婴</span>
                                    <span @click="setIndustry('22')" :class="{cur:industry=='22'}">母婴</span>
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