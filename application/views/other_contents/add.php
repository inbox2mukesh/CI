<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
                  if($this->Role_model->_has_access_('other_contents','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/other_contents/index'); ?>" class="btn btn-danger btn-sm">Contents List</a>
              <?php }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/other_contents/add'); ?>
          	<div class="box-body">
          		<div class="">
					
					<div class="col-md-6">
						<label for="content_title" class="control-label"><span class="text-danger">*</span>Title/Heading</label>
						<div class="form-group">
							<input type="text" name="content_title" value="<?php echo $this->input->post('content_title'); ?>" class="form-control input-ui-100" id="content_title" maxlength="25"/>
							<span class="text-danger"><?php echo form_error('content_title');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="content_type" class="control-label"><span class="text-danger">*</span>Type</label>
						<div class="form-group">
							<select name="content_type" id="content_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option value="">Select Type</option>
								<option value="tc">Terms & Conditions</option>
								<option value="tcc">Terms & Conditions (Checkout)</option>
								<option value="dc">Disclaimer</option>
								<option value="cp">Cookie Policy</option>	
							</select>
							<span class="text-danger"><?php echo form_error('content_type');?></span>
						</div>
					</div>					

					<div class="col-md-12">
						<label for="content_desc" class="control-label">Description</label>
						<div class="form-group has-feedback">
							<textarea name="content_desc" class="form-control myckeditor" id="content_desc"><?php echo $this->input->post('content_desc'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
						<span class="text-danger"><?php echo form_error('content_desc');?></span>
					</div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
						<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>	
						<label for="active" class="control-label">Active</label>					
						</div>
					</div>
					
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
				  </div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>