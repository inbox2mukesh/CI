<!--Start Services Section-->
<section>
	<div class="container">
		<div class="services-content">
		<h2 class="font-weight-300 text-uppercase text-center">Our 
			<span class="text-red font-weight-600">SERVICES<a name="visa-services"></a></span>
		</h2>
	<!--START GRID CONTAINER -->
				<div class="grid-container">
					<div class="grid-flex-cont4">						
						<!--Start Grid Items-->
						<?php foreach ($serviceData->error_message->data as $d) { ?>
						<div class="grid-card-container">
							<div class="grid-card">
								<a href="<?php echo base_url('visa_service_details/index/'.$d->id);?>">
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
						</div>
						<?php } ?>
						<!--End Grid Items-->	
					</div>
				</div>
				<!--END GRID CONTAINER -->
			</div>
		</div>
	</section>
	<!--End Services Section-->