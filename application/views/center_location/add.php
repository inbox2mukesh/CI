<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools">
                  <?php 
                  if($this->Role_model->_has_access_('center_location','index')){
                  ?>
                    <a href="<?php echo site_url('adminController/center_location/index'); ?>" class="btn btn-danger btn-sm">Branch/IB List</a> 
                <?php }?>
                </div>              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/center_location/add', array('onsubmit' => 'return validate_branch_form();'));?>
          	<div class="box-body">
          		<div class="clearfix">
          			<?php                     				
					    $independent_body=0;
					    if(isset($_POST['independent_body'])){						
						    $independent_body=$this->input->post('independent_body');  
					    }
					?>
          			<div class="col-md-4">
						<label for="independent_body" class="control-label">Independent body?<span class="text-danger">*</span> </label>
						<div class="form-group">	
							<select name="independent_body" id="independent_body" class="form-control selectpicker selectpicker-ui-100" onchange="checkIndependent($(this).val())">
								<option value="1">Yes</option>
								<option value="0" <?php echo $independent_body==0 ? 'selected="selected"':''?>>No</option>
							</select>						
							<span class="text-danger independent_body_err"><?php echo form_error('independent_body');?></span>
						</div>
					</div>
					
					<div class="col-md-4">
						<label for="center_name" class="control-label">Branch/IB name<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="center_name" value="<?php echo $this->input->post('center_name');?>" class="form-control input-ui-100" id="center_name" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="25"/>	
							<span class="text-danger center_name_err"><?php echo form_error('center_name');?></span>
						</div>						
					</div>

					<div class="col-md-4">
						<label for="center_code" class="control-label">Branch/IB code<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="center_code" value="<?php echo $this->input->post('center_code'); ?>" class="form-control input-ui-100" id="center_code" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="3"/>	
							<span class="text-danger center_code_err"><?php echo form_error('center_code');?></span>
						</div>						
					</div>
                    <?php                     				
					    $physical_branch=1;
					    if(isset($_POST['physical_branch'])){						
						    $physical_branch=$this->input->post('physical_branch');  
					    }
					?>
					<div class="col-md-4 noIB">
						<label for="physical_branch" class="control-label">Physical Branch?<span class="text-danger">*</span> </label>
						<div class="form-group">	
							<select name="physical_branch" id="physical_branch" class="form-control selectpicker selectpicker-ui-100" onchange="checkPhysicalBranch($(this).val())">
								<option value="1">Yes</option>
								<option value="0" <?php echo $physical_branch==0 ? 'selected="selected"':''?>>No</option>
							</select>						
							<span class="text-danger physical_branch_err"><?php echo form_error('physical_branch');?></span>
						</div>
					</div>

					<div class="col-md-4 noIB">
						<label for="is_overseas" class="control-label">Overseas Branch?<span class="text-danger">*</span> </label>
						<div class="form-group">	
							<select name="is_overseas" id="is_overseas" class="form-control selectpicker selectpicker-ui-100">
								<option value="1">Yes</option>
								<option value="0" selected="selected">No</option>
							</select>						
							<span class="text-danger is_overseas_err"><?php echo form_error('is_overseas');?></span>
						</div>
						<div class="isOverseasHide"></div>
					</div>					

					<div class="col-md-4 noIB">
						<label for="contact" class="control-label">Contact no.(if multiple write with comma seperated)<span class="text-danger">*</span></label>
						<div class="form-group has-feedback">
							<input type="text" name="contact" value="<?php echo $this->input->post('contact'); ?>" class="form-control input-ui-100" id="contact" maxlength="60"/>
							<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							<span class="text-danger contact_err"><?php echo form_error('contact');?></span>
						</div>						
					</div>

					<div class="col-md-4 noIB">
						<label for="email" class="control-label">Email id (if multiple write with comma seperated)<span class="text-danger">*</span></label>
						<div class="form-group has-feedback">
							<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control input-ui-100" id="email" maxlength="100"/>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							<span class="text-danger email_err"><?php echo form_error('email');?></span>
						</div>						
					</div>

					<div id="PhysicalBranchData" style="display:<?php echo $physical_branch==1 ? '':'none'; ?>">

					<div class="col-md-4 noIB">
						<label for="country_id" class="control-label">Country<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_state_list(this.value)">
								<option data-subtext="" value="">Select country</option>
								<?php 
								foreach($all_country_list as $p)
								{	
									$selected = ($p['country_id'] == $this->input->post('country_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger country_id_err"><?php echo form_error('country_id');?></span>
						</div>
					</div>

					<div class="col-md-4 noIB">
						<label for="state_id" class="control-label">State<span class="text-danger">*</span></label>
						<div class="form-group" id="state_dd">	
							<select name="state_id" id="state_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_city_list(this.value)">
								<option data-subtext="" value="">Select state</option>
								<?php 
									
									$selected = $this->input->post('state_id') ? ' selected="selected"' : "";
									echo '<option value="'.$this->input->post('state_id').'" '.$selected.'>'.$p['state_name'].'</option>';
								
								?>
							</select>						
							<span class="text-danger state_id_err"><?php echo form_error('state_id');?></span>
						</div>
					</div>					

					<div class="col-md-4 noIB">
						<label for="city_id" class="control-label">City<span class="text-danger">*</span></label>
						<div class="form-group" id="city_dd">	
							<select name="city_id" id="city_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
								<option data-subtext="" value="">Select city</option>
							</select>						
							<span class="text-danger city_id_err"><?php echo form_error('city_id');?></span>
						</div>
					</div>

					<div class="col-md-12 noIB">
						<label for="address_line_1" class="control-label">Address<span class="text-danger">*</span></label>
						<div class="form-group has-feedback">
							<textarea name="address_line_1" class="form-control" id="address_line_1"><?php echo $this->input->post('address_line_1'); ?></textarea>
							<span class="glyphicon glyphicon-home form-control-feedback"></span>
							<span class="text-danger address_line_1_err"><?php echo form_error('address_line_1');?></span>
						</div>
					</div>
					
					<div class="col-md-4 noIB">
						<label for="zip_code" class="control-label">ZIP Code</label>
						<div class="form-group">
							<input type="text" name="zip_code" value="<?php echo $this->input->post('zip_code'); ?>" class="form-control chknum1 input-ui-100" id="zip_code" maxlength="6"/>
							<span class="text-danger"><?php echo form_error('zip_code');?></span>
						</div>						
					</div>

					<div class="col-md-4 noIB">
						<label for="latitude" class="control-label">Latitude</label>
						<div class="form-group has-feedback">
							<input type="text" name="latitude" value="<?php echo $this->input->post('latitude'); ?>" class="form-control input-ui-100" id="latitude" />
							<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('latitude');?></span>
						</div>						
					</div>

					<div class="col-md-4 noIB">
						<label for="longitude" class="control-label">Longitude</label>
						<div class="form-group has-feedback">
							<input type="text" name="longitude" value="<?php echo $this->input->post('longitude'); ?>" class="form-control input-ui-100" id="longitude" />
							<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('longitude');?></span>
						</div>						
					</div>
                    </div>
					<div class="col-md-4 noIB">
						<label for="feedbackLink" class="control-label">Feeback Link</label>
						<div class="form-group has-feedback">
							<input type="text" name="feedbackLink" value="<?php echo $this->input->post('feedbackLink'); ?>" class="form-control input-ui-100" id="feedbackLink" onblur="checkURL();"/>
							<span class="form-control-feedback"><i class="fa fa-link"></i></span>
							<span class="text-danger link_err"><?php echo form_error('feedbackLink');?></span>
						</div>
					</div>
					
                    <div class="col-md-12">
						<label for="feedbackLink" class="control-label"></label>
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>		
							<label for="active" class="control-label">Active</label>					
						</div>
					</div>

					<div class="col-md-12">
					<b>Assign Division<span class="text-danger">*</span></b>
					<hr>
					</div>
					<?php						
					$branch_divisions=$this->input->post('branch_divisions');
					if(isset($branch_divisions)){

					}else{
						$branch_divisions=[];
					}
					$i=1;
					foreach($all_division_list as $division){
						$id = 'branch_divisions'.$i;
					?>
					<div class="col-md-4">
						<div class="form-group form-checkbox">
							<input type="checkbox" id="<?php echo $id;?>" name="branch_divisions[]" value="<?php echo $division['id']?>" <?php if(in_array($division['id'],$branch_divisions)){ echo "checked";}?>/>
							<label for="<?php echo $id;?>" class="control-label"><?php echo ucfirst($division['division_name'])?></label>
							<span class="text-danger branch_divisions_err"><?php echo form_error('branch_divisions[]');?></span>
						</div>
					</div>
					
					<?php 
					$i++;
					}?>
				</div>
			</div>
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
<?php ob_start();?>
<script>
    function checkPhysicalBranch(physicalBranch){
		
	    if(physicalBranch==1){
		    $("#PhysicalBranchData").show();  
	    }else{
			$("#PhysicalBranchData").hide();  
		}
    }

    function checkIndependent(independent_body){

    	if(independent_body==1){
		    $(".noIB").hide();
	    }else{
			$(".noIB").show();  
		}

    }

    function checkURL(){

    	var feedbackLink = $("#feedbackLink").val();
    	if(feedbackLink){
    		var regex = /(?:https?):\/\/(\w+:?\w*)?(\S+)(:\d+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
			if(!regex.test(feedbackLink)) {
				$(".link_err").text('Please enter valid URL!');
				return false;
			}else{
				$(".link_err").text('');
			}
    	}else{
    		$(".link_err").text('');
    	}		
    }
</script>
<?php global $customJs;
$customJs=ob_get_clean();?>
