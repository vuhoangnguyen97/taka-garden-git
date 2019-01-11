<?php 
require_once DOCUMENT_ROOT . '/entities/Products.php';

if( isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] != '' ){
    $result = Products::delete($_GET['id']);
    
    header("Location: /admin/?act=products&type=index");die();
}
?>