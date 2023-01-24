<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
          
			<div class="box-body">
			<?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/country/edit/'.$country['country_id']); ?>
				<div class="clearfix">
					
					<div class="col-md-4">
						<label for="name" class="control-label"><span class="text-danger">*</span>Country Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $country['name']); ?>" class="form-control input-ui-100" id="name" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="60"/>
							<span class="glyphicon glyphicon-flag form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('name');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="iso3" class="control-label"><span class="text-danger">*</span>ISO-3</label>
						<div class="form-group">
							<input type="text" name="iso3" value="<?php echo ($this->input->post('iso3') ? $this->input->post('iso3') : $country['iso3']); ?>" class="form-control input-ui-100" id="iso3" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="3"/>
							
							<span class="text-danger"><?php echo form_error('iso3');?></span>
						</div>
					</div>

					<?php
    					$country_code = $country['country_code'];
    					$country_code = ltrim($country_code, '+');
					?>
					<div class="col-md-4">
						<label for="country_code" class="control-label"><span class="text-danger">*</span>Country code</label>
						<div class="form-group has-feedback">
							<input type="text" name="country_code" value="<?php echo ($this->input->post('country_code') ? $this->input->post('country_code') : $country_code); ?>" class="form-control chknum1 input-ui-100" id="country_code"  maxlength="4"/>
							<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('country_code');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="currency_code" class="control-label">Currency</label>
						<div class="form-group has-feedback">
								<input type="text" name="currency_code" value="<?php echo ($this->input->post('currency_code') ? $this->input->post('currency_code') : $country['currency_code']); ?>" class="form-control input-ui-100" id="currency_code" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)"  maxlength="4"/>
							<span class="text-danger"><?php echo form_error('currency_code');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="flag" class="control-label">Flag Link</label>
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/add');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL;?></a>
						</span>
						]&nbsp;
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/index');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL_LIST;?></a>
						</span>
						]
						<div class="form-group has-feedback">
							<input type="url" name="flag" value="<?php echo ($this->input->post('flag') ? $this->input->post('flag') : $country['flag']); ?>" class="form-control input-ui-100" id="flag" />
							<span class="glyphicon glyphicon-link form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('flag');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="min_phoneNo_limit" class="control-label">Contact No. Length(Min.)</label>
						<div class="form-group has-feedback">
								<input type="text" name="min_phoneNo_limit" value="<?php echo ($this->input->post('min_phoneNo_limit') ? $this->input->post('min_phoneNo_limit') : $country['min_phoneNo_limit']); ?>" class="form-control chknum1 input-ui-100" id="min_phoneNo_limit" min="1" max="2" maxlength="2" minlength="1"/>
							<span class="text-danger"><?php echo form_error('min_phoneNo_limit');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="phoneNo_limit" class="control-label">Contact No. Length(Max.)</label>
						<div class="form-group has-feedback">
								<input type="text" name="phoneNo_limit" value="<?php echo ($this->input->post('phoneNo_limit') ? $this->input->post('phoneNo_limit') : $country['phoneNo_limit']); ?>" class="form-control chknum1 input-ui-100" id="phoneNo_limit" min="1" max="2" maxlength="2" minlength="1"/>
							<span class="text-danger"><?php echo form_error('phoneNo_limit');?></span>
						</div>
					</div>					

					<div class="col-md-4">
						<div class="form-group form-checkbox mt-30">							
							<input type="checkbox" name="we_deal?" value="1" <?php echo ($country['we_deal?']==1 ? 'checked="checked"' : ''); ?> id='we_deal?' />	
							<label for="we_deal?" class="control-label">We deal in this country?</label>
						</div>
					</div>					
					
					<div class="col-md-4">
						<div class="form-group form-checkbox mt-30">							
							<input type="checkbox" name="active" value="1" <?php echo ($country['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
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