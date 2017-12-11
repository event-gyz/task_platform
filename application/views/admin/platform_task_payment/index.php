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
                                            <button @click="confirm_receive_money('<?= $value['payment_id'] ?>')"
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

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script>

    const localComputed = {};
    const localMethods  = {
        confirm_receive_money: function (payment_id) {
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
    new Ctor().$mount('#app');

</script>

</html>
