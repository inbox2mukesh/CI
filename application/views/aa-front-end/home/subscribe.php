<section class="bg-red-theme">
      <div class="container">
        <div class="white-box">
        <h3>Get Latest News, Articles, Free Practice Material, Best Tips and Techniques</h3>
          <div class="wdth-80">
               <div class="subs-group">
                        <input type="text" class="subs-input form-control" placeholder="Please Enter Your Email" name="subscription_email" id="subscription_email">             
                         <button class="btn btn-red btn-subs" onclick="return send_subscription();" id="send_sub_btn" type="button">SUBSCRIBE</button>            
                       </div>
             <div class="validation hide error_sub">Wrong!</div> 

  <div class="alert alert-danger hide alert-dismissible  mt-10  " id="sub_error_info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
 <div id="sub_error_info_text"></div>
  
</div>
        </div>
          
        </div>        
        </div>  
</section>

<div class="subscription-otp" >
    <div class="modal fade" id="subscription-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <div class="reg-modal clearfix"> <span class="cross-btn pull-right text-black " data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
              <div class="reg-otp-info text-center text-black ">
                <h3>Verification Code</h3>
                <p class="mb-10 font-12 " id="sub_success_info"></p>
                
                  <div class="form-group">
                  <div class="subs-group" id="optmain_sec">
                    <input type="text" class="form-control" name="subs_otp" id="subs_otp" maxlength="4" placeholder="Please Enter OTP" style="height:55px;">
                    <input type="hidden" id="sub_id" name="sub_id"/>
                     <button class="btn btn-blue btn-subs"  onclick="return Verify_sub_opt(this.value);" id="verifyBtn" type="button">Verify</button>      
                  </div>
                  <div class="validation hide subs_reg_otp_err" > Wrong OTP!</div>
                  </div>
                  <div class="alert alert-success hide alert-dismissible  mt-10  " id="otp_sub_success_info" role="alert">               
                    <div id="opt_sub_success_info_text"></div>
                  </div>
                  <div class="alert alert-danger hide alert-dismissible  mt-10  " id="otp_sub_error_info" role="alert">
                    <div id="opt_sub_error_info_text"></div>
                  </div>               
              </div>
              <!--End Login Popup-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript"> 

function send_subscription()
{
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
  var email = $("#subscription_email").val();
  if(email == "" || email == null)
    {
    $("#subscription_email").focus();
    $(".error_sub").removeClass('hide');
    $(".error_sub").text('Please enter valid Email Id');
    return false;
    }
    if (echeck(email)==false){

    $("#subscription_email").focus();
    $(".error_sub").removeClass('hide');
    $(".error_sub").text('Please enter valid Email Id');
    return false;
    }
     $.ajax({
        url: "<?php echo site_url('home/subscribe_send');?>",
        type: 'post',
        data: {email:email},                
        success: function(response)
        {
          if(response.status=='true')
          {
          $('#subscription-OTP').modal('show');
          $('#sub_success_info').text(response.msg); 
          $('#sub_id').val(response.id); 
          $("#subscription_email").val("");           
          }
          else
          {       
          $('#sub_error_info').removeClass('hide');
          $('#sub_error_info_text').html(response.msg);
          $("#subscription_email").val("");
          }                
        },
        beforeSend: function(){
        $(".error_sub").addClass('hide');
      
        }
    });

    
}

function Verify_sub_opt()
{

  var reg_otp = $("#subs_otp").val();
  var sub_id= $('#sub_id').val(); 
  if(reg_otp!='')
  {
      $(".subs_reg_otp_err").text('');
      $('#subsreg_opt_danger').addClass('hide'); 
  }
  else{
      $("#reg_otp").focus();
     $('#otp_sub_error_info').removeClass('hide'); 
     $('#opt_sub_error_info_text').html("Please Enter OTP"); 
      return false;
  }


  $.ajax({
        url: "<?php echo site_url('home/Verify_subscription');?>",
        type: 'post',
        data: {otp: reg_otp,sub_id:sub_id},                              
        success: function(response){        
        // alert( JSON.stringify(response))
          if(response.status=='true')
          {
              $('#subs_otp').val(''); 
              
               $('#optmain_sec').addClass('hide'); 
              $('#otp_sub_error_info').addClass('hide');   
              $('#otp_sub_success_info').removeClass('hide'); 
              $('#opt_sub_success_info_text').html(response.msg);             
          }
          else
          {
              $('#subs_otp').val(''); 
              $('#otp_sub_success_info').addClass('hide');   
              $('#otp_sub_error_info').removeClass('hide'); 
              $('#opt_sub_error_info_text').html(response.msg); 
             
          }                  
        }
       
    });

}

</script>