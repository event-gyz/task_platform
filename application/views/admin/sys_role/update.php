<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<link href="https://cdn.bootcss.com/element-ui/2.0.5/theme-chalk/index.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            更新角色
            <small>更新一个角色</small>
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
                        <form class="form-horizontal" action="/admin/sys_role/update" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="role_name" class="col-sm-2 control-label">角色名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="role_name" class="form-control" id="role_name"
                                               placeholder="输入角色名称"
                                               value="<?= $info['role_name'] ?>"
                                        >
                                        <span class="help-block"><?php echo form_error('role_name'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="auth_ids" class="col-sm-2 control-label">选择权限</label>
                                    <div class="col-sm-10" id="app">
                                        <el-tree
                                                :data="treeData"
                                                show-checkbox
                                                node-key="id"
                                                empty-text="暂无权限菜单可选择"
                                                :default-expanded-keys="[2, 3]"
                                                :default-checked-keys="[5]"
                                                :props="defaultProps"
                                        >
                                        </el-tree>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer ">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
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

<script src="https://cdn.bootcss.com/vue/2.5.8/vue.min.js"></script>
<script src="https://cdn.bootcss.com/element-ui/2.0.5/index.js"></script>

<script>

    var Main = {
        data: function () {
            return {
                treeData    : <?= $auth_list_json ?>,
                defaultProps: {
                    children: 'children',
                    label   : 'label'
                }
            };
        }
    };

    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

</script>

</html>
