<?php include('email-header.php');?>
<!--Header-->

<!--Main Content-->
      
       <div style="padding: 30px 0px">
         <p style="font-size: 15px; padding: 0px; margin: 0px">Dear <?php echo $student_name;?>,</p>
          <p style="font-size: 15px; padding: 0px; margin-top:20px;">
            <?php echo $email_message; ?>          
           </p>
          
         
          <p style="font-size: 15px; padding: 0px; margin: 0px">Your Booking Reference is: <?php echo $refno;?></p>        
                    
           
           <div style="margin-top: 30px;">
           
             <p style="font-size: 15px; padding: 0px; margin-bottom:6px"><?php echo $thanks;?>
            </p>
            
            <p style="font-size: 15px; padding: 0px; margin: 0px"><?php echo $team; ?></p>
           
           </div>
            
          </div>
      
       <!--End Main Content-->

<?php include('email-footer.php');?>