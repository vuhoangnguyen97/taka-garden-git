<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/taka_garden/admin/entities/Products.php';
    require_once $_SERVER['DOCUMENT_ROOT']. '/taka_garden/admin/entities/Order.php';
//    $opt = $_GET["opt"];
    $id = isset($_GET['id'])?$_GET['id']:0;

//    $p = new Products();

    $detail = Products::loadData($id);

    $pivotDate;
    echo json_encode($detail, JSON_UNESCAPED_UNICODE);
?>