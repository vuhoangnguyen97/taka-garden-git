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
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
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
				<?php 
				$flag = 0;
				$productPerPage = 20;	// số sản phẩm trên 1 trang
				$curPage = 1;
				if(isset($_GET["page"]))
					$curPage=$_GET["page"];
				
				$offset = ($curPage-1)*$productPerPage;
				
				if(isset($_GET["catId"]))
				{
					if(isset($_GET['price'])){
						$price = $_GET['price'];
					}else{
						$price = 100000000;
					}
					$p_catId = $_GET["catId"];
					$categoryDetail = categories::getCategoryById($p_catId);
					$alllist = Products::loadProductsByCatId($p_catId, $price);
					$list = Products::loadProductsLimit($p_catId,$price,$offset,$productPerPage);
					$flag=1;
				}else
					if(isset($_GET["cId"]))
					{
						$p_cId = $_GET["cId"];
						$alllist = Products::loadProductsByCId($p_cId);
						$list = Products::loadProductsLimitClassify($p_cId,$offset,$productPerPage);
						$flag=2;
					}else
					
					{
						$alllist = Products::loadProductsAll();
						$p_catId = -1;
						$list = Products::loadProductsLimit($p_catId,$offset,$productPerPage);
					}
				$numberProduct= count($alllist); // số lượng sản phẩm load được
				$numberPages= ceil($numberProduct/$productPerPage); // số lượng trang
				$n = count($list); //số lượng sản phẩm load lên
				?>
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="breadcrumbs">
								<p>
									<a href="home.html">Trang chủ</a> 
									<i class="fa fa-caret-right"></i> 
									<a href="#">Danh mục sản phẩm</a> 
									<i class="fa fa-caret-right"></i> 
									<a href="#"><?php echo $categoryDetail->catName ?></a> 
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div>
							<!-- <div class="col-md-6 col-xs-12">
								<select class="form-control" name="selectHSXForm" id="selectHSXForm" >
									<option value="0">Lọc theo loại sản phẩm</option>
									<?php
									for ($i = 0; $i < count($categories); $i++) 
									{
										$name = $categories[$i]->getCatName();
										$id = $categories[$i]->getCatId(); ?>
										<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
									<?php }?>
								</select>
							</div> -->
							<div class="col-md-3 col-xs-12">
								<?php 
									if(isset($_GET['price'])){
										$price = $_GET['price'];
									}else{
										$price = 0;
									}
								?>
								<select class="form-control" name="selectGiaForm" id="selectGiaForm" >
									<option value="0" <?php echo $price == 0 ? 'selected':'' ?> >Lọc theo giá</option>
									<option value="10000000" <?php echo $price == 10000000 ? 'selected':'' ?> >< 10 triệu </option>
									<option value="20000000" <?php echo $price == 20000000 ? 'selected':'' ?> >< 20 triệu </option>
									<option value="30000000" <?php echo $price == 30000000 ? 'selected':'' ?> >< 30 triệu </option>
									<option value="40000000" <?php echo $price == 40000000 ? 'selected':'' ?> >< 40 triệu </option>
									<option value="50000000" <?php echo $price == 50000000 ? 'selected':'' ?> >< 50 triệu </option>
								</select>
							</div>
						</div>
					</div>
                    <div class="row">
						 <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="prod-title">
								<h2><?php echo $categoryDetail->catName ?></h2>
							</div>
							<div class="prod-content">
								<div class="row">
								<?php		
									
									if ($n == 0) {
										echo "<div class='col-md-12'>Không có sản phẩm.</div>";
									} 
									else {
										
										for ($i = 0; $i < $n; $i++) {
											$pid=$list[$i]->getProId();
											?>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<div class="prod-item">
											<div class="item-thumb">
                                            	<span class="label_news "><span class="bf_">Mới</span></span>
												<img src="imgs/products/<?php echo $pid;?>/1.jpg" alt="Product1">
											</div>
											<div class="item-info">
												<h5><a href="details.php?proID=<?php echo $pid;?>"><?php echo $list[$i]->getProName();?></a></h5>
												<span class="price"><?php echo number_format($list[$i]->getPrice());?> VNĐ</span>
											</div>
											<a href="#" onClick="putProID('<?php echo $pid; ?>')" class="lbutton">Đặt hàng</a>
										</div>
									</div>
									<?php }}?>
								</div>
								<div class="row">
									<div class="col-md-12 text-center listPages">
										<hr/>
										<?php 
											for ($page=1; $page <= $numberPages; $page++)
											{
												if($page == $curPage)
													echo "<strong>".$page."</strong> ";
												else
													if($flag == 0)
														echo "<a class='lpage' href='productsByCat.php?page=".$page."'>".$page."</a> ";
													else if($flag == 1)
														echo "<a class='lpage' href='productsByCat.php?catId=".$p_catId."&page=".$page."'>".$page."</a> ";
													else if($flag == 2)
														echo "<a class='lpage' href='productsByCat.php?cId=".$p_cId."&page=".$page."'>".$page."</a> ";

											} //end for
											?>
									</div>
								</div>
							</div>
						 </div>
					</div>
				</div>
			</div>
<!--			<form id="form1" name="form1" method="post" action="">-->
<!--			<input type="hidden" id="txtMaSP" name="txtMaSP" />-->
<!--			</form>	-->
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