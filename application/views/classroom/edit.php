<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/classroom/edit/'.$classroom['id']); ?>
			<div class="box-body">
				<div class="">
					<input type="hidden" name="classroom_id_hidden" id="classroom_id_hidden" value="<?php echo $classroom['id'];?>">
					<div class="col-md-4">
						<label for="classroom_name" class="control-label"><span class="text-danger">*</span>Classroom name</label>
						<div class="form-group has-feedback">
							<input type="text" name="classroom_name" value="<?php echo ($this->input->post('classroom_name') ? $this->input->post('classroom_name') : $classroom['classroom_name']); ?>" class="form-control input-ui-100" id="classroom_name" maxlength='8' onblur="validate_classroom_name(this.value)"/>
							<span class="glyphicon glyphicon-book form-control-feedback"></span>
							<span class="text-danger classroom_name_err"><?php echo form_error('classroom_name');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom edit');" disabled="disabled">
								<option value="">Select course</option>
								<?php 
								foreach($all_test_module as $t){
									$selected = ($t['test_module_id'] == $classroom['test_module_id']) ? ' selected="selected"' : "";
									echo '<option data-subtext="'.$t['test_module_name'].'" value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);" disabled="disabled">
								<option value="">Select Program</option>
								<?php 
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $classroom['programe_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<?php 
						$c = count($prev_category);
					?>
					<div class="col-md-4">
						<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" disabled="disabled">
								<option value="" disabled="disabled">Select Category</option>
								<?php 
								foreach($all_category as $p){
									$selected='';
									for ($i=0; $i <$c ; $i++) { 
										if(in_array($p['category_id'],$prev_category[$i])){
											$selected='selected="selected"';
										}
									}
									echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].SEP.$p['programe_name'].SEP.$p['category_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
						</div>
					</div>						

					<div class="col-md-4">
						<label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
						<div class="form-group">
							<select name="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" disabled="disabled">
								<option value="">Select Batch</option>
								<?php 
								foreach($all_batches as $b){
									$selected = ($b['batch_id'] == $classroom['batch_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('batch_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="center_id" class="control-label"><span class="text-danger">*</span>Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" disabled="disabled">
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b){
									$selected = ($b['center_id'] == $classroom['center_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_id');?></span>							
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1" <?php echo ($classroom['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						</div>
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