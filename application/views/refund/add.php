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
                  if($this->Role_model->_has_access_('refund','index')){
                  ?>
              	<a href="<?php echo site_url('adminController/refund/index'); ?>" class="btn btn-success btn-sm">ALL Request List</a>
              <?php }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/refund/add'); ?>
          	<div class="box-body">
					<div class="col-md-12">
						<label for="student_id" class="control-label"><span class="text-danger">*</span>For Student</label>
						<div class="form-group">
							<select name="student_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  onchange="displayRefundHistory(this.value)">
								<option data-subtext="" value="">Select</option>
								<?php 
								foreach($all_student as $p)
								{
									$d = $p['UID'].' | '.$p['fname'].' '.$p['lname'];
									$selected = ($p['id'] == $this->input->post('student_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('student_id');?></span>
						</div>
					</div>		

					<div class="col-md-12">

					<div class="msg row"></div>
					</div>			

					<div class="col-md-6">
						<label for="user_id" class="control-label"><span class="text-danger">*</span>Request to refund Admin</label>
						<div class="form-group">
							<select name="user_id" id="user_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select refund Admin</option>
								<?php 
								foreach($all_user as $p)
								{
									$d = $p['employeeCode'].' | '.$p['fname'].' '.$p['lname'].' | '.$p['mobile'];
									$selected = ($p['id'] == $this->input->post('user_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('user_id');?></span>
						</div>
					</div>	

					<div class="col-md-6">
						<label for="ref_user_id" class="control-label"> Ref. By</label>
						<div class="form-group">
							<select name="ref_user_id" id="ref_user_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select Ref.</option>
								<?php 
								foreach($all_refUser as $p)
								{
									$d = $p['employeeCode'].' | '.$p['fname'].' '.$p['lname'].' | '.$p['employeeCode'];
									$selected = ($p['id'] == $this->input->post('ref_user_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$d.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('ref_user_id');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="amount" class="control-label"><span class="text-danger">*</span>Amount required for refund</label>
						<div class="form-group has-feedback">
							<input type="text" name="amount" value="<?php echo $this->input->post('amount'); ?>" class="form-control input-ui-100 allow_numeric " id="amount" maxlength="5" onblur="checkAmount(this.value)"/>
							<span class="text-danger amount_wa_error"><?php echo form_error('amount');?></span>	
						</div>
					</div>                    					
					
					<div class="col-md-6">
						<div class="form-group form-checkbox mt-30">
							<input type="checkbox" name="active" value="1" id="active" checked="checked" readonly/>
							<label class="control-label">Active</label>
						</div>
					</div>	

					<div class="col-md-12">
						<label for="remarks" class="control-label"><span class="text-danger">*</span>Remarks</label>
						<div class="form-group has-feedback">
							<textarea name="remarks" class="form-control" id="remarks" placeholder="Enter remarks"></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('remarks');?></span>
						</div>
					</div>		

			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>