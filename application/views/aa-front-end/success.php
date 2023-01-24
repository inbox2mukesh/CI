<section class="bg-lighter checkout">
  <div class="container">
   
    <div class="rw-flex">
      <!-- Start Checkout Details-->
      <div class="main-box" style="width: 100%;">
      <div class="success-box">
                  <h2>Booking Done Successfully</h2>
                  <p>Thankyou for Booking with us. </p>
                  <div class="font-14">More details have been sent to your email.</div>
                  <!--End Login Popup-->
                </div>     
      </div>    
      <!-- End  Checkout Details-->     
    </div>
  </div>
</section>
<script>
   $(document).ready(function() {
    setTimeout(function() {
              window.location.href = "<?php echo site_url('our_students/student_dashboard'); ?>";
            }, 10000);
  });
 

</script>