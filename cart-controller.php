<?php
    define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
    session_start();

    if (!isset($_SESSION["IsLogin"])) {
        $_SESSION["IsLogin"] = 0; // chưa đăng nhập
    }
    require_once './entities/categories.php';
    require_once './entities/classify.php';
    require_once './helper/Utils.php';
    require_once './entities/Products.php';
    require_once './helper/CartProcessing.php';
    require_once './helper/Context.php';
    require_once './helper/SessionFunction.php';
    require_once './entities/Order.php';
    require_once './entities/OrderDetail.php';
    require_once './mail/PHPMailer.php';
    require_once './mail/SMTP.php';

    if (!Context::isLogged()) {
        // Utils::RedirectTo('login.php?retUrl=cart.php');
    }
    // đặt hàng
    if (isset($_POST["txtMaSP"])) {
        $masp = $_POST["txtMaSP"];
        $solg = 1;
        CartProcessing::addItem($masp, $solg);
    }

    $categories = categories::loadAll();

    $listProduct1 = Products::loadProductsByCatId(1);
    $listProduct3 = Products::loadProductsByCatId(2);
    $listProduct2 = Products::loadProductsByCatId(3);

    if (!isset($_SESSION['Cart'])) {
        $_SESSION['Cart'] = array();
    }

    if (isset($_POST['hCmd'])) {
        $cmd = $_POST['hCmd']; // X/S
        $masp = $_POST['hProId'];

        if ($cmd == 'X') {
            CartProcessing::removeItem($masp);
        } else if ($cmd == 'S') {
            $sl = $_POST["txtSoLuong"];
            CartProcessing::updateItem($masp, $sl);
        }
    }
?>