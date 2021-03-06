<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<link href="https://cdn.bootcss.com/viewerjs/0.10.0/viewer.min.css" rel="stylesheet">

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
            <a data-toggle="collapse" href="#collapseDiv" aria-expanded="false">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        广告主基本信息
                    </h3>
                </div>
            </a>

            <?php if (($advertiser_info['advertiser_type'] === "1")): ?>
                <!--个人广告主基本信息-->
                <div class="box-body collapse" id="collapseDiv">

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>用户ID：</b> KPS<?= $advertiser_info['advertiser_id'] ?><br><br>
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
                                <?= isset($adv_audit_status[$advertiser_info['audit_status']]) ? $adv_audit_status[$advertiser_info['audit_status']] : '' ?>
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
                                <?= isset($adv_account_status[$advertiser_info['status']]) ? $adv_account_status[$advertiser_info['status']] : '' ?>
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
                <div class="box-body collapse" id="collapseDiv">

                    <div class="row">

                        <div class="col-sm-3 invoice-col">
                            <b>用户ID：</b> KPS<?= $advertiser_info['advertiser_id'] ?><br><br>
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
                        <b>任务ID：</b> RW<?= $info['task_id'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务名称：</b> <?= $info['task_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务类型：</b> <?= isset($task_type_list[$info['task_type']]) ? $task_type_list[$info['task_type']] : '' ?>
                        <br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>发布平台：</b> <?= isset($publishing_platform_list[$info['publishing_platform']]) ? $publishing_platform_list[$info['publishing_platform']] : '' ?>
                        <br><br>
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
                        <b>任务时间：</b>
                        <?= date('Y-m-d H:i:s', $info['start_time']) ?>
                        -
                        <?= date('Y-m-d H:i:s', $info['end_time']) ?>
                        <br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务状态：</b>

                        <?php if ((in_array($info['release_status'], ["8", "9"]))): ?>
                            已关闭
                        <?php elseif (($info['audit_status'] === "1") && ($info['release_status'] === "0")): ?>
                            待审核
                        <?php elseif (($info['audit_status'] === "2") && ($info['release_status'] === "0")): ?>
                            驳回
                        <?php elseif (($info['pay_status'] === "0") && ($info['audit_status'] === "3")): ?>
                            待广告主付款
                        <?php elseif (($info['pay_status'] === "1") && ($info['audit_status'] === "3") && ($info['finance_status'] === "0")): ?>
                            待财务确认
                        <?php elseif (($info['pay_status'] === "1") && ($info['audit_status'] === "3") && ($info['finance_status'] === "1")): ?>
                            财务已确认
                        <?php else: ?>
                            未知
                        <?php endif; ?>

                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>审核状态：</b> <?= isset($task_audit_status[$info['audit_status']]) ? $task_audit_status[$info['audit_status']] : '' ?>
                        <br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>期望账号数量：</b> <?= $info['media_man_number'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>系统匹配数量：</b> <?= $info['actual_media_man_number'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>任务链接：</b>
                        <a href="<?= $info['link'] ?>" target="_blank"><?= $info['link'] ?></a>
                        <br><br>
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
                        <b>完成标准：</b> <?= isset($task_completion_criteria[$info['completion_criteria']]) ? $task_completion_criteria[$info['completion_criteria']] : '' ?>
                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>任务描述：</b> <?= $info['task_describe'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <span>任务图片：</span>
                    </div>

                    <div class="col-sm-9">
                        <ul id="task_images">
                            <?php
                            $pic_arr = [];
                            if (!empty($info['pics'])) {
                                $pic_arr = json_decode($info['pics']);
                            }
                            ?>
                            <?php foreach ($pic_arr as $key0 => $pic): ?>
                                <li style="list-style: none;float:left;display:inline;width:150px;">
                                    <img data-original="<?= $pic ?>" src="<?= $pic ?>"
                                         alt="<?= $info['title'] . $key0 ?>"
                                         class="img-thumbnail" width="50px" height="50px"
                                    >
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">操作日志</h3>
            </div>
            <div class="box-body">

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">

                        <el-table :data="table_log_list" height="280" border>
                            <el-table-column property="id" label="序号" width="100"></el-table-column>
                            <el-table-column property="name" label="用户名" width="200"></el-table-column>
                            <el-table-column property="create_time" label="操作时间" width="180"></el-table-column>
                            <el-table-column property="content" label="操作事项"></el-table-column>
                        </el-table>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.box-body -->
        </div>

        <!--审核状态audit_status=1&&release_status=0待审核才进行审核-->
        <?php if (in_array($info['audit_status'], [1]) && in_array($info['release_status'], [0])): ?>

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
                                        <el-radio label="3">通过</el-radio>
                                        <el-radio label="2">不通过</el-radio>
                                    </el-radio-group>
                                </el-form-item>

                                <el-form-item label="拒绝原因" prop="reasons_for_rejection">
                                    <el-input placeholder="请填写拒绝的原因" type="textarea"
                                              v-model="ruleForm.reasons_for_rejection"></el-input>
                                </el-form-item>

                            </el-form>

                        </div>
                        <!-- /.col -->
                    </div>

                </div>
                <!-- /.box-body -->
            </div>

        <?php endif; ?>

        <div class="row">
            <div class="col-xs-12 col-xs-offset-4">
                <?php if (in_array($info['audit_status'], [1]) && in_array($info['release_status'], [0])): ?>
                    <button @click="submitForm('ruleForm')" type="button" class="btn btn-success margin-r-5">提交</button>
                <?php endif; ?>
                <?php
                // 是否显示手工作废按钮
                $is_show_cancellation_btn = (in_array($info['audit_status'], [1, 2])) ||
                    (($info['pay_status'] === "0") && ($info['audit_status'] === "3")) ||
                    (($info['pay_status'] === "1") && ($info['audit_status'] === "3") && ($info['finance_status'] === "0"));
                $is_show_cancellation_btn = (!in_array($info['release_status'], [8])) && $is_show_cancellation_btn;
                ?>
                <?php if ($is_show_cancellation_btn): ?>
                    <button @click="update_task_release_status()" type="button" class="btn btn-danger margin-r-5">
                        手工作废
                    </button>
                <?php endif; ?>
                <button @click="goBack('ruleForm')" type="button" class="btn btn-default margin-r-5"> 返回</button>
            </div>
        </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script src="https://cdn.bootcss.com/viewerjs/0.10.0/viewer.min.js"></script>

<script>

    var Main = {

        data   : function () {
            return {
                loading       : false,// 是否显示加载
                task_id       : '<?= $info['task_id']?>',
                ruleForm      : {
                    audit_status         : '',
                    reasons_for_rejection: ''
                },
                rules         : {
                    audit_status         : [
                        {required: true, message: '请选审核结果', trigger: 'change'}
                    ],
                    reasons_for_rejection: [
                        {required: false, message: '请填写拒绝的原因', trigger: 'blur'}
                    ]
                },
                table_log_list: <?= $log_list ?>,
            };
        },
        methods: {
            submitForm                   : function (formName) {
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

                    this.update_task_audit_status();
                });
            },
            goBack                       : function (formName) {
                window.history.go(-1);
            },
            update_task_audit_status     : async function () {
                try {
                    this.loading = true;
                    var url      = '/admin/platform_task/update_task_audit_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"                   : this.task_id,
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
            update_task_release_status   : function () {

                var message = "确定要将任务作废吗，作废后任务将关闭无法正常流转。";

                this.$confirm(message, '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(async () => {

                    await this.$prompt('请输入手工作废的原因', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText : '取消',
                        inputValidator   : (value) => { return value !== null; },
                        inputErrorMessage: '手工作废原因不能为空'
                    }).then(({value}) => {
                        this.do_update_task_release_status('8', value);
                    }).catch(() => {
                    });

                }).catch(() => {
                });

            },
            do_update_task_release_status: async function (release_status, close_reason) {
                try {

                    this.loading = true;
                    var url      = '/admin/platform_task/update_task_release_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"            : this.task_id,
                            "release_status": release_status,
                            "close_reason"  : close_reason,
                        },
                    );
                    this.loading = false;
                    var resData  = response.data;

                    if (resData.error_no === 0) {
                        this.$message.success('操作成功,即将刷新页面...');
                        return window.location.reload();
                    }

                    return this.$message.error(resData.msg);

                } catch (error) {

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
            }
        }

    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

    new Viewer(document.getElementById('task_images'), {url: 'data-original'});

</script>

</html>
