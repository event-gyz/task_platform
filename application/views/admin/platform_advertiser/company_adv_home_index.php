<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

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
                                        <label for="company_name" class="col-sm-3 control-label">公司名称</label>
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
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control"
                                                   name="start_time"
                                                   value="<?= $form_data['start_time'] ?>"
                                            >

                                        </div>

                                        <div class="col-sm-4">
                                            <input type="text" class="form-control"
                                                   name="end_time"
                                                   value="<?= $form_data['end_time'] ?>"
                                            >

                                        </div>


                                    </div>

                                </div>

                                <div class="row">

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
                                        <label for="content_phone" class="col-sm-4 control-label">联系人电话</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入联系人电话来搜索..." name="content_phone"
                                                   value="<?= $form_data['content_phone'] ?>"
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
                                    <th><?= $value['advertiser_id'] ?></th>
                                    <th><?= $value['advertiser_login_name'] ?></th>
                                    <th><?= $value['company_name'] ?></th>
                                    <th><?= $value['company_address'] ?></th>
                                    <th><?= $value['content_name'] ?></th>
                                    <th><?= $value['content_phone'] ?></th>
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

<script>

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
