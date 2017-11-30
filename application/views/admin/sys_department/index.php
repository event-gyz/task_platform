<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            系统部门列表
            <small>管理系统的部门</small>
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
                                    <label for="dept_name" class="col-sm-3 control-label">部门名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="dept_name"
                                               placeholder="输入部门名称来搜索..." name="dept_name"
                                               value="<?= $form_data['dept_name'] ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <button type="submit" class="btn btn-info">搜索</button>
                                    <a class="btn btn-success" href="/admin/sys_department/add">添加部门</a>
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
                                <th>部门ID</th>
                                <th>部门名称</th>
                                <th>创建人</th>
                                <th>创建时间</th>
                                <th>最后修改时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th><?= $value['id'] ?></th>
                                    <th><?= $value['dept_name'] ?></th>
                                    <th><?= $value['create_by_name'] ?></th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th>
                                        <a href="/admin/sys_department/update?id=<?= $value['id'] ?>"
                                           class="btn btn-info btn-sm">修改</a>
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

<script>

    var Main = {
        methods: {
            del: function (id) {
                var del_url = "/admin/sys_department/del?id=" + id;
                this.$confirm('此操作将永久删除此部门, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    this.$message({
                        type   : 'success',
                        message: '正在删除...'
                    });
                    window.location.href = del_url;
                }).catch(() => {
                });
            }
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

</script>

</html>
