  <!-- Start main-content -->
<div class="bg-lighter">
<div class="display-flex">
<div class="login-side-panel">
<div class="login-side-panel-content text-white">
  <h3 class="text-white">Western Overseas Study Abroad</h3>
  <p class="font-16">Recover your password if forgotten.</p>
</div>
</div>    

<div class="login-panel">
  <div class="login-box">
     <div class="text-center "><h4 class="heading-title text-white text-uppercase mb-0"><i class="fa fa-key red-text font-30 mr-5" aria-hidden="true"></i>  <?php echo $title;?></h4></div>
      <?php echo $this->session->flashdata('flsh_msg'); ?>
      <?php echo form_open('forgot_password', array('name'=>'fp-form', 'class'=>'clearfix')); ?>
        <div class="row">               
          <div class="form-group col-md-12">
            <p class="text-yellow info">We will send system genereted new password on your email</p>  
            <label class="text-white">Email ID:</label>
            <input type="email" id="email" name="email" class="form-control" maxlength="60" placeholder="Enter Your Registered Email Id">
             <span class="text-white email_err"><?php echo form_error('email');?></span>
          </div>          
        </div>
              
        <div class="form-group">
          <button type="submit" class="btn btn-red btn-lg mr-10">SUBMIT</button> 
        </div>
      <?php echo form_close(); ?>
  </div>
</div>
</div>
<!-- end main-content -->
</div>