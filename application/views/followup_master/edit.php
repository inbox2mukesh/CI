<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/lead_management/edit_followup_status_/'.$followup['id']); ?>
			<div class="box-body">
				<div class="">
					
					<div class="col-md-6">
						<label for="title" class="control-label"><span class="text-danger">*</span>Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $followup['title']); ?>" class="form-control input-ui-100" id="title" />
							<span class="fa fa-search form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('title');?></span>
						</div>
					</div>

					<div class="col-md-12">
					<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($followup['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
				 <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>					
			<?php echo form_close(); ?>
		</div>
    </div>
</div>