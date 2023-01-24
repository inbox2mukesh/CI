<section class="bg-lighter checkout">
  <div class="container">
    
    <div class="rw-flex">
      <!-- Start Checkout Details-->
      <div class="main-box" style="width: 100%;">
      <div class="danger-box">
                  <h2>Booking Fail</h2>
                  <?php 
                  if(!empty($exception_msg))
                  {?>
                   <p><?php
                   echo str_replace(". More info here: https://stripe.com/docs/india-exports","",$exception_msg);                  
                   
                   ?></p>
                  <?php  } else {
                    ?>
                    <p>Error....Try again.</p>
                    <?php  }  ?>
                 
                  <!-- <div class="font-14">More details have been sent to your email.</div> -->
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
              window.location.href = "<?php echo site_url(); ?>";
            }, 10000);
  });

</script>