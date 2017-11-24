<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            系统用户列表
            <small>管理系统的管理员用户</small>
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

                                <div class="form-group col-xs-3">
                                    <label for="user_name" class="col-sm-3 control-label">用户名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="user_name"
                                               placeholder="输入用户名称来搜索..." name="user_name"
                                               value="<?= $form_data['user_name'] ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <label for="dept_id" class="col-sm-3 control-label">归属部门</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="dept_id"
                                               placeholder="输入部门来搜索..." name="dept_id"
                                               value="<?= $form_data['dept_id'] ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <label for="mobile" class="col-sm-3 control-label">联系电话</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="mobile"
                                               placeholder="输入电话来搜索..." name="mobile"
                                               value="<?= $form_data['mobile'] ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <button type="submit" class="btn btn-info">搜索</button>
                                    <a class="btn btn-success" href="/admin/sys_user/add">添加用户</a>
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
                                <th>归属部门</th>
                                <th>联系电话</th>
                                <th>创建人</th>
                                <th>创建时间</th>
                                <th>最后修改人</th>
                                <th>最后修改时间</th>
                                <th>用户状态</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th><?= $value['id'] ?></th>
                                    <th><?= $value['user_name'] ?></th>
                                    <th><?= $value['dept_id'] ?></th>
                                    <th><?= $value['mobile'] ?></th>
                                    <th><?= $value['create_sys_user_id'] ?></th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th><?= $value['last_modify_sys_user_id'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th><?= $value['user_status'] ?></th>
                                    <th>
                                        <a href="/admin/sys_user/update?id=<?= $value['id'] ?>"
                                           class="btn btn-info btn-sm">修改</a>
                                        <a href="/admin/sys_user/update_user_status?id=<?= $value['id'] ?>"
                                           class="btn btn-warning btn-sm">冻结</a>
                                        <button del-url="/admin/sys_user/del?id=<?= $value['id'] ?>"
                                                class="del-user btn btn-danger btn-sm">删除
                                        </button>
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

    $('.del-user').click(function () {
        var del_url = $(this).attr('del-url');

        layer.confirm(
            '确定删除此用户？',
            {btn: ['确定', '取消']},
            function () {
                window.location.href = del_url;
            });
    });

</script>

</html>
