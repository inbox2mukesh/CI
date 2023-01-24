<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: 'Montserrat', sans-serif;">
    <div style="display:block; clear:both; margin:0 auto; padding: 10px 20px; box-shadow: 0 0px 5px #ccc; border:1px solid #ccc; border-radius: 16px;">
        <div style=" width:50%; float: left;">
            <a href="#"> <img src="<?php echo base_url(LOGO_IELTS); ?>" width="200"></a>
        </div>
        <div style=" width:50%; float: left;">
            <h3 style=" margin-bottom: 0px; margin-top: 15px; font-family: 'Montserrat', sans-serif; text-align: right; text-transform: uppercase; color: #e01f24; font-size: 14px; padding: 0px;"><b>Non - Refundable</b></h3>
            <h3 style="font-family: 'Montserrat', sans-serif; text-align: right; text-transform: uppercase; color: #e01f24;font-size: 14px; padding: 0px;margin: 0px;"><b>Non - Transferable</b></h3>
        </div>
        <div style="clear: both; display: block;"></div>
    </div>

    <div style="display:block; clear:both; margin:20px auto 0; padding: 10px 20px; box-shadow: 0 0px 5px #ccc; border:1px solid #ccc; border-radius: 16px;">
        <div style=" border-bottom:1px solid #ccc; width:100%; margin-bottom: 10px; padding-bottom: 10px; clear:both; display: inline-flex;">
            <div style="float:left; width:50% ;">
                <h3 style="text-transform: uppercase; font-size: 16px;">Client Details</h3>
                <div style="font-size: 13px; text-transform: uppercase; margin-bottom: 9px;"><b>client name - </b><?php echo $Reciept_data->error_message->data->fname . ' ' . $Reciept_data->error_message->data->lname; ?></div>
                <div style="font-size: 13px; text-transform: uppercase; margin-bottom: 9px;"><b>UID - </b><?php echo $Reciept_data->error_message->data->UID; ?></div>
                <div style="font-size: 13px; text-transform: uppercase; margin-bottom: 9px;"><b>phone number - </b><?php echo $Reciept_data->error_message->data->country_code; ?> <?php echo $Reciept_data->error_message->data->mobile; ?></div>
                <div style="font-size: 13px; text-transform: uppercase; margin-bottom: 9px;"><b>email - </b><?php echo $Reciept_data->error_message->data->email; ?></div>
            </div>

            <div style="float:left; width:50% ;">
                <h3 style=" text-align: right; margin:50px 0 10px;font-size: 14px;">PAYMENT-ID - <span style="font-weight: normal;"><?php echo $Reciept_data->error_message->data->payment_id; ?></span></h3>
                <h3 style=" text-align: right;text-transform: uppercase; font-size: 14px;">ORDER id - <span style="font-weight: normal;"><?php echo $Reciept_data->error_message->data->order_id; ?></span></h3>
                <div style=" text-align: right; font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 9px;"><b>Dated -</b> <?php echo $Reciept_data->error_message->data->requested_on; ?></div>
            </div>

        </div>

        <div style="clear: both; display: block;"></div>
        <div class="clear: both;">
            <h3 style="text-transform: uppercase; font-size: 16px; margin-bottom: 20px;">ORDER DETAILS</h3>
            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>Order Name</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->package_name; ?></div>
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>
            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>Products/Services</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->test_module_name; ?>  <?php if($Reciept_data->error_message->data->programe_name !='None') { echo "- ".$Reciept_data->error_message->data->programe_name;} ?> / <?php echo $Reciept_data->error_message->data->pack_type; ?></div> 
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>
            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>VALID FROM</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->subscribed_on; ?></div>
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>


            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>VALID TILL</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->expired_on; ?></div>
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>


            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>PRICE</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->currency.' '.$Reciept_data->error_message->data->amount; ?></div>
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>

            <?php
            $p_od = explode(' ', $Reciept_data->error_message->data->other_discount);
            if ($Reciept_data->error_message->data->other_discount!= '0.00') { ?>
                <div style="clear: both;">
                    <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>DISCOUNT - PROMO - 10%</b></div>
                    <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->currency.' '.$Reciept_data->error_message->data->other_discount; ?></div>
                </div>
                <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 20px;"></div>
            <?php } ?>

            <?php
            $p_wai = explode(' ', $Reciept_data->error_message->data->waiver);
            if ($Reciept_data->error_message->data->waiver != '0.00') { ?>
                <div style="clear: both;">
                    <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>DISCOUNT - PROMO - 10%</b></div>
                    <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"> <?php echo $Reciept_data->error_message->data->waiver; ?></div>
                </div>
                <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 20px;"></div>
            <?php } ?>

            <div style="clear: both;">
                <div style=" float: left; width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"><b>TOTAL PAID</b></div>
                <div style=" float: right;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;"><?php echo $Reciept_data->error_message->data->currency.' '.$Reciept_data->error_message->data->amount_paid; ?> </div>
            </div>
            <div style="clear: both; border-bottom:1px dotted #ccc; margin-bottom: 15px;"></div>

            <div style="clear: both;text-align: right;">
                <div style=" display:inline; border-bottom:1px dotted #ccc; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;">
                    <?php                   
                    $numberInput = $Reciept_data->error_message->data->amount_paid;
                    $numberInput= intval(str_replace(',', '', $numberInput));
                    $locale = 'en_CA';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, $numberInput);
                    echo  $Reciept_data->error_message->data->currency.' - ' . $in_words;
                    ?>
                </div>
            </div>

            <div style="clear: both;  margin-bottom: 15px;"></div>

            <?php
                $Reciept_data->error_message->data->wallet_amount;           
                if ($Reciept_data->error_message->data->wallet_amount != '0.00' and !empty($Reciept_data->error_message->data->wallet_amount)){
            ?>
                <div style="clear: both;">
                    <div style=" float: left;  width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"></div>
                    <div style=" float: right; border-bottom:1px dotted #ccc;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;">
                        <div style="float: left; width: 50%; text-align: left;">PAID FROM WALLET</div>
                        <div style="float: right; width: 50%; text-align: right;"><?php echo $Reciept_data->error_message->data->currency.' '.$Reciept_data->error_message->data->wallet_amount; ?></div>

                    </div>
                </div>
                <div style="clear: both; margin-bottom: 10px;"></div>
            <?php } ?>
            <div style="clear: both;">
                <div style=" float: left;  width: 50%; padding-bottom: 4px; font-size: 13px; text-transform: uppercase;"></div>
                <div style="float: right; border-bottom:1px dotted #ccc;  width: 50%; padding-bottom: 4px; text-align: right; font-size: 13px; text-transform: uppercase; font-weight: 500;">
                    <div style="float: left; width: 50%;  text-align: left;">PAID </div>
                    <div style="float: right; width: 50%; text-align: right;"><?php echo $Reciept_data->error_message->data->currency.' '.$Reciept_data->error_message->data->amount_paid; ?></div>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div style="display:block; clear:both;margin:20px auto 0; padding: 10px 20px; box-shadow: 0 0px 5px #ccc; border:1px solid #ccc; border-radius: 16px;">

        <div style=" width:50%; float: left;">
            <h4 style="text-transform: uppercase; font-size: 12px; "><?php echo COMPANY; ?></h4>
            <div style="text-transform: uppercase; font-size: 11px; margin-bottom: 5px;"><b><?php echo COMPANY_ADDRESS; ?></b></div>
            <div style="text-transform: uppercase; font-size: 11px;margin-bottom: 5px;"><b>Helpline - <?php echo SUPPORT_CONTACT; ?></b></div>
            <div style="text-transform: uppercase; font-size: 11px; margin-bottom: 20px;"><b>Email - <?php echo ADMIN_EMAIL; ?></b></div>
            <div style="text-transform: uppercase; font-size: 11px; margin-bottom: 5px;"><b>PAN ACCOUNT NUMBER: <?php echo PAN_ACCOUNT_NUMBER; ?></b></div>
            <div style="text-transform: uppercase; font-size: 11px;"><b>GST NUMBER: <?php echo GST_NUMBER; ?></b></div>
        </div>

        <div style=" width:50%; float: left;">
            <img style=" float: right; margin-bottom: 5px;" src="<?php echo STAMP; ?>" width="100">
            <div style="clear: both;"></div>
            <div style="text-transform: uppercase; font-size: 13px; font-weight: 500; margin-bottom: 5px; text-align: right;">Auth. Signatory</div>
            <div style="text-transform: uppercase; font-size: 11px;text-align: right;"><b>For <?php echo COMPANY; ?></b></div>
        </div>
        <div style="clear: both; display: block;"></div>
    </div>
</body>
</html>