<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . './entities/Products.php';
    $opt = $_GET["opt"];
    $id = isset($_GET['id'])?$_GET['id']:0;


    switch ($opt){
        case 1: // List
            $product = Products::loadProductsAll();
            $productJSON = json_encode($product, JSON_UNESCAPED_UNICODE);
            echo $productJSON;
            break;
        case 2: // Detail
            $detail = Products::loadProductByProId($id);
            echo json_encode($detail, JSON_UNESCAPED_UNICODE);
            break;
    }
?>