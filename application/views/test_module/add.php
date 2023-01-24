<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
						if($this->Role_model->_has_access_('test_module','index')){
					?>
                  <a href="<?php echo site_url('adminController/test_module/index'); ?>" class="btn btn-danger btn-sm">Courses List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/test_module/add'); ?>
          	<div class="box-body">
          	
					<input type="hidden" name="test_module_id_hidden" id="test_module_id_hidden" value="0">
					<div class="col-md-6">
						<label for="test_module_name" class="control-label"><span class="text-danger">*</span>Course Name</label>
						<div class="form-group">
							<input type="text" name="test_module_name" value="<?php echo $this->input->post('test_module_name'); ?>" class="form-control input-ui-100" id="test_module_name" onblur="check_course_name_duplicacy(this.value);"/>
							<span class="text-danger test_module_name_err"><?php echo form_error('test_module_name');?></span>
						</div>
					</div>						
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

					<div class="col-md-12">
						<label for="test_module_desc" class="control-label">Course Description</label>
						<div class="form-group has-feedback">
							<textarea name="test_module_desc" class="form-control" id="test_module_desc"><?php echo $this->input->post('test_module_desc'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>
					
				
			</div>
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>