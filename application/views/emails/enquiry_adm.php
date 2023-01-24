<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Email-MasterPrep</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 10px 30px 10px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="left" style="padding: 40px 0 30px 30px;">
                            <img src="<?php echo site_url('resources/img/mp-logo.jpg');?>" alt="MasterPrep Logo" style="display: block;" />
                        </td>
						<td align="right" style="vertical-align: top;">
                            <img src="<?php echo site_url('resources/img/header.png');?>" height="200" alt="MasterPrep Logo Theme" style="display: block;width:100%; max-width: 200px" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 40px 30px 20px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="left" style="color: #ed3237; text-transform:uppercase; font-family: Arial, sans-serif; font-size: 16px;">
                                        <b>Dear <?php echo $name;?>,</b>
                                    </td>
                                </tr>								
                                <tr>
                                    <td align="left" style="padding: 20px 0 0px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Enquiry from Masterprep student are as follows:</p>
                                        <?php 
                                            if($programe_id==11){
                                                $programe_name="Academic";
                                            }else{
                                                $programe_name="General Training";
                                            }
                                        ?>
                                        <p>
                                        	student Name: <?php echo $student_name;?>
                                            <?php echo '<br/>';?>
                                            Email: <?php echo $email;?>
                                        	<?php echo '<br/>';?>
                                        	Contact Number: <?php echo $mobile;?>
                                        	<?php echo '<br/>';?>
                                            Course: <?php echo $test_module_name;?>
                                            <?php echo '<br/>';?>
                                            Student Type: <?php echo $programe_name;?>
                                            <?php echo '<br/>';?>
                                            Branch: <?php echo $center_name.' '.$city_name;?>
                                            <?php echo '<br/>';?>
                                        	Message/Query: <?php echo '<br/>';?>
                                            <?php echo $message;?>
                                        </p>

                                        <p>Note: Reply back ASAP</p>

                                        <p>
										<?php echo '<br/>'; ?><?php echo '<br/>'; ?>
										<?php echo 'Thanks and Regards'.'<br/>'; ?>
										<?php echo 'Team: Masterprep'; ?>
										</p>
                                    </td>
                                </tr>
                                
                                
                                
                            </table>
                        </td>
                    </tr>
					<?php include('email-footer.php');?>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>