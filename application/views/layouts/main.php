<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="<?php echo site_url(''.DESIGN_VERSION.'/img/favicon.png?v='.JS_CSS_VERSION);?>" type="image/gif">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/bootstrap-select.min.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/bootstrap.min.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/font-awesome.min.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/ionicons.min.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/bootstrap-datetimepicker.min.css?v='.JS_CSS_VERSION);?>">
        <link id="CSSId1" rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/AdminLTE.min.css?v='.JS_CSS_VERSION);?>">
        <link id="CSSId2" rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/_all-skins.min.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/bootstrap.daterangepicker.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/datepicker/css/bootstrap-datepicker.min.css?v='.JS_CSS_VERSION);?>">
		<link rel="stylesheet" href="<?php echo site_url(''.DESIGN_VERSION.'/css/developer-custom.css?v='.JS_CSS_VERSION);?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <?php echo callCommonJSFileVariables(); ?>
    </head>
    <style>
    .skin-blue .main-header .syncdb, .skin-blue .main-header .testdb,.skin-blue .main-header .testdblive {
      z-index: 9999;
      float:left;
      color:#ff1b23;
      order: 1;
      width: 150px;
      padding: 0;
      margin-right: 10px;
    }

    .skin-blue .main-header .testenv {
      z-index: 9999;
      float:left;
      font-size:16px;
      color:#ff1b23;
      vertical-align:middle;
      margin:5px;
      font-weight:bold;
      order: 1;
      width: 150px;
      padding: 0;
      margin-right: 10px;
    }
</style>

    <body class="hold-transition skin-blue sidebar-mini" <?php if(ENVIRONMENT=="production_testing"){?> style="background-color: #ffd35e !important;"; <?php }?>>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo site_url('adminController/dashboard');?>" class="logo" data-toggle="tooltip" data-placement="bottom" title="Go to dashboard">
                    <span class="logo-mini"><img width="175" src=<?php echo site_url(LOGO);?> ></span>
                    <span class="logo-lg"><img width="175" src=<?php echo site_url(LOGO);?> /></span>
                </a>

                <nav class="navbar navbar-static-top" style="background: #15AE9F">
                    <?php  ?>
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                    <?php  if(ENVIRONMENT=="production_testing"){?>
                      <a href="javascript:void(0);" class="testenv" data-toggle="tooltip" data-placement="bottom">
                        <span class="mndb-lg">Testing Enviornment</span>
                    </a>
                     
                   <?php } if(ENVIRONMENT=="production"){?>
                   <?php if($this->Role_model->_has_access_('cron_tab','syncdb')){?>
                    <a href="javascript:void(0);" class="syncdb" data-toggle="tooltip" data-placement="bottom" title="Manual Data Sync" alt="Manual Data Sync">
                    <span class="mndb-lg">Manaul Data Sync</span>
                    <img width="18" title="Manual Data Sync" alt="Manual Data Sync" src="<?php echo site_url('resources/img/manual-data-sncy.svg');?>">
                    </a>
                    <?php }?>
                    <a href="javascript:void(0);" class="testdb" data-toggle="tooltip" data-placement="bottom" title="Go to Testing" alt="Go to Testing">
                    <span class="mndb-lg">Go to Testing</span>
                    <img width="18" title="Go to Testing" alt="Go to Testing" src="<?php echo site_url('resources/img/go-to-testing.svg');?>">
                    </a>
                    <?php } if(ENVIRONMENT=="production_testing"){?>
                    <a href="javascript:void(0);" class="testdblive" data-toggle="tooltip" data-placement="bottom" title="Go to Live" alt="Go to Live">
                    <span class="mndb-lg">Go to Live</span>
                    <img width="18" title="Go to Live" alt="Go to Live" src="<?php echo site_url('resources/img/go-to-live.svg');?>">
                    </a>
                    <?php }?>
                        <ul class="nav navbar-nav">
                            <?php                                
                                $data = $this->session->userdata(SESSION_VAR);
                                foreach ($data as $d){
                                    $role_id=$d->role_id;
                                    $role_name=$d->role_name;
                                    $homeBranch=$d->homeBranch;
                            ?>
                            <li class="dropdown user user-menu">
                                <a href="javascript:void(0);">
                                    Server Time: <span id="LiveTime"><?php echo date("d-M-Y h:i A"); ?></span>
                                </a>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-placement="bottom" title="Click here">
                                    <i class="fa fa-user"></i>
                                    <span class="hidden-xs"><?php echo $d->role_name;?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                       <i class="fa fa-user text-danger"></i>
                                    <p>
                                        <?php
                                            echo 'Hi '.$d->fname;
                                            $date=date_create($d->created);
                                            $Member_since = date_format($date,"M d, Y");
                                        ?>
                                        <small>Employee Role : <i><?php echo $d->role_name;?></i></small>
                                        <small>Home Branch: <i><?php echo $homeBranch;?></i></small>
                                        <small>Member since: <i><?php echo $Member_since;?></i></small>
                                    </p>
                                    </li>
                                    <!-- Menu Footer-->

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo site_url('adminController/user/profile_');?>" class="btn btn-pro"><i class="fa fa-user"></i> Profile</a>
                                        </div>
                                        <div class="pull-right">
                                        <a href="<?php echo site_url('adminController/Login/logout/'.RL);?>" class="btn btn-pro"><i class="fa fa-sign-out"></i> Log out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <?php include('menu.php');?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <?php if(isset($_view) && $_view){                        
                        $this->load->view($_view);
                    }
                    ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <strong>By: <a href="<?php echo COMPANY_URL;?>" target="_blank" style="color: #15AE9F;"><?php echo WOSA;?></a></strong>
            </footer>
            <aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                </div>
            </aside>
            <div class="control-sidebar-bg"></div>
        </div>

        <!-- sync db popup -->
        <div id="confirm" class="modal" style="padding-left:17px !important;">
          <div class="modal-body" style="background:#FFFFFF; font-size:18px; font-weight:bold; text-align:center;">
            Testing Environment
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="saveid">OK</button>
          </div>
        </div>
        <!-- sync db popup -->

<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/jquery-3.6.0.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/jquery.validate.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/bootstrapnew.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/bootstrap-select.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/fastclick.js?v='.JS_CSS_VERSION);?>"></script>
<script id = "JSId1" src="<?php echo site_url(''.DESIGN_VERSION.'/js/app.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/demo.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/moment.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/bootstrap-datetimepicker.min.js?v='.JS_CSS_VERSION);?>"></script>
<script id = "JSId2" src="<?php echo site_url(''.DESIGN_VERSION.'/js/global.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/ckeditor/ckeditor.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/bootstrap3-wysihtml5.all.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/bootstrap.daterangepicker.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/datepicker/js/bootstrap-datepicker.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="<?php echo site_url(DESIGN_VERSION . '/js/sweetalert2.all.min.js?v='.JS_CSS_VERSION); ?>"></script>
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/common.js?v='.JS_CSS_VERSION);?>"></script>
<script type='text/javascript' src="<?php echo site_url(''.DESIGN_VERSION.'/js/jquery.inputmask.bundle.js?v='.JS_CSS_VERSION);?>"></script>

<!-- prabhat -->
<script type='text/javascript' src="<?php echo site_url(''.DESIGN_VERSION.'/js/jquery.cookie.min.js?v='.JS_CSS_VERSION);?>"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->
<script type = "text/javascript">
<?php if(ENVIRONMENT=="production_testing"){?>  
     function blink_text() {
    $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
}
setInterval(blink_text, 1000); 
<?php }?>   
  /* history.pushState(null, null, location.href);
    window.onpopstate = function (){
        history.go(1);
    };*/    

$(document).ready(function(){
<?php if(ENVIRONMENT=="production_testing"){?>
if (!$.cookie("noticeaccepted")){
    $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
    })
    .on('click', '#saveid', function(e){
    $.cookie("noticeaccepted", 1, { expires : (1*24*60*60*1000) });
    $('#confirm').modal.model('hide');
    });        
}else{
    $('#clearCookie').show();
}
<?php }?>

    $(document).on('click', '.syncdb', function(){
        jQuery('.loading').show();
        $.ajax({
            url: "<?php echo site_url('adminController/setting_global/syncdb');?>",
            async : true,
            type: 'post',
            data: {},
            dataType: 'json',
            crossDomain:true,
            success: function(response){
            jQuery('.loading').hide();
            alert("Successfully data synced");
            window.location.href="<?php echo TESTINGURL;?>";
            }
        });
    });

    $(document).on('click', '.testdb', function(){    
        window.location.href="<?php echo TESTINGURL;?>";   
    });

    $(document).on('click', '.testdblive', function(){ 
        $.removeCookie("noticeaccepted");
        window.location.href="<?php echo LIVEURL;?>";                
    });

});
</script>
<!-- prabhat -->

<script>
<?php if(ENVIRONMENT=="production" or ENVIRONMENT=="production_testing"){ ?>
$(document).bind("contextmenu",function(e){
    return false;
});
//67-c,86-v,85-u,117-f6,73-i,88-x,83-s,80-p
document.onkeydown = function(e){
  if(e.ctrlKey && 
      (
      e.keyCode === 85 ||
      e.keyCode === 117 ||
      e.keyCode === 73 ||      
      e.keyCode === 80 ||
      e.keyCode === 83)){
        return false;
  }else{
    return true;
  }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey){
    return false;
  }else{
    return true;
  }
});
<?php } ?>

 var browserName = (function (agent){
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
    window.location.href = '<?php echo base_url("/support_browser");?>';
}


function subtractMinutes(numOfMinutes, date = new Date()) 
{
	date.setMinutes(date.getMinutes() - numOfMinutes);
	return date;
}
function addMinutes(numOfMinutes, date = new Date()) 
{
	date.setMinutes(date.getMinutes() + numOfMinutes);
	return date;
}
const date = new Date();
	<?php
	if(DEFAULT_COUNTRY==38){ ?>
	let caDate = subtractMinutes(<?php echo TIME_DIFF;?>, date);
	<?php }	else if(DEFAULT_COUNTRY==13) {
	?>
	let caDate = addMinutes(<?php echo TIME_DIFF;?>, date);
	<?php 
	} else { ?>
	let caDate = addMinutes(<?php echo TIME_DIFF;?>, date);
	<?php }?>

$('.datepicker_timezone').datepicker({
startDate: caDate,
autoclose:true,
});


</script>
<?php
global $customJs;
echo $customJs;
?>
</body>
</html>