<!DOCTYPE html>
<html>
    <head>
        <title>我的任务</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
    </head>
    <body>
        <div class="main" id="app" style="margin: 0;">
            <ul class="my_task" style="display:none;">
                <!--执行中-->
                <li v-for="item in lists" class="task_box">
                    <a :href="'/media/index/taskDetail?task_id='+item.task_id">
                    <div class="top proceed" :class="task_status_class(item)">
                        <p class="name">{{item.task_name}}</p>
                        <p class="status">● {{task_status(item)}}</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>{{item.task_id}}</span></li>
                            <li>任务类型：<span>{{typeFn(item.task_type)}}</span></li>
                            <li>任务总价：<span class="warn">¥{{item.total_price}}</span></li>
                            <li>发布平台：<span>{{platformFn(item.publishing_platform)}}</span></li>
                            <li>任务时间：<span>{{timeFn(item.start_time,item.end_time)}}</span></li>
                        </ul>
                    </div>
                    </a>
                    <table v-if="task_status(item) == '执行中'" class="task_table" style="width: 100%"><!--执行中-->
                        <tr>
                            <td><a class="a_box s_color1" href="./give_task.html">交付任务</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '交付审核失败'" class="task_table" style="width: 100%"><!--交付审核失败-->
                        <tr>
                            <td><a class="a_box s_color1" href="#">重新交付</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '待确认收款'" class="task_table" style="width: 100%"><!--待确认收款-->
                        <tr>
                            <td><a class="a_box s_color1" href="#">确认收款</a></td>
                        </tr>
                    </table>
                </li>
                <!--执行中-end-->

                <!--未完成-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 未完成</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>11.14 ~ 11.06</span></li>
                        </ul>
                    </div>
                </li>
                <!--未完成-end-->
                <!--待审核-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name"><a href="#">天猫超市高校藏盒子活动</a></p>
                        <p class="status">● 待结果审核</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>11.14 ~ 11.06</span></li>
                        </ul>
                    </div>
                </li>
                <!--待审核-end-->
                <!--待财务付款-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 待财务付款</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                </li>
                <!--待财务付款-end-->
                <!--结果审核驳回-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 结果审核驳回</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td><a class="a_box s_color1" href="#">重新交付</a></td>
                        </tr>
                    </table>
                </li>
                <!--结果审核驳回-end-->
                <!--待确认收款-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 待确认收款</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td><a class="a_box s_color1" href="#">确认收款</a></td>
                        </tr>
                    </table>
                </li>
                <!--待确认收款-end-->
                <!--已完成-->
                <li class="task_box">
                    <div class="top end">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 已完成</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                </li>
                <!--已完成-end-->
                <!--已关闭-->
                <li class="task_box">
                    <div class="top close">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 已关闭</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                            <li>任务时间：<span>2017.11.14 ~ 2017.11.06</span></li>
                        </ul>
                    </div>
                </li>
                <!--已关闭-end-->
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
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/third/moment.min.js"></script>
        <script src="http://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/myTaskMedia.js"></script>
    </body>
</html>