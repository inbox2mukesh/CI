<div id="packbox_pp" class="edit-gray-bg" style="display: none;">
                            <div class="col-md-12 edit-rh">
                                <div class="bg-info">
                                    Student payment management for Practice pack!
                                </div>
                            </div>
                            <?php if ($student['wallet'] / 100 > 0) { ?>
                                <div class="col-md-12">
                                    <div class="form-group form-checkbox">
                                        <input type="checkbox" name="use_wallet_pp" value="1" id='use_wallet_pp' />
                                        <label for="use_wallet_pp" class="control-label">Use Wallet Amount?
                                            (<?php echo $student['wallet'] / 100; ?>)</label>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <label for="package_id_pp" class="control-label"><span class="text-danger">*</span>
                                    Pack <span class="text-info">( Format: Pack Name | Offer Price | Org. Price | Pack
                                        Validity )</span> </label>
                                <div class="form-group">
                                    <select name="package_id_pp" id="package_id_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="getPackPrice(this.value);getOnlineOfflinePackInfo();">
                                        <option value="">Select package</option>
                                    </select>
                                    <span class="text-danger package_id_pp_err"><?php echo form_error('package_id_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12 packInfo"></div>
                            <div class="col-md-4">
                                <label for="method_pp" class="control-label"><span class="text-danger">*</span>Payment mode</label>
                                <div class="form-group">
                                    <select name="method_pp" id="method_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-live-search="true">
                                        <?php echo PAYMENT_OPTIONS; ?>
                                    </select>
                                    <span class="text-danger method_pp_err"><?php echo form_error('method_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_type_pp" class="control-label text-success"><span class="text-danger">*</span>Discount type</label>
                                <div class="form-group">
                                    <select name="discount_type_pp" id="discount_type_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="showDiscountTypeFields_pp(this.value)">
                                    <?php if(WOSA_ONLINE_DOMAIN == 1){?> 
                                        <option value="Waiver">Waiver</option>                                       
                                        <?php } ?>
                                        <option value="None">None</option>
                                    </select>
                                    <span class="text-danger discount_type_pp_err"><?php echo form_error('discount_type_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_pp" style="display: none;">
                                <label for="waiver_pp" class="control-label">Waiver amount</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_pp" value="<?php echo $this->input->post('waiver_pp') ? $this->input->post('waiver_pp') : $waiver_amount_given; ?>" class="form-control input-ui-100" id="waiver_pp" readonly />
                                    <span class="text-danger waiver_err"><?php echo form_error('waiver_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_pp" style="display: none;">
                                <label for="waiver_by_pp" class="control-label">Waiver By</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_by_pp" value="<?php echo $this->input->post('waiver_by_pp') ? $this->input->post('waiver_by_pp') : $waiver_from_fname . ' ' . $waiver_from_lname; ?>" class="form-control input-ui-100" id="waiver_by_pp" readonly />
                                </div>
                            </div>
                            <div class="col-md-4 discountField_pp" style="display: none;">
                                <label for="other_discount_pp" class="control-label">Discount</label>
                                <a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#modal-Discount-PromoCode" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Promocode" onclick="getApplicablePromocode(this.id);">Show Promo Code*</a> |
                                <a href="javascript:void(0)" class="text-warning" name="removePromocode_pp" id="removePromocode_pp" title="Remove Promocode" onclick="removePromocode('other_discount_pp');">Remove Promo Code</a>
                                <div class="form-group">
                                    <input type="text" class="form-control input-ui-100" name="other_discount_pp" value="<?php echo ($this->input->post('other_discount_pp') ? $this->input->post('other_discount_pp') : 0); ?>" class="form-control removeerrmessage" id="other_discount_pp" readonly />
                                    <span class="text-danger other_discount_err"><?php echo form_error('other_discount_pp'); ?></span>
                                </div>
                            </div>
                            <!-- onfocusout="getOnlineOfflinePackInfo(this.value);" -->
                            <div class="col-md-4">
                                <label for="amount_paid_pp" class="control-label"><span class="text-danger">*</span>Amount
                                    paid <span class="text-warning"><i>(You may edit amount if any dues)</i></span></label>
                                <div class="form-group">
                                    <input type="text" name="amount_paid_pp" id="amount_paid_pp" value="<?php echo $this->input->post('amount_paid_pp'); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" onblur="validate_amount_paid_pp(this.value);getOnlineOfflinePackInfo(this.value);" onkeyup="calculatepayableamnt('practicepack',this.value);"  maxlength="5" autocomplete="off" />
                                    <span class="text-danger amount_paid_err"><?php echo form_error('amount_paid_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="amount_paid_pp" class="control-label"><span class="text-danger">*</span>Amount
                                    payable(Incl. Taxes)<span class="text-warning"></span></label>
                                <div class="form-group">
                                    <input type="text" name="amount_payable_pp" id="amount_payable_pp" value="<?php echo $this->input->post('amount_payable_pp'); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" maxlength="5" autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="start_date_pp" class="control-label"><span class="text-danger">*</span>Package Starting Date</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="start_date_pp" id="start_date_pp" value="<?php echo ($this->input->post('start_date_pp') ? $this->input->post('start_date_pp') : $tomarrow); ?>" class="datepicker_timezone form-control input-ui-100 removeerrmessage change_startdate" autocomplete="off" readonly="readonly" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger start_date_pp_err"><?php echo form_error('start_date_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="due_commitment_date_pp" class="control-label">Due Commitment Date (If any)</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="due_commitment_date_pp" value="<?php echo ($this->input->post('due_commitment_date_pp') ? $this->input->post('due_commitment_date_pp') : ''); ?>" class="datepicker_timezone form-control input-ui-100" id="due_commitment_date_pp" autocomplete="off" readonly="readonly" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger due_commitment_date_pp_err"><?php echo form_error('due_commitment_date_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tran_id_pp" class="control-label">Transaction ID (If any)</label>
                                <div class="form-group">
                                    <input type="text" name="tran_id_pp" id="tran_id_pp" value="<?php echo ($this->input->post('tran_id_off') ? $this->input->post('tran_id_pp') : ''); ?>" class="form-control input-ui-100" maxlength="16" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_file_pp" class="control-label">Payment Slip
                                    <?php echo PAYMENT_SCREENSHOT_ALLOWED_LABEL; ?></label>
                                <div class="form-group">
                                    <input type="file" name="payment_file_pp" id="image_pp" value="<?php echo $this->input->post('payment_file_pp'); ?>" class="form-control input-file-ui-100 input-file-ui" onchange="validate_file_type_paymentSlip_pp(this.id)" />
                                    <span class="text-danger image_pp_err"><?php echo form_error('payment_file'); ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning add_std_pack rd-20"  onclick="return check_all_validation_pp();">
                                    <?php echo PP_LABEL; ?> <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>