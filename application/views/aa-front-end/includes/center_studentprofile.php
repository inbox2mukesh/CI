<div class="col-md-5">
							<div class="lt-clr-box mob-mb-20">
								<div class="profile-info">
									<div class="pro-pics">
										<?php 
									
		                          if(!empty($this->session->userdata('student_login_data')->profile_pic ))
		{
$p_pic=base_url($this->session->userdata('student_login_data')->profile_pic);

		}	
		else {
			$p_pic=base_url('uploads/profile_pic/default_profile_pic.png');
		}							
 

										?>
										<img src="<?php echo $p_pic;?>">
										<div class="change-img">
                                         <a href="#" data-toggle="modal" data-target="#modal-changeprofilepic" class="change-btn"><i class="fa fa-pencil"></i> Update Photo</a>
                                          </div>


									</div>
									<div class="detail">
										<p><?php echo $this->session->userdata('student_login_data')->fname.' '.$this->session->userdata('student_login_data')->lname?></p>
										<p><?php echo $this->session->userdata('student_login_data')->country_code.'-'.$this->session->userdata('student_login_data')->mobile;?></p>
										<p><?php echo $this->session->userdata('student_login_data')->email;?></p>
										<p class="font-12 mt-15"><a class="text-blue" href="<?php echo base_url('our_students/update_profile');?>">
										<?php 
										if($this->session->userdata('student_login_data')->profileUpdate ==1)
										{
											echo '<i class="fa fa-user" aria-hidden="true"></i> VIEW PROFILE';
										}
										else {
											echo '<i class="fa fa-pencil mr-5"></i>EDIT PROFILE';
										}
										?>
										</a></p>
										<p class="font-12 mt-15"><a  href="javascript:void" class="launch-modal text-red" data-toggle="modal" data-target="#modal-md"><i class="fa fa-key mr-5"></i>CHANGE PASSWORD</a></p>
										<div class="mt-10" style="display: inline-block;"><span class="id-info">UNIQUE ID: <?php echo $this->session->userdata('student_login_data')->UID;?></span></div>
										<!-- <div class="wallet-info">
											<p><a href="javascript:void()"  data-toggle="modal" data-target="#modal-wallet"><i class="fa fa-credit-card mr-5"></i> WALLET: <?php echo $wallet->error_message->data->wallet;?></a></p>
											<p><a href="#" data-toggle="modal" data-target="#mydiscount_model"><i class="fa fa-credit-card mr-5"></i> My Discount Codes</a></p>
										</div> -->
									</div>
								</div>
							</div>
						</div>

<!---Modal Wallet Withrawl-->

		<div class="modal fade" id="modal-wallet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
						<h4 class="modal-title text-uppercase">Wallet Transaction</h4> </div>
					<div class="modal-body" style="padding-left: 25px;">
						<div class="title font-18 text-red font-weight-600">Previous History</div>
							<div class="modal-scroll" id="scroll-style">
					<div class="table-responsive">
					<table class="table table-bordered font-12">
                       <thead>
                         <tr>
                               <th>Method</th>
							   <th>Withdrawal Amt.</th>
							   <th>Deposited Amt.</th>
							   <th>Transaction ID</th>
							   <th>Screenshot</th>
							   <th>Remarks</th>
							   <th>By</th>
							   <th class="text-right">Date</th>
     
                       </tr>
                      </thead>
						
						<tbody>
							<?php 
if(count($STD_WALLET_HISTORY->error_message->data)>0){
	foreach($STD_WALLET_HISTORY->error_message->data as $p){ 
							?>
                         <tr>
                               <td><?php echo $p->withdrawl_method;?></td>
							   <td><?php echo $p->withdrawl_amount;?></td>
							   <td><?php echo $p->deposited_amount;?></td>
							   <td><?php echo $p->withdrawl_tran_id;?></td>
							   <td>
<?php if(!empty($p->withdrawl_image)) {?>
							   	<img scr="<?php echo $p->withdrawl_image;?>" width="50" height="50"><?php } else {?>N/A<?php }?></td>
							   <td><?php echo $p->remarks;?></td>
							   <td><?php echo $p->fname.' '.$p->lname;?></td>
							   <td class="text-right"><?php echo $p->created;?></td>
     
                       </tr>
                   <?php }} else {
                   	?>
                   	<tr>
                   		
                   		<td colspan="8">No record</td>
                   	</tr>
                   	<?php 
                   }?>
						
                      </tbody>
						
						
						
						</table>
					</div>
						</div>
						</div>
				</div>
			</div>
		</div>
	
	<!--End Modal Wallet Withrawl-->
	<!---Modal Available Promotions Codes-->
	<div class="avlble-pro-code">
		<div class="modal fade" id="mydiscount_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
						<h4 class="modal-title text-uppercase">Available Promotion Codes</h4> </div>
					<div class="modal-body">
						
						<div class="modal-scroll scroll-style">
						<?php 

if(is_countable($SPECIAL_PROMOCODES->error_message->data) && count($SPECIAL_PROMOCODES->error_message->data)>0){
						foreach($SPECIAL_PROMOCODES->error_message->data as $p)
						{ 
							if($p->discount_type == "Percentage")
							{
								$text1="Get ".$p->max_discount.'%'." OFF up to INR ".$p->not_exceeding;
							}
							else {
								$text1="Get Rs.".$p->max_discount.' OFF';
							}

						?>
						<div class="info mb-20">
							<p class="font-weight-600"><?php echo $text1;?></p>
							<p>Valid on purchase more than equal to  INR <?php echo $p->min_purchase_value;?></p>
							<p> For <?php echo $p->uses_per_user;?> time use only</p>
							<p class="date font-12"> Valid till <?php echo $p->end_date.' '.$p->end_time;?></p>
							<?php if($p->active == 0){?>
								<span class="text-red font-weight-600">Expired</span>
							<?php }?>
							<div class="mt-10 clearfix"> <span class="coupon"><?php echo $p->discount_code;?></span> </div>
						</div>
						<p class="font-weight-500">Use Discount Codes at Checkout</p>
					<?php } } else {?>

<p class="font-weight-500">No Discount Codes available</p>
					<?php }?>
						
						
					
						
					
					</div>
						
				</div>
					</div>
			</div>
		</div>
	</div>
	<!--End Available Promotions Codes-->
						