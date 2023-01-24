<div class="role-edit">

      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Edit Role </h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/role/edit/'.$role['id']); ?>
			<div class="box-body">

					<div class="col-md-6">
						<label for="name" class="control-label"><span class="text-danger">*</span>Name</label>
						<div class="form-group">
							<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $role['name']); ?>" class="form-control input-ui-100" id="name" onblur="checkRoleNameValidity(this.value)"/>
							<span class="text-danger role_name_err"><?php echo form_error('name');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<!-- <label for="checkbox"></label> -->
						<div class="form-group">
							<input type="checkbox" name="active" value="1" <?php echo ($role['active']==1 ? 'checked="checked"' : ''); ?> id='active' class='checkbox-btn-ui' />
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
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>
			</div>
			<?php echo form_close(); ?>
		</div>
    </div>
