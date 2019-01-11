/* Check login and register*/
function ValidateEmail()   
{  
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( $("#txtEmail").val() ))  
  {  
    return (true);  
  }  
    alert("Email không hợp lệ!") ; 
    return (false);  
}  

function KTraDK() {
	var tenDN = $("#txtTenDN").val();
	var pass1 = $("#txtMK").val();
	var pass2 = $("#txtNLMK").val();
	var mail = $("#txtEmail").val();
	
	if (tenDN.length === 0 || pass1.length === 0 || pass2.length === 0 || mail.length === 0) {
		alert("Chưa đủ thông tin.");
		return false;
	}
	else if( pass1 != pass2 )
	{
		alert("Mật khẩu không khớp.");
		return false;
	}
	else if(!ValidateEmail()) return false;
	
	return true;
}

function changeCaptcha() {
	var captcha = document.getElementById("imgCaptcha");
	captcha.src = "captcha/captcha.php?" + Math.random();
}
