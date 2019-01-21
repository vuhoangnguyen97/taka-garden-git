<?php
//    session_start();
//    if(!isset($_SESSION['usdTotal'])){
//        if(isset($_POST['usd'])) {
//            $_SESSION['usdTotal'] = number_format($_POST['usd'], 2);
//            echo  $_SESSION['usdTotal'];
//        }
//    }
//    else{
//        session_destroy();
//        if(isset($_POST['usd'])) {
//            $_SESSION['usdTotal'] = number_format($_POST['usd'], 2);
//            echo  $_SESSION['usdTotal'];
//        }
//    }
    if(isset($_POST['usd'])) {
        session_start();
        $_SESSION['usdTotal'] = number_format($_POST['usd'], 2);
        echo  $_SESSION['usdTotal'];
    }
?>