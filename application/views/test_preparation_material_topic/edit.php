<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/test_preparation_material_topic/edit/'.$topic_master['topic_id']); ?>
			<div class="box-body">
			
					<input type="hidden" name="topic_id_hidden" id="topic_id_hidden" value="<?php echo $topic_master['topic_id'];?>" >
					<div class="col-md-6">
						<label for="topic" class="control-label"><span class="text-danger">*</span>Topic</label>
						<div class="form-group">
							<input type="text" name="topic" value="<?php echo ($this->input->post('topic') ? $this->input->post('topic') : $topic_master['topic']); ?>" class="form-control input-ui-100" id="topic" maxlength="20" onblur="check_test_preparation_duplicacy(this.value);"/>
							<span class="text-danger topic_err"><?php echo form_error('topic');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($topic_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
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