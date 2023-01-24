<div id="packbox_online" style="display: none;">

	<div class="col-md-12">
		<div class="form-group bg-primary">
			<div class="alert alert-primary" role="alert">
  				Online class pack booking!
			</div>
		</div>
	</div>

	<?php if($student['wallet']/100>0){ ?>
		<div class="col-md-12">
			<div class="form-group">
				<input type="checkbox" name="use_wallet_on" value="1" id='use_wallet_on' />
				<label for="use_wallet_on" class="control-label">Use Wallet Amount? (<?php echo $student['wallet']/100; ?>)</label>
			</div>
		</div>
	<?php } ?>

	<div class="col-md-12">
		<label for="package_id" class="control-label"><span class="text-danger">*</span>Online Class Package <span class="text-info">(Format: Pack Name | Price | Pack Validity)</span> </label>
		<div class="form-group">
			<select name="package_id" id="package_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPackPrice(this.value);getOnlineOfflinePackInfo(this.value);getPackBatch(this.value)">
				<option value="">Select pack</option>
			</select>
			<span class="text-danger package_id_err"><?php echo form_error('package_id');?></span>
		</div>
	</div>

	<div class="col-md-12 packInfo"></div>

	<div class="col-md-6">
		<label for="method" class="control-label"><span class="text-danger">*</span>Payment mode</label>
		<div class="form-group">
			<select name="method" id="method" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
				<?php echo PAYMENT_OPTIONS;?>
			</select>
			<span class="text-danger method_err"><?php echo form_error('method');?></span>
		</div>
	</div>



					<div class="col-md-6">
						<label for="discount_type" class="control-label text-success"><span class="text-danger">*</span>Discount type</label>
							<div class="form-group">
								<select name="discount_type" id="discount_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="showDiscountTypeFields_online(this.value)" >
									<option value="">Select type</option>
									<option value="Waiver">Waiver</option>
									<option value="Discount">Promocode</option>
									<option value="None">None</option>
								</select>
								<span class="text-danger discount_type_err"><?php echo form_error('discount_type');?></span>
							</div>
					</div>



					<div class="col-md-6 waiverField_online" style="display: none;">

						<label for="waiver" class="control-label">Waiver amount</label>

						<div class="form-group">

							<input type="text" name="waiver" value="<?php echo $this->input->post('waiver') ? $this->input->post('waiver') : $waiver_amount_given; ?>" class="form-control" id="waiver" readonly/>

							<span class="text-danger waiver_err"><?php echo form_error('waiver');?></span>

						</div>

					</div>



					<div class="col-md-6 waiverField_online" style="display: none;">

						<label for="waiver_by" class="control-label">Waiver By</label>

						<div class="form-group">

							<input type="text" name="waiver_by" value="<?php echo $this->input->post('waiver_by') ? $this->input->post('waiver_by') : $waiver_from_fname.' '.$waiver_from_lname; ?>" class="form-control" id="waiver_by" readonly/>

							<span class="text-danger waiver_by_err"><?php echo form_error('waiver_by');?></span>

						</div>

					</div>



					<div class="col-md-12 discountField_online" style="display: none;">

						<label for="other_discount" class="control-label">Discount</label>
						<a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#modal-Discount-PromoCode" name="<?php echo $student['id'];?>" id="<?php echo $student['id'];?>" title="Promocode" onclick="getApplicablePromocode(this.id);">Show Promo Code</a> |
						<a href="javascript:void(0)" class="text-warning" name="removePromocode" id="removePromocode" title="Remove Promocode" onclick="removePromocode('other_discount');">Remove Promo Code</a>
						<div class="form-group">

							<input type="text" name="other_discount" value="<?php echo ($this->input->post('other_discount') ? $this->input->post('other_discount') : 0); ?>" class="form-control" id="other_discount" readonly/>

							<span class="text-danger other_discount_err"><?php echo form_error('other_discount');?></span>

						</div>

					</div>



					<div class="col-md-4">

						<label for="amount_paid" class="control-label"><span class="text-danger">*</span>Amount paid <span class="text-warning"><i>(You may edit amount if any dues)</i></span></label>

						<div class="form-group">

							<input type="text" name="amount_paid" id="amount_paid" value="<?php echo $this->input->post('amount_paid'); ?>" class="form-control chknum1" onblur="validate_amount_paid(this.value);" maxlength="5" autocomplete="off"/>

							<span class="text-danger amount_paid_err"><?php echo form_error('amount_paid');?></span>

						</div>

					</div>



					<div class="col-md-4">

						<label for="start_date" class="control-label"><span class="text-danger">*</span>Pack Starting Date</label>

						<div class="form-group has-feedback">

							<input type="text" name="start_date" value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $tomarrow); ?>" class="noBackDate form-control" id="start_date" autocomplete="off" readonly="readonly"/>

							<span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>

							<span class="text-danger start_date_err"><?php echo form_error('start_date');?></span>

						</div>

					</div>



					<div class="col-md-4">

						<label for="tran_id" class="control-label">Transaction ID (If any)</label>

						<div class="form-group">

							<input type="text" name="tran_id" id="tran_id" value="<?php echo ($this->input->post('tran_id') ? $this->input->post('tran_id') : ''); ?>" class="form-control" maxlength="16" autocomplete="off"/>

						</div>

					</div>



					<div class="col-md-4">
						<label for="payment_file" class="control-label">Payment Slip <?php echo PAYMENT_SCREENSHOT_ALLOWED_LABEL;?></label>
						<div class="form-group">
							<input type="file" name="payment_file" id="payment_file" value="<?php echo $this->input->post('payment_file'); ?>" class="form-control" />
						</div>
					</div>

					<div class="col-md-4">
						<label for="due_commitment_date" class="control-label">Due Commitment Date (If any)</label>
						<div class="form-group has-feedback">
							<input type="text" name="due_commitment_date" value="<?php echo ($this->input->post('due_commitment_date') ? $this->input->post('due_commitment_date') : ''); ?>" class="noBackDate form-control" id="due_commitment_date" autocomplete="off" readonly="readonly"/>
							<span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
							<span class="text-danger due_commitment_date_err"><?php echo form_error('due_commitment_date');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
						<div class="form-group packBatch">
							<select name="batch_id" id="batch_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Batch</option>
							</select>
							<span class="text-danger batch_id_err"><?php echo form_error('batch_id');?></span>
						</div>
					</div>

					<div class="box-footer col-md-12">
		            	<button type="submit" class="btn btn-primary add_std_pack" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
							<?php echo ONLINE_LABEL;?> <i class="fa fa-arrow-right"></i>
						</button>
			        </div>
				</div>