<style>
.table-ui-scroller{padding:0px;}
.prevnext-cont{text-align:right;}

/* Added by Vikram 8-12-22 */
/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 5px 35px;
  font-size: 16px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
  </style>

<div class="user-profile_widget">
<!-- <section class="content-header">
      <h1>        Profile      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section> -->
    <?php echo $this->session->flashdata('flsh_msg');?>
    <span class="msg"></span>

     <span class="msg"></span>
         <!-- Main content -->
    <section class="">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary" style="margin-bottom:0px;">
            <div class="box-body box-profile">
              <?php

                  $data = $this->session->userdata(SESSION_VAR);
                  foreach($data as $d){
                    if($d->waiver_power==1){
                      $wp='<span class="text-success">YES</span>';
                    }else{
                      $wp='<span class="text-danger">NO</span>';
                    }

                    if($d->refund_power==1){
                      $rp='<span class="text-success">YES</span>';
                    }else{
                      $rp='<span class="text-danger">NO</span>';
                    }
             ?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo site_url('resources/img/user2-160x160.jpg');?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $d->fname.' '.@$d->lname.' | '.$d->employeeCode;?></h3>
              <p class="text-muted text-center"><?php echo @$d->role_name.'/'.$d->homeBranch;?></p>
              <p class="text-muted text-center"><?php echo @$userFunctionalBranch;?></p>
              <ul class="list-group list-group-unbordered" style="margin-top:25px;">
                <li class="list-group-item">
                  <b><i class="fa fa-gavel pro-icn"></i></b> <?php echo 'Waiver Power: '.$wp;?> </li>

                <li class="list-group-item">
                  <b><i class="fa fa-history pro-icn"></i></b> <?php echo 'Refund Power: '.$rp;?>  </li>

                <li class="list-group-item">
                  <b><i class="fa fa-envelope pro-icn"></i></b> <a href="mailto:<?php echo $d->email;?>"><?php echo $d->email;?></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-phone pro-icn"></i></b> <?php echo $d->country_code_offc.'-'.$d->mobile;?>
                </li>
                 <li class="list-group-item">
                  <?php
                    $date=date_create(@$d->dob);
                    $dob = date_format($date,"M d, Y");
                  ?>
                  <b><i class="fa fa-birthday-cake pro-icn"></i></b><?php echo $dob;?>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-home pro-icn"></i></b> <?php echo $d->residential_address;?>
                </li>
                <li class="list-group-item">
                  <?php
                    $date=date_create($d->created);
                    $created = date_format($date,"M d, Y");
                  ?>
                  <b><i class="fa fa-calendar pro-icn"></i></b>Member Since:  <?php echo $created;?>
                </li>
              </ul>
              <!-- <a href="<?php echo site_url('adminController/user/edit/'.base64_encode($d->id));?>" class="btn btn-danger btn-block"><b><i class="fa fa-edit"></i> Update profile</b></a> -->
            </div>
            <?php } ?>
          </div>

          <!-- About Me Box -->
         <!--  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5 text-danger"></i> Education</strong>
              <p class="text-muted">
                ---
              </p>
              <hr>
            </div>
          </div> -->
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-9">
       

          <div class="nav-tabs-custom" style="padding:13px; border-radius:8px;min-height:545px;margin-bottom:0px;">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Today activity logs</a></li>
              <li><a href="#cp" data-toggle="tab">Change password</a></li>
            </ul>

            <div class="tab-content">

              <div class="tab-pane mt-15" id="cp">
                <!-- <form action="user/change_password" method="post" class='form-horizontal' onsubmit = "return validate_cp();"> -->
                  <?php echo form_open_multipart('adminController/user/change_password', array('class'=>'form-horizontal', 'onsubmit' => 'return validate_cp();')); ?>

                  <div class="form-group">
                    <label for="op" class="col-sm-3 control-label">Rules:</label>
                    <div class="col-sm-9">                   
                      <span class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters(Upto 14 chars max.)</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="op" class="col-sm-3 control-label">Old password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control input-ui-100" name="op" id="op" placeholder="Enter old passowrd" maxlength="30" autocomplete="off" onblur="check_old_pwd(this.value)">
                      <span class="text-danger" id="op"><?php echo form_error('op');?></span>
                      <span class="text-danger" id="op_err"></span>
                    </div>

                  </div>

                  <div class="form-group">
                    <label for="np" class="col-sm-3 control-label">New password</label>
                    <div class="col-sm-9">
                    <input  class="form-control input-ui-100" type="password" id="np" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter new passowrd" maxlength="14" autocomplete="off">
                      <span class="text-danger np_err"><?php echo form_error('np');?></span>
                    </div>
                  </div>
                  

                  <div class="form-group">
                    <label for="rnp" class="col-sm-3 control-label">Re-confirm new password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control input-ui-100" name="rnp" id="rnp" placeholder="Re-enter new password" maxlength="30" autocomplete="off">
                      <span class="text-danger rnp_err"><?php echo form_error('rnp');?></span>
                    </div>
                  </div>

                  <div class="form-group form-checkbox">
                  <div class="col-sm-3">&nbsp;</div>
                    <!-- <label for="spp" class="col-sm-2 control-label">Show Password</label> -->
                    <div class="col-sm-9">
                      <input id="spp" type="checkbox" onclick="showPwd('np','rnp')">
                      <label for="spp" class="">Show Password</label>
                    </div>
                  </div>

                  <div class="form-group  mt-30">
                  <div class="col-sm-3">&nbsp;</div>
                    <div class="col-sm-9">
                      <button type="submit"  id="submit_profile"class="btn btn-danger rd-20">Submit</button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                  <div id="message">
                  <h4>Password must contain the following:</h4>
                  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                  <p id="number" class="invalid">A <b>number</b></p>
                  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
              </div>
            
            
          
              <div class="tab-pane active" id="activity">  
              <div class="clearfix"><a href="<?php echo site_url('adminController/user/user_activity_'); ?>" class="pull-left text-blue">More Activity log</a></div>
                <div class="table-ui-scroller">
              <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">           
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Activity</th>
                        <th>Desc.</th>
                        <th>Pack</th>
                        <th>Lat/Long</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>IP</th>
                        <th>Proxy?</th>
                        <th>Suspicious?</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php $sr=0;foreach($UserActivityData as $ua){ $zero=0;$one=1;$pk='activity_id'; $table='user_activity';$sr++;

                      if($ua['isProxy']==0){
                        $isProxy = 'N';
                      }elseif($ua['isProxy']==1){
                        $isProxy = '<span class="text-danger">Y</span>';
                      }else{
                        $isProxy = NA;
                      }

                      if($ua['isSuspicious']==0){
                        $isSuspicious = 'N';
                      }elseif($ua['isSuspicious']==1){
                        $isSuspicious = '<span class="text-danger">Y</span>';
                      }else{
                        $isSuspicious = NA;
                      }

                      if($ua['description']!=''){
                        $description = $ua['description'];
                      }else{
                        $description = NA;
                      }

                    ?>
                    <tr>
                        <td><?php echo $sr;?></td>
                        <td><?php echo $ua['activity_name'];?></td>
                        <td><?php echo $description;?></td>
                        <td><?php echo $ua['student_package_id'];?></td>
                        <td><?php echo $ua['latitude'].','.$ua['longitude'];?></td>
                        <td><?php echo $ua['country'];?></td>
                        <td><?php echo $ua['state'];?></td>
                        <td><?php echo $ua['city'];?></td>
                        <td><?php echo $ua['IP_address'];?></td>
                        <td><?php echo $isProxy;?></td>
                        <td><?php echo $isSuspicious;?></td>
                        <td><?php echo $ua['created'];?></td>
                    </tr>
                  <?php } ?>
                    </tbody>
                </table>
                </div>
                </div>


            </div>
       
            <div class="tab-pane" id="activity">
                No contents here !
            </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
 <script>
// Added by Vikram 8-12-22
var myInput = document.getElementById("np");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
	document.getElementById("submit_profile").style.disable = "true";
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
	document.getElementById("submit_profile").style.disable = "false";
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>