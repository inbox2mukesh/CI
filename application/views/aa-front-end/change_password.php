<div class="modal-change-password">
    <div class="modal fade" id="modal-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">		
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
            <h4 class="modal-title text-uppercase">Change Password</h4> </div>
          <div class="modal-body pd-20">
          <div class="alert alert-danger hide font-12" id="fail_pass_update_msg" role="alert"></div>
          <div class="alert alert-success hide font-12" id="success_pass_update_msg" role="alert"></div>
              <div class="form-row clearfix">
                <div class="form-group col-md-12">
                  <label>Previous Password<span class="red-text">*</span></label>
                  <div class="login-pwd-cont">
                    <input type="password" class="fstinput"  id="cp" name="cp"  maxlength="14" autocomplete="off">
                    <span class="fa onepass fa-eye-slash" id="prepassBtn"></span>
                    <div class="validation cp_err"><?php echo form_error('cp');?></div>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label>New Password<span class="red-text">*</span></label>
                  <div class="login-pwd-cont">
                    <input id="np" name="np" type="password" class="fstinput" placeholder="" autocomplete="off">
                    <span class="fa twopass fa-eye-slash" id="npBtn"></span> 
                    <div class="validation np_err"><?php echo form_error('np');?></div>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label>Retype Password<span class="red-text">*</span></label>
                  <div class="login-pwd-cont">
                    <input type="password" class="fstinput" id="cnp" name="cnp" autocomplete="off">
                    <span class="fa threepass fa-eye-slash" id="cnpBtn"></span> 
                    <div class="validation cnp_err"><?php echo form_error('cnp');?></div>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-blue btn-mdl"  onclick="return submit_newpassword();" >CHANGE PASSWORD</button>
                </div>
              </div>
          
          </div>
          </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    
function submit_newpassword()
{
    var cp = $("#cp").val();
    var np = $("#np").val();
    var cnp = $("#cnp").val();  
    if(cp!=''){
      $(".cp_err").text('');
    }else{
      //$("#cp").focus();
      $(".cp_err").text("Please Enter Previous Password!");
      return false;
    }
    if(np!=''){
      $(".np_err").text('');
    }else{
      //$("#np").focus();
      $(".np_err").text("Please Enter New Password!");
      return false;
    }

    if(cnp!=''){
    $(".cnp_err").text('');
    }else{
    //$("#cnp").focus();
    $(".cnp_err").text("Please Enter Retype Password!");
    return false;
    }

   
    $.ajax({
        url: "<?php echo site_url('our_students/change_password');?>",
        type: 'post',
        data:  {cp: cp,np:np,cnp:cnp},        
        success: function(response)
        { 
          if(response.status=='true')
          {
             $('#success_pass_update_msg').removeClass('hide');
             $('#success_pass_update_msg').html(response.msg);
            $('#fail_pass_update_msg').addClass('hide'); 
            setTimeout(function() {
       window.location.href = "<?php echo site_url('our_students/student_dashboard');?>"
      }, 1500);

          }
          else
          {
          $("#cp").val('');
          $("#np").val('');
          $("#cnp").val('');
         // $("#cp").focus();
          $('#success_pass_update_msg').addClass('hide');
          $('#fail_pass_update_msg').removeClass('hide'); 
          $('#fail_pass_update_msg').html(response.msg);  

          } 
                            
        },
        beforeSend: function(){
          $('#btn-complain').hide();
          $('.complaintBtnDiv_pro').show(); 
          $('.mainForm').show();     
        }
    });
    
  }

  const PreBtn = document.querySelector('#prepassBtn');
  PreBtn.addEventListener('click', () => {
  const input = document.querySelector('#cp');
  input.getAttribute('type') === 'password' ? input.setAttribute('type', 'text') : input.setAttribute('type', 'password');
  $('.onepass').toggleClass("fa-eye");
  });

  const npBtn = document.querySelector('#npBtn');
  npBtn.addEventListener('click', () => {
  const input = document.querySelector('#np');
  input.getAttribute('type') === 'password' ? input.setAttribute('type', 'text') : input.setAttribute('type', 'password');
  $('.twopass').toggleClass("fa-eye");
  });

  const cnpBtn = document.querySelector('#cnpBtn');
  cnpBtn.addEventListener('click', () => {
  const input = document.querySelector('#cnp');
  input.getAttribute('type') === 'password' ? input.setAttribute('type', 'text') : input.setAttribute('type', 'password');
  $('.threepass').toggleClass("fa-eye");
  });

  </script>