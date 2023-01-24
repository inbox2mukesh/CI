<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Edit Gender </h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/gender/edit/'.$gender['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					
					<div class="col-md-6">
						<label for="gender_name" class="control-label"><span class="text-danger">*</span>Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="gender_name" value="<?php echo ($this->input->post('gender_name') ? $this->input->post('gender_name') : $gender['gender_name']); ?>" class="form-control input-ui-100" id="gender_name" />
							<span class="fa fa-venus form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('gender_name');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($gender['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
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