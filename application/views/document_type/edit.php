<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/document_type/edit/'.$document_type['id']); ?>
			<div class="box-body">
		
					<input type="hidden" name="document_type_id_hidden" id="document_type_id_hidden" value="<?php echo $document_type['id'];?>" >
					<div class="col-md-6">
						<label for="document_type_name" class="control-label"><span class="text-danger">*</span>Document Type</label>
						<div class="form-group">
							<input type="text" name="document_type_name" value="<?php echo ($this->input->post('document_type_name') ? $this->input->post('document_type_name') : $document_type['document_type_name']); ?>" class="form-control input-ui-100" id="document_type_name" onblur="check_document_type_duplicacy(this.value);"/>
							<span class="text-danger document_type_name_err"><?php echo form_error('document_type_name');?></span>
						</div>
					</div>

						

					<div class="col-md-4">
			            <label for="have_expiry_date" class="control-label"><span class="text-danger">*</span>Have expiry date?</label>
			            <div class="form-group">
			              <select name="have_expiry_date" id="have_expiry_date" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
			                <option value="">Select</option>
			                <?php								
								if($document_type['have_expiry_date']=='Y'){
							?>
			                <option value="Y" selected="selected">Yes</option>
                			<option value="N">No</option>
                			<?php }else{ ?>
                				<option value="Y">Yes</option>
                				<option value="N" selected="selected">No</option>
                			<?php } ?>
			              </select>
			              <span class="text-danger"><?php echo form_error('have_expiry_date');?></span>
			            </div>
			         </div>				
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($document_type['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
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