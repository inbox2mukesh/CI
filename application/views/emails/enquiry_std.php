<?php include('email-header.php');?>
<!--Header-->


<!--Content-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 20px;background-color: #fffcf1;border-top: solid 1px #f3eedd;">
<tr>
<td style="font-size:16px; color:#333; line-height:24px; text-align: justify">
<p style="padding:5px 0px;margin:0px;">Dear <?php echo $name;?>,</p>	
<p> 
	<?php echo 'Your message to WOSA Team sent successfully. We will get back to you soon.'; ?>	
</p>
</td>
</tr>

<p>
	<?php echo '<br/>'; ?><?php echo '<br/>'; ?>
	<?php echo 'Thanks and Regards'.'<br/>'; ?>
	<?php echo 'Team: WOSA'; ?>	   	
</p>

<tr>
<td align="right">	
<a href="<?php echo base_url('My_login');?>" style="background-color: #131945;border: none;color: white;padding: 10px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 15px;border-radius: 4px;">LOGIN</a>	
</td>
</tr>
</table>
<!--footer-->
<?php include('email-footer.php');?>