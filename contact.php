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
		
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="breadcrumbs">
							<p>
								<a href="home.html">Trang chủ</a> 
								<i class="fa fa-caret-right"></i> 
								<a>Liên hệ</a>
							</p>
						</div>
					</div>
				</div>
                <div class="contact-box">
                	<div class="row">
                        <div class="col-md-5">
                            <div class="img-contact">
                                <img src="img/image-contact.jpg" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="reservation-page-form"> 
                                <div class="title-section">
                                    <div class="top-section">
                                        <p>Chào mừng tới Taka Graden</p>
                                    </div>
                                    
                                    <h1 class="title">Liên hệ với chúng tôi</h1>
                                </div>
                                <ul>
                                    <li>Thứ 2 đến thứ 6 <span>6:00 AM - 22:00 PM</span></li>
                                    <li>Thứ 7 đến Chủ nhật <span>6:00 AM - 12:00 AM</span></li>
                                </ul>
                                <h2 class="phone"><a href="tel:01202582956">01202582956</a></h2>
                                <h3><span>Đặt hàng ngay</span></h3>
                                <form accept-charset="UTF-8" action="javascript:alert('Thông tin đặt hàng gửi đi thành công!');" id="contact" method="post">
                                <div id="reservation-form">
                                    <div class="reservation-page-input-box">
                                        <label>Tên của bạn</label>
                                        <input type="text" class="form-control" placeholder="Tên của bạn"  id="form-name"  required>
                                    </div>
                                    
                                    <div class="reservation-page-input-box">
                                        <label>Số điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Số điện thoại của bạn"  id="form-phone"  required>
                                    </div>
                                    <div class="reservation-page-input-box">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email của bạn" id="form-email"  required>
                                    </div>
                                    <div class="reservation-page-input-box">
                                        <label>Số lượng mua</label>
                                        <input type="number" min="1" class="form-control rt-date" placeholder="2 chậu"  id="form-quantity"  required>
                                    </div>
                                    
                                    <div class="reservation-page-input-box" style="width: 100%;">
                                        <label>Lời nhắn</label>
                                        <input type="text" class="form-control rt-date" placeholder="Lời nhắn"  id="form-date"  required >
                                    </div>
                                    <div class="reservation-booking">
                                        <button type="submit" class="book-now-btn">Gửi ngay</button>
                                    </div>
                                </div>
                                </form>                              
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.935728531272!2d106.675624813946!3d10.816230592294497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e19559e523%3A0x8e4133bdb1373cc9!2zMzcxIE5ndXnhu4VuIEtp4buHbSwgUGjGsOG7nW5nIDMsIEfDsiBW4bqlcCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1523784661993" width="100%" height="300px" frameborder="0" style="border:0; border-radius:3px" allowfullscreen></iframe>
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
        <script src="js/main-script.js"></script>
		<script type="text/javascript">
			function putProID(masp) {
				$("#txtMaSP").val(masp);
				document.form1.submit();
			}
		</script>
	</body>
</html>