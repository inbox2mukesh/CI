<!--Start Contact Section-->
<section>
<div class="container">
	<div class="wraper-content">
		<h2 class="font-weight-400 text-uppercase text-center">Contact <span class="text-red font-weight-600">Us</span></h2>
		<div class="light-info-box mb-30">
			<div class="row font-17">
				<div class="col-md-6 text-center"><strong>Phone</strong>: <?php echo CU_PHONE;?></div>
				<div class="col-md-6 text-center"><strong>Email</strong>: <?php echo CU_EMAIL;?></div>
			</div>
		</div>
		<!--Start Map Section-->

	<div class="branch-info">
		<div class="map-info">
			<div class="row row-eq-height">
				<?php 
					if(DEFAULT_COUNTRY==38){
						$country_name='Canada';
					}else if(DEFAULT_COUNTRY==13){
						$country_name='Australia';
					}else if(DEFAULT_COUNTRY==101){
						$country_name='India';
					}else{
						$country_name='';
					}
				?>
				<div class="col-md-12">	<h3 class="font-weight-400 text-center text-uppercase">Western Overseas <span class="text-red font-weight-600"><?php echo $country_name;?></span></h3></div>
					<?php 
					if(DEFAULT_COUNTRY==38){ ?>
					<div class="col-md-6 col-sm-6">
						<div class="branch-box  lt-bg">
							<div class="content">
								<p class="hide"><i class="fa fa-map-marker"></i> <span>314 Charlotte St. Sydney, NS B1P 1C7, Canada</span></p>
								<p><i class="fa fa-map-marker"></i> <span>Unit 260, 7025 Tomken Rd, Mississauga, Ontario</span></p>
								<p><i class="fa fa-phone"></i> <span><?php echo CU_PHONE;?></span></p>
								<p><i class="fa fa-envelope-o"></i> <span><a href="mailto:<?php echo CU_EMAIL;?>"><?php echo CU_EMAIL;?></a></span></p>
								<p><i class="fa fa-envelope-o"></i> <span><a href="mailto:<?php echo CU_EMAIL2;?>"><?php echo CU_EMAIL2;?></a></span></p>
							</div>
							<div><a class="btn btn-red btn-flat view-btn" href="https://www.google.com/maps/dir//155+Park+St,+Sydney,+NS+B1P+4W7,+Canada/@46.134785,-60.182995,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x4b67fb37da60bcf1:0xfcfa589078107ef5!2m2!1d-60.1829953!2d46.1347846?hl=en" target="_blank">Direction</a></div>
						</div>
					</div>						

					<div class="col-md-6 col-sm-6">
						<div class="branch-box  lt-bg">
							<div class="content">
								<p><i class="fa fa-map-marker"></i> 314 Charlotte St. Sydney,NS B1P 1C7, Canada</p>
								<p><i class="fa fa-phone"></i>  <a href="tel:9025371344">+1 (902) 537-1344</a></p>
								<p><i class="fa fa-envelope-o"></i> <a href="mailto:info@westernoverseas.ca">info@westernoverseas.ca</a></p>
								<p><i class="fa fa-envelope-o"></i> <a href="mailto:ankit@westernoverseas.ca">ankit@westernoverseas.ca</a></p>
							</div>
							<div><a class="btn btn-red btn-flat view-btn" href="https://www.google.com/maps/dir//155+Park+St,+Sydney,+NS+B1P+4W7,+Canada/@46.134785,-60.182995,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x4b67fb37da60bcf1:0xfcfa589078107ef5!2m2!1d-60.1829953!2d46.1347846?hl=en" target="_blank">Direction</a></div>
						</div>
					</div>
				   <?php }elseif(DEFAULT_COUNTRY==13){ ?>
				   	<div class="col-md-6 col-sm-6">
						<div class="branch-box  lt-bg">
							<div class="content">
								<p><i class="fa fa-map-marker"></i> Level 1, Suit 102, 2Queen St, Melbourne CBD 3000</p>
								<p><i class="fa fa-phone"></i>  <a href="tel:61430439035">+61-430-439-035</a></p>
								<p><i class="fa fa-envelope-o"></i> <a href="mailto:anil@westernoverseas.com.au">anil@westernoverseas.com.au</a></p>
							</div>
							<div><a class="btn btn-red btn-flat view-btn" href="https://goo.gl/maps/4xPhRPoFCxDZoPpo8" target="_blank">Direction</a></div>
						</div>
					</div>
				   <?php }elseif(DEFAULT_COUNTRY==101){ ?>
					<?php foreach ($longBranchesOverseas->error_message->data as $p){  ?>
		
				<?php if(isset($p->center_name) && strtolower($p->center_name) != 'online') { ?>
					<div class="col-md-4 col-sm-6">
						<div class="branch-box mb-20 wht-bg">
							<h4 class="mt-0"><?php echo $p->center_name;?></h4>
						
							<div class="content">
								<?php if(isset($p->address_line_1) && $p->address_line_1) { ?>
									<p><i class="fa fa-map-marker"></i> <span><?php echo $p->address_line_1;?></span></p>
								<?php } ?>
								<?php if(isset($p->contact) && $p->contact) { ?>
									<p><i class="fa fa-phone"></i> <span><a href="tel:<?php echo $p->contact;?>"><?php echo $p->contact;?></a></span> </p>
								<?php } ?>
								<?php if(isset($p->email) && $p->email) { ?>
									<p><i class="fa fa-envelope-o"></i><span> 
									<a href="mailto:<?php echo $p->email;?>"><?php echo $p->email;?></a></span> </p>
								<?php } ?>
							</div>
							<?php if($p->feedbackLink){ ?>
								<div class="ft-btm"><a href="<?php echo $p->feedbackLink;?>"  target="_blank" class="btn btn-red btn-md">Give Feedback</a> </div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>	
			
		
	<?php } ?>
				   <?php }else{ ?>
				   <?php } ?>
			</div>
		</div>
	</div>
	<!--End Map Section-->
	
	<?php if(DEFAULT_COUNTRY!=101){?>
	<!--Start Branch Section-->
	<h3 class="font-weight-400 text-uppercase text-center mt-40">Other <span class="text-red font-weight-600">Partners in our Network</span></h3>
	<div class="branch-info mt-20">
	<!--Australia Branch-->
	<div class="row row-eq-height">
	<?php foreach ($longBranchesOverseas->error_message->data as $p){  ?>
			<?php if(isset($p->center_name) && strtolower($p->center_name) != 'online') { ?>
				<div class="col-md-4 col-sm-6">
					<div class="branch-box mb-20 wht-bg">
						<h4 class="mt-0"><?php echo $p->center_name;?></h4>
					
						<div class="content">
							<?php if(isset($p->address_line_1) && $p->address_line_1) { ?>
								<p><i class="fa fa-map-marker"></i> <span><?php echo $p->address_line_1;?></span></p>
							<?php } ?>
							<?php if(isset($p->contact) && $p->contact) { ?>
								<p><i class="fa fa-phone"></i> <span><a href="tel:<?php echo $p->contact;?>"><?php echo $p->contact;?></a></span> </p>
							<?php } ?>
							<?php if(isset($p->email) && $p->email) { ?>
								<p><i class="fa fa-envelope-o"></i><span> 
								<a href="mailto:<?php echo $p->email;?>"><?php echo $p->email;?></a></span> </p>
							<?php } ?>
						</div>
						<?php if($p->feedbackLink){ ?>
							<div class="ft-btm"><a href="<?php echo $p->feedbackLink;?>"  target="_blank" class="btn btn-red btn-md">Give Feedback</a> </div>
						<?php } ?>
					</div>
				</div>	
			<?php } ?>
			
		
	<?php } ?>
	</div>

	<!--India Branch-->
	<?php
	$indianbranch=array();
	if(count($indianbranch)>0 && isset($indianbranch) ){ ?>
		<div class="branch-wht mt-20">
			<h3 class="red-text text-uppercase mb-10">India
				<a href="<?php echo IND_SITE_LINK;?>" target="_blank"><span class="btn btn-red btn-circled btn-sm mb-10 pull-right">Website</span></a>
			</h3>
			<div class="row row-eq-height">
			<?php foreach ($indianbranch as $ib) { ?>
				<div class="col-md-4">
					<div class="branch-box mb-20 lt-bg">
					<h4 class="mt-0"><?php echo $ib['center_name'];?></h4>
						<div class="content">
							<p><i class="fa fa-map-marker"></i> <span><?php echo $ib['address_line_1'];?></span></p>
							<p><i class="fa fa-phone"></i> <span><?php echo $ib['contact'];?></span> </p>
							<p><i class="fa fa-envelope-o"></i> <span> <a href="mailto:<?php echo $ib['email'];?>"><?php echo $ib['email'];?></a></span></p>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	<?php } ?>
	</div>
<?php }?>
<!--End Branch Section-->
		</div>
	</div>
</section>
<!--End Contact Section-->

<!--Start Query Section-->
<section class="red-theme-bg">
	<div class="container">
	<div class="row">
		<div class="col-md-6 text-center mob-display mt-50 pr-30"> <img src="<?php echo base_url('resources-f/images/contact1.png');?>" alt="" title="" class="con-img"></div>
		<div class="col-md-6">
			<div class="topFormpanel text-left mb-0 clearfix">
				<?php include('includes/enquiry_form.php');?>
			</div>
		</div>
	</div>
	</div>
<script>
	//make a new multiSelect instance
	const multi = new MultiSelect({
		pleaseSelectOptionValue: 'nothingHere'
	});

	function sendData(){
		// get the <select> values
		const values = multi.getJson(false);
		console.log(values);
		// validate
		if(multi.simpleValidate()){
			// make something
		}else{
			//make something
		}
	}
</script>
</section>
<!--End Query Section-->