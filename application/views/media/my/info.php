<!DOCTYPE html>
<html>
    <head>
        <title>任务详情</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/swiper-3.4.2.min.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_xnfkadft2e7y14i.css">
    </head>
    <body>
        <div class="main" style="margin-bottom: 0">
            <div class="index_advert">
                <?php if($release_status==9 || $release_status==8 || $release_status==7){?>
                <!--已关闭-->
                <div class="task_status task_status3">
                    <p class="status">● 已关闭</p>
                </div>
                <!--已关闭-end-->

                <?php }else if($release_status==2){?>
                <!--已拒绝-->
                <div class="task_status task_status1">
                    <p class="status">● 已拒绝</p>
                    <p class="time">拒绝时间：<?= $receive_time?></p>
                </div>
                <!--已拒绝-end-->

                <?php }else if($release_status==1 && $receive_status==1 && (time()<$start_time)){?>
                <!--未开始-->
                <div class="task_status task_status1">
                    <p class="status">● 未开始</p>
                    <p class="time">领取时间：<?= $receive_time?></p>
                </div>
                <!--未开始-end-->

                <?php }else if($release_status==1 && $receive_status==1 && (time()>$start_time) && (time()<$end_time) && $deliver_status!=1){?>
                <!--执行中-->
                <div class="task_status task_status1">
                    <p class="status">● 执行中</p>
                    <p class="time">领取时间：<?= $receive_time?></p>
                </div>
                <!--执行中-end-->

                <?php }else if($release_status==1 && $receive_status==1 && $deliver_status==1 && $deliver_audit_status==0){?>
                <!--交付待审核-->
                <div class="task_status task_status1">
                    <p class="status">● 交付待审核</p>
                    <p class="time">交付时间：<?=$deliver_time?></p>
                </div>
                <!--交付待审核-end-->

                <?php }else if($release_status==1 && $receive_status==1 && $deliver_status==1 && $deliver_audit_status==2){?>
                <!--结果审核驳回-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/sb.png"></p>
                    <h2>任务结果被驳回</h2>
                    <p class="text">抱歉，此条任务结果被驳回，请根据审核意见修改后重新交付。</p>
                    <div class="info">
                        <ul>
                            <li class="tit">审核意见：</li>
                            <li class="list">
                                <?= !empty($reasons_for_rejection)?$reasons_for_rejection:''?>
                            </li>
                        </ul>
                    </div>
                    <p class="bg_line"></p>
                    <p class="button1">
                        <a href="/media/index/giveTask?task_id=<?=$task_id?>&flag=2">立即修改</a><br>
                        <span><img src="/images/status/ts.png"><?=$allot_time?></span>
                    </p>
                </div>
                <div class="task_status task_status1">
                    <p class="status">● 结果审核驳回</p>
                    <p class="time">驳回时间：<?=$update_time?></p>
                </div>
                <!--结果审核驳回-end-->

                <?php }else if($release_status==1 && $receive_status==1 && $deliver_status==1 && $deliver_audit_status==1 && $finance_status!=1){?>
                <!--待财务付款-->
                <div class="task_status task_status1">
                    <p class="status">● 待财务付款</p>
                    <p class="time">交付时间：<?=$update_time?></p>
                </div>
                <!--待财务付款-end-->

                <?php }else if($release_status==1 && $receive_status==1 && $deliver_status==1 && $deliver_audit_status==1 && $finance_status==1 && $receivables_status!=1){?>
                <!--待确认收款-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/dd.png"></p>
                    <h2>待确认收款</h2>
                    <p class="text">财务人员已经将此任务的收入打入您的支付宝账户，请确认已收到款项。</p>
                    <p class="bg_line"></p>
                    <p class="button1">
                        <a href="#" class="confirmReceivables">确认收款</a><br>
                    </p>
                </div>
                <div class="task_status task_status1">
                    <p class="status">● 待确认收款</p>
                    <p class="time">交付时间：<?=$pay_time?></p>
                </div>
                <!--待确认收款-end-->

                <?php }else if($receive_status==1 && $deliver_status==1 && $finance_status==1 && $receivables_status==1){?>
                <!--已完成-->
                <div class="task_status task_status2">
                    <p class="status">● 已完成</p>
                    <p class="time">完成时间：<?=$update_time?></p>
                </div>
                <!--已完成-end-->

                <?php }else if($receive_status==1 && $deliver_audit_status!=1 && (time()>$end_time)){?>
                <!--未完成-->
                <div class="task_status task_status1">
                    <p class="status">● 未完成</p>
                    <p class="time">领取时间：<?=$receive_time?></p>
                </div>
                <!--未完成-end-->
                <?php }?>
                <div class="input-box" style="margin:0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="70px;">创建时间</th>
                            <td class="border_bottom" align="right"><?=$allocation_time?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >任务编号</th>
                            <td class="border_bottom" align="right"><?=$task_id?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务名称</th>
                            <td class="border_bottom" align="right"><?=$task_name?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务类型</th>
                            <td class="border_bottom" align="right"><?= $this->config->item('task_type')[$task_type] ?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务标题</th>
                            <td class="border_bottom" align="right"><?=$title?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务链接</th>
                            <td class="border_bottom" align="right"><?=$link?></td>
                        </tr>
                        <tr>
                            <th align="left" valign="top" class="border_bottom"><br>任务图片</th>
                            <td class="border_bottom">
                                <ul class="generalize_img_box">
                                    <?php if($pics){
                                        $pics = json_decode($pics,true);
                                        foreach($pics as $value){
                                            ?>
                                            <li><img src="<?=$value?>"></li>
                                        <? }
                                    }?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th align="left" valign="top"><br>任务描述</th>
                            <td align="right"><?=$task_describe?></td>
                        </tr>
                    </table>
                </div>
                <div class="min-title1">任务发布信息</div>
                <div class="input-box" style="margin-bottom:0px">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">任务单价</th>
                            <td class="border_bottom warn" align="right">￥<?=$platform_price?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务时间</th>
                            <td class="border_bottom" align="right"><?= !empty($start_time)?date('Y.m.d', $start_time):'暂无' ?>－<?= !empty($end_time)?date('Y.m.d', $end_time):'暂无' ?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">发布平台</th>
                            <td class="border_bottom" align="right"><?= $publishing_platform ?></td>
                        </tr>
                        <tr>
                            <th align="left">完成标准</th>
                            <td align="right"><?=$completion_criteria?></td>
                        </tr>
                    </table>
                </div>
                <?php if($release_status==1 && $receive_status==1 && (time()>$start_time) && (time()<$end_time) && $deliver_status!=1){?>
                <!--执行中-->
                <table class="info_table">
                    <tr>
                        <td><a href="/media/index/giveTask?task_id=<?=$task_id?>" class="common_button2">交付任务</a></td>
                    </tr>
                </table>
                <!--执行中-end-->
                <?php }else if($release_status==1 && $receive_status==1 &&(time()>$start_time) && (time()<$end_time)  && $deliver_status==1 && $deliver_audit_status==2){?>
                <!--结果审核驳回-->
                <table class="info_table">
                    <tr>
                        <td><a href="/media/index/giveTask?task_id=<?=$task_id?>&flag=2" class="common_button2">重新交付</a></td>
                    </tr>
                </table>
                <!--结果审核驳回-end-->
                <?php }else if($release_status==1 && $receive_status==1 && $deliver_status==1 && $deliver_audit_status==1 && $finance_status==1 && $receivables_status!=1){?>
                <!--待确认收款-->
                <table class="info_table">
                    <tr>
                        <td><a href="#" class="confirmReceivables">确认收款</a></td>
                    </tr>
                </table>
                <!--待确认收款-end-->
                <?php }?>
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/third/swiper-3.3.1.jquery.min.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/indexMedia.js"></script>
    </body>
</html>

