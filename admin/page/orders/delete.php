<?php 
require_once DOCUMENT_ROOT . '/entities/Order.php';

if( isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] != '' ){
    
    $result = Order::delete($_GET['id']);
    
    header("Location: ./?act=orders&type=list");die();
}
?>