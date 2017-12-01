<!DOCTYPE html>
<html>
<head>
    <title>项目名称</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="/css/common.css" />
    <link rel="stylesheet" href="/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/css/indexAdvert.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_xnfkadft2e7y14i.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
</head>
<body>
<div class="main" id="app">
    <div class="index_advert" style="display: none;">
        <div class="min-title">任务基础信息</div>
        <div class="input-box" style="margin:0px">
            <table>
                <tr>
                    <th align="left" class="border_bottom" width="70px;">任务名称</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" v-model="taskName" placeholder="请输入"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom" >任务类型</th>
                    <td class="border_bottom"><input id="task_type" style="text-align: right;" type="text" v-model="taskType" placeholder="请选择 >"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">任务标题</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" v-model="taskTitle" placeholder="请输入"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">任务链接</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" v-model="taskUrl" placeholder=" 请输入，以http://或http://开头"></td>
                </tr>
                <tr>
                    <th align="left" valign="top" class="border_bottom"><br>任务图片</th>
                    <td class="border_bottom">
                        <ul class="generalize_img_box" v-if="taskImg">
                            <li v-for="item in taskImg"><img :src="item"><i class="iconfont" @click="removeImg(item)">&#xe601;</i></li>
                        </ul>
                        <ul class="generalize_up_button">
                            <li class="img" @click="uploadImg"><img src="/images/Bitmap.png"></li>
                            <li class="text">最多上传9张图，图片大小不超过3M，长宽比1:1。仅支持jpg、png格式</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th align="left" valign="top"><br>任务描述</th>
                    <td><textarea style="height: 120px;text-align: right" v-model="taskDes" placeholder="请输入"></textarea></td>
                </tr>
            </table>
        </div>
        <div class="min-title">任务发布信息</div>
        <div class="input-box" style="margin-bottom:0px">
            <table>
                <tr>
                    <th align="left" class="border_bottom" width="90px;">任务单价</th>
                    <td class="border_bottom"><input style="text-align: right;width:88%;" type="number" v-model="taskPrice" placeholder="请输入"><span style="color: #333;">元</span></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom" >账号要求</th>
                    <td class="border_bottom" align="center">
                        <p class="index_advert_icon">
                            <span @click="numAsk = 0" :class="{cur:!numAsk}"><img v-if="!numAsk" src="/images/icon1.png"><img v-else src="/images/icon2.png">&nbsp;无要求</span>
                            <span @click="numAsk = 1" :class="{cur:numAsk}"><img v-if="!numAsk" src="/images/icon2.png"><img v-else src="/images/icon1.png">&nbsp;自定义要求</span>
                        </p>
                    </td>
                </tr>
                <tr class="no_bg" style="display: none" v-show="numAsk">
                    <td colspan="2" class="no_bg_td">
                        <div class="bg">
                            <table>
                                <tr>
                                    <th class="border_bottom" width="40px;" align="left">性别</th>
                                    <td class="border_bottom">
                                        <p class="index_advert_icon">
                                            <span @click="setSex(0)" style="width:32%" :class="{cur:sex==0}"><img v-show="sex==0" src="/images/icon1.png"><img v-show="sex!=0" src="/images/icon2.png">&nbsp;不限</span>
                                            <span @click="setSex(1)" style="width:32%" :class="{cur:sex==1}"><img v-show="sex==1" src="/images/icon1.png"><img v-show="sex!=1" src="/images/icon2.png">&nbsp;男</span>
                                            <span @click="setSex(2)" style="width:32%" :class="{cur:sex==2}"><img v-show="sex==2" src="/images/icon1.png"><img v-show="sex!=2" src="/images/icon2.png">&nbsp;女</span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border_bottom" align="left">年龄</th>
                                    <td class="border_bottom">
                                        <p class="text-box">
                                            <span @click="setAge('18岁以下')" :class="{cur:age.indexOf('18岁以下')!=-1}">18岁以下</span>
                                            <span @click="setAge('18-30岁')" :class="{cur:age.indexOf('18-30岁')!=-1}">18-30岁</span>
                                            <span @click="setAge('31-50岁')" :class="{cur:age.indexOf('31-50岁')!=-1}">31-50岁</span>
                                            <span @click="setAge('50岁以上')" :class="{cur:age.indexOf('50岁以上')!=-1}">50岁以上</span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border_bottom" align="left">兴趣<br>爱好</th>
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
                                    <th class="border_bottom" align="left">行业</th>
                                    <td class="border_bottom">
                                        <p class="text-box">
                                            <span @click="setIndustry('学生')" :class="{cur:industry.indexOf('学生')!=-1}">学生</span>
                                            <span @click="setIndustry('互联网')" :class="{cur:industry.indexOf('互联网')!=-1}">互联网</span>
                                            <span @click="setIndustry('传媒/营销')" :class="{cur:industry.indexOf('传媒/营销')!=-1}">传媒/营销</span>
                                            <span @click="setIndustry('金融/财经')" :class="{cur:industry.indexOf('金融/财经')!=-1}">金融/财经</span>
                                            <span @click="setIndustry('电商/微商')" :class="{cur:industry.indexOf('电商/微商')!=-1}">电商/微商</span>
                                            <span @click="setIndustry('文娱')" :class="{cur:industry.indexOf('文娱')!=-1}">文娱</span>
                                            <span @click="setIndustry('母婴')" :class="{cur:industry.indexOf('母婴')!=-1}">母婴</span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left">地域</th>
                                    <td>
                                        <p class="text-box">
                                            <span @click="setCity('北京')" :class="{cur:city.indexOf('北京')!=-1}">北京</span>
                                            <span @click="setCity('上海')" :class="{cur:city.indexOf('上海')!=-1}">上海</span>
                                            <span @click="setCity('广州')" :class="{cur:city.indexOf('广州')!=-1}">广州</span>
                                            <span @click="setCity('深圳')" :class="{cur:city.indexOf('深圳')!=-1}">深圳</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">任务开始时间</th>
                    <td class="border_bottom"><input id="start_time" style="text-align: right;" type="text" v-model="startTime" readonly="readonly" placeholder="请选择 >"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">任务结束时间</th>
                    <td class="border_bottom"><input id="end_time" style="text-align: right;" type="text" v-model="endTime" readonly="readonly" placeholder="请选择 >"></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">发布平台</th>
                    <td class="border_bottom">
                        <p class="index_advert_icon">
                            <span :class="{cur:platform.indexOf('1')!=-1}" @click="setPlatform('1')"><img v-show="platform.indexOf('1')!=-1" src="/images/icon7.png"><img v-show="platform.indexOf('1')==-1" src="/images/icon8.png">&nbsp;微信</span>
                            <span :class="{cur:platform.indexOf('2')!=-1}" @click="setPlatform('2')"><img v-show="platform.indexOf('2')!=-1" src="/images/icon7.png"><img v-show="platform.indexOf('2')==-1" src="/images/icon8.png">&nbsp;微博</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">账号数量</th>
                    <td class="border_bottom"><input style="text-align: right;width: 88%;" type="number" v-model="number" placeholder="请输入"><span style="color: #333;">个</span></td>
                </tr>
                <tr>
                    <th align="left" class="border_bottom">任务总价</th>
                    <td class="border_bottom"><input style="text-align: right;" type="text" readonly="readonly" v-model="total" value="" placeholder=""></td>
                </tr>
                <tr>
                    <th align="left">完成标准</th>
                    <td>
                        <p class="index_advert_icon">
                            <span :class="{cur:endStandard.indexOf('图片')!=-1}" @click="setEndStandard('图片')"><img v-show="endStandard.indexOf('图片')!=-1" src="/images/icon7.png"><img v-show="endStandard.indexOf('图片')==-1" src="/images/icon8.png">&nbsp;图片</span>
                            <span :class="{cur:endStandard.indexOf('链接')!=-1}" @click="setEndStandard('链接')"><img v-show="endStandard.indexOf('链接')!=-1" src="/images/icon7.png"><img v-show="endStandard.indexOf('链接')==-1" src="/images/icon8.png">&nbsp;链接</span>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="index_button_box">
            <p><input type="button" @click="save(1)" value="保存" class="common_button2"></p>
            <p><input type="button" @click="save(2)" value="确认提交" class="common_button"></p>
        </div>
    </div>
</div>
<!--nav-->
<div class="nav">
    <p><a href="index.html"><i class="iconfont">&#xe661;</i><br>首页</a></p>
    <p class="cur"><a href="generalize.html"><i class="iconfont">&#xe621;</i><br>开始推广</a></p>
    <p><a href="./my/index.html"><i class="iconfont">&#xe600;</i><br>我的</a></p>
</div>
<!--nav-end-->
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript" src="/js/third/zepto.min.js"></script>
<script type="text/javascript" src="/js/third/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/js/third/vue.js"></script>
<script type="text/javascript" src="/js/util.js"></script>
<script type="text/javascript" src="/js/third/moment.min.js"></script>
<script type="text/javascript" src="/js/third/jquery-weui.js"></script>
<script type="text/javascript" src="/js/generalize.js"></script>
</body>
</html>