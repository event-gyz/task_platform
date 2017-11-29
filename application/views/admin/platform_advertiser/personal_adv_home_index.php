<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            个人广告主审核列表
            <small>管理个人广告主的审核</small>
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
                                        <label for="advertiser_name" class="col-sm-3 control-label">姓名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="advertiser_name"
                                                   placeholder="输入姓名来搜索..." name="advertiser_name"
                                                   value="<?= $form_data['advertiser_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="advertiser_phone" class="col-sm-3 control-label">手机号码</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="advertiser_phone"
                                                   placeholder="输入手机号码来搜索..." name="advertiser_phone"
                                                   value="<?= $form_data['advertiser_phone'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="audit_status" class="col-sm-3 control-label">审核状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="audit_status">
                                                <option value="">全部</option>
                                                <option value="0"
                                                    <?= $form_data['audit_status'] == '0' ? "selected" : "" ?>
                                                >
                                                    待审核
                                                </option>
                                                <option value="1"
                                                    <?= $form_data['audit_status'] == '1' ? "selected" : "" ?>
                                                >
                                                    通过
                                                </option>
                                                <option value="2"
                                                    <?= $form_data['audit_status'] == '2' ? "selected" : "" ?>
                                                >
                                                    驳回
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label class="col-sm-3 control-label">注册时间</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="create_time"
                                                   class="form-control pull-right"
                                                   id="reservation"
                                                   value="<?= $form_data['create_time'] ?>"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="id_card" class="col-sm-3 control-label">身份证号</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入身份证号来搜索..." name="id_card"
                                                   value="<?= $form_data['id_card'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="advertiser_id" class="col-sm-3 control-label">用户ID</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入用户ID来搜索..." name="advertiser_id"
                                                   value="<?= $form_data['advertiser_id'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="status" class="col-sm-3 control-label">账号状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status">
                                                <option value="">全部</option>
                                                <option value="0"
                                                    <?= $form_data['status'] == '0' ? "selected" : "" ?>
                                                >
                                                    草稿
                                                </option>
                                                <option value="1"
                                                    <?= $form_data['status'] == '1' ? "selected" : "" ?>
                                                >
                                                    待审核
                                                </option>
                                                <option value="2"
                                                    <?= $form_data['status'] == '2' ? "selected" : "" ?>
                                                >
                                                    正常
                                                </option>
                                                <option value="9"
                                                    <?= $form_data['status'] == '9' ? "selected" : "" ?>
                                                >
                                                    冻结
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <button type="submit" class="btn btn-info">搜索</button>
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
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>手机号码</th>
                                <th>身份证号</th>
                                <th>审核状态</th>
                                <th>注册时间</th>
                                <th>帐号状态</th>
                                <th>最后操作人</th>
                                <th>最后操作时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th><?= $value['advertiser_id'] ?></th>
                                    <th><?= $value['advertiser_login_name'] ?></th>
                                    <th><?= $value['advertiser_name'] ?></th>
                                    <th><?= $value['advertiser_phone'] ?></th>
                                    <th><?= $value['id_card'] ?></th>
                                    <th><?= $value['audit_status'] ?></th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th><?= $value['status'] ?></th>
                                    <th><?= $value['last_operator_name'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th>
                                        <a href="/admin/sys_department/update?id=<?= $value['advertiser_id'] ?>"
                                           class="btn btn-info btn-sm">审核</a>
                                        <a del-url="/admin/sys_department/del?id=<?= $value['advertiser_id'] ?>"
                                           class="del-department btn btn-danger btn-sm">冻结
                                        </a>
                                        <a del-url="/admin/sys_department/del?id=<?= $value['advertiser_id'] ?>"
                                           class="del-department btn btn-danger btn-sm">解冻
                                        </a>
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

<script src="/assets/layer/layer.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>

<script>

    $('#reservation').daterangepicker();

    $('.del-department').click(function () {
        var del_url = $(this).attr('del-url');

        layer.confirm(
            '确定删除此部门？',
            {btn: ['确定', '取消']},
            function () {
                window.location.href = del_url;
            });
    });

</script>

</html>
