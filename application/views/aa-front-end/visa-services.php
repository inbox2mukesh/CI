
			


<!--Start Services Section-->
<section>
	<div class="container">


	<div class="vd-border">
			<div class="owl-carousel-slider image-border">
				<div class="item"><img src="<?php echo base_url('resources-f/images/slider/visa-services01.webp');?>" class="img-fullwidth"></div>
				<div class="item"><img src="<?php echo base_url('resources-f/images/slider/visa-services02.webp');?>" class="img-fullwidth"></div>
				<div class="item"><img src="<?php echo base_url('resources-f/images/slider/visa-services03.webp');?>" class="img-fullwidth"></div>
				<div class="item"><img src="<?php echo base_url('resources-f/images/slider/visa-services04.webp');?>" class="img-fullwidth"></div>
			</div>
		</div>

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