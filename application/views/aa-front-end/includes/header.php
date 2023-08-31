<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<?php
	$directoryURI = $_SERVER['REQUEST_URI'];
	$path = parse_url($directoryURI, PHP_URL_PATH);
	$components = array_filter(explode('/', $path));
	$page ='';
	$this->load->helper('static_meta_helper');
	if(ENVIRONMENT=='production'){

		//For Live:
		if(count($components)<=1 && !empty($components))
		{
			if(!isset($components[2]))
			{
				$components[2]=$components[1];
			}
			$page= ((ENVIRONMENT == 'production'))?$components[1]:$components[2];
			echo get_meta_tag($page);	
			
		}
		else if(count($components)>=2 && empty(strpos($directoryURI,'our_students')))
		{		
		    if(strpos($path,'view'))
		    {
		        $page1 = ((ENVIRONMENT == 'production'))?$components[1]:$components[2];
			    $page_url = ((ENVIRONMENT == 'production'))?$components[3]:$components[4];
		        
		    }
		    else{
		        $page1 = (ENVIRONMENT == 'production')?$components[1]:$components[2];
				$page_url = (ENVIRONMENT == 'production')?$components[2]:$components[3];
		    }		
			echo dynamic_meta_tag_data($page1,$page_url);
		}
		else
		{
		    echo get_meta_tag('');	
		}

	}else{
		//For testing:
		if(count($components)<=2 && !empty($components))
		{
			if(!isset($components[2]))
			{
				$components[2]=$components[1];
			}
			$page= ((ENVIRONMENT == 'production'))?$components[1]:$components[2];
			echo get_meta_tag($page);	
			
		}
		else if(count($components)>=3 && empty(strpos($directoryURI,'our_students')))
		{		
		    if(strpos($path,'view'))
		    {
		        $page1 = ((ENVIRONMENT == 'production'))?$components[1]:$components[2];
			    $page_url = ((ENVIRONMENT == 'production'))?$components[3]:$components[4];
		        
		    }
		    else{
		        $page1 = (ENVIRONMENT == 'production')?$components[1]:$components[2];
				$page_url = (ENVIRONMENT == 'production')?$components[2]:$components[3];
		    }		
			echo dynamic_meta_tag_data($page1,$page_url);
		}
		else
		{
		    echo get_meta_tag('');	
		}

	}
		
		if(isset($title)){
	?>
	
	<title><?php echo $title; ?></title>
	<?php } if (DEFAULT_COUNTRY == 38) // canada 
	{ ?>
		<meta name="google-site-verification" content="TWahbwzXobBcHLN37jpUOgPFpl67Di8nEZ4YmKxDK0I" />
		<!-- Google Tag Manager -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', 'GTM-MX66WH3');
		</script>
		<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Organization",
		"name": "Western Overseas Immigration",
		"alternateName": "Western Overseas Canada",
		"url": "https://westernoverseas.ca/",
		"logo": "https://westernoverseas.ca/resources-f/images/logo-sm.webp",
		"contactPoint": {
			"@type": "ContactPoint",
			"telephone": "9025371344",
			"contactType": "customer service",
			"contactOption": "TollFree",
			"areaServed": "CA",
			"availableLanguage": "en"
		},
		"sameAs": [
			"https://westernoverseas.ca/",
			"https://www.facebook.com/westernoverseascanada/",
			"https://www.instagram.com/westernoverseascanada/?hl=en",
			"https://www.youtube.com/WesternOverseas"
		]
		}
		</script>
		<!-- End Google Tag Manager -->
	<?php } else if (DEFAULT_COUNTRY == 13) //Australia
	{ ?>
		<meta name="google-site-verification" content="a9_WHtbaFwjpLNeEwuUYmBxH3Qrnfyf9YSCpG-E6U7M" />
		<!-- Google Tag Manager -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', 'GTM-T479XDP');
		</script>
		<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Organization",
		"name": "Western Overseas Education & Immigration Consultant",
		"alternateName": "Western Overseas Australia",
		"url": "https://westernoverseas.com.au/",
		"logo": "https://westernoverseas.com.au/resources-f/images/logo-sm-aus.png",
		"contactPoint": {
			"@type": "ContactPoint",
			"telephone": "61430 439 035",
			"contactType": "customer service",
			"contactOption": "TollFree",
			"areaServed": "AU",
			"availableLanguage": "en"
		},
		"sameAs": [
			"https://westernoverseas.com.au/",
			"https://www.facebook.com/westernoverseasaustralia/",
			"https://www.instagram.com/westernoverseascanada/?hl=en",
			"https://www.youtube.com/WesternOverseas"
		]
		}
		</script>

		<!-- End Google Tag Manager -->
	<?php } else if (DEFAULT_COUNTRY == 101) { ?>
		<meta name="google-site-verification" content="hHbGzYKUYkKZiPzPYliiuH_vn_FizdVJJTkaGHnHZE0" />
		<!-- Google Tag Manager -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', 'GTM-KWNJTJJ');
		</script>
		<!-- End Google Tag Manager -->
		<!-- START FACEBOOK PIXEL-->
		<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '581914803129863'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=581914803129863&ev=PageView&noscript=1"/>
</noscript>
	<!-- END FACEBOOK PIXEL-->
	<?php } ?>	
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/images/favicon.png'); ?>" rel="shortcut icon" type="image/png">
	<!-- Stylesheet -->
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/bootstrap.min.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/css-plugin-collections.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" media="all">
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/style-main.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<?php
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	?>
	<link rel="canonical" href="<?php echo $url;?>">
	<?php
		$REQUEST_URI_ARRAY=explode('/',$_SERVER['REQUEST_URI']);
		
		//pr($REQUEST_URI_ARRAY,1);
		if(ENVIRONMENT != "production" ) {
			$requestURIIndex = $REQUEST_URI_ARRAY[2];
		}
		else {
			$requestURIIndex = $REQUEST_URI_ARRAY[1];
		}

		if($requestURIIndex =="")
		{
			?>
			<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/home-css/home.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
			<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/home-css/home-comman.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
			<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/home-css/home-responsive.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
			<?php 
		} else {?>
			<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/global.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
			<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/responsive.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
		<?php }
	?>

	
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/bootstrap-select.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/datepicker.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<?php if ($this->session->userdata('student_login_data')) { ?>
		<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/dash-layout.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<?php } ?>
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/wosa-header.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<link href="<?php echo base_url(DESIGN_VERSION_F . '/css/marquee-ticker.css?v=' . JS_CSS_VERSION_F); ?>" rel="stylesheet" type="text/css" media="all">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" rel="stylesheet" type="text/css" media="all">
	<!-- <link href="https://fonts.cdnfonts.com/css/montserrat?styles=17402,17405,17398,17400,17403,17391" rel="stylesheet"> -->
	<script  src="<?php echo base_url(DESIGN_VERSION_F . '/js/jquery-min.js?v=' . JS_CSS_VERSION_F); ?>" type="text/javascript"></script>
	<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200&display=swap" rel="stylesheet"> -->
	<!--Added by Vikram 6 dec 2022 -->
	<?php echo callCommonJSFileVariables(); ?>
	<style>
		body {
			opacity: 0
		}

		body.active {
			opacity: 1
		}
	</style>
</head>

<body>
	<?php if (DEFAULT_COUNTRY == 38) { ?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MX66WH3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<?php } else if (DEFAULT_COUNTRY == 13) { ?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T479XDP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<?php } else if (DEFAULT_COUNTRY == 101) { ?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KWNJTJJ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<?php } else {
	} ?>
	<?php
	$this->load->helper('marketing_helper');
	$marketingPopupsData =  marketing_popup_data(); 
	$marketingPopUp = get_cookie('MarketingPopUp');
	?>
	<?php include_once('login_model.php'); ?>
	<?php include_once('registration_model.php'); ?>
	<?php include_once('forgot_password_model.php'); ?>
	<?php 
	if(count($marketingPopupsData)>0 and $marketingPopUp!='no'){
		include_once('marketing_model.php');
	}
	
	?>
	<div class="wosa-header">
		<div class="top-hdr">
			<div class="w-menu-container">
				<div class="lt-news">
					<div class="marquee-news-ticker">
						<ul>
							<?php
							if(isset($newsData) && !empty($newsData)){
							foreach ($newsData->error_message->data as $d) {
								$date = date_create($d->news_date);
								$news_date = date_format($date, "M d, Y");
								$news_id = $d->id;
							?>
								<li><span><a href="<?php echo base_url('news-detail/' . $d->URLslug); ?>"> <?php echo $d->title; ?> <span class="date"><?php echo $news_date; ?></span></a><span class="bn-seperator">|</span>
									</span></li>
							<?php } 
							}//end if
							?>
						</ul>
					</div>
				</div>
				<div class="rt-btns mob-display-none">
					<ul>
						<?php if (ENVIRONMENT == 'development' or ENVIRONMENT == 'testing') { ?>
							<span style="color: #FFF;">Server Time: <?php echo date("d-M-Y h:i A"); ?></span>
						<?php } ?>
						<?php if (!$this->session->userdata('student_login_data')) { ?>
							<li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login">Login</a></li>
							<li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-register" id="modalregister">Register</a></li>
						<?php } else { ?>
							<li><a title="Go to Dashboard" class="text-yellow" href="<?php echo base_url('our_students/student_dashboard'); ?>"><?php echo 'Hi! ' . $this->session->userdata('student_login_data')->fname; ?></a></li>
							<li class="hide"><a href="<?php echo base_url('our_students/student_dashboard'); ?>">Dashboard</a> </li>
							<li><a title="Logout" class="" href="<?php echo base_url('my_login/student_logout'); ?>">Logout</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="w-header">
			<div class="top-head  w-menu-container">
				<div class="desk-menu">
					<nav class="box-menu">
						<div class="logo"> <a href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(LOGO); ?>" alt="logo" width="233px" height="60px"></a> </div>
						<div class="header-container">
							<div class="menu-header-container">
								<ul id="cd-primary-nav" class="menu">
									<?php if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) { ?>
										<li style="margin-bottom:10px!important;" class="mob-enq-btn no-lg-display" onClick="location.replace('<?php echo base_url('counseling'); ?>');"><a>Book Counseling</a></li>
									<?php } ?>
									<?php if (DEFAULT_COUNTRY == 101) { ?>
										<li style="margin-bottom:10px!important;" class="mob-enq-btn no-lg-display"><a href="https://www.ieltsrealitytest.com/" target="_blank">Reality Test</a></li>
									<?php } ?>
									<?php if (DEFAULT_COUNTRY != 101) { ?>
										<li class="menu-item leave-mouse"> <a href="<?php echo base_url('visa-services'); ?>">Visa &amp; Immigration Services</a></li>
									<?php } ?>
									<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">Online coaching</a>
										<ul class="sub-menu">
											<li class="back"><a href="#">Back</a></li>
											<li class="menu-item leave-mouse"> <a href="<?php echo base_url('online-coaching'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/about-online-pack.svg'); ?>" alt="">About Online Coaching</a> </li>
											<li class="menu-item leave-mouse"> <a href="<?php echo base_url('online-courses'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/online-course.svg'); ?>" alt="">Online Courses</a> </li>
											<li class="menu-item leave-mouse"> <a href="<?php echo base_url('practice-packs'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/practice-pack.svg'); ?>" alt="">Practice Packs</a> </li>
											<li class="menu-item menu-item-has-children header-sub-menu">
										</ul>
									</li>
									<?php if (DEFAULT_COUNTRY == 101) { ?>
										<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/" target="_blank">Visa &amp; Immigration Services</a> </li>
									<?php } ?>
									<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">Resources</a>
										<ul class="sub-menu">
											<li class="back"><a href="#">Back</a></li>
											<li class="menu-item leave-mouse"> <a href="<?php echo base_url('articles'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/article.svg'); ?>" alt="">Articles</a> </li>
											<li class="menu-item leave-mouse"> <a href="<?php echo base_url('test-preparation-material'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/immigration-news.svg'); ?>" alt="">Test Preparation Material</a> </li>
											<?php if (DEFAULT_COUNTRY != 101) { ?>
												<li class="menu-item leave-mouse"> <a href="<?php echo base_url('news'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/immigration-news.svg'); ?>" alt="">Latest Immigration News</a> </li>
											<?php } ?>
											
											<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/english-level-assessment" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/english-level-assesment.svg'); ?>" alt="">English Level Assessment</a> </li>
											<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/visa-assessment" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/study-visa-eligibility.svg'); ?>" alt="">Study Visa Eligibility</a> </li>
											<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/crs-calculator" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/crs-calculator.svg'); ?>" alt="">CRS Calculator</a> </li>
											<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/score-converter" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/score-convertor.svg'); ?>" alt="">Score Convertor</a> </li>
										</ul>
									</li>
									<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">More</a>
										<ul class="sub-menu">
											<li class="back"><a href="#">Back</a></li>
											<div class="submenu-scroll scroll-v">
												<?php if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) { ?>
													<li class="menu-item leave-mouse"> <a href="<?php echo base_url('why-canada'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/why-canada.svg'); ?>" alt="">Why Canada?</a> </li>
												<?php } ?>
												<li class="menu-item leave-mouse"> <a href="<?php echo base_url('gallery'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/gallery.svg'); ?>" alt="">Image Gallery</a> </li>
												<li class="menu-item leave-mouse"> <a href="<?php echo base_url('videos'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/video-gallery.svg'); ?>" alt="">Video Gallery</a> </li>
												<li class="menu-item leave-mouse"> <a href="<?php echo base_url('contact-us'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/contact.svg'); ?>" alt="">Contact</a> </li>
												<li class="menu-item leave-mouse"> <a href="<?php echo base_url('faq'); ?>"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/faq.svg'); ?>" alt="">FAQ</a> </li>
												<?php
												if (!$this->session->userdata('student_login_data') && DEFAULT_COUNTRY != 101) {
												?>
													<li class="menu-item leave-mouse"> <a href="<?php echo base_url(); ?>become-agent" class="blink"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/network.svg'); ?>" alt="">Join Agent Network</a> </li>
												<?php } ?>
												<li class="menu-item menu-item-has-children header-sub-menu"><a href="#"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/partners.svg'); ?>" alt=""><?php if (DEFAULT_COUNTRY == 101) {
																																																					echo "Our Website";
																																																				} else {
																																																					echo "Our Partners";
																																																				} ?></a>
													<ul class="sub-menu">
														<li class="back"><a href="#">Back</a></li>
														<li class="menu-item leave-mouse"> <a class="text-normal" href="https://western-overseas.com/" style="text-transform: lowercase!important;" target="_blank">www.western-overseas.com</a> </li>
														<?php if (DEFAULT_COUNTRY != 101) { ?>
															<li class="menu-item leave-mouse"> <a class="text-normal" href="https://www.westernoverseas.online/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.online</a> </li>
														<?php } ?>
														<?php if (DEFAULT_COUNTRY != 38) { ?>
															<li class="menu-item leave-mouse"> <a class="text-normal" href="https://westernoverseas.ca/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.ca</a> </li>
														<?php } ?>
														<li class="menu-item leave-mouse"> <a class="text-normal" href="https://www.ieltsrealitytest.com/" style="text-transform: lowercase!important;" target="_blank">www.ieltsrealitytest.com</a> </li>
														<li class="menu-item leave-mouse"> <a class="text-normal" href="https://westernoverseas.events/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.events</a> </li>
														<?php if (DEFAULT_COUNTRY != 13) { ?>
															<li class="menu-item leave-mouse"> <a class="text-normal" href="https://westernoverseas.com.au/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.com.au</a> </li>
														<?php } ?>
													</ul>
												</li>
												<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#"><img src="<?php echo base_url(DESIGN_VERSION_F . '/images/social-media.svg'); ?>" alt="">Find us on Social Media</a>
													<ul class="sub-menu">
														<li class="back"><a href="#">Back</a></li>
														<div class="social-media text-center">
															<div><a href="<?php echo FB; ?>" target="_blank"><i class="fa fa-facebook s-icn facebook"></i>Facebook</a></div>
															<div><a href="<?php echo TWT; ?>" target="_blank"><i class="fa fa-twitter s-icn twitter"></i>Twitter</a></div>
															<div><a href="<?php echo INST; ?>" target="_blank"><i class="fa fa-instagram s-icn instagram"></i>Instagram</a></div>
															<div><a href="<?php echo YTD; ?>" target="_blank"><i class="fa fa-youtube s-icn y-tb"></i>Youtube</a></div>
															<?php if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) { ?>
																<div><a href="<?php echo TTK; ?>" target="_blank" style="display: -webkit-box!important;"><img class="s-icn tik" style="padding: 10px;" src="<?php echo base_url(DESIGN_VERSION_F . '/images/tiktok.svg'); ?>" alt=""><span style="margin-top:7px; display: block;"> Tiktok</span></a></div>
															<?php } ?>
														</div>
													</ul>
												</li>
											</div>
										</ul>
									</li>
									<?php
									if ($this->session->userdata('student_login_data')) {
									?>
										<li class="menu-item"><a href="<?php echo base_url('our_students/student_dashboard'); ?>">Dashboard</a> </li>
									<?php }
									if (!$this->session->userdata('student_login_data')) {
									?>
										<li class="menu-item no-lg-display">
											<div class="logn-btn"><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login">Login</a></div>
										</li>
										<li class="menu-item no-lg-display">
											<div class="crt-btn"><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-register">Register</a></div>
										</li>
									<?php } else { ?>
										<li class="menu-item no-lg-display">
											<div class="logn-btn"><a title="Go to Dashboard" class="text-yellow" href="<?php echo base_url('our_students/student_dashboard'); ?>"><?php echo 'Hi! ' . $this->session->userdata('student_login_data')->fname; ?></a></div>
										</li>
										<li class="menu-item no-lg-display">
											<div class="crt-btn"><a title="Logout" class="" href="<?php echo base_url('my_login/student_logout'); ?>">Logout</a></div>
										</li>
									<?php } ?>
									<li class="line"></li>
								</ul>
							</div>
						</div>
						<?php
						if (DEFAULT_COUNTRY != 13 && DEFAULT_COUNTRY != 101) {
						?>
							<div class="rts-btn mob-display">
								<ul>
									<li class="enq-btn" onClick="location.replace('<?php echo base_url('counseling'); ?>');"><a>Book Counseling</a></li>
								</ul>
							</div>
						<?php  } ?>
						<?php
						if (DEFAULT_COUNTRY == 101) {
						?>
							<div class="rts-btn mob-display">
								<ul>
									<a href="https://www.ieltsrealitytest.com/" target="_blank">
										<li class="enq-btn">Reality Test</li>
									</a>
									<!-- <li class="enq-btn" onClick="location.replace('<?php echo base_url('counseling'); ?>');"><a>Reality Test</a></li> -->
								</ul>
							</div>
						<?php  } ?>
						<div class="hamburger-menu">
							<div class="bar"></div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--End Header -->