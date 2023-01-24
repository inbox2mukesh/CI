 <!-- Start main-content -->
<div class="main-content">
<div class="container mt-10 mb-40">
<h2 class="mb-10 text-uppercase font-weight-300 font-24 text-center"><?php echo $title;?> <span class="text-theme-color-2 font-weight-500"> <?php echo $title2;?></span></h2>
  
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">        
  
  <?php echo $this->session->flashdata('flsh_msg'); ?>
  <div class="form-wrapper">
    <?php echo form_open('our_students/student_otp', array('name'=>'otp-form', 'class'=>'')); ?>
    <div class="form-box">
      <div class="form-group">
      <?php if(isset($_SESSION['lastId_std'])){ ?>
            <label class="font-weight-500 font-16 sr-only" for="otp"><span class="text-danger">*</span> Enter Verification Code:</label>
            <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP" maxlength="4">
            </div>      
      <div class="">
        <button type="submit" class="btn btn-red btn-lg">Submit</button>
            </div>
            <?php } ?>
    </div>
    <?php echo form_close(); ?>   
  </div>      
  <div class="col-md-3"></div>
  </div>
</div>

</div>
  <!-- end main-content -->
</div>