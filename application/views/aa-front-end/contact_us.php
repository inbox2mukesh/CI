<style>
	h3{font-size:22px!important;}
</style>

<section>
		<div class="container">
			<!--Start Support Section-->
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div class="branch-box mb-20 lt-bg ">
						<h3>STUDENT SUPPORT</h3>
						<div class="content1">
							<p><i class="fa fa-phone"></i> <a href="tel:+91-9991683777">+91-9991683777</a></p>
							<p><i class="fa fa-envelope-o"></i> <a href="mailto:support@westernoverseas.online">support@westernoverseas.online</a></p>
							
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="branch-box mb-20 lt-bg">
						<h3>ADMISSIONS TEAM</h3>
						<div class="content1">
							<p><i class="fa fa-phone"></i> <a href="tel:+91-9991555120">+91-9991555120</a></p>
							<p><i class="fa fa-envelope-o"></i><a href="mailto:admissions@westernoverseas.online">admissions@westernoverseas.online</a></p>
							
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="branch-box mb-20 lt-bg">
						<h3>ADMIN ONLINE LMS</h3>
						<div class="content1">
							
							<p><i class="fa fa-envelope-o"></i> <a href="mailto:admin@westernoverseas.online">admin@westernoverseas.online</a></p>
							
						</div>
					</div>
				</div>
				
			</div>
			<!--End Support Section-->
			<!--Start India Branch Section-->
			<?php
$count_section=count($longBranches->error_message->data);
if($count_section >0)
{
			?>
			<h3 class="font-weight-400 text-uppercase mt-20">Our <span class="text-red font-weight-600">Branches in India</span></h3>
			<div class="branch-info mt-20">
				<div class="row">
				  <?php

				   foreach ($longBranches->error_message->data as $p){  ?>
					<div class="col-md-4 col-sm-6">
						<div class="branch-box mb-20 wt-bg">
							<h4 class="mt-0"><?php echo $p->center_name;?></h4>
							<div class="content">
								<p><i class="fa fa-map-marker"></i> <span><?php echo $p->address_line_1;?></span></p>
								<p><i class="fa fa-phone"></i> <span><a href="tel:<?php echo $p->contact;?>"><?php echo $p->contact;?></a></span> </p>
								<p><i class="fa fa-envelope-o"></i><span> 
							    <a href="mailto:<?php echo $p->email;?>"><?php echo $p->email;?></a></span> </p>
								
							</div>
							<?php if($p->feedbackLink){ ?>
							<div class="ft-btm"><a href="<?php echo $p->feedbackLink;?>"  target="_blank" class="btn btn-red btn-md">Give Feedback</a> </div><?php } ?>
						</div>
					</div>
					  <?php } ?>			
					
					
					
				
					
					
				</div>
				<!--India Branch-->
			</div>
			<!--End India Branch Section-->
		<?php }?>
			<!--Start Branch-->
			<div class="row mt-40">
				 <?php foreach ($longBranchesOverseas->error_message->data as $p){  ?>
					<div class="col-md-4 col-sm-6">
						<div class="branch-box mb-20 wt-bg">
							<h4 class="mt-0"><?php echo $p->center_name;?></h4>
							<div class="content">
								<p><i class="fa fa-map-marker"></i> <span><?php echo $p->address_line_1;?></span></p>
								<p><i class="fa fa-phone"></i> <span><a href="tel:<?php echo $p->contact;?>"><?php echo $p->contact;?></a></span> </p>
								<p><i class="fa fa-envelope-o"></i><span> 
							    <a href="mailto:<?php echo $p->email;?>"><?php echo $p->email;?></a></span> </p>
								
							</div>
							<?php if($p->feedbackLink){ ?>
							<div class="ft-btm"><a href="<?php echo $p->feedbackLink;?>"  target="_blank" class="btn btn-red btn-md">Give Feedback</a> </div><?php } ?>
						</div>
					</div>
					  <?php } ?>
				
			</div>
			<!--End Branch-->
			<div class="row mt-50">
				<div class="col-md-6">
					<div class="topFormpanel text-left lt-bg">
						<?php include('home/enquiry_form.php');?>
					</div>
				</div>
				<div class="col-md-6 text-center"> <img src="<?php echo base_url();?>resources-f/images/contact.jpg" alt="" title="" class="mt-60">
				</div>
			</div>
		</div>
		<!--Form Multiple Value Selector-->
		<script>
		$(function() {
			$('.selector').change(function() {
				$('.show-vlu').hide();
				$('#' + $(this).val()).show();
			});
		});
		</script>
		<!--End Form Multiple Value Selector-->
	</section>