<?php include('email-header.php');?>
<!--Header-->

<!--Main Content-->
<table width="100%" border="0" cellspacing="20" cellpadding="0" style="background-color: #fffcf1;">  
<tr>
    <td style="font-size:14px; color:#333; line-height:24px; text-align: justify">  

        <p style="font-size:14px; padding: 0px; margin: 0px">Dear <?php echo $student_name;?>,</p>
        <p style="font-size:14px; padding: 0px; margin-top:15px;word-break:break-word;"><span style="font-weight:bold">Ref.No: </span> <?php echo $refno;?>,</p>
        <p style="font-size:14px; padding: 0px; margin-top:15px;word-break:break-word;"> <?php echo $email_message; ?></p>

        <div style="margin-top:10px; margin-bottom:10px;">
        <table width="100%" cellspacing="0" cellpadding="0" style="font-size:14px;">
            <tr>
                <td width="50%" valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;">Session type</td>
                <td valign="top" style="padding:4px;word-break:break-word;"><?php echo $session_type;?></td>
            </tr>   
            
            <tr>
                <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;">Service</td>
                <td valign="top" style="padding:4px;word-break:break-word;"><?php echo $service_id; ?></td>
            </tr>  

            <tr>
                <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;word-break:break-word;">Session Date/Time</td>
                <td valign="top" style="padding:4px;word-break:break-word;"><?php echo $booked_date; ?></td>
            </tr>

            <tr>
                <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;word-break:break-word;">Amount</td>
                <td valign="top" style="padding:4px;word-break:break-word;"><?php echo CURRENCY; ?> <?php echo $amount; ?></td>
            </tr>

            <tr>
                <td valign="top" style="background-color: #efefef; font-weight:bold; text-align:left; padding:4px;word-break:break-word;">Payment status</td>
                <td valign="top" style="padding:4px;word-break:break-word;text-transform: capitalize;"><?php echo $payment_status; ?></td>
            </tr>


        </table>
        </div>
    </td>
</tr>
</table>
<!--End Main Content-->

<?php include('email-footer.php');?>