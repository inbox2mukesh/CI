<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Online/Offline english learning" />
    <meta name="keywords" content="VISA, Canada, Study abroad, Immigration" />
    <meta name="author" content="" />
    <meta name="google-site-verification" content="" />
    <title><?php echo $title;?></title>
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/images/favicon.png');?>" rel="shortcut icon" type="image/png">
    <!-- Stylesheet -->
	<link href="<?php echo base_url(DESIGN_VERSION_F.'/css/bootstrap.min.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
	<!-- <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/font-awesome.min.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all"> -->
	<link href="<?php echo base_url(DESIGN_VERSION_F.'/css/css-plugin-collections.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/style-main.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/global.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/responsive.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/bootstrap-select.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/datepicker.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/dash-layout.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/wosa-header.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo base_url(DESIGN_VERSION_F.'/css/news-ticker-min.css?v='.JS_CSS_VERSION_F);?>" rel="stylesheet" type="text/css" media="all">

    <script src="<?php echo base_url(DESIGN_VERSION_F.'/js/jquery-min.js?v='.JS_CSS_VERSION_F);?>" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200&display=swap" rel="stylesheet">

	<!--Added by Vikram 6 dec 2022 -->
    <?php echo callCommonJSFileVariables(); ?>
    <style>
	    body {opacity: 0}
	    body.active {opacity: 1}
	    /* .news-headline {overflow: hidden;font-size: 12px;display: list-item;height: 26px;line-height: 26px;}
	    .news-headline span {margin: 5px 0px;line-height: 23px;}
	    .news-headline span a {color: #fff;}
	    .news-headline span a span.date {font-style: italic;font-weight: bold;font-size: .70rem;margin-left: 10px;}
	    .news-headline span.spacer {color: rgb(255, 255, 255, 0.3); margin: 0px 10px;} */
    </style>
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
(function() { var css = document.createElement('link'); css.href = '<?php echo base_url(DESIGN_VERSION_F.'/css/font-awesome.min.css?v='.JS_CSS_VERSION_F);?>'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); 
</script>
</head>
<body>
	<?php include_once('login_model.php');?>
	<?php include_once('registration_model.php');?>
	<?php include_once('forgot_password_model.php');?>
			<div class="wosa-header">
				<div class="top-hdr">
					<div class="w-menu-container">
						<div class="lt-news">

						<div class="js-conveyor-1">

	<ul>
										<?php
											foreach ($newsData->error_message->data as $d){
											$date=date_create($d->news_date);
											$news_date = date_format($date,"M d, Y");
											$news_id = $d->id;
										?>
											<li><a href="<?php echo base_url('news_article/index/'.$news_id);?>"> <?php echo $d->title;?> <span class="date"><?php echo $news_date;?></span></a><span class="bn-seperator">|</span>
												</li>
										<?php }?>
									</ul>




  </div>



							<!-- <div class="breaking-news-ticker bn-effect-scroll bn-direction-ltr" id="newsTicker">
								<div class="bn-news">
									<ul class="marquee-clone">
										<?php
											foreach ($newsData->error_message->data as $d){
											$date=date_create($d->news_date);
											$news_date = date_format($date,"M d, Y");
											$news_id = $d->id;
										?>
											<li><a href="<?php echo base_url('news_article/index/'.$news_id);?>"> <?php echo $d->title;?> <span class="date"><?php echo $news_date;?></span></a><span class="bn-seperator">|</span>
												</li>
										<?php }?>
									</ul>
								</div>
							</div> -->
						</div>
								<div class="rt-btns mob-display-none">
									<ul>
										<?php if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){ ?>
											<span style="color: #FFF;">Server Time: <?php echo date("d-M-Y h:i A"); ?></span>
										<?php } ?>
										<?php if(!$this->session->userdata('student_login_data')){ ?>
											<li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login">Login</a></li>
											<li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-register" id="modalregister">Register</a></li>
											<?php } else {?>
												<li><a title="Go to Dashboard" class="text-yellow" href="<?php echo base_url('our_students/student_dashboard');?>"><?php echo 'Hi! '.$this->session->userdata('student_login_data')->fname;?></a></li>
												<li class="hide"><a href="<?php echo base_url('our_students/student_dashboard');?>">Dashboard</a> </li>
												<li><a title="Logout" class="" href="<?php echo base_url('my_login/student_logout');?>">Logout</a></li>
											<?php }?>
									</ul>
								</div>
							</div>
						</div>
						<div class="w-header">
							<div class="top-head  w-menu-container">
								<div class="desk-menu">
									<nav class="box-menu">
										<div class="logo"> <a href="<?php echo base_url('');?>"><img src="<?php echo base_url(LOGO);?>" alt="logo" ></a> </div>
										<div class="header-container">
											<div class="menu-header-container">
										
												<ul id="cd-primary-nav" class="menu">
																									
													<li style="margin-bottom:10px!important;" class="mob-enq-btn no-lg-display" onClick="location.replace('<?php echo base_url('counseling');?>');"><a>Book Counseling</a></li>	
													<li class="menu-item leave-mouse"> <a href="<?php echo base_url('visa_services');?>">Visa &amp; Immigration Services</a> </li>
													<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">Online coaching</a>
														<ul class="sub-menu">
															<li class="back"><a href="#">Back</a></li>
															<li class="menu-item leave-mouse"> <a href="<?php echo base_url('online_courses');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/online-course.svg');?>" alt="">Online Course</a> </li>
															<li class="menu-item leave-mouse"> <a href="<?php echo base_url('practice_packs');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/practice-pack.svg');?>" alt="">Practice Pack</a> </li>
															<li class="menu-item menu-item-has-children header-sub-menu">
														</ul>
														</li>
														<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">Resources</a>
															<ul class="sub-menu">
																<li class="back"><a href="#">Back</a></li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('free_resources');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/article.svg');?>" alt="">Article & Tutorials</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('latest_news');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/immigration-news.svg');?>" alt="">Latest Immigration News</a> </li>
																<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/english-level-assessment" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/english-level-assesment.svg');?>" alt="">English Level Assessment</a> </li>
																<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/visa-assessment" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/study-visa-eligibility.svg');?>" alt="">Study Visa Eligibility</a> </li>
																<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/crs-calculator" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/crs-calculator.svg');?>" alt="">CRS Calculator</a> </li>
																<li class="menu-item leave-mouse"> <a href="https://western-overseas.com/assessment-tools/score-converter" target="_blank"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/score-convertor.svg');?>" alt="">Score Convertor</a> </li>
															</ul>
														</li>
														<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#">More</a>
															<ul class="sub-menu">
																<li class="back"><a href="#">Back</a></li>
																<div class="submenu-scroll scroll-v">
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('why_canada');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/why-canada.svg');?>" alt="">Why Canada?</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/gallery.svg');?>" alt="">Image Gallery</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('videos');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/video-gallery.svg');?>" alt="">Video Gallery</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('contact_us');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/contact.svg');?>" alt="">Contact</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url('faq');?>"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/faq.svg');?>" alt="">FAQ</a> </li>
																<li class="menu-item leave-mouse"> <a href="<?php echo base_url();?>become_agent" class="blink"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/network.svg');?>" alt="">Join Agent Network</a> </li>
																<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/partners.svg');?>" alt="">Our Partners</a>
																	<ul class="sub-menu">
																		<li class="back"><a href="#">Back</a></li>
																		<li class="menu-item leave-mouse"> <a class="text-normal" href="https://western-overseas.com/" style="text-transform: lowercase!important;" target="_blank">www.western-overseas.com</a> </li>
																		<li class="menu-item leave-mouse"> <a class="text-normal" href="https://www.westernoverseas.online/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.online</a> </li>
																		<li class="menu-item leave-mouse"> <a class="text-normal" href="https://westernoverseas.ca/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.ca</a> </li>
																		<li class="menu-item leave-mouse"> <a class="text-normal" href="https://www.ieltsrealitytest.com/" style="text-transform: lowercase!important;" target="_blank">www.ieltsrealitytest.com</a> </li>
																		<li class="menu-item leave-mouse"> <a class="text-normal" href="https://westernoverseas.events/" style="text-transform: lowercase!important;" target="_blank">www.westernoverseas.events</a> </li>
																	</ul>
																</li>
																<li class="menu-item menu-item-has-children header-sub-menu"> <a href="#"><img src="<?php echo base_url(DESIGN_VERSION_F.'/images/social-media.svg');?>" alt="">Find us on Social Media</a>
																	<ul class="sub-menu">
																		<li class="back"><a href="#">Back</a></li>
																		<div class="social-media text-center">
																			<div><a href="<?php echo FB;?>" target="_blank"><i class="fa fa-facebook s-icn facebook"></i>Facebook</a></div>
																			<div><a href="<?php echo TWT;?>" target="_blank"><i class="fa fa-twitter s-icn twitter"></i>Twitter</a></div>
																			<div><a href="<?php echo INST;?>" target="_blank"><i class="fa fa-instagram s-icn instagram"></i>Instagram</a></div>
																			<div><a href="<?php echo YTD;?>" target="_blank"><i class="fa fa-youtube s-icn y-tb"></i>Youtube</a></div>
																			<div><a href="<?php echo TTK;?>" target="_blank" style="display: -webkit-box!important;"><img class="s-icn tik" style="padding: 10px;"src="<?php echo base_url(DESIGN_VERSION_F.'/images/tiktok.svg');?>" alt=""><span style="margin-top:7px; display: block;"> Tiktok</span></a></div>
																		</div>

																	</ul>
																</li>
											</div>
															</ul>
														</li>
														<?php

															if($this->session->userdata('student_login_data')){

															?>
															<li class="menu-item"><a href="<?php echo base_url('our_students/student_dashboard');?>">Dashboard</a> </li>
															<?php }

															if(!$this->session->userdata('student_login_data')){

															?>
																	<li class="menu-item no-lg-display">
																		<div class="logn-btn"><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login">Login</a></div>
																	</li>
																	<li class="menu-item no-lg-display">
																		<div class="crt-btn"><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-register">Register</a></div>
																	</li>
																	<?php } else {?>
																		<li class="menu-item no-lg-display">
																			<div class="logn-btn"><a title="Go to Dashboard" class="text-yellow" href="<?php echo base_url('our_students/student_dashboard');?>"><?php echo 'Hi! '.$this->session->userdata('student_login_data')->fname;?></a></div>
																		</li>
																		<li class="menu-item no-lg-display">
																			<div class="crt-btn"><a title="Logout" class="" href="<?php echo base_url('my_login/student_logout');?>">Logout</a></div>
																		</li>
																		<?php }?>

																			<li class="line"></li>
												</ul>
											</div>
										</div>
										<div class="rts-btn mob-display hide">
											<ul>
												<li class="enq-btn" onClick="location.replace('<?php echo base_url('counseling');?>');"><a>Book Counseling</a></li>
											</ul>
										</div>
										<div class="hamburger-menu">
											<div class="bar"></div>
										</div>
									</nav>
								</div>
							</div>
						</div>
					</div>
					<!--End Header -->