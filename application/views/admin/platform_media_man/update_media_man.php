<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            自媒体人详情
            <small>修改自媒体人</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-2 invoice-col">
                        <b>用户ID：</b> <?= $info['media_man_id'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>用户名：</b> <?= $info['media_man_login_name'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>注册时间：</b> <?= $info['create_time'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>审核状态：</b>
                        <small class="label
                                            <?= $info['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $info['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $info['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                            <?= $media_audit_status[$info['audit_status']] ?>
                        </small>
                        <br><br>
                    </div>

                    <div class="col-sm-2">
                        <b>账户状态：</b>
                        <small class="label
                                            <?= $info['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $info['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $info['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $info['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                            <?= $media_account_status[$info['status']] ?>
                        </small>

                        <br><br>
                    </div>

                </div>

            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">修改基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-xs-8">

                        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px"
                                 class="demo-ruleForm" size="medium">

                            <el-form-item label="姓名" prop="media_man_name">
                                <el-input v-model="ruleForm.media_man_name"></el-input>
                            </el-form-item>

                            <el-form-item label="性别" prop="sex">
                                <el-radio-group v-model="ruleForm.sex">
                                    <el-radio label="1">男</el-radio>
                                    <el-radio label="2">女</el-radio>
                                </el-radio-group>
                            </el-form-item>

                            <el-form-item label="电话" prop="media_man_phone">
                                <el-input v-model="ruleForm.media_man_phone"></el-input>
                            </el-form-item>

                            <el-form-item label="学校名称" prop="school_name">
                                <el-input v-model="ruleForm.school_name"></el-input>
                            </el-form-item>

                            <el-form-item label="学校类型" prop="school_type">
                                <el-select v-model="ruleForm.school_type" placeholder="请选择学校类型">
                                    <el-option
                                            v-for="(item, key) in school_type_list"
                                            :label="item"
                                            :value="key">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="学校地区" prop="school_province">
                                <el-select v-model="ruleForm.school_province" placeholder="请选择学校所在省">
                                    <el-option label="公立学校" value="1"></el-option>
                                    <el-option label="私立学校" value="2"></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item prop="school_city">
                                <el-select v-model="ruleForm.school_city" placeholder="请选择学校所在市">
                                    <el-option label="公立学校" value="1"></el-option>
                                    <el-option label="私立学校" value="2"></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item prop="school_area">
                                <el-select v-model="ruleForm.school_area" placeholder="请选择学校所在区">
                                    <el-option label="公立学校" value="1"></el-option>
                                    <el-option label="私立学校" value="2"></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="办学层次" prop="school_level">
                                <el-select v-model="ruleForm.school_level" placeholder="请选择办学层次">
                                    <el-option
                                            v-for="(item, key) in school_level_list"
                                            :label="item"
                                            :value="key">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="支付宝账号" prop="zfb_nu">
                                <el-input v-model="ruleForm.zfb_nu"></el-input>
                            </el-form-item>

                            <el-form-item label="真实姓名" prop="zfb_realname">
                                <el-input v-model="ruleForm.zfb_realname"></el-input>
                            </el-form-item>

                            <el-form-item label="年龄" prop="age">
                                <el-radio-group v-model="ruleForm.age">
                                    <el-radio v-for="(item, key) in age_list" :label="key">
                                        {{ item }}
                                    </el-radio>
                                </el-radio-group>
                            </el-form-item>

                            <el-form-item label="兴趣爱好" prop="hobby">
                                <el-checkbox-group v-model="ruleForm.hobby">
                                    <el-checkbox v-for="(item, key) in hobby_list" :label="key">
                                        {{item}}
                                    </el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item label="行业" prop="industry">
                                <el-checkbox-group v-model="ruleForm.industry">
                                    <el-checkbox v-for="(item, key) in industry_list" :label="key">
                                        {{item}}
                                    </el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item label="微信号" prop="wx_code">
                                <el-input v-model="ruleForm.wx_code"></el-input>
                            </el-form-item>

                            <el-form-item label="微信账号类型" prop="wx_type">
                                <el-select v-model="ruleForm.wx_type" placeholder="请选择微信账号类型">
                                    <el-option
                                            v-for="(item, key) in wx_type_list"
                                            :label="item"
                                            :value="key">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="最高粉丝量" prop="wx_max_fans" :span="12">
                                <el-input v-model="ruleForm.wx_max_fans"></el-input>
                            </el-form-item>

                            <el-form-item label="微博昵称" prop="weibo_nickname">
                                <el-input v-model="ruleForm.weibo_nickname"></el-input>
                            </el-form-item>

                            <el-form-item label="微博账号类型" prop="weibo_type">
                                <el-select v-model="ruleForm.weibo_type" placeholder="请选择微博账号类型">
                                    <el-option
                                            v-for="(item, key) in weibo_type_list"
                                            :label="item"
                                            :value="key">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="最高粉丝量" prop="weibo_max_fans">
                                <el-input v-model="ruleForm.weibo_max_fans"></el-input>
                            </el-form-item>

                            <el-form-item label="微博链接" prop="weibo_link">
                                <el-input v-model="ruleForm.weibo_link"></el-input>
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                                <el-button @click="goBack('ruleForm')">返回</el-button>
                            </el-form-item>

                        </el-form>

                    </div>
                    <!-- /.col -->
                </div>

            </div>
            <!-- /.box-body -->
        </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script>

    var Main = {
        data   : function () {
            return {
                loading          : false,// 是否显示加载
                media_man_id     : '<?= $info['media_man_id']?>',
                school_type_list : JSON.parse('<?= json_encode($school_type_list) ?>'),
                school_level_list: JSON.parse('<?= json_encode($school_level_list) ?>'),
                age_list         : JSON.parse('<?= json_encode($age_list) ?>'),
                hobby_list       : JSON.parse('<?= json_encode($hobby_list) ?>'),
                industry_list    : JSON.parse('<?= json_encode($industry_list) ?>'),
                wx_type_list     : JSON.parse('<?= json_encode($wx_type_list) ?>'),
                weibo_type_list  : JSON.parse('<?= json_encode($weibo_type_list) ?>'),
                ruleForm         : {
                    media_man_name : '<?= $info['media_man_name']?>',
                    sex            : '<?= $info['sex']?>',
                    media_man_phone: '<?= $info['media_man_phone']?>',
                    school_name    : '<?= $info['school_name']?>',
                    school_type    : '<?= $info['school_type']?>',
                    school_province: '<?= $info['school_province']?>',
                    school_city    : '<?= $info['school_city']?>',
                    school_area    : '<?= $info['school_area']?>',
                    school_level   : '<?= $info['school_level']?>',
                    zfb_nu         : '<?= $info['zfb_nu']?>',
                    zfb_realname   : '<?= $info['zfb_realname']?>',
                    age            : '<?= $info['age']?>',
                    hobby          : JSON.parse('<?= json_encode(explode(',', $info['hobby'])) ?>'),
                    industry       : JSON.parse('<?= json_encode(explode(',', $info['industry'])) ?>'),
                    wx_code        : '<?= $info['wx_code']?>',
                    wx_type        : '<?= $info['wx_type']?>',
                    wx_max_fans    : '<?= $info['wx_max_fans']?>',
                    weibo_nickname : '<?= $info['weibo_nickname']?>',
                    weibo_type     : '<?= $info['weibo_type']?>',
                    weibo_max_fans : '<?= $info['weibo_max_fans']?>',
                    weibo_link     : '<?= $info['weibo_link']?>',
                },
                rules            : {
                    audit_status         : [
                        {required: true, message: '请选审核结果', trigger: 'change'}
                    ],
                    reasons_for_rejection: [
                        {required: false, message: '请填写拒绝的原因', trigger: 'blur'}
                    ]
                }
            };
        },
        methods: {
            submitForm : function (formName) {
                this.$refs[formName].validate((valid) => {

                    if (!valid) {
                        this.$message.error('请选审核结果');
                        return false;
                    }

                    if (this.ruleForm.audit_status === "2") {
                        if (this.ruleForm.reasons_for_rejection === "") {
                            this.$message.error('请填写拒绝的原因');
                            return false;
                        }
                    }

                    this.media_audit();
                });
            },
            goBack     : function (formName) {
                window.location.href = '/admin/platform_media_man/home';
            },
            media_audit: async function () {
                try {
                    this.loading = true;
                    var url      = '/admin/platform_media_man/update_media_audit_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"                   : this.media_man_id,
                            "audit_status"         : this.ruleForm.audit_status,
                            "reasons_for_rejection": this.ruleForm.reasons_for_rejection,
                        },
                    );
                    this.loading = false;
                    var resData  = response.data;

                    if (resData.error_no === 0) {
                        this.$message.success('操作成功,即将刷新页面...');
                        return window.location.reload();
                    }

                    return this.$message.error(resData.msg);
                }
                catch (error) {

                    this.loading = false;

                    if (error instanceof Error) {

                        if (error.response) {
                            return this.$message.error(error.response.data.responseText);
                        }

                        if (error.request) {
                            console.error(error.request);
                            return this.$message.error('服务器未响应');
                        }

                        console.error(error);

                    }

                }
            },
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app')

</script>

</html>
