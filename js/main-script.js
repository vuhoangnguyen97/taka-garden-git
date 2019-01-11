$(document).ready(function() {
	"use strict";
	
	var windowWidth = $(window).width();
	var windowHeight = $(window).height();

	$('#itemslider').carousel({ interval: 3000 });

	$('.carousel-showmanymoveone .item').each(function(){
	var itemToClone = $(this);

	for (var i=1;i<6;i++) {
	itemToClone = itemToClone.next();

	if (!itemToClone.length) {
	itemToClone = $(this).siblings(':first');
	}

	itemToClone.children(':first-child').clone()
	.addClass("cloneditem-"+(i))
	.appendTo($(this));
	}
	});
	
	/* NAV DROPDOWN */
	function dropdownsNavigation(){
		
		var mainNav = $('.main-navigation');
		var mainNavItems = $('.main-navigation ul li.submenu');
		
		mainNavItems.hover(function(){
			
			var dropdown = $(this).find('>ul');
			if(!dropdown.hasClass('animating') && windowWidth>767){
				
				dropdown.css('opacity',0).css('top','150%').show().animate({opacity:1, top:100+'%'},300);
				
			}
			
		}, function(){
			
			var dropdown = $(this).find('>ul');
			if(!dropdown.hasClass('animating')){
				
				dropdown.addClass('animating').animate({opacity:0, top:150+'%'},300, function(){
					$(this).hide().removeClass('animating');
				});
				
			}
			
		});
	}
	dropdownsNavigation(); // gọi hàm
	
	/* END NAV DROPDOWN */
	
	
	/* JS SLIDER */
	
    $('.slideshow img:gt(0)').hide(); //ẩn tất cả các ảnh trừ ảnh đầu tiên
		setInterval(function(){
		  $('.slideshow :first-child').fadeOut() // ẩn ảnh đang hiện
			 .next('img').fadeIn() // hiện ảnh tiếp theo
			 .end().appendTo('.slideshow');}, // chuyển ảnh đầu tiền về vị trí cuối cùng để slide chọn ảnh tiếp theo để hiện
		  4000); // sau 4 giây sẽ đổi ảnh mới 
	
	/* END JS SLIDER */
	
	/* JS BACKTOTOP */
	function awe_backtotop() { 
		if ($('.back-to-top').length) {
			var scrollTrigger = 100,
				backToTop = function () {
					var scrollTop = $(window).scrollTop();
					if (scrollTop > scrollTrigger) {
						$('.back-to-top').addClass('bt-top');
					} else {
						$('.back-to-top').removeClass('bt-top');
					}
				};
			backToTop();
			$(window).on('scroll', function () {
				backToTop();
			});
			$('.back-to-top').on('click', function (e) {
				e.preventDefault();
				$('html,body').animate({
					scrollTop: 0
				}, 700);
			});
		}
	} window.awe_backtotop = awe_backtotop;
	/* END JS BACKTOTOP */
	
	awe_backtotop();
	
	
	/* JS TABS*/
	
	// Hàm active tab
    function activeTab(obj)
    {
        // Xóa class active tất cả các tab
        $('.tab-wrapper ul li').removeClass('active');
 
        // Thêm class active vào tab đang click
        $(obj).addClass('active');
 
        // Lấy href của tab để show content tương ứng
        var id = $(obj).find('a').attr('href');
 
        // Ẩn hết nội dung các tab đang hiển thị
        $('.tab-item').hide();
 
        // Hiển thị nội dung của tab hiện tại
        $(id).show();
    }
 
    // Sự kiện click đổi tab khác
    $('.tab li').click(function(){
        activeTab(this);
        return false;
    });
 
    // Active tab đầu tiên khi trang web được chạy
    activeTab($('.tab li:first-child'));
	
	/* END JS TABS*/
	
	$('#selectGiaForm').on('change', function(){
		var value = $('#selectGiaForm').val();
		$('#selectGia').val(value);
		
		const params = new URL(location.href).searchParams;
		const catId = params.get('catId');	
		
		window.location.href = window.location.origin + window.location.pathname+'?catId='+catId+'&price='+value+'&page=1';
	})
	$('#selectHSXForm').on('change', function(){
		var value = $('#selectHSXForm').val();
		$('#selectHSX').val(value);
		$('#btnSearch').trigger('click');
	})
});


