function unableScroll() {
	var top = jQuery(document).scrollTop();
	jQuery(document).on('scroll.unable',function (e) {
		jQuery(document).scrollTop(top);
	})
}
function enableScroll() {
	jQuery(document).unbind("scroll.unable");
}
jQuery(document).ready(function($) {
	var nav = $('#nav');
	var navItem = nav.find('li');
	navItem.each(function(){
		if($(this).children('ul').length > 0){
			$(this).children('a').after('<em></em>');
		}
	});

	/***/
	navItem.find('em').click(function(){
		$(this).siblings('ul').stop().slideToggle('fast').parent().siblings().find('ul').stop().slideUp('fast');
	});

	/***/
	$('#navBtn').click(function(){
		if($(this).hasClass('active')){
			enableScroll();
			$(this).removeClass('active');
			nav.stop().fadeOut('fast',function(){
				$(this).removeAttr('style').find('li').removeClass('show');
			});
		}else{
			unableScroll();
			$(this).addClass('active');
			var win = $(window).height() - $('#header').height();;
			nav.height(win).stop().fadeIn('fast',function(){
				$(this).find('li').addClass('show');
			});
		}
	});

	/*Load*/
    if($('.slick-load').length > 0){
        $('.slick-load').each(function(event, slick){
            $(this).on('init',function(){
                $(this).siblings('.loading').remove();
            });
        });
    }
	/**/
	var curSlides = $('#curSlides .slick-load');
	var tabSlides = $('#tabSlides .slick-load');
	if(curSlides.length > 0){	
		curSlides.slick({
			autoplay:false,
			autoplaySpeed:5000,
			speed:500,
	        dots: false,
	        arrows: true,
	        fade:true,
	        vertical: false,
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        pauseOnHover:false,
	        focusOnSelect:true,
	        prevArrow:'<div class="slick-prev"></div>',
	        nextArrow:'<div class="slick-next"></div>',
	        asNavFor:tabSlides,
	        responsive: [
			    {
			      breakpoint: 769,
			      settings: {
			       fade: true,
			        
			      }
			    }
			]
	    });
	}
	
	if(tabSlides.length > 0){	
		tabSlides.slick({
			infinite: true,
			autoplay:false,
			autoplaySpeed:5000,
			speed:500,
	        dots: false,
	        arrows: false,
	        vertical: true,
	        //rows:2,
	        //slidesPerRow:2,
	        slidesToShow: 3,
	        slidesToScroll: 1,	        
	        pauseOnHover:false,
	        focusOnSelect:true,
	        prevArrow:'<div class="slick-prev"></div>',
	        nextArrow:'<div class="slick-next"></div>',
	        centerMode:false,
	        centerPadding:'0',
	        asNavFor:curSlides,
	        responsive: [
			    {
			      breakpoint: 769,
			      settings: {
			        slidesToShow: 3,
			        vertical: false,

			      }
			    }
			]
	    });
	}

	
	/****/
	$('#social .wx').click(function(){
		$(this).children('.qr').stop().fadeToggle('fast');
	});

	/**/
	$('#search .submit').click(function(){
		if($(this).siblings('.text').val() == ''){
			alert('请输入关键词再搜索！');
			return false;
		}
	});
	/**/
	$('#back i').click(function(){
		$('body,html').animate({scrollTop:0},300);
	});

	$(window).resize(function(){
		if($(this).width() > 1024){
			nav.removeAttr('style');
			navItem.on('mouseover mouseleave');
			navItem.mouseover(function(){
				$(this).addClass('on').children('ul').stop().slideDown('fast');
			}).mouseleave(function(){
				$(this).removeClass('on').children('ul').stop().slideUp('fast');
			});
		}else{
			navItem.off('mouseover mouseleave');
			
		}
	}).trigger('resize');

	
});