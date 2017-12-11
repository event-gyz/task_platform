<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            广告主付款列表
            <small>管理广告主的付款信息</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">

            <div class="col-xs-12">

                <div class="box box-success">

                    <div class="box-body">

                        <div class="row">

                            <!-- form start -->
                            <form class="form-horizontal">

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="advertiser_login_name" class="col-sm-4 control-label">用户名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入用户名来搜索..." name="advertiser_login_name"
                                                   value="<?= $form_data['advertiser_login_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="u_name_or_c_name" class="col-sm-4 control-label">姓名/公司名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入姓名/公司名来搜索..." name="u_name_or_c_name"
                                                   value="<?= $form_data['u_name_or_c_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="u_phone_or_c_phone" class="col-sm-4 control-label">电话</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入电话来搜索..." name="u_phone_or_c_phone"
                                                   value="<?= $form_data['u_phone_or_c_phone'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="adv_finance_status" class="col-sm-4 control-label">财务状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="adv_finance_status">
                                                <option value="">全部</option>

                                                <?php foreach ($finance_status_list as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['adv_finance_status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-4">
                                        <label for="sex" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-info">搜索</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="box">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>任务ID</th>
                                <th>任务名称</th>
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>姓名/公司名称</th>
                                <th>电话</th>
                                <th>任务总金额</th>
                                <th>付款总金额</th>
                                <th>付款方式</th>
                                <th>付款时间</th>
                                <th>财务状态</th>
                                <th>最后操作人</th>
                                <th>财务确认时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th><?= $value['task_id'] ?></th>
                                    <th><?= $value['task_name'] ?></th>
                                    <th><?= $value['advertiser_id'] ?></th>
                                    <th><?= $value['advertiser_login_name'] ?></th>
                                    <th>

                                        <?php if (($value['advertiser_type'] === "1")): ?>
                                            <?= empty($value['advertiser_name']) ? '' : $value['advertiser_name'] ?>
                                        <?php endif; ?>

                                        <?php if (($value['advertiser_type'] === "2")): ?>
                                            <?= empty($value['company_name']) ? '' : $value['company_name'] ?>
                                        <?php endif; ?>

                                    </th>
                                    <th>

                                        <?php if (($value['advertiser_type'] === "1")): ?>
                                            <?= empty($value['advertiser_phone']) ? '' : $value['advertiser_phone'] ?>
                                        <?php endif; ?>

                                        <?php if (($value['advertiser_type'] === "2")): ?>
                                            <?= empty($value['content_phone']) ? '' : $value['content_phone'] ?>
                                        <?php endif; ?>

                                    </th>
                                    <th><?= $value['total_price'] ?></th>
                                    <th><?= $value['pay_money'] ?></th>
                                    <th><?= $platform_pay_way_list[$value['pay_way']] ?></th>
                                    <th><?= $value['pay_time'] ?></th>
                                    <th>

                                        <?php if (($value['finance_status'] === "0")): ?>
                                            <small class="label bg-yellow">
                                                待财务确认
                                            </small>
                                        <?php elseif (($value['finance_status'] === "1")): ?>
                                            <small class="label bg-green">
                                                已支付
                                            </small>
                                        <?php else: ?>
                                            <small class="label bg-gray">
                                                未知
                                            </small>
                                        <?php endif; ?>

                                    </th>
                                    <th><?= $value['confirming_person'] ?></th>
                                    <th><?= $value['confirm_time'] ?></th>
                                    <th>
                                        <?php

                                        // 是否确认收款按钮
                                        $is_show_confirm_btn = ($value['finance_status'] === "0");

                                        // 是否显示查看凭证按钮
                                        $is_show_view_btn = ($value['finance_status'] === "1");

                                        ?>

                                        <?php if ($is_show_confirm_btn): ?>
                                            <button @click="show_confirm_receive_money_dialog('<?= $value['task_id'] ?>')"
                                                    type="button"
                                                    class="btn btn-primary btn-xs margin-r-5">确认收款
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($is_show_view_btn): ?>
                                            <button @click="" type="button"
                                                    class="btn btn-success btn-xs margin-r-5">查看凭证
                                            </button>
                                        <?php endif; ?>

                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <!-- /.box-body -->

                    <?= $page_link ?>

                </div>
                <!-- /.box -->

            </div>

        </div>

        <el-dialog title="上传支付凭证" :visible.sync="dialogTableVisible" center>

            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">

                <el-form-item label="上传凭证"
                              v-loading="upload_loading"
                              element-loading-text="正在上传,请稍候..."
                              element-loading-spinner="el-icon-loading"
                              element-loading-background="rgba(0, 0, 0, 0.8)"
                >

                    <el-col :span="12">

                        <el-upload
                                ref="upload"
                                :data="upload_params"
                                :action="uploadUrl"
                                :multiple="true"
                                :file-list="ruleForm.fileList"
                                :auto-upload="false"
                                :on-change="handleChange"
                        >
                            <el-button slot="trigger" size="mini" type="primary">选取文件</el-button>
                            <el-button size="mini" type="success" @click="submitUpload">上传到服务器</el-button>
                            <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                        </el-upload>

                    </el-col>

                </el-form-item>

                <el-form-item label="确认金额" prop="pay_money">
                    <el-col :span="8">
                        <el-input v-model="ruleForm.pay_money"></el-input>
                    </el-col>
                </el-form-item>


                <el-form-item label="备注" prop="confirm_remark">
                    <el-col :span="8">
                        <el-input type="textarea" v-model="ruleForm.confirm_remark"></el-input>
                    </el-col>
                </el-form-item>

            </el-form>

            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitForm('ruleForm')">确 认</el-button>
                <el-button type="info" @click="dialogTableVisible = false">关 闭</el-button>
            </div>
        </el-dialog>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script>

    const localComputed = {};
    const localMethods  = {
        show_confirm_receive_money_dialog: function (task_id) {
            this.upload_params.task_id = task_id;
            this.dialogTableVisible    = true;
        },
        submitForm                       : function (formName) {
            this.$refs[formName].validate((valid) => {

                if (!valid) {
                    return false;
                }

            });
        },
        submitUpload                     : function () {
            this.upload_loading = true;
            this.$refs.upload.submit();
        },
        handleChange                     : function (file) {
            this.upload_loading = false;

            let response = file.response;
            if (response !== undefined) {

                if (response.error_no === 1) {
                    return this.$message.error(response.msg);
                }

                if (response.error_no === 0) {
                    return this.$message.success(response.msg);
                }

            }

        },
    };
    const data          = function () {
        return {
            loading           : false,// 是否显示加载
            upload_loading    : false,// 上传的加载框
            dialogTableVisible: true,// 是否显示dialog
            uploadUrl         : '/admin/login/upload_file',// 上传服务器地址
            upload_params     : {'task_id': 0},// 上传时附带的额外参数
            ruleForm          : {
                pay_money     : '',
                confirm_remark: '',
                fileList      : [],
            },
            rules             : {
                pay_money     : [
                    {required: true, message: '确认金额', trigger: 'blur'}
                ],
                confirm_remark: [
                    {required: false, message: '请填写备注', trigger: 'blur'}
                ]
            },
        };
    };

    const Main = {
        data    : data,
        created : function () {},
        methods : localMethods,
        computed: localComputed,
    };
    const Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

</script>

</html>
