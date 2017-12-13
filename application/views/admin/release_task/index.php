<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            任务发布列表
            <small>管理任务的发布</small>
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
                                        <label for="task_name" class="col-sm-4 control-label">任务名称</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入任务名称来搜索..." name="task_name"
                                                   value="<?= $form_data['task_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="publishing_platform" class="col-sm-4 control-label">发布平台</label>
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
                                        <label for="task_type" class="col-sm-4 control-label">任务类型</label>
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
                                        <label class="col-sm-4 control-label">提交时间</label>
                                        <div class="col-sm-7 input-group">
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
                                        <label for="task_status" class="col-sm-4 control-label">任务状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="task_status">
                                                <option value="">全部</option>

                                                <?php foreach ($release_task_status as $key => $value): ?>
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
                                        <label for="sex" class="col-sm-4 control-label"></label>
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

                <div class="box" v-loading.body="loading" element-loading-text="拼命加载中" id="table">

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
                                        <a href="/admin/release_task/task_detail?id=<?= $value['task_id'] ?>">
                                            RW<?= $value['task_id'] ?>
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
                                        <?php if (($value['release_status'] === "0")): ?>
                                            <small class="label bg-yellow">
                                                待发布
                                            </small>
                                        <?php elseif (($value['release_status'] === "1") && ($value['end_time'] > time())): ?>
                                            <small class="label bg-green">
                                                执行中
                                            </small>
                                        <?php elseif (($value['release_status'] === "1") && ($value['end_time'] <= time())): ?>
                                            <small class="label bg-orange">
                                                待确认完成
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
                                        <?php

                                        // 是否显示发布按钮
                                        $is_show_release_btn = in_array($value['release_status'], [0]);

                                        // 是否显示查看自媒体人按钮
                                        $is_show_view_btn = ($value['release_status'] === "1") && ($value['end_time'] > time());

                                        // 是否显示手工作废按钮
                                        $is_show_cancellation_btn = (($value['release_status'] === "0")) ||
                                            (($value['release_status'] === "1") && ($value['end_time'] > time()));

                                        // 是否显示确认完成按钮
                                        $is_show_confirm_btn = ($value['release_status'] === "1") && ($value['end_time'] <= time());

                                        ?>

                                        <?php if ($is_show_release_btn): ?>
                                            <button @click="release_task('<?= $value['task_id'] ?>')" type="button"
                                                    class="btn btn-success btn-sm margin-r-5">发布
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($is_show_view_btn): ?>
                                            <button class="btn btn-primary btn-sm margin-r-5"
                                                    @click="view_self_media_man('<?= $value['task_id'] ?>')"
                                            >
                                                查看自媒体人
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($is_show_cancellation_btn): ?>
                                            <button @click="update_task_release_status('<?= $value['task_id'] ?>')"
                                                    type="button"
                                                    class="btn btn-danger btn-sm margin-r-5">
                                                手工作废
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($is_show_confirm_btn): ?>
                                            <button @click="confirm_finish('<?= $value['task_id'] ?>')" type="button"
                                                    class="btn btn-primary btn-sm margin-r-5">
                                                确认完成
                                            </button>
                                        <?php endif; ?>

                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <!-- /.box-body -->

                    <?= $page_link ?>

                    <el-dialog title="查看自媒体人" :visible.sync="dialogTableVisible">
                        <el-table :data="fmtResTableData" height="300" border>
                            <el-table-column property="task_map_id" label="序号" width="110"></el-table-column>
                            <el-table-column property="media_man_user_name" label="用户名" width="150"></el-table-column>
                            <el-table-column property="status" label="状态" width="150"></el-table-column>
                            <el-table-column property="create_time" label="发送时间" width="150"></el-table-column>
                            <el-table-column property="receive_time" label="领取/拒绝时间" width="150"></el-table-column>
                            <el-table-column property="deliver_time" label="完成时间" width="200"></el-table-column>
                        </el-table>
                        <el-pagination
                                layout="total, sizes, prev, pager, next, jumper"
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                :page-sizes="[10, 15, 20, 25]"
                                :current-page="pagination.currentPage"
                                :page-size="pagination.pageSize"
                                :total="pagination.total">
                        </el-pagination>
                        <div slot="footer" class="dialog-footer">
                            <el-button type="info" @click="dialogTableVisible = false">关 闭</el-button>
                        </div>
                    </el-dialog>

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

    const localComputed = {
        fmtResTableData: function () {
            // 处理服务端返回的数据
            return _.map(this.tableData, function (info) {
                return info;
            });
        }
    };
    const localMethods  = {
        view_self_media_man          : async function (task_id) {

            try {
                this.task_id   = (task_id !== 0) ? task_id : this.task_id;
                this.loading   = true;
                const url      = '/admin/release_task/view_self_media_man';
                const response = await axios.get(url, {
                    params: {
                        "id"   : this.task_id,
                        "page" : this.pagination.currentPage,
                        "limit": this.pagination.pageSize,
                    }
                });
                this.loading   = false;
                const resData  = response.data;

                if (resData.error_no !== 0) {
                    return this.$message.error(resData.msg)
                }

                this.tableData          = resData.data.list;
                this.pagination         = {
                    currentPage: resData.data.page,// 当前页
                    total      : resData.data.total,// 总记录数
                    pageSize   : resData.data.limit,// 每页显示记录数
                };
                this.dialogTableVisible = true;
            } catch (error) {
                this.loading   = false;
                this.tableData = [];

                if (error instanceof Error) {

                    if (error.response) {
                        return this.$message.error(error.response.data.responseText);
                    }

                    if (error.request) {
                        console.error(error.request);
                        return this.$message.error('服务器未响应');
                    }

                    console.error(error);

                }

            }

        },
        handleSizeChange             : function (val) {
            this.pagination.pageSize = val;
            if (this.pagination.total !== 0) {
                this.view_self_media_man(this.task_id);
            }
        },
        handleCurrentChange          : function (val) {
            this.pagination.currentPage = val;
            if (this.pagination.total !== 0) {
                this.view_self_media_man(this.task_id);
            }
        },
        release_task                 : async function (task_id) {

            await this.$prompt('请输入任务单价', '提示', {
                confirmButtonText: '确定',
                cancelButtonText : '取消',
                inputValidator   : (value) => { return (value !== null) && (value > 0); },
                inputErrorMessage: '任务单价只能是正数,仅支持小数点后一位'
            }).then(({value}) => {
                this.do_release_task(task_id, value);
            }).catch(() => {
            });

        },
        do_release_task              : async function (task_id, platform_price) {
            try {
                this.loading = true;
                var url      = '/admin/release_task/release_task';
                var response = await axios.post(
                    url,
                    {
                        "id"            : task_id,
                        "platform_price": platform_price,
                    },
                );
                this.loading = false;
                var resData  = response.data;

                if (resData.error_no === 0) {
                    this.$message.success('操作成功,即将刷新页面...');
                    return window.location.reload();
                }

                return this.$message.error(resData.msg);
            }
            catch (error) {

                this.loading = false;

                if (error instanceof Error) {

                    if (error.response) {
                        return this.$message.error(error.response.data.responseText);
                    }

                    if (error.request) {
                        console.error(error.request);
                        return this.$message.error('服务器未响应');
                    }

                    console.error(error);

                }

            }
        },
        confirm_finish               : async function (task_id) {
            try {
                this.loading   = true;
                const url      = '/admin/release_task/confirm_finish';
                const response = await axios.post(
                    url,
                    {
                        "id": task_id,
                    },
                );
                this.loading   = false;
                const resData  = response.data;

                if (resData.error_no === 0) {
                    this.$message.success('操作成功,即将刷新页面...');
                    return window.location.reload();
                }

                return this.$message.error(resData.msg);
            }
            catch (error) {

                this.loading = false;

                if (error instanceof Error) {

                    if (error.response) {
                        return this.$message.error(error.response.data.responseText);
                    }

                    if (error.request) {
                        console.error(error.request);
                        return this.$message.error('服务器未响应');
                    }

                    console.error(error);

                }

            }
        },
        update_task_release_status   : function (task_id) {

            var message = "确定要将任务作废吗，作废后任务将关闭无法正常流转。";

            this.$confirm(message, '提示', {
                confirmButtonText: '确定',
                cancelButtonText : '取消',
                type             : 'warning'
            }).then(async () => {

                await this.$prompt('请输入手工作废的原因', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    inputValidator   : (value) => { return value !== null; },
                    inputErrorMessage: '手工作废原因不能为空'
                }).then(({value}) => {
                    this.do_update_task_release_status(task_id, '8', value);
                }).catch(() => {
                });

            }).catch(() => {
            });

        },
        do_update_task_release_status: async function (task_id, release_status, close_reason) {
            try {

                this.loading = true;
                var url      = '/admin/release_task/update_task_release_status';
                var response = await axios.post(
                    url,
                    {
                        "id"            : task_id,
                        "release_status": release_status,
                        "close_reason"  : close_reason,
                    },
                );
                this.loading = false;
                var resData  = response.data;

                if (resData.error_no === 0) {
                    this.$message.success('操作成功,即将刷新页面...');
                    return window.location.reload();
                }

                return this.$message.error(resData.msg);

            } catch (error) {

                this.loading = false;

                if (error instanceof Error) {

                    if (error.response) {
                        return this.$message.error(error.response.data.responseText);
                    }

                    if (error.request) {
                        console.error(error.request);
                        return this.$message.error('服务器未响应');
                    }

                    console.error(error);

                }

            }
        },
    };
    const data          = function () {
        return {
            loading           : false,// 是否显示加载
            dialogTableVisible: false,// 是否显示dialog
            tableData         : [],// 初始化表格数据
            task_id           : 0,
            pagination        : {
                currentPage: 1,// 当前页
                total      : 0,// 总记录数
                pageSize   : 10,// 每页显示记录数
            },
        };
    };

    const Main = {
        data    : data,
        created : function () {},
        methods : localMethods,
        computed: localComputed,
    };
    const Ctor = Vue.extend(Main);
    new Ctor().$mount('#table');

</script>

</html>
