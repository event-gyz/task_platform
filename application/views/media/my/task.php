<!DOCTYPE html>
<html>
    <head>
        <title>我的任务</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />


        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app" style="margin: 0;">
            <ul class="my_task" style="display:none;">
                <!--执行中-->
                <li v-for="item in lists" class="task_box">
                    <a class="a_box" :href="'/media/index/taskDetail?task_id='+item.task_id">
                    <div class="top proceed" :class="task_status_class(item)">
                        <p class="name">{{item.task_name}}</p>
                        <p class="status">● {{task_status(item)}}</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>RW{{item.task_id}}</span></li>
                            <li>任务类型：<span>{{typeFn(item.task_type)}}</span></li>
                            <li>任务单价：<span class="warn">¥{{item.platform_price}}</span></li>
                            <li v-if="item.task_type==2">发布平台：<span>{{platformFn(item.publishing_platform)}}</span></li>
                            <li>任务时间：<span>{{timeFn(item.start_time,item.end_time)}}</span></li>
                        </ul>
                    </div>
                    </a>
                    <table v-if="task_status(item) == '执行中'" class="task_table" style="width: 100%"><!--执行中-->
                        <tr>
                            <td><a class="a_box s_color1" :href="'/media/index/giveTask?task_id='+item.task_id">交付任务</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '交付审核失败'" class="task_table" style="width: 100%"><!--交付审核失败-->
                        <tr>
                            <td><a class="a_box s_color1" :href="'/media/index/giveTask?task_id='+item.task_id">重新交付</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '待确认收款'" class="task_table" style="width: 100%"><!--待确认收款-->
                        <tr>
                            <td><a class="a_box s_color1" href="#" @click="sk(item.task_id)">确认收款</a></td>
                        </tr>
                    </table>
                </li>
                <!--执行中-end-->
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