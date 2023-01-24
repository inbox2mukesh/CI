<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo WOSA;?> Login</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="<?php echo site_url('resources/img/favicon.png');?>" type="image/gif">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/font-awesome.min.css');?>">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/ionicons.min.css');?>">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap-datetimepicker.min.css');?>">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/AdminLTE.min.css');?>">
        <link rel="stylesheet" href="<?php echo site_url('resources/css/_all-skins.min.css');?>">
        <?php echo callCommonJSFileVariables(); ?>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">

            <section class="content">
                <?php
                if(isset($_view) && $_view)
                    $this->load->view($_view);
                ?>
            </section>

            <footer class="main-footer" style="margin-left: 0px !important; ">
                <strong class="text-dark">By: <a href="<?php echo COMPANY_URL; ?>" target="_blank" style="color: #15AE9F"><?php echo COMPANY;?></a> </strong>
            </footer>

        <script src="<?php echo site_url('resources/js/jquery-2.2.3.min.js');?>"></script>
        <script src="<?php echo site_url('resources/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo site_url('resources/js/fastclick.js');?>"></script>
        <script src="<?php echo site_url('resources/js/app.min.js');?>"></script>
        <script src="<?php echo site_url('resources/js/demo.js');?>"></script>
        <script src="<?php echo site_url('resources/js/moment.js');?>"></script>
        <script src="<?php echo site_url('resources/js/bootstrap-datetimepicker.min.js');?>"></script>
        <script src="<?php echo site_url('resources/js/global.js');?>"></script>

<script>

var browserName = (function (agent) {
    switch (true) {
        case agent.indexOf("edge") > -1: return "MS Edge";
        case agent.indexOf("edg/") > -1: return "Edge ( chromium based)";
        case agent.indexOf("opr") > -1 && !!window.opr: return "Opera";
        case agent.indexOf("chrome") > -1 && !!window.chrome: return "Chrome";
        case agent.indexOf("trident") > -1: return "MS IE";
        case agent.indexOf("firefox") > -1: return "Mozilla Firefox";
        case agent.indexOf("safari") > -1: return "Safari";
        default: return "other";
    }
    })(window.navigator.userAgent.toLowerCase());

//document.querySelector("h1").innerText="You are using "+ browserName +" browser";
console.log(browserName);
if( browserName == 'Chrome' || browserName == 'Mozilla Firefox' ||  browserName == 'Edge ( chromium based)' ||  browserName == 'Safari'  ) {
    console.log(browserName);
} else {
    window.location.href = "https://westernoverseas.ca/canada-development/support_browser";
}
 </script>


    </body>
</html>
