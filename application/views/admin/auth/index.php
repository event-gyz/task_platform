<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            权限列表
            <small>管理系统的操作权限</small>
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
                                    <label for="auth_name" class="col-sm-3 control-label">权限名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="auth_name"
                                               placeholder="输入权限名称来搜索..." name="auth_name"
                                               value="<?= $form_data['auth_name'] ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <label for="level" class="col-sm-3 control-label">权限等级</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="level">
                                            <option value="0"
                                                <?= $form_data['level'] == '0' ? "selected" : "" ?>
                                            >
                                                一级菜单
                                            </option>
                                            <option value="1"
                                                <?= $form_data['level'] == '1' ? "selected" : "" ?>
                                            >
                                                二级菜单
                                            </option>
                                            <option value="2"
                                                <?= $form_data['level'] == '2' ? "selected" : "" ?>
                                            >
                                                按钮操作
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <button type="submit" class="btn btn-info">搜索</button>
                                    <a class="btn btn-success" href="/admin/auth/add">添加权限</a>
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
                                <th>权限ID</th>
                                <th>权限名称</th>
                                <th>权限父id</th>
                                <th>类</th>
                                <th>方法</th>
                                <th>权限级别</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th><?= $value['id'] ?></th>
                                    <th><?= $value['auth_name'] ?></th>
                                    <th><?= $value['pid'] ?></th>
                                    <th><?= $value['class'] ?></th>
                                    <th><?= $value['action'] ?></th>
                                    <th><?= $value['level'] ?></th>
                                    <th>
                                        <a href="/admin/auth/update?id=<?= $value['id'] ?>"
                                           class="btn btn-info btn-sm">修改</a>
                                        <button del-url="/admin/auth/del?id=<?= $value['id'] ?>"
                                                class="del-auth btn btn-danger btn-sm">删除
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

    $('.del-auth').click(function () {
        var del_url = $(this).attr('del-url');

        layer.confirm(
            '确定删除此权限？',
            {btn: ['确定', '取消']},
            function () {
                window.location.href = del_url;
            });
    });

</script>

</html>