<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/time_slot_master/edit/'.$time_slot_master['id']); ?>
			<div class="box-body">
			
					<input type="hidden" name="time_slot_id_hidden" id="time_slot_id_hidden" value="<?php echo $time_slot_master['id'];?>" >
					<div class="col-md-6">
						<label for="time_slot" class="control-label"><span class="text-danger">*</span>Time Slot</label>
						<div class="form-group">
							<input type="text" name="time_slot" value="<?php echo ($this->input->post('time_slot') ? $this->input->post('time_slot') : $time_slot_master['time_slot']); ?>" class="form-control input-ui-100" id="time_slot" maxlength="5" minlength="5" />
							<span class="text-danger time_slot_err"><?php echo form_error('time_slot');?></span>
						</div>
					</div>

					<div class="col-md-6">
			            <label for="type" class="control-label"><span class="text-danger">*</span>Type</label>
			            <div class="form-group">
			              <select name="type" id="type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="check_timeslot_duplicacy(this.value);">
			                <option value="">Select Type</option>
			                <?php 
			                if($time_slot_master['type']=='AM'){
			                	$am_selected = 'selected = "selected" ';
			                	$pm_selected = '';
			                }else if($time_slot_master['type']=='PM'){
			                	$pm_selected = 'selected = "selected" ';
			                	$am_selected = '';
			                }else{
			                	$pm_selected = '';
			                	$am_selected = '';
			                }
			                ?>
			                <option value="AM" <?php echo $am_selected;?> >AM</option>
			                <option value="PM" <?php echo $pm_selected;?> >PM</option>                
			              </select>
			              <span class="text-danger type_err"><?php echo form_error('type');?></span>
			            </div>
			        </div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($time_slot_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
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