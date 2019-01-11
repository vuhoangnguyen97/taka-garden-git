<?php
    require_once  $_SERVER['DOCUMENT_ROOT'] . '/taka_garden/entities/Products.php';
    $arr = json_encode(Products::loadPrice());

?>
<html>
    <head>
        <!-- thư viện js-->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>
    <body onload="get()">

        <h2>THỐNG KÊ NĂM HIỆN TẠI: <?php echo $year = (new DateTime)->format("Y"); ?></h2>
        <!-- Vẽ -->
        <div id="chart" style="height: 350px;"></div>

        <script>
            function get(){
                var data = <?php echo $arr; ?> ;

                Morris.Bar({
                    element: 'chart',
                    data: [
                        { date: 'User 1  ', value: data[0]},
                        { date: 'User 2  ', value: data[1]},
                        { date: 'User 3  ', value: data[2]},
                    ],
                    xkey: 'user',
                    xLabelAngle: 20,
                    resize: true,
                    padding: 70,
                    barSize: 60,
                    ykeys: ['value'],

                    labels: ['Sản phẩm'],
                });
            }

        </script>
    </body>
</html>
