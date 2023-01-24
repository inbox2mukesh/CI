<style type="text/css">
	input[type="checkbox"][readonly] {
  	pointer-events: none;
}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
               <div class="box-tools pull-right">
               	<?php 
                  if($this->Role_model->_has_access_('waiver','index')){
                  ?>
              	<a href="<?php echo site_url('adminController/waiver/index'); ?>" class="btn btn-success btn-sm">ALL Request list</a>
              <?php }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/waiver/add'); ?>
          	<div class="box-body">          		
        

          		<div class="col-md-6">
						<label for="waiver_type" class="control-label"><span class="text-danger">*</span>Waiver Type</label>
						<div class="form-group">
							<select name="waiver_type" id="waiver_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectRefFields(this.value)">
								<?php
									if($this->input->post('waiver_type')=='General'){

										$selectedGen = ' selected= "selected" ';

									}elseif($this->input->post('waiver_type')=='Special'){

										$selectedSpl = ' selected= "selected" ';

									}elseif($this->input->post('waiver_type')=='Pack Adjustment'){
										$selectedAjd = ' selected= "selected" ';
									}else{
										$selectedGen = '';
										$selectedSpl = '';
										$selectedAjd = '';
									}
								?>
								<option value="">Select Type</option>
								<option value="General" <?php echo $selectedGen;?> >General</option>
								<option value="Special" <?php echo $selectedSpl;?> >Special</option>
								<option value="Pack Adjustment" <?php echo $selectedAjd;?> >Pack Adjustment</option>
							</select>
							<span class="text-danger"><?php echo form_error('waiver_type');?></span>
						</div>
					</div>				

					<div class="col-md-6">
						<label for="student_id" class="control-label"><span class="text-danger">*</span>For Student</label>
						<div class="form-group">
							<select name="student_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="displayWaiverHistory(this.value)">
								<option data-subtext="" value="">Select</option>
								<?php 
								foreach($all_student as $p){
									$d = $p['UID'].' | '.$p['fname'].' '.$p['lname'];
									$selected = ($p['id'] == $this->input->post('student_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('student_id');?></span>
						</div>
					</div>

					<div class="col-md-12 msg"></div>					

					<div class="col-md-6">
						<label for="user_id" class="control-label"><span class="text-danger">*</span>Request to Waiver Admin</label>
						<div class="form-group">
							<select name="user_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" id="waiver_amount" >
								<option data-subtext="" value="">Select Waiver Admin</option>
								<?php 
								foreach($all_user as $p)
								{
									$d = $p['employeeCode'].' | '.$p['fname'].' '.$p['lname'].' | '.$p['mobile'].' | Max range: '.$p['waiver_upto'];
									$selected = ($p['id'] == $this->input->post('user_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.' data-id="'.$p['waiver_upto'].'">'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('user_id');?></span>
						</div>
					</div>

					<div class="col-md-6 refBox" style="display: none;">
						<label for="ref_user_id" class="control-label"> Ref. By</label>
						<div class="form-group">
							<select name="ref_user_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select Ref.</option>
								<?php 
								foreach($all_refUser as $p)
								{
									$d = $p['employeeCode'].' | '.$p['fname'].' '.$p['lname'].' | '.$p['employeeCode'];
									$selected = ($p['id'] == $this->input->post('user_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('ref_user_id');?></span>
						</div>
					</div>	

					<div class="col-md-6">
						<label for="amount" class="control-label"><span class="text-danger">*</span>Amount required for waiver</label>
						<div class="form-group has-feedback">
							<input type="text" name="amount" value="<?php echo $this->input->post('amount'); ?>" class="form-control allow_numeric entered_waiver_amt input-ui-100" id="amount" maxlength="5"/>
							<span class="text-danger amount_wa_error"><?php echo form_error('amount');?></span>	
						</div>
					</div>                    					
					
					<div class="col-md-12">
						<div class="form-group">
							<input type="checkbox" name="active" value="1" id="active" checked="checked" readonly/>
							<label class="control-label">Active</label>
						</div>
					</div>	

					<div class="col-md-12">
						<label for="remarks" class="control-label"><span class="text-danger">*</span>Remarks</label>
						<div class="form-group has-feedback">
							<textarea name="remarks" class="form-control" id="remarks" placeholder="Enter remarks"><?php echo $this->input->post('remarks'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('remarks');?></span>
						</div>
					</div>		

				</div>
		
			<input type="hidden" id="user_waiver_amt" value=0 />
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>