

jQuery(function($){

	setTimeout(function(){

		$(".selectpicker-auto .bootstrap-select").each(function() {

		   $(this).on("click", function(e) {

			   e.preventDefault();
			   var minw = $(this).width();
			   var hgg = $(this).offset();
			   var offt = hgg.top;
			   var hggwa = $(this).offset();
			   //var countmdl = mdlw - mdlw1;
			   var mdlw = $(".scroll-select-picker").width();
			   var hglft = hggwa.left;
			   var jhd = $(window).width();
			   var mdlw1 = $(this).parents(".modal-dialog").width();
			   var hgdr = jhd - mdlw1;
			   var countmdlfinal = hglft - hgdr/2;
			   if ( $(window).width() > 900 ){
				$(this).children(".dropdown-menu.open").css({"position" : "fixed","top" : offt + 16,"left" : countmdlfinal, "min-width": minw});
				}else{
				$(this).children(".dropdown-menu.open").css({"position" : "fixed","top" : offt + 20,"left" : countmdlfinal, "min-width": minw});
		      }

			   $(".scroll-select-picker .pp-scroll").toggleClass("active");

		   })

	   })

   },1000);


   $(window).click(function(){

	   	$(".scroll-select-picker .pp-scroll").removeClass("active");

   });


})





$(".lecture-video-box  > a").each(function(i) {

    $(".lecture-video-box  > a").on("click", function() {

      $(".lecture-video-box  > a").parent().parent().addClass("popup-active");

      $('.media-start').get(i).currentTime = 0;

    });

  });



 $(".recorded-lecture .close").each(function(i) {

    $(".recorded-lecture .close").on("click", function() {

        $(".recorded-lecture .r-lecture").removeClass("popup-active");

        $('.media-start').get(i).currentTime = 0;

		//$('video.media-start').addClass("dsfjksdk");

    });

  });


  var mclone = $(".marquee-clone > *").clone();
  $(".marquee-clone li:last-child").after(mclone)



console.log = function() {};
var THEMEMASCOT = {};
(function($) {
	"use strict";
	/* ---------------------------------------------------------------------- */
	/* -------------------------- Declare Variables ------------------------- */
	/* ---------------------------------------------------------------------- */
	var $document = $(document);
	var $document_body = $(document.body);
	var $window = $(window);
	var $html = $('html');
	var $body = $('body');
	THEMEMASCOT.isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return(THEMEMASCOT.isMobile.Android() || THEMEMASCOT.isMobile.BlackBerry() || THEMEMASCOT.isMobile.iOS() || THEMEMASCOT.isMobile.Opera() || THEMEMASCOT.isMobile.Windows());
		}
	};
	THEMEMASCOT.isRTL = {
		check: function() {
			if($("html").attr("dir") == "rtl") {
				return true;
			} else {
				return false;
			}
		}
	};
	THEMEMASCOT.initialize = {
		init: function() {
			THEMEMASCOT.initialize.TM_onLoadModal();
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------------ Preloader  ---------------------------- */
		/* ---------------------------------------------------------------------- */
		TM_preLoaderClickDisable: function() {
			var $preloader = $('#preloader');
			$preloader.children('#disable-preloader').on('click', function(e) {
				$preloader.fadeOut();
				return false;
			});
		},
		TM_preLoaderOnLoad: function() {
			var $preloader = $('#preloader');
			$preloader.delay(200).fadeOut('slow');
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------------- Platform detect  --------------------- */
		/* ---------------------------------------------------------------------- */
		TM_platformDetect: function() {
			if(THEMEMASCOT.isMobile.any()) {
				$html.addClass("mobile");
			} else {
				$html.addClass("no-mobile");
			}
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------------ Hash Forwarding  ---------------------- */
		/* ---------------------------------------------------------------------- */
		TM_onLoadModal: function() {
			var $modal = $('.on-pageload-popup-modal');
			if($modal.length > 0) {
				$modal.each(function() {
					var $current_item = $(this);
					var target = $current_item.data('target');
					var timeout = $current_item.data('timeout');
					//var target_id           = target.split('#')[1];
					var delay = $current_item.data('delay');
					delay = (!delay) ? 2500 : Number(delay) + 2500;
					if(!$current_item.hasClass('cookie-enabled')) {
						$.removeCookie(target);
					}
					var t = setTimeout(function() {
						$.magnificPopup.open({
							items: {
								src: target
							},
							type: 'inline',
							mainClass: 'mfp-no-margins mfp-fade',
							closeBtnInside: false,
							fixedContentPos: true,
							removalDelay: 500,
							callbacks: {
								afterClose: function() {}
							}
						}, 0);
					}, Number(delay));
					if(timeout !== '') {
						var to = setTimeout(function() {
							$.magnificPopup.close();
						}, Number(delay) + Number(timeout));
					}
				});
			}
		},
		/* ---------------------------------------------------------------------- */
		/* ----------------------- Background image, color ---------------------- */
		/* ---------------------------------------------------------------------- */
		TM_customDataAttributes: function() {
			$('[data-bg-color]').each(function() {
				$(this).css("cssText", "background: " + $(this).data("bg-color") + " !important;");
			});
			$('[data-bg-img]').each(function() {
				$(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
			});
			$('[data-text-color]').each(function() {
				$(this).css('color', $(this).data("text-color"));
			});
			$('[data-font-size]').each(function() {
				$(this).css('font-size', $(this).data("font-size"));
			});
			$('[data-height]').each(function() {
				$(this).css('height', $(this).data("height"));
			});
			$('[data-border]').each(function() {
				$(this).css('border', $(this).data("border"));
			});
			$('[data-margin-top]').each(function() {
				$(this).css('margin-top', $(this).data("margin-top"));
			});
			$('[data-margin-right]').each(function() {
				$(this).css('margin-right', $(this).data("margin-right"));
			});
			$('[data-margin-bottom]').each(function() {
				$(this).css('margin-bottom', $(this).data("margin-bottom"));
			});
			$('[data-margin-left]').each(function() {
				$(this).css('margin-left', $(this).data("margin-left"));
			});
		},
	};
	THEMEMASCOT.header = {
		init: function() {
			var t = setTimeout(function() {
				THEMEMASCOT.header.TM_scroolToTopOnClick();
				THEMEMASCOT.header.TM_scrollToFixed();
				//				THEMEMASCOT.header.TM_homeParallaxFadeEffect();
			}, 0);
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------------- scrollToTop  ------------------------- */
		/* ---------------------------------------------------------------------- */
		TM_scroolToTop: function() {
			if($window.scrollTop() > 600) {
				$('.scrollToTop').fadeIn();
			} else {
				$('.scrollToTop').fadeOut();
			}
		},
		TM_scroolToTopOnClick: function() {
			$document_body.on('click', '.scrollToTop', function(e) {
				$('html, body').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		},
		/* ---------------------------------------------------------------------------- */
		/* --------------------------- collapsed menu close on click ------------------ */
		/* ---------------------------------------------------------------------------- */
		TM_scrollToFixed: function() {
			$('.navbar-scrolltofixed').scrollToFixed();
			$('.scrolltofixed').scrollToFixed({
				marginTop: $('.header .header-nav').outerHeight(true) + 10,
				limit: function() {
					var limit = $('#footer').offset().top - $(this).outerHeight(true);
					return limit;
				}
			});
		},
	};
	THEMEMASCOT.widget = {
		init: function() {
			THEMEMASCOT.widget.TM_funfact();
			THEMEMASCOT.widget.TM_accordion_toggles();
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------ Funfact Number Counter ---------------------- */
		/* ---------------------------------------------------------------------- */
		TM_funfact: function() {
			var $animate_number = $('.animate-number');
			$animate_number.appear();
			$document_body.on('appear', '.animate-number', function() {
				$animate_number.each(function() {
					var current_item = $(this);
					if(!current_item.hasClass('appeared')) {
						current_item.animateNumbers(current_item.attr("data-value"), true, parseInt(current_item.attr("data-animation-duration"), 10)).addClass('appeared');
					}
				});
			});
		},
		/* ---------------------------------------------------------------------- */
		/* ------------------------- accordion & toggles ------------------------ */
		/* ---------------------------------------------------------------------- */
		TM_accordion_toggles: function() {
			var $panel_group_collapse = $('.panel-group .collapse');
			$panel_group_collapse.on("show.bs.collapse", function(e) {
				$(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").addClass("active");
			});
			$panel_group_collapse.on("hide.bs.collapse", function(e) {
				$(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").removeClass("active");
			});
		},
	};
	THEMEMASCOT.slider = {
		init: function() {
			THEMEMASCOT.slider.TM_owlCarousel();
			THEMEMASCOT.slider.TM_maximageSlider();
			//			THEMEMASCOT.slider.TM_bxslider();
		},
		/* ---------------------------------------------------------------------- */
		/* -------------------------------- Owl Carousel  ----------------------- */
		/* ---------------------------------------------------------------------- */
		TM_owlCarousel: function() {
			$('.owl-carousel-slider').each(function() {
				var data_dots = ($(this).data("dots") === undefined) ? false : $(this).data("dots");
				var data_nav = ($(this).data("nav") === undefined) ? false : $(this).data("nav");
				var data_duration = ($(this).data("duration") === undefined) ? 6000 : $(this).data("duration");
				$(this).owlCarousel({
					rtl: THEMEMASCOT.isRTL.check(),
					autoplay:true,
					autoplayTimeout: data_duration,
					loop: true,
					items: 1,
					// dots: data_dots,
					// nav: data_nav,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					responsive: {
						0: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						480: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						600: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						768: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						},
						960: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						},
						1300: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						}
					}
				});
			});



			$('.owl-carousel-video').each(function() {
				var data_dots = ($(this).data("dots") === undefined) ? false : $(this).data("dots");
				var data_nav = ($(this).data("nav") === undefined) ? false : $(this).data("nav");
				var data_duration = ($(this).data("duration") === undefined) ? 4000 : $(this).data("duration");
				$(this).owlCarousel({
					rtl: THEMEMASCOT.isRTL.check(),
					autoplay: false,
					autoplayTimeout: data_duration,
					loop: true,
					items: 1,
					dots: data_dots,
					nav: data_nav,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					responsive: {
						0: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						480: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						600: {
							items: 1,
							center: true,
							nav: true,
							margin: 15,
							dots: false
						},
						768: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						},
						960: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						},
						1300: {
							items: 1,
							nav: true,
							margin: 15,
							dots: false
						}
					}
				});
			});


			$('.text-carousel').each(function() {
				//				var data_dots = ($(this).data("dots") === undefined) ? false : $(this).data("dots");
				//				var data_nav = ($(this).data("nav") === undefined) ? false : $(this).data("nav");
				//				var data_duration = ($(this).data("duration") === undefined) ? 4000 : $(this).data("duration");
				$(this).owlCarousel({
					rtl: THEMEMASCOT.isRTL.check(),
					autoplay: true,
					autoplayHoverPause: true,
					loop: true,
					items: 1,
					navText: false,
					responsive: {
						0: {
							items: 1,
							center: true,
							nav: false,
							dots: false,
							margin: 15
						},
						480: {
							items: 1,
							center: true,
							nav: false,
							dots: false,
							margin: 15,
						},
						768: {
							items: 1,
							center: true,
							nav: false,
							margin: 15,
							dots: false
						},
						960: {
							items: 1,
							nav: false,
							margin: 15,
							dots: false
						},
						1170: {
							items: 1,
							margin: 15,
							nav: false,
							dots: false
						},
						1300: {
							items: 1,
							margin: 15,
							nav: false,
							dots: false,
						}
					}
				});
			});
		},


		/* ---------------------------------------------------------------------- */
		/* ---------- maximage Fullscreen Parallax Background Slider  ----------- */
		/* ---------------------------------------------------------------------- */
		TM_maximageSlider: function() {
			$('.maximage').maximage({
				cycleOptions: {
					fx: 'fade',
					speed: 1500,
					prev: '.img-prev',
					next: '.img-next'
				}
			});
		}
	};
	/* ---------------------------------------------------------------------- */
	/* ---------- document ready, window load, scroll and resize ------------ */
	/* ---------------------------------------------------------------------- */
	//document ready
	THEMEMASCOT.documentOnReady = {
		init: function() {
			THEMEMASCOT.initialize.init();
			THEMEMASCOT.header.init();
			THEMEMASCOT.slider.init();
			THEMEMASCOT.widget.init();
			THEMEMASCOT.windowOnscroll.init();
		}
	};
	//window on load
	THEMEMASCOT.windowOnLoad = {
		init: function() {
			THEMEMASCOT.initialize.TM_preLoaderOnLoad();
			$window.trigger("scroll");
			//			$window.trigger("resize");
		}
	};
	//window on scroll
	THEMEMASCOT.windowOnscroll = {
		init: function() {
			$window.on('scroll', function() {
				THEMEMASCOT.header.TM_scroolToTop();
			});
		}
	};
	/* ---------------------------------------------------------------------- */
	/* ---------------------------- Call Functions -------------------------- */
	/* ---------------------------------------------------------------------- */
	$document.ready(THEMEMASCOT.documentOnReady.init);
	$window.on('load', THEMEMASCOT.windowOnLoad.init);
	//	$window.on('resize', THEMEMASCOT.windowOnResize.init);
	//call function before document ready
	THEMEMASCOT.initialize.TM_preLoaderClickDisable();
})(jQuery);

// Added by Vikram 6 dec 2022
$(document).ready(function(){
	/* setInterval(function(){
	    refresh_access();
	},
	10000);

    function refresh_access(){
	    $.ajax({
	        url: WOSA_ADMIN_URL + 'cron_tab/cronJob_is_student_correct_logged_in',
	        type: 'post',
	        success: function(response){
	            if(response==1){
	            	// alert(response)
	            }else{
					alertMsg(response,'error');
	            	console.log("response",response);
	            	setTimeout(function(){
        				refresh_finally(response);
   					},4000);//delay is in milliseconds

	            }
	        },
	        beforeSend: function(){
	        }
	    });
    }

    function refresh_finally(response){
    	sessionStorage.clear();
		console.log("url", WOSA_BASE_URL + 'login' + response)
    	window.location.href = WOSA_BASE_URL + 'My_login/student_logout/' + response;
    } */
});

function alertMsg(title,icon){
	var colorName='red';
	if(icon=='success'){
		var colorName='green';
	}
	Swal.fire({
		//toast: true,
		//position: 'top-end',
		icon: icon,
		title:title,
		showConfirmButton: true,
		confirmButtonColor: colorName,
		timer: 3000,
    });
}