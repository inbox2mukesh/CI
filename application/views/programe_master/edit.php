<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/programe_master/edit/'.$programe_master['programe_id']); ?>
			<div class="box-body">
			
					<input type="hidden" name="programe_id_hidden" id="programe_id_hidden" value="<?php echo $programe_master['programe_id'];?>">
					<div class="col-md-6">
						<label for="programe_name" class="control-label"><span class="text-danger">*</span>Program Name</label>
						<div class="form-group">
							<input type="text" name="programe_name" value="<?php echo ($this->input->post('programe_name') ? $this->input->post('programe_name') : $programe_master['programe_name']); ?>" class="form-control input-ui-100" id="programe_name" maxlength="100" onblur="check_programe_duplicacy(this.value);"/>
							<span class="text-danger programe_name_err"><?php echo form_error('programe_name');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($programe_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
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