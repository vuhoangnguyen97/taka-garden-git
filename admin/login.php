<?php
    session_start();

    define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

    if (!isset($_SESSION["AdminIsLogin"])) {
        $_SESSION["AdminIsLogin"] = 0; // chưa đăng nhập
    }
    else{
        $url = 'index.php';
        echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
    }
?>
<?php
// Login

require_once DOCUMENT_ROOT .'/taka_garden/entities/User.php';
require_once DOCUMENT_ROOT . '/taka_garden/helper/Utils.php';


if (isset($_POST["btnDangNhap"])) {

    $uid = $_POST["txtUsername"];
    $pwd = $_POST["txtPassword"];

    $u = new User(0, $uid, $pwd, '', '', time(), 0);
    $loginRet = $u->login();

    if ($loginRet) {
        if($u->getPermission() == 1){
            $_SESSION["AdminIsLogin"] = 1; // đã đăng nhập
            $_SESSION["Admin"] = $uid;

            // Rember login
//        $remember = isset($_POST["chkGhiNho"]) ? true : false;
//
//        if ($remember) {
//            $expire = time() + 15 * 24 * 60 * 60;
//            setcookie("UserName", $uid, $expire);
//        }

            $url = 'index.php';
            if (isset($_GET["retUrl"])) {
                $url = $_GET["retUrl"];
            }

            Utils::RedirectTo($url);
        }
        else{
            // Không có quyền truy cập
        }

    } else {

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Taka Garden Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Taka </b>Garden</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Login</p>

        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="txtUsername" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="txtPassword" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">

                <!-- /.col -->
                <div class="col-xs-4">
                    <input name="btnDangNhap" type="submit" class="btn btn-primary btn-block btn-flat" value="Login"/>
                </div>
                <!-- /.col -->
            </div>
        </form>


        <a href="#">Forgot my password ?</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
