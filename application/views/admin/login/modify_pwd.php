<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            修改密码
            <small>修改管理员的登录密码</small>
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
                        <form action="/admin/login/modify_pwd" class="form-horizontal" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原密码</label>
                                    <div class="col-sm-10">
                                        <input name="pwd" type="password" class="form-control"
                                               placeholder="请输入原密码"
                                               value="<?= set_value('pwd') ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('pwd'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">新密码</label>
                                    <div class="col-sm-10">
                                        <input name="re_pwd" type="password" class="form-control"
                                               placeholder="请输入新密码"
                                               value="<?= set_value('re_pwd') ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('re_pwd'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">确认新密码</label>
                                    <div class="col-sm-10">
                                        <input name="re2_pwd" type="password" class="form-control"
                                               placeholder="请确认新密码"
                                               value="<?= set_value('re2_pwd') ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('re2_pwd'); ?></span>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
                                <a class="btn btn-default" href="javascript:window.history.go(-1);">取消</a>
                                <button type="submit" class="btn btn-info pull-right">添加</button>
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

<script>

</script>

</html>
