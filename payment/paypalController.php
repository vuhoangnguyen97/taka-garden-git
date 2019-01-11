<?php
    // libs
    require __DIR__ . '/../bootstrap.php';
    use PayPal\Api\Amount;
    use PayPal\Api\Details;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Payer;
    use PayPal\Api\Payment;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Transaction;

    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    $amout = isset($_POST['total'])? $_POST['total']:0;

    if ($amout > 0){

    }

?>