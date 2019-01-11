<?php 
    // Controller: params: email, data: hoTen, noiDungChiTiet
    require_once './mail/PHPMailer.php';
    require_once './mail/SMTP.php';
    require_once './mail/Exception.php';
    /* GỬI EMAIL */
    // B1 : Config Cấu hình email : GMail 
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail -> CharSet = "UTF-8";

    $mail->IsSMTP(); //giao thức email: SMTP: Simple mail tranfer protocol
                                               // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "tls";                 
    $mail->Host       = "smtp.gmail.com";      // SMTP server
    $mail->Port       = 587;                   // SMTP port
    $mail->Username   = "chamsockhachhangdtonline@gmail.com";  // username
    $mail->Password   = "Tuminhhau";            // password

    $mail->SetFrom('chamsockhachhangdtonline@gmail.com', 'Taka Garden');

    $mail->Subject    = "[Taka Garden] Chi tiết đơn hàng";

    $content = '';
    $chiTiet = '';
    $emailUser = '';
    $total = 0;

    if (isset($_POST['hoTen']) && isset($_POST['detail']) && isset($_POST['total'])) {
        // vãng lai
        $content = '<h4>Chào bạn: '.$_POST['hoTen'].'</h4>';

        $chiTiet = $_POST['detail'];

        $total = $_POST['total'];
        
        $content.=$chiTiet.'<hr/> Total : '.$total;

        $emailUser = $_POST['emailUser'];

        $mail->MsgHTML($content);


        $mail->AddAddress($emailUser, "");

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            //echo "Message sent!";

            $template = "                                    
             <script>
                 $('#myModal').modal('show');
             </script>
              ";

            echo $template;
        }

    }


?>