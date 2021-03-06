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
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    </head>
    <body>
        <div class="main" style="margin-bottom: 0">
            <?php if(isset($flag) && ($flag == 2)){?>
                <div class="statu_style">

                    <!--注册成功-->
                    <div class="statu_box">
                        <p class="icon-box"><img src="/images/status/sb.png"></p>
                        <h2>该任务已经超时</h2>
                        <p class="text">任务已经超时了哦，回到任务大厅再看看吧</p>
                        <p class="bg_line"></p>
                        <p class="button1"><a href="/media/index/getMissionHallView">返回任务大厅</a></p>
                    </div>
                    <!--注册成功-end-->
                </div>
            <?php }else{?>
            <div class="index_advert">
                <!--待领取-->
                <div class="min-title2">
                    <p class="name">任务基础信息</p>
                    <p class="time">
                        <i class="warn">待领取</i><?=$surplus_time?>
                    </p>
                </div>
                <!--待领取-end-->
                <div class="input-box" style="margin:0">
                    <table>
                        <tr>
                            <th align="left" class="border_bottom" width="70px;">创建时间</th>
                            <td class="border_bottom" align="right"><?=$allot_time?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom" >任务编号</th>
                            <td class="border_bottom" align="right"><?= 'RW'.$task_id?></td>
                        </tr>
                        <tr>
                            <th align="left" class="border_bottom">任务名称</th>
                            <td class="border_bottom" align="right" id="task_name"><?=$task_name?></td>
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
                                <ul id="pb1" class="generalize_img_box">
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
                        <?php if($task_type==2){?>
                        <tr>
                            <th align="left" class="border_bottom">发布平台</th>
                            <td class="border_bottom" align="right"><?= $publishing_platform ?></td>
                        </tr>
                        <?php }?>
                        </tr>
                        <tr>
                            <th align="left">完成标准</th>
                            <td align="right"><?=$completion_criteria?></td>
                        </tr>
                    </table>
                </div>
                <!--待领取-->
                <table class="info_table">
                    <tr>
                        <td><a href="javascrtip:;" class="common_button2 accept">领取</a></td>
                        <td><a href="javascrtip:;" class="common_button4 refuse">拒绝</a></td>
                    </tr>
                </table>
                <!--待领取-end-->
            </div>
            <?php }?>
        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/third/jquery-weui.js"></script>
        <script type="text/javascript" src="/js/third/swiper.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/indexMedia.js"></script>
        <script type="text/javascript">
            var arr = [];
            $('#pb1 img').each(function(index,item){
                arr.push($(item).attr('src'));
            });
            var pb1 = $.photoBrowser({
                items: arr,
                onSlideChange: function(index) {
                  //console.log(this, index);
                },
                onOpen: function() {
                  //console.log("onOpen", this);
                },
                onClose: function() {
                  //console.log("onClose", this);
                }
            });
            $("#pb1").click(function(e) {
                var index = $(e.target).closest('li').index();
                pb1.open(index);
            });
        </script>
    </body>
</html>

