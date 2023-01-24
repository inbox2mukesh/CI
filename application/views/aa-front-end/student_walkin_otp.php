<!-- Start main-content -->
<div class="main-content">
<div class="container mt-10 mb-40">
<h2 class="mb-10 text-uppercase font-weight-300 font-24 text-center"><?php echo $title1;?> <span class="text-theme-color-2 font-weight-500"> <?php echo $title2;?></span></h2>
  
<div class="row">
<div class="col-md-3"></div>
  <div class="col-md-6">
        
    <?php echo $this->session->flashdata('flsh_msg'); ?>
    <div class="resend_otpMsg"></div>        
    <div class="form-wrapper">      
     <?php echo form_open('walkin/student_walkin_otp', array('name'=>'walkin-otp-form', 'class'=>'clearfix form-inline')); ?>
      <?php if(isset($_SESSION['walkin_lastId_std'])){ ?>
      <div class="form-box otp-form">       
          <div class="form-group">
            <label class="font-weight-500 font-16 sr-only" for="otp">
              <span class="text-danger">*</span> Enter Verification Code:
            </label>
            <input type="text" class="form-control col-md-10" name="otp" id="otp" placeholder="Enter OTP" maxlength="4">

              <button type="submit" class="btn btn-red btn-lg ml-10">Submit</button>

             <span class="text-danger small otp_err"><?php echo form_error('otp');?></span>
              <div>  <a href="javascript:void(0);" class="otp_form" style="color: #1068c3;" onclick="resendOTP()">Resend Verification Code?
                      </a></div>
              <div class="proBtn" style="display: none"><i class="fa fa-spinner fa-spin mr-10"></i></div>
          </div>        
         <div> 
       
        </div>
      </div>
      <?php } ?>
      <?php echo form_close(); ?>
    </div>
      
  <div class="col-md-3"></div>
  </div>  
  </div>
</div>  
<!-- end main-content -->
</div>

<script type="text/javascript">

  function resendOTP(){

    var id = '<?php echo $_SESSION['walkin_lastId_std'];?>';
    //alert(id)    
    $.ajax({
        url: "<?php echo site_url('walkin/resendOTP');?>",
        type: 'post',
        data: {id: id},                              
        success: function(response){ 
          
          if(response.status=='true'){
            //alert(response.status)
            $('.proBtn').hide(); 
            $('.resend_otpMsg').show();
            $('.resend_otpMsg').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OTP Resent on your Email. Please enter.<a href="#" class="alert-link"></a>.</div>');              
          }else{                 
            $('.resend_otpMsg').hide();
          }                  
        },
        beforeSend: function(){
          $('.proBtn').show();     
        }
  });
}

</script>