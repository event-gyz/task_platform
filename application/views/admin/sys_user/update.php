<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="/assets/select2/css/select2.min.css" rel="stylesheet"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            更新用户
            <small>更新一个系统用户</small>
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
                        <form class="form-horizontal" action="/admin/sys_user/update" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="user_name" class="col-sm-2 control-label">用户名</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="user_name" class="form-control" id="user_name"
                                               placeholder="输入用户名称"
                                               value="<?= $info['user_name'] ?>"
                                               disabled
                                        >
                                        <span class="help-block"><?php echo form_error('user_name'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nick_name" class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nick_name" class="form-control" id="nick_name"
                                               placeholder="输入用户姓名"
                                               value="<?= $info['nick_name'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('nick_name'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile" class="col-sm-2 control-label">联系电话</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mobile" class="form-control" id="mobile"
                                               placeholder="输入联系电话"
                                               value="<?= $info['mobile'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('mobile'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role_id" class="col-sm-2 control-label">所属角色</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="select-role_id" name="role_id">
                                            <option value="0">选择角色</option>

                                            <?php foreach ($role_list as $value): ?>
                                                <option value="<?= $value['id'] ?>"
                                                    <?= $value['id'] === $info['role_id'] ? 'selected' : ''; ?>
                                                >
                                                    <?= $value['role_name'] ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                        <span class="help-block"><?php echo form_error('role_id'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dept_id" class="col-sm-2 control-label">所属部门</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="select-dept_id" name="dept_id">
                                            <option value="0">选择部门</option>

                                            <?php foreach ($dept_list as $value): ?>
                                                <option value="<?= $value['id'] ?>"
                                                    <?= $value['id'] === $info['dept_id'] ? 'selected' : ''; ?>

                                                >
                                                    <?= $value['dept_name'] ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                        <span class="help-block"><?php echo form_error('dept_id'); ?></span>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer ">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
                                <a class="btn btn-default" href="/admin/sys_user/home">取消</a>
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
    $("#select-role_id").select2();
    $("#select-dept_id").select2();

</script>

</html>
