<?php include('email-header.php');?>
<!--Header-->


<!--Content-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 20px;background-color: #fffcf1;border-top: solid 1px #f3eedd;">
<tr>
<td style="font-size:16px; color:#333; line-height:24px; text-align: justify">
<p style="padding:5px 0px;margin:0px;">Dear <?php echo $fname;?>,</p>	
<p style="word-break:break-word;"> 
	<?php echo $email_message.'<br/><br/>'; ?>
	USERNAME: <?php echo $username.'<br/>'; ?>
	PASSWORD: <?php echo $password.'<br/><br/>'; ?>		
</p>
	
<p>Course Information:</p>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="font-size: 13px; font-weight: 300; margin-bottom: 10px; background-color: #f0e8ce;">
	<thead>
		<tr style="background-color: #fff4cc;"></tr>
	</thead>	
	<tbody>
		<tr style="background-color: #fff;">
			<td align="center" valign="top">Program: <?php echo $programe_name;?></td>
			<td align="center" valign="top">Course: <?php echo $test_module_name;?></td>
			<td align="center" valign="top">Batch: <?php echo $batch_name;?></td>
		</tr>			
	</tbody>	
</table>

<p>Package Information:</p>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="font-size: 13px; font-weight: 300; margin-bottom: 10px; background-color: #f0e8ce;">
	<thead>
		<tr style="background-color: #fff4cc;"></tr>
	</thead>	
	<tbody>
		<tr style="background-color: #fff;">
		<td align="center" valign="top">Package: <?php echo $package_name;?></td>
		<td align="center" valign="top">Package cost (Org.): <?php echo $amount;?></td>
		<td align="center" valign="top">Package cost (Discounted): <?php echo $discounted_amount;?>></td>
		<td align="center" valign="top">Package duration: <?php echo $duration;?></td>
		<td align="center" valign="top">Package test limit: <?php echo $test_paper_limit;?> </td>
		<td align="center" valign="top">Subscribtion date: <?php echo $subscribed_on;?> </td>
		<td align="center" valign="top">Expiry: <?php echo $expired_on;?> </td>
		</tr>			
	</tbody>	
</table>

<p>Payment Information:</p>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="font-size: 13px; font-weight: 300; margin-bottom: 10px; background-color: #f0e8ce;">
	<thead>
		<tr style="background-color: #fff4cc;"></tr>
	</thead>	
	<tbody>
		<tr style="background-color: #fff;">
		<td align="center" valign="top">Amount paid: <?php echo $amount_paid;?></td>
		<td align="center" valign="top">Waiver: <?php echo $waiver;?></td>
		<td align="center" valign="top">Waiver by: <?php echo $waiver_by;?>></td>
		<td align="center" valign="top">Other discount: <?php echo $other_discount;?></td>
		<td align="center" valign="top">Amount due: <?php echo $amount_due;?> </td>
		<td align="center" valign="top">Payment mode: <?php echo $method;?> </td>
		<td align="center" valign="top">Payment id: <?php echo $payment_id;?> </td>
		<td align="center" valign="top">Requested On: <?php echo $requested_on;?> </td>
		<td align="center" valign="top">Payment id: <?php echo $payment_id;?> </td>
		</tr>			
	</tbody>	
</table>
</td>
</tr>

<p>
	<?php echo $thanks.'<br/>'; ?>
    <?php echo $team; ?>    	
</p>

<tr>
<td align="right">	
<a href="<?php echo base_url('My_login');?>" style="background-color: #131945;border: none;color: white;padding: 10px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 15px;border-radius: 4px;">LOGIN</a>	
</td>
</tr>
</table>
<!--footer-->
<?php include('email-footer.php');?>