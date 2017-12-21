/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        type:[1,2],
        task_id:'',
        url:'',
        imgs:[]
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this = this;
            var params = window.location.search.substr(1).split('&');
            params.forEach(function(item){
                var name = item.split('=')[0];
                var val = item.split('=')[1];
                if(name == 'task_id'){
                    _this.task_id = val;
                }
            });
            $.ajax({
                url: "/media/index/getGiveInfo",
                dataType: 'json',
                type:"post",
                data:{task_id:_this.task_id},
                success: function(res) {
                    if(res.errorno >= 0){
                        _this.url = res.data.deliver_link;
                        _this.imgs = res.data.deliver_images && JSON.parse(res.data.deliver_images);
                        _this.type = res.data.completion_criteria && res.data.completion_criteria.split(',');
                    }else{
                        util.tips(res.msg);
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            });
            wx.config({
                debug: false,
                appId: $('#appId').val(),
                timestamp: $('#timestamp').val(),
                nonceStr: $('#nonceStr').val(),
                signature: $('#signature').val(),
                jsApiList: [
                    'chooseImage',
                    'uploadImage',
                    'downloadImage',
                    'previewImage'
                ]
            });
        });
    },
    computed:{

    },
    methods:{
        //上传图片
        uploadImg:function(){
            var _this = this;
            wx.chooseImage({
                count: 9,
                sizeType: ['compressed'],
                sourceType: ['album', 'camera'],
                success: function (res) {
                    var localIds = typeof(res.localIds) == 'string'?[res.localIds]:res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    localIds.forEach(function(item,index){
                        wx.getLocalImgData({
                            localId: '' + item, // 图片的localID
                            success: function (res) {
                                var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                                $.ajax({
                                    url: "/upload/base64toimg",
                                    dataType: 'json',
                                    type:"post",
                                    data:{
                                        imgBase64:localData
                                    },
                                    success: function(res) {
                                        if(res.errorno >= 0){
                                            var url = '/'+res.data;
                                            _this.imgs.push(url);
                                        }else{
                                            util.tips(res.msg)
                                        }
                                    },
                                    error:function(){
                                        util.tips('网络异常，请尝试刷新！');
                                    }
                                });
                            }
                        });
                    });
                }
            });
        },
        removeImg: function(item){
            var index= this.imgs.indexOf(item);
            this.imgs.splice(index,1);
        },
        save: function(){
            var _this = this;
            if($('#info').length){
                if(!this.url){
                    util.tips('请输入任务结果链接！');
                    return;
                }else if(!util.regexp.url.test(this.url)){
                    util.tips('任务结果链接格式错误！');
                    return;
                }
            }
            if($('.generalize_img_box').length){
                if(!this.imgs.length){
                    util.tips('请上传任务结果图片！');
                    return;
                }
            }
            util.confirm('是否确认交付任务',function(){
                $.ajax({
                    url: "/media/index/giveTaskApi",
                    dataType: 'json',
                    type:"post",
                    data:{
                        task_id: _this.task_id,
                        deliver_link: _this.url,
                        deliver_images: _this.imgs
                    },
                    success: function(res) {
                        if(res.errorno > 0){
                            util.tips(res.msg);
                            //提示停留2秒然后跳转
                            setTimeout(function(){
                                location.href='/media/index/taskDetail?task_id='+_this.task_id;
                            },2000);

                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            },function(){});

        }
    }
});




