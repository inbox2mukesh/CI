<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/mock_test/edit/'.$mock_test['id']); ?>
			<div class="box-body">
				<div class="row clearfix">

					<div class="col-md-3">
						<label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group has-feedback">
							<input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $mock_test['title']); ?>" class="form-control" id="title" maxlength="100"/>
							<span class="text-danger title_err"><?php echo form_error('title');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Test module</label>
						<div class="form-group">
							<select name="test_module_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select </option>
								<?php 
								foreach($all_test_module as $t)
								{
									$selected = ($t['test_module_id'] == $mock_test['test_module_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select programme</option>
								<?php 
								foreach($all_programe_masters as $p)
								{
									$selected = ($p['programe_id'] == $mock_test['programe_id']) ? ' selected="selected"' : "";

									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="center_id" class="control-label">Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="GetBranchAddress(this.value);">
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b)
								{
									$selected = ($b['center_id'] == $mock_test['center_id']) ? ' selected="selected"' : "";

									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_id');?></span>
						</div>
					</div>
					
					<div class="col-md-4">
						<label for="date" class="control-label"><span class="text-danger">*</span>Date <?php echo DATE_FORMAT_LABEL_RT;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="date" value="<?php echo ($this->input->post('date') ? $this->input->post('date') : $mock_test['date']); ?>" class="form-control has-datepicker" id="date"/>
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('date');?></span>
						</div>
					</div>

					<div class="col-md-2">
						<label for="time_slot1" class="control-label">Time Slot 1 </label>
						<div class="form-group has-feedback">
							<input type="text" name="time_slot1" value="<?php echo ($this->input->post('time_slot1') ? $this->input->post('time_slot1') : $mock_test['time_slot1']); ?>" class="form-control" id="time_slot1" />
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('time_slot1');?></span>
						</div>
					</div>	

					<div class="col-md-2">
						<label for="time_slot2" class="control-label">Time Slot 2 </label>
						<div class="form-group has-feedback">
							<input type="text" name="time_slot2" value="<?php echo ($this->input->post('time_slot2') ? $this->input->post('time_slot2') : $mock_test['time_slot2']); ?>" class="form-control" id="time_slot2" />
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('time_slot2');?></span>
						</div>
					</div>

					<div class="col-md-2">
						<label for="time_slot3" class="control-label">Time Slot 3 </label>
						<div class="form-group has-feedback">
							<input type="text" name="time_slot3" value="<?php echo ($this->input->post('time_slot3') ? $this->input->post('time_slot3') : $mock_test['time_slot3']); ?>" class="form-control" id="time_slot3" />
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('time_slot3');?></span>
						</div>
					</div>

					<div class="col-md-2">
						<label for="seats" class="control-label">Seats </label>
						<div class="form-group has-feedback">
							<input type="number" name="seats" value="<?php echo ($this->input->post('seats') ? $this->input->post('seats') : $mock_test['seats']); ?>" class="form-control" id="seats" maxlength="3"/>							
							<span class="text-danger"><?php echo form_error('seats');?></span>
						</div>
					</div>

					<div class="col-md-12">					
						<label for="seatslbl" class="control-label"><?php echo TIME_FT_FORMAT_LABEL;?> </label>
					</div>

					<div class="col-md-4">
						<label for="amount" class="control-label"><span class="text-danger">*</span>Booking Price</label>
						<div class="form-group has-feedback">
							<input type="text" name="amount" value="<?php echo ($this->input->post('amount') ? $this->input->post('amount') : $mock_test['amount']); ?>" class="form-control" id="amount" onblur="validate_booking_amount(this.value);"/>
							<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
							<span class="text-danger amount_err"><?php echo form_error('amount');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<label for="venue" class="control-label">Venue address</label>
						<div class="form-group has-feedback">
							<textarea name="venue" class="form-control" id="venue"><?php echo ($this->input->post('venue') ? $this->input->post('venue') : $mock_test['venue']); ?></textarea>
							<span class="form-control-feedback"><i class="fa fa-hotel"></i></span>
						</div>
					</div>					

					<div class="col-md-12">
						<div class="form-group">
							<label for="active" class="control-label">Active</label>
							<input type="checkbox" name="active" value="1" <?php echo ($mock_test['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
						</div>
					</div>
					
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-danger add_rt">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>