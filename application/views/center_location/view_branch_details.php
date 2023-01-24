<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
margin-bottom: 5px;
}
.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>            
          	<div class="box-body">
          		<div class="clearfix">
					
					<div class="col-md-4">
						<label for="center_name" class="control-label">Branch name</label>
						<div class="form-group">
							<input type="text" name="center_name" value="<?php echo ($this->input->post('center_name') ? $this->input->post('center_name') : $center_location['center_name']); ?>" class="form-control input-ui-100" id="center_name" maxlength="25" readonly/>							
						</div>						
					</div>

					<div class="col-md-4">
						<label for="center_code" class="control-label">Branch code</label>
						<div class="form-group">
							<input type="text" name="center_code" value="<?php echo ($this->input->post('center_code') ? $this->input->post('center_code') : $center_location['center_code']); ?>" class="form-control input-ui-100" id="center_code" maxlength="3" readonly/>
						</div>						
					</div>

                    <?php 	
				        $physical_branch=$physical_branch=$center_location['physical_branch'];
					    if(isset($_POST['physical_branch'])){						
						    $physical_branch=$this->input->post('physical_branch');  
					   }
                   ?>                   
				   <div class="col-md-4">
						<label for="physical_branch" class="control-label">Physical Branch?</label>
						<div class="form-group">	
							<select name="physical_branch" id="physical_branch" class="form-control selectpicker selectpicker-ui-100" onchange="checkPhysicalBranch($(this).val())" disabled="disabled">
								<option value="1">Yes</option>
								<option value="0" <?php echo $physical_branch==0 ? 'selected="selected"':''?>>No</option>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<label for="is_overseas" class="control-label">Overseas Branch?</label>
						<div class="form-group">	
							<select name="is_overseas" id="is_overseas" class="form-control selectpicker selectpicker-ui-100"  disabled="disabled">
								<?php
									if($center_location['is_overseas']==1){
										$yesSelected = ' selected = "selected" ';
										$noSelected = '';
									}else{
										$yesSelected = '';
										$noSelected = ' selected = "selected" ';
									}
								?>
								<option value="1" <?php echo $yesSelected;?> >Yes</option>
								<option value="0" <?php echo $noSelected;?> >No</option>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<label for="contact" class="control-label">Contact no</label>
						<div class="form-group has-feedback">
							<input type="text" name="contact" value="<?php echo ($this->input->post('contact') ? $this->input->post('contact') : $center_location['contact']); ?>" class="form-control input-ui-100" id="contact" readonly/>
							<span class="glyphicon glyphicon-phone form-control-feedback"></span>
						</div>						
					</div>

					<div class="col-md-4">
						<label for="email" class="control-label">Email id</label>
						<div class="form-group has-feedback">
							<input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $center_location['email']); ?>" class="form-control input-ui-100" id="email" maxlength="60" readonly/>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						</div>						
					</div>
					<div id="PhysicalBranchData" style="display:<?php echo $physical_branch==1 ? '':'none'; ?>">
						<div class="col-md-4">
							<label for="country_id" class="control-label">Country</label>
							<div class="form-group">
								<select name="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_state_list(this.value)" disabled="disabled">
									<option  data-subtext="" value="">Select country</option>
									<?php 
									foreach($all_country_list as $p){
										$selected = ($p['country_id'] == $center_location['country_id']) ? ' selected="selected"' : "";
										echo '<option data-subtext="'.$p['name'].'" value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
									} 
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<label for="state_id" class="control-label">State</label>
							<div class="form-group" id="state_dd">
								<select name="state_id" id="state_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_city_list(this.value)" disabled="disabled">
									<option  data-subtext="" value="">Select state</option>
									<?php 
									foreach($all_state_list as $p)
									{									
										$selected = ($p['state_id'] == $center_location['state_id']) ? ' selected="selected"' : "";
										echo '<option data-subtext="'.$p['state_name'].'" value="'.$p['state_id'].'" '.$selected.'>'.$p['state_name'].'</option>';
									} 
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<label for="city_id" class="control-label">City</label>
							<div class="form-group" id="city_dd">
								<select name="city_id" id="city_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" disabled="disabled">
									<option data-subtext="" value="">Select city</option>
									<?php 
									foreach($all_city_list as $p)
									{										
										$selected = ($p['city_id'] == $center_location['city_id']) ? ' selected="selected"' : "";
										echo '<option data-subtext="'.$p['city_name'].'" value="'.$p['city_id'].'" '.$selected.'>'.$p['city_name'].'</option>';
									} 
									?>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<label for="address_line_1" class="control-label">Address</label>
							<div class="form-group has-feedback">
								<textarea name="address_line_1" class="form-control" id="address_line_1" readonly><?php echo ($this->input->post('address_line_1') ? $this->input->post('address_line_1') : $center_location['address_line_1']); ?>
							</textarea>
							<span class="glyphicon glyphicon-home form-control-feedback">
							</div>
						</div>

						<div class="col-md-3">
							<label for="zip_code" class="control-label">ZIP Code</label>
							<div class="form-group">
								<input type="text" name="zip_code" value="<?php echo ($this->input->post('zip_code') ? $this->input->post('zip_code') : $center_location['zip_code']); ?>" class="form-control chknum1 input-ui-100" id="zip_code" maxlength="6" readonly/>
							</div>						
						</div>

						<div class="col-md-3">
							<label for="latitude" class="control-label">Latitude</label>
							<div class="form-group has-feedback">
								<input type="text" name="latitude" value="<?php echo ($this->input->post('latitude') ? $this->input->post('latitude') : $center_location['latitude']); ?>" class="form-control input-ui-100" id="latitude" readonly/>
								<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
							</div>						
						</div>

						<div class="col-md-3">
							<label for="longitude" class="control-label">Longitude</label>
							<div class="form-group has-feedback">
								<input type="text" name="longitude" value="<?php echo ($this->input->post('longitude') ? $this->input->post('longitude') : $center_location['longitude']); ?>" class="form-control input-ui-100" id="longitude" readonly/>
								<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
							</div>						
						</div>
                    </div>

					<div class="col-md-3">
						<label for="feedbackLink" class="control-label">Feeback Link</label>
						<div class="form-group has-feedback">
							<input type="text" name="feedbackLink" value="<?php echo ($this->input->post('feedbackLink') ? $this->input->post('feedbackLink') : $center_location['feedbackLink']); ?>" class="form-control input-ui-100" id="feedbackLink" readonly/>
							<span class="form-control-feedback"><i class="fa fa-link"></i></span>
						</div>
					</div>

					<div class="col-md-12">
					    <!-- <label for="feedbackLink" class="control-label"></label> -->
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($center_location['active']==1 ? 'checked="checked"' : ''); ?> id='active'  disabled="disabled"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>				
					
					<div class="col-md-12 text-blue" style="margin-bottom:10px; font-size:16px">
					<b>Assigned Division <span class="text-danger">*</span></b>
					<hr>
					</div>
					<?php			
					$branch_divisions=$this->input->post('branch_divisions');
					
					if(empty($branch_divisions)){
						
						$branch_divisions=$center_divisions;
					}
					$i=1;
					foreach($all_division_list as $division){
						$id = 'branch_divisions'.$i;
					?>
					<div class="col-md-4">
						<div class="form-group form-checkbox">
							<input type="checkbox" id="<?php echo $id;?>" name="branch_divisions[]" value="<?php echo $division['id']?>" <?php if(in_array($division['id'],$branch_divisions)){ echo "checked";}?>  disabled="disabled"/>
							<label for="<?php echo $id;?>" class="control-label"><?php echo ucfirst($division['division_name'])?></label>
							<span class="text-danger"><?php echo form_error('branch_divisions[]');?></span>
						</div>
					</div>
					<?php $i++; }?>
					<hr>
					<div class="col-md-12 text-blue" style="margin-bottom:10px; font-size:16px"><b>Branch Managements</b>
				
					<hr>
				
				</div>
				
					<div class="col-md-4">
						<label for="center_id" class="control-label">Branch Head</label>
						<?php
						foreach ($center_heads as $c) {
							echo '<button disabled="disabled" type="button" class="btn btn-md btn-success del" onclick=deleteUserCenterHead('.$c["center_id"].','.$c["id"].')>
               				'.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'<i class="fa fa-close cross-icn"></i></button>';
						} ?>
						<div class="form-group">
							<select name="center_heads[]" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" disabled="disabled">
								<option value="" disabled="disabled">Select Branch Head</option>
								<?php 
								foreach($user_list as $b)
								{
								    $selected='';
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
									
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_heads');?></span>
						</div>
					</div>
					<div class="col-md-4">
						<label for="center_id" class="control-label">Academy Management</label>
						<?php
							foreach ($center_academy_managements as $c) {
							echo '<button disabled="disabled" type="button" class="btn btn-info btn-md del" onclick=deleteUserCenterAcademyManagements('.$c["center_id"].','.$c["id"].')>
               				'.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'<i class="fa fa-close cross-icn"></i></button>';
						 } ?>
						<div class="form-group">
							<select name="center_academy_managements[]" id="center_academy_managements" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" disabled="disabled">
								<option value="" disabled="disabled">Select Academy Management</option>
								<?php 
								foreach($user_list as $b)
								{							   
								    $selected='';
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_academy_managements');?></span>
						</div>
					</div>
					<div class="col-md-4">
						<label for="center_id" class="control-label">Visa Management</label>
						<?php
							foreach ($center_visa_managements as $c) {
							echo '<button disabled="disabled" type="button" class="btn btn-warning btn-sm del" onclick=deleteUserCenterVisaManagements('.$c["center_id"].','.$c["id"].')>
               				'.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'<i class="fa fa-close cross-icn"></i></button>';
						 } ?>
						<div class="form-group">
							<select name="center_visa_managements[]" id="center_visa_managements" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" disabled="disabled">
								<option value="" disabled="disabled">Select Visa Management</option>
								<?php 
								foreach($user_list as $b)
								{							
								    $selected='';
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_visa_managements');?></span>
						</div>
					</div>
					
				</div>
				</div>
			</div>
          	<!-- <div class="box-footer">
            	<button type="submit" class="btn btn-danger">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button> 
          	</div> -->
      	</div>
    </div>
</div>
<script>
    function checkPhysicalBranch(physicalBranch){
		
	    if(physicalBranch==1){
		    $("#PhysicalBranchData").show();  
	    }else{
			$("#PhysicalBranchData").hide();  
		}
    }
</script>