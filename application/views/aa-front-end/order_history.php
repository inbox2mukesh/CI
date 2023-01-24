<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
        <?php include('includes/student_profile_sidebar.php'); ?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <!-- Start Content Part -->
		<div class="content-aside dash-main-box">					
			<div class="row">
				<div class="col-md-5">
					<div class="top-title mb-15 text-uppercase"><?php echo $title1;?> <?php echo $title2;?></div>
				</div>
				<div class="col-md-1" style="text-align: right;margin-top: 12px;">
					<div class="hide" id="ajaxloader" style=""><img src="<?php echo site_url();?>resources-f/images/ajax-loader1.gif" width="20px"/></div>
				</div>
								
				<div class="col-md-6 col-sm-6 d-flex">								
					<div class="form-group" style="width: 100%;">								
						<select class="selectpicker form-control" data-live-search="true" onchange="searchOrderDate(this.value);" id="orderdate" >
							<option value="">Select Date</option>
							<?php foreach($allOrderDate as $p){ ?>
							<option value="<?php echo $p->requested_on?>">
								<?php 
									$date=date_create($p->requested_on);
									echo date_format($date,"d-m-Y");
								?>
							</option>
							<?php }?>
						</select>
					</div>
				</div>								
			</div>
						
					<div class="row">
				
						<div class="global-page-scroll orderhistorydiv" id="scroll-style">
							
							<div class="col-md-12">
							
								<?php if(count($allOrder)>0){ ?>
									<?php 
									//print_r($allOrder);     
      								foreach($allOrder as $p){ ?>
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
											<a href="<?php echo base_url('our_students/download_order_reciept/'.base64_encode($p->student_package_id));?>" >
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
						</div>
					</div>
				</div>
				<!-- End Content Part -->
        <!-- End Content Part -->
      </div>
    </div>
  </section>


      </div>
    </div>
  </div>

  <script>
function searchOrderDate(orderdate)
  {		
	$.ajax({
          url: "<?php echo site_url('our_students/ajax_order_history');?>",
          type: 'post', 
		  data:{orderdate:orderdate},                     
          success: function(response)
		  {  
			$('#ajaxloader').addClass('hide');   			
          $('.orderhistorydiv').html(response);              
          },
          beforeSend: function(){   
			  
			$('#ajaxloader').removeClass('hide');   
          }
      });
  }
  </script>

  