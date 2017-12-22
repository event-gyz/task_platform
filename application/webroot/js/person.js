/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        type:'person',
        name:'',
        phone:'',
        idCard:'',
        frontCard:'',
        backCard:'',
        card:''
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this = this;
            var params = window.location.search.substr(1).split('&');
            params.forEach(function(item){
                var name = item.split('=')[0];
                var val = item.split('=')[1];
                if(name == 'phone'){
                    _this.phone = val;
                }
                if(name == 'flag'){
                    _this.flag = val;
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
            if(_this.flag == 2){
                $.ajax({
                    url: "/advertiser/index/userInfoApi",
                    dataType: 'json',
                    type:"post",
                    data:{},
                    success: function(res) {
                        if(res.errorno > 0){
                            _this.type= 'person';
                            _this.name= res.data.advertiser_name;
                            _this.phone= res.data.advertiser_phone;
                            _this.idCard= res.data.id_card;
                            _this.frontCard= res.data.id_card_positive_pic;
                            _this.backCard= res.data.id_card_back_pic;
                            _this.card= res.data.handheld_id_card_pic;
                        }else{
                            util.tips(res.msg)
                        }
                    },
                    error:function(){
                        util.tips('网络异常，请尝试刷新！');
                    }
                })
            }
        });
    },
    computed:{
        setUrlPerson: function(){
            if(this.flag){
                return '/advertiser/index/person?phone='+this.phone+'&flag='+this.flag;
            }else if(this.phone){
                return '/advertiser/index/person?phone='+this.phone;
            }else{
                return '/advertiser/index/person';
            }
        },
        setUrlCompany: function(){
            if(this.flag){
                return '/advertiser/index/company?phone='+this.phone+'&flag='+this.flag;
            }else if(this.phone){
                return '/advertiser/index/company?phone='+this.phone;
            }else{
                return '/advertiser/index/company';
            }
        }
    },
    methods:{
        //上传
        uploadImg:function(name){
            var _this = this;
            wx.chooseImage({
                count: 1,
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
                                            _this[name] = url;
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
        removeImg:function(name){
            this[name] = '';
        },
        save: function(){
            var _this = this;
            if(!this.name){
                util.tips('请输入您的姓名！');
                return;
            }
            if(!this.phone){
                util.tips('请输入您的手机号！');
                return;
            }else if(!util.regexp.mobile.test(this.phone)){
                util.tips('手机号格式错误！');
                return;
            }
            if(!this.idCard){
                util.tips('请输入您的身份证号！');
                return;
            }else if(!util.regexp.idCard.test(this.idCard)){
                util.tips('身份证号格式错误！');
                return;
            }
            if(!this.frontCard){
                util.tips('请上传身份证正面照片！');
                return;
            }
            if(!this.backCard){
                util.tips('请上传身份证背面照片！');
                return;
            }
            if(!this.card){
                util.tips('请上传手持身份证照片！');
                return;
            }
            $.ajax({
                url: "/advertiser/index/saveInfo",
                dataType: 'json',
                type:"post",
                data:{
                    type:'person',
                    name:this.name,
                    phone:this.phone,
                    idCard:this.idCard,
                    frontCard:this.frontCard,
                    backCard:this.backCard,
                    handheld_id_card_pic:this.card
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/advertiser/login/accountStatus6';
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
