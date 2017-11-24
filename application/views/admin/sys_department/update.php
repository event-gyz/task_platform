<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            更新部门
            <small>更新一个部门</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">

            <div class="col-xs-12">

                <div class="col-md-6">

                    <!-- Horizontal Form -->
                    <div class="box box-info">

                        <div class="box-header with-border">
                            <div class="bg-danger"><?php echo validation_errors(); ?></div>
                        </div>

                        <!-- form start -->
                        <form class="form-horizontal" action="/admin/sys_department/update" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="dept_name" class="col-sm-2 control-label">部门名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="dept_name" class="form-control" id="dept_name"
                                               placeholder="输入部门名称"
                                               value="<?= $info['dept_name'] ?>"
                                        >
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer ">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
                                <a class="btn btn-default" href="/admin/sys_department/home">取消</a>
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
