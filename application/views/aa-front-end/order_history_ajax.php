
<div class="col-md-12">
<div class=" hide" id="ajaxloader" style="text-align: -webkit-center;"><img src="<?php echo site_url();?>resources-f/images/ajax-loader.gif" width="70px"/></div>
	<?php if(count($allOrder)>0){ ?>
		<?php      
foreach($allOrder as $p){        
?>
	<div class="order-hstry-box">
		<div class="row">
			<div class="col-md-9">
				<div class="info">
					<div><span class="font-weight-600 mr-5">ORDER:</span>  <?php echo $p->package_name;?></div>
					<ul>
					<li><span class="font-weight-600 mr-5">Product/Services:</span><?php echo ucwords($p->pack_type);?> - <?php echo $p->test_module_name;?>  <?php if($p->programe_name !='None'){ echo '- '.$p->programe_name; }?></li><br>
						<li><span class="font-weight-600 mr-5">Date:</span><?php echo $p->requested_on;?></li>
						<li><span class="font-weight-600 mr-5">Valid From:</span><?php echo $p->subscribed_on;?> </li>
						<li><span class="font-weight-600 mr-5">Valid Till:</span><?php echo $p->expired_on;?></li>
						<li><span class="font-weight-600 mr-5">Status:</span>
							<?php 
							//echo $p->package_status;					
							if($p->package_status==1)
								{	?>
							<span class="text-green">Active</span>
							<?php } else { ?>
<span class="text-red">InActive</span>
								<?php }?>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<a href="<?php echo base_url('our_students/download_order_reciept/'.$p->student_package_id);?>" >
					<div class="text-center dwn-load">Download Receipt</div>
				</a>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php } else {?>
		<div class="order-hstry-box">
		<div class="row">
			<div class="col-md-9">
				<div class="info">
					<div><span class="font-weight-600 mr-5">No transaction history !</div>
					
				</div>
			</div>
			
		</div>
	</div>
	<?php } ?>						
</div>