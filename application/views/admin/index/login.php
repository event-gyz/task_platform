<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>自媒体后台管理系统</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/assets/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/AdminLTE/css/AdminLTE.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:;"><b>自媒体后台</b>管理系统</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>

        <form action="/admin/index/login" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="user_name" class="form-control" placeholder="用户名"
                       value="<?= set_value('user_name') ?>">
                <span class="fa fa-fw fa-user form-control-feedback"></span>
                <span class="help-block"><?php echo form_error('user_name'); ?></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="pwd" class="form-control" placeholder="密码" <?= set_value('pwd') ?>>
                <span class="fa fa-fw fa-lock form-control-feedback"></span>
                <span class="help-block"><?php echo form_error('pwd'); ?></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="/assets/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
    // 如果文本框有错误信息则将其父div设置错误样式
    $('.help-block').each(function (index, value) {
        var has_error = $(value).html();
        if (has_error !== "") {
            $(value).parent().addClass('has-error');
        }
    });
</script>

</body>
</html>
