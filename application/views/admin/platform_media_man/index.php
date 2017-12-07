<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            自媒体人审核列表
            <small>管理自媒体人的审核</small>
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

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="media_man_name" class="col-sm-3 control-label">姓名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入姓名来搜索..." name="media_man_name"
                                                   value="<?= $form_data['media_man_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="school_name" class="col-sm-4 control-label">学校名称</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入学校名称来搜索..." name="school_name"
                                                   value="<?= $form_data['school_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="audit_status" class="col-sm-3 control-label">审核状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="audit_status">
                                                <option value="">全部</option>

                                                <?php foreach ($media_audit_status as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['audit_status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label class="col-sm-3 control-label">注册时间</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="create_time"
                                                   class="form-control pull-right"
                                                   id="reservation"
                                                   value="<?= $form_data['create_time'] ?>"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="sex" class="col-sm-3 control-label">性别</label>
                                        <div class="col-sm-7">

                                            <select class="form-control" name="sex">
                                                <option value="">全部</option>
                                                <option value="1"
                                                    <?= "1" === $form_data['sex'] ? 'selected' : ''; ?>
                                                >
                                                    男
                                                </option>
                                                <option value="2"
                                                    <?= "2" === $form_data['sex'] ? 'selected' : ''; ?>
                                                >
                                                    女
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="media_man_phone" class="col-sm-4 control-label">电话</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入电话来搜索..." name="media_man_phone"
                                                   value="<?= $form_data['media_man_phone'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="status" class="col-sm-3 control-label">账号状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status">
                                                <option value="">全部</option>

                                                <?php foreach ($media_account_status as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="tag" class="col-sm-3 control-label">标签</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入标签来搜索..." name="tag"
                                                   value="<?= $form_data['tag'] ?>"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="sex" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-info">搜索</button>
                                        </div>
                                    </div>

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
                                <th>姓名</th>
                                <th>性别</th>
                                <th>电话</th>
                                <th>学校名称</th>
                                <th>审核状态</th>
                                <th>注册时间</th>
                                <th>帐号状态</th>
                                <th>最后操作人</th>
                                <th>最后操作时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th>
                                        <a href="/admin/platform_media_man/media_man_detail?id=<?= $value['media_man_id'] ?>">
                                            <?= $value['media_man_id'] ?>
                                        </a>
                                    </th>
                                    <th><?= $value['media_man_login_name'] ?></th>
                                    <th><?= $value['media_man_name'] ?></th>
                                    <th><?= $value['sex'] === "1" ? "男" : "女" ?></th>
                                    <th><?= $value['media_man_phone'] ?></th>
                                    <th><?= $value['school_name'] ?></th>
                                    <th>
                                        <small class="label
                                            <?= $value['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $value['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $value['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                                            <?= $media_audit_status[$value['audit_status']] ?>
                                        </small>
                                    </th>
                                    <th><?= $value['create_time'] ?></th>
                                    <th>
                                        <small class="label
                                            <?= $value['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $value['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $value['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $value['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                                            <?= $media_account_status[$value['status']] ?>
                                        </small>
                                    </th>
                                    <th><?= $value['last_operator_name'] ?></th>
                                    <th><?= $value['update_time'] ?></th>
                                    <th>
                                        <a href="/admin/platform_media_man/to_update_media_man?id=<?= $value['media_man_id'] ?>"
                                           class="btn btn-primary btn-sm">
                                            修改
                                        </a>
                                        <a href="/admin/platform_media_man/media_man_detail?id=<?= $value['media_man_id'] ?>"
                                           class="btn btn-success btn-sm">
                                            详情
                                        </a>
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

<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>

<script>

    $('#reservation').daterangepicker({
        locale: {
            applyLabel : '确定',
            cancelLabel: '取消',
            daysOfWeek : ['日', '一', '二', '三', '四', '五', '六'],
            monthNames : ['一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月'],
        }
    });

</script>

</html>
