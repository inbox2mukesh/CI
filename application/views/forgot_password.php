<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"> 
      <img src='<?php echo site_url(LOGO);?>' style="max-width: 290px;"/>
  </div> 
  
  <div class="login-box-body">
    <p class="login-box-msg text-bold"><?php echo $title;?></p>
    <?php echo $this->session->flashdata('flsh_msg');?>
    <form action="" name="fp" id="fp" method="post">      
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control input-ui-100" placeholder="Enter E-mail">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>      

      <div class="row">
        <div class="col-xs-6">
          <input type="submit" name="sbmt_fp" class="btn btn-danger btn-block btn-flat" value="Submit" />        
        </div>
      </div>
    </form>
  </div>
  
</div>


</body>
<?php ob_start(); 

?>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>  -->
<script>
<?php if(ENVIRONMENT=="production" or ENVIRONMENT=="production_testing"){ ?>
$(document).bind("contextmenu",function(e){
    return false;
});
//67-c,86-v,85-u,117-f6,73-i,88-x,83-s,80-p
document.onkeydown = function(e){
  if(e.ctrlKey && 
      (
      e.keyCode === 67 ||
      e.keyCode === 86 || 
      e.keyCode === 85 ||
      e.keyCode === 117 ||
      e.keyCode === 73 || 
      e.keyCode === 88 || 
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
<?php } global $customJs;
  $customJs .= ob_get_clean(); ?>
</script>

