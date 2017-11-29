<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<link href="https://cdn.bootcss.com/element-ui/2.0.5/theme-chalk/index.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="app" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            公司广告主
            <small>公司广告主审核详情页</small>
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

                    <div class="col-sm-3 invoice-col">
                        <b>用户ID：</b> <?= $info['advertiser_id'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>用户名：</b> <?= $info['advertiser_login_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>公司名称：</b> <?= $info['company_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>公司地址：</b> <?= $info['company_address'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>联系人姓名：</b> <?= $info['content_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>联系人电话：</b> <?= $info['content_phone'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>注册时间：</b> <?= $info['create_time'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>审核状态：</b> <?= $info['audit_status'] ?><br><br>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <b>账户状态：</b> <?= $info['status'] ?><br><br>
                    </div>
                    <div class="col-sm-3">
                        <b>营业执照：</b>
                        <a href="<?= $info['business_license_pic'] ?>" target="_blank">
                            <img src="<?= $info['business_license_pic'] ?>"
                                 alt="<?= $info['company_name'] ?>"
                                 class="img-thumbnail">
                        </a>
                        <br><br>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">操作日志</h3>
            </div>
            <div class="box-body">

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>用户名</th>
                                <th>操作时间</th>
                                <th>操作事项</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Call of Duty</td>
                                <td>455-981-221</td>
                                <td>El snort testosterone trophy driving gloves handsome</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Need for Speed IV</td>
                                <td>247-925-726</td>
                                <td>Wes Anderson umami biodiesel</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.box-body -->
        </div>

        <?php if (in_array($info['audit_status'], [0, 2])): ?>

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

<script src="https://cdn.bootcss.com/vue/2.5.8/vue.min.js"></script>
<script src="https://cdn.bootcss.com/element-ui/2.0.5/index.js"></script>
<script src="https://cdn.bootcss.com/axios/0.17.1/axios.min.js"></script>

<script>

    var Main = {
        data   : function () {
            return {
                loading      : false,// 是否显示加载
                advertiser_id: <?= $info['advertiser_id']?>,
                ruleForm     : {
                    audit_status         : '',
                    reasons_for_rejection: ''
                },
                rules        : {
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
            submitForm: function (formName) {
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

                    this.adv_audit();
                });
            },
            goBack    : function (formName) {
                window.location.href = '/admin/platform_advertiser/company_adv_home';
            },
            async adv_audit() {
                try {
                    this.loading = true;
                    var url      = '/admin/platform_advertiser/update_adv_audit_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"                   : this.advertiser_id,
                            "audit_status"         : this.ruleForm.audit_status,
                            "reasons_for_rejection": this.ruleForm.reasons_for_rejection,
                        },
                    );
                    this.loading = false;
                    var resData  = response.data;

                    if (resData.error_no === 0) {
                        this.$message.success('审核成功,即将刷新页面...');
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
