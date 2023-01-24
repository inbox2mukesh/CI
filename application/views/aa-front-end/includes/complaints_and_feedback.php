<div class="modal-compalaint">
		<div class="modal fade" id="modal-complaint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close text-white"></i></button>
						<div class="modal-title text-uppercase">Register a Complaint</div>
					</div>
					<div class="modal-body">
						<div class="modal-scroll" id="scroll-style">
						<form id="first_form" method="post" enctype="multipart/form-data">
								<div class="form-row clearfix">
									<div class="form-group col-md-4 col-sm-6">
										<div>
											<label>Select Subject<span class="red-text">*</span></label>
											<select class="selectpicker form-control"  name="complain_subject_comp" id="complain_subject_comp">
												<option value="">Select subject</option>
												<?php      
      foreach($complaintSubject->error_message->data as $p){        
    ?>
    <option value="<?php echo $p->id;?>"><?php echo $p->subject;?></option>
  <?php } ?>
											</select>
										</div>
										  <div class="valid-validation complain_subject_comp_err"></div>   
									</div>
									<?php 
  if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
     $disabled_sel="disabled='disabled'";
  }else{
    $readOnly='';
    $disabled_sel="";
  }
?>
									<div class="form-group col-md-4 col-sm-6">
										<div>
											<label>First Name<span class="red-text">*</span></label>
											<input type="text" class="fstinput" name="fname_comp" id="fname_comp" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?>  maxlength="30" > </div>
										 <div class="valid-validation fname_err_comp"></div> 
											
											</div>
									<div class="form-group col-md-4 col-sm-6">
										<div>
											<label>Last Name<span class="red-text">*</span></label>
											<input type="text" class="fstinput" name="lname_comp" id="lname_comp" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>"  <?php echo $readOnly;?>  maxlength="30">
<div class="valid-validation lname_err_comp"></div>  
											</div>
									</div>
									<div class="form-group col-md-4 col-sm-6">
										<div>
											<label>Country Code<span class="red-text">*</span></label>
											<select class="selectpicker form-control" data-live-search="true" id="country_code" name="country_code"  <?php echo $disabled_sel;?> <?php echo $readOnly;?>>
												<option value="">Select</option>
												 <?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
											</select>
										</div>
									</div>
									<div class="form-group col-md-4 col-sm-6">
										<div>
											<label>Mobile Number<span class="red-text">*</span></label>
											<input type="text" class="fstinput" name="mobile_comp" id="mobile_comp" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>"  <?php echo $readOnly;?>  maxlength="10">
											<div class="valid-validation mobile_err_comp"></div>   
										</div>
									</div>
									<div class="form-group col-md-4 col-sm-6">										
										<div>
											<label>Email<span class="red-text">*</span></label>
											<input type="email"  <?php echo $readOnly;?> class="fstinput" autocomplete="off" name="email_comp" id="email_comp" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>"  maxlength="60"> 
											 <div class="valid-validation email_err_comp"></div>
											</div>
											
									</div>
									<div class="form-group col-md-12">
										<div>
											<label>Please Explain in Detail<span class="red-text">*</span></label>
											<textarea class="txtarea" placeholder="Write your complaint message upto 150 words.." rows="3" class="form-control" name="complaint_text_comp" id="complaint_text_comp" ></textarea>
											<div class="valid-validation complaint_text_err"></div>
										</div>
									</div>
									<div class="form-group col-md-12">
										<div>
											<label>Add Attachments (if Required)</label>
											<input type="file" class="form-control-file file-bg mt-5 mb-10" id="attachment_file" name="attachment_file">
											<p class="font-12"><span class="text-blue">Supported file format </span><?php echo COMPLAIN_ATTACHMENT_FILE_IMAGE_TYPES.'|'.COMPLAIN_ATTACHMENT_FILE_VIDEO_TYPES.'|'.COMPLAIN_ATTACHMENT_FILE_AUDIO_TYPES; ?></p>
											 <div class="valid-validation attachment_err_comp"></div>
										</div>
									</div>
									
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-red btn-mdl complaintBtn" onclick="return Send_Complaints();" id="btn-complain">SUBMIT</button>
									</div>
									<div class="col-md-12 complaintBtnDiv_pro text-right" style="display: none;">
									<button type="button" class="btn btn-blue complaintBtn_pro">Sending please wait..</button> <i class="fa fa-spinner fa-spin mr-10"></i>
									</div>
									<div class="col-md-12 msg_comp"></div>
								</div>
								</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript"> 


function validate_complaint_email(email){
  
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(email.match(mailformat)){
        $(".email_err_comp").text('');
        $('.complaintBtn').prop('disabled', false);  
        return true;
    }else{
        $(".email_err_comp").text("Please enter valid email Id!");
        $('#email').focus();
        $('.complaintBtn').prop('disabled', true);
        return false;
    }
}
  
function Send_Complaints(){
  
    var numberes = /^[0-9-+]+$/;
    var letters = /^[A-Za-z ]+$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;

    var complain_subject = $("#complain_subject_comp").val();
    var fname = $("#fname_comp").val();
    var lname = $("#lname_comp").val();
    var mobile = $("#mobile_comp").val();
    var email = $("#email_comp").val();
    var complaint_text = $("#complaint_text_comp").val();
    var country_code = $("#country_code").val();
    var attachment_file = $("#attachment_file").val().split('\\').pop();
	
    if(complain_subject!=''){
      $(".complain_subject_comp_err").text('');
    }else{
      $("#complain_subject_comp").focus();
      $(".complain_subject_comp_err").text("Please select subject of complaint!");
      return false;
    }

    if(fname.match(letters)){
      $(".fname_err_comp").text('');
    }else{
      $("#fname").focus();
      $(".fname_err_comp").text("Please enter valid Name. Numbers not allowed!");
      return false;
    }

   /* if(lname.match(letters)){
      $(".lname_err_comp").text('');
    }else{
      $("#lname").focus();
      $(".lname_err_comp").text("Please enter valid Name. Numbers not allowed!");
      return false;
    }*/
	

    if(mobile.match(numberes)){
      $(".mobile_err_comp").text('');
    }else{
      $("#mobile").focus();
      $(".mobile_err_comp").text("Please enter valid number. Alphabets not allowed!");
      return false;
    }

    if(mobile.length>10 || mobile.length<10){
      $("#mobile").focus();
      $(".mobile_err_comp").text('Please enter valid Number of 10 digit');
      return false;
    }else{ 
     $(".mobile_err_comp").text('');
    }

    if(emailReg.test(email)){
        $(".email_err_comp").text('');
      }else{ 
       $("#email").focus();
       $(".email_err_comp").text('Please enter valid Email Id');
       return false;
    }

    if(complaint_text!='' && complaint_text.length<=150){
      $(".complaint_text_err").text('');
    }else{
      $("#complaint_text").focus();
      $(".complaint_text_err").text("Please enter you message upto 150 chars!");
      return false;
    }
     if(attachment_file !="")
	 {
	  if(validate(attachment_file) == 1)
	  {
      $(".attachment_err_comp").text('');
      }else{
      $("#attachment_file").val('');
      $("#attachment_file").focus();
      $(".attachment_err_comp").text("File Format not supported!");
      return false;
    }
	 }
	 //return false;
	 var form = document.getElementById('first_form'); //id of form
var formdata = new FormData(form);
    $.ajax({
        url: "<?php echo site_url('Complaints/send_complaint');?>",
        type: 'post',
       // data: form_data,   
     data: formdata,
        processData: false,
        contentType: false,		
        success: function(response)
		{ 
			
          if(response.status=='true')
		  {
			   $('#modal-complaint').modal('hide');
			   $('#modal-OTP').modal('show');		
      }
		  else
		  {
            $('.complaintBtnDiv_pro').hide();
            $('.msg_comp').html(response.msg);
            $('.otpform').hide(); 
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
    var arrayExtensions = ["jpg" , "jpeg", "png",'pdf','mp4','webm','ogg','mp3','wav','mpeg'];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
      return -1;
        //$("#image").val("");
    }
	else {
		return 1;
	}
}
</script>