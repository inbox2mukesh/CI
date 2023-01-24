<section class="bg-lighter">
      <div class="container">
        <div class="section-title mb-10 text-center">
          <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0">POPULAR<span class="red-text font-weight-500">  PRACTICE PACKS</span></h2> </div>
        <div class="scroll-tab">
          <ul class="nav nav-tabs text-center">
             <li class="active"> <a href="#PP-All" data-toggle="tab">All</a></li>
<?php
          foreach($AllTestModule_PP->error_message->data as $p){
        ?>
        <li><a href="<?php echo '#'.$p->test_module_name;?>" data-toggle="tab"><?php echo $p->test_module_name;?></a></li>
        <?php } ?>
          </ul>
        </div>
        <div id="myTabContent" class="tab-content pb-0">
          <div class="tab-pane fade in active" id="PP-All">
            <!--START THUMB GRID CONTAINER -->
            <div class="thumb-grid-container">
              <div class="thumb-grid-flex-cont4">
                <!--Start Items-->
                <?php
                 // echo "<pre>";
                  //print_r($AllPack_PP);
                  //die();
      foreach($All_Pack_PP->error_message->data as $p)
      {
       $package_id=$p->package_id;
  ?>
                 <div class="thumb-grid-card-container4">
                  <div class="thumb-grid-card">
                  <a href="#" class="text-blue" data-toggle="modal" data-target="#allModal<?php echo $p->package_id;?>" data-keyboard="false" data-backdrop="static">
                        <div class="practice-pack">
                          <div class="img-area"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
                            <div class="disc">
                              <ul>
                                <li><i class="fa fa-angle-right"></i>    <?php echo 'Validity: '.$p->duration.' Days';?>  </li>
                                <?php if($p->mock_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->mock_test_count.' Full Length Mock Test';?> 
                </li>
              <?php } ?>

              <?php if($p->listening_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->listening_test_count.' Sectional Listening Test';?> 
                </li>
              <?php } ?>

              <?php if($p->speaking_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->speaking_test_count.' Sectional Speaking Test';?> 
                </li>
              <?php } ?>

              <?php if($p->reading_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->reading_test_count.' Sectional Reading Test';?> 
                </li>
              <?php } ?>

              <?php if($p->writing_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->writing_test_count.' Sectional Writing Test';?> 
                </li>
              <?php } ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> Test Evaluation and Feedback</li>
                              </ul>
                            </div>
                          </div>
                          <div class="img-text">
                            <h4><?php echo substr($p->package_name, 0,28);?> </h4>
                            <h5 class="text-black"><?php echo $p->test_module_name;?> <?php if($p->test_module_name=='IELTS'){echo '| '.$p->programe_name;}?></h5>
<?php if($p->amount>$p->discounted_amount){ ?>
            <span class="price-strike text-black"><span class="font-14">Rs. </span> <strike><?php echo $p->amount;?></strike></span>
          <?php } ?>

                            <div class="price"><?php echo $p->discounted_amount;?><span class="font-14">Rs. </span></div>
                            <div class="ft-btn btn btn-blue">Purchase Now</div>
                          </div>
                        </div>
                      </a>
                  </div>
                </div>
                <!--modal-->
              <div class="modal fade modal-lg ppmodal" id="allModal<?php echo $p->package_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
              <div class="modal-header" style="border-bottom: none; padding: 0px;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="modal-btn-close"><i class="fa fa-close red-text font-16"></i> Close</span> </button>
              </div>
              <div class="modal-content">
              <div class="pp-modal">
              <div class="modal-scroll" id="scroll-style">
              <div class="row">
              <?php 
              if(isset($this->session->userdata('student_login_data')->id)){
              $readOnly='readonly="readonly" ';
              $readOnly_dis='disabled="disabled" ';
              }else{
              $readOnly=''; 
              $readOnly_dis=""; }?>
              <div class="col-md-5 col-sm-5">
              <div class="practice-pack-active" id="flex">
              <div class="img-area" id="a"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
              <div class="disc">
              <ul>
              <li><i class="fa fa-angle-right"></i>    <?php echo 'Validity: '.$p->duration.' Days';?>  </li>
              <?php if($p->mock_test_count>0){ ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
              <?php echo $p->mock_test_count.' Full Length Mock Test';?> 
              </li>
              <?php } ?>

              <?php if($p->listening_test_count>0){ ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
              <?php echo $p->listening_test_count.' Sectional Listening Test';?> 
              </li>
              <?php } ?>

              <?php if($p->speaking_test_count>0){ ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
              <?php echo $p->speaking_test_count.' Sectional Speaking Test';?> 
              </li>
              <?php } ?>

              <?php if($p->reading_test_count>0){ ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
              <?php echo $p->reading_test_count.' Sectional Reading Test';?> 
              </li>
              <?php } ?>

              <?php if($p->writing_test_count>0){ ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
              <?php echo $p->writing_test_count.' Sectional Writing Test';?> 
              </li>
              <?php } ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> Test Evaluation and Feedback</li>
              </ul>
              </div>
              </div>
              <div class="img-text" id="b">
              <h4><?php echo substr($p->package_name, 0,28);?>  <br class="text-brake">  <span class="text-black"><?php echo $p->test_module_name;?> <?php if($p->test_module_name=='IELTS'){echo '| '.$p->programe_name;}?></span></h4>
              <?php if($p->amount>$p->discounted_amount){ ?>
              <span class="price-strike text-black"><span class="font-14">Rs. </span> <strike><?php echo $p->amount;?></strike></span>
              <?php } ?>
              <?php $ty=1;?>
              <div class="price"><?php echo $p->discounted_amount;?><span class="font-14">Rs. </span></div>
              </div>
              </div>
              </div>
              <div class="col-md-7 col-sm-7">
              <div class="modal-box-info">
              <form action="#" method="post" enctype="multipart/form-data" id="ppform<?php echo $ty;?><?php echo $p->package_id;?>" class="mt-15 theme-bg">
              <input type="hidden" value="<?php echo $p->package_id;?>" name="package_id" id="package_id" />                 
              <div class="form-group">
              <input type="text" class="fstinput is-invalid" placeholder="First Name" name="online_fname" id="online_fname<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?>  maxlength="30">
              <div class="validation font-11 red-text online_fname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
              </div>     
              <div class="form-group">
              <input type="text" class="fstinput" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $ty;?><?php echo $package_id;?>" class="fstinput" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>"    maxlength="30"> 
              <div class="validation font-11 red-text online_lname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
              </div>      
              <div class="row">
              <div class="col-sm-6">                 
              <div class="form-group">
              <select class="selectpicker form-control" <?php echo $readOnly_dis;?>  data-live-search="true"  name="online_country_code" id="online_country_code<?php echo $ty;?><?php echo $package_id;?>">
              <option value="">Country Code</option>
              <?php 
              $c='+91';
              foreach ($countryCode->error_message->data as $p)
              {  
              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
              } 
              ?>
              </select>
              <div class="validation font-11 red-text online_country_code_error<?php echo $ty;?><?php echo $package_id;?>"></div>
              </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
              <input type="text" class="fstinput" placeholder="Valid Phone" name="onlinec_mobile" id="onlinec_mobile<?php echo $ty;?><?php echo $package_id;?>" placeholder=""  value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>"   maxlength="10" <?php echo $readOnly;?>> 
              <div class="validation font-11 red-text online_mobile_error<?php echo $ty;?><?php echo $package_id;?>"></div>
              </div>
              </div>
              </div>                     
              <div class="form-group ">                
              <div class="has-feedback">
              <input  name="dob" id="dob<?php echo $ty;?><?php echo $package_id; ?>" type="text" class="fstinput datepicker"  value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" placeholder="DOB*" maxlength="10" autocomplete='off' readonly="readonly"  <?php echo $disabled_sel;?>> 
              <span class="fa fa-calendar form-group-icon"></span> </div>
              <div class="validation onldob_error<?php echo $ty;?><?php echo $package_id; ?>"><?php echo form_error('dob');?></div>
              </div>
              <div class="form-group">
              <input type="email" class="fstinput" placeholder="Valid Email" name="online_email" id="online_email<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" onblur="validate_complaint_email(this.value)"  maxlength="60"  <?php echo $readOnly;?> > 
              <div class="validation font-11 red-text online_email_error<?php echo $ty;?><?php echo $package_id;?>"></div>
              </div>
              <input type="hidden" value="<?php echo $price2;?>" id="programe_booking_price" name="programe_booking_price"/>
              <div class="clearfix mt-20"> 
              <span class="pull-right">
              <input type="hidden" value="practice" name="pack_type" id="pack_type" />
              <button type="button" class="btn btn-red btn-mdl font-weight-600" onclick="return check_booking(<?php echo $package_id;?>,<?php echo $ty;?>);" >Checkout <i class="fa fa-angle-right ml-5"></i></button>
              </span> </div>
              </form>
              </div>
              </div>
              </div>
              </div>
              </div>
              </div>
              </div>
              </div>
  <!--modal-->
                  <?php } ?>
                
              
              </div>
            </div>
            <!--END THUMB GRID CONTAINER -->
          </div>
                      <!--START THUMB GRID CONTAINER -->
            
          <div class="tab-pane fade" id="IELT">
              <div class="thumb-grid-flex-cont4">
                <!--Start Items-->
                <?php foreach($All_IELTS_Pack_PP->error_message->data as $p){ 
 $package_id=$p->package_id;
                  ?>
                <div class="thumb-grid-card-container4">
                  <div class="thumb-grid-card">
                    <a href="#" class="text-blue" data-toggle="modal" data-target="#ieltsModal<?php echo $p->package_id;?>" data-keyboard="false" data-backdrop="static">
                      <div class="practice-pack">
                        <div class="img-area"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
                          <div class="disc">
                          <ul>
                          <?php if($p->mock_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                          <?php echo $p->mock_test_count.PP_MOCK_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->listening_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                          <?php echo $p->listening_test_count.PP_L_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->speaking_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                          <?php echo $p->speaking_test_count.PP_S_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->reading_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                          <?php echo $p->reading_test_count.PP_R_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->writing_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                          <?php echo $p->writing_test_count.PP_W_DESC;?> 
                          </li>
                          <?php } ?>

                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>Test Evaluation and Feedback</li>

                          </ul>
                          </div>
                        </div>
                        <div class="img-text">
                          <h4><?php echo $p->package_name;?></h4>
                          <h5 class="text-black"><?php echo $p->test_module_name;?> | <?php echo $p->programe_name;?></h5>
                          <?php if($p->amount>=$p->discounted_amount){ ?>
                          <span class="price"><?php echo $p->discounted_amount;?> <span class="font-14">Rs. </span></span>
                          <?php }else{ ?>
                          <span class="price"><?php echo $p->amount;?> <span class="font-14">Rs. </span></span>
                          <?php } ?>      
                          <div class="ft-btn btn btn-blue">Purchase Now</div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <!--modal-->
                 <div class="modal fade modal-lg ppmodal" id="ieltsModal<?php echo $p->package_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-header" style="border-bottom: none; padding: 0px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="modal-btn-close"><i class="fa fa-close red-text font-16"></i> Close</span> </button>
      </div>
      <div class="modal-content">
        <div class="pp-modal">
          <div class="modal-scroll" id="scroll-style">
            <div class="row">
                      <?php 
   if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
     $readOnly_dis='disabled="disabled" ';
  }else{
    $readOnly=''; 
    $readOnly_dis=""; }?>
              <div class="col-md-5 col-sm-5">
                <div class="practice-pack-active" id="flex">
                  <div class="img-area" id="a"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
                    <div class="disc">
                      <ul>
                                <li><i class="fa fa-angle-right"></i>    <?php echo 'Validity: '.$p->duration.' Days';?>  </li>
                                <?php if($p->mock_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->mock_test_count.' Full Length Mock Test';?> 
                </li>
              <?php } ?>

              <?php if($p->listening_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->listening_test_count.' Sectional Listening Test';?> 
                </li>
              <?php } ?>

              <?php if($p->speaking_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->speaking_test_count.' Sectional Speaking Test';?> 
                </li>
              <?php } ?>

              <?php if($p->reading_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->reading_test_count.' Sectional Reading Test';?> 
                </li>
              <?php } ?>

              <?php if($p->writing_test_count>0){ ?>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                  <?php echo $p->writing_test_count.' Sectional Writing Test';?> 
                </li>
              <?php } ?>
              <li><i class="fa fa-angle-right" aria-hidden="true"></i> Test Evaluation and Feedback</li>
                              </ul>
                    </div>
                  </div>
                  <div class="img-text" id="b">
                    <h4><?php echo substr($p->package_name, 0,28);?>  <br class="text-brake">  <span class="text-black"><?php echo $p->test_module_name;?> <?php if($p->test_module_name=='IELTS'){echo '| '.$p->programe_name;}?></span></h4>
                    <?php if($p->amount>$p->discounted_amount){ ?>
            <span class="price-strike text-black"><span class="font-14">Rs. </span> <strike><?php echo $p->amount;?></strike></span>
          <?php } ?>

                    <div class="price"><?php echo $p->discounted_amount;?><span class="font-14">Rs. </span></div>
                  </div>
                </div>
              </div>
              <?php $ty=3;?>
              <div class="col-md-7 col-sm-7">
                <div class="modal-box-info">
                   <form action="#" method="post" enctype="multipart/form-data" id="ppform<?php echo $ty;?><?php echo $p->package_id;?>" class="mt-15 theme-bg">
                     <input type="hidden" value="<?php echo $p->package_id;?>" name="package_id" id="package_id" />  
                 
                      <div class="form-group">
                        <input type="text" class="fstinput is-invalid" placeholder="First Name" name="online_fname" id="online_fname<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?>  maxlength="30">
                        <div class="validation font-11 red-text online_fname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                    

                
                      <div class="form-group">
                        <input type="text" class="fstinput" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $ty;?><?php echo $package_id;?>" class="fstinput" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>"    maxlength="30"> 
 <div class="validation font-11 red-text online_lname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>                  


                 <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                        <select class="selectpicker form-control" <?php echo $readOnly_dis;?>  data-live-search="true"  name="online_country_code" id="online_country_code<?php echo $ty;?><?php echo $package_id;?>">
                          <option value="">Country Code</option>
                          <?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
                        </select>
                        <div class="validation font-11 red-text online_country_code_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                    </div>
                    
  <div class="col-sm-6">
                      <div class="form-group">
                        <input type="text" class="fstinput" placeholder="Valid Phone" name="onlinec_mobile" id="onlinec_mobile<?php echo $ty;?><?php echo $package_id;?>" placeholder=""  value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>"   maxlength="10" <?php echo $readOnly;?>> 
 <div class="validation font-11 red-text online_mobile_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                    </div>
                  </div>
                     
  <div class="form-group ">                
                  <div class="has-feedback">
                  <input  name="dob" id="dob<?php echo $ty;?><?php echo $package_id; ?>" type="text" class="fstinput datepicker"  value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" placeholder="DOB*" maxlength="10" autocomplete='off' readonly="readonly"  <?php echo $disabled_sel;?>> 
                  <span class="fa fa-calendar form-group-icon"></span> </div>
                  <div class="validation onldob_error<?php echo $ty;?><?php echo $package_id; ?>"><?php echo form_error('dob');?></div>
                </div>

                      <div class="form-group">
                        <input type="email" class="fstinput" placeholder="Valid Email" name="online_email" id="online_email<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" onblur="validate_complaint_email(this.value)"  maxlength="60"  <?php echo $readOnly;?> > 
                        <div class="validation font-11 red-text online_email_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                        <input type="hidden" value="<?php echo $price2;?>" id="programe_booking_price" name="programe_booking_price"/>
                      <div class="clearfix mt-20"> 
                        <span class="pull-right">
                         
                          <input type="hidden" value="practice" name="pack_type" id="pack_type" />
                          <button type="button" class="btn btn-red btn-mdl font-weight-600" onclick="return check_booking(<?php echo $package_id;?>,<?php echo $ty;?>);" >Checkout <i class="fa fa-angle-right ml-5"></i></button>
                        </span> </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
              <?php } ?>
                
              </div>
            </div>
            <!--END THUMB GRID CONTAINER -->
        
          <div class="tab-pane fade" id="PTE">
            <!--START THUMB GRID CONTAINER -->
            <div class="thumb-grid-container">
              <div class="thumb-grid-flex-cont4">
                <?php foreach($All_PTE_Pack_PP->error_message->data as $p){
                  $package_id=$p->package_id; ?>
                <!--Start Items-->
                <div class="thumb-grid-card-container4">
                  <div class="thumb-grid-card">
                    <a href="#" class="text-blue" data-toggle="modal" data-target="#pteModal<?php echo $p->package_id;?>" data-keyboard="false" data-backdrop="static">
                      <div class="practice-pack">
                        <div class="img-area"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
                          <div class="disc">
                             <ul>
      <?php if($p->mock_test_count>0){ ?>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                              <?php echo $p->mock_test_count.PP_MOCK_DESC;?> 
                            </li>
                          <?php } ?>

                          <?php if($p->listening_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                            <?php echo $p->listening_test_count.PP_L_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->speaking_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                            <?php echo $p->speaking_test_count.PP_S_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->reading_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                            <?php echo $p->reading_test_count.PP_R_DESC;?> 
                          </li>
                          <?php } ?>

                          <?php if($p->writing_test_count>0){ ?>
                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>
                            <?php echo $p->writing_test_count.PP_W_DESC;?> 
                          </li>
                          <?php } ?>

                          <li><i class="fa fa-angle-right" aria-hidden="true"></i>Test Evaluation and Feedback</li>
                          
        </ul>
                          </div>
                        </div>
                        <div class="img-text">
                          <h4><?php echo $p->package_name;?> </h4>
                          <h5 class="text-black"><?php echo $p->test_module_name;?> | <?php echo $p->programe_name;?></h5>
                          <?php if($p->amount>=$p->discounted_amount){ ?>
    <span class="price"><?php echo $p->discounted_amount;?> <span class="font-14">Rs. </span></span>
  <?php }else{ ?>
    <span class="price"><?php echo $p->amount;?> <span class="font-14">Rs. </span></span>
  <?php } ?>
                          
                        
                          <div class="ft-btn btn btn-blue">Purchase Now</div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <!--modal-->
                <div class="modal fade modal-lg ppmodal" id="pteModal<?php echo $p->package_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-header" style="border-bottom: none; padding: 0px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="modal-btn-close"><i class="fa fa-close red-text font-16"></i> Close</span> </button>
                      </div>
                      <div class="modal-content">
                        <div class="pp-modal">
                          <div class="modal-scroll" id="scroll-style">
                            <div class="row">
                                  <?php 
   if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
     $readOnly_dis='disabled="disabled" ';
  }else{
    $readOnly=''; 
    $readOnly_dis=""; }?>
                              <div class="col-md-5 col-sm-5">
                                <div class="practice-pack-active" id="flex">
                                  <div class="img-area" id="a"> <img src="<?php echo site_url('resources-f/images/pp/pack-2.jpg');?>" class="img-responsive" alt=""> <span class="duration"><?php echo $p->duration.' Days';?></span>
                                    <div class="disc">
                                      <ul>
                                        <li><i class="fa fa-angle-right"></i><?php echo 'Validity: '.$p->duration.' Days';?>  </li>
                                        <?php if($p->mock_test_count>0){ ?>
                                          <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                                          <?php echo $p->mock_test_count.' Full Length Mock Test';?> 
                                          </li>
                                          <?php } ?>
                                          <?php if($p->listening_test_count>0){ ?>
                                          <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                                          <?php echo $p->listening_test_count.' Sectional Listening Test';?> 
                                          </li>
                                          <?php } ?>
                                          <?php if($p->speaking_test_count>0){ ?>
                                            <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                                            <?php echo $p->speaking_test_count.' Sectional Speaking Test';?> 
                                            </li>
                                            <?php } ?>
                                            <?php if($p->reading_test_count>0){ ?>
                                            <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                                            <?php echo $p->reading_test_count.' Sectional Reading Test';?> 
                                            </li>
                                            <?php } ?>
                                            <?php if($p->writing_test_count>0){ ?>
                                            <li><i class="fa fa-angle-right" aria-hidden="true"></i> 
                                            <?php echo $p->writing_test_count.' Sectional Writing Test';?> 
                                            </li>
                                           <?php } ?>
                                          <li><i class="fa fa-angle-right" aria-hidden="true"></i> Test Evaluation and Feedback</li>
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="img-text" id="b">
                                      <h4><?php echo substr($p->package_name, 0,28);?>  <br class="text-brake">  <span class="text-black"><?php echo $p->test_module_name;?> <?php if($p->test_module_name=='IELTS'){echo '| '.$p->programe_name;}?></span></h4>
                                      <?php if($p->amount>$p->discounted_amount){ ?>
                                        <span class="price-strike text-black"><span class="font-14">Rs. </span> <strike><?php echo $p->amount;?></strike></span>
                                        <?php } ?>
                                        <div class="price"><?php echo $p->discounted_amount;?><span class="font-14">Rs. </span></div>
                                    </div>
                                  </div>
                            </div>
                            <?php $ty=4;?>
                  <div class="col-md-7 col-sm-7">
                  <div class="modal-box-info">
                   <form action="#" method="post" enctype="multipart/form-data" id="ppform<?php echo $ty;?><?php echo $p->package_id;?>" class="mt-15 theme-bg">
                     <input type="hidden" value="<?php echo $p->package_id;?>" name="package_id" id="package_id" />  
                 
                      <div class="form-group">
                        <input type="text" class="fstinput is-invalid" placeholder="First Name" name="online_fname" id="online_fname<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?>  maxlength="30">
                        <div class="validation font-11 red-text online_fname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                    

                
                      <div class="form-group">
                        <input type="text" class="fstinput" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $ty;?><?php echo $package_id;?>" class="fstinput" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>"    maxlength="30"> 
 <div class="validation font-11 red-text online_lname_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>                  


                 
                      <div class="form-group">
                        <select class="selectpicker form-control" <?php echo $readOnly_dis;?>  data-live-search="true"  name="online_country_code" id="online_country_code<?php echo $ty;?><?php echo $package_id;?>">
                          <option value="">Country Code</option>
                          <?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
                        </select>
                        <div class="validation font-11 red-text online_country_code_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                    

                      <div class="form-group">
                        <input type="text" class="fstinput" placeholder="Valid Phone" name="onlinec_mobile" id="onlinec_mobile<?php echo $ty;?><?php echo $package_id;?>" placeholder=""  value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>"   maxlength="10" <?php echo $readOnly;?>> 
 <div class="validation font-11 red-text online_mobile_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                     


                      <div class="form-group">
                        <input type="email" class="fstinput" placeholder="Valid Email" name="online_email" id="online_email<?php echo $ty;?><?php echo $package_id;?>" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" onblur="validate_complaint_email(this.value)"  maxlength="60"  <?php echo $readOnly;?> > 
                        <div class="validation font-11 red-text online_email_error<?php echo $ty;?><?php echo $package_id;?>"></div>
                      </div>
                        <input type="hidden" value="<?php echo $price2;?>" id="programe_booking_price" name="programe_booking_price"/>
                      <div class="clearfix mt-20"> 
                        <span class="pull-right">
                         
                          <input type="hidden" value="practice" name="pack_type" id="pack_type" />
                          <button type="button" class="btn btn-red btn-mdl font-weight-600" onclick="return check_booking(<?php echo $package_id;?>,<?php echo $ty;?>);" >Checkout <i class="fa fa-angle-right ml-5"></i></button>
                        </span> </div>
                    </form>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
                <!--End Items-->
              <?php }?>
               
              </div>
            </div>
            <!--END THUMB GRID CONTAINER -->
          </div>
         
        </div>
        <div class="text-center mt-20"> <a class="btn btn-red btn-flat view-btn" href="practice-pack.html">View All →</a></div>
      </div>
    </section>


    <script type="">
    
     function check_booking(package_id,type)
    {


      var numberes = /^[0-9-+]+$/;
      var letters = /^[A-Za-z ]+$/;
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
      var fname = $("#online_fname"+type+package_id).val();
      var email = $("#online_email"+type+package_id).val();
      var mobile = $("#onlinec_mobile"+type+package_id).val();
      var country_code = $("#online_country_code"+type+package_id).val();
      //var package_id = $("#package_id").val();
    
      if(fname.match(letters)){
      $(".online_fname_error"+type+package_id).text('');
      }else{
      $("#online_fname"+type+package_id).focus();
      $(".online_fname_error"+type+package_id).text("Please enter valid Name. Numbers not allowed!");
      return false;
      }

      if(mobile.length>10 || mobile.length<10){
      $("#online_mobile"+type+package_id).focus();
      $(".online_mobile_error"+type+package_id).text('Please enter valid Number of 10 digit');
      return false;
      }else{ 
      $(".online_mobile_error"+type+package_id).text('');
      }


    if(validate_complaint_email(email)){
    $(".online_email_error"+type+package_id).text('');
    }else{ 
    $("#online_email"+type+package_id).focus();
    $(".online_email_error"+type+package_id).text('Please enter valid Email Id');
    return false;
    }


    if(country_code == ""){
    $("#online_country_code"+type+package_id).focus();
    $(".online_country_code_error"+type+package_id).text('Please select country code');
    return false;
    }else{ 
    $(".online_country_code_error"+type+package_id).text('');
    }
    var form = $("#ppform"+type+package_id);

   $.ajax({
        url: "<?php echo site_url('booking/check_booking');?>",
        type: 'post',
          data: form.serialize(),               
        success: function(response){  
//alert(JSON.stringify(response))
        if(response.status=='true')
        {
        $('.ppmodal').modal('hide');
        $('#modal-reg-OTP').modal('show');       
        }
        else if(response.status==2)
        {
        /*window.location.href = "<?php ///echo site_url('booking/checkout');?>"*/
         $('.ppmodal').modal('hide');
         $('#modal-login').modal('show');   

        }
        else if(response.status==3)
        {
        window.location.href = "<?php echo site_url('booking/checkout');?>"          

        }
        else
        {
         $('.complaintBtnDiv_pro').hide(); 
          $('#reg_button').prop('disabled', false);
            $('#regmain_msg_danger').removeClass('hide');
            $('#regmain_msg_danger').html(response.msg);
            //$('.regsub_button').hide(); 
          }                  
        },
        beforeSend: function(){
          $('.complaintBtnDiv_pro').show(); 
          $('#reg_button').prop('disabled', true);
        }
    });
    }

    function validate_complaint_email(email){
  
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(email.match(mailformat)){
        $(".dc_email_error").text('');
       // $('.complaintBtn').prop('disabled', false);  
        return true;
    }else{
        $(".dc_email_error").text("Please enter valid email Id!");
        $('#dc_email').focus();
       // $('.complaintBtn').prop('disabled', true);
       return false;
    }
}
  </script>