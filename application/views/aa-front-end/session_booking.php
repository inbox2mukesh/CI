<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
        <?php include('includes/student_profile_sidebar.php'); ?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside dash-main-box">
					<div class="top-title mb-15 text-uppercase"><?php echo $title;?></div>
					<div class="row">						
						<div class="global-page-scroll" id="scroll-style">
							<?php if(count($session_booking->error_message->data)>0)
							{ 
      		    foreach($session_booking->error_message->data as $p)
      		    {      	     
  		        ?>
							<div class="col-md-4">
								<div class="lt-clr-box reality-booking mt-5">
									<div class="card-info">
										<h4><?php echo ucfirst($p->session_type);?></h4>
										<h5><?php echo ucfirst($p->test_module_name);?> <?php echo ucfirst($p->programe_name);?> </h5>
										<ul>
											<li><span class="font-weight-600 mr-5">Booking Date:</span><?php echo ucfirst($p->booking_date);?></li>
											<li><span class="font-weight-600 mr-5">Time:</span><?php echo ucfirst($p->booking_time_slot);?></li>
											<li><span class="font-weight-600 mr-5">Location:</span><?php echo ucfirst($p->center_name);?></li>
											<?php
											if(!empty($p->remarks))
											{
											?>
											<li><span class="font-weight-600 mr-5">Remark:</span><?php echo ucfirst($p->remarks);?></li>
										<?php }?>
										<li><span class="font-weight-600 mr-5">Created Date:</span><?php echo $p->created;?></li>
										</ul>
										<div class="ftr-btm">
											<div> <span class="font-weight-600">Status: </span> 
                      <?php if($p->is_attended == 0)
											{ ?>
												<span class="text-red">Not Attended</span>
											<?php } 
											else if($p->is_attended == 1)
											{ 
											?>
											<span class="text-green">Attended</span>
											<?php 
											}
											else if($p->is_attended == 2)
											{ ?>
												<span class="text-yellow ">Pending</span>
											<?php } ?>
											</div>
											<?php 											
											if($p->booking_link !='0' AND $p->booking_link !='')
											{
											?>
											<div><a href="<?php echo $p->booking_link;?>" target="_blank" class="btn btn-wht mt-10">Click to Join</a></div>
										<?php }?>
										</div>
									</div>
								</div>
							</div>
						<?php } } else {?>
	            <div class="col-md-6">
								<div><span class="font-weight-600 mr-5"> No session booking is available !</div>
							</div>
						<?php } ?>				
						</div>
					</div>
				</div>
        <!-- End Content Part -->
      </div>
    </div>
</section>
</div>
</div>
</div>