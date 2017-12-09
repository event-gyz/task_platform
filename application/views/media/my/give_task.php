<!DOCTYPE html>
<html>
    <head>
        <title>媒体人-交付任务</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/common.css" />
        <link rel="stylesheet" href="/css/indexMedia.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_15076_xnfkadft2e7y14i.css">
    </head>
    <body>
        <div class="main" id="app">
            <div class="login-style">
                <div class="input-box">
                    <table>
                        <?php if(in_array('1',explode(',',$completion_criteria))){?>
                        <tr>
                            <th align="left" class="border_bottom" width="90px;">任务结果链接</th>
                            <td class="border_bottom">
<!--                                todo 审核失败以后原数据要显示-->
                                <input type="text" v-model="url" placeholder="请输入，以http://或https://开头" value="<?=$deliver_link?>">
                            </td>
                        </tr>
                        <?php }?>
                        <?php if(in_array('2',explode(',',$completion_criteria))){?>
                        <tr>
                            <th align="left" width="60px;" valign="top"><br>任务结果图片</th>
                            <td>
                                <ul class="generalize_img_box">
                                    <li v-for="item in imgs"><img :src="item"><i class="iconfont" @click="removeImg(item)">&#xe601;</i></li>
                                </ul>
                                <ul class="generalize_up_button">
                                    <li class="img" @click="uploadImg"><img src="/images/Bitmap.png"></li>
                                    <li class="text">最多上传9张图，图片大小不超过3M，长宽比1:1。仅支持jpg、png格式</li>
                                </ul>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                </div>
            </div>
            <div>
                <p class="button-box"><input type="button" @click="save" value="确认提交" class="common_button"></p>
            </div>
        </div>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
        <script type="text/javascript" src="/js/third/jquery.js"></script>
        <script type="text/javascript" src="/js/third/vue.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="/js/giveTask.js"></script>
    </body>
</html>