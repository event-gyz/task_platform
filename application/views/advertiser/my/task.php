<!DOCTYPE html>
<html>
    <head>
        <title>项目名称</title>
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
                    <a href="#">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</a></p>
                        <p class="status">● 待提交</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>{{item.task_id}}</span></li>
                            <li>任务类型：<span>{{typeFn(item.task_type)}}</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>{{timeFn(item.start_time,item.end_time)}}</span></li>
                            <li>发布平台：<span>{{platformFn(item.publishing_platform)}}</span></li>
                        </ul>
                    </div>
                    </a>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box" href="#">修改</a></td>
                            <td class="border"><a class="a_box pass" href="#">提交</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>



                <!--待提交-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name"><a href="#">天猫超市高校藏盒子活动</a></p>
                        <p class="status">● 待提交</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box" href="#">修改</a></td>
                            <td class="border"><a class="a_box pass" href="#">提交</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <!--待提交-end-->
                <!--待审核-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 待审核</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                </li>
                <!--待审核-end-->
                <!--驳回-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 驳回</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box" href="#">修改</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <!--驳回-end-->
                <!--代付款-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 待付款</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td class="border"><a class="a_box pass" href="#">确认付款</a></td>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <!--代付款-end-->
                <!--代财务确认收款-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 代财务确认收款</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <!--代财务确认收款-end-->
                <!--待发布-->
                <li class="task_box">
                    <div class="top wait">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 待发布</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                    <table class="task_table" style="width: 100%">
                        <tr>
                            <td><a class="a_box warn" href="#">结束</a></td>
                        </tr>
                    </table>
                </li>
                <!--待发布-end-->
                <!--执行中-->
                <li class="task_box">
                    <div class="top proceed">
                        <p class="name">天猫超市高校藏盒子活动</p>
                        <p class="status">● 执行中</p>
                    </div>
                    <div class="context">
                        <ul>
                            <li>任务编号：<span>2017090908</span></li>
                            <li>任务类型：<span>线上任务</span></li>
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                </li>
                <!--执行中-end-->
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
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
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
                            <li>任务单价：<span>¥5</span></li>
                            <li>任务总价：<span class="warn">¥8888</span></li>
                            <li>任务时间：<span>2017.11.14 ~2017.11.06</span></li>
                            <li>发布平台：<span>微博、微信</span></li>
                        </ul>
                    </div>
                </li>
                <!--已关闭-end-->
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