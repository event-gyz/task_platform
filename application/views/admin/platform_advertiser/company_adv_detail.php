<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            公司广告主
            <small>公司广告主审核详情页</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>用户ID：</b> <?= $info['advertiser_id'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>用户名：</b> <?= $info['advertiser_login_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>公司名称：</b> <?= $info['company_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>公司地址：</b> <?= $info['company_address'] ?><br><br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 invoice-col">
                        <b>联系人姓名：</b> <?= $info['content_name'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>联系人电话：</b> <?= $info['content_phone'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>注册时间：</b> <?= $info['create_time'] ?><br><br>
                    </div>

                    <div class="col-sm-3 invoice-col">
                        <b>审核状态：</b> <?= $info['audit_status'] ?><br><br>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <b>账户状态：</b> <?= $info['status'] ?><br><br>
                    </div>
                    <div class="col-sm-3">
                        <b>营业执照：</b>
                        <a href="<?= $info['business_license_pic'] ?>" target="_blank">
                            <img src="<?= $info['business_license_pic'] ?>"
                                 alt="<?= $info['company_name'] ?>"
                                 class="img-thumbnail">
                        </a>
                        <br><br>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">操作日志</h3>
            </div>
            <div class="box-body">

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>用户名</th>
                                <th>操作时间</th>
                                <th>操作事项</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Call of Duty</td>
                                <td>455-981-221</td>
                                <td>El snort testosterone trophy driving gloves handsome</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Need for Speed IV</td>
                                <td>247-925-726</td>
                                <td>Wes Anderson umami biodiesel</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.box-body -->
        </div>

        <div class="row">
            <div class="col-xs-12 col-xs-offset-5">
                <button type="button" class="btn btn-default">
                    返回
                </button>
                <button type="button" class="btn btn-primary" style="margin-left: 15px;">
                    提交
                </button>
            </div>
        </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

</html>
