<!DOCTYPE html>
<html>
    <head>
        <title>媒体人-我的收入</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
    </head>
    <body>
        <div class="main" style="margin-bottom: 0;">
            <div class="income">
                <!--head-->
                <div class="income_head">
                    <ul>
                        <li class="border">
                            <p class="num">￥<span><?=$moneyTotal?></span></p>
                            <p class="text">总收入</p>
                        </li>
                        <li>
                            <p class="num">￥<span><?=$notInComeMoneyTotal?></span></p>
                            <p class="text">已错过</p>
                        </li>
                    </ul>
                </div>
                <!--head-end-->
                <!--con-->
                <div class="income_list">
                    <ul>
                        <?php foreach($list as $value){
                            ?>
                            <li>
                                <div class="left">
                                    <p>任务编号：<span><?=$value['task_id']?></span></p>
                                    <p>任务名称：<span><?=$value['task_name']?></span></p>
                                    <p>任务时间：<span><?= !empty($value['start_time'])?date('Y.m.d', $value['start_time']):'暂无' ?>~<?= !empty($value['end_time'])?date('Y.m.d', $value['end_time']):'暂无' ?></span></p>
                                </div>
                                <div class="right warn">¥<?=$value['platform_price']?></div>
                            </li>
                        <?php
                        }?>
                    </ul>
                </div>
                <!--con-end-->
            </div>


        </div>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
    </body>
</html>