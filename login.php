<?php
session_start();
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

if (!isset($_SESSION["IsLogin"])) {
    $_SESSION["IsLogin"] = 0; // chưa đăng nhập
}
require_once DOCUMENT_ROOT . '/taka_garden/entities/categories.php';
require_once DOCUMENT_ROOT . '/taka_garden/entities/classify.php';
require_once DOCUMENT_ROOT . '/taka_garden/helper/Utils.php';
require_once DOCUMENT_ROOT . '/taka_garden/entities/Products.php';
require_once DOCUMENT_ROOT . '/taka_garden/helper/CartProcessing.php';
require_once DOCUMENT_ROOT . '/taka_garden/helper/Context.php';

// đặt hàng
if (isset($_POST["txtMaSP"])) {
    $masp = $_POST["txtMaSP"];
    $solg = 1;
    CartProcessing::addItem($masp, $solg);
}

$categories = categories::loadAll();


?>
<?php
if (isset($_POST["btnSearch"])) {
    $value = str_replace("'", "", $_POST['txtSearch']);
    $value = str_replace("  ", "", $value);
    $value = str_replace(" ", "%", $value);

    $url = "search.php?nsx=" . $_POST['selectHSX'] . "&value=" . $value . "&gia=" . $_POST['selectGia'];
    Utils::RedirectTo($url);
}
?>
<?php
// Login

require_once DOCUMENT_ROOT . '/taka_garden/entities/User.php';

if (isset($_POST["btnDangNhap"])) {

    $uid = $_POST["txtTenDN"];
    $pwd = $_POST["txtMK"];

    $u = new User(-1, $uid, $pwd, '', '', time(), 0);
    $loginRet = $u->login();

    if ($loginRet) {
        $_SESSION["IsLogin"] = 1; // đã đăng nhập
        $_SESSION["CurrentUser"] = $uid;

        $remember = isset($_POST["chkGhiNho"]) ? true : false;

        if ($remember) {
            $expire = time() + 15 * 24 * 60 * 60;
            setcookie("UserName", $uid, $expire);
        }

        $url = 'index.php';
        if (isset($_GET["retUrl"])) {
            $url = $_GET["retUrl"];
        }

        Utils::RedirectTo($url);
    } else {

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Taka Graden - Đăng nhập </title>
    <meta charset="UTF-8">
    <meta name="keywords" content="html,htm5,web">
    <meta name="description" content="Do an web, home, trang chu">
    <link href="img/logog.png" rel="shourtcut icon"/>

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"/>

 <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700&subset=latin-ext" rel="stylesheet">

</head>
<body class="main">
<!-- Header -->
<?php include 'header.php'; ?>
<!-- /Header -->

<!-- Content -->
<div class="content">
    <div class="content-product senda">
        <div class="container">
            <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="breadcrumbs">
                                <p>
                                    <a href="index.php">Trang chủ</a> 
                                    <i class="fa fa-caret-right"></i> 
                                    <a href="#">Đăng nhập</a> 
                                </p>
                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="main_body">
                        <form id="fr" name="fr" method="post" action="">
                            <h2 align="center">ĐĂNG NHẬP TÀI KHOẢN</h2>
                            <table id="tableDangNhap" cellpadding="2" cellspacing="0" style="margin-left: 320px;">
								<span style="color:#F00; font-size:16px;padding-left: 219px;">
								<?php if (isset($_GET["true"]) == 1) echo "Đăng ký thành công"; ?> </span>
                               
                               
                                <tr>
                                    <td width="15px">&nbsp;</td>
                                    <td width="120px">Tên đăng nhập:</td>
                                    <td width="200px"><input type="text" name="txtTenDN" id="txtTenDN"/></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mật khẩu:</td>
                                    <td><input type="password" name="txtMK" id="txtMK"/></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="text-align: right"> Ghi nhớ <span style="text-align: right"></span></td>
                                    <td><input name="chkGhiNho" type="checkbox" id="chkGhiNho" value="checked"
                                               width="10%"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><input name="btnDangNhap" type="submit" class="blueButton" id="btnDangNhap"
                                               value="Đăng nhập"/></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3"><span style="color: red"></span></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /Content -->

<!-- Footer -->
<?php include 'footer.php'; ?>
<!-- /Footer -->

<!-- Backtotop -->
<div class="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
<!-- /Backtotop -->

<!-- Javascript -->
<!-- <script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script> -->
<script src="js/main-script.js"></script>
</body>
</html>