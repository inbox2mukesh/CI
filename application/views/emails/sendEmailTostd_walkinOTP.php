<?php include('email-header.php');?>
<!--Header-->


<!--Content-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 20px; background-color: #fffcf1;border-collapse: collapse; border:none!important;">
<tr>
<td style="font-size:16px; color:#333333!important; line-height:24px; text-align: justify">
<p style="padding:5px 0px;margin:0px;">Dear <?php echo $fname;?>,</p>	
<p> 
	<?php echo $email_message; ?>	
</p>
	

</td>
</tr>

</table>
<!--footer-->
<?php include('email-footer.php');?>