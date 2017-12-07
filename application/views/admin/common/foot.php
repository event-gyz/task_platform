        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                自媒体后台管理系统
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?= date('Y') ?> <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="/assets/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/AdminLTE/js/adminlte.min.js"></script>

    <script src="https://cdn.bootcss.com/vue/2.5.8/vue.js"></script>
    <script src="https://cdn.bootcss.com/element-ui/2.0.5/index.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.17.1/axios.min.js"></script>
    <script src="https://cdn.bootcss.com/lodash.js/4.17.4/lodash.min.js"></script>

    <script>

        // 实现进入子页面时左侧菜单也能高亮起来
        var my_auth_id     = "<?= !empty($_SESSION['my_auth_id']) ? $_SESSION['my_auth_id'] : ""?>";
        var my_auth_id_str = "[my_auth_id='" + my_auth_id + "']";
        $(my_auth_id_str).addClass('active');

        // 让他爹也亮起来
        $('.treeview-menu .active').parent().parent().addClass('active');

        // 如果文本框有错误信息则将其父div设置错误样式
        $('.help-block').each(function (index, value) {
            var has_error = $(value).html();
            if (has_error !== "") {
                $(value).parent().parent().addClass('has-error');
            }
        });

    </script>

</body>
