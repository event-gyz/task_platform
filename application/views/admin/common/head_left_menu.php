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

            <?php $auth_list = $_SESSION['auth_list']; ?>
            <?php foreach ($auth_list as $value0): ?>
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
                        <?php foreach ($auth_list as $value1): ?>
                            <?php if ($value1['level'] === '1' && $value1['pid'] === $value0['id']): ?>
                                <li>
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
