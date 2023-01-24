<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                  <?php if($this->Role_model->_has_access_('provinces','index')){?>
                  <a href="<?php echo site_url('adminController/provinces/index'); ?>" class="btn btn-danger btn-sm">Province List</a> <?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/provinces/add'); ?>
          	<div class="box-body">
          		<div class="">
					
					<div class="col-md-4">
						<label for="province_name" class="control-label">Province Name<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="province_name" value="<?php echo $this->input->post('province_name'); ?>" class="form-control input-ui-100" id="province_name" />
							<span class="text-danger"><?php echo form_error('province_name');?></span>
						</div>
					</div>

          <div class="col-md-4">
            <label for="image" class="control-label"> Province Images</label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">
              <input type="file" name="parent_image" class="form-control input-ui-100" id="parent_image"  onchange="validate_file_type_Webp(this.id)"/>
              <span class="text-danger parent_image_err"><?php echo form_error('parent_image');?></span>
            </div>
          </div>	

          <div class="col-md-4">
            <label for="image" class="control-label"> Province Slider Images</label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">
              <input type="file" name="files[]" class="form-control input-ui-100" id="files" multiple="" onchange="validate_file_type_Webp(this.id)"/>
              <span class="text-danger files_err"><?php echo form_error('parent_image');?></span>
            </div>
          </div>

          <div class="col-md-12">
            <label for="about" class="control-label">About Province</label>
            <div class="form-group has-feedback">
              <textarea name="about" class="form-control myckeditor" id="about"><?php echo $this->input->post('about'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
            </div>
          </div>

          <div class="col-md-12">
            <label for="education" class="control-label">Education in Province</label>
            <div class="form-group has-feedback">
              <textarea name="education" class="form-control myckeditor" id="education"><?php echo $this->input->post('education'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
            </div>
          </div>

          <div class="col-md-12">
            <label for="jobs" class="control-label">Jobs in Province</label>
            <div class="form-group has-feedback">
              <textarea name="jobs" class="form-control myckeditor" id="jobs"><?php echo $this->input->post('jobs'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
            </div>
          </div>	

          <div class="col-md-12">
            <label for="way_of_life" class="control-label">Way of life in Province</label>
            <div class="form-group has-feedback">
              <textarea name="way_of_life" class="form-control myckeditor" id="way_of_life"><?php echo $this->input->post('way_of_life'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
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
            	 <?php echo SAVE_LABEL;?>
            	</button>
               </div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>