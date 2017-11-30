<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="/assets/select2/css/select2.min.css" rel="stylesheet"/>

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
                                        <select class="form-control" id="select-dept_id" name="dept_id">
                                            <option value="">全部</option>

                                            <?php foreach ($dept_list as $value): ?>
                                                <option value="<?= $value['id'] ?>"
                                                    <?= $value['id'] === $form_data['dept_id'] ? 'selected' : ''; ?>

                                                >
                                                    <?= $value['dept_name'] ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
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
                                <th>所属角色</th>
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
                                    <th><?= $value['dept_name'] ?></th>
                                    <th><?= $value['role_name'] ?></th>
                                    <th><?= $value['mobile'] ?></th>
                                    <th><?= $value['create_by_name'] ?></th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th><?= $value['modify_by_name'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th><?= $value['user_status'] === '1' ? '有效' : '无效' ?></th>
                                    <th>
                                        <a href="/admin/sys_user/update?id=<?= $value['id'] ?>"
                                           class="btn btn-info btn-sm">修改</a>

                                        <?php if ($value['user_status'] == '0'): ?>
                                            <button @click="update_user_status('1','<?= $value['id'] ?>')"
                                                    class="btn btn-success btn-sm">
                                                解冻
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($value['user_status'] == '1'): ?>
                                            <button @click="update_user_status('0','<?= $value['id'] ?>')"
                                                    class="btn btn-warning btn-sm">
                                                冻结
                                            </button>
                                        <?php endif; ?>

                                        <button @click="manager_reset_pwd('<?= $value['id'] ?>')"
                                                class="btn btn-primary btn-sm">
                                            重置密码
                                        </button>

                                        <button @click="del('<?= $value['id'] ?>')" class="btn btn-danger btn-sm">
                                            删除
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
<script src="/assets/select2/js/select2.full.min.js"></script>

<script>

    // 初始化select2下拉框
    $("#select-dept_id").select2();

    var Main = {
        methods: {
            update_user_status: function (user_status, id) {
                var message = (user_status === "0") ? "确定将此用户冻结吗？冻结后此用户将不能再登录系统。" : "确定将此用户解冻吗？";
                var url     = "/admin/sys_user/update_user_status?user_status=" + user_status + "&id=" + id;
                this.$confirm(message, '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    this.$message({
                        type   : 'success',
                        message: '正在执行,请稍候...'
                    });
                    window.location.href = url;
                }).catch(() => {
                });
            },
            manager_reset_pwd : function (id) {
                var message = "确定重置此用户密码为123456？";
                var url     = "/admin/sys_user/manager_reset_pwd?id=" + id;
                this.$confirm(message, '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    this.$message({
                        type   : 'success',
                        message: '正在执行,请稍候...'
                    });
                    window.location.href = url;
                }).catch(() => {
                });
            },
            del               : function (id) {
                var url = "/admin/sys_user/del?id=" + id;
                this.$confirm('此操作将永久删除此用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    this.$message({
                        type   : 'success',
                        message: '正在删除...'
                    });
                    window.location.href = url;
                }).catch(() => {
                });
            }
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

</script>

</html>
