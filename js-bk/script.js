// JavaScript Document

$(document).ready(function(){

	// -----------------Slider Banner
	
	$('.bxslider').bxSlider(
	{
	  adaptiveHeight: true,
	  mode: 'fade',
	  auto: true
	});
	//--end banner

	// Init Smooth Div Scroll	
	$(".productScroll, .spCungLoai, .spCungNsx").smoothDivScroll({
		//autoScrollingMode: "onStart",
		//manualContinuousScrolling: true,
		//mousewheelScrolling: "allDirections",
		touchScrolling: true,
		hotSpotScrolling: true
	});

});



//---------------------- Change class
function Change_Class(My_Element, My_Class) {

	document.getElementById(My_Element).setAttribute("class", My_Class);

}

//---------------------- Change image trang Detail
	function changeImage(imgUrl) {
		var bigImg = document.getElementById("big");
		if (bigImg != null) {
			bigImg.src = imgUrl;
		}
	}
		
	var number = 1;
	
	function timer_tick() {
		
		number++;
		
		var imgName = number + ".jpg";
		changeImage(imgName);
		
		if (number == 6) number = 0;
	}
//---------------------- End Change image product
