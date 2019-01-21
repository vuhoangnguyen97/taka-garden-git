<?php
//    $xml = simplexml_load_string(file_get_contents('https://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx'));
    header('Content-type: text/html; charset=utf-8');

    $url = 'https://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx';
    $data = file_get_contents($url);
    $data = iconv(mb_detect_encoding($data, mb_detect_order(), true), "UTF-8", $data);
    $xmlDoc = new DOMDocument();
    $xmlDoc = load($data);

    //echo $xml;
    $searchNode = $xmlDoc->getElementsByTagName( "Exrate" );

    foreach( $searchNode as $searchNode )
    {
        echo $searchNode;
    }

?>

