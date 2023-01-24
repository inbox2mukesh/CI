<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3> 
              	<div class="box-tools pull-right">
              		<?php 
                  if($this->Role_model->_has_access_('classroom','index')){
                  ?>
              	<a href="<?php echo site_url('adminController/classroom/index'); ?>" class="btn btn-success btn-sm">All Classroom List</a> 
              	<?php }?>   
              	</div>         	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/classroom/add'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
          			<input type="hidden" name="classroom_id_hidden" id="classroom_id_hidden" value="0">
          			<div class="col-md-12">
						<label for="classroom_name" class="control-label"><span class="text-danger">*</span>Classroom name</label>
						<div class="form-group has-feedback">
							<input type="text" name="classroom_name" value="<?php echo $this->input->post('classroom_name'); ?>" class="form-control" id="classroom_name" maxlength='8' onblur="validate_classroom_name(this.value)"/>
							<span class="glyphicon glyphicon-book form-control-feedback"></span>
							<span class="text-danger classroom_name_err"><?php echo form_error('classroom_name');?></span>
						</div>
					</div>

          			<div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom add');">
								<option value="">Select course</option>
								<?php 
								foreach($all_test_module as $p){
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id2" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="programe_id" onchange="get_category_forPack(this.value);">
								<option value="">Select Program</option>
								<?php 
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>
					<?php 	
			            $category_id_post=$this->input->post('category_id[]');
			        ?>
					<div class="col-md-4 catBox">
						<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Category</option>
								<?php 
								foreach($all_category as $p){
									$selected='';
									if(in_array($p['category_id'],$category_id_post)){
										$selected='selected="selected"';
									}
									echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].' | '.$p['programe_name'].' | '.$p['category_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
						</div>
					</div>

					<?php 
						$batch_id_post=$this->input->post('batch_id');
					?>
					<div class="col-md-4">
						<label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
						<div class="form-group">
							<select name="batch_id[]" name="batch_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option disabled="disabled" value="">Select Batch</option>
								<?php 
								foreach($all_batches as $b){
									$selected = in_array($b['batch_id'],$batch_id_post) ? ' selected="selected"' : "";								
									echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('batch_id[]');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="center_id" class="control-label"><span class="text-danger">*</span>Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b){
									$selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_id');?></span>
						</div>
					</div>			

					<div class="col-md-6">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>		
							<label for="active" class="control-label">Active</label>					
						</div>
					</div>					
					
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger sbm rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

