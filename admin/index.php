<?php
session_start();
ob_start(); // Cache
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
?>

<?php
    if (!isset($_SESSION['AdminIsLogin'])){
        $url = 'login.php';
        echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
    }
    else{
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="assets/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Date picker-->



    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
          href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Taka</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Taka </b>Garden</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="assets/dist/img/photo2.png" class="user-image" alt="User Image">
                            <span class="hidden-xs">Diemntb</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="assets/dist/img/photo2.png" class="img-circle" alt="User Image">

                                <p>
                                    Diemntb - Web Developer
                                    <small>Member since Nov. 2018</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="assets/dist/img/photo2.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>Diemntb</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="/taka_garden/admin">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Products</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/taka_garden//admin?act=products&type=index"><i class="fa fa-circle-o"></i> List</a></li>
                        <li><a href="/taka_garden//admin?act=products&type=add"><i class="fa fa-circle-o"></i> Add</a></li>
                        <li><a href="/taka_garden//admin?act=cate_products&type=index"><i class="fa fa-circle-o"></i> Categories</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Orders</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/taka_garden//admin?act=orders&type=list"><i class="fa fa-circle-o"></i> List</a></li>
                        </li>
                    </ul>
                </li>
                <!-- User List -->
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Users</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/taka_garden/admin?act=user&type=list"><i class="fa fa-circle-o"></i> List</a></li>
                        </li>
                    </ul>
                </li>
                <!-- Products có webix -->
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Products using Webix</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/taka_garden/admin?act=orderwebix&type=list"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <?php
    switch ($act) {
        case 'products':
            switch ($type) {
                case 'add':
                    include "page/products/add.php";
                    break;
                case 'edit':
                    include "page/products/edit.php";
                    break;
                case 'delete':
                    include "page/products/delete.php";
                    break;
                default:
                    include "page/products/index.php";
                    break;
            }
            break;
        case 'cate_products':
            switch ($type) {
                case 'add':
                    include "page/products/cate/add.php";
                    break;
                case 'edit':
                    include "page/products/cate/edit.php";
                    break;
                default:
                    include "page/products/cate/index.php";
                    break;
            }
            break;
        case 'orders':
        switch ($type) {
            case 'list':
                include "page/orders/list.php";
                break;
            case 'edit':
                include "page/orders/edit.php";
                break;
            case 'delete':
                include "page/orders/delete.php";
                break;
            default:
                include "page/orders/list.php";
                break;
        }
        break;
        case 'user':
            switch ($type) {
                case 'list':
                    include "page/users/list.php";
                    break;
                default:
                    include "page/users/list.php";
                    break;
            }
            break;
        case 'orderwebix':
            switch ($type) {
                case 'list':
                    include "page/order-webix/list.php";
                    break;
                default:
                    include "page/order-webix/list.php";
                    break;
            }
            break;
        default:
            include 'page/index.php';
            break;
    }
    ?>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2019 <a href="#">Taka Garden</a>.</strong> All rights
        reserved.
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="assets/bower_components/raphael/raphael.min.js"></script>
<script src="assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="assets/bower_components/moment/min/moment.min.js"></script>
<script src="assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- CK Editor -->
<script src="assets/bower_components/ckeditor/ckeditor.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<script src="assets/admin.js"></script>

<!-- Date picker js -->
<script type="text/javascript"
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
</script>
<script type="text/javascript"
        src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
</script>
<script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
</script>
<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
    });
</script>

</body>
</html>
<?php }?>
<?php ob_end_flush(); ?>