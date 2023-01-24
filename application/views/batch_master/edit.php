<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/batch_master/edit/'.$batch_master['batch_id']); ?>
			<div class="box-body">
				
					<input type="hidden" name="batch_id_hidden" id="batch_id_hidden" value="<?php echo $batch_master['batch_id'];?>" >
					<div class="col-md-6">
						<label for="batch_name" class="control-label"><span class="text-danger">*</span>Batch Name</label>
						<div class="form-group">
							<input type="text" name="batch_name" value="<?php echo ($this->input->post('batch_name') ? $this->input->post('batch_name') : $batch_master['batch_name']); ?>" class="form-control input-ui-100" id="batch_name" maxlength="20" onblur="check_batch_duplicacy(this.value);"/>
							<span class="text-danger batch_name_err"><?php echo form_error('batch_name');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($batch_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
					
					<div class="col-md-12">
						<label for="batch_desc" class="control-label">Batch Description</label>
						<div class="form-group has-feedback">
							<textarea name="batch_desc" class="form-control" id="batch_desc"><?php echo ($this->input->post('batch_desc') ? $this->input->post('batch_desc') : $batch_master['batch_desc']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>
			
			</div>
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>