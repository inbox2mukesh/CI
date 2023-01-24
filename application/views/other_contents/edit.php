<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/other_contents/edit/'.$other_contents['content_id']); ?>
			<div class="box-body">
				<div class="">
					
					<div class="col-md-6">
						<label for="content_title" class="control-label"><span class="text-danger">*</span>Title/Heading</label>
						<div class="form-group">
							<input type="text" name="content_title" value="<?php echo ($this->input->post('content_title') ? $this->input->post('content_title') : $other_contents['content_title']); ?>" class="form-control input-ui-100" id="content_title" maxlength="25"/>
							<span class="text-danger"><?php echo form_error('content_title');?></span>
						</div>
					</div>

					<?php
						if($other_contents['content_type']=='tc'){

							$selected_tc = ' selected = "selected" ';
							$selected_dc ='';
							$selected_cp ='';
							$selected_tcc ='';
						}
						if($other_contents['content_type']=='tcc'){

							$selected_tcc = ' selected = "selected" ';
							$selected_tc = '';
							$selected_dc ='';
							$selected_cp ='';
						}
						elseif($other_contents['content_type']=='dc'){

							$selected_dc = ' selected = "selected" ';
							$selected_tc ='';
							$selected_cp ='';
							$selected_tcc ='';

						}elseif($other_contents['content_type']=='cp'){

							$selected_cp = ' selected = "selected" ';
							$selected_dc ='';
							$selected_tc ='';
							$selected_tcc ='';

						}else{

							$selected_cp = '';
							$selected_dc ='';
							$selected_tc ='';
							$selected_tcc ='';

						}
					?>

					<div class="col-md-6">
						<label for="content_type" class="control-label"><span class="text-danger">*</span>Type</label>
						<div class="form-group">
							<select name="content_type" id="content_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option value="">Select Type</option>
								<option value="tc" <?php echo $selected_tc;?> >Terms & Conditions</option>
								<option value="tcc" <?php echo $selected_tcc;?>>Terms & Conditions (Checkout)</option>
								<option value="dc" <?php echo $selected_dc;?> >Disclaimer</option>
								<option value="cp" <?php echo $selected_cp;?> >Cookie Policy</option>	
							</select>
							<span class="text-danger"><?php echo form_error('content_type');?></span>
						</div>
					</div>
					
					<div class="col-md-12">
						<label for="content_desc" class="control-label">Batch Description</label>
						<div class="form-group has-feedback">
							<textarea name="content_desc" class="form-control myckeditor" id="content_desc"><?php echo ($this->input->post('content_desc') ? $this->input->post('content_desc') : $other_contents['content_desc']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('content_desc');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($other_contents['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>		
			</div>			
			<?php echo form_close(); ?>
		</div>
    </div>
</div>