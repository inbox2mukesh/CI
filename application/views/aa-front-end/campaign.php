
	<!-- about section  --->
<section>
	<div class="container">
		<h2>Enquiry</h2>			
			<div class="wizard">
				<form>
					<div class="tab-content">
						<!--Start Step-1-->
						<div class="tab-pane active" role="tabpanel" id="step1">
							<div class="step-disc-box">
								<div class="form-box">
									<div class="row">
										<div class="column12">
<!--											<h4 class="">Form-1</h4> -->
										</div>
										<div class="column6">
											<div class="form-group">
												<label>First Name<span class="text-red">*</span></label>
												<input type="text" class="form-control" placeholder="">
												<span id="fname_error" class="validation">fff</span>
											</div>
										</div>
										<div class="column6">
											<div class="form-group">
												<label>Last Name<span class="text-red">*</span></label>
												<input type="text" class="form-control" placeholder=""> </div>
										</div>
										<div class="column6">
											<div class="form-group">
												<label>Country Code<span class="text-red">*</span></label>
<!--												    <select class="fstdropdown-select">-->
												<select class="selectpicker" data-live-search="true">
													<option value="">Select Country Code</option>
													 <?php
                                                        foreach ($countryCode->error_message->data as $c) {
                                                            if($c->country_id=='101')
                                                            {
                                                        ?>
                                                        <option value="<?php echo $c->country_code;?>" selected="selected"><?php echo $c->country_code.'- '.$c->iso3;?></option>
                                                        <?php }
                                                        }
                                                        
                                                        foreach ($countryCode->error_message->data as $c) {
                                                            if($c->country_id!='101')
                                                            { ?>
                                                        <option value="<?php echo $c->country_code;?>" ><?php echo $c->country_code.'- '.$c->iso3;?></option>
                                                        <?php
                                                          }
                                                        }?>
												</select>
											</div>
										</div>
										<div class="column6">
											<div class="form-group">
												<label>Phone Number<span class="text-red">*</span></label>
												<input type="text" class="form-control" placeholder=""> </div>
										</div>
										<div class="column6">
											<div class="form-group">
												<label>Email<span class="text-red">*</span></label>
												<input type="text" class="form-control" placeholder=""> </div>
										</div>
										<div class="column6">
											<div class="form-group">
												<label>Date of Birth<span class="text-red">*</span></label>
												 <input id="date" data-inputmask="'alias': 'date'" class="form-control date" placeholder="dd/mm/yyyy">
										
											</div>
										</div>
										<div class="column12">
											<div class="text-right">
										<button type="submit" class="btn btn-red btn-md">BOOK SESSION</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--End Step-1-->
						<!--Start Step-2-->
						<div class="tab-pane" role="tabpanel" id="step2">
							<div class="form-box">
								<div class="row">
									<div class="column12">
<!--										<h4 class="">Form-2</h4>-->
									</div>
								</div>
							</div>
						</div>
						<!--End Step-2-->
						<!--Start Step-3-->
						<div class="tab-pane" role="tabpanel" id="step3">
							<div class="form-box">
								<div class="row">
									<div class="column12">
<!--										<h4>Form-3</h4>-->
									
									</div>
								</div>
							</div>
						</div>
						<!--End Step-3-->
						<!--Start Step-4-->
						<div class="tab-pane" role="tabpanel" id="step4">
							<div class="form-box">
								<div class="row">
									<div class="column12">
<!--										<h4>Form-4</h4>-->
									</div>
								</div>
							</div>
						</div>
						<!--End Step-4-->
						<div class="clearfix"></div>
						<div class="wizard-inner">
							<!--					<div class="connecting-line"></div>-->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"> <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span></a></li>
								<li role="presentation" class="disabled"> <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span></a> </li>
								<li role="presentation" class="disabled"> <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span></a> </li>
								<li role="presentation" class="disabled"> <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span></a> </li>
							</ul>
						</div>
					</div>
				</form>
			</div>
			<!--Slider--->
			<div class="glbl-box">
				<div class="slider-wrapper">
					<div class="contentpart">
						<h2>Lorem ipsum dollar</h2>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy is simply dummy text of the printing and typesetting industry.</p>
					</div>
					<div class="imagepart"><img src="<?php echo base_url()?>resources-f/campaign/images/sldr-1.webp" alt=""></div>
				</div>
			</div>
			<!--Logos--->
	<div class="logo-box">
				<div class="logo-container">
					<div class="logo-item">
						<a href="#"><img src="<?php echo base_url()?>resources-f/campaign/images/partners/IDP-IELTS.webp" alt=""></a>
						<div class="lg-text">Award and Certified Institute </div>
					</div>
					<div class="logo-item">
						<a href="#"><img src="<?php echo base_url()?>resources-f/campaign/images/partners/camb.webp" alt=""></a>
						<div class="sl-text"> Official Resource Partner (Silver Member)</div>
					</div>
					<div class="logo-item">
						<a href="#"><img src="<?php echo base_url()?>resources-f/campaign/images/partners/pear.webp" alt=""></a>
						<div class="sl-text"> Pearson Certified Institute (Silver Member) </div>
					</div>
				
			    <div class="logo-item">
				  <a href="#"><img src="<?php echo base_url()?>resources-f/campaign/images/partners/pear.webp" alt=""></a>
				  <div class="sl-text"> Pearson Certified Institute (Silver Member) </div>
			   </div>
             </div>
	</div>
			<!--Video--->
			<div class="glbl-box">
				<div class="vd-border">
					<div class="embed-responsive embed-responsive-16by9">
						<video autoplay preload="auto" loop="loop" muted="muted">
							<source src="<?php echo base_url()?>resources-f/campaign/video/why-canada.mp4"> </video>
					</div>
				</div>
			</div>
			<!--About--->
			<div class="glbl-box">
				<div class="content-wrapper">
					<h3 class="text-uppercase">Online <span>Coaching</span></h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
						<ul>
							<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
							<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
							<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
							<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
						</ul> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. </p>
				</div>
			</div>
			<!--About--->
			<div class="glbl-box">
				<div class="image-wrapper">
					<img src="<?php echo base_url()?>resources-f/campaign/images/main.webp" alt="" class="mob-display-none">
						<img src="<?php echo base_url()?>resources-f/campaign/images/mob-slider-1.webp" alt="" class="no-lg-display">
				
				</div>
			</div>
		</div>
</section>
	<!--  end about section  --->
	<!--Latest Post-->
	