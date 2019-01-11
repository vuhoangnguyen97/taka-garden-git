// Change so luong
function changeSoLuong(txtInput){
    var temp = txtInput.id;
    var id = temp.split("sl_")[1];
    var soLuong = parseInt(txtInput.value);

    var hCmd = 'S';
    // call ajax
    $.ajax({
        url: "http://localhost:81/taka_garden/cart-controller.php",
        data: ({
            hCmd : hCmd,
            hProId:id,
            txtSoLuong: soLuong
        }),
        dataType:"text",
        type: "post",
        success: function(data){
            setTimeout(function()
            {
                location.reload();  //Refresh page
            }, 0.01);
        },
        error: function (dataError) {
            alert('error');
        }
    });
}

function initSendEmail(email, hoTen, total, details ){
    var emailUser = email;
    var hoTen = hoTen;
    var total = total;
    var detail = details;

    console.log(emailUser + ' ' + hoTen + ' ' + total + ' ' + detail);

    $.ajax({
        // controller:
        url: 'http://localhost:81/taka_garden/sendEmail.php',
        // params
        data: {
            hoTen : hoTen,
            detail: detail,
            total:total,
            emailUser: emailUser
        },
        dataType:"html",
        type : "POST",
        success: function(data){
            //alert('success');
            $('#modal-email').append(data)
        }

    });
}

function goHome() {
    window.open("index.php","_self");
}


// Onepay
// btnOnePay is clicked
// function onePayPayment(total) {
//     var url = 'http://localhost:8080/PaymentServiceClient/sampleServicesPaymentProxy/Result.jsp?method=13&total16=';
//     var total = total;
//     $.ajax({
//         // controller:
//         url: url+total,
//         headers: {
//             'Access-Control-Allow-Origin': url
//         },
//         // params
//         data: {
//             total: total
//         },
//         xhrFields: {
//             withCredentials: true
//         },
//         dataType:"html",
//         type : "GET",
//         crossDomain: true,
//         success: function(data){
//             console.log(data.replace(/&amp;/g, '&'));
//             //window.open(data);
//             $('.btnOnePay').append("<a href='"+data+"' id=\"btnOnePay\">"+"THANH TOÁN ONEPAY"+"</a>")
//         }
//
//     });
// }


function paypalPayment(total){
    var total = total;
    var url = '';
    $.ajax({
        url: url,
        data: {
            total: total
        },
        dataType: "html",
        type: "POST",
        success: function(data){
            // Success create transaction
            $('.btnPayPal').append("<a href='"+data+"' id=\"btnOnePay\">"+"THANH TOÁN ONEPAY"+"</a>")

        },
        error: function (error) {
          console.warn(error.toString());
        }
    });
}

function loadTime(){
    var id = 1;
    var url = '';
}

