/**
 * Created by Zhang on 17/11/28.
 */
var app = new Vue({
    el:'#app',
    data:{
        noPhone:'',
        type:'company',
        companyName:'',
        companyAdress:'',
        name:'',
        phone:'',
        companyImg:''
    },
    mounted:function(){
        this.$nextTick(function(){
            var _this = this;
            var params = window.location.search.substr(1).split('&');
            params.forEach(function(item){
                var name = item.split('=')[0];
                var val = item.split('=')[1];
                if(name == 'phone'){
                    _this.noPhone = val;
                }
                if(name == 'flag'){
                    _this.flag = val;
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
            if(_this.flag == 2){
                $.ajax({
                    url: "/advertiser/index/userInfoApi",
                    dataType: 'json',
                    type:"post",
                    data:{},
                    success: function(res) {
                        if(res.errorno > 0){
                            _this.type= 'company';
                            _this.companyName= res.data.company_name;
                            _this.companyAdress= res.data.company_address;
                            _this.name= res.data.content_name;
                            _this.phone= res.data.content_phone;
                            _this.companyImg= res.data.business_license_pic;
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
                return '/advertiser/index/person?phone='+this.noPhone+'&flag='+this.flag;
            }else if(this.noPhone){
                return '/advertiser/index/person?phone='+this.noPhone;
            }else{
                return '/advertiser/index/person';
            }
        },
        setUrlCompany: function(){
            if(this.flag){
                return '/advertiser/index/company?phone='+this.noPhone+'&flag='+this.flag;
            }else if(this.noPhone){
                return '/advertiser/index/company?phone='+this.noPhone;
            }else{
                return '/advertiser/index/company';
            }
        }
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
                    _this.companyImg = localIds;
                }
            });
        },
        save: function(){
            var _this = this;
            if(!this.companyName){
                util.tips('请输入公司名！');
                return;
            }
            if(!this.companyAdress){
                util.tips('请输入公司地址！');
                return;
            }
            if(!this.name){
                util.tips('请输入联系人名称！');
                return;
            }
            if(!this.phone){
                util.tips('请输入手机号！');
                return;
            }else if(!util.regexp.mobile.test(this.phone)){
                util.tips('手机号格式错误！');
                return;
            }else if(this.phone == this.noPhone){
                util.tips('联系人手机号不能和您的手机号一致！');
                return;
            }
            // if(!this.companyImg){
            //     util.tips('请上传营业执照！');
            //     return;
            // }
            $.ajax({
                url: "/advertiser/index/saveInfo",
                dataType: 'json',
                type:"post",
                data:{
                    type:'company',
                    companyName:this.companyName,
                    companyAdress:this.companyAdress,
                    content_name:this.name,
                    content_phone:this.phone,
                    business_license_pic:this.companyImg
                },
                success: function(res) {
                    if(res.errorno > 0){
                        location.href='/advertiser/index/home';
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




