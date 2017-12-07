<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            任务审核列表
            <small>管理任务的审核</small>
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
                                        <label for="task_name" class="col-sm-3 control-label">任务名称</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入任务名称来搜索..." name="task_name"
                                                   value="<?= $form_data['task_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="publishing_platform" class="col-sm-3 control-label">发布平台</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="publishing_platform">
                                                <option value="">全部</option>

                                                <?php foreach ($publishing_platform_list as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['publishing_platform'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="task_type" class="col-sm-3 control-label">任务类型</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="task_type">
                                                <option value="">全部</option>

                                                <?php foreach ($task_type_list as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['task_type'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label class="col-sm-3 control-label">提交时间</label>
                                        <div class="input-group col-sm-7">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="submit_audit_time"
                                                   class="form-control pull-right"
                                                   id="reservation"
                                                   value="<?= $form_data['submit_audit_time'] ?>"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label for="task_status" class="col-sm-3 control-label">任务状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="task_status">
                                                <option value="">全部</option>

                                                <?php foreach ($task_status_list as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['task_status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

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
                                <th>任务ID</th>
                                <th>任务名称</th>
                                <th>任务类型</th>
                                <th>发布平台</th>
                                <th>任务标题</th>
                                <th>任务状态</th>
                                <th>提交时间</th>
                                <th>提交人</th>
                                <th>期望帐号数量</th>
                                <th>系统匹配数量</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th>
                                        <a href="/admin/platform_task/task_detail?id=<?= $value['task_id'] ?>">
                                            <?= $value['task_id'] ?>
                                        </a>
                                    </th>
                                    <th><?= $value['task_name'] ?></th>
                                    <th><?= $task_type_list[$value['task_type']] ?></th>
                                    <th>
                                        <?php foreach (explode(',', $value['publishing_platform']) as $key2 => $value2): ?>
                                            <?= $publishing_platform_list[$value2] ?>
                                        <?php endforeach; ?>
                                    </th>
                                    <th><?= $value['title'] ?></th>
                                    <th>
                                        <?php if (($value['audit_status'] === "1")): ?>
                                            <small class="label bg-yellow">
                                                待审核
                                            </small>
                                        <?php elseif (($value['audit_status'] === "2")): ?>
                                            <small class="label bg-red">
                                                驳回
                                            </small>
                                        <?php elseif (($value['pay_status'] === "0") && ($value['audit_status'] === "3")): ?>
                                            <small class="label bg-aqua">
                                                待广告主付款
                                            </small>
                                        <?php elseif (($value['pay_status'] === "1") && ($value['audit_status'] === "3") && ($value['finance_status'] === "0")): ?>
                                            <small class="label bg-orange">
                                                待财务确认
                                            </small>
                                        <?php elseif (($value['pay_status'] === "1") && ($value['audit_status'] === "3") && ($value['finance_status'] === "1")): ?>
                                            <small class="label bg-green">
                                                财务已确认
                                            </small>
                                        <?php else: ?>
                                            <small class="label bg-gray">
                                                未知
                                            </small>
                                        <?php endif; ?>
                                    </th>
                                    <th><?= $value['submit_audit_time'] ?></th>
                                    <th><?= $value['advertiser_user_name'] ?></th>
                                    <th><?= $value['media_man_number'] ?></th>
                                    <th><?= $value['actual_media_man_number'] ?></th>
                                    <th>
                                        <a href="/admin/platform_task/task_detail?id=<?= $value['task_id'] ?>"
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
