<!-- Modal Apply Now -->
	<!-- <div class="modal-form fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="font-18"><i class="fa fa-times"></i></span> </button>
				</div>
				<div class="modal-body">
					<?php //include('includes/enquiry_form.php');?>
				</div>
			</div>
		</div>
	</div> -->
	<!-- End Modal Apply Now -->
	<!--Start Why Canada Section-->
	<section>
		<div class="container">
		<div class="head-title font-weight-400 text-uppercase mb-20">OUR <span class="text-red font-weight-600">SERVICES</span></div>
			<div class="row" id="order-flex">
				<div class="col-md-8" id="down">
					<div class="main-services">
						<!--Start About Content-->
						<div class="wraper-content">
							<div class="sub-service-info">
								<h4 class="title-head-bar text-uppercase ">About <?php echo strtolower($serviceDetails->error_message->data->enquiry_purpose_name);?></h4>
								<div class="about-sub-info">
									<p> <?php echo $serviceDetails->error_message->data->about_service?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 side-info" id="up">				
					<div class="rt-services">
										<div class="img-area"> <img src="<?php echo base_url('uploads/service_image/'.$serviceDetails->error_message->data->image);?>" class="img-responsive" alt="" title=""> </div>
										<div class="img-text">
											<h4><?php echo $serviceDetails->error_message->data->enquiry_purpose_name;?></h4> 
	   </span> </div>
									</div>
<!--
				<div class="text-center no-lg-display mt-15 mb-20">
					<button type="button" class="btn btn btn-blue btn-circled btn-md" data-toggle="modal" data-target="#form"> Apply Now <i class="fa fa-chevron-right font-10"></i> </button>
				</div>
-->
			<div class="topFormpanel text-left mt-30 mob-display clearfix">
					<?php 
					$service_id=$serviceDetails->error_message->data->id;
					$enquiry_purpose_name=$serviceDetails->error_message->data->enquiry_purpose_name;
					include('includes/enquiry_form.php');?>
				</div>
			</div>
	</section>
	<!--End Why Canada Section-->
<script>
		// make a new multiSelect instance
		const multi = new MultiSelect({
			pleaseSelectOptionValue: 'nothingHere'
		});
		function sendData() {
			// get the <select> values
			const values = multi.getJson(false);
			console.log(values);
			// validate
			if(multi.simpleValidate()) {
				// make something
			} else {
				//make something
			}
		}
</script>