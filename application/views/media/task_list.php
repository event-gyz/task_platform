<!DOCTYPE html>
<html>
    <head>
        <title>任务大厅</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_ujqqb18j5hruow29.css">

        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app">
            <ul class="my_task" style="display:none;">
                <!--list-->
                <li class="task_box" v-for="item in lists">
                    <a class="a_box" :href="'/media/index/getMissionHallTaskDetail?task_id='+item.task_id">
                        <div class="top wait">
                            <p class="name">待领取</p>
                            <p class="time" v-html="item.allot_time"></p>
                        </div>
                        <div class="context">
                            <ul>
                                <li>任务编号：<span>RW{{item.task_id}}</span></li>
                                <li>任务类型：<span>{{typeFn(item.task_type)}}</span></li>
                                <li>任务价格：<span class="warn">¥{{item.platform_price}}</span></li>
                                <li v-if="item.task_type==2">发布平台：<span>{{platformFn(item.publishing_platform)}}</span></li>
                                <li>任务时间：<span>{{timeFn(item.start_time,item.end_time)}}</span></li>
                            </ul>
                        </div>
                    </a>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box pass" href="#" @click="pick(item.task_id)">领取</a></td>
                            <td><a class="a_box warn" href="#" @click="reject(item.task_id)">拒绝</a></td>
                        </tr>
                    </table>
                </li>
                <!--list-end-->
                <p class="no_task" style="display:none;"  v-show="!lists.length"><img src="/images/zwnr.png"><br>暂无分配的任务</p>
            </ul>
            <!--滚动加载-->
            <div class="weui-loadmore">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>
            <!--滚动加载-end-->
        </div>
        <!--nav-->
        <div class="nav">
            <p><a href="/media/index/home"><i class="iconfont">&#xe661;</i><br>首页</a></p>
            <p class="cur"><a href="/media/index/getMissionHallView"><i class="iconfont">&#xe653;</i><br>任务大厅</a></p>
            <p><a href="/media/index/my"><i class="iconfont">&#xe600;</i><br>我的</a></p>
        </div>
        <!--nav-end-->
        <script type="text/javascript" src="/js/third/zepto.min.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/third/moment.min.js"></script>
        <script src="http://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/taskList.js"></script>
    </body>
</html>