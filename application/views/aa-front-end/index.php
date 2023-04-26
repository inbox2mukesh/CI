<!-- Main Slider -->
<section class="bg-lighter">
<div class="carousel slide" data-ride="carousel">
<?php if(DEFAULT_COUNTRY==13) { ?>
	<div class="owl-carousel-slider">
    <div class="carousel-item active">
      <img class="d-block w-100 desktop-slider lazyload" src="<?php echo base_url('resources-f/images/slider/aus-slider-1.webp');?>" alt="" loading="lazy">
	  <img class="d-block w-100 mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/aus-mob-slider-1.webp');?>" alt="" loading="lazy">
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider " src="<?php echo base_url('resources-f/images/slider/aus-slider-2.webp');?>" alt="" loading="lazy">	 
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/aus-mob-slider-2.webp');?>" alt="" loading="lazy">	 
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider" src="<?php echo base_url('resources-f/images/slider/aus-slider-3.webp');?>" alt="" loading="lazy">	
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/aus-mob-slider-3.webp');?>" alt="" loading="lazy">
    </div>


  
  </div>
  <?php }
  else if(DEFAULT_COUNTRY==101) { 
	?>

<div class="owl-carousel-slider">
    <div class="carousel-item active">
      <img class="d-block w-100 desktop-slider lazyload" src="<?php echo base_url('resources-f/images/slider/online-desktop-slider-1.webp');?>" alt="" loading="lazy">
	  <img class="d-block w-100 mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/online-mobile-slider-1.webp');?>" alt="" loading="lazy">
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider " src="<?php echo base_url('resources-f/images/slider/online-desktop-slider-2.webp');?>" alt="" loading="lazy">	 
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/online-mobile-slider-2.webp');?>" alt="" loading="lazy">	 
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider" src="<?php echo base_url('resources-f/images/slider/online-desktop-slider-3.webp');?>" alt="" loading="lazy">	
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/online-mobile-slider-3.webp');?>" alt="" loading="lazy">
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider" src="<?php echo base_url('resources-f/images/slider/online-desktop-slider-4.webp');?>" alt="" loading="lazy">	
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/online-mobile-slider-4.webp');?>" alt="" loading="lazy">
    </div>


  
  </div>



	<?php
  }
 
 else {?>
	<div class="owl-carousel-slider">
    <div class="carousel-item active">
      <img class="d-block w-100 desktop-slider lazyload" src="<?php echo base_url('resources-f/images/slider/desktop-slider-1.webp');?>" alt="" width="1920px" height="800px">
	  <img class="d-block w-100 mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/mobile-slider-1.webp');?>" alt="" width="1000px" height="665px">
	  <img class="d-block w-100 small-mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/small-mobile-slider-1.webp');?>" alt="" width="375px" height="249px">
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider " src="<?php echo base_url('resources-f/images/slider/desktop-slider-2.webp');?>" alt="" width="1920px" height="800px">	 
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/mobile-slider-2.webp');?>" alt="" width="1000px" height="665px">
	  <img class="d-block w-100 small-mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/small-mobile-slider-2.webp');?>" alt="" width="375px" height="249px">	 
    </div>

	<div class="carousel-item">
      <img class="d-block w-100 desktop-slider" src="<?php echo base_url('resources-f/images/slider/desktop-slider-3.webp');?>" alt="" width="1920px" height="800px">	
	  <img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/mobile-slider-3.webp');?>" alt="" width="1000px" height="665px">
	  <img class="d-block w-100 small-mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/small-mobile-slider-3.webp');?>" alt="" width="375px" height="249px">
    </div>
  
  </div>
	
	<?php }?>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>   
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
<!-- uick form -->

<div class="container sld-form">
	<div class="sl-form">
			<div class="topFormpanel text-left clearfix">
			<?php include('includes/enquiry_form.php');?>
			</div>
		</div>
	</div>
<div>
  
</section> 

	<!-- End Main Slider -->



		

	
	<!--Start About Section-->

	<section class="bg-lighter">

		<div class="container">
			<div class="about-content">
			<?php if(DEFAULT_COUNTRY!=13 && DEFAULT_COUNTRY!=101) { ?>
					<div class="text-center" style="text-align: -webkit-center;">

							<img src="<?php echo base_url('resources-f/images/iccrc.webp');?>" alt="rcic logo" title="rcic logo" class="image_iccrc" width="685px" height="204px">

						</div>

					<div class="text-center">

							<h4  class="text-center">

						<?php echo Licence_No;?>

						</h4>						

						</div>
				<?php }?>

				<div style="margin-top:40px;">
				<h2 class="font-weight-400 text-uppercase css1" style="text-align:center;">Who we <span class="text-red font-weight-600 mr-5">Are</span></h2>
				<?php if(DEFAULT_COUNTRY==13) { ?>
				<p class="text-justify">
				We aim to become your most trusted partner and ally in your journey to a better life through relevant education, a modern curriculum, and state-of-the-art methodologies. Young minds and aspiring seekers of knowledge who hold their aim to imbibe education overseas at the highest in their life are more than welcome. Western Overseas Australia will turn this dream of yours to migrate and settle abroad into a reality.
<br><br>
Western Overseas is where your talents are valued and dreams are nurtured. Indian students seeking global education and immigration have begun to rely on just one name, Western Overseas. Founded in 2016, with a vision to provide young minds with world-class education across the globe, we specialize in facilitating studies and immigration in not just Australia but several other destinations that you can think of. Western Overseas is the name of affordable, quick, and convenient immigration solutions and expert immigration advice and assistance 24/7. Our teams abide by every single Australian immigration law. All our experts go through a very strict training and testing module to develop a superbly high standard of expertise in every aspect of Australian immigration policies and legislation.
<br><br>
We take the MARA professional Code of Conduct very seriously and make sure that young and skilled people aspiring to immigrate to Australia in search of a great lifestyle and excellent job opportunities are never disappointed. If you are a skilled migrant looking to move to Australia, your suitability will be assessed on a points system. Your work experience, qualifications, and language proficiency will be expressed in points. Alternatively, you can obtain an immigration visa to Australia through the Australian Family Migration and Humanitarian Programs as well.

				</p>
<?php } else {?>
	<p class="text-center">
	At Western Overseas, we proudly offer a versatile platform for online coaching in English proficiency tests such as IELTS, PTE, TOEFL, and others. Our comprehensive courses are designed to provide students with all the necessary tools and resources to succeed in these exams.<br><br>

Expert Lectures, Grammar Tutorials, Practice Modules, Doubt-Clearing Sessions, Feedback Classes, and One-to-One Interaction make our coaching classes different and successful. We believe success in English proficiency exams requires hard work, perseverance, and dedication. Our coaching classes emphasize these values and motivate students to strive for excellence.<br><br>

We are committed to providing a supportive and conducive learning environment that empowers students to achieve their goals in English proficiency exams. Join us to unlock new doors of opportunities through online coaching.
				</p>
	<?php }?>
			</div>

	

			</div>

		</div>

	</section>

	<!--End About Section-->

<section class="bg-lighter-theme">
<div class="service-card-container">
	
<?php if(DEFAULT_COUNTRY!=101) { ?>
	<div class="service-card">
	<a href="<?php echo site_url()?>visa-services"> 
			<div class="rt-img up">
							<div class="video-popup">
								<img src="<?php echo BASE_URL();?>resources-f/images/immigration-services.webp" alt="" width="420px" height="280px">
								<!-- <span class="play-btn"><i class="fa fa-play play-cicle"></i></span>  -->
						</div>
						</div>
		
	
					<div class="crd-disc order-info">
						<div class="lt-info down">							
								<div class="title-heading">VISA & IMMIGRATION<br class="brake">SERVICES</div>	
								
								<ul>
									<li>study visa</li>
									<li>post study visa</li>
									<li>after visa services</li>
								</ul>	
									
						</div>
					
					</div>	
                        <div class="sp-line"></div>
					 <div class="crd-disc">	
						<?php if(DEFAULT_COUNTRY == 38) { ?>		
								<p>If you wish to study, work or extent your visa in Canada, our expert immigration and VISA services will help you apply for the application. We also take PR and citizenship cases and cover various visa types to create an easy pathway to secure your visa success. Rely on us and migrate through RCIC expert visa consultants.</p>	
							<?php } elseif(DEFAULT_COUNTRY == 13) {?>
								<p>Our pride is to serve you the best Australian immigration and VISA services. Individuals planning to stay, work and study further in the country get genuine assistance from our MARA-certified visa consultants. So migrate and settle in Australia through our expert support.</p>
								<?php } ?>
							 <div class="view-btn">Click Here <i class="fa fa-angle-right"></i></div>
					</div>					
	
		</a>
		
			
</div>
<?php } ?>
	
	<div class="service-card">
	<a href="<?php echo site_url()?>online-courses">
		<div class="rt-img up">
							<div class="video-popup">
								<img src="<?php echo BASE_URL();?>resources-f/images/online-coachings.webp" alt="" width="420px" height="280px">
								<!-- <span class="play-btn"><i class="fa fa-play play-cicle"></i></span>  -->
						      </div>
						</div>
			
		
					<div class="crd-disc order-info">
						<div class="lt-info down">							
								<div class="title-heading">TEST PREP<br class="brake">ONLINE COACHING</div>	
							
								<ul>
									<li>IELTS </li>
									<li>pte</li>
									<li>toefl</li>
								</ul>	
									
						</div>
						
					</div>	
           <div class="sp-line"></div>
					 <div class="crd-disc">			
								
								<?php if(DEFAULT_COUNTRY == 38) { ?>		
								<p>IELTS | TOEFL | PTE | No longer be hard to study | Online coaching programs formulated by English language experts will ensure your success. Advanced learning strategies are incorporated to aid students in learning at a fast pace. Dig into the pool of professional courses and choose your preferred option fulfilling your needs.</p>	
							<?php } elseif(DEFAULT_COUNTRY == 13) {?>
								<p>We are launching new IELTS, PTE, and TOEFL online coaching programs to boost English competence and Self-confidence. Experts have invested their knowledge, experience and expertise to design online courses standing up to students' expectations. The key to success lies in our online coaching. Let's start preparing!AU Test preparation practice packs</p>	
								<?php } else { ?>	
									<p>Wide range of online coaching programs for IELTS, PTE, TOEFL, and others offer students the convenience of making the best choice. Test preparation for you will involve only enrolling yourself in our programs, and our certified trainers will make you achieve a good score. Ensure your success with us!</p>	
								<?php } ?>
								 <div class="view-btn">Click Here <i class="fa fa-angle-right"></i></div>
					</div>	 
	
		</a>
		
		
		<!-- <div class="video-popup-widget" style="display: none">
			<h2>Online Coaching</h2>
			<div class="close-tag" href="#">&times;</div>
			<div class="content">
			<div class="embed-responsive embed-responsive-16by9">
			<div class="embed-responsive">
			<video autoplay preload="auto" loop="loop" muted="muted" controls disablepictureinpicture controlslist="nodownload noplaybackrate">
			<source src="<?php echo site_url()?>resources-f/video/ocean.mp4"> </video>
			</div>
			</div>
			</div>
		</div> -->

	</div>
	

	
<div class="service-card">
<a href="<?php echo site_url()?>practice-packs">
		<div class="rt-img up">
			<div class="video-popup">
			<img src="<?php echo BASE_URL();?>resources-f/images/test-prap.webp" alt="" width="420px" height="280px">
			<!-- <span class="play-btn"><i class="fa fa-play play-cicle"></i></span> -->
			</div>
		</div>
		
		
				<div class="crd-disc order-info">
				<div class="lt-info down">							
				<div class="title-heading">TEST PREP

<br class="brake">PRACTICE PACKS</div>	

				<ul>
				<li>IELTS </li>
				<li>pte</li>
				<li>toefl</li>
				</ul>

				</div>

				</div>
				<div class="sp-line"></div>	
				<div class="crd-disc">				
							<?php if(DEFAULT_COUNTRY == 38) { ?>		
								<p>We provided updated content for IELTS, PTE and TOEFL through our Test preparation practice pack that helps students do enough practice to ace the exam. Access to live expert classes, mock tests, Videos sessions, and real-time test analysis are a few aspects of our online practice packs. Let's get started to have success.</p>	
							<?php } elseif(DEFAULT_COUNTRY == 13) {?>
								<p>Our exclusive Test preparation practice packs have benefited students in securing their success at IELTS, PTE, and TOEFL exams. Students can practice and develop their test techniques with the latest sample papers in the programs. Choose your path to success with us, and start practising to ace the exam.</p>	
								<?php } else { ?>	
									<p>Online preparation practice packs for IELTS, PTE, TOEFL, and other English proficiency tests are made for students who want to improve their English skills with expert guidance. Our small-duration courses help students to get command over the English language and achieve their desired score. Book your course today!</p>	
								<?php } ?>						
				<div class="view-btn">Click Here <i class="fa fa-angle-right"></i></div>
				</div>	
		</a>
		
		<!-- <div class="video-popup-widget" style="display: none">
			<h2>Test Prep Practice Pack</h2>
			<div class="close-tag" href="#">&times;</div>
			<div class="content">
			<div class="embed-responsive embed-responsive-16by9">
			<div class="embed-responsive">
			<video autoplay preload="auto" loop="loop" muted="muted" controls disablepictureinpicture controlslist="nodownload noplaybackrate">
			<source src="<?php echo site_url()?>resources-f/video/ocean.mp4"> </video>
			</div>
			</div>
			</div>
		</div> -->
	
</div>
<?php if(DEFAULT_COUNTRY==101) { ?>
	<div class="service-card">
	<a href="https://www.ieltsrealitytest.com/" target="_blank"> 
			<div class="rt-img up">
							<div class="video-popup">
								<img src="<?php echo BASE_URL();?>resources-f/images/immigration-services.webp" alt="">
								<!-- <span class="play-btn"><i class="fa fa-play play-cicle"></i></span>  -->
						</div>
						</div>
		
	
					<div class="crd-disc order-info">
						<div class="lt-info down">							
								<div class="title-heading">Reality Test</div>	
								
								<ul>
									<li>PTE</li>
									<li>IELTS</li>
									<li>CD-IELTS</li>
								</ul>	
									
						</div>
					
					</div>	
                        <div class="sp-line"></div>
					 <div class="crd-disc">			
								<p>We are the Pioneer of IELTS | PTE | TOEFL Reality Test. Our great invention is helping thousands of under-confident students overcome their exam phobia. Students also take the exam to check their preparation level. Book your slot for the upcoming Reality test and get an accurate evaluation of English proficiency. </p>							
							 <div class="view-btn">Click Here <i class="fa fa-angle-right"></i></div>
					</div>					
	
		</a>
		
			
</div>
<?php } ?>

	</section>

<!--Start Articles Section-->
<?php 
if(!empty($FREE_RESOURCE_CONTENT->error_message->data))
{
?>
		<section>			
			<div class="container">
				<div class="font-weight-300 title text-center">Articles & <span class="text-red font-weight-600">Tutorials</span></div>			
			<div class="card-container">
				<div class="thumb-grid-flex-cont3">
					<?php 

foreach($FREE_RESOURCE_CONTENT->error_message->data as $p){

//print_r($p);
?>
					<!--Start Items-->
					<div class="card-item-3">
						<a href="<?php echo base_url()?>articles/post/<?php echo $p->URLslug; ?>">
							<div class="lt-post-img">
								<div class="img-area"> <img src="<?php echo $p->image;?>" class="img-responsive" alt="" width="237px" height="250px"> </div>
								<div class="img-text">
									<h4><!-- <i class="fa fa-thumb-tack text-red mr-5"></i> --><?php echo ucwords($p->title);?></h4>
									<div class="date"><?php echo $p->created;?></div>
									<div class="font-weight-600 font-12 text-italic">
										<?php echo strtoupper($p->content_type_name);?> <span class="text-theme-colored">(
										<?php 
										$type="";
										foreach($p->Course as $pp){
											$type.=$pp->topic.', ';
										}
										echo rtrim($type,', ')?>
									)</span>
									</div>
									<p><?php echo ucfirst($p->description);?></p>
								</div>
							</div>
						</a>
					</div>
					<!--End Items-->
					<?php }?>				
				</div>
			</div>	
			<div class="mt-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url();?>articles">View More →</a></div>		
  		</div>	
		</section>
<?php }?>
<!--End Articles Section-->
<!--Start Assessment Section-->	
	<section class="bg-lighter-theme">	
	<div class="container">
		<div class="font-weight-300 title text-center">Assessment &amp; <span class="text-red font-weight-600">Eligibility  Tools</span></div>
			<div class="row">			
			    <div class="col-md-3 col-sm-6 text-center">					
					<div class="img-tools">
					<a href="https://western-overseas.com/assessment-tools/crs-calculator" target="_blank">						
					<div class="imgi-icn"><img src="<?php echo BASE_URL();?>resources-f/images/crs-icn.svg" alt="" title="" width="70px" height="70px"></div>
						<div class="imgi-title">CRS CALCULATOR</div>
					</a>
					</div>
				</div>			
				
				 <div class="col-md-3 col-sm-6 text-center">					
					<div class="img-tools">	
					<a href="https://western-overseas.com/assessment-tools/visa-assessment" target="_blank">					
					<div class="imgi-icn"><img src="<?php echo BASE_URL();?>resources-f/images/study-visa.svg" alt="" title="" width="70px" height="70px"></div>
						<div class="imgi-title">Study Visa Eligibility</div>
					</a>
					</div>
				</div>
				
			 <div class="col-md-3 col-sm-6 text-center">					
					<div class="img-tools">				
					<a href="https://western-overseas.com/assessment-tools/english-level-assessment" target="_blank">	
					<div class="imgi-icn"><img src="<?php echo BASE_URL();?>resources-f/images/eng-level.svg" alt="" title="" width="70px" height="70px"></div>
						<div class="imgi-title">English Level Assessment</div>
					</a>
					</div>
				</div>								
			 <div class="col-md-3 col-sm-6 text-center">					
					<div class="img-tools">	
<a href="https://western-overseas.com/assessment-tools/score-converter" target="_blank">
					    <div class="imgi-icn"><img src="<?php echo BASE_URL();?>resources-f/images/score-convert.svg" alt="" title="" width="70px" height="70px"></div>
						<div class="imgi-title">Score Convertor</div>
					</a>

					</div>
				</div>			
			
			</div>	
</div>
	</section>
<!--End Assessment Section-->

	<!--Start Immigration News Section-->
	<?php 
if(!empty($newsData->error_message->data))
{
?>
	<section>
		<div class="container">
			<div class="font-weight-300 title text-center">Latest <span class="text-red font-weight-600">Immigration News</span></div>
			<div class="immigation-news-content">
				
				<!--START Thumb GRID CONTAINER -->
				<div class="card-container">
				<div class="thumb-grid-flex-cont3">
					<?php 
					foreach ($newsData->error_message->data as $d) { 
					$date=date_create($d->news_date);
					$news_date = date_format($date,"M d, Y");
					?>
					<!--Start Items-->
					<div class="card-item-3">
						<a href="<?php echo base_url('news/post/'.$d->URLslug);?>">
							<div class="lt-post-img lt-bg">
								<div class="img-area"> <img src="<?php echo base_url('uploads/news/'.$d->card_image);?>" class="img-responsive" alt="" width="237px" height="250px" > </div>
								<div class="img-text">
									<h4><?php echo substr($d->title,0,60);?></h4>
									<div class="date"><?php echo $news_date;?></div>
									<p><?php echo substr(strip_tags($d->body), 0,120);?></p>
								</div>
							</div>
						</a>
					</div>
					<!--End Items-->
					<?php } ?>
					
				</div>
			</div>
				<!--End Thumb GRID CONTAINER -->
				<div class="mt-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url();?>news">View More →</a></div>
			</div>
		</div>
	</section>
	<?php }?>
	<!--End Immigration News Section-->

<script>
$(document).ready(function() { 
  $(".selectpicker").selectpicker();
})
</script>


	<!--Video Modal-->
<!-- <script>	
$(document).ready(function() { 		
	$(".service-card").each(function(i){		
		$(this).addClass("c-"+i);			
		$(this).children().eq(0).click(function(){			
			$(".c-"+i).find(".video-popup-widget").css("display","block");			
			$("body").append("<div class='video-overlay'></div>");
		});
	});
});
	
$(".video-popup-widget .close-tag").click(function(){
	$(".video-popup-widget").css("display","none");
	$(".video-overlay").remove();
})
</script> -->

	<!--End Video Modal-->












