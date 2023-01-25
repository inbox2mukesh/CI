<?php include('email-header.php');?>
<!--Header-->

<!--Main Content-->
      
       <div style="padding: 30px 0px">
          
          <p style="font-size: 15px; padding: 0px; margin: 0px">Dear <?php echo $student_name;?>,</p>
          <p style="font-size: 15px; padding: 0px; margin: 0px">Ref.No <?php echo $refno;?>,</p>
              
             <p style="font-size: 15px; padding: 0px; margin-top:20px;">
            <?php echo $email_message; ?>
           
           </p>
           <p style="font-size: 15px; padding: 0px; margin: 0px">Session type: <?php echo $session_type;?></p>
              
            <p style="font-size: 15px; padding: 0px; margin-top:20px;">Service: 
            <?php echo $service_id; ?>
            </p>
            <p style="font-size: 15px; padding: 0px; margin-top:20px;">Session Date/Time: 
            <?php echo $booked_date; ?>
            </p>
            <p style="font-size: 15px; padding: 0px; margin-top:20px;">Amount: 
            <?php echo CURRENCY; ?> <?php echo $amount; ?>
            </p>
              <p style="font-size: 15px; padding: 0px; margin-top:20px;">Payment status: 
            <?php echo $payment_status; ?>
            </p>
           
           
          
            
          </div>
      
       <!--End Main Content-->

<?php include('email-footer.php');?>