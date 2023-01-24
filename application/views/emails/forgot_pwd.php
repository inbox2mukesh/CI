<!--Header-->
<?php include('email-header.php');?>

<!--Content-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 20px;background-color: #fffcf1;border-top: solid 1px #f3eedd;">
<tr>
	<td style="font-size:16px; color:#333; line-height:24px; text-align: justify">
	<p style="padding:5px 0px;margin:0px;">Dear User,</p>	
	<p>	 
		<?php echo $email_message.'<br/><br/>'; ?>		
		PASSWORD: <?php echo $password.'<br/><br/>'; ?>

		<?php echo $thanks.'<br/>'; ?>
		<?php echo $team; ?>		
	</p>
	</td>
</tr>


</table>
<!--footer-->
<?php include('email-footer.php');?>