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
require_once './entities/Blog.php';
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
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	    <!-- Optional theme -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700&subset=latin-ext" rel="stylesheet">
		
	</head>
	<body class="main">
		<?php include 'header.php'; ?>
		
		<!-- Content -->
		<div class="content">
        	<div class="content-top">
                <div class="container">
                	<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="breadcrumbs">
								<p>
									<a href="home.html">Trang chủ</a> 
									<i class="fa fa-caret-right"></i> 
									<a href="#">Tin tức</a> 
									
								</p>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="sidebar col-md-3 col-sm-3 col-xs-12">
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
                        <div class="col-md-9 col-sm-9 col-xs-12 list-blog-page">
							<div class="border-bg clearfix">
								<div class="box-heading">
									<h1 class="title-head">Tin tức</h1>
								</div>
								<section class="list-blogs blog-main">
                                    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 clearfix">
									<?php 
										$flag = 0;
										$productPerPage = 5;	// số sản phẩm trên 1 trang
										$curPage = 1;
										if(isset($_GET["page"]))
											$curPage=$_GET["page"];
										
										$offset = ($curPage-1)*$productPerPage;

										$alllist = Blog::loadAll();
										$p_catId = -1;
										$list = Blog::loadBlogLimit($offset,$productPerPage);
											
										$numberProduct= count($alllist); // số lượng sản phẩm load được
										$numberPages= ceil($numberProduct/$productPerPage); // số lượng trang
										$n = count($list); //số lượng sản phẩm load lên
										?>
										<?php 
										foreach($list as $item){
										?>
                                        <article class="blog-item">
                                            <div class="blog-item-thumbnail">						
                                                <a href="#">
                                                    <img src="img/blog-image.jpg"/>
                                                </a>
                                            </div>
                                            <div class="blog-item-mains">
                                                <h3 class="blog-item-name">
                                                <a href="#"><?php echo $item->blogName ?></a></h3>
                                                <div class="post-time">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $item->created_at ?> &nbsp;-&nbsp;  <i class="fa fa-commenting-o" aria-hidden="true"></i><?php echo $item->author ?>
                                                </div>
                                                <p class="blog-item-summary margin-bottom-5"><?php echo $item->blogDetail;?></p>
                                            </div>
										</article>
										<?php }?>
									</div>
								</section>
							</div>
                    	</div>
                    </div>
                </div>
            </div>
			
			
			<form id="form1" name="form1" method="post" action="">
			<input type="hidden" id="txtMaSP" name="txtMaSP" />
			</form>	
		</div>
		<!-- /Content -->
		
        <!-- Footer -->
        <?php include 'footer.php'; ?>
		<!-- /Footer -->
        
        <!-- Backtotop -->
        <div class="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
		<!-- /Backtotop -->
            <script src="js/main-script.js"></script>
		<!-- Javascript -->
		<!-- <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script> -->
        
		<script type="text/javascript">
			function putProID(masp) {
				$("#txtMaSP").val(masp);
				document.form1.submit();
			}
		</script>
	</body>
</html>