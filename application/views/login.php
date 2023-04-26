<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo" > 
    <img src='<?php echo site_url(LOGO);?>' style="max-width: 290px;"/>
  </div>

  <div class="login-box-body">
    <p class="login-box-msg text-bold">WOSA ADMIN LOGIN PORTAL</p>
    <?php echo $this->session->flashdata('flsh_msg');?>
    <form action="" name="login" id="login" method="post" >      
      
      <div class="form-group has-feedback">
        <input type="text" name="email" value='<?php echo $callfromview->dataDecryption(get_cookie(COOKIE_USERNAME));?>' class="form-control input-ui-100" placeholder="Enter Employee code">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="passwrd" value='<?php echo $callfromview->dataDecryption(get_cookie(COOKIE_PWD));?>' class="form-control input-ui-100" id="dashlogin" placeholder="Enter PASSWORD">
        <span class="fa fa-eye-slash form-control-feedback" id="dashBtn"></span>
      </div>

      <div class="row">
        <div class="col-xs-6" style="padding-left:25px;">

          <div class="form-group form-checkbox">  
            <?php 
                if(get_cookie(COOKIE_USERNAME) and get_cookie(COOKIE_PWD)){
                  $checked = 'checked= "checked" ';
                }else{
                  $checked = '';
                }
            ?>              
            <input type="checkbox" name="rememberme" id="rememberme" <?php echo $checked; ?> >
            <label for="rememberme">  Remember Me</label>
          </div>

        </div>
        
        <div class="col-xs-6">
          <input type="submit" name="sbmt" class="btn btn-danger btn-block btn-flat" value="Log In">
          <div class="text-right mt-25"> <a href="<?php echo base_url('adminController/forgot_password');?>">Forgot password?</a></div>
        </div>

      </div>
    </form>
  </div>
  
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script> 
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=2.exp&signed_in=true"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=test" async></script>


<script type="text/javascript">
$( document ).ready(function() {
    getLocation()
});
function getLocation(){
  if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(showPosition);
  }else{ 
    alert("Geolocation is not supported by this browser.");
    return false;
  }
}

function showPosition(position){
                
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  //alert(latitude);alert(longitude);
  if(!latitude || !longitude){
    window.location.href = window.location.href
  }else{             
    document.cookie = "user_Latitude="+latitude+"";
    document.cookie = "user_Longitude="+longitude+"";
    return true;
  }
              
}

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
<?php } ?>

const dashBtn = document.querySelector('#dashBtn');
  dashBtn.addEventListener('click', () => {
  const input = document.querySelector('#dashlogin');
  input.getAttribute('type') === 'password' ? input.setAttribute('type', 'text') : input.setAttribute('type', 'password');
  $('.fa-eye-slash').toggleClass("fa-eye");
  });
</script>
</body>



