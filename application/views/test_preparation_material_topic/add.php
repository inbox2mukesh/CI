<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
						if($this->Role_model->_has_access_('test_preparation_material_topic','index')){
					?>
                  	<a href="<?php echo site_url('adminController/test_preparation_material_topic/index'); ?>" class="btn btn-danger btn-sm">Topic List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/test_preparation_material_topic/add'); ?>
          	<div class="box-body">
          	
					<input type="hidden" name="batch_id_hidden" id="batch_id_hidden" value="0" >
					<div class="col-md-6">
						<label for="topic" class="control-label"><span class="text-danger">*</span>Topic</label>
						<div class="form-group">
							<input type="text" name="topic" value="<?php echo $this->input->post('Topic'); ?>" class="form-control input-ui-100" id="topic" maxlength="20" onblur="check_test_preparation_duplicacy(this.value);"/>
							<span class="text-danger topic_err"><?php echo form_error('topic');?></span>
						</div>
					</div>						
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
							
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