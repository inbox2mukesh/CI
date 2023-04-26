<section>
    <div class="container">
      <div class="login-wrapper">
                <h2><i class="fa fa-lock mr-10 font-28"></i> <?php echo $title;?></h2>
                <?php echo $this->session->flashdata('flsh_msg'); ?>
        <?php echo form_open('My_login/index', array('name'=>'login-form', 'class'=>'clearfix')); ?> 
                <div class="form-group">
                  <lable>Username/Email/Mobile/UID<span class="text-white">*</span></lable>
                  <input type="text" id="username" name="username" class="fstinput" type="text" placeholder="Enter Username/Email/Mobile/UID" maxlength="60" value='<?php echo get_cookie('wosa_username_f');?>'>
                  <div class="p-validation"><?php echo form_error('username');?></div>
                </div>
                <div class="form-group">
                  <lable>Password<span class="text-white">*</span></lable>
                  <div class="login-pwd-cont">
                    <input type="password" id="password" name="password" class="fstinput" placeholder="Enter password" value='<?php echo get_cookie('wosa_pwd_f');?>'>
                    <span class="fa fa-eye-slash" id="passBtnstu"></span>
                    <div class="p-validation"><?php echo form_error('password');?></div>
                  </div>
                </div>
                  <?php 
                  if(get_cookie('wosa_username_f') and get_cookie('wosa_pwd_f') ){
                    $checked_f = 'checked= "checked" ';
                  }else{
                    $checked_f = '';
                  }
                ?>
                <div class="form-checkbox text-left mt-20">
                  <input type="checkbox" id="javascript">
                  <label for="javascript" class="text-white" id="rememberme_f" name="rememberme_f" type="checkbox" <?php echo $checked_f; ?> >Remember Me!</label>
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-yellow btn-mdl">SUBMIT</button>
                </div>
                <div class="mt-20 text-right"> <a style="cursor: pointer;" class="text-white" id="forgot_password_n">Forgot Password?</a> </div>

            <?php echo form_close(); ?>
    </div>
      
    </div>
  </section>
  <script type="text/javascript">
    $("#forgot_password_n").click(function()
    {
      
      $('#modal-login').modal('hide');
      $('#modal-password').modal('show');  
    });

$(document).ready( function(){
  $("#passBtnstu").on("click",function(){
    var hrl = $(this).prev().attr("type");
    if ( hrl === 'password' ) {
      $(this).prev().attr("type","text");
      $(".fa-eye-slash").addClass("fa-eye");
    } else {
      $(this).prev().attr("type","password");
      $(".fa-eye-slash").removeClass("fa-eye");
    }
  })
})


  </script>