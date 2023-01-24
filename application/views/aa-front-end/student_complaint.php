<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
        <?php include('includes/student_profile_sidebar.php'); ?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside complaint dash-main-box"> <span class="top-btn">
				<button type="submit" class="btn btn-red text-uppercase" data-toggle="modal" data-target="#modal-complaint">Register New Complaint</button>
			
			</span>
					<div class="top-title mb-15 text-uppercase mb-top-30">Complaint Made by You</div>
					<div class="row">
						

						<div class="global-page-scroll" id="scroll-style">
					<?php if(count($student_complaints->error_message->data)>0){ ?>    
					<?php
      		foreach($student_complaints->error_message->data as $p)
      		{        
  				?>

							<div class="col-md-6">
								<div class="complaint-card mt-5">
									<!--									<span class="top-icn"><i class="fa fa-bell text-red"></i></span>-->
									<div class="info">
										<h2>Complaint ID: <?php echo $p->complain_id?></h2>
										<ul>
											<li><span class="mr-5 font-weight-600">Subject:</span><?php echo ucfirst($p->subject);?></li>
											<li><span class="mr-5 font-weight-600">Status:</span></span><?php if($p->active == 1){ echo "Active";} else { echo "Closed";}?></li>
											<li><span class="mr-5 font-weight-600">Report Issued On:</span> <?php 
											$date=date_create($p->created);
											echo date_format($date,"d-m-Y");?></li>
											
										</ul>
										<div class="ftr-btm mt-15"> <span><a href="#" class="btn btn-wht" data-toggle="modal" data-target="#modal-details<?php echo $p->id?>">View Details</a></span> <span><a href="#" class="btn btn-conversation" data-toggle="modal" data-target="#modal-conversation<?php echo $p->id?>">
												  <span class="btn-label"><i class="fa fa-bell text-white"></i> </span>Conversations</a>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-details">
					<div class="modal fade" id="modal-details<?php echo $p->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
									<div class="modal-title text-uppercase">Complaint Details</div>
								</div>
								<div class="bg-lighter modal-body pd-20">
									<form>
										<div class="form-row clearfix">
											<div class="form-group col-md-12">
												<label>Subject</label>
												<input type="text" class="fstinput" readonly value="<?php echo ucfirst($p->subject);?>"> </div>
											<div class="form-group col-md-12">
												<label>Details</label>
												<textarea class="txtarea" rows="3" style="height:110px;" readonly><?php echo ucfirst($p->complaint_text);?></textarea>
											</div>
											
											<div class="col-md-12">
												<?php 
												if($p->attachment_file){
$type =strtolower( pathinfo($p->attachment_file, PATHINFO_EXTENSION));
if($type == 'jpg' OR $type == 'jpeg'  OR $type == 'png')
{

													?>
												<div class="thumb"><img src="<?php echo $p->attachment_file; ?>"></div>
											<?php } else {?>
<div class="thumb"><a href="<?php echo $p->attachment_file; ?>" target="_blank"><?php echo OPEN_FILE;?></a></div>

											<?php }?>
											<?php }?>
											
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
					<!---Modal Conversation Detail-->
				<div class="modal-conversation">
					<div class="modal fade" id="modal-conversation<?php echo $p->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-black"></i></button>
									<div class="modal-title text-uppercase">Conversations - Complaint ID:<?php echo $p->complain_id?></div>
								</div>
								<div class="bg-lighter modal-body pd-20">
									<div class="font-weight-600 mb-15">Complaint Registered: <?php 
											$date=date_create($p->created);
											echo date_format($date,"d-m-Y H:i:s");?></div>
									<div class="hstry-scroll" id="scroll-style">
                   <?php if(count($p->Reply)>0){
                   foreach($p->Reply as $rep_data) {?>
										<div class="chat-history">
											<div class="info-panel"> Reply by: <?php echo $rep_data->fname.' '.$rep_data->lname;?> | Employee ID:<?php echo $rep_data->employeeCode;?> <span class="pull-right"><?php 
											$date=date_create($p->created);
											echo date_format($date,"d-m-Y H:i:s");?></span> </div>
											<div class="chat-panel"><?php echo ucfirst($rep_data->admin_reply);?></div>
										</div>
									<?php }} else{?>
										<div class="chat-history">No Reply
											
										</div>
									<?php }?>
										
									</div>
									<div class="d-line"></div>
									<form>
										<div class="form-group">
											<textarea class="txtarea" rows="3" placeholder="Write your message here"></textarea>
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-blue btn-mdl">SEND</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--End Modal Conversation Detail-->
						<?php } } else {
							?>
							<div class="order-hstry-box">
									<div class="row">
										<div class="col-md-9">
											<div class="info">
												<div><span class="font-weight-600 mr-5">No Complaint history !</div>
												
											</div>
										</div>
										
									</div>
								</div>
							<?php
						} ?>
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

  