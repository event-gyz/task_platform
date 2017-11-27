<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            添加角色
            <small>添加一个角色</small>
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
                        <form class="form-horizontal" action="/admin/sys_role/add" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="role_name" class="col-sm-2 control-label">角色名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="role_name" class="form-control" id="role_name"
                                               placeholder="输入角色名称"
                                               value="<?= set_value('role_name') ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('role_name'); ?></span>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer ">
                                <a class="btn btn-default" href="/admin/sys_role/home">取消</a>
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

</html>
