<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            任务管理
            <small>任务审核详情页</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">广告主基本信息</h3>
            </div>

            <?php if (($advertiser_info['advertiser_type'] === "1")): ?>
                <!--个人广告主基本信息-->
                <div class="box-body">

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>用户ID：</b> <?= $advertiser_info['advertiser_id'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>用户名：</b> <?= $advertiser_info['advertiser_login_name'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>姓名：</b> <?= $advertiser_info['advertiser_name'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>身份证号：</b> <?= $advertiser_info['id_card'] ?><br><br>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>手机号码：</b> <?= $advertiser_info['advertiser_phone'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>注册时间：</b> <?= $advertiser_info['create_time'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>审核状态：</b>
                            <small class="label
                                            <?= $advertiser_info['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $advertiser_info['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $advertiser_info['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                                <?= $adv_audit_status[$advertiser_info['audit_status']] ?>
                            </small>
                            <br><br>
                        </div>

                        <div class="col-sm-3">
                            <b>账户状态：</b>
                            <small class="label
                                            <?= $advertiser_info['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $advertiser_info['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $advertiser_info['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $advertiser_info['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                                <?= $adv_account_status[$advertiser_info['status']] ?>
                            </small>
                            <br><br>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-3">
                            <b>身份证正面：</b>
                            <a href="<?= $advertiser_info['id_card_positive_pic'] ?>" target="_blank">
                                <img src="<?= $advertiser_info['id_card_positive_pic'] ?>"
                                     alt="<?= $advertiser_info['advertiser_name'] ?>"
                                     class="img-thumbnail">
                            </a>
                            <br><br>
                        </div>

                        <div class="col-sm-3">
                            <b>身份证反面：</b>
                            <a href="<?= $advertiser_info['id_card_back_pic'] ?>" target="_blank">
                                <img src="<?= $advertiser_info['id_card_back_pic'] ?>"
                                     alt="<?= $advertiser_info['advertiser_name'] ?>"
                                     class="img-thumbnail">
                            </a>
                            <br><br>
                        </div>

                        <div class="col-sm-3">
                            <b>身份证手持：</b>
                            <a href="<?= $advertiser_info['handheld_id_card_pic'] ?>" target="_blank">
                                <img src="<?= $advertiser_info['handheld_id_card_pic'] ?>"
                                     alt="<?= $advertiser_info['advertiser_name'] ?>"
                                     class="img-thumbnail">
                            </a>
                            <br><br>
                        </div>

                    </div>

                </div>
                <!--个人广告主基本信息-->
            <?php endif; ?>

            <?php if (($advertiser_info['advertiser_type'] === "2")): ?>
                <!--公司广告主基本信息-->
                <div class="box-body">

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>用户ID：</b> <?= $advertiser_info['advertiser_id'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>用户名：</b> <?= $advertiser_info['advertiser_login_name'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>公司名称：</b> <?= $advertiser_info['company_name'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>公司地址：</b> <?= $advertiser_info['company_address'] ?><br><br>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>联系人姓名：</b> <?= $advertiser_info['content_name'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>联系人电话：</b> <?= $advertiser_info['content_phone'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>注册时间：</b> <?= $advertiser_info['create_time'] ?><br><br>
                        </div>

                        <div class="col-sm-3 invoice-col">
                            <b>审核状态：</b>
                            <small class="label
                                            <?= $advertiser_info['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $advertiser_info['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $advertiser_info['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                                <?= $adv_audit_status[$advertiser_info['audit_status']] ?>
                            </small>
                            <br><br>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <b>账户状态：</b>
                            <small class="label
                                            <?= $advertiser_info['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $advertiser_info['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $advertiser_info['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $advertiser_info['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                                <?= $adv_account_status[$advertiser_info['status']] ?>
                            </small>
                            <br><br>
                        </div>
                        <div class="col-sm-3">
                            <b>营业执照：</b>
                            <a href="<?= $advertiser_info['business_license_pic'] ?>" target="_blank">
                                <img src="<?= $advertiser_info['business_license_pic'] ?>"
                                     alt="<?= $advertiser_info['company_name'] ?>"
                                     class="img-thumbnail">
                            </a>
                            <br><br>
                        </div>
                    </div>

                </div>
                <!--公司广告主基本信息-->
            <?php endif; ?>

        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">任务基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务ID：</b> <?= $info['task_id'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务名称：</b> <?= $info['task_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务类型：</b> <?= $info['task_type'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>发布平台：</b> <?= $info['publishing_platform'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务标题：</b> <?= $info['title'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>提交时间：</b> <?= $info['submit_audit_time'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务时间：</b> <?= $info['start_time'] ?> - <?= $info['end_time'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务状态：</b>
                        任务状态
                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>审核状态：</b> <?= $info['audit_status'] ?> <br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>期望账号数量：</b> <?= $info['media_man_number'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>系统匹配数量：</b> <?= $info['actual_media_man_number'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务链接：</b> <?= $info['link'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务单价：</b> <?= $info['price'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>账号要求：</b> <?= $info['media_man_require'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务总价：</b> <?= $info['total_price'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>完成标准：</b> <?= $info['completion_criteria'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务描述：</b> <?= $info['task_describe'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务图片：</b> <?= $info['pics'] ?><br><br>
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

                            <?php foreach ($log_list as $value): ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['sys_user_name'] ?></td>
                                    <td><?= $value['create_time'] ?></td>
                                    <td><?= $value['sys_log_content'] ?></td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

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
            adv_audit : async function () {
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
