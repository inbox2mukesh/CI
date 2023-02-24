<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
						if($this->Role_model->_has_access_('batch_master','index')){
					?>
                  	<a href="<?php echo site_url('adminController/batch_master/index'); ?>" class="btn btn-danger btn-sm">Batch List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/batch_master/add'); ?>
          	<div class="box-body">
          		
					<input type="hidden" name="batch_id_hidden" id="batch_id_hidden" value="0" >
					<div class="col-md-6">
						<label for="batch_name" class="control-label"><span class="text-danger">*</span>Batch Name</label>
						<div class="form-group">
							<input type="text" name="batch_name" value="<?php echo $this->input->post('batch_name'); ?>" class="form-control input-ui-100" id="batch_name" maxlength="40" onblur="check_batch_duplicacy(this.value);"/>
							<span class="text-danger batch_name_err"><?php echo form_error('batch_name');?></span>
						</div>
					</div>						
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
							
						</div>
					</div>
					
					<div class="col-md-12">
						<label for="batch_desc" class="control-label">Batch Description</label>
						<div class="form-group has-feedback">
							<textarea name="batch_desc" class="form-control" id="batch_desc"><?php echo $this->input->post('batch_desc'); ?></textarea>
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