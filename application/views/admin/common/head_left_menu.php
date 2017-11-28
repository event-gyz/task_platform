<?php

$s_auth_list = $_SESSION['menu_auth_list'];

/**
 * 获取当前菜单是否需要激活
 *
 * @param $cur_path 当前需要比较的子路径
 *
 * @return string
 */
function get_active_str($cur_path) {
    $request_url = strtolower($_SERVER['REQUEST_URI']);
    $cur_path    = strtolower($cur_path);
    $pos         = strpos($request_url, $cur_path);
    return ($pos === false) ? '' : 'active';
}

?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i>
                    <span>广告主管理</span>
                    <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/index/home1">个人审核列表</a></li>
                    <li><a href="/admin/index/home2">公司审核列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i>
                    <span>自媒体人管理</span>
                    <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/index/home1">自媒体人审核列表</a></li>
                </ul>
            </li>

            <?php foreach ($s_auth_list as $value0): ?>
                <li class="treeview">

                    <?php if ($value0['level'] === '0'): ?>
                        <a href="javascript:;">
                            <span><?= $value0['auth_name'] ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                    <?php endif; ?>

                    <ul class="treeview-menu">
                        <?php foreach ($s_auth_list as $value1): ?>
                            <?php if ($value1['level'] === '1' && $value1['pid'] === $value0['id']): ?>
                                <li
                                        class="<?= get_active_str("/{$value1['class']}") ?>"
                                >
                                    <a href="/admin/<?= $value1['class'] ?>/<?= $value1['action'] ?>">
                                        <?= $value1['auth_name'] ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                </li>
            <?php endforeach; ?>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
