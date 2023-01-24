<div class="row package_master-add_offline_pack">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
	            <div class="box-tools pull-right">
	            <?php
                    if($this->Role_model->_has_access_('package_master','online_pack')){
                ?>
	            <a href="<?php echo site_url('adminController/package_master/online_pack'); ?>" class="btn btn-warning btn-sm">Online Pack</a> <?php } ?>
	            <?php
                    if($this->Role_model->_has_access_('package_master','offline_pack')){
                ?>
                <a href="<?php echo site_url('adminController/package_master/offline_pack'); ?>" class="btn btn-danger btn-sm">Inhouse Pack</a><?php } ?>

              	<?php
              		if($this->Role_model->_has_access_('package_master','offline_pack')){
              		foreach ($all_testModule as $t) {
              			$test_module_id=  $t['test_module_id'];
              	?>
                  <a href="<?php echo site_url('adminController/package_master/offline_pack/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
              	<?php }} ?>
               </div>

            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/package_master/add_offline_pack'); ?>
			<input type="hidden" name="currency_code" id="currency_code" value="<?php echo $this->input->post('currency_code'); ?>" />
          	<div class="box-body">
          		<div class="clearfix flex-auto">

					<div class="col-md-4">
						<label for="package_name" class="control-label"><span class="text-danger">*</span>Pack Name</label>
						<div class="form-group">
							<input type="text" name="package_name" value="<?php echo $this->input->post('package_name'); ?>" class="form-control input-ui-100" id="package_name" maxlength="60"/>
							<span class="text-danger package_name_err"><?php echo form_error('package_name');?></span>
						</div>
					</div>

					<div class="col-md-4">
                        <label for="country_id" class="control-label"><span class="text-danger">*</span>
                            Country</label>
                        <div class="form-group">
                            <select id="country_id" name="country_id" class="form-control inDis selectpicker ccode selectCountry selectpicker-ui-100" data-show-subtext="true">
                                <option data-subtext="" value="">Select Country</option>
                                <?php
								foreach($all_countries as $p) {
									$selected = ($p['country_id'] == $this->input->post('country_id')) ? ' selected="selected"' : "";
										echo '<option  value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								}
								?>
                            </select>
                            <span class="text-danger country_id_err"><?php echo form_error('country_id');?></span>
                        </div>
                    </div>

					<div class="col-md-4 currencySelection" style="display:none;">
                        <label for="country_currency" class="control-label"><span class="text-danger">*</span>Country Currency</label>
                        <div class="form-group">
                            <select name="country_currency" id="country_currency" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                <option data-subtext="" value="">Select Currency</option>
                                <option value="default-currency" selected>Default Currency</option>
								<option value="<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>"><?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?></option>
                            </select>
                            <span class="text-danger country_currency_err"><?php echo form_error('country_currency');?></span>
                        </div>
                    </div>

					<div class="col-md-4">
						<label for="duration_type" class="control-label"><span class="text-danger">*</span>Duration type</label>
						<div class="form-group">
							<select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100">
								<option value="">Select</option>
								<?php
								foreach($all_duration_type as $p){
									$selected = ($p['id'] == $this->input->post('duration_type')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['duration_type'].'</option>';
								}
								?>
							</select>
							<span class="text-danger duration_type_err"><?php echo form_error('duration_type');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="duration" class="control-label"><span class="text-danger">*</span>Duration</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 30" name="duration" value="<?php echo $this->input->post('duration'); ?>" class="form-control chknum1 input-ui-100" id="duration" onblur='validate_duration(this.value)' maxlength="3"/>
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger duration_err"><?php echo form_error('duration');?></span>
						</div>
					</div>

					<?php
			            $course_timing_post=$this->input->post('course_timing[]');
			        ?>
					<div class="col-md-4">
						<label for="course_timing" class="control-label"><span class="text-danger">*</span>Course Type</label>
						<div class="form-group">
							<select name="course_timing[]" id="course_timing" class="form-control selectpicker selectpicker-ui-100"  data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select</option>
								<?php
								foreach($course_timing as $p){
									$selected='';
									if(in_array($p['id'],$course_timing_postz)){
										$selected='selected="selected"';
									}
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['course_timing'].'</option>';
								}
								?>
							</select>
							<span class="text-danger course_timing_err"><?php echo form_error('course_timing[]');?></span>
						</div>
					</div>
					<?php
			            $batch_id_post=$this->input->post('batch_id[]');
			        ?>
					<div class="col-md-4">
						<label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
						<div class="form-group">
							<select name="batch_id[]" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value=""  disabled="disabled">Select</option>
								<?php
								foreach($all_batch as $p){
									$selected='';
									if(in_array($p['batch_id'],$batch_id_post)){
										$selected='selected="selected"';
									}
									echo '<option value="'.$p['batch_id'].'" '.$selected.'>'.$p['batch_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger batch_id_err"><?php echo form_error('batch_id[]');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'offline_pack');">
								<option value="">Select Course</option>
								<?php
								foreach($all_test_module as $p){
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger test_module_id_err"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
								<option data-subtext="" value="">Select program</option>
								<?php
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger programe_id_err"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<?php
			            $category_id_post=$this->input->post('category_id[]');
			        ?>
					<div class="col-md-4 catBox">
						<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Category jjj</option>
								<?php
								foreach($all_category as $p){
									$selected='';
									if(in_array($p['category_id'],$category_id_post)){
										$selected='selected="selected"';
									}
									echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].' | '.$p['programe_name'].' | '.$p['category_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="image" class="control-label"><span class="text-danger">*</span>Media File</label>
						<?php echo PACKAGE_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="image" class="form-control input-file-ui" id="image" onchange="validate_file_type(this.id)"/>
						</div>
						<span class="text-danger image_err"><?php echo form_error('image');?></span>
					</div>

					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
							<div class="form-group has-feedback">
								<label for="global_price" class="control-label">Set real price globally for all branches</label>
								<input type="text" class="form-control chknum1 input-ui-100" name="global_real_price" id="global_real_price" maxlength="5" style="background:#fff0f2;" onkeyup="setRealPrice(this.value);" />
								<span class="form-control-feedback currency-symbol"></span>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group has-feedback">
								<label for="global_fake_price" class="control-label">Set fake price globally for all branches</label>
								<input type="text" class="form-control chknum1 input-ui-100" name="global_fake_price" id="global_fake_price" maxlength="5" style="background:#fff0f2;" onkeyup="setPackFakePrice(this.value);" />
								<span class="form-control-feedback currency-symbol"></span>
							</div>
						</div>
						</div>
						
					</div>					


					<div class="col-md-12 section_country" style="display:none;">
						<label for="brPrice" class="control-label">Set Price By Branch </label>
						<?php if($all_country_branches) { ?>
							<?php foreach($all_country_branches as $branchObj) { ?>
								<div class="form-flex sub_section_country section_country_id_<?php echo $branchObj["country_id"]; ?>" style="display:none;">
									<?php if($branchObj["branches"]) { ?>
										<?php foreach($branchObj["branches"] as $b) { ?>

										<div class="set-price-widget">

											<div class="col-md-5 form-group label-radio-rel mrg-top-30 has-feedback form-checkbox">
												<input type="checkbox" name="branchCB[]" value="<?php echo $b['center_id'];?>" id="<?php echo $b['center_id'];?>" checked="checked" onclick="manage_branch_cb(this.id);" class="branch_input_field country_id_<?php echo $branchObj["country_id"]; ?>" disabled/>
												<label for="<?php echo $b['center_id'];?>" class="control-label"><?php echo $b['center_name'];?></label>
												<span class="form-control-feedback currency-symbol"></span>
											</div>

											<div class="flex-input col-md-4 has-feedback">
												<input type="text" name="discounted_amount[]" placeholder="Pack real price for <?php echo $b['center_name'];?> branch" class="input-ui-100 form-control chknum1 global_real_price_data country_id_<?php echo $branchObj["country_id"]; ?> branch_input_field" id="discounted_amount<?php echo $b['center_id'];?>" maxlength="5" disabled/>
												<span class="form-control-feedback bg-currency currency-symbol"></span>
												<span class="text-danger discounted_amount_err"><?php echo form_error('discounted_amount[]');?></span>
											</div>

											<div class="flex-input col-md-4">
												<input type="text" name="fake_amount[]" placeholder="Pack fake price for <?php echo $b['center_name'];?> branch" class="input-ui-100 form-control chknum1 global_fake_price country_id_<?php echo $branchObj["country_id"]; ?> branch_input_field" id="fake_amount<?php echo $b['center_id'];?>" maxlength="5" disabled />
												<span class="form-control-feedback bg-currency currency-symbol"></span>
												<span class="text-danger fake_amount_err"><?php echo form_error('fake_amount[]');?></span>
											</div>

										</div>

										<?php } ?>
									<?php } ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>

					<!-- <div class="col-md-12">
						<label for="brPrice" class="control-label">Set Price By Branch </label>
						<div class="form-group">
							<?php
								foreach ($all_branch as $b) {
									if($b['center_name']!='Online' or $b['center_id']!=ONLINE_BRANCH_ID) { ?>
										<div class="form-flex">
											<div class="label-radio-rel mrg-top-30">
												<label for="<?php echo $b['center_id'];?>" class="control-label"><?php echo $b['center_name'];?></label>
												<input type="checkbox" name="branchCB[]" value="<?php echo $b['center_id'];?>" id="<?php echo $b['center_id'];?>" checked="checked" onclick="manage_branch_cb(this.id);"/>
											</div>

											<div class="flex-input col-md-6">
												<input type="text" name="discounted_amount[]" placeholder="Pack real price for <?php echo $b['center_name'];?> branch" class="form-control chknum1 global_real_price_data" id="discounted_amount<?php echo $b['center_id'];?>" maxlength="5"/>
											</div>
											<div class="flex-input col-md-6">
												<input type="text" name="fake_amount[]" placeholder="Pack fake price for <?php echo $b['center_name'];?> branch" class="form-control chknum1 global_fake_price" id="fake_amount<?php echo $b['center_id'];?>" maxlength="5"/>
											</div>
										</div>
										<?php
									}
								} ?>
							<br/>
						</div>
					</div>					 -->

					<div class="col-md-12">
						<label for="package_desc" class="control-label">Package Description</label>
						<div class="form-group has-feedback">
							<textarea name="package_desc" class="form-control myckeditor" id="package_desc"><?php echo $this->input->post('package_desc'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>

						<div class="col-md-1">
							<div class="form-group form-checkbox">
								<input type="checkbox" class="" name="active" value="1" id="active" checked="checked" />
								<label for="active" class="control-label">Active</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group form-checkbox">
								<input type="checkbox" class="" name="publish" value="1" id="publish" />
								<label for="publish" class="control-label">Publish</label>
							</div>
						</div>
					</div>

			</div>
          	<div class="box-footer">
			  <div class="col-md-2">
            	<button type="submit" class="btn btn-danger sbm rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
<?php ob_start();?>
<script type="text/javascript">
	<?php if(!empty($this->input->post("country_id"))) {
		$countryId = $this->input->post("country_id");
		?>
		$(".section_country").hide();
		$(".sub_section_country").hide();
		$(".branch_input_field").prop("disabled",true);
		if($(".section_country_id_<?php echo $countryId; ?>").length > 0) {
			$(".section_country").show();
			$(".section_country_id_<?php echo $countryId; ?>").show();
			$(".country_id_<?php echo $countryId; ?>").prop("disabled",false);
		}
	<?php } ?>

	$(document).on("click",'.branch_input_field',function(){
		var countryId = $("#country_id option:selected").val();
		var branchSelected = $('.country_id_'+countryId+':checked').length;

		if(!branchSelected) {
			$(this).prop("checked",true);
			manage_branch_cb($(this).attr("id"));
		}
	})

	$(document).on("change","#country_id",function(){
		var countryId 		= $(this).val();
		var currencyCode 	= getCountryCurrencyCodeByCountryId(countryId);
		$("#country_currency").val('default-currency');
		$("#country_currency").selectpicker('refresh');

		if(countryId) {
			$(".currencySelection").show();
			$(".section_country").hide();
			$(".sub_section_country").hide();
			$(".branch_input_field").prop("disabled",true);
			if($(".section_country_id_"+countryId).length > 0) {
				$(".section_country").show();
				$(".section_country_id_"+countryId).show();
				$(".country_id_"+countryId).prop("disabled",false);
			}
		}
		else {
			$(".currencySelection").hide();
		}

		if(currencyCode) {
			$("#currency_code").val(currencyCode);
			$(".currency-symbol").html(currencyCode);
		}
	});

	$(document).on("change","#country_currency",function(){
		var countryId 			 	= $("#country_id").val();
		var countryCurrencyType		= $(this).val();
		var countryCurrencyCode  	= getCountryCurrencyCodeByCountryId(countryId);

		if(countryId && countryCurrencyType == 'default-currency') {
			$("#currency_code").val(countryCurrencyCode);
			$(".currency-symbol").html(countryCurrencyCode);
		}
		else if(countryId && countryCurrencyType == '<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>') {
			$("#currency_code").val('<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>');
			$(".currency-symbol").html('<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>');
		}
	});

	function setRealPrice(global_real_price){
		$('.global_real_price_data').val(global_real_price);
		$('.global_fake_price').val(global_real_price);
	}

	function setPackFakePrice(global_fake_price) {
		$('.global_fake_price').val(global_fake_price);
	}

	function manage_branch_cb(cb_id){
		if($("#"+cb_id).prop('checked') == true){
			var global_real_price2 	= $('#global_real_price').val();
			var global_fake_price 	= $('#global_fake_price').val();
	        $('#discounted_amount'+cb_id).val(global_real_price2);
	        $('#discounted_amount'+cb_id).prop('disabled', false);

			$('#fake_amount'+cb_id).val(global_fake_price);
			$('#fake_amount'+cb_id).prop('disabled', false);
	    }else{
	        $('#discounted_amount'+cb_id).val('');
	        $('#discounted_amount'+cb_id).prop('disabled', true);
			$('#fake_amount'+cb_id).val('');
			$('#fake_amount'+cb_id).prop('disabled', true);
	    }
	}
</script>
<?php global $customJs; $customJs = ob_get_clean();?>