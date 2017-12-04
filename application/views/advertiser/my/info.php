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
    </head>
    <body>
        <div class="main" style="margin-bottom: 0">
            <div class="index_advert">
                <!--待提交-->
                <?php if(($audit_status == 0) && ($release_status == 0)){?>
                <div class="min-title1">任务基础信息<span class="warn">● 待提交</span></div>
                <!--待提交-end-->
                <?php }elseif(($audit_status == 1) && ($release_status == 0)){?>
                <!--待审核-->
                <div class="min-title1">任务基础信息<span class="warn">● 待审核</span></div>
                <!--待审核-end-->
                <?php }?>

                <?php if(($audit_status == 2) && ($release_status == 0)){?>
                <!--驳回-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/sb.png"></p>
                    <h2>任务被驳回</h2>
                    <p class="text">抱歉，此条任务被驳回，请根据审核意见修改后重新提交审核。</p>
                    <div class="info">
                        <ul>
                            <li class="tit">审核意见：</li>
                            <li class="list">
                                <?=$reasons_for_rejection;?>
                            </li>
                        </ul>
                    </div>
                    <p class="bg_line"></p>
                    <p class="button1">
                        <a href="/advertiser/index/taskView?task_id=<?=$_GET['task_id']?>">立即修改</a><br>
                        <span><img src="/images/status/ts.png">剩余时间：<?=$allot_time?></span>
                    </p>
                </div>
                <div class="min-title1">任务基础信息<span class="warn">● 驳回</span></div>
                <!--驳回-end-->
                <?php }?>

                <?php if(($audit_status == 3) && ($release_status == 0) && ($pay_status == 0)){?>
                <!--待付款-->
                <div class="min-title1">任务基础信息<span class="warn">● 待付款</span></div>
                <!--待付款-end-->
                <?php }?>

                <?php if(($audit_status == 3) && ($release_status == 0) && ($pay_status == 1) && ($finance_status != 1)){?>
                <!--待财务确认收款-->
                <div class="min-title1">任务基础信息<span class="warn">● 待财务确认收款</span></div>
                <!--待财务确认收款-end-->
                <?php }?>

                <?php if(($audit_status == 3) && ($release_status == 0) && ($pay_status == 1) && ($finance_status == 1)){?>
                <!--待发布-->
                <div class="min-title1">任务基础信息<span class="warn">● 待发布</span></div>
                <!--待发布-end-->
                <?php }?>

                <?php if($release_status == 1){?>
                    <!--执行中-->
                    <div class="min-title1"><span style="float:right">查看领取进度</span></div>
                    <span></span>
                    <!--执行中-end-->
                <?php }?>

                <?php if($release_status == 2){?>
                    <!--已完成-->
                    <div class="min-title1">任务基础信息<span class="warn">● 已完成</span></div>
                    <!--已完成-end-->
                <?php }?>

                <?php if($release_status == 7){?>
                    <!--已结束-->
                    <div class="min-title1">任务基础信息<span class="warn">● 已结束</span></div>
                    <!--已结束-end-->
                <?php }?>

                <?php if($release_status == 8){?>
                    <!--已结束-->
                    <div class="min-title1">任务基础信息<span class="warn">● 手工作废</span></div>
                    <!--已结束-end-->
                <?php }?>

                <?php if($release_status == 9){?>
                    <!--已结束-->
                    <div class="min-title1">任务基础信息<span class="warn">● 已关闭</span></div>
                    <!--已结束-end-->
                <?php }?>

                <?php if(($audit_status ==3) && ($release_status==1)){?>
                <!--执行中-->
<!--                todo 上面直接显示一个查看领取人数  点击后加载出这一段提示-->
                <?php if(($media_man_number > $total_person)){?>
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/dts.png"></p>
                    <p class="text"><span class="s_color1"><?=$total_person?></span>个媒体人已领取任务，离期望账号数量还差<span class="s_color1"><?=$media_man_number-$total_person?></span>个，您可以新建一个任务来达到推广效果</p>
                    <p class="bg_line"></p>
                    <p class="button1">
                        <a href="/advertiser/index/taskView">立即新建</a><br>
                    </p>
                </div>
                <?php }?>
                <div class="min-title1">任务基础信息<span class="warn">● 执行中</span></div>
                <!--执行中-end-->
                <?php }?>

                <?php if($release_status == 9){?>
                <!--已关闭-->
                <div class="statu_box">
                    <p class="icon-box"><img src="/images/status/sb.png"></p>
                    <h2>任务已关闭</h2>
                    <p class="text">抱歉，此条任务已被关闭。</p>
                    <div class="info">
                        <ul>
                            <li class="tit">关闭时间：</li>
                            <li class="list">
                                <?=$close_time;?>
                            </li>
                            <li class="tit">关闭原因：</li>
                            <li class="list">
                                <?=$close_reason;?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="min-title1">任务基础信息<span class="warn">● 已关闭</span></div>
                <!--已关闭-end-->
                <?php }?>

                <?php if($release_status == 2){?>
                <!--已完成-->
                <div class="min-title1">任务基础信息<span class="warn">● 已完成</span></div>
                <!--已完成-end-->
                <?php }?>

                <div class="input-box" style="margin:0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="70px;">创建时间</th>
                            <td class="border_bottom" align="right"><?=$create_time?></td>
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
                            <td class="border_bottom warn" align="right">￥<?=$price?></td>
                        </tr>
                        <?php if($media_man_require == 1){?>
                        <tr>
                            <th align="left" class="border_bottom" >账号要求</th>
                            <td class="border_bottom" align="right">自定义要求</td>
                        </tr>
                        <tr>
                            <th class="border_bottom" width="45px;" align="left">性别</th>
                            <td class="border_bottom" align="right"><?=$require_sex?></td>
                        </tr>
                        <tr>
                            <th class="border_bottom" align="left">年龄</th>
                            <td class="border_bottom" align="right"><?=$require_age?></td>
                        </tr>
                        <tr>
                            <th class="border_bottom" align="left">兴趣爱好</th>
                            <td class="border_bottom" align="right"><?=$require_hobby?></td>
                        </tr>
                        <tr>
                            <th class="border_bottom" align="left">行业</th>
                            <td class="border_bottom" align="right"><?=$require_industry?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">地域</th>
                            <td class="border_bottom" align="right"><?=$require_local?></td>
                        </tr>
                        <? }else{ ?>
                        <tr>
                            <th align="left" class="border_bottom" >账号要求</th>
                            <td class="border_bottom" align="right">无要求</td>
                        </tr>
                        <? } ?>
                        <tr>
                            <th align="left" class="border_bottom">任务时间</th>
                            <td class="border_bottom" align="right"><?= !empty($start_time)?date('Y.m.d', $start_time):'暂无' ?>－<?= !empty($end_time)?date('Y.m.d', $end_time):'暂无' ?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">发布平台</th>
                            <td class="border_bottom" align="right"><?= $publishing_platform ?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">账号数量</th>
                            <td class="border_bottom" align="right"><?=$media_man_number?>个</td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务总价</th>
                            <td class="border_bottom warn" align="right"><?=$total_price?></td>
                        </tr>
                        <tr>
                            <th align="left">完成标准</th>
                            <td align="right"><?=$completion_criteria?></td>
                        </tr>
                    </table>
                </div>
                <!--待提交-->
                <table class="info_table">
                    <tr>
                        <td><a href="#" class="common_button3">修改</a></td>
                        <td><a href="#" class="common_button2">提交</a></td>
                        <td><a href="#" class="common_button4">结束</a></td>
                    </tr>
                </table>
                <!--待提交-end-->
                <!--驳回-->
                <table class="info_table">
                    <tr>
                        <td><a href="#" class="common_button3">修改</a></td>
                        <td><a href="#" class="common_button4">结束</a></td>
                    </tr>
                </table>
                <!--驳回-end-->
                <!--待付款-->
                <table class="info_table">
                    <tr>
                        <td><a href="#" class="common_button2">确认付款</a></td>
                        <td><a href="#" class="common_button4">结束</a></td>
                    </tr>
                </table>
                <!--待付款-end-->
                <!--待财务确认收款-->
                <table class="info_table">
                    <tr>
                        <td><a href="#" class="common_button4">结束</a></td>
                    </tr>
                </table>
                <!--待财务确认收款-end-->
            </div>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/third/swiper-3.3.1.jquery.min.js"></script>
        <script type="text/javascript" src="/js/indexMedia.js"></script>
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

