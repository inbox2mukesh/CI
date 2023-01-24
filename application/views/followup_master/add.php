<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                   <?php if($this->Role_model->_has_access_('lead_management','followup_status_list')){?>
                  <a href="<?php echo site_url('adminController/lead_management/followup_status_list'); ?>" class="btn btn-danger btn-sm">List Followup Status</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/lead_management/add_followup_status_'); ?>
          	<div class="box-body">
          		<div class="">
					
					<div class="col-md-6">
						<label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group has-feedback">
							<input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control allow_alphabets input-ui-100" id="title" required/>
              <span class="fa fa-search form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('title');?></span>
						</div>
					</div>

          <div class="col-md-12">
          <div class="form-group form-checkbox">
              <input type="checkbox" name="active" value="1" id="active" checked="checked"/>
              <label for="active" class="control-label">Active</label>
            </div>
          </div>
          
				</div>
			</div>
          	<div class="box-footer">
              <div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
               <?php echo SAVE_LABEL;?>
              </button>
              </div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>