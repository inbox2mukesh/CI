
			


<!--Start Services Section-->
<section>
	<div class="container">

	<?php if(!empty($bannerList->error_message->data)) { 
		$data = $bannerList->error_message->data;
		?>
		<div class="vd-border">
			<div class="owl-carousel-slider image-border">
				<?php foreach($data as $image) { ?>
				<div class="item"><img src="<?php echo base_url(VISA_BANNER_IMAGE_PATH.$image->banner_img);?>" class="img-fullwidth"></div>
				<?php } //end foreach ?>
			</div>
		</div>
		<?php } //if condition end ?>
		<div class="services-content mt-40">
		<h2 class="font-weight-300 text-uppercase text-center">Our 
			<span class="text-red font-weight-600">SERVICES<a name="visa-services"></a></span>
		</h2>
	<!--START GRID CONTAINER -->
				<div class="row">
								
						<!--Start Grid Items-->
						<?php
						foreach ($serviceData->error_message->data as $d) { ?>
						<div class="col-md-3 col-sm-6">
						
								<a href="<?php echo base_url('visa-services/'.$d->URLslug);?>">
									<div class="services">
										<div class="img-area"> <img src="<?php echo base_url('uploads/service_image/'.$d->image);?>" class="img-responsive" alt="" title=""> </div>
										<div class="img-text">
										<h4><?php echo $d->enquiry_purpose_name;?></h4> 
								
										<span class="ft-btn text-center btn btn-blue btn-circled btn-sm mt-5"> Find Out More <i class="fa fa-chevron-right font-10"></i>
										</span> 
										</div>
									</div>
								</a>
							</div>
				
						<?php } ?>
						<!--End Grid Items-->	
					</div>
			
				<!--END GRID CONTAINER -->
			</div>
		</div>
	</section>
	<!--End Services Section-->