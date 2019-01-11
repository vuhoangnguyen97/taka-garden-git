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
if (isset($_POST["btnDatHang"])) {
	$masp = $_GET["proID"];
	$solg = $_POST["txtSoLuong"];
	CartProcessing::addItem($masp, $solg);
}

$categories = categories::loadAll();
$p_proId = $_GET["proID"];
Products::AddView($p_proId);
$product = Products::loadProductByProId($p_proId);

$relatedProduct  = Products::loadProductsByCatId($product->catId);
?>

<?php
	if (!isset($_SESSION['Cart'])) {
		$_SESSION['Cart'] = array();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Taka Graden - Products </title>
		<meta charset="UTF-8">
		<meta name="keywords" content="html,htm5,web">
		<meta name="description" content="Do an web, products, san pham">
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
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=528108377592791&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
		<?php include 'header.php'; ?>
		
		<!-- Content -->
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="breadcrumbs">
							<p>
								<a href="index.php">Trang chủ</a> 
								<i class="fa fa-caret-right"></i> 
								<a href="#">Sản phẩm</a> 
								<i class="fa fa-caret-right"></i>
								<?php echo $product->proName ?>
							</p>
						</div>
					</div>
				</div>
				<div class="row">
               		<div class="sidebar col-md-3 col-sm-3 col-xs-12">
						<div class="side-box dmsp">
							<div class="side-box-heading">
								<i class="fa fa-folder-open-o" aria-hidden="true"></i>
								<h4>Danh mục sản phẩm</h4>
							</div>
							<div class="side-box-content">
								<ul>
                                    <?php
                                        for ($i = 0, $n = count($categories); $i < $n; $i++) 
                                        {
                                            $name = $categories[$i]->getCatName();
                                            $id = $categories[$i]->getCatId();
                                    ?>
                                    <li><a href="productsByCat.php?catId=<?php echo $id; ?>"><?php echo $name; ?></a></li>
                                    <?php
                                    }
                                    ?>
									<li><a href="#">Sản phẩm bán chạy</a></li>
									<li><a href="#">Sản phẩm nổi bật</a></li>
									<li><a class="purple" href="#">Tất cả sản phẩm</a></li>
								</ul>
							</div>
						</div>
						
						<div class="side-box related-prod">
							<div class="side-box-heading">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<h4>Sản phẩm liên quan</h4>
							</div>
							<div class="side-box-content">
								<table class="related-table">
									<tbody>
                                        <?php 
                                        for($i = 0; $i < 4; $i++){
                                            
                                        ?>
										<tr>
											<td class="product-thumbnail"><a href="details.php?proID=<?php echo $relatedProduct[$i]->proId;?>"><img src="imgs/products/<?php echo $relatedProduct[$i]->proId;;?>/1.jpg" alt="Product1"></a></td>
											<td class="product-info">
												<p><a href=""><?php echo $relatedProduct[$i]->proName?></a></p>
												<span class="price"> <?php echo number_format($relatedProduct[$i]->price) ?> VND</span>
											</td>
										</tr>
                                        <?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9">
                        	<div class="details-product">
                                <div class="col-md-6 images-pro">
                                  <abbr title="Hoa xương rồng"><img src="imgs/products/<?php echo $product->proId;;?>/1.jpg" style="max-width:400px"></abbr>
                                </div>
                                <div class="col-md-6 details-pro">
									<h2><?php echo $product->proName ?></h2>
									<?php if($product->onsale == 1){ ?>
										<p class="price-pro">Giá: <span><?php echo number_format($product->salesprice); ?> VND </span><del><?php echo number_format($product->price); ?> VND</del></p>
									<?php }else{ ?>
										<p class="price-pro">Giá: <span><?php echo number_format($product->price); ?> VND </span></p>
									<?php } ?>
									<p class="in-stock">Tình trạng: <?php echo $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' ?></p>
                                    <?php 
                                    if( $product->quantity > 0 ){
                                    ?>
										<form id="fr"  name="fr" method="post" action="">
											<p class="number">Số lượng: <input type="number" id="txtSoLuong" name="txtSoLuong" min="1" style="width:50px" value="1"/></p>
                                            <div class="fb-like" data-href="http://localhost:81/taka_garden/details.php?proID=<?php echo $product->getProId(); ?>" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true">

                                            </div><br/><br/>
                                            <input id="btnDatHang" name="btnDatHang" type="submit" value="Thêm vào giỏ hàng " class="blueButton" />
										</form>
                                    <?php }?>
                                </div>
                         	</div>
							<div class="tab-wrapper">
								<ul class="tab">
									<li>
										<a href="#tab-main-info">Chi tiết sản phẩm</a>
									</li>
									<li>
										<a href="#tab-image">Hình ảnh</a>
									</li>
									<li>
										<a href="#tab-seo">Đánh giá sản phẩm</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-item" id="tab-main-info">
										<?php echo $product->fullDes; ?>
									</div>
									<div class="tab-item" id="tab-image">
										Hình ảnh về cây xương rồng...
									</div>
									<div class="tab-item" id="tab-seo">
                                        <div class="fb-comments" style="width: 100%" data-href="http://localhost:81/taka_garden/details.php?proID=<?php echo $product->getProId();?>" data-numposts="5">

                                        </div>
									</div>
								</div>
							</div>	
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
		<script src="js/main-script.js"></script>
		<!-- <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
         -->
		
	</body>
</html>