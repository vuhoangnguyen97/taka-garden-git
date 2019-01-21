<?php
    // Define
    require_once DOCUMENT_ROOT . '/entities/Order.php';
    require_once DOCUMENT_ROOT . '/taka_garden/admin/entities/Products.php';
    require_once DOCUMENT_ROOT . '/entities/User.php';
    require_once DOCUMENT_ROOT . '/entities/categories.php';
    $listOrder = Order::loadAll();
    $listProduct = Products::loadProductsAll();
    $listProductChart = Products::loadProductsChart();
    $listUser = User::loadUserName();
    $listCat = categories::loadAll();
?>
<!-- Lib ChartJS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- End Lib -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo sizeof($listOrder); ?></h3>

                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="index.php?act=orders&type=list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo sizeof($listProduct) ?></h3>

                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="index.php?act=products&type=index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo sizeof($listUser);?></h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="index.php?act=user&type=list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo sizeof($listCat); ?></h3>

                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="index.php?act=cate_products&type=index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <script>
            function drawGraph(){
                var data = '';
                data = <?php echo json_encode($listProductChart, JSON_UNESCAPED_UNICODE ); ?> ;
                console.log(data[5])

                Morris.Bar({
                    element: 'chart',
                    data: [
                        { product: data[0].proName , value: data[0].view},
                        { product: data[1].proName,value: data[1].view},
                        { product: data[2].proName, value: data[2].view},
                        { product: data[3].proName, value: data[3].view},
                        { product: data[4].proName, value: data[4].view}
                    ],
                    xkey: 'product',
                    xLabelAngle: 20,
                    resize: true,
                    padding: 70,
                    barSize: 60,
                    ykeys: ['value'],

                    labels: ['Lượt xem cao nhất'],
                });
            }
        </script>
        <!-- Chart -->
        <div>
            <h4>Top 5 sản phẩm có lượt xem cao nhất</h4>
            <div id="chart" style="height: 350px;"></div>
            <script>drawGraph()</script>
        </div>


        <!--End Chart -->
    </section>
</div>




