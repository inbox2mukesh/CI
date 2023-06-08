<!-- Footer -->
<section class="footer-bg footer">
	<div class="container">
		<div class="footer-wrapper4">
			<?php if (DEFAULT_COUNTRY != 101) { ?>
				<div class="column">
					<h4>Visa &amp; Immigration Services</h4>
					<ul>
						<?php foreach ($serviceData->error_message->data as $sd) { ?>
							<li>
								<a href="<?php echo base_url('visa-services/' . $sd->URLslug); ?>">
									<?php echo $sd->enquiry_purpose_name; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php } else {
			?>
				<div class="column">
					<h4>Visa &amp; Immigration Services</h4>
					<ul>
						<li>
							<a href="https://western-overseas.com/" target="_blank">Visa &amp; Immigration Services</a>
						</li>
					</ul>
				</div>
			<?php } ?>
			<div class="column">
				<h4>Online Coaching</h4>
				<ul>
					<li><a href="<?php echo base_url('about-online-coaching'); ?>">About Online Coaching</a></li>
					<li><a href="<?php echo base_url('online-courses'); ?>">Online Courses</a></li>
					<li><a href="<?php echo base_url('practice-packs'); ?>">Practice Packs</a></li>
					<?php if (DEFAULT_COUNTRY == 101) { ?>
						<li><a href="https://www.ieltsrealitytest.com/" target="_blank">Reality Test</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="column">
				<h4>Resources</h4>
				<ul>
					<li><a href="<?php echo base_url('articles'); ?>">Articles</a></li>
					<li><a href="<?php echo base_url('test-preparation-material'); ?>" target="_blank">Test Preparation Material</a></li>
					<?php if (DEFAULT_COUNTRY != 101) { ?>
						<li><a href="<?php echo base_url('news'); ?>">Latest Immigration News</a></li>
					<?php } ?>
					
					<li><a href="https://western-overseas.com/assessment-tools/english-level-assessment" target="_blank">English Level Assessment</a></li>
					<li><a href="https://western-overseas.com/assessment-tools/visa-assessment" target="_blank">Study Visa Eligibility</a></li>
					<li><a href="https://western-overseas.com/assessment-tools/crs-calculator" target="_blank">CRS Calculator</a></li>
					<li><a href="https://western-overseas.com/assessment-tools/score-converter" target="_blank">Score Convertor</a></li>
				</ul>
			</div>
			<div class="column">
				<h4>More</h4>
				<ul>
					<?php if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) { ?>
						<li><a href="<?php echo base_url('why-canada'); ?>">Why Canada?</a></li>
					<?php } ?>
					<li><a href="<?php echo base_url('gallery'); ?>">Image Gallery</a></li>
					<li><a href="<?php echo base_url('videos'); ?>">Video Gallery</a></li>
					<li><a href="<?php echo base_url('contact-us'); ?>">Contact</a></li>
					<li><a href="<?php echo base_url('faq'); ?>">FAQ</a></li>
					<?php
					if (!$this->session->userdata('student_login_data') && DEFAULT_COUNTRY != 101) {
					?>
						<li><a href="<?php echo base_url(); ?>become-agent">Join Agent Network</a></li>
					<?php } ?>
					<li><a href="<?php echo base_url(); ?>sitemap">Sitemap</a></li>
				</ul>
			</div>
		</div>
		<div class="ft-line"></div>
		<div class="row">
			<div class="col-md-6">
				<?php
				if (DEFAULT_COUNTRY == 38) {
					$c = '<p class="font-18 font-weight-600">Western Overseas
								<br> Immigration</p>';
				} elseif (DEFAULT_COUNTRY == 13) {
					$c = '<p class="font-18 font-weight-600">Western Overseas
								<br> Education & Migration Consultant</p>';
				} elseif (DEFAULT_COUNTRY == 101) {
					$c = '<p class="font-18 font-weight-600">Western Overseas
								<br> Study abroad</p>';
				} else {
					$c = '';
				}
				?>
				<?php echo $c; ?>
				<div class="social-media">
					<ul>
						<li><a href="<?php echo FB; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?php echo TWT; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="<?php echo YTD; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
						<li><a href="<?php echo INST; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<?php if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) { ?>
							<li><a href="<?php echo TTK; ?>" target="_blank" cursor-class="arrow"><img src="<?php echo base_url('resources-f/images/tiktok.svg'); ?>" alt="" style="display: inline;padding:5px;" width="22px" height="22px"></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-md-6">
				<div class="top-info">
					<ul>
						<li><a href="tel:+91-9115-017-017"><i class="fa fa fa-phone text-red"></i><?php echo CU_PHONE; ?></a></li>
						<li><a href="mailto:<?php echo CU_EMAIL; ?>"><i class="fa fa-envelope-o text-red"></i><?php echo CU_EMAIL; ?></a></li>
					</ul>
					<div class="terms"><a href="<?php echo base_url(); ?>term-condition">Terms and Condition</a></div>
				</div>
			</div>
			<div class="col-md-12 web">
				<div class="btm-info">
					<h4>Our Websites</h4> <span><a href="https://western-overseas.com/" target="_blank">www.western-overseas.com</a></span>
					<?php if (DEFAULT_COUNTRY != 101) { ?>
						<span><a href="https://www.westernoverseas.online/" target="_blank">www.westernoverseas.online</a></span>
					<?php } ?>
					<span><a href="https://www.westernoverseas.events/" target="_blank">www.westernoverseas.events</a></span>
					<?php if (DEFAULT_COUNTRY == 13) { ?>
						<span><a href="https://westernoverseas.ca/" target="_blank">www.westernoverseas.ca</a></span>
					<?php } else if (DEFAULT_COUNTRY == 101) {
					?>
						<span><a href="https://westernoverseas.ca/" target="_blank">www.westernoverseas.ca</a></span>
						<span><a href="https://westernoverseas.com.au/" target="_blank">www.westernoverseas.com.au</a></span>
					<?php
					} else { ?>
						<span><a href="https://westernoverseas.com.au/" target="_blank">www.westernoverseas.com.au</a></span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section> <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
<div class="txt-limit"></div>
<div class="popupdata video-popup-widget" style="display:none"></div>
<!-- end wrapper -->
<!-- Footer Scripts -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- Footer Scripts -->
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/fixed-footer.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/jquery-2.2.4.min.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo site_url(DESIGN_VERSION_F . '/js/marquee-ticker.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/bootstrap.min.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/custom.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/bootstrap-select.min.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/bootstrap-datepicker.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/sidebar.menu.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/wosa-header.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/jquery-plugin-collection.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(DESIGN_VERSION_F . '/js/polyfills.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(DESIGN_VERSION_F . '/js/webp-hero.bundle.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script> -->
<!--Added by Vikram 6 dec 2022 -->
<script src="<?php echo site_url(DESIGN_VERSION . '/js/sweetalert2.all.min.js?v=' . JS_CSS_VERSION_F); ?>"></script>
<script src="<?php echo site_url(DESIGN_VERSION_F . '/js/common.js?v=' . JS_CSS_VERSION_F); ?>"></script>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<!-- <script type="text/javascript">
	(function() {
		var css = document.createElement('link');
		css.href = '<?php echo base_url(DESIGN_VERSION_F . '/css/font-awesome.min.css?v=' . JS_CSS_VERSION_F); ?>';
		css.rel = 'stylesheet';
		css.type = 'text/css';
		document.getElementsByTagName('head')[0].appendChild(css);
	})();
</script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js"></script>
<script>
  WebFont.load({
    google: {
      families: ['Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200&display=swap']
    }
  });
</script>
<script>
	$(document).ready(function() {
		$("#myModal").modal('show');
	});
	window.onload = function() {
		setTimeout(function() {
			$("body").addClass("active")
		}, 1);
	};
</script>
<script type="text/javascript">
	$(function() {
		if($(".marquee-news-ticker li").length > 0) { 
			$('.marquee-news-ticker').jConveyorTicker({
				force_loop: true
			});
		}
	});
</script>
<?php if (ENVIRONMENT == "production" or ENVIRONMENT == "production_testing") { ?>
	<script type="text/javascript">
		var currenturl = $(location).attr('href');
		$(document).bind("contextmenu", function(e) {
			return false;
		});
		//67-c,86-v,85-u,117-f6,73-i,88-x,83-s,80-p
		document.onkeydown = function(e) {
			if (e.ctrlKey &&
				(
					e.keyCode === 67 ||
					e.keyCode === 85 ||
					e.keyCode === 117 ||
					e.keyCode === 73 ||
					e.keyCode === 88 ||
					e.keyCode === 80 ||
					e.keyCode === 83)) {
				return false;
			} else {
				return true;
			}
		};
		$(document).keypress("u", function(e) {
			if (e.ctrlKey) {
				return false;
			} else {
				return true;
			}
		});
		<?php } ?>
	</script>
	<script type="text/javascript">
		function subtractMinutes(numOfMinutes, date = new Date()) {
			date.setMinutes(date.getMinutes() - numOfMinutes);
			return date;
		}

		function addMinutes(numOfMinutes, date = new Date()) {
			date.setMinutes(date.getMinutes() + numOfMinutes);
			return date;
		}
		const date = new Date();
		<?php
		if (DEFAULT_COUNTRY == 38) { ?>
			let caDate = subtractMinutes(<?php echo TIME_DIFF; ?>, date);
		<?php } else if (DEFAULT_COUNTRY == 13) {
		?>
			let caDate = addMinutes(<?php echo TIME_DIFF; ?>, date);
		<?php
		} else { ?>
			let caDate = addMinutes(<?php echo TIME_DIFF; ?>, date);
		<?php } ?>
		$('.datepicker_dynamic').datepicker({
			format: 'dd-mm-yyyy',
			startDate: caDate,
			todayHighlight: true
		});
		var today = new Date();
		$('.datepickerpack').datepicker({
			format: 'dd-mm-yyyy',
		});
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			startDate: caDate,
			todayHighlight: true
		});
		$('#class_date').datepicker({
			format: 'mm/dd/yyyy',
		}).on("changeDate", function(e) {
			searchClass();
		});
	</script>
	<script>
		/*----Allow alphabets Only--------*/
		$(".allow_alphabets").on("input", function(evt) {
			var self = $(this);
			self.val(self.val().replace(/[^a-zA-Z ]/, ""));
			if ((evt.which < 65 || evt.which > 90)) {
				evt.preventDefault();
			}
		});
		$(".allow_numeric").on("input", function(evt) {
			var self = $(this);
			self.val(self.val().replace(/\D/g, ""));
			if ((evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
			}
		});
		$(".allow_decimal").on("input", function(evt) {
			var self = $(this);
			self.val(self.val().replace(/[^0-9\.]/g, ''));
			if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
			}
		});
		$(".allow_alphabets_numberic").on("input", function(evt) {
			var self = $(this);
			self.val(self.val().replace(/[^A-Za-z0-9]/, ""));
			if ((evt.which < 65 || evt.which > 90)) {
				evt.preventDefault();
			}
		});
		$(".allow_alphabets_numberic_withsomespecialchar").on("input", function(evt) {
			var self = $(this);
			self.val(self.val().replace(/[^A-Za-z0-9\@\&\-.\()\/\ ]/, ""));
			if ((evt.which < 65 || evt.which > 90)) {
				evt.preventDefault();
			}
		});
		/*----validate input value lenght-----*/
		$(".length_validate").change(function() {
			var self = $(this).val();
			var id = $(this).attr('id');
			var id_err = id + '_err'; //create class for message display
			if (self.length < 2) {
				$("#" + id).focus();
				$("." + id_err).text('Please enter minimum 2 characters');
				return false;
			} else {
				$("." + id_err).text('');
			}
		});
		/*--------ends----*/
		$(document).on('change', '.removeerrmessage', function() {
			var id = $(this).attr('id');
			//alert(id);
			var id_err = id + '_err';
			$("." + id_err).html("");
		});
		$(document).on('click', '.removeerrmessage', function() {
			var id = $(this).attr('id');
			//alert(id);
			var id_err = id + '_err';
			$("." + id_err).html("");
		});
		$(document).on('click', '.select_removeerrmessagep', function() {
			var id = $(this).prev().attr('id')
			var id_err = id + '_err';
			$("." + id_err).html("");
		});
		$(document).on('blur', '.checkvalidemail', function() {
			var email = $(this).val();
			var id = $(this).attr('id');
			var id_err = id + '_err'; //create class for message display
			var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,10}\b$/i
			if (email.match(mailformat)) {
				$("#" + id_err).text('');
				return true;
			} else {
				$("#" + id_err).text("Please enter the valid email Id");
				///$("#" + id).focus();
				return false;
			}
		});

		function validate_file_type_PJW(id) {
			var ext = $('#' + id).val().split('.').pop().toLowerCase();
			var id_err = id + '_err';
			if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'webp']) == -1) {
				$('.' + id_err).text('Please upload valid file format');
				$('#' + id).val('');
				$('.checkfile').html('Choose a file...');
				$('#' + id).focus();
				return false;
			} else {
				$('.' + id_err).text('');
			}
		}
		$('.txt-45').each(function(i) {
			$(this).addClass('ct_' + i);
			var jh2 = $('.ct_' + i).text();
			$('.ct_' + i).next().html(jh2);
			var textlenght = $('.ct_' + i).text().length;
			var textcorrect = $('.ct_' + i).text();
			if (textlenght > 42) {
				$('.ct_' + i).next().text($(this).text().substr(0, 42) + '...');
			}
			$(this).next().hover(function() {
				if (textlenght > 42) {
					$('.ct_' + i).addClass("active");
					var hg = $('.ct_' + i).height() + 12;
					$('.ct_' + i).css("top", -hg);
				}
			}, function() {
				$('.ct_' + i).removeClass("active");
			})
		});
		$('.limit-one-line').each(function(i) {
			$(this).addClass('ot_' + i);
			var jh22 = $('.ot_' + i).text();
			$('.ot_' + i).next().html(jh22);
			var textlenght1 = $('.ot_' + i).text().length;
			var textcorrect1 = $('.ot_' + i).text();
			if (textlenght1 > 50) {
				$('.ot_' + i).next().text($(this).text().substr(0, 50) + '...');
			}
			$(this).next().hover(function() {
				if (textlenght1 > 50) {
					$('.ot_' + i).addClass("active");
					var hg1 = $('.ot_' + i).height() + 5;
					$('.ot_' + i).css("top", -hg1);
				}
			}, function() {
				$('.ot_' + i).removeClass("active");
			})
		})
		$(".rcd-lecture").each(function(i) {
			$(this).addClass("c-" + i);
			$(".c-" + i).children().eq(0).on("click", function() {
				$(".popupdata").empty();
				$(this).addClass("c-active");
				$(".c-active").next().addClass("holdata");
				$("body").append("<div class='video-overlay'></div>");
				$('.media-start').get(i).currentTime = 0;
				$(".video-overlay").eq(1).remove();
				$(".video-overlay").eq(2).remove();
				var jh = $(".holdata").html();
				$(".popupdata").append(jh);
				$(".popupdata").css("display", "block");
				$(".close-tag").click(function() {
					$(".video-popup-widget").css("display", "none")
					$(".video-popup-widget").removeClass("holdata");
					$(".video-popup").removeClass("c-active");
					$(".popupdata").css("display", "none");
					$(".video-popup-widget.holdata").css("display", "none");
					$(".video-overlay").remove();
					$(".popupdata").empty();
				})
			});
		});
		$('.change_focus').keyup(function() {
			if (this.value.length == $(this).attr("maxlength")) {
				$(this).parent().next().find('input').focus();
			}
		});
		$('#modalregister').click(function() {
			//alert('pp')
			$('#reg_button').prop('disabled', false);
			$('.complaintBtnDiv_pro').hide();
		});
		$('.btn_reset').click(function() {
			$('.checkout_btn ').prop('disabled', false);
			$('.checkout_btn').text('Checkout');
		});

		function validatedob(data=null, id=null) {
			let dob ='';
			if (data != "") {
				dob = new Date(data);
			}
			else{
				
				dob = $('#hidden_dob').val();//new Date($('#hidden_dob').val());
				// alert(dob);
			}
				const today = new Date();
				// const dob = new Date(data);
				const diffTime = Math.floor(today - dob);
				let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)/31/12); 
				// alert(dob);
				// alert(diffTime);
				if( diffDays < 15 )
				{	
					// alert(dob);
					$('.'+id+'_err').html('Age should be minimum 15 years');			
					$('#'+id).val('');
					return false;
				}
				// else if(isNaN(diffDays))
				// {	
				// 	// alert(dob);
				// 	$('.'+id+'_err').html('Age should be minimum 15 years');			
				// 	$('#'+id).val('');
				// 	return false;
				// }
				else{
					$('.'+id+'_err').html('');
				}
			//}
				// else{
				// 	return true;
				// }
				// var idd = '.' + id + '_err';
				// var dt = data.split("/");
				// if (dt[1] == '02') {
				// 	if (dt[0] > 29) {
				// 		$(idd).text('Please enter the valid date of birth');
				// 		return false;
				// 	} else {
				// 		$(idd).text('');
				// 	}
				// }
				// var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
				// if (pattern.test(data) == false) {
				// 	$(idd).text('Please enter the valid date of birth');
				// 	return false;
				// } else {
				// 	$(idd).text('');
				// }
				// dt = dt[2] + '-' + dt[1] + '-' + dt[0];
				// if (isDateOver15(new Date(dt)) == false) {
				// 	$(idd).text('You must have at least 15 years of age');
				// 	return false;
				// }
			}
		// }

		function isDateOver15(dateOfBirth) {
			const date15YrsAgo = new Date();
			date15YrsAgo.setFullYear(date15YrsAgo.getFullYear() - 15);
			return dateOfBirth <= date15YrsAgo;
		}
		$('.wordcountlimit').keyup(function() {
			maxLength = 20
			var textlen = maxLength - $(this).val().length;
			//$('#rchars').text(textlen);
		});
	</script>
	<style>
		.limit-one-line {
			display: none;
		}
	</style>
	<?php
	global $customJs;
	echo $customJs;
	?>
	<script>
		$(document).on('change', '.countrylist', function() {
			var id = $(this).val();
			if (id != "") {
				$.ajax({
					url: "<?php echo site_url('our_students/ajax_get_state'); ?>",
					type: 'post',
					data: {
						id: id
					},
					success: function(response) {
						$('#state').html(response);
						$('#state').selectpicker('refresh');
						$("#state").trigger("change");
					},
					beforeSend: function() {}
				});
			}
		});
		$(document).on('change', '.statelist', function() {
			var id = $(this).val();
			if (id != "") {
				$.ajax({
					url: "<?php echo site_url('our_students/ajax_get_city'); ?>",
					type: 'post',
					data: {
						id: id
					},
					success: function(response) {
						$('#city').html(response);
						$('#city').selectpicker('refresh');
					},
					beforeSend: function() {}
				});
			}
		});
	</script>
	<script>
		if ($(window).width() >= 500) {
			var browserName = (function(agent) {
				switch (true) {
					case agent.indexOf("edge") > -1:
						return "MS Edge";
					case agent.indexOf("edg/") > -1:
						return "Edge ( chromium based)";
					case agent.indexOf("opr") > -1 && !!window.opr:
						return "Opera";
					case agent.indexOf("chrome") > -1 && !!window.chrome:
						return "Chrome";
					case agent.indexOf("trident") > -1:
						return "MS IE";
					case agent.indexOf("firefox") > -1:
						return "Mozilla Firefox";
					case agent.indexOf("safari") > -1:
						return "Safari";
					default:
						return "other";
				}
			})(window.navigator.userAgent.toLowerCase());
			console.log(browserName);
			if (browserName == 'Chrome' || browserName == 'Mozilla Firefox' || browserName == 'Edge ( chromium based)' || browserName == 'Safari') {
				console.log(browserName);
			} else {
				window.location.href = "https://westernoverseas.ca/canada-development/support_browser";
			}
		}
	</script>
	<!-- <script>
	var webpMachine = new webpHero.WebpMachine()
	webpMachine.polyfillDocument()
</script> -->
	<!-- Body Scroller Remove on modal-->
	<!-- <script>
	var scrollDistance = 0;
	$(document).on("show.bs.modal", ".modal", function () {
	scrollDistance = $(window).scrollTop();
	$("body").css("top", scrollDistance * -1);
	});
	$(document).on("hidden.bs.modal", ".modal", function () {
	$("body").css("top", "");
	$(window).scrollTop(scrollDistance);
	});
</script> -->
	</body>

	</html>