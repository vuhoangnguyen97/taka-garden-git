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
require_once './helper/SessionFunction.php';
require_once './entities/Order.php';
require_once './entities/OrderDetail.php';
require_once './mail/PHPMailer.php';
require_once './mail/SMTP.php';

if (!Context::isLogged()) {
    // Utils::RedirectTo('login.php?retUrl=cart.php');
}
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
    
    if (isset($_POST['hCmd'])) {
        $cmd = $_POST['hCmd']; // X/S
        $masp = $_POST['hProId'];

        if ($cmd == 'X') {
            CartProcessing::removeItem($masp);
        } else if ($cmd == 'S') {
            //$sl = $_POST["sl_".$masp];
            $sl = $_POST["sl_$masp"];
            CartProcessing::updateItem($masp, $sl);
        }
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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
        <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mua hàng thành công</h4>
                </div>
                <div class="modal-body">
                  <p>Mua hàng thành công</p>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="goHome();" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
              </div>
              
            </div>
          </div>
     	<?php include 'header.php'; ?>
		
		<!-- Content -->
		<div class="content">
			
			<div class="content-product senda">

				<div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="breadcrumbs">
                                <p>
                                    <a href="index.php">Trang chủ</a> 
                                    <i class="fa fa-caret-right"></i> 
                                    <a href="#">Giỏ hàng</a> 
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
						 <div class="col-md-12 col-sm-12 col-xs-12">
                         <?php flash( 'message' ); ?>
                         <?php
                        // lập hoá đơn
                            if (isset($_POST['btnLapHD'])) {
								
                                $date = time();
                                $user = isset($_SESSION['CurrentUser']);
                                if( $user == null ){
                                    $hoTen = $_POST['txtHoTen'];
                                    $sdt = $_POST['txtSoDienThoai'];
                                    $email = $_POST['txtEmail'];
                                }else{
                                    $hoTen = '';
                                }
                                $total = 0; $chiTiet = '';
                                foreach ($_SESSION['Cart'] as $masp => $solg) {
                                    $p = Products::loadProductByProId($masp);
                                    if( $p->onsale ){
                                        $amount = $p->salesprice * $solg;
                                    }else{
                                        $amount = $p->getPrice() * $solg;
                                    }
                                    $total += $amount;
                                    Products::UpdateQuantity($masp,$solg);
                                }
                                $o = new Order(-1, $date, $user, $total, $hoTen, $sdt, $email);
                                // var_dump($o);die();
                                $o->add();
                                // thêm nhiều dòng chi tiết hoá đơn

                                $totalSum = 0;
                                foreach ($_SESSION['Cart'] as $masp => $solg) {
                                    $p = Products::loadProductByProId($masp);
                                    if( $p->onsale ){
                                        $amount = $p->salesprice * $solg;
                                        $detail = new OrderDetail(-1, $o->getOrderID(), $masp, $solg, $p->salesprice, $amount);


                                         $chiTiet .= 'Mã SP: '.$p->proId.' Tên sản phẩm: '.$p->proName.' Giá sản phẩm: '.$p->salesprice.' Số lượng : '.$solg.'<br/>';
                                        $totalSum+=$amount;


                                    }
                                    else{
                                        $amount = $p->getPrice() * $solg;
                                        $detail = new OrderDetail(-1, $o->getOrderID(), $masp, $solg, $p->getPrice(), $amount);

                                        $chiTiet .= 'Mã SP: '.$p->proId.' Tên sản phẩm: '.$p->proName.' Giá sản phẩm: '.$p->price.' Số lượng : '.$solg.'<br/>';
                                        $totalSum+=$amount;
                                    }
                                    $detail->add();
                                }

                                flash( 'message', 'Đặt hàng thành công!', 'text-success' );
                                echo '<div class="text-success" id="msg-flash">Đặt hàng thành công!</div>';

                                // call ajax
                                echo "
                                    <script type='text/javascript'>
                                        //email, hoTen, total, details
                                        window.onload = function () { 
                                            initSendEmail('".$email."', '".$hoTen."', '".$total."', '".$chiTiet."'); 
                                        }                                       
                                    </script>
                                ";

                                // nạp lại trang hiện tại

                                $query = $_SERVER['PHP_SELF'];
                                $path = pathinfo($query);
                                $url = $path['basename'];



                                // huỷ giỏ hàng
                                unset($_SESSION['Cart']);
                                //Utils::RedirectTo($url);
								//echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META
								
                            }
                            ?>
                             <div id="modal-email"></divid>
                        <div class="main_body">
                        <form id="fr"  name="fr" method="post" action="">
                            <input type="hidden" id="hCmd" name="hCmd" />
                            <input type="hidden" id="hProId" name="hProId" />
                            <div class="col-md-12">
                                <table class="cart" border="1" cellspacing="0" cellpadding="4">
                                <tbody>
                                    <tr>
                                    <th width="30%" scope="col">Sản phẩm</th>
                                    <th width="15%" scope="col">Giá</th>
                                    <th width="15%" scope="col">Số lượng</th>
                                    <th width="20%" scope="col">Thành tiền</th>
                                    <th width="10%" scope="col">Xóa</th>
                                    <!--<th width="10%" scope="col">Cập nhật</th>-->
                                    </tr>
                                    <?php 
                                    $total = 0;
    								if( !empty( $_SESSION['Cart'] ))  
                                    foreach ($_SESSION['Cart'] as $masp => $soluong){
                                    $p = Products::loadProductByProId($masp);
                                    ?>
                                    <tr align="center">
                                    <td><?php echo $p->getProName(); ?></td>
                                    <td><?php if( $p->onsale ){ echo number_format($p->salesprice); }else{ echo number_format($p->getPrice() ); }?></td>
                                    <td><input type="text" onchange="changeSoLuong(sl_<?php echo $masp; ?>)" id="sl_<?php echo $masp; ?>" name="sl_<?php echo $masp; ?>" style="width: 50px;text-align: center;" value="<?php echo $soluong; ?>" /></td>
                                    <td><?php if( $p->onsale ){ echo number_format($p->salesprice * $soluong); }else{ echo number_format($p->getPrice() * $soluong); }?></td>
                                    <td><img src="imgs/delete-icon.png" width="16" height="16" alt="Delete" style="cursor: pointer" onclick="putProID('X', <?php echo $masp; ?>);"></td>
                                    <!--
                                        <td><img src="imgs/save-icon.png" width="16" height="16" alt="Update" style="cursor: pointer" onclick="putProID('S', <?php //echo $masp; ?>);"></td>
                                    -->
                                    </tr>
                                    <?php 
                                        if( $p->onsale ){
                                            $total += $p->salesprice * $soluong;

                                        }else{

                                            $total += $p->getPrice() * $soluong;
                                        }
                                    }?>

                                    <tr class="text-align-right">
                                        <td colspan="6">
                                            <div><strong style="padding-right: 10px;" id="total" class="bold13orange"">Tổng tiền: 0</strong></div>

                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            
                            <?php if($total != 0) {?>
                                <script type="text/javascript">
                                    window.onload = function () {
                                        onePayPayment(<?php echo $total; ?>);
                                    }
                                </script>
                                <?php if( !Context::isLogged() ){ ?>
                                <div class="col-md-12">
                                    <div>
                                        <p>Nếu chưa có tài khoản, bạn vui lòng để lại thông tin liên hệ (tên, số điện thoại) để shop liên hệ giao hàng</p>
                                    </div>
<!--                                    <div class="col-md-12 order-note">-->
                                        <div class="col-md-4"><input id="txtHoTen" class="tk-width-100" type="text" required="true" name="txtHoTen" placeholder="Họ tên:"/></div>
                                        <div class="col-md-4"><input id="txtSDT" type="number" class="tk-width-100" required="true" name="txtSoDienThoai" placeholder="Số điện thoại:"/></div>
                                        <div class="col-md-4"><input id="txtEmail" type="email" class="tk-width-100" required="true" name="txtEmail" placeholder="Email:"/></div>
<!--                                    </div>-->
                                </div>
                                <?php } ?>
                                <div class="col-md-12">
                                <div class="row tk-margin-t-10">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
<!--                                            <input type="submit" onclick="checkName();" id="btnLapHD" name="btnLapHD" value="Lập hoá đơn" class="blueButton" />-->
                                        </div>
                                        <div class="col-md-6 btnOnePay-div">
                                            <input type="submit" onclick="checkName();" id="btnLapHD" name="btnLapHD" value="Lập hoá đơn" class="blueButton tk-float-left" />
                                            <span id="paypal-button" class="tk-float-left"></span>
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                    </div>
                                </div>


                                    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                                    <script type="text/javascript">
                                        let usd = 0;
                                        function toUSD(vnd){
                                            $.ajax({
                                                type: "GET",
                                                url: "http://localhost:81/taka_garden/js/tygia.xml",
                                                dataType: "xml",
                                                success: function(xml) {
                                                    var currentExchange = xml.getElementsByTagName("Exrate")[18].getAttribute('Sell');
                                                    usd = vnd/currentExchange;
                                                    saveUSD(usd);
                                                    console.log(usd);
                                                },
                                                error: function (error) {
                                                    alert('error');
                                                }
                                            });
                                        }
                                        function saveUSD(usd){
                                            $.ajax({
                                                type: "POST",
                                                url: "http://localhost:81/taka_garden/tygia.php",
                                                data: {usd: usd},
                                                dataType: "html",
                                                success: function(xml) {
                                                    console.log('success');
                                                },
                                                error: function (error) {
                                                    alert('error');
                                                }
                                            });
                                        }
                                        let total = toUSD(<?php echo $total ?>);
                                        console.log('ttt'+total);
                                        setTimeout(renderPayPal
                                            , 3000);

                                        function renderPayPal() {
                                            paypal.Button.render({
                                                env: 'sandbox',

                                                commit: true,

                                                client: {
                                                    sandbox: '<?php echo 'Ae_i1xv2kO9mqWHjvXApWiomrXpAg6d9E5Nr2qxH7sucRcgQIIZITSFMFB2mkO9pUTYr6Mvg4q04TgWp'; ?>',
                                                    //production: '<?php //echo 'Ae_i1xv2kO9mqWHjvXApWiomrXpAg6d9E5Nr2qxH7sucRcgQIIZITSFMFB2mkO9pUTYr6Mvg4q04TgWp'; ?>//'
                                                },

                                                payment: function (data, actions) {

                                                    return actions.payment.create({
                                                        payment: {
                                                            transactions: [
                                                                {
                                                                    amount: {
                                                                        total: <?php echo ($_SESSION['usdTotal'] != '')? $_SESSION['usdTotal'] : 0;?>,
                                                                        currency: '<?php echo 'USD'; ?>'
                                                                    }
                                                                }
                                                            ]
                                                        }
                                                    });
                                                },

                                                onAuthorize: function (data, actions) {
                                                    return actions.payment.execute().then(function () {
                                                        $('#btnLapHD').trigger('click');
                                                    });
                                                }
                                            }, '#paypal-button');
                                        }
                                    </script>
                                <?php } ?>
                            </div>
                                <script type="text/javascript">
                                    function checkName() {
                                        // var nameReg =/^[A-Za-z]*/; // bắt đầu và kết thúc đều từ A-Z, a-z
                                        // var hoTen = document.getElementById("txtHoTen");
                                        // if (nameReg.test(hoTen)) {
                                        //     alert('Bạn phải nhập chữ');
                                        //     return;
                                        // }
                                    }

                                </script>
                        </form>
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
        <script src="js/ajax.js"></script>

        <!-- InstanceBeginEditable name="head" -->
        <script type="text/javascript">
            function putProID(cmd, masp) {
                var result = confirm("Bạn có muốn xóa sản phẩm này?");
                if (result) {
                    $("#hCmd").val(cmd);
                    $("#hProId").val(masp);

                    document.fr.submit();
                }

            }
        </script>
        <script type="text/javascript">
            $("#total").html("Tổng tiền: <?php echo number_format($total); ?>");
        </script>
        <script type="text/javascript">
            function onePayPayment(total) {

                var url = 'http://localhost:8080/PaymentServiceClient/sampleServicesPaymentProxy/Result.jsp?method=13&total16=';
                var total = total;
                var httpRequest = new XMLHttpRequest();
                httpRequest.open('POST', url, true);
                httpRequest.setRequestHeader( 'Access-Control-Allow-Origin', '*');
                httpRequest.setRequestHeader( 'Content-Type', 'application/json' );
                httpRequest.onerror = function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log( 'The data failed to load :(' );
                    console.log(JSON.stringify(XMLHttpRequest));
                };
                httpRequest.onload = function() {
                    console.log('SUCCESS!');
                }

                $.ajax({
                    // controller:
                    url: url+total,
                    // params
                    data: {
                        total: total
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    dataType:"html",
                    type : "GET",
                    crossDomain: true,
                    success: function(data){
                        console.log(data.replace(/&amp;/g, '&'));
                        //window.open(data);
                        $('.btnOnePay-div').append("<a href='"+data+"' id=\"btnOnePay\">"+"<button class='btnOnePay blueButton'>Thanh toán OnePay</button>"+"</a>")
                    }

                });
            }

        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#s1_2').on('keyup paste', updated);
            });


            function updated(){
                setTimeout( function() {
                    var username = $('#s1_2').val();
                },100);
                if(username == "" || username.length < 4){
                    alert("error");
                }
            }


        </script>
        <!-- InstanceEndEditable -->
	</body>
</html>