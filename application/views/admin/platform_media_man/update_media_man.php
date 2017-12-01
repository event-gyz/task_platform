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
                <h3 class="box-title">第三方帐号信息</h3>
            </div>
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>微信号：</b> <?= $info['wx_code'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>账号类型：</b> <?= $info['wx_type'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>最高粉丝量：</b> <?= $info['wx_max_fans'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>微博昵称：</b> <?= $info['weibo_nickname'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>账号类型：</b> <?= $info['weibo_type'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>最高粉丝量：</b> <?= $info['weibo_max_fans'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>微博链接：</b> <?= $info['weibo_link'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>支付宝账号：</b> <?= $info['zfb_nu'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>真实姓名：</b> <?= $info['zfb_realname'] ?><br><br>
                    </div>

                </div>

            </div>
            <!-- /.box-body -->
        </div>

        <!--帐号状态status=1待审核,审核状态audit_status=0待审核或者审核状态audit_status=2驳回时才进行审核-->
        <?php if (($info['status'] === "1") && in_array($info['audit_status'], [0, 2])): ?>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">审核操作</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">

                            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">

                                <el-form-item label="审核结果" prop="audit_status">
                                    <el-radio-group v-model="ruleForm.audit_status">
                                        <el-radio label="1">通过</el-radio>
                                        <el-radio label="2">不通过</el-radio>
                                    </el-radio-group>
                                </el-form-item>

                                <el-form-item label="拒绝原因" prop="reasons_for_rejection">
                                    <el-input placeholder="请填写拒绝的原因" type="textarea"
                                              v-model="ruleForm.reasons_for_rejection"></el-input>
                                </el-form-item>

                                <el-form-item>
                                    <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
                                    <el-button @click="goBack('ruleForm')">返回</el-button>
                                </el-form-item>

                            </el-form>

                        </div>
                        <!-- /.col -->
                    </div>

                </div>
                <!-- /.box-body -->
            </div>

        <?php endif; ?>

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
                loading     : false,// 是否显示加载
                media_man_id: <?= $info['media_man_id']?>,
                ruleForm    : {
                    audit_status         : '',
                    reasons_for_rejection: ''
                },
                rules       : {
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
