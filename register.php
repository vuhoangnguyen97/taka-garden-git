<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
session_start();

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
require_once DOCUMENT_ROOT . '/taka_garden/entities/User.php';

if (isset($_POST["btnDangKy"])) {
    $tendn = $_POST["txtTenDN"];
    $mk = $_POST["txtMK"];
    $hoTen = $_POST["txtHoTen"];
    $email = $_POST["txtEmail"];
    $ngaySinh = $_POST["txtNgaySinh"]; // 28/11/2014

    $dob = strtotime(str_replace('/', '-', $ngaySinh)); //d-m-Y

    $listName = User::loadUserName();

    $flag = true;

    foreach ($listName as $idname) {
        if ($idname == $tendn) {
            $flag = false;
            break;
        }
    }
    if ($flag) {
        $u = new User(-1, $tendn, $mk, $hoTen, $email, $dob, 0);
        $u->insert();
        Utils::RedirectTo("login.php?true=1");
    } else { ?>
        <script> alert("Tên đăng nhập đã tồn tại!");</script>
    <?php }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Taka Graden - Đăng ký tài khoản </title>
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
                                    <a href="#">Đăng ký</a> 
                                </p>
                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="main_body">
                        <form id="fr" name="fr" method="post" action="" onsubmit="return KTraDK();">
                            <h2 align="center">ĐĂNG KÝ TÀI KHOẢN</h2>
                            <table width="362" cellpadding="2" cellspacing="0" id="tableDangKy"
                                   style="margin-left: 310px;">
                               
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tên đăng nhập:</td>
                                    <td><input type="text" name="txtTenDN" id="txtTenDN"/></td>
                                    <td style="text-align: center; color: #FF0000;"> *</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mật khẩu:</td>
                                    <td><input type="password" name="txtMK" id="txtMK"/></td>
                                    <td style="text-align: center; color: #FF0000;">*</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Nhập lại:</td>
                                    <td><input type="password" name="txtNLMK" id="txtNLMK"/></td>
                                    <td style="text-align: center; color: #FF0000;">*</td>
                                </tr>
                                <!--<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                 <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><img src="captcha/captcha.php" id="imgCaptcha" style="cursor: pointer;"
                                             onclick="changeCaptcha()"/></td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr> 
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mã xác nhận:</td>
                                    <td><input type="text" name="captcha-form" id="captcha-form" autocomplete="off"/>
                                    </td>
                                    <td style="text-align: center; color: #FF0000;">*</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="title">Thông tin cá nhân</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>-->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Họ tên:</td>
                                    <td><input type="text" name="txtHoTen" id="txtHoTen"/></td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Email:</td>
                                    <td><input type="text" name="txtEmail" id="txtEmail"/></td>
                                    <td style="text-align: center; color: #FF0000;">*</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Ngày sinh:</td>
                                    <td><input type="text" name="txtNgaySinh" id="txtNgaySinh"/></td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><input name="btnDangKy" type="submit" class="btn blueButton" id="btnDangKy"
                                               value="Đăng ký"/></td>
                                    <td style="text-align: center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
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
<script src="js/check.js"></script>
</body>
</html>