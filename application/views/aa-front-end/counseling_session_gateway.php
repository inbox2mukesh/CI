<h4>Please do not refresh or click back button as transaction is in processing</h4>

<form action="<?php echo PP_URL;?>" method="post" name="form-pp" id="gatewayform">
                 <!-- <input type="hidden" name="business" value="sb-kvxdi15155745@business.example.com">
                <input type="hidden" name="image_url" value="http://paypal.local/static/logo.png">
                <input type="hidden" name="charset" value="utf8">
                <input type="hidden" name="item_name" value="Pizza">
                <input type="hidden" name="order_id" value="101">
               <input type="hidden" name="invoice" value="<?php echo $_SESSION['sessionBookingId']?>" / >   
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="amount" value="1">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="return" value="http://localhost/paypal_check/payment-return.php">
                <input type="hidden" name="rm" value="2">
               
                <input type="hidden" name="cancel_return" value="http://localhost/paypal_check/payment-fail.php">
                <input type="submit" value="buy" id="pabtn"> -->

                <!-- ppppp -->

 <input type="hidden" name="business" value="<?php echo $params['business']?>">
                <input type="hidden" name="image_url" value="http://paypal.local/static/logo.png">
                <input type="hidden" name="charset" value="utf8">
                <input type="hidden" name="item_name" value="<?php echo $params['item_name']?>"> 
                <input type="hidden" name="custom" value="<?php echo $_SESSION['sessionBookingId']?>" / > 
                <input type="hidden" name="invoice" value="<?php echo $params['sessBookingNo']?>" / >     
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="amount" value="<?php echo $params['amount']?>">
                <input type="hidden" name="currency_code" value="<?php echo $params['currency_code']?>">
                <input type="hidden" name="cmd" value="<?php echo $params['cmd']?>">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="return" value="<?php echo $params['return']?>">
                <input type="hidden" name="rm" value="<?php echo $params['rm']?>">
               
                <input type="hidden" name="cancel_return" value="<?php echo $params['cancel_return']?>">
                <input type="submit" value="Redirecting to PayPal" >





            </form>

            <script src="<?php echo base_url()?>resources-f/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
     $("#gatewayform").submit();
});
</script>

<!-- 
<script type="text/javascript">
     // disable right click 
    if (document.layers) {
         document.captureEvents(Event.MOUSEDOWN);

         document.onmousedown = function () {
            return false;
        };
    }
    else {
         
        document.onmouseup = function (e) {
            if (e != null && e.type == "mouseup") {
                
                if (e.which == 2 || e.which == 3) {
                   
                    return false;
                }
            }
        };
    }

    //Disable the Context Menu event.
    document.oncontextmenu = function () {
        return false;
    };

    document.onkeydown = ShowKeyCode;
    function ShowKeyCode(evt) {
        if ((evt.keyCode == '123') || (evt.keyCode == '17'))
            return false;
         
    }
</script>
<script>
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
            return false;
        } else {
            return true;
        }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});
</script> -->