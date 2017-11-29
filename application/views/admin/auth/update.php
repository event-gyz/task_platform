<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="/assets/select2/css/select2.min.css" rel="stylesheet"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            修改权限
            <small>修改一个权限</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">

            <div class="col-xs-12">

                <div class="col-md-6">

                    <!-- Horizontal Form -->
                    <div class="box box-info">

                        <!-- form start -->
                        <form class="form-horizontal" action="/admin/auth/update" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="select-pid" class="col-sm-2 control-label">父级菜单</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="select-pid" name="pid">
                                            <option value="0">根节点-即创建为一级菜单</option>

                                            <?php foreach ($auth_list as $value): ?>
                                                <option value="<?= $value['id'] ?>"
                                                    <?= $value['id'] === $info['pid'] ? 'selected' : ''; ?>
                                                >
                                                    <?= $value['auth_name'] ?>
                                                    <?= $value['level'] === '0' ? '-1级菜单' : ''; ?>
                                                    <?= $value['level'] === '1' ? '-2级菜单' : ''; ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                        <span class="help-block"><?php echo form_error('pid'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="auth_name" class="col-sm-2 control-label">权限名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="auth_name" class="form-control" id="auth_name"
                                               placeholder="输入权限名称"
                                               value="<?= $info['auth_name'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('auth_name'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="class" class="col-sm-2 control-label">类</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="class" class="form-control" id="class"
                                               placeholder="输入权限控制的类名称,注意大小写"
                                               value="<?= $info['class'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('class'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="action" class="col-sm-2 control-label">方法</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="action" class="form-control" id="action"
                                               placeholder="输入权限控制的方法名称,注意大小写"
                                               value="<?= $info['action'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('action'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">排序值</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="sort" class="form-control" id="sort"
                                               placeholder="值越大排序越靠前"
                                               value="<?= $info['sort'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('sort'); ?></span>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer ">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
                                <a class="btn btn-default" href="/admin/auth/home">取消</a>
                                <button type="submit" class="btn btn-info pull-right">提交</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>

                    </div>
                    <!-- /.box -->

                </div>

            </div>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>
<script src="/assets/select2/js/select2.full.min.js"></script>

<script>

    // 初始化select2下拉框
    $("#select-pid").select2();

</script>

</html>
