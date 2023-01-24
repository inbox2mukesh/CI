<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                  <?php 
                    if($this->Role_model->_has_access_('content_type_master','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/content_type_master/index'); ?>" class="btn btn-danger btn-sm">Content Type</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/content_type_master/add'); ?>
          	<div class="box-body">
          		
			  <input type="hidden" name="content_id_hidden" id="content_id_hidden" value="0" >
					<div class="col-md-6">
						<label for="content_type_name " class="control-label"><span class="text-danger">*</span>Content Type </label>
						<div class="form-group">
							<input type="text" name="content_type_name" value="<?php echo $this->input->post('content_type_name'); ?>" class="form-control input-ui-100" id="content_type_name" onblur="check_content_type_duplicacy(this.value);"/>
							<span class="text-danger content_type_name_err"><?php echo form_error('content_type_name');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
					
			
			</div>
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20 sbm">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>