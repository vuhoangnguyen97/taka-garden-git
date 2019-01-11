<?php
    $feed = file_get_contents("https://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx");
    $xml = simplexml_load_string($feed);

    echo $xml->ExrateList->Exrate [0];
?>

