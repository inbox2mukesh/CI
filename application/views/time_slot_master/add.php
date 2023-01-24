<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                  <?php 
                    if($this->Role_model->_has_access_('time_slot_master','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/time_slot_master/index'); ?>" class="btn btn-danger btn-sm">Time slot List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/time_slot_master/add'); ?>
          	<div class="box-body">
         
          <input type="hidden" name="time_slot_id_hidden" id="time_slot_id_hidden" value="0" >
          <div class="col-md-6">
            <label for="time_slot" class="control-label"><span class="text-danger">*</span>Time Slot</label>
            <div class="form-group">
              <input type="text" name="time_slot" placeholder="e.g. 09:30" value="<?php echo $this->input->post('time_slot'); ?>" class="form-control input-ui-100" id="time_slot" maxlength="5" minlength="5" />
              <span class="text-danger time_slot_err"><?php echo form_error('time_slot');?></span>
            </div>
          </div>

          <div class="col-md-6">
            <label for="type" class="control-label"><span class="text-danger">*</span>Type</label>
            <div class="form-group">
              <select name="type" id="type" class="form-control selectpicker selectpicker-ui-100" onchange="check_timeslot_duplicacy(this.value);">
                <?php
                  if($this->input->post('type')=='AM'){
                    $amSelected = ' selected = "selected" ';
                    $pmSelected = '';
                  }elseif($this->input->post('type')=='PM'){
                    $pmSelected = ' selected = "selected" ';
                    $amSelected ='';
                  }else{
                    $amSelected ='';$pmSelected = '';
                  }
                ?>
                <option value="">Select Type</option>
                <option value="AM" <?php echo $amSelected;?> >AM</option>
                <option value="PM" <?php echo $pmSelected;?> >PM</option>                
              </select>
              <span class="text-danger type_err"><?php echo form_error('type');?></span>
            </div>
          </div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
					
			
			</div>
          	<div class="box-footer">
            <div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20">
                <i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
              </button>
          	</div>
            </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>