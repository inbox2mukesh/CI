<?php include('email-header.php');?>
<!--Header-->

<!--Main Content-->
      
<div style="padding: 30px 0px">
    <p style="font-size: 15px; padding: 0px; margin: 0px">Dear Admin,</p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><?php echo $email_message; ?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Student:</span> <?php echo $student_name;?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Mobile:</span> <?php echo $mobile;?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Email:</span> <?php echo $useremail;?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Ref.No:</span> <?php echo $refno;?></p>                          
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Session type:</span> <?php echo $session_type;?></p>              
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Service:</span> <?php echo $service_id; ?> </p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Session Date/Time:</span> <?php echo $booked_date; ?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Amount:<?php echo CURRENCY; ?></span> <?php echo $amount; ?></p>
    <p style="font-size: 15px; padding: 0px; margin-top:20px;"><span style="font-weight:bold">Payment status:</span> <?php echo $payment_status; ?></p>
</div>
      
       <!--End Main Content-->

<?php include('email-footer.php');?>