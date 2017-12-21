<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            公司广告主审核列表
            <small>管理公司广告主的审核</small>
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
                                        <label for="company_name" class="col-sm-4 control-label">公司名称</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入公司名称来搜索..." name="company_name"
                                                   value="<?= $form_data['company_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="content_name" class="col-sm-4 control-label">联系人姓名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入联系人姓名来搜索..." name="content_name"
                                                   value="<?= $form_data['content_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="audit_status" class="col-sm-4 control-label">审核状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="audit_status">
                                                <option value="">全部</option>

                                                <?php foreach ($adv_audit_status as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['audit_status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label class="col-sm-4 control-label">注册时间</label>
                                        <div class="col-sm-7 input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="create_time"
                                                   class="form-control"
                                                   id="reservation"
                                                   value="<?= $form_data['create_time'] ?>"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="content_phone" class="col-sm-4 control-label">联系人电话</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入联系人电话来搜索..." name="content_phone"
                                                   value="<?= $form_data['content_phone'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="status" class="col-sm-4 control-label">账号状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status">
                                                <option value="">全部</option>

                                                <?php foreach ($adv_account_status as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="advertiser_id" class="col-sm-4 control-label">用户ID</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入用户ID来搜索..." name="advertiser_id"
                                                   value="<?= $form_data['advertiser_id'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="sex" class="col-sm-4 control-label"></label>
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

                <div class="box" v-loading.body="loading" element-loading-text="拼命加载中" id="table">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>公司名称</th>
                                <th>公司地址</th>
                                <th>联系人姓名</th>
                                <th>联系人电话</th>
                                <th>审核状态</th>
                                <th>注册时间</th>
                                <th>帐号状态</th>
                                <th>最后操作人</th>
                                <th>最后操作时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th>
                                        <a href="/admin/platform_advertiser/company_adv_detail?id=<?= $value['advertiser_id'] ?>">
                                            KPS<?= $value['advertiser_id'] ?>
                                        </a>
                                    </th>
                                    <th><?= $value['advertiser_login_name'] ?></th>
                                    <th><?= $value['company_name'] ?></th>
                                    <th><?= $value['company_address'] ?></th>
                                    <th><?= $value['content_name'] ?></th>
                                    <th><?= $value['content_phone'] ?></th>
                                    <th>
                                        <small class="label
                                            <?= $value['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $value['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $value['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                                            <?= isset($adv_audit_status[$value['audit_status']]) ? $adv_audit_status[$value['audit_status']] : '' ?>
                                        </small>
                                    </th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th>
                                        <small class="label
                                            <?= $value['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $value['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $value['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                                            <?= isset($adv_account_status[$value['status']]) ? $adv_account_status[$value['status']] : '' ?>
                                        </small>
                                    </th>
                                    <th><?= $value['last_operator_name'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th>

                                        <?php

                                        // 是否显示审核按钮
                                        $is_show_audit_btn = ($value['status'] === "1") && ($value['audit_status'] === "0");

                                        // 是否显示冻结按钮
                                        $is_show_disable_btn = ($value['status'] === "2") && ($value['audit_status'] === "1");

                                        // 是否显示解冻按钮
                                        $is_show_active_btn = ($value['status'] === "9") && ($value['audit_status'] === "1");

                                        ?>

                                        <?php if ($is_show_audit_btn): ?>
                                            <a href="/admin/platform_advertiser/company_adv_detail?id=<?= $value['advertiser_id'] ?>"
                                               class="btn btn-success btn-sm">
                                                审核
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($is_show_disable_btn): ?>
                                            <button @click="update_adv_account_status('9','<?= $value['advertiser_id'] ?>')"
                                                    class="btn btn-danger btn-sm">
                                                冻结
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($is_show_active_btn): ?>
                                            <button @click="update_adv_account_status('2','<?= $value['advertiser_id'] ?>')"
                                                    class="btn btn-success btn-sm">
                                                解冻
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

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>

<script>

    $('#reservation').daterangepicker({
        autoUpdateInput: false,
        locale         : {
            applyLabel : '确定',
            cancelLabel: '取消',
            daysOfWeek : ['日', '一', '二', '三', '四', '五', '六'],
            monthNames : ['一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月'],
        }
    });

    $('#reservation').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('#reservation').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    const localComputed = {};
    const localMethods  = {
        update_adv_account_status   : async function (account_status, advertiser_id) {

            const message = (account_status === "2") ? "确定要将此用户解冻吗，解冻后可正常登陆使用。" : "确定要将此用户冻结吗，冻结后无法正常登陆。";

            this.$confirm(message, '提示', {
                confirmButtonText: '确定',
                cancelButtonText : '取消',
                type             : 'warning'
            }).then(async () => {

                if (account_status === "9") {

                    await this.$prompt('请输入冻结的原因', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText : '取消',
                        inputValidator   : (value) => { return value !== null; },
                        inputErrorMessage: '冻结原因不能为空'
                    }).then(({value}) => {
                        this.do_update_adv_account_status(account_status, advertiser_id, value);
                    }).catch(() => {
                    });

                } else {
                    this.do_update_adv_account_status(account_status, advertiser_id, '');
                }

            }).catch(() => {
            });

        },
        do_update_adv_account_status: async function (account_status, advertiser_id, freezing_reason) {
            try {

                this.loading = true;
                var url      = '/admin/platform_advertiser/update_adv_account_status';
                var response = await axios.post(
                    url,
                    {
                        "id"             : advertiser_id,
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
        },
    };
    const data          = function () {
        return {
            loading: false,// 是否显示加载
        };
    };

    const Main = {
        data    : data,
        created : function () {},
        methods : localMethods,
        computed: localComputed,
    };
    const Ctor = Vue.extend(Main);
    new Ctor().$mount('#table');

</script>

</html>
