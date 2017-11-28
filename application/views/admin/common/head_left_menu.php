<?php

// 菜单列表
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

// 用户的权限列表
$auth_ids    = $_SESSION['sys_user_info']['auth_ids'];
$auth_id_arr = explode(',', $auth_ids);

?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <?php foreach ($s_auth_list as $value0): ?>
                <li class="treeview">

                    <?php if (($value0['level'] === '0') && (in_array($value0['id'], $auth_id_arr))): ?>
                        <a href="javascript:;">
                            <span><?= $value0['auth_name'] ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                    <?php endif; ?>

                    <ul class="treeview-menu">
                        <?php foreach ($s_auth_list as $value1): ?>
                            <?php if (($value1['level'] === '1') && ($value1['pid'] === $value0['id']) && (in_array($value1['id'], $auth_id_arr))): ?>
                                <li
                                        class="<?= get_active_str("/{$value1['class']}/{$value1['action']}") ?>"
                                        auth_id="<?= $value1['id'] ?>"
                                >
                                    <a href="/admin/<?= $value1['class'] ?>/<?= $value1['action'] ?>?my_auth_id=<?= $value1['id'] ?>">
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
