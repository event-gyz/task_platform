<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<link href="https://cdn.bootcss.com/viewerjs/0.10.0/viewer.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            任务发布管理
            <small>任务详情页</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

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
                        <b>任务类型：</b> <?= $task_type_list[$info['task_type']] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>发布平台：</b> <?= $publishing_platform_list[$info['publishing_platform']] ?><br><br>
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

                        <?php if (($info['release_status'] === "0")): ?>
                            <small class="label bg-yellow">
                                待发布
                            </small>
                        <?php elseif (($info['release_status'] === "1") && ($info['end_time'] > time())): ?>
                            <small class="label bg-green">
                                执行中
                            </small>
                        <?php elseif (($info['release_status'] === "1") && ($info['end_time'] <= time())): ?>
                            <small class="label bg-orange">
                                待确认完成
                            </small>
                        <?php else: ?>
                            <small class="label bg-gray">
                                未知
                            </small>
                        <?php endif; ?>

                        <br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>审核状态：</b> <?= $task_audit_status[$info['audit_status']] ?> <br><br>
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
                        <b>完成标准：</b> <?= $task_completion_criteria[$info['completion_criteria']] ?><br><br>
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
                                         class="img-thumbnail"
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
                                    <td><?= $value['sys_user_name'] ? $value['sys_user_name'] : $value['user_name'] ?></td>
                                    <td><?= $value['create_time'] ?></td>
                                    <td><?= $value['sys_log_content'] ? $value['sys_log_content'] : $value['user_log_content'] ?></td>
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

        <!--release_status=0显示发布表单-->
        <?php if (in_array($info['release_status'], [0])): ?>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">发布操作</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">

                            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">

                                <el-form-item label="发布任务" prop="platform_price">
                                    <el-input v-model="ruleForm.platform_price" placeholder="请输入任务单价"></el-input>
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

                <?php

                // 是否显示发布按钮
                $is_show_release_btn = in_array($info['release_status'], [0]);

                // 是否显示手工作废按钮
                $is_show_cancellation_btn = (($info['release_status'] === "0")) ||
                    (($info['release_status'] === "1") && ($info['end_time'] > time()));

                // 是否显示确认完成按钮
                $is_show_confirm_btn = ($info['release_status'] === "1") && ($info['end_time'] <= time());

                ?>

                <?php if ($is_show_release_btn): ?>
                    <button @click="submitForm('ruleForm')" type="button" class="btn btn-success margin-r-5">发布</button>
                <?php endif; ?>

                <?php if ($is_show_cancellation_btn): ?>
                    <button @click="update_task_release_status()" type="button" class="btn btn-warning margin-r-5">
                        手工作废
                    </button>
                <?php endif; ?>

                <?php if ($is_show_confirm_btn): ?>
                    <button @click="confirm_finish()" type="button" class="btn btn-primary margin-r-5">
                        确认完成
                    </button>
                <?php endif; ?>

                <button @click="goBack('ruleForm')" type="button" class="btn btn-default margin-r-5">返回</button>
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
                loading : false,// 是否显示加载
                task_id : '<?= $info['task_id']?>',
                ruleForm: {
                    platform_price: '',
                },
                rules   : {
                    platform_price: [
                        {required: true, message: '请填写有效的任务单价', trigger: 'blur'}
                    ],
                }
            };
        },
        methods: {
            submitForm                   : function (formName) {
                this.$refs[formName].validate((valid) => {

                    if (!valid) {
                        this.$message.error('请填写有效的任务单价');
                        return false;
                    }

                    if (this.ruleForm.platform_price <= 0) {
                        this.$message.error('任务单价只能是正数,仅支持小数点后一位');
                        return false;
                    }

                    this.release_task();
                });
            },
            goBack                       : function (formName) {
                window.location.href = '/admin/release_task/home';
            },
            release_task                 : async function () {
                try {
                    this.loading = true;
                    var url      = '/admin/release_task/release_task';
                    var response = await axios.post(
                        url,
                        {
                            "id"            : this.task_id,
                            "platform_price": this.ruleForm.platform_price,
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

                    var close_reason = "";
                    await this.$prompt('请输入手工作废的原因', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText : '取消',
                        inputValidator   : (value) => { return value !== null; },
                        inputErrorMessage: '手工作废原因不能为空'
                    }).then(({value}) => {
                        close_reason = value;
                    }).catch(() => {
                    });

                    await this.do_update_task_release_status('8', close_reason);

                }).catch(() => {
                });

            },
            do_update_task_release_status: async function (release_status, close_reason) {
                try {

                    this.loading = true;
                    var url      = '/admin/release_task/update_task_release_status';
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
            },
            confirm_finish               : async function () {
                try {
                    this.loading = true;
                    var url      = '/admin/release_task/confirm_finish';
                    var response = await axios.post(
                        url,
                        {
                            "id": this.task_id,
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
    new Ctor().$mount('#app');

    new Viewer(document.getElementById('task_images'), {url: 'data-original'});

</script>

</html>
