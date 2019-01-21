<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
session_start();

if (!isset($_SESSION["IsLogin"])) {
    $_SESSION["IsLogin"] = 0; // chưa đăng nhập
}
require_once './entities/categories.php';
require_once './entities/classify.php';
require_once './helper/Utils.php';
require_once './entities/Products.php';
require_once './helper/CartProcessing.php';
require_once './helper/Context.php';

// đặt hàng
if (isset($_POST["txtMaSP"])) {
	$masp = $_POST["txtMaSP"];
	$solg = 1;
	CartProcessing::addItem($masp, $solg);
}

$categories = categories::loadAll();

$listProduct1 = Products::loadProductsByCatId(1);
$listProduct3 = Products::loadProductsByCatId(2);
$listProduct2 = Products::loadProductsByCatId(3);


?>
<?php
	if (!isset($_SESSION['Cart'])) {
		$_SESSION['Cart'] = array();
	}
?>

<?php 
if(isset($_POST["btnSearch"]))
{
	$value = str_replace("'","",$_POST['txtSearch']);
	$value = str_replace("  ","",$value);
	$value = str_replace(" ","%",$value);

	$url ="search.php?nsx=".$_POST['selectHSX']."&value=".$value."&gia=".$_POST['selectGia'];
	Utils::RedirectTo($url);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Taka Graden </title>
		<meta charset="UTF-8">
		<meta name="keywords" content="html,htm5,web">
		<meta name="description" content="Do an web, home, trang chu">
		<link href="img/logog.png" rel="shourtcut icon" />
		
		<!-- Style CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />

        <!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	    <!-- Optional theme -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700&subset=latin-ext" rel="stylesheet">
	    
	</head>
	<body class="main">
		<!-- Header -->
		<?php include 'header.php'; ?>
		<!-- /Header -->
		
		<!-- Content -->
		<div class="content">

			<div class="content-product senda">

				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="breadcrumbs">
								<p>
									<a href="home.html">Trang chủ</a> 
									<i class="fa fa-caret-right"></i> 
									<a href="#">Tìm kiếm</a> 
									<i class="fa fa-caret-right"></i> 
									<a href="#"><?php echo $noidung = $_GET["value"];  ?></a>
								</p>
							</div>
						</div>
					</div>
                    <div class="row">
						 <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="prod-content">
								<div class="row">
                         <?php 
                            require_once './entities/Search.php';
                            if(isset($_GET["value"]))
                                {
                                    $noidung = $_GET["value"];
                                    $nsx = $_GET["nsx"];
                                    $gia = $_GET["gia"];

                                    $alllist = Search::SearchName($noidung,$nsx,$gia);
                                    $numberProduct = count($alllist);// số lượng sản phẩm load được
                                    
                                if ($numberProduct == 0) {
                                    echo "Không có sản phẩm.";
                                }else {
			
                                    $productPerPage = 12;	// số sản phẩm trên 1 trang
                                    $curPage = 1;
                                    if(isset($_GET["page"]))
                                        $curPage=$_GET["page"];		
                                    $offset = ($curPage-1)*$productPerPage;
									$list = Search::SearchNameLimit($noidung,$nsx,$gia,$offset,$productPerPage);
                                    $numberPages= ceil($numberProduct/$productPerPage); // số lượng trang
                                    $n = count($list); //số lượng sản phẩm load lên
                                        
                                    for ($i = 0; $i < $n; $i++) {
                                        $pid=$list[$i]->getProId();
                                    ?>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<div class="prod-item">
											<div class="item-thumb">
                                            	<span class="label_news "><span class="bf_">Mới</span></span>
												<img src="imgs/products/<?php echo $list[$i]->proId;;?>/1.jpg" alt="Product1">
											</div>
											<div class="item-info">
												<h5><a href="details.php?proID=<?php echo $list[$i]->proId;?>"><?php echo $list[$i]->proName; ?></a></h5>
												<span class="price"><?php echo number_format($list[$i]->getPrice());?> VNĐ</span>
											</div>
											<a href="#" onClick="putProID('<?php echo $list[$i]->proId; ?>')" class="lbutton">Đặt hàng</a>
										</div>
									</div>
                                    <?php 
                                    }
                                }
                            }
                                    ?>
								</div>
							</div>
						 </div>
					</div>
					<div class="row">
                <div class="col-md-12 text-center listPages">
                    <hr/>                                                                                                                                                                
                    <?php
                        if (isset($numberPages)){
                            for ($page=1; $page <= $numberPages; $page++)
                            {
                                if($page == $curPage)
                                    echo "<strong>".$page."</strong> ";
                                else
                                {
                                    echo "<a class='lpage' href='search.php?nsx=".$_GET['nsx']."&value=".$_GET['value']."&loai=".$_GET['loai']."&gia=".$_GET['gia']."&page=".$page."'>".$page."</a> ";
                                }
                            }
                        }

                    ?></div>
                </div>
			</div>
				</div>
                
			
			
		</div>
		<!-- /Content -->
		
        <!-- Footer -->
        <?php include 'footer.php'; ?>
		<!-- /Footer -->
        
        <!-- Backtotop -->
        <div class="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
		<!-- /Backtotop -->
            
		<!-- Javascript -->
		<!-- <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script> -->
        <script src="js/main-script.js"></script>
		<script type="text/javascript">
			function putProID(masp) {
				$("#txtMaSP").val(masp);
				document.form1.submit();
                alert('Mua thành công!');
			}
		</script>
	</body>
</html>