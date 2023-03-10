<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
				<div class="box-tools pull-right">
					<?php foreach ($student_package as $sp) { ?>
						<?php 
                        	if($this->Role_model->_has_access_('student','student_full_details_')){
                    	?>
						<a href="<?php echo site_url('adminController/student/student_full_details_/' . base64_encode($sp['student_id'])) ?>" class="btn btn-success btn-sm">See Student Details</a><?php } ?>

						<?php 
                        	if($this->Role_model->_has_access_('student','edit')){
                    	?>
						<a href="<?php echo site_url('adminController/student/edit/' . base64_encode($sp['student_id'])) ?>" class="btn btn-warning btn-sm">Manage Student</a><?php } ?>
					<?php } ?>
				</div>
			</div>

			<?php echo $this->session->flashdata('flsh_msg'); ?>
			<div class="box-body">
				<div class="clearfix">
					<?php
						foreach ($student_package as $sp) { 
							if($sp['holdDateFrom']!='' and $sp['holdDateTo']!=''){
								$holdDateFrom_check = new DateTime($sp['holdDateFrom']);
								$current_date = new DateTime();
								if($holdDateFrom_check > $current_date){
									$holdDateFrom_isFuture=1;
								}else{
									$holdDateFrom_isFuture=0;
								}
							}else{
								$holdDateFrom_isFuture=2;
							}

							$_SESSION['current_start_date']=$sp['subscribed_on'];

							//echo $holdDateFrom_isFuture;
					?>
						<?php echo form_open_multipart('adminController/student/adjust_online_and_inhouse_pack_/' . $sp['student_package_id'], array('onsubmit' => 'return validate_adjustment_forms();')); ?>
						<input type="hidden" name="student_id" id="student_id" value="<?php echo $sp['student_id']; ?>">
						<input type="hidden" name="student_package_id" id="student_package_id" value="<?php echo $sp['student_package_id']; ?>">
						<input type="hidden" value="<?php echo $sp['test_module_id'] ?>" name="student_test_module_id" id="student_test_module_id" />
						<input type="hidden" value="<?php echo $sp['programe_id'] ?>" name="student_programe_id" id="student_programe_id" />
						<?php
							$by_user= $_SESSION['UserId'];
						?>
						<input type="hidden" name="by_user" id="by_user" value="<?php echo $by_user; ?>">
						<?php if ($sp['is_terminated'] == 1) { ?>
							<div class="col-md-12">
								<h3 class="text-danger">Terminated Pack !</h3>
							</div>
						<?php } ?>
						<div class="col-md-6">
							<label for="package_name" class="control-label">Pack Name</label>
							<div class="form-group has-feedback">
								<input type="text" name="package_name" value="<?php echo $sp['package_name']; ?>" class="form-control input-ui-100" id="package_name" disabled />
								<span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
							</div>
						</div>
						<div class="col-md-6">
							<label for="package_name" class="control-label">Pack Price</label>
							<div class="form-group has-feedback">
								<input type="text" name="package_name" value="Org. price: <?php echo $sp['package_cost']; ?>" class="form-control input-ui-100" id="package_name" disabled />
								<span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="test_module_name" class="control-label">Course/Program</label>
							<div class="form-group has-feedback">
								<input type="text" name="test_module_name" value="<?php echo $sp['test_module_name'] . '-' . $sp['programe_name']; ?>" class="form-control input-ui-100" id="test_module_name" disabled />
							</div>

						</div>
						<div class="col-md-3">
							<?php
							$category_name = "";
							foreach ($sp['Package_category']  as $pcat) {
								$category_name .= $pcat['category_name'] . ', ';
							}
							?>
							<label for="batch_id" class="control-label">Category</label>
							<div class="form-group has-feedback">
								<input type="text" name="batch_id" value="<?php echo rtrim($category_name, ', '); ?>" class="form-control input-ui-100" id="batch_id" disabled />
							</div>
						</div>
						<div class="col-md-3">
							<label for="center_id" class="control-label">Branch</label>
							<div class="form-group has-feedback">
								<input type="text" name="center_id" value="<?php echo $sp['center_name']; ?>" class="form-control input-ui-100" id="center_id" disabled />
							</div>
						</div>

						<div class="col-md-3">
							<label for="batch_id" class="control-label">Batch</label>
							<div class="form-group has-feedback">
								<input type="text" name="batch_id" value="<?php echo $sp['batch_name']; ?>" class="form-control input-ui-100" id="batch_id" disabled />
							</div>
						</div>

						<div class="col-md-3">
							<label for="amount" class="control-label text-success">Amount Paid</label>
							<div class="form-group has-feedback">
								<input type="text" name="amount" value="<?php echo $sp['amount_paid']; ?>" class="form-control input-ui-100" id="amount" disabled />
								<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="ext_amount" class="control-label text-success">Ext. Amount Paid</label>
							<div class="form-group has-feedback">
								<input type="text" name="ext_amount" value="<?php echo $sp['ext_amount']; ?>" class="form-control input-ui-100" id="ext_amount" disabled />
								<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="amount_due" class="control-label text-danger">Dues</label>
							<div class="form-group has-feedback">
								<input type="text" name="amount_due" value="<?php echo $sp['amount_due']; ?>" class="form-control input-ui-100" id="amount_due" disabled /><span class="form-control-feedback"><i class="fa fa-usd"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="irr_dues" class="control-label text-danger">Irr. Dues</label>
							<div class="form-group has-feedback">
								<input type="text" name="irr_dues" value="<?php echo $sp['irr_dues']; ?>" class="form-control input-ui-100" id="irr_dues" disabled />
							</div>
						</div>

						<?php
						if ($sp['due_commitment_date'] != '') {
							$dcd = date('d-m-Y', $sp['due_commitment_date']);
							$data_dcd = date('d-m-Y', $sp['due_commitment_date']);	
								
							$nextdat=date('d-m-Y', strtotime($data_dcd. ' + 5 days'));
							$next_dcd_str =strtotime($data_dcd. ' + 5 days');						
						} else {
							$dcd = 'N/A';
						}
						?>
						<div class="col-md-3">
							<label for="due_commitment_date" class="control-label text-danger">Due Commitment Date</label>
							<div class="form-group">
								<input type="text" name="due_commitment_date" value="<?php echo $dcd; ?>" class="form-control input-ui-100" id="due_commitment_date" disabled data-edate="<?php echo $nextdat; ?>" data-sdate="<?php echo $data_dcd; ?>" data-nextdcdstr="<?php echo $next_dcd_str;?>" />
							</div>
						</div>

						<div class="col-md-3">
							<label for="amount_refund" class="control-label text-warning">Wallet Refund</label>
							<div class="form-group has-feedback">
								<input type="text" name="amount_refund" value="<?php echo $sp['amount_refund']; ?>" class="form-control input-ui-100" id="amount_refund" disabled />
								<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
							</div>
						</div>

						<?php if(WOSA_ONLINE_DOMAIN==1){ ?>
						<div class="col-md-3">
							<label for="waiver" class="control-label text-success">Waiver</label>
							<div class="form-group has-feedback">
								<input type="text" name="waiver" value="<?php echo $sp['waiver']; ?>" class="form-control input-ui-100" id="waiver" disabled/>
								<span class="form-control-feedback"><i class="fa fa-gift"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="waiver_by" class="control-label">Waiver By</label>
							<div class="form-group has-feedback">
								<input type="text" name="waiver_by" value="<?php echo $sp['waiver_by']; ?>" class="form-control input-ui-100" id="waiver_by" disabled/>
								<span class="form-control-feedback"><i class="fa fa-user"></i></span>
							</div>
						</div>
						<?php } ?>

						<div class="col-md-3">
							<label for="other_discount text-success" class="control-label">Promo Discount</label>
							<div class="form-group has-feedback">
								<input type="text" name="other_discount" value="<?php echo $sp['other_discount']; ?>" class="form-control input-ui-100" id="other_discount" disabled />
								<span class="form-control-feedback"><i class="fa fa-percent text-success"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="order_id" class="control-label">Payment Id</label>
							<div class="form-group has-feedback">
								<input type="text" name="order_id" value="<?php echo $sp['payment_id']; ?>" class="form-control input-ui-100" id="order_id" disabled />
							</div>
						</div>

						<div class="col-md-3">
							<label for="tran_id" class="control-label">Ext. Tran Id</label>
							<div class="form-group has-feedback">
								<input type="text" name="tran_id" value="<?php echo $sp['tran_id']; ?>" class="form-control input-ui-100" id="tran_id" disabled />
							</div>
						</div>

						<div class="col-md-3">
							<label for="subscribed_on" class="control-label">Pack Starting date</label>
							<div class="form-group has-feedback">
								<input type="text" name="subscribed_on" value="<?php echo $sp['subscribed_on']; ?>" class="form-control input-ui-100" id="subscribed_on" disabled data-date="<?php $date = date_create($sp['subscribed_on']); echo date_format($date, "d-m-Y"); ?>" data-strdate="<?php $date = date_create($sp['subscribed_on']); echo strtotime(date_format($date, "d-m-Y")); ?>" />
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="expired_on1" class="control-label">Expiry date</label>
							<div class="form-group has-feedback">
								<input type="text" name="expired_on1" value="<?php echo $sp['expired_on']; ?>" class="form-control input-ui-100" id="expired_on1" disabled data-date="<?php $datee = date_create($sp['expired_on']); echo date_format($datee, "d-m-Y"); ?>" data-strdate="<?php $dateex = date_create($sp['expired_on']); echo strtotime(date_format($dateex, "d-m-Y")); ?>" />
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="requested_on" class="control-label">Created on</label>
							<div class="form-group has-feedback">
								<input type="text" name="requested_on" value="<?php echo $sp['requested_on']; ?>" class="form-control input-ui-100" id="requested_on" disabled />
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group form-checkbox">
								<input type="checkbox" name="active" value="1" <?php echo ($sp['package_status'] == 1 ? 'checked="checked"' : ''); ?> id='active' disabled />
								<label for="active" class="control-label">Pack status</label>
							</div>
						</div>

						<?php
						if ($sp['pack_type'] == 'online') {
							$filePath = PAYMENT_SCREENSHOT_FILE_PATH_ONLINE;
						} elseif ($sp['pack_type'] == 'offline') {
							$filePath = PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE;
						} else {
							$filePath = '';
						}
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-3">
									<label for="payment_file" class="control-label" style="margin-right:5px;">Payment file</label>
									<div class="form-group">

										<?php
										$ext = pathinfo($sp['payment_file'], PATHINFO_EXTENSION);
										if (isset($sp['payment_file']) and ($ext == 'JPG' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'png' or $ext == 'PNG')) {
										?>
											<a href='<?php echo site_url($filePath . $sp['payment_file']); ?>' target="_blank"><img src='<?php echo site_url($filePath . $sp['payment_file']); ?>' class="img-brdr" /></a>

										<?php } elseif (isset($sp['payment_file']) and ($ext == 'pdf')) { ?>

											<a href='<?php echo site_url($filePath . $sp['payment_file']); ?>' target="_blank"><?php echo OPEN_FILE; ?></a>
										<?php } else { ?>
											<?php echo NO_FILE; ?>
										<?php } ?>
									</div>
								</div>


								<div class="col-md-3">
									<label for="" class="control-label">Pack Hold Application file</label>
									<div class="form-group">

										<?php
										$ext = pathinfo($sp['application_file'], PATHINFO_EXTENSION);
										if (isset($sp['application_file']) and ($ext == 'JPG' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'png' or $ext == 'PNG')) {
										?>
											<a href='<?php echo site_url(PACK_HOLD_FILE_PATH . $sp['application_file']); ?>' target="_blank"><img src='<?php echo site_url(PACK_HOLD_FILE_PATH . $sp['application_file']); ?>' class="img-brdr" /></a>
										<?php } elseif (isset($sp['application_file']) and ($ext == 'pdf')) { ?>
											<a href='<?php echo site_url(PACK_HOLD_FILE_PATH . $sp['application_file']); ?>' target="_blank"><?php echo OPEN_FILE; ?></a>
										<?php } else { ?>
											<?php echo NO_FILE; ?>
										<?php } ?>
									</div>
								</div>

							</div>
						</div>

						<?php if ($sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Full Refund') { ?>

						<?php }  elseif(strtotime(date('d-m-Y')) > strtotime($sp['expired_on']))
						{

						}  elseif ($sp['packCloseReason'] == 'Pack Terminated') { ?>
							<div class="col-md-12">
								<label for="payment_type" class="control-label">Adjusment Type</label>
								<div class="form-group">
									<select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_form(this.value);">
										<option value="">Select Adjusment Type</option>
										<?php if ($sp['amount_paid'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'partial_refund_')) {
											?>
												<option value="Partial Refund">Partial Refund</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'full_refund_')) {
											?>
												<option value="Full Refund">Full Refund</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'reactivate_pack_')) {
											?>
												<option value="Reactivate-Pack">Reactivate Pack</option>
											<?php } ?>
										<?php } ?>
									</select>
									<span class="text-danger"><?php echo form_error('payment_type'); ?></span>
								</div>
							</div>

						<?php } elseif ($sp['packCloseReason'] == 'Pack on hold' or $holdDateFrom_isFuture==1) { ?>
							<div class="col-md-12">
								<label for="payment_type" class="control-label">Adjusment Type</label>
								<div class="form-group">
									<select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_form(this.value);">
										<option value="">Select Adjusment Type</option>
										<?php if ($sp['amount_paid'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'partial_refund_')) {
											?>
												<option value="Partial Refund">Partial Refund</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'full_refund_')) {
											?>
												<option value="Full Refund">Full Refund</option>
											<?php } ?>
										<?php } ?>
										<?php if ($sp['amount_due'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'add_payment_')) {
											?>
												<option value="Add payment">Add Payment</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'updateNewDueCommittmentDate_')) {
											?>
												<option value="Change DCD">Change Due Commitment date</option>
											<?php } ?>
										<?php } ?>
										<!-- <option value="Waiver">Waiver Reimbursement</option>	 -->
										<?php if ($sp['package_status'] == 1) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'updateBatch_')) {
											?>
												<option value="Batch Update">Update Batch</option>
											<?php } ?>
										<?php } ?>
										<?php
										/* if ($this->Role_model->_has_access_('student', 'terminate_pack')) {
										?>
											<option value="Terminate-Pack">Terminate Pack</option>
										<?php } */ ?>
										<?php
										if ($this->Role_model->_has_access_('student', 'unhold_pack_')) {
										?>
											<option value="Unhold-Pack">Unhold pack</option>
										<?php } ?>
									</select>
									<span class="text-danger"><?php echo form_error('payment_type'); ?></span>
								</div>
							</div>

						<?php } elseif ($sp['packCloseReason'] == 'Partial Refund' and $sp['package_status'] == 1) { ?>
							<div class="col-md-12">
								<label for="payment_type" class="control-label">Adjusment Type</label>
								<div class="form-group">
									<select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_form(this.value);validateExtensionDate();">
										<option value="">Select Adjusment Type</option>
										<?php if ($sp['amount_paid'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'partial_refund_')) {
											?>
												<option value="Partial Refund">Partial Refund</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'full_refund_')) {
											?>
												<option value="Full Refund">Full Refund</option>
											<?php } ?>
										<?php } ?>
										<?php if ($sp['amount_due'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'add_payment_')) {
											?>
												<option value="Add payment">Add Payment</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'updateNewDueCommittmentDate_')) {
											?>
												<option value="Change DCD">Change Due Commitment date</option>
											<?php } ?>
										<?php } ?>
										<?php
										if ($this->Role_model->_has_access_('student', 'pack_extension_adjustment_')) {
										?>
											<option value="Adjustment-PE">Adjustment-Pack Extension</option><?php } ?>
										<?php
										if ($this->Role_model->_has_access_('student', 'course_switch_adjustment_')) {
										?>
											<option value="Adjustment-CS">Adjustment-Course Switch</option><?php } ?>
										 <?php
												if ($this->Role_model->_has_access_('student', 'branch_switch_adjustment_') and WOSA_ONLINE_DOMAIN==1) {
												?>
											<option value="Adjustment-BS">Adjustment-Branch Switch</option><?php } ?>
										 	<!-- <option value="Waiver">Waiver Reimbursement</option> -->
										<?php if ($sp['package_status'] == 1) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'do_pack_on_hold_')) {
											?>
												<option value="Pack on Hold">Pack on Hold</option>
											<?php } ?>

											<?php
											if ($this->Role_model->_has_access_('student', 'updateBatch_')) {
											?>
												<option value="Batch Update">Update Batch</option>
											<?php } ?>

										<?php } ?>
										<?php
										/* if ($this->Role_model->_has_access_('student', 'terminate_pack')) {
										?>
											<option value="Terminate-Pack">Terminate Pack</option>
										<?php }  */?>
									</select>
									<span class="text-danger"><?php echo form_error('payment_type'); ?></span>
								</div>
							</div>

						<?php } elseif ($sp['packCloseReason'] == 'Partial Refund' and $sp['package_status'] == 0) { ?>
							<div class="col-md-12">
								<label for="payment_type" class="control-label">Adjusment Type</label>
								<div class="form-group">
									<select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_form(this.value);validateExtensionDate();">
										<option value="">Select Adjusment Type</option>
										<?php
										if ($this->Role_model->_has_access_('student', 'reactivate_pack_against_partial_refund_')) {
										?>
											<option value="Reactivate-Pack-Against-PR">Reactivate pack against partial refund</option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php } else { ?>
							<div class="col-md-12">
								<label for="payment_type" class="control-label">Adjusment Type</label>
								<div class="form-group">
									<select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_form(this.value);validateExtensionDate();">
										<option value="">Select Adjusment Type</option>
										<?php if ($sp['amount_paid'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'partial_refund_')) {
											?>
												<option value="Partial Refund">Partial Refund</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'full_refund_')) {
											?>
												<option value="Full Refund">Full Refund</option>
											<?php } ?>
										<?php } ?>

										<?php if ($sp['amount_due'] > 0) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'add_payment_')) {
											?>
												<option value="Add payment">Add Payment</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'updateNewDueCommittmentDate_')) {
											?>
												<option value="Change DCD">Change Due Commitment date</option>
											<?php } ?>
										<?php } ?>
										<?php
										if ($this->Role_model->_has_access_('student', 'pack_extension_adjustment_')) {
										?>
											<option value="Adjustment-PE">Adjustment-Pack Extension</option><?php } ?>
										<?php
										if ($this->Role_model->_has_access_('student', 'course_switch_adjustment_')) {
										?>
											<option value="Adjustment-CS">Adjustment-Course Switch</option><?php } ?>
										 <?php
												if ($this->Role_model->_has_access_('student', 'branch_switch_adjustment_') and WOSA_ONLINE_DOMAIN==1) {
												?>
												<option value="Adjustment-BS">Adjustment-Branch Switch</option><?php } ?>
										<!-- <option value="Waiver">Waiver Reimbursement</option> -->	 
										<?php if ($sp['package_status'] == 1) { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'do_pack_on_hold_')) {
											?>
												<option value="Pack on Hold">Pack on Hold</option>
											<?php } ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'updateBatch_')) {
											?>
												<option value="Batch Update">Update Batch</option>
											<?php } ?>
										<?php } ?>
										<!-- manage start date -->
										<?php if ($sp['packCloseReason'] == 'Have to be start') { ?>
											<?php
											if ($this->Role_model->_has_access_('student', 'manage_pack_start_date')) {
											?>
												<option value="Manage start date">Manage start date</option>
											<?php } ?>
											
										<?php } ?>
										<!-- manage start date -->


										<?php
										/* if ($this->Role_model->_has_access_('student', 'terminate_pack_')) {
										?>
											<option value="Terminate-Pack">Terminate Pack</option>
										<?php }  */?>
									</select>
									<span class="text-danger"><?php echo form_error('payment_type'); ?></span>
								</div>
							</div>
						<?php } ?>

						<div class="col-md-12">

							<?php
							$walletBalance = $wallet['wallet'] / 100;
							if ($wallet['wallet'] / 100 > 0) {
							?>
								<div class="form-group ap" style="display: none;">
									<input type="checkbox" name="use_wallet" value="1" id='use_wallet' />
									<label for="use_wallet" class="control-label">Use Wallet Amount? (<?php echo $wallet['wallet'] / 100; ?>)</label>
								</div>
							<?php } ?>

							<label for="add_payment" class="control-label text-success ap" style="display: none;"><span class="text-danger">*</span>Add payment</label>
							<label for="add_payment" class="control-label text-success rp" style="display: none;"><span class="text-danger">*</span>Refund payment <span class="text-info"><i>(NOTE: Full refund will do pack De-active and Partial refund will keep it at your choice.)</i></span></label>
							<div class="form-group has-feedback pf" style="display: none;">
								<input type="text" name="add_payment" placeholder="Enter amount" class="form-control chknum1 input-ui-100" id="add_payment" onblur="check_payment(this.value,'<?php echo $walletBalance; ?>');" maxlength="5" />
								<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
								<span class="text-danger ad"><?php echo form_error('add_payment'); ?></span>
							</div>
							<div class="form-group has-feedback pf" style="display: none;">
								<label for="due_commitment_date_next" class="control-label text-success"> Next Due Commitment Date</label>
								<input type="text" name="due_commitment_date_next" class="DateVariryBetweendueplusfive_days_holdenddate form-control input-ui-100" id="due_commitment_date_next" maxlength="10" autocomplete="off" onchange="enableBtn_packPayment_due_commitment(this.value);" data-date-format="dd-mm-yyyy" readonly="readonly" />
								<span class="glyphicon form-control-feedback"><i class="fa fa-calendar"></i></span>
								<span class="text-danger dcdn"><?php echo form_error('due_commitment_date_next'); ?></span>
							</div>
						</div>

						<div class="col-md-12 pf" style="display: none;">
							<label for="remarks" class="control-label"> Remarks</label>
							<div class="form-group has-feedback">
								<textarea name="remarks" class="form-control" placeholder="Add transactional remark if any" id="remarks"><?php echo $this->input->post('remarks'); ?></textarea>
								<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							</div>
						</div>

					<?php } ?>

					<!-- pack extension form -->
					<div class="col-md-12 pack_extension_form" style="display: none;">

						<?php
						$walletBalance = $wallet['wallet'] / 100;
						if ($wallet['wallet'] / 100 > 0) {
						?>
							<div class="form-group pack_extension_form" style="display: none;">
								<input type="checkbox" name="use_wallet_pe" value="1" id='use_wallet_pe' />
								<label for="use_wallet_pe" class="control-label">Use Wallet Amount? (<?php echo $wallet['wallet'] / 100; ?>)</label>
							</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label for="add_payment_pe" class="control-label text-success"><span class="text-danger">*</span>Pack Extension Charge</label>
									<input type="text" name="add_payment_pe" placeholder="Enter Extension charge" class="form-control chknum1 input-ui-100" id="add_payment_pe" maxlength="5" />
									<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
									<span class="add_payment_pe_err text-danger"></span>
								</div>
							</div>
							<?php
							$newDate = date("d-m-Y", strtotime($sp['expired_on2']));
							$newDate = date('d-m-Y', strtotime($newDate . ' +1 day'));
							$_SESSION['packExpiry'] = $newDate;
							?>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label for="expired_on" class="control-label text-success"><span class="text-danger">*</span>Pack Extension till Date (Current expiry date is: <?php echo date("d-m-Y", strtotime($sp['expired_on2'])); ?>)</label>
									<input type="text" name="expired_on" class="pe_date form-control input-ui-100" id="expired_on" maxlength="10" autocomplete="off" readonly="readonly" />
									<span class="glyphicon form-control-feedback">
										<i class="fa fa-calendar"></i></span>
									<span class="expired_on_err text-danger"></span>
								</div>
							</div>
						</div>
					</div>
					<!-- pack extension form closed-->

					<!-- Branch switch form -->
					<div class="col-md-12 branch_switch_form" style="display: none;">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="center_id" class="control-label text-success"><span class="text-danger">*</span>Update Branch</label>
									<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="enableBtn_packPayment();">
										<option value="">Select Branch</option>
										<?php
										foreach ($all_branch as $b) {
											$disabled = ($b['center_id'] == $sp['center_id']) ? ' disabled="disabled"' : "";
											echo '<option value="' . $b['center_id'] . '" ' . $disabled . '>' . $b['center_name'] . '</option>';
										}
										?>
									</select>
									<span class="text-danger"><?php echo form_error('center_id'); ?></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label for="add_payment_bs" class="control-label text-success"><span class="text-danger">*</span>Branch Switch Cutting Charge</label>
									<input type="text" name="add_payment_bs" placeholder="Enter Cutting amount" class="form-control chknum1 input-ui-100" id="add_payment_bs" maxlength="5" onblur="enableBtn_packPayment();" onfocus="diableBtn_packPayment();" />
									<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
								</div>
							</div>
						</div>
					</div>
					<!-- Branch switch form closed-->

					<!-- Course switch form -->
					<div class="col-md-12 course_switch_form" style="display: none;">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="test_module_id" class="control-label text-success"><span class="text-danger">*</span>Course</label>
									<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'adjustmentPage');">
										<option value="">Select Course</option>
										<?php
										foreach ($all_test_module as $t) {
											$disabled = (($t['test_module_id'] == $sp['test_module_id'] and $t['test_module_id'] == PTE_ID)) ? ' disabled="disabled"' : "";
											echo '<option value="' . $t['test_module_id'] . '" ' . $disabled . ' >' . $t['test_module_name'] . '</option>';
										}
										?>
									</select>
									<span class="text-danger test_module_id_err"><?php echo form_error('test_module_id'); ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="programe_id" class="control-label text-success"><span class="text-danger">*</span>Program</label>
									<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
										<option value="">Select Program</option>
										<?php
										foreach ($all_programe_masters as $pm){
											$disabled = ($pm['programe_id'] == $sp['programe_id']) ? ' disabled="disabled"' : "";
											echo '<option value="' . $pm['programe_id'] . '" ' . $disabled . '>' . $pm['programe_name'] . '</option>';
										}
										?>
									</select>
									<span class="text-danger programe_id_err"><?php echo form_error('programe_id'); ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group has-feedback">
									<label for="add_payment_cs" class="control-label text-success"><span class="text-danger">*</span>Course Switch Cutting Charge</label>
									<input type="text" name="add_payment_cs" placeholder="Enter Cutting amount" class="form-control chknum1 input-ui-100" id="add_payment_cs" maxlength="5"/>
									<span class="form-control-feedback"><i class="fa fa-usd"></i></span>
									<span class="text-danger add_payment_cs_err"></span>
								</div>
							</div>

						</div>
					</div>
					<!-- Course switch form closed-->

					<!-- manage start date form -->
					<div class="col-md-12 manage_start_date_form" style="display:none;" >

						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label for="add_payment_pe" class="control-label text-success">Current Start Date</label>
									<input type="text" value="<?php echo $_SESSION['current_start_date'];?>" name="current_start_date" class="form-control input-ui-100" id="current_start_date" readonly />									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label for="new_start_date" class="control-label text-success"><span class="text-danger">*</span>New Start Date</label>
									<input type="text" name="new_start_date" class="noBackDate form-control input-ui-100" id="new_start_date" maxlength="10" autocomplete="off" readonly="readonly" />
									<span class="glyphicon form-control-feedback">
										<i class="fa fa-calendar"></i></span>
									<span class="new_start_date_err text-danger"></span>
								</div>
							</div>
						</div>
					</div>
					<!-- manage start date form closed-->

				</div>

				<!--waiver table-->
				<div class="col-md-12 mns-mt-10"><span class='text-danger waiver_msg_failed'></span></div>

				<div class="col-md-12 table-responsive wv_table" style="display: none;">

					<table class="table table-striped table-bordered table-sm">
						<thead>
							<tr>
								<th>ID</th>
								<th>Amount</th>
								<th>Remarks by Requester</th>
								<th>Approver</th>
								<th><?php echo ACTION; ?></th>
							</tr>
						</thead>
						<tbody id="myTable">
							<tr>
								<td id="wid"></td>
								<td id="wamount"></td>
								<td id="wremarks"></td>
								<td id="wapprover"></td>
								<td>
									<a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="tooltip" title="Use Waiver" onclick="remburse_waiver();" id="waiver_btn"><span class="fa fa-plus"></span> </a>
								</td>
							</tr>
						</tbody>
					</table>

				</div>

				<!-- refund -->
				<div class="col-md-12 mns-mt-10 form-group"><span class='text-red font-12 refund_msg_failed'></span></div>

				<div class="col-md-12 mns-mt-10 table-responsive rf_table" style="display: none;">

					<table class="table table-striped table-bordered table-sm">
						<thead>
							<tr>
								<th>ID</th>
								<th>Amount</th>
								<th>Remarks by Requester</th>
								<th>Approver</th>
								<th>Type</th>
								<th><?php echo ACTION; ?></th>
							</tr>
						</thead>
						<tbody id="myTable">
							<tr>
								<td id="r-wid"></td>
								<td id="r-amount"></td>
								<td id="r-remarks"></td>
								<td id="r-approver"></td>
								<td id="r-type"></td>
								<td>
									<?php
									if ($sp['center_name'] == 'Online') {
										$pack_cb = 'online';
									} else {
										$pack_cb = 'offline';
									}
									?>
									<a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="tooltip" title="Use Refund" onclick="remburse_refund('<?php echo $pack_cb; ?>');" id="refund_btn"><span class="fa fa-plus"></span> </a>
									<?php if ($sp['is_terminated'] == 0) {  ?>
										<span class="packCbDiv" style="display: none;">
											<label for="packStatusOnRefund" class="control-label text-success"> | Pack Status</label>
											<input type="checkbox" name="packStatusOnRefund" id="packStatusOnRefund" <?php echo ($sp['package_status'] == 1 ? 'checked="checked"' : ''); ?> value="1">
										</span>
									<?php } ?>

								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- refund form closed -->

				<!-- pack on hold form -->
				<div class="col-md-12 pack_onhold_form" style="display: none;">
					<div class="row">

						<div class="col-md-4">
							<div class="form-group has-feedback">
								<label for="holdDateFrom" class="control-label text-success"><span class="text-danger">*</span>Pack Hold Date From</label>
								<input type="text" name="holdDateFrom" class="DateVariryBetweenStartEnd form-control input-ui-100" id="holdDateFrom" maxlength="10" autocomplete="off" readonly="readonly" />
								<span class="text-danger holdDateFrom_err"></span>
								<span class="glyphicon form-control-feedback">
									<i class="fa fa-calendar"></i></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group has-feedback">
								<label for="holdDateTo" class="control-label text-success"><span class="text-danger">*</span>Pack Hold Date Upto</label>
								<input type="text" name="holdDateTo" class="DateVariryBetweenStartEnd_holdenddate form-control input-ui-100" id="holdDateTo" maxlength="10" autocomplete="off" readonly="readonly" />
								<span class="text-danger holdDateTo_err"></span>
								<span class="glyphicon form-control-feedback">
									<i class="fa fa-calendar"></i></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="application_file" class="control-label text-success"><span class="text-danger">*</span>Attach Application file <?php echo PACK_HOLD_ALLOWED_TYPES_LABEL; ?></label>
								<input type="file" name="application_file" value="<?php echo $this->input->post('application_file'); ?>" class="form-control input-ui-100" id="application_file" onchange="validate_file_type_packHold(this.id)" />
								<span class="text-danger application_file_err"><?php echo form_error('application_file'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!-- pack on hold form closed-->

				<!-- Batch update form -->
				<div class="col-md-12 batch_update_form" style="display: none;">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="batch_id_adj" class="control-label text-success"><span class="text-danger">*</span>Update Batch</label>
								<select name="batch_id_adj" id="batch_id_adj" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									<option value="">Select Batch</option>
									<?php
									foreach ($all_batches as $b) {
										$disabled = ($b['batch_name'] == $sp['batch_name']) ? ' disabled="disabled"' : "";
										echo '<option value="' . $b['batch_id'] . '" ' . $disabled . '>' . $b['batch_name'] . '</option>';
									}
									?>
								</select>
								<span class="text-danger batch_id_adj_err"><?php echo form_error('batch_id_adj'); ?></span>
							</div>
						</div>
					</div>

				</div>
				<!-- Batch update form closed-->

				<!-- Terminate pack form -->
				<div class="col-md-12 terminate_pack_form" style="display: none;">

					<div class="form-group has-feedback">
						<label for="termination_reason" class="control-label text-success"><span class="text-danger">*</span>Termination reason/remarks</label>
						<textarea name="termination_reason" class="t-area form-control" placeholder="Add termination reason" id="termination_reason" onkeyup="getWordCount_tr(this.value);" onkeypress="getWordCount_tr(this.value);" onblur="getWordCount_tr(this.value);"><?php echo $this->input->post('termination_reason'); ?></textarea>
						<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						<span class="text-danger termination_reason_err"><?php echo form_error('termination_reason'); ?></span>
					</div>

				</div>
				<!-- Terminate pack form closed-->

				<!-- due committment date change form start -->
				<div class="col-md-12 due_commitment_form" style="display: none;">
					<div class="form-group has-feedback">
						<label for="new_due_committment_date" class="control-label text-success"><span class="text-danger">*</span>New due Commitment date</label>
						<input type="text" name="new_due_committment_date" value="<?php echo ($this->input->post('new_due_committment_date') ? $this->input->post('new_due_committment_date') : ''); ?>" class="DateVariryBetweendueplusfive_days_holdenddate form-control 
							input-ui-100 removeerrmessage" id="new_due_committment_date" autocomplete="off" data-date-format="dd-mm-yyyy" readonly="readonly" />
						<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						<span class="text-danger new_due_committment_date_err"><?php echo form_error('new_due_committment_date'); ?></span>
					</div>
				</div>
				<!-- due committment date change form start closed-->

				<div class="col-md-12">
					<?php if ($sp['package_status'] == 1 or $sp['package_status'] == 0) {  ?>
						<button type="submit" class="btn btn-danger uspp rd-20"><i class="fa fa-check"></i> <?php echo UPDATE_LABEL; ?>
						</button>
					<?php } ?>

					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php ob_start(); ?>
	<script>
		var minDate = $('#subscribed_on').data('date');
		var currentDate = '<?php echo strtotime(date("d-m-Y"))?>';
		var str_minDate = $('#subscribed_on').data('strdate');
		//DateVariryBetweendueplusfive_days_holdenddate
		var duecomm_startDate = $('#due_commitment_date').data('sdate');
		var duecomm_endtDate = $('#due_commitment_date').data('edate');			
		var duecomm_nextdcdstr = $('#due_commitment_date').data('nextdcdstr');			
		if(currentDate >str_minDate )
		{
			minDate=new Date();
		}
		var enddate = $('#expired_on1').data('date');
		var enddate_strdate = $('#expired_on1').data('strdate');
      if(duecomm_nextdcdstr>enddate_strdate)
	  {
		duecomm_endtDate=enddate;
	  }
	  else {
		duecomm_endtDate=duecomm_endtDate;
	  }
		$(".DateVariryBetweendueplusfive_days_holdenddate").datepicker({
			startDate: duecomm_startDate,
			endDate: duecomm_endtDate,
			autoclose: true,
		});

		$(".DateVariryBetweenStartEnd,.DateVariryBetweenStartEnd_holdenddate").datepicker({
			startDate: minDate,
			endDate: enddate,
			autoclose: true,
		});

		$("#holdDateFrom").change(function() {
			$(".DateVariryBetweenStartEnd_holdenddate").datepicker("destroy");
			$(".DateVariryBetweenStartEnd_holdenddate").datepicker({
				startDate: this.value,
				endDate: enddate,
				autoclose: true,
			});
		});

		function validateExtensionDate() {
			var minDate = '<?php echo $_SESSION["packExpiry"]; ?>'
			$(".pe_date").datepicker({
				startDate: minDate,
				autoclose: true,
			});
		}
	</script>
	<?php global $customJs;
	$customJs = ob_get_clean();
	?>