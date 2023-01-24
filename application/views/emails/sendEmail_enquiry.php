<!--Header-->
<?php include('email-header.php');?>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border:none!important;">                  
                    <tr>
                        <td style="padding: 20px 0px 20px 0px;">
                             <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;">
                                <tr>
                                    <td align="left" style="color: #ed3237; text-transform:uppercase; font-family: Arial, sans-serif; font-size: 16px; padding:0px;">
                                        <b>Dear <?php echo $fname;?>,</b>
                                    </td>
                                </tr>								
                                <tr>
                                    <td align="left" style="padding: 20px 0px 0px 0px; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height:24px;">
                                        <?php echo $email_message.'<br/><br/>'; ?>										
                                    </td>
                                </tr>                                
                              
                                
                            </table>
                        </td>
                    </tr>					
                </table>
<!--footer-->
<?php include('email-footer.php');?>