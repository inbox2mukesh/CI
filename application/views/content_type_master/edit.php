<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/content_type_master/edit/'.$content_type_master['id']); ?>
			<div class="box-body">
			<input type="hidden" name="content_id_hidden" id="content_id_hidden" value="<?php echo $content_type_master['id'];?>" >
					<div class="col-md-6">
						<label for="document_type_name" class="control-label"><span class="text-danger">*</span>Content Type</label>
						<div class="form-group">
					<input type="text" name="content_type_name" value="<?php echo ($this->input->post('content_type_name') ? $this->input->post('content_type_name') : $content_type_master['content_type_name']); ?>" class="form-control input-ui-100" id="content_type_name" onblur="check_content_type_duplicacy(this.value);"/>
					<span class="text-danger content_type_name_err"><?php echo form_error('content_type_name');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1" <?php echo ($content_type_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>				
				
			</div>
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20 sbm">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>		
			</div>			
			<?php echo form_close(); ?>
		</div>
    </div>
</div>