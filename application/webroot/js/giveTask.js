/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        task_id:'',
        url:'',
        imgs:[1,2,3,4]
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
            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: 'aaa', // 必填，企业号的唯一标识，此处填写企业号corpid
                timestamp: '123123', // 必填，生成签名的时间戳
                nonceStr: 'sdfsdfsfd', // 必填，生成签名的随机串
                signature: 'eeee',// 必填，签名，见附录1
                jsApiList: [
                    'chooseImage',
                    'uploadImage',
                    'downloadImage',
                    'previewImage'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
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
                count: 1,
                sizeType: ['compressed'],
                sourceType: ['album', 'camera'],
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    _this.imgs.push(localIds);
                }
            });
        },
        removeImg: function(item){
            var index= this.imgs.indexOf(name);
            this.imgs.splice(index,1);
        },
        save: function(){
            var _this = this;
            if(!this.url){
                util.tips('请输入任务结果链接！');
                return;
            }else if(!util.regexp.url.test(this.url)){
                util.tips('任务结果链接格式错误！');
                return;
            }
            if($('.generalize_img_box').length){
                if(!this.imgs.length){
                    util.tips('请上传任务结果图片！');
                    return;
                }
            }
            $.ajax({
                url: "/media/index/giveTaskApi",
                dataType: 'json',
                type:"post",
                data:{
                    task_id: this.task_id,
                    deliver_link: this.url,
                    deliver_images: this.imgs
                },
                success: function(res) {
                    if(res.errorno > 0){
                        console.log(res);
                    }else{
                        util.tips(res.msg)
                    }
                },
                error:function(){
                    util.tips('网络异常，请尝试刷新！');
                }
            })
        }
    }
});




