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
									<a href="#">Giới thiệu</a> 
									
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
								
								<div class="content-info">
									<div class="term-description"><h1 style="text-align: center;"><strong>Sen đá&nbsp;</strong></h1><p><strong>Sen đá </strong>hay<strong>&nbsp;</strong>còn được gọi là<strong> hoa đá</strong>.<strong> Sen đá </strong>không&nbsp;chỉ là một loài cây để bàn đơn thuần , cây hoa đá còn là món quà tặng đầy ý nghĩa cho người thân vào mỗi dịp đặc biệt. Với vẻ đẹp lung linh và sức sống khỏe mạnh cây hoa đá tượng trưng cho sự bền lâu, vĩnh cửu trong tình yêu.</p><h2><strong>Tác dụng của sen đá:</strong></h2><ul><li>Màu xanh của cây&nbsp;giúp tăng cường trí nhớ lên 20% và tăng hiệu quả làm việc lên tới 15%</li><li>Lá <strong>sen đá</strong> có thể hút được tia điện tử từ máy tính, điện thoại giúp bảo vệ sức khỏe tốt hơn.<br> Là món quà tặng rất ý nghĩa cho bạn bè, người thân.</li></ul><h2><strong>Ý nghĩa của sen đá:</strong></h2><p>Suất phát từ việc loài cây đặc biệt này khi ngắt lá cây ra và cắm xuống đất sẽ lên cây mới, hơn nữa lại ít phải chăm sóc và tưới tắm nên có thể để ở mọi môi trường, dù là trong nhà, ngoài trời hay phòng điều hòa kín vẫn khỏe khắn, kiên cường. Vậy nên người ta vẫn ví loài cây này với cái tên ” loài cây bất tử “. Cây mang ý nghĩa về sức sống dẻo dai, trường tồn, ý chí kiên cường, mạnh mẽ không bao giờ bỏ cuộc hay nản chí.</p><h2><strong>Cách chăm sóc cây sen đá:&nbsp;</strong></h2><ul><li>Nước tưới : khi tưới nước cho cây bạn nên tưới vào gốc cây và chọn thời điểm tưới là khi trời mát như ban chiều, bạn sáng hoặc trời vừa mưa xong, một chú ý nho nhỏ là không để nước dính vào lá cây vì như vậy dễ khiến cho cây bị úng lá và chết đi. Duy trì tưới cây một tuần từ 1-2 lần đều đặn là đủ để cây phát triển đẹp, khỏe mạnh.</li><li>Ánh sáng: ánh sáng cho cây nên là ánh sáng mặt trời với cường độ vừa phải, khoảng sáng sớm-9 giờ sáng là khoảng thời gian tuyệt nhất cho chậu cây.</li><li>Gió : Khi ánh sáng giúp cây khỏe, nước và đất giúp cây sống thì thì gió giúp cho cây lên màu tươi đẹp hơn, nếu một cây màu đỏ, vàng, tím qua một thời gian không được tiếp xúc với gió thì sẽ mất màu và trở về màu xanh. hãy đưa cây ra gió gió sẽ giúp bạn có một chậu <strong>sen đá</strong> đẹp tuyệt vời.</li></ul></div>
								</div>
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