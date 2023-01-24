<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"> <?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/city/edit/'.$city['city_id']); ?>
			<div class="box-body">
				<div class="clearfix">					
					
					<div class="col-md-4">
						<label for="country_id" class="control-label"><span class="text-danger">*</span>Country</label>
						<div class="form-group">
							<select name="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_state_list(this.value)">
								<option value="">Select country</option>
								<?php 
								foreach($all_country_list as $p)
								{
									$selected = ($p['country_id'] == $city['country_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('country_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="state_id" class="control-label"><span class="text-danger">*</span>State</label>
						<div class="form-group" id="state_dd">
							<select name="state_id" id="state_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select state</option>
								<?php 
								foreach($all_state_list as $p)
								{
									$selected = ($p['state_id'] == $city['state_id']) ? ' selected="selected"' : "";

									echo '<option data-subtext="'.$p['state_name'].'" value="'.$p['state_id'].'" '.$selected.'>'.$p['state_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('state_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="city_name" class="control-label"><span class="text-danger">*</span>City name</label>
						<div class="form-group has-feedback">
							<input type="text" name="city_name" value="<?php echo ($this->input->post('city_name') ? $this->input->post('city_name') : $city['city_name']); ?>" class="form-control input-ui-100" id="city_name" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
							<span class="text-danger"><?php echo form_error('city_name');?></span>
							<span class="glyphicon glyphicon-flag form-control-feedback"></span>
						</div>
					</div>
					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($city['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>