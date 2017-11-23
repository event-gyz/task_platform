<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            内容标题0
            <small>内容标题的小字部分0</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <!--------------------------
          | Your Page Content Here |
          -------------------------->
        这里是页面的内容

        <div id="app">
            <el-button @click="visible = true">按钮</el-button>
            <el-dialog :visible.sync="visible" title="Hello world">
                <p>欢迎使用 Element</p>
            </el-dialog>

            <el-button>默认按钮</el-button>
            <el-button type="primary">主要按钮</el-button>
            <el-button type="success">成功按钮</el-button>
            <el-button type="info">信息按钮</el-button>
            <el-button type="warning">警告按钮</el-button>
            <el-button type="danger">危险按钮</el-button>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script>
    new Vue({
        el: '#app',
        data: function() {
            return { visible: false }
        }
    })
</script>

</html>
