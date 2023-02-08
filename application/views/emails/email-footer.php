<div class="d-flex" style="border-top:solid 1px #ccc; padding-top:20px;"> 	 
	 <div class="bx-1">		 
		 <div style="display: flow-root">
		 <p style="font-size: 13px; padding: 0px; margin: 0px 0px 2px 0px"><?php echo THANKS;?></p>
		 <p style="font-size: 13px; padding: 0px; margin: 0px 0px 2px 0px"><?php echo COMPANY;?></p>
		 <p style="font-size: 13px; padding: 0px; margin: 0px 0px 2px 0px"><a href="<?php echo base_url('contact_us');?>" style="background-color: #d72a22;border:none;color:white;padding: 5px 9px;text-align:center;text-decoration:none;display:inline-block;font-size: 12px;border-radius:4px;margin-top:10px" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://westernoverseas.ca/canada-development/my_login&amp;source=gmail&amp;ust=1671527440441000&amp;usg=AOvVaw3fQffHmXIufoqH9s3Trb2k">Contact us</a></p>
		</div>	
		 </div>
		<?php 
		if(DEFAULT_COUNTRY !='13') { //not Australia
		?>
		<div class="bx-2">		 
		<img src="<?php echo base_url('resources-f/images/cer-logo.png');?>" style="width:270px;">
		</div>
		<?php }?>
		   <div class="bx-3">		 
		<div class="mrgn-top-50">
		<a href="<?php echo FB;?>"><img src="<?php echo base_url('resources/img/f-icn.png');?>" width="25" height="25" style="margin-right:0px;"></a>
		<a href="<?php echo TWT;?>"><img src="<?php echo base_url('resources/img/t-icn.png');?>"width="25" height="25" style="margin-right:0px;"></a>
		<a href="<?php echo INST;?>"><img src="<?php echo base_url('resources/img/i-icn.png');?>" width="25" height="25" style="margin-right:0px;"></a>
		<a href="<?php echo YTD;?>"><img src="<?php echo base_url('resources/img/y-icn.png');?>" width="25" height="25" style="margin-right:0px;"></a>
		<?php 
		if(DEFAULT_COUNTRY !='13') { //not Australia
		?>
		<a href="<?php echo TTK;?>"><img src="<?php echo base_url('resources/img/tiktok.png');?>" width="25" height="25" style="margin-right:0px;"></a>
		<?php }?>
			   </div>
		 </div>
	 </div>
</div>
</body>
</html>