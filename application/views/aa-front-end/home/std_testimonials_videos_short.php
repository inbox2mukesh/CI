<section>
			<div class="container">
				<div class="section-title mb-10 text-center">
					<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0">Our <span class="red-text font-weight-500"> Reviews</span></h2> </div>
				<div class="row">
					<div class="col-md-6">
						<div class="testimonial-bx">
							<div class="owl-carousel text-carousel">
							  <?php
    foreach($All_TXT_TSMT->error_message->data as $p){
  ?>
								<div class="item">
				<p> <?php 
				$string = word_limiter($p->testimonial_text, 110);
				echo ucfirst($string);?> 
									<?php if(!empty($p->image)){ ?>
         <p class="text-right mt-15">
              <img width="75" height="75" class="img-rounded" src="<?php echo base_url(TESTIMONIAL_USER_FILE_PATH.$p->image);?>">
            </p>
          <?php } ?>
									
									</p>
														
									
									<p class="mt-20 text-right">- <span class="red-text"><?php echo $p->name;?>,</span></p>
									<p class="text-right"><?php echo $p->designation_name;?></p>
									<p class="mt-20 text-right"><span class="font-12"><?php echo $p->tsmt_date;?></span></p>
				
								</div>
	<?php }?>
								
							</div>
						</div>
						<div class="mt-30 mb-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url('student_testimonial/student_testimonial_text');?>">View More →</a></div>
					</div>
					<?php if(count($All_TSMT->error_message->data)>0) { ?> 
					<div class="col-md-6">
						
						
						<div class="video-bx">
							<div class="owl-carousel owl-carousel-slider">
							<?php 						
						foreach($All_TSMT->error_message->data as $p){ 
						?>
								<div class="lg-video embed-responsive embed-responsive-16by9">
									<!--<video src="<?php //echo $p->url;?>" controls></video>-->
									<iframe class="embed-responsive-item" src="<?php echo $p->url;?>"></iframe>
								</div>
								 <?php } ?>
							</div>
						</div>
						
						<div class="mt-30 mb-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url('student_testimonial');?>">View More →</a></div>
					</div>
					<?php }?>
				</div>
			</div>
		</section>