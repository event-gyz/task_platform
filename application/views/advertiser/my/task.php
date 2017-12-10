<!DOCTYPE html>
<html>
    <head>
        <title>我的任务</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexAdvert.css" />

        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" id="app" style="margin: 0;">
            <ul class="my_task" style="display:none;">
                <li class="task_box" v-for="item in lists">
                    <a class="a_box" :href="'/advertiser/index/taskInfo?task_id='+item.task_id">
                    <div class="top wait" :class="task_status_class(item)">
                        <p class="name">{{item.task_name}}</p>
                        <p class="status">● {{task_status(item)}}</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>{{item.task_id}}</span></li>
                            <li>任务类型：<span>{{typeFn(item.task_type)}}</span></li>
                            <li>任务单价：<span>¥{{item.price}}</span></li>
                            <li>任务总价：<span class="warn">¥{{item.total_price}}</span></li>
                            <li>任务时间：<span>{{timeFn(item.start_time,item.end_time)}}</span></li>
                            <li>发布平台：<span>{{platformFn(item.publishing_platform)}}</span></li>
                        </ul>
                    </div>
                    </a>
                    <table v-if="task_status(item) == '待提交'" class="task_table" style="width: 100%"><!--待提交-->
                        <tr>
                            <td class="border"><a class="a_box" href="#">修改</a></td>
                            <td class="border"><a class="a_box pass" href="#">提交</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '驳回'" class="task_table" style="width: 100%"><!--驳回-->
                        <tr>
                            <td class="border"><a class="a_box" href="#">修改</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '代付款'" class="task_table" style="width: 100%"><!--代付款-->
                        <tr>
                            <td class="border"><a class="a_box pass" href="#">确认付款</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '代财务确认收款'" class="task_table" style="width: 100%"><!--代财务确认收款-->
                        <tr>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                    <table v-if="task_status(item) == '待发布'" class="task_table" style="width: 100%"><!--待发布-->
                        <tr>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <p class="no_task" style="display:none;"  v-show="!lists.length"><img src="/images/zwnr.png"><br>暂无任务</p>
            </ul>
            <!--滚动加载-->
            <div class="weui-loadmore">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>
            <!--滚动加载-end-->
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script src="http://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/js/third/moment.min.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/myTaskAdvertiser.js"></script>

    </body>

<?php
function __handleNuToName($str,$configArr){
    if(empty($str)){
        return '';
    }
    $arr = explode(',',$str);
    $nStr = '';
    if(!empty($arr)){
        foreach($arr as $value){
            $nStr .= $configArr[$value].',';
        }
    }
    $nStr = rtrim($nStr,',');
    return $nStr;
}
?>
</html>