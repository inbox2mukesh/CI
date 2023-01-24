<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/division_master/edit/'.$division_master['id']); ?>
			<div class="box-body">
					<div class="col-md-6">
						<label for="division_name" class="control-label"><span class="text-danger">*</span>Division Name</label>
						<div class="form-group">
							<input type="text" name="division_name" value="<?php echo ($this->input->post('division_name') ? $this->input->post('division_name') : $division_master['division_name']); ?>" class="form-control input-ui-100" id="division_name" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" />
							<span class="text-danger"><?php echo form_error('division_name');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($division_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						
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