<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            自媒体人
            <small>自媒体人审核详情页</small>
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
                        <b>用户ID：</b> <?= $info['media_man_id'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>用户名：</b> <?= $info['media_man_login_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>姓名：</b> <?= $info['media_man_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>性别：</b> <?= $info['sex'] === "1" ? "男" : "女" ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>电话：</b> <?= $info['media_man_phone'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>学校名称：</b> <?= $info['school_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>学校类型：</b> <?= $school_type_list[$info['school_type']] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>学校地址：</b>
                        <?= $info['school_province'] ?>
                        <?= $info['school_city'] ?>
                        <?= $info['school_area'] ?>
                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>办学层次：</b> <?= $school_level_list[$info['school_level']] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>年龄：</b> <?= $age_list[$info['age']] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>行业：</b> <?= $industry_list[$info['industry']] ?> <br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>兴趣爱好：</b>
                        <?php if (!empty($info['hobby'])): ?>
                            <?php foreach (explode(',', $info['hobby']) as $value): ?>
                                <?= $hobby_list[$value] ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>注册时间：</b> <?= $info['create_time'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
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

                    <div class="col-sm-3">
                        <b>账户状态：</b>
                        <small class="label
                                            <?= $info['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $info['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $info['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $info['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                            <?= $media_account_status[$info['status']] ?>
                        </small>

                        <?php if ($info['status'] === "9"): ?>
                            <button @click="update_media_account_status('2','<?= $info['media_man_id'] ?>')"
                                    class="btn btn-success btn-sm" style="margin-left: 10px;">
                                解冻
                            </button>
                        <?php endif; ?>

                        <?php if ($info['status'] === "2"): ?>
                            <button @click="update_media_account_status('9','<?= $info['media_man_id'] ?>')"
                                    class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                冻结
                            </button>
                        <?php endif; ?>

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
                        <b>账号类型：</b> <?= $wx_type_list[$info['wx_type']] ?><br><br>
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
                        <b>账号类型：</b> <?= $weibo_type_list[$info['weibo_type']] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>最高粉丝量：</b> <?= $info['weibo_max_fans'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>微博链接：</b> <a target="_blank" href="<?= $info['weibo_link'] ?>"><?= $info['weibo_link'] ?></a><br><br>
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

        <!--帐号状态status=1待审核,审核状态audit_status=0待审核时才进行审核-->
        <?php if (($info['status'] === "1") && ($info['audit_status'] === "0")): ?>

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
                <?php if (($info['status'] === "1") && ($info['audit_status'] === "0")): ?>
                    <button @click="submitForm('ruleForm')" type="button" class="btn btn-success margin-r-5">提交</button>
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
            submitForm                    : function (formName) {
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
            goBack                        : function (formName) {
                window.location.href = '/admin/platform_media_man/home';
            },
            media_audit                   : async function () {
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
            update_media_account_status   : async function (account_status, media_man_id) {

                var message = (account_status === "2") ? "确定要将此用户解冻吗，解冻后可正常登陆使用。" : "确定要将此用户冻结吗，冻结后无法正常登陆。";

                this.$confirm(message, '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(async () => {

                    var freezing_reason = "";

                    if (account_status === "9") {

                        await this.$prompt('请输入冻结的原因', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText : '取消',
                            inputValidator   : (value) => { return value !== null; },
                            inputErrorMessage: '冻结原因不能为空'
                        }).then(({value}) => {
                            freezing_reason = value;
                        }).catch(() => {
                        });

                    }

                    await this.do_update_media_account_status(account_status, media_man_id, freezing_reason);

                }).catch(() => {
                });

            },
            do_update_media_account_status: async function (account_status, media_man_id, freezing_reason) {
                try {

                    this.loading = true;
                    var url      = '/admin/platform_media_man/update_media_account_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"             : media_man_id,
                            "account_status" : account_status,
                            "freezing_reason": freezing_reason,
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
    new Ctor().$mount('#app')

</script>

</html>
