<?php
	$listening =$RT_report_data->error_message->data->listening; 
	$reading = $RT_report_data->error_message->data->reading; 
	$writing = $RT_report_data->error_message->data->writing; 
	$speaking = $RT_report_data->error_message->data->speaking; 
	$oa = $RT_report_data->error_message->data->oa;  
?>
<!doctype html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<title></title>
</head>
<body style="font-family: 'Open Sans', sans-serif; padding:0px; margin:0px;">
<!--	Main Container	 ---->
<div style="border-collapse:separate; position: relative; color: #000000;">		
		
		<!--Header Start---->
		<div style="background: rgb(255,10,5);background: linear-gradient(90deg, rgba(255,10,5,1) 0%, rgba(255,119,1,1) 100%); padding:15px; display: flex; height:70px;">			
			<div style="width:40%; float: left"><img src="<?php echo base_url(LOGO_TOEFL);?>" alt=""></div>	
			<div style="width:60%; float: right;color: #ffffff; font-size:20px;font-weight:bold; text-align: right; font-weight:bold;">
				<div style="margin-top:40px">	TOEFL iBT | Score Report</div>
			</div>	
		</div>
		<!--End Header Start---->
	
	
			<!--Content Middle Part---->
			<div style="background-color: #ffffff; padding:60px 0px 0px 0px;">				
				<div style="display: flex">
						<div style="width:75%; float: left">							
						    <div style="font-size:22px; color: #000000; font-weight:bold; text-transform: uppercase; margin-bottom:20px">
						    	<?php echo $RT_report_data->error_message->data->fname.' '.$RT_report_data->error_message->data->lname;?></div>	
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:18px;">
								<tr>
								<td height="40" align="left" valign="top" style="font-weight:bold">Registration Number : </td>
								<td width="53%" align="left" valign="top"><?php echo $RT_report_data->error_message->data->Registration_ID;?></td>
								</tr>
								<tr>
								<td height="40" align="left" valign="top" style="font-weight:bold">Test Date: </td>
								<td align="left" valign="top"><?php echo $RT_report_data->error_message->data->Date_of_Test;?></td>
								</tr>
								<tr>
								<td height="40" align="left" valign="top" style="font-weight:bold">Report Generated on:</td>
								<td align="left" valign="top"><?php echo $RT_report_data->error_message->data->Date_of_Report;?></td>
								</tr>
								</table>

						</div>	
						<?php
					        if($RT_report_data->error_message->data->gender_name=='Male'){
					          $img = MALE;
					        }elseif($RT_report_data->error_message->data->gender_name=='Female'){
					           $img = FEMALE;
					        }else{ 
					          $img=MALE;      
					        }
      					?>
						<div style="width:25%; float: right; text-align:right"><img src="<?php echo base_url($img);?>" class="brdr" style="border:solid 1px #707070; padding:6px; height:140px; width:140px;"></div>
				</div>
				
				<!--Start Scale Score---->
				<div style="border: solid 2px #000; border-radius: 10px; margin-top: 50px;">					
					<div style="background-color: #ffdecf; border-radius: 10px 10px 0px 0px; line-height:50px; text-align: center; font-weight:bold; height:50px; font-size: 20px;">TOEFL iBT Scaled Score</div>
					
					<div style="background-color: #fff; padding: 30px; border-radius:0px 0px 10px 10px;border-top: solid 2px #000; display: flex;">
						
						<div style="width:35%; float:left;">						
							<div style="position: relative;padding: 0px; margin-top:10px; width:210px; height:185px;">
								
									<?php
										$marks_img 	= "d-".$oa.".png"; 
									?>
									<!-- <img src="<?php echo base_url('resources-f/images/graph/d-0.png');?>">  -->
									<div><img src="<?php echo base_url('resources-f/images/mock_test_reprt_images/graph/'.$marks_img);?>"></div>
													
								<div style="text-align: center; line-height:26px; margin-top:-20px;"><div style="font-size:20px; font-weight:bold"><?php echo $oa;?> </div><div>Out of 120</div></div>
							</div>
						</div>					

						
						<div style="width:65%; float:right;">					
						
						  <div style="display: flex; height:30px; margin-bottom:15px;">
								 <div style="width:25%; float: left; text-align: right; line-height:30px;font-size:18px;">Listening</div>
							     <div style="width:12%; float: left; text-align: right;line-height:30px; font-weight: bold;font-size:18px; padding-right:3%;">
							     	<?php echo $listening;?> 
  								</div>
							    <div style="width:60%; float:right; background-color: #a4a4a4">
							       <div style="width:<?php echo $listening;?>%; background-color:#ff6e01; height:30px"></div>
							     </div>							
							</div>
							
							<div style="display: flex; height:30px; margin-bottom:15px;">
								 <div style="width:25%; float: left; text-align: right; line-height:30px;font-size:18px;">Reading</div>
							     <div style="width:12%; float: left; text-align: right;line-height:30px; font-weight: bold;font-size:18px; padding-right:3%">
							     	<?php echo $reading;?> 
								</div>
							    <div style="width:60%; float:right; background-color: #a4a4a4">
							       <div style="width:<?php echo $reading;?>%; background-color:#ff6e01; height:30px"></div>
							     </div>							
							</div>							
							
							<div style="display: flex; height:30px; margin-bottom:15px;">
								 <div style="width:25%; float: left; text-align: right; line-height:30px;font-size:18px;">Speaking	</div>
							     <div style="width:12%; float: left; text-align: right;line-height:30px; font-weight: bold;font-size:18px; padding-right:3%">
							     	<?php echo $speaking;?>    	
    							</div>
							    <div style="width:60%; float:right; background-color: #a4a4a4">
							       <div style="width:<?php echo $speaking;?>%; background-color:#ff6e01; height:30px"></div>
							     </div>							
							</div>						

							
							<div style="display: flex; height:30px;">
								 <div style="width:25%; float: left; text-align: right; line-height:30px;font-size:18px;">Writing </div>
							     <div style="width:12%; float: left; text-align: right;line-height:30px; font-weight: bold;font-size:18px; padding-right:3%">
								 <?php echo $writing;?>					      	
								</div>
							    <div style="width:60%; float:right; background-color: #a4a4a4">	
								   <div style="width:<?php echo $writing;?>%; background-color:#ff6e01; height:30px"></div>
							     </div>							
							</div>
						</div>						
					</div>
				</div>
				<!--End Scale Score---->
			</div>
			<!--End Content Middle Part---->	
	
			<!--Footer Start---->
			<div style="background: rgb(255,119,1);background: linear-gradient(90deg, rgba(255,119,1,1) 0%, rgba( 255,10,5,1) 100%); padding:20px; color: #ffffff; font-size:16px; height:50px; line-height:24px;bottom: 0;background-color: #ff0a05; position: fixed; width:100%; margin-top:50px;">
					This is a Score Report generated on the basis of Practice Test conducted by Western Overseas and is not valid for any immigration purposes.
			</div>
			<!--Footer End---->
</div>	
	<!--End Main Container---->
</body>
</html>