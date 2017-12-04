<!DOCTYPE html>
<html>
    <head>
        <title>项目名称</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexAdvert.css" />
    </head>
    <body>
        <div class="main" style="margin: 0;">
            <ul class="my_task">
                <?php if(empty($list) || !is_array($list)){?>
                    <div class="statu_box">
                        <p class="icon-box"><img src="/images/status/dts.png"></p>
                        <p class="text">还没有任务哦，快去新建任务吧</p>
                        <p class="bg_line"></p>
                        <p class="button1">
                            <a href="/advertiser/index/taskView">立即新建</a><br>
                        </p>
                    </div>
                <?php }else{
                    foreach($list as $value) {
                        //待提交
                        if (($value['audit_status'] == 0) && ($value['release_status'] == 0)) {
                            ?>
                            <!--待提交-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><a href="#"><?= $value['task_name'] ?></a></p>
                                    <p class="status">● 待提交</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 修改-->
                                        <td class="border"><a class="a_box" href="#">修改</a></td>
                                        <!-- todo 提交-->
                                        <td class="border"><a class="a_box pass" href="#">提交</a></td>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="#">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--待提交-end-->
                            <?php

                        } else if (($value['audit_status'] == 1) && ($value['release_status'] == 0)) {
                            ?>
                            <!--待审核-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 待审核</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                            </li>
                            <!--待审核-end-->
                            <?php

                        } else if (($value['audit_status'] == 2) && ($value['release_status'] == 0)) {
                            ?>
                            <!--驳回-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 驳回</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 修改-->
                                        <td class="border"><a class="a_box" href="/advertiser/index/taskView?task_id=<?=$value['task_id']?>">修改</a></td>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--驳回-end-->
                        <?php } else if (($value['audit_status'] == 3) && ($value['release_status'] == 0) && ($value['pay_status'] == 0)) {
                            ?>
                            <!--代付款-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 待付款</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 确认付款-->
                                        <td class="border"><a class="a_box pass" href="#">确认付款</a></td>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="#">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--代付款-end-->

                        <?php } else if (($value['audit_status'] == 3) && ($value['release_status'] == 0) && ($value['pay_status'] == 1) && ($value['finance_status'] != 1)) {
                        ?>
                            <!--待财务确认收款-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 待财务确认收款</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="#">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--待财务确认收款-end-->
                        <?php } else if (($value['audit_status'] == 3) && ($value['release_status'] == 0) && ($value['pay_status'] == 1) && ($value['finance_status'] == 1)) {?>
                            <!--待发布-->
                            <li class="task_box">
                                <div class="top wait">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 待发布</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="#">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--待发布-end-->
                        <?php } else if ($value['release_status'] == 1) {?>
                            <!--执行中-->
                            <li class="task_box">
                                <div class="top proceed">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 执行中</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                                <table class="task_table" style="width: 100%">
                                    <tr>
                                        <!-- todo 结束-->
                                        <td><a class="a_box warn" href="#">结束</a></td>
                                    </tr>
                                </table>
                            </li>
                            <!--执行中-end-->
                        <?php } else if ($value['release_status'] == 2) {?>
                            <!--已完成-->
                            <li class="task_box">
                                <div class="top end">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 已完成</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                            </li>
                            <!--已完成-end-->
                        <?php } else if ($value['release_status'] == 7) {?>
                            <!--已结束-->
                            <li class="task_box">
                                <div class="top close">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 已结束</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                            </li>
                            <!--已结束-end-->
                        <?php } else if ($value['release_status'] == 8) {?>
                            <!--手工作废-->
                            <li class="task_box">
                                <div class="top close">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 手工作废</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                            </li>
                            <!--手工作废-end-->
                        <?php } else if ($value['release_status'] == 8) {?>
                            <!--已关闭-->
                            <li class="task_box">
                                <div class="top close">
                                    <p class="name"><?= $value['task_name'] ?></p>
                                    <p class="status">● 已关闭</p>
                                </div>
                                <a href="/advertiser/index/taskInfo?task_id=<?=$value['task_id']?>">
                                <div class="context">
                                    <ul>
                                        <li>任务编号：<span><?= $value['task_id'] ?></span></li>
                                        <li>
                                            任务类型：<span><?= $this->config->item('task_type')[$value['task_type']] ?></span>
                                        </li>
                                        <li>任务单价：<span>¥<?= $value['price'] ?></span></li>
                                        <li>任务总价：<span class="warn">¥<?= $value['total_price'] ?></span></li>
                                        <li>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>－<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></li>
                                        <li>
                                            发布平台：<span><?= __handleNuToName($value['publishing_platform'], $this->config->item('publishing_platform')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                </a>
                            </li>
                            <!--已关闭-end-->
                            <?php }?>
                        <!-- if end-->
                   <?php  }?>
                    <!-- foreach end-->
                <?php   } ?>
            </ul>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
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