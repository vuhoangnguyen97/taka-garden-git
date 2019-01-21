<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . './entities/Products.php';
//    $opt = $_GET["opt"];
    $id = isset($_GET['id'])?$_GET['id']:0;

    $detail = Products::loadData($id);
    echo json_encode($detail, JSON_UNESCAPED_UNICODE);
?>