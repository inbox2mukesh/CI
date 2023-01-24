<div >
<section class="bg-lighter-theme">
	
	<div class="container" style="padding-bottom: 80px;">
		<h2 class="font-weight-300 text-uppercase text-center">Book <span class="text-red font-weight-600">Counseling</span></h2>
		

			<div class="counselling-booking-box" id="order-object">
	
<div class="left-info-sec" id="down">
		
<div class="logo-section">
	<img src="<?php echo site_url()?>resources-f/images/logo-sm.png" alt="<?php echo COMPANY;?>">
</div>	
<div class="info-section">
<h6><?php echo ADMIN_NAME;?></h6>
<h2><?php echo COMPANY;?></h2>	
	
	 <p><i class="fa fa-clock-o"></i><span><?php echo $sessionInfo['duration'];?> </span></p>
	<p><i class="fa fa-credit-card"></i><span>$<?php echo $sessionInfo['amount'];?> USD</span></p> 
	
	<div class="details">
	<?php //echo "<pre>"; print_r($generalInfo);

	 echo $generalInfo[0]['description'];?>	

	</div>
	
</div>	
	
</div>
	
	
<div class="right-info-sec" id="up">
	<div class="booking-form">	
		<div class="gray-box">
			<div class="msg-info text-center">
				<form method="post" action="<?php echo site_url('counseling/continue_pay');?>" enctype="multipart/form-data" id="studentPostForm"   >
			<div class="font-18 mt-10">Session create successfully. <br>Pay booking amount to complete your process</div>
			<div class="subs-group clearfix">
			<!-- <div class="subs-input">
			<h5 class="hide">Booking Amount :$<?php echo $sessionInfo['amount'];?> USD<b id="b_amt"></b> </h5>
			</div> -->

			</div>

			<div>
			<button style="background: none;padding: 0px;margin-top: 10px !important;margin: 0px;" class="btn btn-red btn-subs" type="submit"><img src="https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_l.png" alt="Pay with PayPal"></button>			
			</div>

			<div class="mt-20">
				<h4>Or </h4>
			<h4 class="mt-10">You can also Interact With this Email: <a href="mailto:<?php echo CU_EMAIL2;?>" style="color: blue;"><?php echo CU_EMAIL2;?>  </a></h4>

			<h4 class="mt-5">Use Reference No: <b><?php echo $sessionInfo['sessBookingNo']?></b> in the Email</h4>

			</div>
			</form>	
			</div>
			<div class="mt-20">  
 <a href="<?php echo site_url();?>" class="btn btn-red pull-left">Home</a>
			 <a href="<?php echo site_url();?>counseling" class="btn btn-black"><i class="fa fa-arrow-left"></i> Back</a></div>
		</div>
			

		</div>	
	
</div>
	
</div>

			
	</div>	
</section>
</div>
<script src="<?php echo site_url()?>resources-f/js/jquery.min.js"></script>	
<script src="<?php echo site_url()?>resources-f/js/bootstrap-datepicker.js"></script>

