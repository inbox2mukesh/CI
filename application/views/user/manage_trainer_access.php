<div class="user-manage_trainer_access">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title text-info"><?php echo $title.'-'.$user['fname'].' '.$user['lname'].' [ '.$user['employeeCode'].' ]';?> </h3>
					<div class="box-tools pull-right">
					<?php
					if($this->Role_model->_has_access_('user','employee_list')){
					?>
					<a href="<?php echo site_url('adminController/user/employee_list'); ?>" class="btn btn-warning btn-sm">Employee list</a>  <?php } ?>
				</div>
				</div>
				<?php echo $this->session->flashdata('flsh_msg'); ?>
				<?php echo form_open('adminController/user/manage_trainer_access_/'.base64_encode($user['id'])); ?>
				<div class="box-body">
					<div class="col-md-12">
					<h4 class="box-title text-info">Current Access list</h4>
				
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-sm">
							<?php if(!empty($trainerbatchList)){ ?>
							<thead>
							<tr>
								<th><?php echo SR;?></th>
								<th>Batch</th>
								<th><?php echo ACTION;?></th>
							</tr>
							</thead>
							<?php } ?>
							<tbody id="myTable">
							<?php

								$sr=0;foreach($trainerbatchList as $b){ $zero=0;$one=1;$pk='user_batch_id'; $table='user_batch';$sr++;
							?>
							<tr>
								<td><?php echo $sr; ?></td>
								<td><?php echo $b['batch_name']; ?></td>
								<td>
									<?php
										if($this->Role_model->_has_access_('user','remove_trainer_batch_')){
									?>
									<a href="<?php echo site_url('adminController/user/remove_trainer_batch_/'.$b['user_batch_id'].'/'.base64_encode($b['user_id'])); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove batch"><span class="fa fa-trash"></span> </a> <?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						</table>
						<div class="pull-right"></div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-sm">
							<?php if(!empty($trainer_access_list)){ ?>
							<thead>
							<tr>
								<th><?php echo SR;?></th>
								<th>Course</th>
								<th>Programe</th>
								<th>Category</th>
								<th><?php echo ACTION;?></th>
							</tr>
							</thead>
							<?php } ?>
							<tbody id="myTable">
							<?php
								$sr=0;foreach($trainer_access_list as $p){ $zero=0;$one=1;$pk='user_test_module_id'; $table='trainer_access_list';$sr++;
							?>
							<tr>
								<td><?php echo $sr; ?></td>
								<td><?php echo $p['test_module_name']; ?></td>
								<td><?php echo $p['programe_name']; ?></td>
								<td>
								<?php
								echo $p['Category']['category_name'];
								?>
								</td>
								<td>
									<?php
										if($this->Role_model->_has_access_('user','remove_trainer_access_')){
									?>
									<a href="<?php echo site_url('adminController/user/remove_trainer_access_/'.$p['user_test_module_id'].'/'.base64_encode($p['user_id'])); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove"><span class="fa fa-trash"></span> </a> <?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						</table>

					</div>

				

					<div class="pagination-right"></div>


						<input type="hidden" name="fake" id="fake" value="fake">
					<div class="row">
						<div class="col-md-3">
							<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
							<div class="form-group">
								<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'online_pack');">
									<option value="">Select</option>
									<?php
									foreach($all_test_module as $p){
										$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
										echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger test_module_id_err"><?php echo form_error('test_module_id');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
							<div class="form-group">
								<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
									<option data-subtext="" value="">Select Program</option>
									<?php
									foreach($all_programe_masters as $p){
										$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
										echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger programe_id_err"><?php echo form_error('programe_id');?></span>
							</div>
						</div>

						<div class="col-md-3 catBox">
							<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
							<div class="form-group">
								<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
									<option value="" disabled="disabled">Select Category</option>
								</select>
								<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="batch_id" class="control-label">Batch</label>
							<div class="form-group">
								<select name="batch_id[]" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
									<option value="" disabled="disabled">Select</option>
									<?php
									foreach($all_batches as $p){
										$selected = ($p['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
										echo '<option value="'.$p['batch_id'].'" '.$selected.'>'.$p['batch_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger batch_id_err"><?php echo form_error('batch_id');?></span>
							</div>
						</div>

					
				</div>
				</div>
				</div>
			
				<div class="box-footer">
					<div class="col-md-12">
				
					<button type="submit" class="btn btn-danger sbm rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
					<?php echo SAVE_LABEL;?>
					</button>
								</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>