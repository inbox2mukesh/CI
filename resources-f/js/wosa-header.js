		(function($) {
    var size;
		//SMALLER HEADER WHEN SCROLL PAGE
    function smallerMenu() {
        var sc = $(window).scrollTop();
        if (sc > 40) {
            $('#header-sroll').addClass('small');
        }else {
            $('#header-sroll').removeClass('small');
        }
    }

    function windowSize() {
        size = $(document).width();
        if (size >= 991) {
            $('body').removeClass('open-menu');
            $('.hamburger-menu .bar').removeClass('animate');
        }
    };

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.bar').removeClass('animate');
            $('body').removeClass('open-menu');
            $('.w-header .desk-menu .header-container .menu .menu-item-has-children a ul').each(function( index ) {
                $(this).removeClass('open-sub');
            });
        }
    });

    $('.hamburger-menu').on('click', function() {
        $('.hamburger-menu .bar').toggleClass('animate');
        if($('body').hasClass('open-menu')){
            $('body').removeClass('open-menu');
			$('.sub-menu').removeClass('open-sub');
        }else{
            $('body').toggleClass('open-menu');
        }
    });

    $('.w-header .desk-menu .header-container .menu .menu-item-has-children > a').on('click', function(e) {
        e.preventDefault();
        if(size <= 991){
            $(this).next('ul').addClass('open-sub');
        }
    });

    $('.w-header .desk-menu .header-container .menu .menu-item-has-children ul .back').on('click', function(e) {
        e.preventDefault();
        $(this).parent('ul').removeClass('open-sub');
    });
    $('body .over-menu').on('click', function() {
        $('body').removeClass('open-menu');
        $('.bar').removeClass('animate');
    });
    $(document).ready(function(){
        windowSize();
    });
    $(window).scroll(function(){
        smallerMenu();
    });
    $(window).resize(function(){
        windowSize();
    });
			
			
			
			

let path = window.location.href;
    $('.w-header .desk-menu .header-container .menu > li').each(function() {
        if (this.href === path) {
            $(this).addClass('menu-active');
        }else{
            $(this).removeClass('menu-active')
        }
    })


if($(window).width() >= 992) {

$('#cd-primary-nav > li.header-sub-menu > a').each(function() {

	$(this).hover(function(event) {

		if ( $(".menu-item-has-children").hasClass("click-active") ){

				$('#cd-primary-nav > li.header-sub-menu > a').removeClass('menu-active');

				$(this).addClass('menu-active');

				$("body").addClass('menu-fixed');

				event.stopPropagation();
		}

	});


	$(this).click(function(event) {
		$('#cd-primary-nav > li.header-sub-menu > a').removeClass('menu-active');

		$(".menu-item-has-children").addClass('click-active');

		if ( $(".menu-item-has-children").hasClass("click-active") ){
			$(this).addClass('menu-active');
			$("body").addClass('menu-fixed');
			event.stopPropagation();
		}
	});


	$(".sub-menu > li > .sub-menu > li > .sub-menu > li > a").click(function(event) {
		$('.header-sub-menu + a').css('display', 'none');
		event.stopPropagation();
	});

	$(window).click(function() {
		$('#cd-primary-nav > li.header-sub-menu > a').removeClass('menu-active');
		$("body").removeClass('menu-fixed');
		$("#cd-primary-nav .menu-item-has-children").addClass("header-sub-menu");
		$(".menu-item-has-children").removeClass('click-active');
	});

});
}


	
			
			
			
})(jQuery);





