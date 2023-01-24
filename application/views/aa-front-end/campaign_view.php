<?php 
if(isset($this->session->userdata('student_login_data')->id)){
	$readOnly='readonly="readonly" ';
	$readOnly_dis='disabled="disabled" ';
}else{
	$readOnly='';
	$readOnly_dis='';
}
 
$fdata=array();
$fdata['getOnlineCoachingProgram'] =FALSE;
$fdata['getOnlinePackage'] =FALSE;
$fdata['getInhouseCoachingCourse'] =FALSE;
$fdata['getInhouseCoachingProgram'] =FALSE;
$fdata['getInhousePackage'] =FALSE;
$fdata['getPracticePackProgram'] =FALSE;
$fdata['getPracticePackPackage'] =FALSE;

$fdata['getProgram'] =FALSE;
$fdata['getRealityTest'] =FALSE;
$fdata['getExamBookingProgram'] =FALSE;

$fdata['getCourseOrCountry'] =FALSE;
$fdata['getEventListByCourse'] =FALSE;
$fdata['getEventListByCountry'] =FALSE;
//pr( $eventList->error_message->data->campaign,1);
?>
<section>
  <div class="container">
    <h2>Campaign</h2>
    <div class="wizard">
    
      <form method="post" id="campaign_form">
      <input type="hidden" name="source_id" id="source_id" value="1">
      <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $eventList->error_message->data->campaign->campaign_id; ?>">
      <input type="hidden" name="campaign_type_id" id="campaign_type_id" value="<?php echo $eventList->error_message->data->campaign->campaign_type_id; ?>">
      <input type="hidden" name="campaign_category_id" id="campaign_category_id" value="<?php echo $eventList->error_message->data->campaign->campaign_category_id; ?>">
      <input type="hidden" name="campaign_title" id="campaign_title" value="<?php echo $eventList->error_message->data->campaign->campaign_title; ?>">
      <input type="hidden" name="social_media_campaign_id" id="social_media_campaign_id" value="<?php echo $eventList->error_message->data->campaign->social_media_campaign_id; ?>">
      <input type="hidden" name="lead_origin_type" id="lead_origin_type" value="<?php echo $eventList->error_message->data->campaign->origin_type; ?>">
      <input type="hidden" name="origin" id="origin" value="<?php echo $eventList->error_message->data->campaign->origin; ?>">
      <input type="hidden" name="medium" id="medium" value="<?php echo $eventList->error_message->data->campaign->medium; ?>">
      
      
        <div class="form-box">
          <div class="row">
            <div class="col-md-12"> 
              <!--											<h4 class="">Form-1</h4> --> 
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>First Name <span class="text-red">*</span></label>
                <input type="text" class="form-control allow_alphabets" name="camp_fname" id="camp_fname" autocomplete="off" onchange="checkfname()" title="First Name" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?> required/>
                <div id="camp_fname_error" class="validation"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Last Name <span class="text-red">*</span></label>
                <input type="text" class="form-control allow_alphabets" placeholder=""  name="camp_lname" id="camp_lname" autocomplete="off" onchange="checklname()" title="Last Name" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>" <?php echo $readOnly;?> required/>
                <div id="camp_lname_error" class="validation"></div>
              </div>
            </div>
             <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label style="display:block;">Country Code <span class="text-red">*</span></label>
                <!--												    <select class="fstdropdown-select">-->
                <select class="selectpicker" name="camp_country_code" id="camp_country_code" data-live-search="true" style="width:100%" title="Country Code" onchange="getPhoneLimit()" required>
                  <option value="">Select Country Code</option>
                  <?php
				  foreach ($countryCode->error_message->data as $c) {
					  if ($c->country_code == '+91') {
				  ?>
                  <option value="<?php echo $c->country_code; ?>" data-iso="<?php echo $c->iso3; ?>" selected="selected"> <?php echo $c->country_code . '- ' . $c->iso3; ?></option>
                  <?php }
					}

				  foreach ($countryCode->error_message->data as $c) {
					  if ($c->country_code != '+91') { ?>
                  <option value="<?php echo $c->country_code; ?>" data-iso="<?php echo $c->iso3; ?>"> <?php echo $c->country_code . '- ' . $c->iso3; ?></option>
                  <?php
					  }
				  } ?>
                </select>
                <div id="camp_country_code_error" class="validation"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label style="display:block">Phone Number <span class="text-red">*</span> 
                	<span id="phone_digit" class="pull-right" style="color: #A60002;font-size:12px;"> Entered Digits : 0 </span> 
                </label>
                <input type="text" class="form-control allow_numeric" placeholder="" name="camp_phone" id="camp_phone" autocomplete="off" maxlength="15" title="Phone Number"  value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>" <?php echo $readOnly;?> required/>
                <div id="camp_phone_error" class="validation"></div>
              </div>
            </div>
             <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Email <span class="text-red">*</span></label>
                <input type="text" class="form-control allow_email" placeholder="" name="camp_email" id="camp_email" autocomplete="off" title="Email" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" <?php echo $readOnly;?> required/>
                <div id="camp_email_error" class="validation"></div>
              </div>
            </div>
             <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Date of Birth <span class="text-red">*</span></label>
                <input id="camp_dob" name="camp_dob" data-inputmask="'alias': 'date'" class="form-control date_mask" placeholder="dd/mm/yyyy" title="Date of Birth" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" <?php echo $readOnly_dis;?> required/>
                <div id="camp_dob_error" class="validation"></div>
              </div>
            </div>
            <?php
				//----------------- Purpose Start ---------------------------------
				
				if(count($eventList->error_message->data->campaign->purpose_level_one)==1)
				{ ?>
				<input type="hidden" name="purpose_level_1" id="purpose_level_1" value="<?php echo $eventList->error_message->data->campaign->purpose_level_one[0]->purpose_level_one; ?>">	
		  <?php }
				elseif(count($eventList->error_message->data->campaign->purpose_level_one)>1)
				{ ?>
             <div class="col-md-4">
                  <div class="form-group">
                      <label >Purpose <span class="text-red">*</span></label>
                      <select name="purpose_level_1" class="form-control selectpicker" id="purpose_level_1" data-show-subtext="true" data-live-search="true" data-actions-box="true"  onchange="getPurposeLevel2()" title="Purpose" required>
                          <option value=""  selected="selected">Select Purpose</option>
                          <?php
						  foreach($eventList->error_message->data->campaign->purpose_level_one as $P1)
						  {
						  ?>
                          <option value="<?php echo $P1->purpose_level_one; ?>"><?php echo $P1->name; ?></option>
                          <?php
						  }?>
                      </select>
                      <div id="purpose_level_1_error" class="validation"></div>
                  </div>
              </div>   
		  <?php	}
			?>
            
          <?php
		  	if(count($eventList->error_message->data->campaign->purpose_level_two)==1)
				{ ?>
				<input type="hidden" name="purpose_level_2" id="purpose_level_2" value="<?php echo $eventList->error_message->data->campaign->purpose_level_two[0]->purpose_level_two; ?>">	
		  <?php }
			elseif(count($eventList->error_message->data->campaign->purpose_level_two)>1)
				{ ?>
             <div class="col-md-4" id="div_pur_lev_1">
                  <div class="form-group">
                      <label for="purpose_level_2">Product / Service <span class="text-red">*</span></label>
                      <select name="purpose_level_2" class="form-control selectpicker" id="purpose_level_2" data-show-subtext="true" data-live-search="true" data-actions-box="true"  onchange="getPurposeLevel3()">
                          <option value=""  selected="selected">Select Product / Service</option>
                          <?php
						  foreach($eventList->error_message->data->campaign->purpose_level_two as $P2)
						  {
						  ?>
                          <option value="<?php echo $P2->purpose_level_two; ?>"><?php echo $P2->name; ?></option>
                          <?php
						  }?>
                      </select>
                      <div class="validation purpose_level_2_error"><?php echo form_error('purpose_level_2'); ?></div>
                  </div>
              </div>   
		  <?php	}
		  		else
				{
			?>
            <div class="col-md-4 hide" id="div_pur_lev_1">
                  <div class="form-group">
                      <label for="purpose_level_2">Product / Service <span class="text-red">*</span></label>
                      <select name="purpose_level_2" class="form-control selectpicker" id="purpose_level_2" data-show-subtext="true" data-live-search="true" data-actions-box="true"  onchange="getPurposeLevel3()">
                          <option value=""  selected="selected">Select Product / Service</option>
                      </select>
                      <div id="purpose_level_2_error" class="validation"><?php echo form_error('purpose_level_2'); ?></div>
                  </div>
              </div>   
           <?php
				} ?>
            <!--=========================================================================
                                                Test Coaching & Preparation
   			=========================================================================-->
            <?php
			if((count($eventList->error_message->data->campaign->online_coaching_course)>=1) || (count($eventList->error_message->data->campaign->inhouse_coaching_branch)>=1) || (count($eventList->error_message->data->campaign->practice_pack_course)>=1))
			{
				$div_test_coaching_cls="";
			}
			else
			{
				$div_test_coaching_cls="hide";
			}
			?>
            <div id="div_test_coaching" class="<?php echo $div_test_coaching_cls; ?>">
            	<?php
				if(count($eventList->error_message->data->campaign->online_coaching_course)==1)
				{
					$fdata['getOnlineCoachingProgram'] =TRUE;
				 ?>
				<input type="hidden" name="online_coaching_course" id="online_coaching_course" value="<?php echo $eventList->error_message->data->campaign->online_coaching_course[0]->test_module_id; ?>">	
                 
				<?php 
				}
				elseif(count($eventList->error_message->data->campaign->online_coaching_course)>1)
				{ ?> 
                <div class="col-md-4" id="div_online_coaching_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="online_coaching_course" class="form-control selectpicker" id="online_coaching_course" data-show-subtext="true" data-live-search="true"   onchange="getOnlineCoachingProgram()" title="Course">
                      <option value=""  selected="selected">Select Course</option>
                      <?php
					  foreach($eventList->error_message->data->campaign->online_coaching_course as $P3)
					  {
					  ?>
					  <option value="<?php echo $P3->test_module_id; ?>"><?php echo $P3->test_module_name; ?></option>
					  <?php
					  }?>
                    </select>
                    <div id="online_coaching_course_error" class="validation"><?php echo form_error('online_coaching_course'); ?></div>
                   </div>
                </div>
                <?php	
				}
				else
				{
				?>    
				<div class="col-md-4 hide" id="div_online_coaching_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="online_coaching_course" class="form-control selectpicker" id="online_coaching_course" data-show-subtext="true" data-live-search="true"   onchange="getOnlineCoachingProgram()" title="Course">
                      <option value=""  selected="selected">Select Course</option>
                    </select>
                    <div id="online_coaching_course_error" class="validation"><?php echo form_error('online_coaching_course'); ?></div>
                   </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->online_coaching_program)==1)
				{ 
					$fdata['getOnlinePackage'] =TRUE;
				?>
				<input type="hidden" name="online_coaching_program" id="online_coaching_program" value="<?php echo $eventList->error_message->data->campaign->online_coaching_program[0]->programe_id; ?>">	
				<?php 
				}
				elseif(count($eventList->error_message->data->campaign->online_coaching_program)>1)
				{ ?>
                <div class="col-md-4" id="div_online_coaching_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="online_coaching_program" class="form-control selectpicker" id="online_coaching_program" data-show-subtext="true" data-live-search="true"    onchange="getOnlinePackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                      <?php
					  foreach($eventList->error_message->data->campaign->online_coaching_program as $P4)
					  {
					  ?>
					  <option value="<?php echo $P4->programe_id; ?>"><?php echo $P4->programe_name; ?></option>
					  <?php
					  }?>
                    </select>
                    <div id="online_coaching_program_error" class="validation"><?php echo form_error('online_coaching_program'); ?></div>
                   </div>
                </div>
                <?php	
				}
				else
				{
					
				?>    
				<div class="col-md-4 hide" id="div_online_coaching_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="online_coaching_program" class="form-control selectpicker" id="online_coaching_program" data-show-subtext="true" data-live-search="true"    onchange="getOnlinePackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                    </select>
                    <div id="online_coaching_program_error" class="validation"><?php echo form_error('online_coaching_program'); ?></div>
                   </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->online_coaching_package)==1)
				{ ?>
				<input type="hidden" name="online_coaching_package" id="online_coaching_package" value="<?php echo $eventList->error_message->data->campaign->online_coaching_package[0]->package_id; ?>">	
				<?php 
				}
				elseif(count($eventList->error_message->data->campaign->online_coaching_package)>1)
				{ ?>
                <div class="col-md-4" id="div_online_coaching_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="online_coaching_package" class="form-control selectpicker" id="online_coaching_package" data-show-subtext="true" data-live-search="true"  title="Package">
                      <option value="" selected="selected">Select Package</option>
                      <?php
					  foreach($eventList->error_message->data->campaign->online_coaching_package as $P5)
					  {
					  ?>
					  <option value="<?php echo $P5->package_id; ?>"><?php echo $P5->package_name; ?></option>
					  <?php
					  }?>
                    </select>
                    <div id="online_coaching_package_error" class="validation"><?php echo form_error('online_coaching_package'); ?></div>
                   </div>
                </div>
                <?php	
				}
				else
				{
					if($eventList->error_message->data->campaign->is_show_package !=1)
					{
				?>    
				<div class="col-md-4 hide" id="div_online_coaching_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="online_coaching_package" class="form-control selectpicker" id="online_coaching_package" data-show-subtext="true" data-live-search="true"  title="Package">
                      <option value="" selected="selected">Select Package</option>
                    </select>
                    <div id="online_coaching_package_error" class="validation"><?php echo form_error('online_coaching_package'); ?></div>
                   </div>
                </div>
				<?php
					}
				} ?>

				<?php
				if(count($eventList->error_message->data->campaign->inhouse_coaching_branch)==1)
				{ 
					$fdata['getInhouseCoachingCourse'] =TRUE;
				?>
					<input type="hidden" name="inhouse_coaching_branch" id="inhouse_coaching_branch" value="<?php echo $eventList->error_message->data->campaign->inhouse_coaching_branch[0]->center_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->inhouse_coaching_branch)>1)
				{ ?>
                <div class="col-md-4" id="div_inhouse_coaching_branch">
                  <div class="form-group">
                    <label for="active" class="control-label">Branch <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_branch" class="form-control selectpicker" id="inhouse_coaching_branch" data-show-subtext="true" data-live-search="true"   onchange="getInhouseCoachingCourse()" title="Branch">
                      <option value="" selected="selected">Select Branch</option>
                      <?php
						foreach($eventList->error_message->data->campaign->inhouse_coaching_branch as $P6)
						{
						?>
						<option value="<?php echo $P6->center_id; ?>"><?php echo $P6->center_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="inhouse_coaching_branch_error" class="validation"><?php echo form_error('inhouse_coaching_branch'); ?></div>
                   </div>
                </div>
               <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_inhouse_coaching_branch">
                  <div class="form-group">
                    <label for="active" class="control-label">Branch <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_branch" class="form-control selectpicker" id="inhouse_coaching_branch" data-show-subtext="true" data-live-search="true"   onchange="getInhouseCoachingCourse()" title="Branch">
                      <option value="" selected="selected">Select Branch</option>
                    </select>
                    <div id="inhouse_coaching_branch_error" class="validation"><?php echo form_error('inhouse_coaching_branch'); ?></div>
                   </div>
                </div>
				<?php
				} ?> 
                
                <?php
				if(count($eventList->error_message->data->campaign->inhouse_coaching_course)==1)
				{ 
					$fdata['getInhouseCoachingProgram'] =TRUE;
				?>
					<input type="hidden" name="inhouse_coaching_course" id="inhouse_coaching_course" value="<?php echo $eventList->error_message->data->campaign->inhouse_coaching_course[0]->test_module_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->inhouse_coaching_course)>1)
				{ ?>
                <div class="col-md-4" id="div_inhouse_coaching_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_course" class="form-control selectpicker" id="inhouse_coaching_course" data-show-subtext="true" data-live-search="true"   onchange="getInhouseCoachingProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                      <?php
						foreach($eventList->error_message->data->campaign->inhouse_coaching_course as $P7)
						{
						?>
						<option value="<?php echo $P7->test_module_id; ?>"><?php echo $P7->test_module_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="inhouse_coaching_course_error" class="validation"><?php echo form_error('inhouse_coaching_course'); ?></div>
                   </div>
                </div>
               <?php	}
					else
					{
				?>
				<div class="col-md-4 hide" id="div_inhouse_coaching_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_course" class="form-control selectpicker" id="inhouse_coaching_course" data-show-subtext="true" data-live-search="true"   onchange="getInhouseCoachingProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                    </select>
                    <div id="inhouse_coaching_course_error" class="validation"><?php echo form_error('inhouse_coaching_course'); ?></div>
                   </div>
                </div>
				<?php
				} ?>
 
 				<?php
				if(count($eventList->error_message->data->campaign->inhouse_coaching_program)==1)
				{
					$fdata['getInhousePackage'] =TRUE;
				 ?>
					<input type="hidden" name="inhouse_coaching_program" id="inhouse_coaching_program" value="<?php echo $eventList->error_message->data->campaign->inhouse_coaching_program[0]->programe_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->inhouse_coaching_program)>1)
				{ ?>
                <div class="col-md-4" id="div_inhouse_coaching_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_program" class="form-control selectpicker" id="inhouse_coaching_program" data-show-subtext="true" data-live-search="true"    onchange="getInhousePackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                      <?php
						foreach($eventList->error_message->data->campaign->inhouse_coaching_program as $P8)
						{
						?>
						<option value="<?php echo $P8->programe_id; ?>"><?php echo $P8->programe_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="inhouse_coaching_program_error" class="validation"><?php echo form_error('inhouse_coaching_program'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
                <div class="col-md-4 hide" id="div_inhouse_coaching_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_program" class="form-control selectpicker" id="inhouse_coaching_program" data-show-subtext="true" data-live-search="true"    onchange="getInhousePackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                    </select>
                    <div id="inhouse_coaching_program_error" class="validation"><?php echo form_error('inhouse_coaching_program'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->inhouse_coaching_package)==1)
				{ ?>
					<input type="hidden" name="inhouse_coaching_package" id="inhouse_coaching_package" value="<?php echo $eventList->error_message->data->campaign->inhouse_coaching_package[0]->package_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->inhouse_coaching_package)>1)
				{ ?>
                <div class="col-md-4" id="div_inhouse_coaching_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_package" class="form-control selectpicker" id="inhouse_coaching_package" data-show-subtext="true" data-live-search="true"  title="Package">
                      <option value="" selected="selected">Select Package</option>
                      <?php
						foreach($eventList->error_message->data->campaign->inhouse_coaching_package as $P9)
						{
						?>
						<option value="<?php echo $P9->package_id; ?>"><?php echo $P9->package_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="inhouse_coaching_package_error" class="validation"><?php echo form_error('inhouse_coaching_package'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
						if($eventList->error_message->data->campaign->is_show_package !=1)
						{
				?>
				<div class="col-md-4 hide" id="div_inhouse_coaching_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="inhouse_coaching_package" class="form-control selectpicker" id="inhouse_coaching_package" data-show-subtext="true" data-live-search="true"  title="Package">
                      <option value="" selected="selected">Select Package</option>
                    </select>
                    <div id="inhouse_coaching_package_error" class="validation"><?php echo form_error('inhouse_coaching_package'); ?></div>
                  </div>
                </div>
				<?php
						}
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->practice_pack_course)==1)
				{
					$fdata['getPracticePackProgram'] =TRUE;
				 ?>
					<input type="hidden" name="practice_pack_course" id="practice_pack_course" value="<?php echo $eventList->error_message->data->campaign->practice_pack_course[0]->test_module_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->practice_pack_course)>1)
				{ ?>
                <div class="col-md-4" id="div_practice_pack_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="practice_pack_course" class="form-control selectpicker" id="practice_pack_course" data-show-subtext="true" data-live-search="true"  onchange="getPracticePackProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                      <?php
						foreach($eventList->error_message->data->campaign->practice_pack_course as $P10)
						{
						?>
						<option value="<?php echo $P10->test_module_id; ?>"><?php echo $P10->test_module_name; ?></option>
						<?php
						}?>
					</select>
                    <div id="practice_pack_course_error" class="validation"><?php echo form_error('practice_pack_course'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_practice_pack_course">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="practice_pack_course" class="form-control selectpicker" id="practice_pack_course" data-show-subtext="true" data-live-search="true"  onchange="getPracticePackProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                    </select>
                    <div id="practice_pack_course_error" class="validation"><?php echo form_error('practice_pack_course'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->practice_pack_program)==1)
				{ 
					$fdata['getPracticePackPackage'] =TRUE;
				?>
					<input type="hidden" name="practice_pack_program" id="practice_pack_program" value="<?php echo $eventList->error_message->data->campaign->practice_pack_program[0]->programe_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->practice_pack_program)>1)
				{ ?>
                <div class="col-md-4" id="div_practice_pack_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="practice_pack_program" class="form-control selectpicker" id="practice_pack_program" data-show-subtext="true" data-live-search="true"    onchange="getPracticePackPackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                      <?php
						foreach($eventList->error_message->data->campaign->practice_pack_program as $P11)
						{
						?>
						<option value="<?php echo $P11->programe_id; ?>"><?php echo $P11->programe_name; ?></option>
						<?php
					    }?>
                    </select>
                    <div id="practice_pack_program_error" class="validation"><?php echo form_error('practice_pack_program'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_practice_pack_program">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="practice_pack_program" class="form-control selectpicker" id="practice_pack_program" data-show-subtext="true" data-live-search="true"    onchange="getPracticePackPackage()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                    </select>
                    <div id="practice_pack_program_error" class="validation"><?php echo form_error('practice_pack_program'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->practice_pack_list)==1)
				{ ?>
					<input type="hidden" name="practice_pack_package" id="practice_pack_package" value="<?php echo $eventList->error_message->data->campaign->practice_pack_list[0]->package_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->practice_pack_list)>1)
				{ ?>
                <div class="col-md-4" id="div_practice_pack_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="practice_pack_package" class="form-control selectpicker" id="practice_pack_package" data-show-subtext="true" data-live-search="true"   title="Package">
                      <option value="" selected="selected">Select Package</option>
                      <?php
						foreach($eventList->error_message->data->campaign->practice_pack_list as $P12)
						{
						?>
						<option value="<?php echo $P12->package_id; ?>"><?php echo $P12->package_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="practice_pack_package_error" class="validation"><?php echo form_error('practice_pack_package'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
						if($eventList->error_message->data->campaign->is_show_package !=1)
						{
				?>
				<div class="col-md-4 hide" id="div_practice_pack_package">
                  <div class="form-group">
                    <label for="active" class="control-label">Package <span class="text-red">*</span></label>
                    <select name="practice_pack_package" class="form-control selectpicker" id="practice_pack_package" data-show-subtext="true" data-live-search="true"   title="Package">
                      <option value="" selected="selected">Select Package</option>
                    </select>
                    <div id="practice_pack_package_error" class="validation"><?php echo form_error('practice_pack_package'); ?></div>
                  </div>
                </div>
				<?php
						}
				} ?>
              </div>
             <!--=========================================================================
                                                Visa Services
               =========================================================================-->
               <?php
				if((count($eventList->error_message->data->campaign->study_visa_country)>=1) || (count($eventList->error_message->data->campaign->visitor_visa_country)>=1) || (count($eventList->error_message->data->campaign->work_visa_country)>=1) || (count($eventList->error_message->data->campaign->dep_visa_country)>=1))
				{
					$div_visa_services_cls="";
				}
				else
				{
					$div_visa_services_cls="hide";
				}
				?>
              <div id="div_visa_services" class="<?php echo $div_visa_services_cls; ?>">
             	<?php
				if(count($eventList->error_message->data->campaign->study_visa_country)==1)
				{ ?>
					<input type="hidden" name="study_visa_int_country" id="study_visa_int_country" value="<?php echo $eventList->error_message->data->campaign->study_visa_country[0]->int_country_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->study_visa_country)>1)
				{ ?>
                <div class="col-md-4" id="div_study_visa_int_country">
                  <div class="form-group">
                    <label for="study_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="study_visa_int_country" class="form-control selectpicker" id="study_visa_int_country" data-show-subtext="true" data-live-search="true"   title="Interested Country" >
                      <option value="" selected="selected">Select Interested Country</option>
                      <?php
						foreach($eventList->error_message->data->campaign->study_visa_country as $P14)
						{
						?>
						<option value="<?php echo $P14->int_country_id; ?>"><?php echo $P14->name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="study_visa_int_country_error" class="validation"><?php echo form_error('study_visa_int_country'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_study_visa_int_country">
                  <div class="form-group">
                    <label for="study_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="study_visa_int_country" class="form-control selectpicker" id="study_visa_int_country" data-show-subtext="true" data-live-search="true"   title="Interested Country" >
                      <option value="" selected="selected">Select Interested Country</option>
                    </select>
                    <div id="study_visa_int_country_error" class="validation"><?php echo form_error('study_visa_int_country'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->visitor_visa_country)==1)
				{ ?>
					<input type="hidden" name="visitor_visa_int_country" id="visitor_visa_int_country" value="<?php echo $eventList->error_message->data->campaign->visitor_visa_country[0]->int_country_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->visitor_visa_country)>1)
				{ ?>
                <div class="col-md-4" id="div_visitor_visa_int_country">
                  <div class="form-group">
                    <label for="visitor_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="visitor_visa_int_country" class="form-control selectpicker" id="visitor_visa_int_country" data-show-subtext="true" data-live-search="true"  title="Interested Country" >
                      <option value="" selected="selected">Select Interested Country</option>
                      <?php
						foreach($eventList->error_message->data->campaign->visitor_visa_country as $P15)
						{
						?>
						<option value="<?php echo $P15->int_country_id; ?>"><?php echo $P15->name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="visitor_visa_int_country_error" class="validation"><?php echo form_error('visitor_visa_int_country'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_visitor_visa_int_country">
                  <div class="form-group">
                    <label for="visitor_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="visitor_visa_int_country" class="form-control selectpicker" id="visitor_visa_int_country" data-show-subtext="true" data-live-search="true"  title="Interested Country" >
                      <option value="" selected="selected">Select Interested Country</option>
                    </select>
                    <div id="visitor_visa_int_country_error" class="validation"><?php echo form_error('visitor_visa_int_country'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->work_visa_country)==1)
				{ ?>
					<input type="hidden" name="work_visa_int_country" id="work_visa_int_country" value="<?php echo $eventList->error_message->data->campaign->work_visa_country[0]->int_country_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->work_visa_country)>1)
				{ ?>
                <div class="col-md-4" id="div_work_visa_int_country">
                  <div class="form-group">
                    <label for="work_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="work_visa_int_country" class="form-control selectpicker" id="work_visa_int_country" data-show-subtext="true" data-live-search="true"   title="Interested Country">
                      <option value="" selected="selected">Select Interested Country</option>
                      <?php
						foreach($eventList->error_message->data->campaign->work_visa_country as $P18)
						{
						?>
						<option value="<?php echo $P18->int_country_id; ?>"><?php echo $P18->name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="work_visa_int_country_error" class="validation"><?php echo form_error('work_visa_int_country'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_work_visa_int_country">
                  <div class="form-group">
                    <label for="work_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="work_visa_int_country" class="form-control selectpicker" id="work_visa_int_country" data-show-subtext="true" data-live-search="true"   title="Interested Country">
                      <option value="" selected="selected">Select Interested Country</option>
                    </select>
                    <div id="work_visa_int_country_error" class="validation"><?php echo form_error('work_visa_int_country'); ?></div>
                  </div>
                </div>
				<?php
				} ?>

                <?php
				if(count($eventList->error_message->data->campaign->dep_visa_country)==1)
				{ ?>
					<input type="hidden" name="dep_visa_int_country" id="dep_visa_int_country" value="<?php echo $eventList->error_message->data->campaign->dep_visa_country[0]->int_country_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->dep_visa_country)>1)
				{ ?>
                <div class="col-md-4" id="div_dep_visa_int_country">
                  <div class="form-group">
                    <label for="dep_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="dep_visa_int_country" class="form-control selectpicker" id="dep_visa_int_country" data-show-subtext="true" data-live-search="true"  title="Interested Country">
                      <option value="" selected="selected">Select Interested Country</option>
                      <?php
						foreach($eventList->error_message->data->campaign->dep_visa_country as $P19)
						{
						?>
						<option value="<?php echo $P19->int_country_id; ?>"><?php echo $P19->name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="dep_visa_int_country_error" class="validation"><?php echo form_error('dep_visa_int_country'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_dep_visa_int_country">
                  <div class="form-group">
                    <label for="dep_visa_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="dep_visa_int_country" class="form-control selectpicker" id="dep_visa_int_country" data-show-subtext="true" data-live-search="true"  title="Interested Country">
                      <option value="" selected="selected">Select Interested Country</option>
                    </select>
                    <div id="dep_visa_int_country_error" class="validation"><?php echo form_error('dep_visa_int_country'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
              </div>
               <!--=========================================================================
                                                            Reality Test 
                  =========================================================================-->
              <?php
				if(count($eventList->error_message->data->campaign->reality_test_course)>=1) 
				{
					$div_reality_test_cls="";
				}
				else
				{
					$div_reality_test_cls="hide";
				}
				?>   
              <div id="div_reality_test" class="<?php echo $div_reality_test_cls; ?>">
              	<?php
				if(count($eventList->error_message->data->campaign->reality_test_course)==1)
				{
					$fdata['getProgram'] =TRUE;
			   ?>
					<input type="hidden" name="reality_test_course" id="reality_test_course" value="<?php echo $eventList->error_message->data->campaign->reality_test_course[0]->test_module_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->reality_test_course)>1)
				{ ?>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="reality_test_course" class="form-control selectpicker" id="reality_test_course" data-show-subtext="true" data-live-search="true"   onchange="getProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                      <?php
						foreach($eventList->error_message->data->campaign->reality_test_course as $P20)
						{
						?>
						<option value="<?php echo $P20->test_module_id; ?>"><?php echo $P20->test_module_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="reality_test_course_error" class="validation"><?php echo form_error('reality_test_course'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="reality_test_course" class="form-control selectpicker" id="reality_test_course" data-show-subtext="true" data-live-search="true"   onchange="getProgram()" title="Course">
                      <option value="" selected="selected">Select Course</option>
                    </select>
                    <div id="reality_test_course_error" class="validation"><?php echo form_error('reality_test_course'); ?></div>
                  </div>
                </div>
				<?php
				} ?>

				<?php
				if(count($eventList->error_message->data->campaign->reality_test_program)==1)
				{ 
					$fdata['getRealityTest'] =TRUE;
				?>
					<input type="hidden" name="reality_test_program" id="reality_test_program" value="<?php echo $eventList->error_message->data->campaign->reality_test_program[0]->programe_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->reality_test_program)>1)
				{ ?>
                <div class="col-md-4" id="div_rt_prog">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="reality_test_program" class="form-control selectpicker" id="reality_test_program" data-show-subtext="true" data-live-search="true"   onchange="getRealityTest()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                      <?php
						foreach($eventList->error_message->data->campaign->reality_test_program as $P21)
						{
						?>
						<option value="<?php echo $P21->programe_id; ?>"><?php echo $P21->programe_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="reality_test_program_error" class="validation"><?php echo form_error('reality_test_program'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4" id="div_rt_prog">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="reality_test_program" class="form-control selectpicker" id="reality_test_program" data-show-subtext="true" data-live-search="true"   onchange="getRealityTest()" title="Program">
                      <option value="" selected="selected">Select Program</option>
                    </select>
                    <div id="reality_test_program_error" class="validation"><?php echo form_error('reality_test_program'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                
                <?php
				if(count($eventList->error_message->data->campaign->reality_test_list)==1)
				{ ?>
					<input type="hidden" name="reality_test" id="reality_test" value="<?php echo $eventList->error_message->data->campaign->reality_test_list[0]->reality_test_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->reality_test_list)>1)
				{ ?>
                <div class="col-md-4" id="div_rt">
                  <div class="form-group">
                    <label for="active" class="control-label">Reality Test <span class="text-red">*</span> <span class="text-info">(Format: Title | Date | Price)</span></label>
                    <select name="reality_test" class="form-control selectpicker" id="reality_test" data-show-subtext="true" data-live-search="true"  title="Reality Test">
                      <option value="" selected="selected">Select Reality Test</option>
                      <?php
						foreach($eventList->error_message->data->campaign->reality_test_list as $P22)
						{
						?>
						<option value="<?php echo $P22->reality_test_id; ?>"><?php echo $P22->title; ?></option>
						<?php
						}?>
                    </select>
                    <div id="reality_test_error" class="validation"><?php echo form_error('reality_test'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
						if($eventList->error_message->data->campaign->is_show_reality_test !=1)
						{
				?>
				<div class="col-md-4" id="div_rt">
                  <div class="form-group">
                    <label for="active" class="control-label">Reality Test <span class="text-red">*</span> <span class="text-info">(Format: Title | Date | Price)</span></label>
                    <select name="reality_test" class="form-control selectpicker" id="reality_test" data-show-subtext="true" data-live-search="true"  title="Reality Test">
                      <option value="" selected="selected">Select Reality Test</option>
                    </select>
                    <div id="reality_test_error" class="validation"><?php echo form_error('reality_test'); ?></div>
                  </div>
                </div>
				<?php
						}
				} ?>
              </div>
              <!--=========================================================================
                                                            Exam Booking
              =========================================================================-->
              <?php
				if(count($eventList->error_message->data->campaign->exam_booking_course)>=1) 
				{
					$div_exam_booking_cls="";
				}
				else
				{
					$div_exam_booking_cls="hide";
				}
				?>  
              <div id="div_exam_booking" class="<?php echo $div_exam_booking_cls; ?>">
              	<?php
				if(count($eventList->error_message->data->campaign->exam_booking_course)==1)
				{ 
					$fdata['getExamBookingProgram'] =TRUE;
				?>
					<input type="hidden" name="exam_booking_course" id="exam_booking_course" value="<?php echo $eventList->error_message->data->campaign->exam_booking_course[0]->test_module_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->exam_booking_course)>1)
				{ ?>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="exam_booking_course" class="form-control selectpicker" id="exam_booking_course" data-show-subtext="true" data-live-search="true"  onchange="getExamBookingProgram()">
                      <option value="" selected="selected">Select Course</option>
                      <?php
						foreach($eventList->error_message->data->campaign->exam_booking_course as $P23)
						{
						?>
						<option value="<?php echo $P23->test_module_id; ?>"><?php echo $P23->test_module_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="exam_booking_course_error" class="validation"><?php echo form_error('exam_booking_course'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4">
                  <div class="form-group">
                    <label for="active" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="exam_booking_course" class="form-control selectpicker" id="exam_booking_course" data-show-subtext="true" data-live-search="true"  onchange="getExamBookingProgram()">
                      <option value="" selected="selected">Select Course</option>
                    </select>
                    <div id="exam_booking_course_error" class="validation"><?php echo form_error('exam_booking_course'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                
                <?php
				if(count($eventList->error_message->data->campaign->exam_booking_program)==1)
				{ 
					
				?>
					<input type="hidden" name="exam_booking_program" id="exam_booking_program" value="<?php echo $eventList->error_message->data->campaign->exam_booking_program[0]->programe_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->exam_booking_program)>1)
				{ ?>
                <div class="col-md-4" id="div_eb_prog">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="exam_booking_program" class="form-control selectpicker" id="exam_booking_program" data-show-subtext="true" data-live-search="true"   >
                      <option value="" selected="selected">Select Program</option>
                      <?php
						foreach($eventList->error_message->data->campaign->exam_booking_program as $P24)
						{
						?>
						<option value="<?php echo $P24->programe_id; ?>"><?php echo $P24->programe_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="exam_booking_program_error" class="validation"><?php echo form_error('exam_booking_program'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4" id="div_eb_prog">
                  <div class="form-group">
                    <label for="active" class="control-label">Program <span class="text-red">*</span></label>
                    <select name="exam_booking_program" class="form-control selectpicker" id="exam_booking_program" data-show-subtext="true" data-live-search="true" >
                      <option value="" selected="selected">Select Program</option>
                    </select>
                    <div id="exam_booking_program_error" class="validation"><?php echo form_error('exam_booking_program'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
              </div>
              <!--=========================================================================
                                                            Events
              =========================================================================-->
               <?php
				if(count($eventList->error_message->data->campaign->purpose_level_two)>=1)
				{
					foreach($eventList->error_message->data->campaign->purpose_level_two as $P2)
					{
						if(($P2->purpose_level_two==33) || ($P2->purpose_level_two==36))
						{
							$div_event_cls="";
						}
						else
						{
							$div_event_cls="hide";
						}
					}
				}
				else
				{
					$div_event_cls="hide";
				}
				?>  
              <div id="div_event" class="<?php echo $div_event_cls; ?>">
              <?php
			  	if($eventList->error_message->data->campaign->purpose_level_two[0]->purpose_level_two==33) //  Academy Events
				{
					$fdata['getCourseOrCountry'] =TRUE;
			  ?>
				  <?php
                    if(count($eventList->error_message->data->campaign->academy_event_type)==1)
                    { ?>
                        <input type="hidden" name="event_type" id="event_type" value="<?php echo $eventList->error_message->data->campaign->academy_event_type[0]->event_type_id; ?>">	
                    <?php }
                    elseif(count($eventList->error_message->data->campaign->academy_event_type)>1)
                    { ?>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="event_type" class="control-label">Event Type <span class="text-red">*</span></label>
                        <select name="event_type" class="form-control selectpicker" id="event_type" data-show-subtext="true" data-live-search="true"   onchange="getCourseOrCountry()" title="Event Type">
                          <option value=""  selected="selected">Select Event Type</option>
                          <?php
							foreach($eventList->error_message->data->campaign->academy_event_type as $P30)
							{
							?>
							<option value="<?php echo $P30->event_type_id; ?>"><?php echo $P30->eventTypeTitle; ?></option>
							<?php
							}?>
                        </select>
                        <div id="event_type_error" class="validation"><?php echo form_error('event_type'); ?></div>
                      </div>
                    </div>
                	<?php }
						else
						{
					?>
					<div class="col-md-4">
                      <div class="form-group">
                        <label for="event_type" class="control-label">Event Type <span class="text-red">*</span></label>
                        <select name="event_type" class="form-control selectpicker" id="event_type" data-show-subtext="true" data-live-search="true"   onchange="getCourseOrCountry()" title="Event Type">
                          <option value=""  selected="selected">Select Event Type</option>
                        </select>
                        <div id="event_type_error" class="validation"><?php echo form_error('event_type'); ?></div>
                      </div>
                    </div>
					<?php
					} ?>
              <?php
				}
				elseif($eventList->error_message->data->campaign->purpose_level_two[0]->purpose_level_two==36) //  Visa Events
				{ 
					$fdata['getCourseOrCountry'] =TRUE;
				?>
                 	 <?php
                    if(count($eventList->error_message->data->campaign->visa_event_type)==1)
                    { ?>
                        <input type="hidden" name="event_type" id="event_type" value="<?php echo $eventList->error_message->data->campaign->visa_event_type[0]->event_type_id; ?>">	
                    <?php }
                    elseif(count($eventList->error_message->data->campaign->visa_event_type)>1)
                    { ?>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="event_type" class="control-label">Event Type <span class="text-red">*</span></label>
                        <select name="event_type" class="form-control selectpicker" id="event_type" data-show-subtext="true" data-live-search="true"   onchange="getCourseOrCountry()" title="Event Type">
                          <option value=""  selected="selected">Select Event Type</option>
                          <?php
							foreach($eventList->error_message->data->campaign->visa_event_type as $P31)
							{
							?>
							<option value="<?php echo $P31->event_type_id; ?>"><?php echo $P31->eventTypeTitle; ?></option>
							<?php
							}?>
                        </select>
                        <div id="event_type_error" class="validation"><?php echo form_error('event_type'); ?></div>
                      </div>
                    </div>
                	<?php }
						else
						{
					?>
					<div class="col-md-4">
                      <div class="form-group">
                        <label for="event_type" class="control-label">Event Type <span class="text-red">*</span></label>
                        <select name="event_type" class="form-control selectpicker" id="event_type" data-show-subtext="true" data-live-search="true"   onchange="getCourseOrCountry()" title="Event Type">
                          <option value=""  selected="selected">Select Event Type</option>
                        </select>
                        <div id="event_type_error" class="validation"><?php echo form_error('event_type'); ?></div>
                      </div>
                    </div>
					<?php
					} ?>
              <?php
				}
				else
				{ ?>
                <div class="col-md-4">
                      <div class="form-group">
                        <label for="event_type" class="control-label">Event Type <span class="text-red">*</span></label>
                        <select name="event_type" class="form-control selectpicker" id="event_type" data-show-subtext="true" data-live-search="true"   onchange="getCourseOrCountry()" title="Event Type">
                          <option value=""  selected="selected">Select Event Type</option>
                        </select>
                        <div id="event_type_error" class="validation"><?php echo form_error('event_type'); ?></div>
                      </div>
                    </div>
                <?php
				} ?>
                             
                <?php
				if(count($eventList->error_message->data->campaign->academy_event_course)==1)
				{ 
					$fdata['getEventListByCourse'] =TRUE;
				?>
					<input type="hidden" name="event_course" id="event_course" value="<?php echo $eventList->error_message->data->campaign->academy_event_course[0]->test_module_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->academy_event_course)>1)
				{ ?>
                <div class="col-md-4" id="div_event_course">
                  <div class="form-group">
                    <label for="event_course" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="event_course" class="form-control selectpicker" id="event_course" data-show-subtext="true" data-live-search="true"   onchange="getEventListByCourse()" title="Course">
                      <option value=""  selected="selected">Select Course</option>
                      <?php
						foreach($eventList->error_message->data->campaign->academy_event_course as $P32)
						{
						?>
						<option value="<?php echo $P32->test_module_id; ?>"><?php echo $P32->test_module_name; ?></option>
						<?php
						}?>
                    </select>
                    <div id="event_course_error" class="validation"><?php echo form_error('event_course'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_event_course">
                  <div class="form-group">
                    <label for="event_course" class="control-label">Course <span class="text-red">*</span></label>
                    <select name="event_course" class="form-control selectpicker" id="event_course" data-show-subtext="true" data-live-search="true"   onchange="getEventListByCourse()" title="Course">
                      <option value=""  selected="selected">Select Course</option>
                    </select>
                    <div id="event_course_error" class="validation"><?php echo form_error('event_course'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
                <?php
				if(count($eventList->error_message->data->campaign->visa_event_country)==1)
				{
					$fdata['getEventListByCountry'] =TRUE;
			    ?>
					<input type="hidden" name="event_int_country" id="event_int_country" value="<?php echo $eventList->error_message->data->campaign->visa_event_country[0]->int_country_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->visa_event_country)>1)
				{ ?>
                <div class="col-md-4" id="div_event_int_country">
                  <div class="form-group">
                    <label for="event_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="event_int_country" class="form-control selectpicker" id="event_int_country" data-show-subtext="true" data-live-search="true"   onchange="getEventListByCountry()" title="Interested Country">
                      <option value=""  selected="selected">Select Interested Country</option>
                      <?php
						foreach($eventList->error_message->data->campaign->visa_event_country as $P33)
						{
						?>
						<option value="<?php echo $P33->int_country_id; ?>"><?php echo $P33->name; ?></option>
						<?php
						}?>
                     </select>
                    <div id="event_int_country_error" class="validation"><?php echo form_error('event_int_country'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
				?>
				<div class="col-md-4 hide" id="div_event_int_country">
                  <div class="form-group">
                    <label for="event_int_country" class="control-label">Interested Country <span class="text-red">*</span></label>
                    <select name="event_int_country" class="form-control selectpicker" id="event_int_country" data-show-subtext="true" data-live-search="true"   onchange="getEventListByCountry()" title="Interested Country">
                      <option value=""  selected="selected">Select Interested Country</option>
                     </select>
                    <div id="event_int_country_error" class="validation"><?php echo form_error('event_int_country'); ?></div>
                  </div>
                </div>
				<?php
				} ?>
                
            	<?php
				if(count($eventList->error_message->data->campaign->event_list)==1)
				{ ?>
					<input type="hidden" name="event_list" id="event_list" value="<?php echo $eventList->error_message->data->campaign->event_list[0]->event_id; ?>">	
				<?php }
				elseif(count($eventList->error_message->data->campaign->event_list)>1)
				{ ?>
                <div class="col-md-4" id="div_event_list">
                  <div class="form-group">
                    <label for="event_list" class="control-label">Event List <span class="text-red">*</span></label>
                    <select name="event_list" class="form-control selectpicker" id="event_list" data-show-subtext="true" data-live-search="true"   title="Event List">
                      <option value=""  selected="selected">Select Event List</option>
                      <?php
						foreach($eventList->error_message->data->campaign->event_list as $P34)
						{
						?>
						<option value="<?php echo $P34->event_id; ?>"><?php echo $P34->eventTitle; ?></option>
						<?php
						}?>
                    </select>
                    <div id="event_list_error" class="validation"><?php echo form_error('event_list'); ?></div>
                  </div>
                </div>
                <?php }
					else
					{
						if($eventList->error_message->data->campaign->is_show_event !=1)
						{
				?>
				<div class="col-md-4 hide" id="div_event_list">
                  <div class="form-group">
                    <label for="event_list" class="control-label">Event List <span class="text-red">*</span></label>
                    <select name="event_list" class="form-control selectpicker" id="event_list" data-show-subtext="true" data-live-search="true"   title="Event List">
                      <option value=""  selected="selected">Select Event List</option>
                    </select>
                    <div id="event_list_error" class="validation"><?php echo form_error('event_list'); ?></div>
                  </div>
                </div>
				<?php
						}
				} ?>
              </div>
            
            
             <div class="col-md-12 col-sm-12">
              <div class="text-right">
                <button id="btn_submit" type="button" class="btn btn-red btn-md">SUBMIT</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php

		foreach ($eventList->error_message->data->campaign->campaignSectionData as $sec_d) {
			if ($sec_d->type == 'text/image') {
		?>
    <!--text/image section--->
    <div class="glbl-box">
      <div class="slider-wrapper">
        <div class="contentpart"> 
        	<img src="<?php echo base_url(CAMPAIGN_IMAGE_PATH.$sec_d->image_video) ?>" alt="" class="imagepart">
          	<h2><?php echo $sec_d->heading; ?></h2>
          	<p><?php echo $sec_d->description; ?></p>
        </div>
      </div>
    </div>
    <?php }
		if ($sec_d->type == 'product') {
		?>
    <!--product section--->
    <div class="logo-box">
      <div class="logo-container">
        <?php
						foreach($eventList->error_message->data->campaign->campaignSectionProductData as $sec_d_p) {
						?>
        <div class="logo-item"> <a href="#"><img src="<?php echo base_url(CAMPAIGN_IMAGE_PATH.$sec_d_p->image) ?>" alt=""></a>
          <div class="lg-text"><?php echo $sec_d_p->heading; ?></div>
        </div>
        <?php } ?>
        
      </div>
    </div>
    <?php }
			if ($sec_d->type == 'video') {
			?>
    <!--Video section--->
    <div class="glbl-box ">
      <div class="vd-border">
        <div class="embed-responsive embed-responsive-16by9">
          <video autoplay preload="auto" loop="loop" muted="muted">
            <source src="<?php echo base_url(CAMPAIGN_VIDEO_PATH.$sec_d->image_video) ?>">
          </video>
        </div>
      </div>
    </div>
    <?php
			}
			if ($sec_d->type == 'text') {
			?>
    <!--text section--->
    <div class="glbl-box">
      <div class="content-wrapper"> <?php echo $sec_d->description; ?> </div>
    </div>
    <?php
	  }
	  if ($sec_d->type == 'image') {
	  ?>
    <!-- images section -->
    <div class="glbl-box ">
      <div class="image-wrapper"> 
      	<img src="<?php echo base_url(CAMPAIGN_IMAGE_PATH.$sec_d->image_video) ?>" alt="" class="mob-display-none"> 
        <img src="<?php echo base_url(CAMPAIGN_IMAGE_PATH.$sec_d->image_video) ?>"  alt="" class="no-lg-display"> 
      </div>
    </div>
    <?php
		}
	} ?>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <span class="text-success" id="otp_success_message"></span>
                <form>
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <label for="note" class="control-label"><span class="text-danger">*</span>OTP</label>
                            <div class="form-group">
                                <input name="otp" id="otp" class="form-control" title="OTP" required/>
                                <span class="text-danger otp_err"><?php echo form_error('otp'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="otp" class="control-label">&nbsp;</label>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger" onclick="verifyOtp();"><?php echo VERIFY; ?></button>
                            </div>
                            <span class="text-danger cursor_pointer" onclick="sendOtp('<?php echo $form_id; ?>', true);"><?php echo RESEND_OTP; ?></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<?php 
	$this->load->view('aa-front-end/campaign_purpose',$fdata);
?>
