<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            自媒体人结账列表
            <small>管理自媒体人结账信息</small>
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
                                        <label for="media_man_login_name" class="col-sm-5 control-label">用户名</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入用户名称" name="media_man_login_name"
                                                   value="<?= $form_data['media_man_login_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="school_name" class="col-sm-5 control-label">学校名称</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入学校名称" name="school_name"
                                                   value="<?= $form_data['school_name'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="zfb_nu" class="col-sm-5 control-label">支付宝</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"
                                                   placeholder="输入支付宝帐号" name="zfb_nu"
                                                   value="<?= $form_data['zfb_nu'] ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-3">
                                        <label for="m_finance_status" class="col-sm-5 control-label">财务状态</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="m_finance_status">
                                                <option value="">全部</option>

                                                <?php foreach ($finance_status_list as $key => $value): ?>
                                                    <option value="<?= $key ?>"
                                                        <?= "$key" === $form_data['m_finance_status'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-xs-3">
                                        <label class="col-sm-5 control-label"></label>
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-info" style="margin-right: 10px;">搜索
                                            </button>
                                            <el-button button-id="export" @click.once="prepare_export_receivables"
                                                       type="primary" size="small">导出
                                            </el-button>
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
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>性别</th>
                                <th>电话</th>
                                <th>学校名称</th>
                                <th>支付宝</th>
                                <th>真实姓名</th>
                                <th>支付方式</th>
                                <th>付款金额</th>
                                <th>财务状态</th>
                                <th>财务确认时间</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($list as $value): ?>
                                <tr>
                                    <th>RW<?= $value['task_id'] ?></th>
                                    <th><?= $value['task_name'] ?></th>
                                    <th>KPS<?= $value['media_man_id'] ?></th>
                                    <th><?= $value['media_man_login_name'] ?></th>
                                    <th><?= $value['media_man_name'] ?></th>
                                    <th><?= $value['sex'] === "1" ? "男" : "女" ?></th>
                                    <th><?= $value['media_man_phone'] ?></th>
                                    <th><?= $value['school_name'] ?></th>
                                    <th><?= $value['zfb_nu'] ?></th>
                                    <th><?= $value['zfb_realname'] ?></th>
                                    <th><?= $platform_pay_way_list[$value['platform_pay_way']] ?></th>
                                    <th><?= $value['platform_pay_money'] ?></th>
                                    <th>

                                        <?php if (($value['finance_status'] === "0")): ?>
                                            <small class="label bg-yellow">
                                                待付款
                                            </small>
                                        <?php elseif (($value['finance_status'] === "1") && ($value['receivables_status'] === "0")): ?>
                                            <small class="label bg-orange">
                                                待确认收款
                                            </small>
                                        <?php elseif (($value['finance_status'] === "1") && ($value['receivables_status'] === "1")): ?>
                                            <small class="label bg-green">
                                                已完成
                                            </small>
                                        <?php else: ?>
                                            <small class="label bg-gray">
                                                未知
                                            </small>
                                        <?php endif; ?>

                                    </th>
                                    <th><?= $value['pay_time'] ?></th>
                                    <th>
                                        <?php

                                        // 是否确认付款按钮
                                        $is_show_confirm_pay_btn = ($value['finance_status'] === "0");

                                        ?>

                                        <?php if ($is_show_confirm_pay_btn): ?>
                                            <button @click="confirm_pay_money('<?= $value['receivables_id'] ?>', '<?= $value['media_man_name'] ?>')"
                                                    type="button"
                                                    class="btn btn-primary btn-sm margin-r-5">确认付款
                                            </button>
                                        <?php endif; ?>

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

<script>

    const localComputed = {};
    const localMethods  = {
        confirm_pay_money         : function (receivables_id, media_man_name) {

            let message = `确认已经付款给 ${media_man_name} 了吗？`;

            this.$confirm(message, '提示', {
                confirmButtonText: '确定',
                cancelButtonText : '取消',
                type             : 'warning'
            }).then(async () => {
                this.do_confirm_pay_money(receivables_id);
            }).catch(() => {
            });

        },
        do_confirm_pay_money      : async function (receivables_id) {
            try {
                this.loading   = true;
                const url      = '/admin/platform_task_receivables/confirm_pay_money';
                const response = await axios.post(
                    url,
                    {
                        "receivables_id": receivables_id,
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
        prepare_export_receivables: async function () {

            // 找到当前点击的按钮并添加加载样式
            let loading_html = '<i class="el-icon-loading"></i><span>excel生成中...</span>';
            let myselect     = "[button-id='export']";
            $(myselect).addClass('is-loading');
            $(myselect).html(loading_html);

            try {
                const url      = '/admin/platform_task_receivables/prepare_export_receivables';
                const response = await axios.post(url);
                const resData  = response.data;

                if (resData.error_no !== 0) {
                    $(myselect).removeClass('is-loading');
                    $(myselect).html('导出');
                    return this.$message.error(resData.msg)
                }

                let cur_excel_path = resData.data.file_path;

                let params = {
                    cur_excel_path: cur_excel_path,
                    cur_btn_select: myselect,
                };

                this.intervalId = setInterval(this.is_file_write_completed, 1000, params);
            } catch (error) {
                $(myselect).removeClass('is-loading');
                $(myselect).html('导出');

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
        is_file_write_completed   : async function (params) {
            try {
                const url      = '/admin/platform_task_receivables/is_file_write_completed';
                const response = await axios.get(url, {
                    params: {
                        "file_path": params.cur_excel_path,
                    }
                });
                const resData  = response.data;

                if (resData.error_no === 0) {
                    $(params.cur_btn_select).removeClass('is-loading');
                    let loading_html = `<a href="${params.cur_excel_path}" style="color:white;cursor:pointer;">点击下载</a>`;
                    $(params.cur_btn_select).html(loading_html);
                    this.$message.success('excel生成完毕,请点击下载');

                    // 移除定时任务
                    clearInterval(this.intervalId);
                }
            } catch (error) {

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
            loading   : false,// 是否显示加载
            intervalId: 0,
        };
    };

    const Main = {
        data    : data,
        created : function () {},
        methods : localMethods,
        computed: localComputed,
    };
    const Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');

</script>

</html>
