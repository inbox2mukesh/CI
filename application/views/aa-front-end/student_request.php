<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
        <?php include('includes/student_profile_sidebar.php'); ?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside complaint dash-main-box"> <span class="top-btn">
				<button type="submit" class="btn btn-red text-uppercase" data-toggle="modal" data-target="#modal-request">Make New Request</button>
			
			</span>
					<div class="top-title mb-15 text-uppercase mb-top-30">Request Made by You</div>
					<div class="row">
						<div class="global-page-scroll" id="scroll-style">
<?php 
//studentRequest

?>
		<?php if(count($studentRequest->error_message->data)>0){
		foreach($studentRequest->error_message->data as $p)
      		{  ?> 
							<div class="col-md-6">
								<div class="request-card mt-5">
									<div class="info">
										<h2>Request ID: <?php echo $p->request_id?></h2>
										<ul>
											<li><span class="mr-5 font-weight-600">Subject:</span><?php echo ucfirst($p->subject);?></li>									
											<li><span class="mr-5 font-weight-600">Status:</span><?php if($p->active == 1){ echo "Active";} else { echo "Closed";}?></li>
											<li><span class="mr-5 font-weight-600">Report Issued On:</span><?php 
											$date=date_create($p->created);
											echo date_format($date,"d-m-Y H:i:s");?></li>
											
										</ul>
										<div class="ftr-btm mt-15"> <span><a href="#" class="btn btn-wht" data-toggle="modal" data-target="#modal-req-details<?php echo $p->id?>">View Details</a></span> <span><a href="#" class="btn btn-conversation" data-toggle="modal" data-target="#modal-req-conversation<?php echo $p->id?>">
												  <span class="btn-label"><i class="fa fa-bell text-white"></i> </span>Conversations</a>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-details">
					<div class="modal fade" id="modal-req-details<?php echo $p->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
									<div class="modal-title text-uppercase">Request Details</div>
								</div>
								<div class="bg-lighter modal-body pd-20">
									<form>
										<div class="form-row clearfix">
											<div class="form-group col-md-12">
												<label>Subject</label>
												<input type="text" class="fstinput" readonly value="<?php echo ucfirst($p->subject);?>"> </div>
											<div class="form-group col-md-12">
												<label>Details</label>
												<textarea class="txtarea" rows="3" style="height:110px;" readonly><?php echo ucfirst($p->request_text);?></textarea>
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
				<div class="modal-conversation">
					<div class="modal fade" id="modal-req-conversation<?php echo $p->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-black"></i></button>
									<div class="modal-title text-uppercase">Conversations - Request ID:<?php echo $p->complain_id?></div>
								</div>
								<div class="bg-lighter modal-body pd-20">
									<div class="font-weight-600 mb-15">Request Registered: <?php 
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
							<?php 
}}
							else {
							?>
							<div class="col-md-6">
								<div><span class="font-weight-600 mr-5">No Request history !</div>
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

  <div class="modal-request">
					<div class="modal fade" id="modal-request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
									<div class="modal-title text-uppercase">Make a Request</div>
								</div>
								<div class="modal-body">
<div class="alert alert-danger hide alert-dismissible  mt-10  " id="sturequest_fail_info" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<div id="sturequest_fail_info_text"></div>
</div>
<div class="alert alert-success hide alert-dismissible  mt-10  " id="sturequest_succ_info" role="alert">

<div id="sturequest_succ_info_text"></div>
</div>
									<form id="stuReqForm" method="post" enctype="multipart/form-data">
										<div class="form-row clearfix">
											<div class="form-group col-md-6">
												<label>Select Subject<span class="red-text">*</span></label>
												<select class="selectpicker form-control" id="request_subject" name="request_subject">
													<option value="">Select</option>
														<?php      
														foreach($requestSubject->error_message->data as $p){        
														?>
														<option value="<?php echo $p->id;?>"><?php echo ucfirst($p->subject);?></option>
														<?php } ?>
												</select>
												<div class="valid-validation request_subject_err"></div>
											</div>
											<div class="form-group col-md-12">
												<label>Please Explain in Detail<span class="red-text">*</span></label>
												<textarea class="txtarea" rows="3" id="request_text" name="request_text"></textarea>
												<div class="valid-validation request_text_err"></div>
											</div>
											<div class="form-group col-md-12">
												<label>Add Attachments (if Required)</label>
												<input type="file" class="file-input" id="req_attachment_file" name="req_attachment_file">
												<p class="font-11"><span class="text-blue">Supported file format </span>jpg, jpeg, png and pdf.</p>
<div class="valid-validation request_fileattach_err"></div>

											</div>
											<div class="col-md-12 text-right">
												<button type="button" class="btn btn-red btn-mdl" onclick="return Send_stu_request();">SEND</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					 
function Send_stu_request()
{
 // document.getElementById("stuReqForm").reset();

   var request_subject = $("#request_subject").val();
    var request_text = $("#request_text").val();
    var attachment_file = $("#req_attachment_file").val().split('\\').pop();
	//alert(attachment_file)
    if(request_subject!=''){
      $(".request_subject_err").text('');
    }else{
      $("#request_subject").focus();
      $(".request_subject_err").text("Please select subject of complaint!");
      return false;
    }
    if(request_text!='' && request_text.length<=150){
      $(".request_text_err").text('');
    }else{
      $("#request_text").focus();
      $(".request_text_err").text("Please enter you message upto 150 chars!");
      return false;
    }
     if(attachment_file !="")
	 {
	  if(validate(attachment_file) == 1)
	  {
      $(".request_fileattach_err").text('');
      }else{
      $("#req_attachment_file").val('');
      $("#req_attachment_file").focus();
      $(".request_fileattach_err").text("File Format not supported!");
      return false;
    }
	 }
	 else {
	 	$("#req_attachment_file").focus();
      $(".request_fileattach_err").text("Please choose file");
      return false;
    }
	 
	 
	 var form = document.getElementById('stuReqForm'); //id of form
var formdata = new FormData(form);
    $.ajax({
        url: "<?php echo site_url('our_students/sendStudentRequest');?>",
        type: 'post',
       // data: form_data,   
     data: formdata,
        processData: false,
        contentType: false,		
        success: function(response)
		{ 	 
			alert(response.status)
			if(response.status=='true')
			{
			$('#stuReqForm').addClass('hide');
			$('#sturequest_succ_info').removeClass('hide');
			$('#sturequest_succ_info_text').html(response.msg);
			}
			else
			{
			$('#stuReqForm').addClass('hide');
			$('#sturequest_fail_info').removeClass('hide');
			$('#sturequest_fail_info_text').html(response.msg);
			}                  
			},
			beforeSend: function(){
			$('#btn-complain').hide();
			$('.complaintBtnDiv_pro').show(); 
			$('.mainForm').show();     
			}
    });
    
  }
  function validate(file) {
	  //alert(file)
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["jpg" , "jpeg", "png",'pdf'];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
      return -1;
        //$("#image").val("");
    }
	else {
		return 1;
	}
}
				</script>