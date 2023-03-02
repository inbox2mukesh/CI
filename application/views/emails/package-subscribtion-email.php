<style>
	td{border:solid 1px #e9e9e9;}

  
	</style>
<?php include('email-header.php');?>
<!--Header-->


<!--Content-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 20px;background-color: #fffcf1;">
<tr>
<td style="font-size:14px; color:#333; line-height:24px; text-align: justify">
<p style="padding:5px 0px;margin:0px;">Dear <?php echo $fname;?>,</p>	
<p style="word-break:break-word;"> 
	<?php echo $email_message.'<br/>'; ?>	
</p>
	
<p style="padding: 0px; margin: 0px; color: #d72a22; font-weight:500">Course Information:</p>

<table width="100%" cellpadding="0" cellspacing="1" style="margin-bottom: 10px;font-size: 14px; border:solid 1px #f3eedd">
<tr>
	<td width="50%" valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;">Course</td>
	<td valign="top" style="padding:4px;"><?php echo $test_module_name;?></td>
</tr>

<?php if($programe_name !='' and $programe_name !='None'){ ?>
<tr>
	<td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Program</td>
	<td valign="top" style="padding:4px;">
    <?php 
      echo $programe_name;
    ?>      
    </td>
</tr>
<?php } ?>

<?php if($batch_name !=''){ ?>
<tr>
	<td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Batch</td>
	<td valign="top" style="padding:4px;"><?php echo $batch_name;?></td>
</tr>
<?php } ?>
<?php if($pack_type !="practice") {?>
<tr>
	<td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Branch</td>
	<td valign="top" style="padding:4px;"><?php if($center_name){echo $center_name;}else{echo NA;}?></td>
</tr>
<?php }?>

</table> 


<p  style="padding: 0px; margin: 0px; color: #d72a22; font-weight:500">Package Information:</p>

<table width="100%" cellpadding="0" cellspacing="1" style="margin-bottom: 10px;font-size: 13px; border:solid 1px #f3eedd">
  <tr>
    <td width="50%" valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Package</td>
    <td valign="top" style="padding:4px;"><?php echo $package_name;?></td>
  </tr>
  
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Cost (Org.)</td>
    <td valign="top" style="padding:4px;"><?php echo $currency.' '.$amount;?></td>
  </tr>
  
  <?php if($discounted_amount>0){ ?>
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Cost (Discounted)</td>
    <td valign="top" style="padding:4px;"><?php echo $currency.' '.$discounted_amount;?></td>
  </tr>
<?php } ?>
  
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Duration</td>
    <td valign="top" style="padding:4px;"><?php echo $duration;?></td>
  </tr>

  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Subscription Date</td>
    <td valign="top" style="padding:4px;"><?php echo $subscribed_on;?></td>
  </tr>

  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Expiry Date</td>
    <td valign="top" style="padding:4px;"><?php echo $expired_on;?> </td>
  </tr>
  
  </table>


<p style="padding: 0px; margin: 0px; color: #d72a22; font-weight:500">Payment Information:</p>


<table width="100%" cellpadding="0" cellspacing="1" style="margin-bottom: 10px;font-size: 13px; border:solid 1px #f3eedd">
  <tr>
    <td width="50%" valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Amount paid</td>
    <td valign="top" style="padding:4px;"><?php echo $currency.' '. $amount_paid;?></td>
  </tr>

  <?php if($waiver>0){ ?>
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Waiver</td>
    <td valign="top" style="padding:4px;"><?php echo $waiver;?></td>
  </tr>
  <?php } ?>

  <?php if($waiver>0){ ?>
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Waiver by</td>
    <td valign="top" style="padding:4px;"><?php echo $waiver_by;?></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Other discount</td>
    <td valign="top" style="padding:4px;"><?php echo $currency.' '. $other_discount;?></td>
  </tr>
  
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Amount due</td>
  	<td valign="top" style="padding:4px;"><?php echo $currency.' '. $amount_due;?></td>
  </tr>
  
  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Payment mode</td>
    <td valign="top" style="padding:4px;"><?php echo $method;?></td>
  </tr>

  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Payment id</td>
    <td valign="top" style="padding:4px;"><?php echo $payment_id;?> </td>
  </tr>

  <tr>
    <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left;padding:4px;">Requested On</td>
    <td valign="top" style="padding:4px;"><?php echo $requested_on;?> </td>
  </tr>
  
  </table>
  


</td>
</tr>


<tr>
<td align="left">	
<a href="<?php echo base_url('my_login');?>" style="background-color: #131945;border: none;color: white;padding:8px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 15px;border-radius: 4px; margin-top:10px;">LOGIN</a>	
</td>
</tr>
</table>
<!--footer-->
<?php include('email-footer.php');?>