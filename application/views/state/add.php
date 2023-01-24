<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools pull-right">
              	<?php 
                if($this->Role_model->_has_access_('country','index')){
                ?>	
                  <a href="<?php echo site_url('adminController/country/index'); ?>" class="btn btn-danger btn-sm">Country List</a>
              	<?php }?>
              	<?php 
                if($this->Role_model->_has_access_('state','index')){
                ?>
                  <a href="<?php echo site_url('adminController/state/index'); ?>" class="btn btn-danger btn-sm">State List</a>
                <?php }?>
                <?php 
                if($this->Role_model->_has_access_('city','index')){
                ?> 
                  <a href="<?php echo site_url('adminController/city/index'); ?>" class="btn btn-danger btn-sm">City List</a>
                <?php }?>  
               </div>
            </div>
           
          	<div class="box-body">
			  <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/state/add'); ?>
          		<div class="clearfix">

					<div class="col-md-6">
						<label for="country_id" class="control-label"><span class="text-danger">*</span>Country</label>
						<div class="form-group">
							<select name="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option value="">Select country</option>
								<?php 
								foreach($all_country_list as $p)
								{	
									echo '<option value="'.$p['country_id'].'" >'.$p['name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('country_id');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="category_name" class="control-label"><span class="text-danger">*</span>State Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="state_name" value="<?php echo $this->input->post('state_name'); ?>" class="form-control input-ui-100" id="state_name" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
							<span class="glyphicon glyphicon-flag form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('state_name');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

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