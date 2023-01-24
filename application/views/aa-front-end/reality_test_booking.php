<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
        <?php include('includes/student_profile_sidebar.php'); ?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside dash-main-box">
					<div class="top-title mb-15 text-uppercase"><?php echo $title;?> </div>
					<div class="row">
						<div class="global-page-scroll" id="scroll-style">
							<?php if(count($RT_booking->error_message->data)>0){ 
      		foreach($RT_booking->error_message->data as $p){

      		$location=$p->venue_rt.''.$p->center_name;      
  		?>
							<div class="col-md-4">
								<div class="lt-clr-box reality-booking mt-5">
									<div class="card-info">
										<h4><?php echo $p->title;?></h4>
										<ul class="mt-10">
											<li><span class="font-weight-600 mr-5">Booking Date:</span><?php echo $p->bookingDate;?></li>
											<li><span class="font-weight-600 mr-5">Candidate Number:</span><?php echo $p->candidateNumber;?></li>
											<li><span class="font-weight-600 mr-5">Events Date:</span> <?php echo $p->eventDate;?></li>
											<li><span class="font-weight-600 mr-5">Time:</span><?php echo $p->timeSlot;?></li>
											<li><span class="font-weight-600 mr-5">Location:</span><?php echo $location;?></li>
										</ul>
										<div class="ftr-btm">
											<div> <span class="font-weight-600">Status: </span>
												<?php if($p->status == 'Active') {?>
											 <span class="text-green"><?php echo $p->status;?></span>
											 <?php } else {?>
 <span class="text-red"><?php echo $p->status;?></span>
											 	<?php }?></div>
											<div><a href="<?php echo base_url('our_students/download_reality_test_acknowledge');?>" class="btn btn-wht mt-10">Download Acknowledge</a></div>
										</div>
									</div>
								</div>
							</div>
						<?php }} else { ?>
							<div class="col-md-6">
								<div><span class="font-weight-600 mr-5"> No Reality Test Booking is available !</div>
							</div>
							<?php	} ?>					
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
<div class="alert alert-danger hide alert-dismissible  mt-10  " id="sturequest_succ_info" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
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
														<option value="<?php echo $p->id;?>"><?php echo $p->subject;?></option>
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