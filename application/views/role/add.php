<div class="role-add">
  <div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools">
                    <?php
                        if($this->Role_model->_has_access_('role','index')){
                    ?>
                    <a href="<?php echo site_url('adminController/role/index'); ?>" class="btn btn-danger btn-sm">Role- List</a> <?php } ?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/role/add'); ?>
          	<div class="box-body">
    

					<div class="col-md-6">
						<label for="name" class="control-label"><span class="text-danger">*</span>Role name</label>
						<div class="form-group">
							<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control roleName" id="name" onblur="checkRoleNameValidity(this.value)"/>
							<span class="text-danger role_name_err"><?php echo form_error('name');?></span>
						</div>
					</div>

          <div class="col-md-12">
            <div class="form-group form-checkbox">
              <input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
              <label for="active" class="control-label">Active</label>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="cred" class="control-label">
              <i class="fa fa-info-circle text-info" aria-hidden="true"></i> <span class="text-danger"><?php echo ROLE_RULES;?></span></label>
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
</div>