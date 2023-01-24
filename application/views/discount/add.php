<style type="text/css">
input[type="checkbox"][readonly] {
    pointer-events: none;
}
.currBack {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    display: block;
    width: 50px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
    background-color: #e0dede;
    display: none;
}
.currFront {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    display: block;
    width: 70px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
    background-color: #e0dede;
}
.currFrontP {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    display: block;
    width: 104px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
    background-color: #e0dede;
}
.currFrontE {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    display: block;
    width: 70px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
    background-color: #e0dede;
}
.currFrontG {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    display: block;
    width: 120px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
    background-color: #e0dede;
}
</style>
<style>
.error {
    color: #a94442;
    font-weight: normal;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo site_url('adminController/discount/index'); ?>"
                        class="btn btn-success btn-sm">ALL Discount list</a>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/discount/add', array('id' => 'frmDiscount')); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <input type="hidden" name="discount_id" id="discount_id" value="" />
                    <input type="hidden" name="countryCurrency" id="countryCurrency" />
					<div class="col-md-4">
                        <label for="country_type" class="control-label"><span class="text-danger">*</span>Country Type</label>
                        <div class="form-group">
                            <select name="country_type" id="country_type" class="form-control selectpicker selectpicker-ui-100"
                                data-live-search="true">
                                <option value="">Select country type</option>
                                <?php if(COUNTRY_TYPE) { ?>
                                    <?php foreach(COUNTRY_TYPE as $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="text-danger country_type_err"><?php echo form_error('country_type');?></span>
                        </div>
                    </div>

					<div class="col-md-4">
                        <label for="country_id" class="control-label"><span class="text-danger">*</span>Applied to
                            Country</label>
                        <div class="form-group">
                            <select id="country_id" name="country_id[]" class="form-control inDis selectpicker ccode selectCountry selectpicker-ui-100" data-show-subtext="true"
							data-live-search="true" data-actions-box="true" multiple="multiple">
                                <option data-subtext="" value="" disabled>Select country</option>
                                <?php 
								foreach($all_country_currency_code as $p) {	
									$selected = ($p['country_id'] == $this->input->post('country_id')) ? ' selected="selected"' : "";
										echo '<option  value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								}
								?>
                            </select>
                            <span class="text-danger country_id_err"><?php echo form_error('country_id');?></span>
                        </div>
                    </div>
					
					<div class="col-md-4 singleCountryTypeRelated" style="display:none;">
                        <label for="country_currency" class="control-label"><span class="text-danger">*</span>Country Currency</label>
                        <div class="form-group">
                            <select name="country_currency" id="country_currency" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                <option data-subtext="" value="">Select Currency</option>
                                <option value="default-currency">Default Currency</option>
								<option value="<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>"><?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?></option>
                            </select>
                            <span class="text-danger country_currency_err"><?php echo form_error('country_currency');?></span>
                        </div>
                    </div>
                    
                    <div class="shide">
                        <div class="col-md-4">
                            <label for="start_date" class="control-label"><span class="text-danger">*</span>Start Date | Time</label>
                            <div class="form-group">
                                <div class="col-md-6" style="padding-left:0px;">
                                    <input type="text" name="start_date"
                                        value="<?php echo $this->input->post('start_date'); ?>" readonly="readonly"
                                        class="inDis dpick form-control input-ui-100" autocomplete="off" id="start_date"
                                        maxlength="10" />
                                    <span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i
                                            class="fa fa-birthday-cake"></i></span>
                                    <span
                                        class="text-danger start_date_err"><?php echo form_error('start_date');?></span>
                                </div>
                                <?php
									$begin = new DateTime("00:00");
									$end   = new DateTime("23:00");
									$interval = DateInterval::createFromDateString('1 hour');
									$times    = new DatePeriod($begin, $interval, $end);
						 		 ?>
                                <div class="col-md-6">
                                    <select name="start_time" id="start_time" class="form-control inDis selectpicker selectpicker-ui-100"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="">Time</option>
                                        <?php 
								/*foreach ($times as $time) {
										$timepick=$time->add($interval)->format('H:i');
         ;
									$selected = ($timepick == $this->input->post('start_time')) ? ' selected="selected"' : "";
									echo '<option value="'.$timepick.'" '.$selected.'>'.$timepick.'</option>';
								} */
								?>
                                        <?php 
								foreach($all_time_slots as $b)
								{
									$selected = ($b['time_slot'] == $this->input->post('start_time')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].' '.$b['type'].'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								} 
								?>
                                    </select>
                                    <span
                                        class="text-danger start_time_err"><?php echo form_error('start_time');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="control-label"><span class="text-danger">*</span>End Date | Time</label>
                            <div class="form-group">
                                <div class="col-md-6" style="padding-left:0px;">
                                    <input type="text" name="end_date"
                                        value="<?php echo $this->input->post('start_date'); ?>" readonly="readonly"
                                        class="inDis form-control input-ui-100" autocomplete="off" id="end_date"
                                        maxlength="10" />
                                    <span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i
                                            class="fa fa-birthday-cake"></i></span>
                                    <span class="text-danger end_date_err"><?php echo form_error('end_time');?></span>
                                </div>
                                <div class="col-md-6">
                                    <select name="end_time" id="end_time" class="form-control inDis selectpicker selectpicker-ui-100"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="">Time</option>
                                        <?php 
								foreach($all_time_slots as $b)
								{
									$selected = ($b['time_slot'] == $this->input->post('end_time')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].' '.$b['type'].'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								} 
								?>
                                    </select>
                                    <span class="text-danger end_time_err"><?php echo form_error('end_time');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix shide">
                    <div class="col-md-4">
                        <label for="amount" class="control-label"><span class="text-danger">*</span>Name</label>
                        <div class="form-group has-feedback">
                            <input type="text" name="disc_name" value="<?php echo $this->input->post('disc_name'); ?>"
                                class="form-control inDis input-ui-100" id="disc_name" maxlength="25" />
                            <span class="text-danger disc_name_err"><?php echo form_error('disc_name');?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="waiver_type" class="control-label"><span class="text-danger">*</span>Type of Discount Code</label>
                        <div class="form-group">
                            <select name="type_of_discount" id="type_of_discount"
                                class="form-control inDis selectpicker selectpicker-ui-100" data-show-subtext="true"
                                data-live-search="true">
                                <option value="">Select Type</option>
                                <option value="General"
                                    <?php echo ("General" == $this->input->post('type_of_discount')) ? ' selected="selected"' : ""; ?>>
                                    General</option>
                                <option value="Special"
                                    <?php echo ("Special" == $this->input->post('type_of_discount')) ? ' selected="selected"' : ""; ?>>
                                    Special</option>
                                <option value="Bulk"
                                    <?php echo ("Bulk" == $this->input->post('type_of_discount')) ? ' selected="selected"' : ""; ?>>
                                    Bulk</option>
                                <!-- <option value="Template">Template</option>-->
                            </select>
                            <span
                                class="text-danger type_of_discount_err"><?php echo form_error('type_of_discount');?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="discount_type" class="control-label"><span class="text-danger">*</span>Discount Type</label>
                        <div class="form-group">
                            <select name="discount_type" id="discount_type" class="form-control inDis selectpicker selectpicker-ui-100"
                                data-show-subtext="true" data-live-search="true">
                                <option value="">Select Type</option>
                                <option value="Percentage"
                                    <?php echo ("Percentage" == $this->input->post('discount_type')) ? ' selected="selected"' : ""; ?>>
                                    Percentage</option>
                                <option value="Amount"
                                    <?php echo ("Amount" == $this->input->post('discount_type')) ? ' selected="selected"' : ""; ?>>
                                    Amount</option>
                            </select>
                            <span class="text-danger discount_type_err"><?php echo form_error('discount_type');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix shide">
                    <div class="col-md-4">
                        <label for="amount" class="control-label"><span class="text-danger">*</span>Max Discount</label>
                        <div class="form-group has-feedback">
                            <input type="text" name="max_discount"
                                value="<?php echo $this->input->post('max_discount'); ?>"
                                class="form-control inDis chknum1 input-ui-100" id="max_discount" maxlength="5" /><span
                                class="currBack curBD">AUD</span>
                            <span class="text-danger max_discount_err"><?php echo form_error('max_discount');?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="amount" class="control-label">Not Exceeding</label>
                        <div class="form-group has-feedback">
                            <input type="text" name="not_exceeding"
                                value="<?php echo $this->input->post('not_exceeding'); ?>"
                                class="form-control inDis chknum1 input-ui-100" id="not_exceeding" maxlength="5" /><span
                                class="currBack curF">AUD</span>
                            <span class="text-danger"><?php echo form_error('not_exceeding');?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="amount" class="control-label">Minimum Purchase Value</label>
                        <div class="form-group has-feedback">
                            <input type="text" name="min_purchase_value"
                                value="<?php echo $this->input->post('min_purchase_value'); ?>"
                                class="form-control inDis chknum1 input-ui-100" id="min_purchase_value" maxlength="5" />
                            <span class="currBack">AUD</span>
                            <span class="text-danger"><?php echo form_error('min_purchase_value');?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="amount" class="control-label">Range 1</label>
                    </div>
                    <div id="tbody">
                        <?php
			  @$totalRanges = count($this->input->post('range_from'));
			  if(!empty($totalRanges) && count($totalRanges)>0) {
			   for($i=0;$i<=$totalRanges;$i++) {?>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">From</span>
                                    <input type="text" name="range_from[]"
                                        value="<?php echo $this->input->post('range_from')[$i]; ?>"
                                        class="form-control chkRange chkMin chkFrom chknum1 input-ui-100" id="range_from"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack">AUD</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">To</span>
                                    <input type="text" name="range_to[]"
                                        value="<?php echo $this->input->post('range_to')[$i]; ?>"
                                        class="form-control chkRange chkMin chkTo chknum1 input-ui-100" id="range_to"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack">AUD</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">Discount</span>
                                    <input type="text" name="range_discount[]"
                                        value="<?php echo $this->input->post('range_discount')[$i]; ?>"
                                        class="form-control chkRange chkDisc chknum1 input-ui-100" id="range_discount"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack curBD">AUD</span>
                                </div>
                            </div>
                            <div class="col-md-3"><button class="btn btn-danger remove" data-del="1"
                                    type="button">X</button></div>
                        </div>
                        <?php }
				 } else {
				 ?>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">From</span>
                                    <input type="text" name="range_from[]" value=""
                                        class="form-control chkRange inDis chkMin chkFrom chknum1 input-ui-100" id="range_from"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack">AUD</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">To</span>
                                    <input type="text" name="range_to[]" value=""
                                        class="form-control chkRange inDis chkMin chkTo chknum1 input-ui-100" id="range_to"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack">AUD</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <span class="currFront">Discount</span>
                                    <input type="text" name="range_discount[]" value=""
                                        class="form-control chkRange inDis chkDisc chknum1 input-ui-100" id="range_discount"
                                        style="padding-left: 75px;" maxlength="5" />
                                    <span class="currBack curBD">AUD</span>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="col-md-12 chkAdd" style="display:none;"><a href="javascript:void(0);"
                            class="btn btn-success btn-sm" id="addBtn">Add New Ranges +</a>
                    </div>
                    <div class="col-md-12">
                        <Br /><span class="text-danger" id="chkSameVal"></span><Br /><span class="text-danger"
                            id="rangeid"></span><Br /><span class="text-danger" id="rangedisc"></span><Br /><span
                            class="text-danger" id="rangeempty"></span>
                    </div>
                    <div class="col-md-12" style="margin-top:20px;"> &nbsp;</div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="user_per_code" class="control-label"><span class="text-danger">*</span>Uses per
                                Code</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="user_per_code"
                                    value="<?php echo $this->input->post('user_per_code'); ?>"
                                    class="form-control inDis chknum1 input-ui-100" id="user_per_code" maxlength="5" />
                                <span
                                    class="text-danger user_per_code_err"><?php echo form_error('user_per_code');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="uses_per_user" class="control-label"><span class="text-danger">*</span>Uses per
                                User</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="uses_per_user"
                                    value="<?php echo $this->input->post('uses_per_user'); ?>" maxlength="1"
                                    class="form-control inDis chknum1 input-ui-100" id="uses_per_user" maxlength="5" />
                                <span
                                    class="text-danger uses_per_user_err"><?php echo form_error('uses_per_user');?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="discount_division_id" class="control-label"><span class="text-danger">*</span>Division</label>
                            <div class="form-group">
                                <select name="discount_division_id" id="discount_division_id" class="form-control selectpicker inDis selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select Division</option>
                                    <?php 
                                    krsort($all_division);
                                    foreach($all_division as $b){
                                        if(in_array(strtolower($b['id']),array(VISA_DIVISION_PKID,ACADEMY_DIVISION_PKID))){
                                            
                                            $selected = in_array($b['id'],$division_id) ? ' selected="selected"' : "";
                                            echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
                                        }
                                    } 
                                    ?>
                                </select>
                                <span class="text-danger discount_division_id_err"><?php echo form_error('discount_division_id');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="appliedProducts" class="control-label"><span class="text-danger">*</span>Applied to Products</label>
                            <div class="form-group">
                                <select name="appliedProducts" id="appliedProducts"
                                    class="form-control inDis selectpicker selectpicker-ui-100" data-show-subtext="true"
                                    data-live-search="true">
                                    <!-- <option value="">Select Product</option>
                                    <option value="1"
                                        <?php if($this->input->post('appliedProducts')==1) echo "selected";?>>Inhouse
                                        pack</option>
                                    <option value="2"
                                        <?php if($this->input->post('appliedProducts')==2) echo "selected";?>>Online
                                        pack</option>
                                    <option value="3"
                                        <?php if($this->input->post('appliedProducts')==3) echo "selected";?>>Practice
                                        Pack</option>
                                    <option value="4"
                                        <?php if($this->input->post('appliedProducts')==4) echo "selected";?>>Reality
                                        Test</option>
                                    <option value="5"
                                        <?php if($this->input->post('appliedProducts')==5) echo "selected";?>>Exam
                                        Booking</option> -->
                                </select>
                                <span
                                    class="text-danger appliedProducts_err"><?php echo form_error('appliedProducts[]');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="appliedBranches" class="control-label appliedBranchesLabel"><span class="text-danger">*</span>Applied to Branches</label>
                            <div class="form-group">
                                <input type="hidden" name="branchids" id="branchids" value="" />
                                <select name="appliedBranches[]" id="appliedBranches"
                                    class="form-control inDis selectpicker selectpicker-ui-100" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple="multiple">
                                    <option value="" disabled>Select Branch</option>
                                    <?php 
									/*foreach($all_branch as $b)
									{
										if(in_array($b['center_id'],$this->input->post('appliedBranches'))) {
										echo '<option value="'.$b['center_id'].'" selected>'.$b['center_name'].'</option>';
										} else {
										echo '<option value="'.$b['center_id'].'">'.$b['center_name'].'</option>';
										}
									} */
									?>
                                </select>
                                <span
                                    class="text-danger appliedBranches_err"><?php echo form_error('appliedBranches[]');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="appliedTestType" class="control-label"> <span
                                    class="text-danger">*</span>Applied to Courses</label>
                            <div class="form-group">
                                <input type="hidden" name="testtypeids" id="testtypeids" value="" />
                                <select name="appliedTestType[]" id="appliedTestType"
                                    class="form-control inDis selectpicker appliedTestType selectpicker-ui-100" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple="multiple">
                                    <option value="" disabled>Select Test Type</option>
                                    <?php 
								foreach($all_testtype_list as $b)
								{
									if(in_array($b['test_module_id'],$this->input->post('appliedTestType'))) {
									echo '<option value="'.$b['test_module_id'].'" selected>'.$b['test_module_name'].'</option>';
									} else {
									echo '<option value="'.$b['test_module_id'].'" >'.$b['test_module_name'].'</option>';
									}
								} 
								?>
                                </select>
                                <span
                                    class="text-danger appliedTestType_err"><?php echo form_error('appliedTestType');?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 appliedPackagesSection">
                        <div class="col-md-4">
                            <label for="appliedPackages" class="control-label"> <span
                                    class="text-danger">*</span>Applied to Packages / Practice Packs</label>
                            <div class="form-group">
                                <input type="hidden" name="packageids" id="packageids" value="" />
                                <select name="appliedPackages[]" id="appliedPackages"
                                    class="form-control inDis selectpicker selectpicker-ui-100" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple="multiple">
                                    <option value="" disabled>Select Type</option>
                                </select>
                                <span
                                    class="text-danger appliedPackages_err"><?php echo form_error('appliedPackages');?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> &nbsp;</div>
                    <div class="col-md-12" style="margin-left:13px;"><label for="amount" class="control-label">Generate
                            Codes</label></div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <div class="col-md-6">
                                    <span class="currFrontG">Auto</span>
                                    <input type="checkbox" name="isAuto" value="0" class="inDis" id="isAuto"
                                        style="margin-left: 122px; margin-top:9px; padding-right:5px;" />
                                </div>
                                <div class="col-md-6">
                                    <span class="currFrontG">Characters</span>
                                    <input type="text" name="disCharacter"
                                        value="<?php echo $this->input->post('disCharacter'); ?>" placeholder="1-5"
                                        class="form-control inDis allow-numeric chknum1 input-ui-100" id="disCharacter"
                                        style="padding-left: 114px; padding-right:5px;" maxlength="1" />
                                    <span class="text-danger"><?php echo form_error('disCharacter');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <span class="currFrontG">Prefix</span>
                                <input type="text" name="disPrefix"
                                    value="<?php echo $this->input->post('disPrefix'); ?>" class="form-control inDis input-ui-100"
                                    id="disPrefix" style="padding-left: 125px; padding-right:5px;" maxlength="5" />
                                <span class="text-danger"><?php echo form_error('disPrefix');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback"><span class="currFrontG">Suffix</span>
                                <input type="text" name="disSuffix"
                                    value="<?php echo $this->input->post('disSuffix'); ?>" class="form-control inDis input-ui-100"
                                    id="disSuffix" style="padding-left: 125px; padding-right:5px;" maxlength="5" />
                                <span class="text-danger"><?php echo form_error('disSuffix');?></span>
                            </div>
                        </div>
                        <div class="col-md-12 nmanual" style="margin-bottom:15px; display:none;">Or</div>
                        <div class="col-md-4 nmanual" style="display:none;">
                            <div class="form-group has-feedback">
                                <div class="col-md-12">
                                    <span class="currFrontG">Manual</span>
                                    <input type="text" name="disc_manual"
                                        value="<?php echo $this->input->post('disc_manual'); ?>"
                                        class="form-control inDis input-ui-100" id="disc_manual"
                                        style="padding-left: 114px; padding-right:5px;" maxlength="10" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 ncodes" style="margin-bottom:15px;display:none;"></div>
                        <div class="col-md-4 ncodes" style="display:none;">
                            <label for="appliedPackages" class="control-label"><span class="text-danger">*</span>Number
                                of Codes</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="no_of_codes"
                                    value="<?php echo $this->input->post('no_of_codes'); ?>"
                                    class="form-control inDis chknum1 input-ui-100" id="no_of_codes" maxlength="5" />
                                <span class="text-danger no_of_codes_err"><?php echo form_error('no_of_codes');?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bindto" style="margin-bottom:15px;display:none;"> &nbsp;</div>
                    <div class="col-md-12 bindto" style="display:none;">
                        <label for="amount" class="control-label"><span class="text-danger">*</span>Bind Code to</label>
                    </div>
                    <div id="tbody" class="bindto" style="display:none;">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="country_code" id="country_code" class="form-control  selectpicker selectpicker-ui-100"
                                    data-show-subtext="true" data-live-search="true">
                                    <option value=""> Country code</option>
                                    <?php 
								foreach($all_country_code as $b)
								{
									$selected= ($b['country_code'] == '+91') ? ' selected="selected"' : "";
									echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';
								} 
								?>
                                </select>
                                <span class="text-danger"><?php echo form_error('country_code');?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <span class="currFrontP">Phone Number</span>
                                <input type="text" name="phoneNumber"
                                    value="<?php echo $this->input->post('phoneNumber'); ?>" autocomplete="off"
                                    maxlength="12" class="form-control  chknum1 input-ui-100" id="phoneNumber"
                                    style="padding-left: 112px;" /><span
                                    class="glyphicon glyphicon-phone form-control-feedback"></span>
                                <input type="hidden" name="phoneemail" id="phoneemail" value="" />
                                <span
                                    class="text-danger chkphone phoneNumber_err"><?php echo form_error('phoneNumber');?></span>
                            </div>
                        </div>
                        <div style="float:left; font-size:16px;">
                            /
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <span class="currFrontE">Email</span>
                                <input type="text" name="bemail" value="<?php echo $this->input->post('bemail'); ?>"
                                    class="form-control input-ui-100" autocomplete="off" id="bemail"
                                    style="padding-left: 75px;" /><span
                                    class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <span class="text-danger chkemail bemail_err"><?php echo form_error('bemail');?></span>
                            </div>
                        </div>
                        <div class="col-md-3 upcsv">
                            <select name="leadgroup[]" id="leadgroup" class="form-control selectpicker selectpicker-ui-100"
                                data-show-subtext="true" data-live-search="true" disabled="disabled"
                                data-actions-box="true">
                                <option value="">Select Lead Group</option>
                            </select>
                        </div>
                        <!--<div class="col-md-3 upcsv">
							<input type="file" id="upfile" name="upfile" style="display:none"/> 
							<a href="javascript:void(0);" id="OpenOUpload" class="btn btn-success btn-sm">Upload CSV</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-sm">Download Sample</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-sm" id="resetid">Reset</a><Br /><span id="sel" style="display:none;">Selected</span>
                    	</div>-->
                    </div>
                    <div class="col-md-12 templateId" style="display:none; margin-top:10px;">
                        <div class="col-md-12">
                            <label for="package_desc" class="control-label"><span
                                    class="text-danger">*</span>Template</label>
                            <div class="form-group has-feedback">
                                <textarea name="template_description" class="form-control myckeditor"
                                    id="template_description"></textarea>
                                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="btnCheck" id="btnCheck" value="0" />
            <div class="shide">
                <div class="box-footer gencode">
                    <button type="submit" class="btn btn-danger btndis btnchckval inDis" data-val="0">
                        <i class="fa fa-check"></i> <?php echo GENERATE_LABEL;?>
                    </button>
                </div>
                <div class="box-footer specialid" style="display:none;">
                    <button type="submit" class="btn btn-danger btndis btnchckval " data-val="0">
                        <i class="fa fa-check"></i> <?php echo GENERATE_SEND_LABEL;?>
                    </button>
                </div>
                <div class="specialid" style="display:none;">
                    <div class="col-md-12" style="margin-top:20px; margin-bottom:30px;">
                        <div class="col-md-4">
                            <label for="waiver_type" class="control-label"><span class="text-danger">*</span> Schedule
                                for Later</label>
                            <div class="form-group">
                                <div class="col-md-6" style="padding-left:0px;">
                                    <input type="text" name="schedule_date"
                                        value="<?php echo $this->input->post('schedule_date'); ?>" autocomplete="off"
                                        class="noBackDate form-control input-ui-100" id="schedule_date" maxlength="10" />
                                    <span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i
                                            class="fa fa-birthday-cake"></i></span>
                                </div>
                                <?php
									$begin = new DateTime("00:00");
									$end   = new DateTime("23:00");
									$interval = DateInterval::createFromDateString('1 hour');
									$times    = new DatePeriod($begin, $interval, $end);
						  		?>
                                <div class="col-md-6">
                                    <select name="schedule_time" id="schedule_time" class="form-control selectpicker selectpicker-ui-100"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="">Time</option>
                                        <?php 
								/*foreach ($times as $time) {
										$timepick=$time->add($interval)->format('H:i');
         ;
									$selected = ($timepick == $this->input->post('end_date')) ? ' selected="selected"' : "";
									echo '<option value="'.$timepick.'" '.$selected.'>'.$timepick.'</option>';
								} */
								?>
                                        <?php 
								foreach($all_time_slots as $b)
								{
									$selected = ($b['time_slot'] == $this->input->post('schedule_time')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].' '.$b['type'].'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								} 
								?>
                                    </select>
                                    <span
                                        class="text-danger schedule_time_err"><?php echo form_error('schedule_time');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger btnchckval" data-val="1"
                            style="color:#000; background-color:#FFFF00; font-weight:bold; border:none; padding:10px;">
                            <i class="fa fa-check"></i> <?php echo GENERATE_SCHEDULE_LABEL;?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>

<?php ob_start(); ?>
<script type="text/javascript">

var activeRealtyTestTypes = '<?php echo $all_realty_active_test_types; ?>';
var activeRealtyPackages  = '<?php echo $all_realty_active_packages; ?>';

function convertTime12To24(time) {
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if (AMPM === "PM" && hours < 12) hours = hours + 12;
    if (AMPM === "AM" && hours === 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    return (sHours + ":" + sMinutes);
}
$(document).ready(function() {
    $(".inDis").attr('disabled', true);
    <?php if(!empty($this->input->post('type_of_discount'))) {?>
    $("#type_of_discount").change();
    <?php }?>
    $('.selectpicker').selectpicker().change(function() {
        $(this).valid()
    });
    $(".allow-numeric").bind("keypress", function(e) {
        var keyCode = e.which ? e.which : e.keyCode
        if (!(keyCode >= 48 && keyCode <= 53)) {
            //$(".error").css("display", "inline");
            return false;
        } else {
            // $(".error").css("display", "none");
        }
    });
    $(document).on('change', '#country_id', function() {
        $(".inDis").attr('disabled', false);
        //$(".selectpicker").val('default');
        $(".selectpicker").selectpicker("refresh");
    });
    $('#uses_per_user, #user_per_code, #disCharacter').keypress(function(e) {
        if (this.value.length == 0 && e.which == 48) {
            return false;
        }
    });
    $(document).on('blur', '.chkTo', function() {
        var from = $(this).parents(".col-md-3").prev().find('input').val();
        if (parseInt($(this).val()) < parseInt(from)) {
            $(".btndis").attr('disabled', 'disabled');
            $("#rangedisc").show();
            $("#rangedisc").html("Range To must be greater than Range From");
            //$(this).focus();
        } else {
            $("#rangedisc").hide();
            $("#rangedisc").html("");
            $(".btndis").attr('disabled', false);
        }
        //$(".chkRange").trigger("blur");
    });
    $(document).on('blur', '.chkFrom', function() {
        var from = $(this).parents(".col-md-12").prev().find('input.chkFrom').val();
        if (parseInt($(this).val()) == parseInt(from)) {
            $(".btndis").attr('disabled', 'disabled');
            $("#chkSameVal").show();
            $("#chkSameVal").html("Range From should not be match others Range From");
            //$(this).focus();
        } else {
            $("#chkSameVal").hide();
            $("#chkSameVal").html("");
            $(".btndis").attr('disabled', false);
        }
        //$(".chkRange").trigger("blur");
    });
    $(document).on('blur', '.chkTo', function() {
        var from = $(this).parents(".col-md-12").prev().find('input.chkTo').val();
        if (parseInt($(this).val()) == parseInt(from)) {
            $(".btndis").attr('disabled', 'disabled');
            $("#chkSameVal").show();
            $("#chkSameVal").html("Range To should not be match others Range To");
            //$(this).focus();
        } else {
            $("#chkSameVal").hide();
            $("#chkSameVal").html("");
            $(".btndis").attr('disabled', false);
        }
        //$(".chkRange").trigger("blur");
    });
    /*jQuery.validator.addMethod("greaterThan", 
    function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) > new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) 
            || (Number(value) > Number($(params).val())); 
    },'Must be greater than {0}.');*/
    jQuery.validator.addMethod("checkSelectedBranchesAccordingtoCountry", function(value, element) {
        var countryIds  = $("[name='country_id[]']").val();
        var branchIds   = $("[name='appliedBranches[]']").val();
        var productId   = $("[name='appliedProducts']").val();
        
        var validate    = false;
        //alert(branchIds);
        if(branchIds != '<?php echo ONLINE_BRANCH_ID; ?>' && productId != 4 && productId != 5) {
            $.ajax({
                url: WOSA_ADMIN_URL + 'discount/ajax_check_selected_branch_according_to_country',
                async: false,
                type: 'post',
                data: { country_id: countryIds, branch_id: branchIds},
                dataType: 'json',
                success: function (data) {
                    if(data) {
                        validate = true;
                    }
                }
            })
            return validate;
        }
        else {
            return true;
        }
    },"Please select atleast one branch of the selected country.");

    jQuery.validator.addMethod("checkMultipleCountry", function(value, element) {
        var countryIds      = $("[name='country_id[]']").val();
        var countCountryIds = countryIds.length;
        var countryType     = $("#country_type").val();
        
        if(countryType == '<?php echo COUNTRY_TYPE[1]; ?>' && countCountryIds <= 1) {
            return false;
        }

        return true;
       
    },"Please select more than one country");

    $.validator.addMethod('greaterThan', function(value, element) {
        var dateFrom = $("#start_date").val();
        var dateTo = $('#end_date').val();
        var timeFrom = $("#start_time").val();
        var timeTo = $('#end_time').val();
        mySDate = dateFrom.split("-");
        var timeFrom = convertTime12To24(timeFrom);
        mySTime = timeFrom.split(":");
        var newSDate = new Date(mySDate[2], mySDate[1] - 1, mySDate[0], mySTime[0], mySTime[1]);
        myEDate = dateTo.split("-");
        var timeTo = convertTime12To24(timeTo);
        myETime = timeTo.split(":");
        var newEDate = new Date(myEDate[2], myEDate[1] - 1, myEDate[0], myETime[0], myETime[1]);
        return newEDate.getTime() > newSDate.getTime();
    }, "Please check your dates. The start date must be before the end date.");
    $("#frmDiscount").validate({
        ignore: [],
        rules: {
            "country_type": {
                required: true
            },
            "country_id[]": {
                required: true,
                checkMultipleCountry: true
            },
            "start_date": {
                //dateBefore: '#end_date',
                required: true,
                //endDate: "#end_date"
            },
            "start_time": {
                required: true,
            },
            "end_date": {
                required: true,
            },
            "end_time": {
                greaterThan: "#start_time",
                required: true,
            },
            "disc_name": {
                required: true,
            },
            "type_of_discount": {
                required: true,
            },
            "discount_type": {
                required: true,
            },
            "max_discount": {
                required: true,
            },
            "user_per_code": {
                required: true,
            },
            "uses_per_user": {
                required: true,
            },
            "discount_division_id": {
                required: true
            },
            "appliedProducts": {
                required: true,
            },
            "appliedBranches[]": {
                required: function(element) {
                    if ($("#appliedProducts").val() == 1 || $("#appliedProducts").val() == 2 || $(
                            "#appliedProducts").val() == 3 || $("#appliedProducts").val() == 4) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkSelectedBranchesAccordingtoCountry: true
            },
            "appliedTestType[]": {
                required: function(element) {
                    if ($("#appliedProducts").val() == 1 || $("#appliedProducts").val() == 2 || $(
                            "#appliedProducts").val() == 3 || $("#appliedProducts").val() == 4) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            "appliedPackages[]": {
                required: function(element) {
                    if ($("#appliedProducts").val() == 1 || $("#appliedProducts").val() == 2 || $(
                            "#appliedProducts").val() == 3 || $("#appliedProducts").val() == 4) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            "no_of_codes": {
                required: function(element) {
                    if ($("#type_of_discount").val() == 'Bulk') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            "phoneemail": {
                required: function(element) {
                    if ($("#type_of_discount").val() == 'Special' && $("#phoneemail").val() == "") {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            "schedule_date": {
                required: function(element) {
                    if ($("#type_of_discount").val() == 'Special' && $("#btnCheck").val() == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            "schedule_time": {
                required: function(element) {
                    if ($("#type_of_discount").val() == 'Special' && $("#btnCheck").val() == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "country_type")
                error.insertAfter(".country_type_err");
            else if (element.attr("name") == "country_id[]")
                error.insertAfter(".country_id_err");
            else if (element.attr("name") == "start_time")
                error.insertAfter(".start_time_err");
            else if (element.attr("name") == "end_time")
                error.insertAfter(".end_time_err");
            else if (element.attr("name") == "type_of_discount")
                error.insertAfter(".type_of_discount_err");
            else if (element.attr("name") == "discount_type")
                error.insertAfter(".discount_type_err");
            else if (element.attr("name") == "discount_division_id")
                error.insertAfter(".discount_division_id_err");    
            else if (element.attr("id") == "appliedProducts")
                error.insertAfter(".appliedProducts_err");
            else if (element.attr("id") == "appliedBranches")
                error.insertAfter(".appliedBranches_err");
            else if (element.attr("id") == "appliedTestType")
                error.insertAfter(".appliedTestType_err");
            else if (element.attr("id") == "appliedPackages")
                error.insertAfter(".appliedPackages_err");
            else if (element.attr("id") == "schedule_time")
                error.insertAfter(".schedule_time_err");
            else
                error.insertAfter(element);
        },
        messages: {
            country_type: "Please select country type.",
            country_id: "Please select country",
            start_date: "Please enter start date",
            start_time: "Please select start time",
            //end_date:"Please enter start date",
            end_date: {
                required: "Please enter start date",
                //greaterThan: jQuery.format("Please check your dates. The start date must be before the end date."),
                //remote: jQuery.format("{0} is already in use")
            },
            end_time: {
                required: "Please enter start time",
                greaterThan: jQuery.format(
                    "Please check your date and time. The start date and time must be before the end date and time."
                    ),
                //remote: jQuery.format("{0} is already in use")
            },
            //end_time:"Please select end time",
            disc_name: "Please enter discount name",
            type_of_discount: "Please select type of discount",
            discount_type: "Please select discount type",
            max_discount: "Please enter max discount",
            user_per_code: "Please enter user per code",
            uses_per_user: "Please enter uses per user",
            'discount_division_id': "Please select division.",
            'appliedProducts': "Please select products",
            'appliedBranches[]': "Please select branch",
            'appliedTestType[]': "Please select course",
            'appliedPackages[]': "Please select package",
            'no_of_codes': "Please enter number of codes",
            'phoneemail': "Please enter phone number or email",
            'schedule_date': "Please enter schedule date",
            'schedule_time': "Please select schedule time",
        },
        //perform an AJAX post to ajax.php
        submitHandler: function(form) {
            //$("form#frmDiscount" ).submit();
            // return true;
            form.submit();
        }
    });

    //Common.js file code start
    $(document).on('change', '#appliedProducts', function () {
        var products    = $(this).val();
        var countryType = $("#country_type option:selected").val();
        var divisionId  = $("#discount_division_id option:selected").val();

        $.ajax({
            url: WOSA_ADMIN_URL + 'discount/ajax_get_selected_branch',
            async: true,
            type: 'post',
            data: { products: products, country_id: $('#country_id').val(), division_id: divisionId },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // html = '';
                $('#appliedTestType').prop('disabled', false);
                if (data.testtypes.length > 0) {
                    var packids = $('#testtypeids').val();
                    var packidsarr = [];
                    if (packids != "") {
                        packidsarr = packids.split(",");
                    } else {
                        packidsarr = [];
                    }
                    html = '<option value="" disabled>Select Test Type</option>';
                    for (i = 0; i < data.testtypes.length; i++) {
                        if (packidsarr.includes(data.testtypes[i]['test_module_id'])) {
                            html += '<option value=' + data.testtypes[i]['test_module_id'] + ' selected>' + data.testtypes[i]['test_module_name'] + ' </option>';
                        } else {
                            html += '<option value=' + data.testtypes[i]['test_module_id'] + ' >' + data.testtypes[i]['test_module_name'] + ' </option>';
                        }
                    }
                    html += '</select>';
                    $('#appliedTestType').html(html);
                    $('#appliedTestType').selectpicker('refresh');
                } else {
                    html = '';
                    $('#appliedTestType').html(html);
                    $('#appliedTestType').selectpicker('refresh');
                    // $('.branch_div_rt').hide(); 
                }
                var groupFilter = $('#appliedTestType');
                groupFilter.selectpicker("refresh");
                $('#appliedTestType').prop('disabled', false);
                var branchids = $('#branchids').val();
                var branchidsarr = [];
                if (branchids != "") {
                    branchidsarr = branchids.split(",");
                } else {
                    branchidsarr = [];
                }
                $('label.appliedBranchesLabel[for="appliedBranches"]').html('<span class="text-danger">*</span>Applied to Branches');
               
                //$('#appliedTestType').selectpicker('val',''); 
                // $('#appliedTestType').attr('multiple',true);
                // $('#appliedTestType').selectpicker('refresh');
                // $("div.appliedTestType li").removeClass('selected');
                // $('#appliedTestType option').prop('selected',false);
                 $(".appliedPackagesSection").show();

                if (data.result == 1) {
                    $('#appliedBranches').html("");
                    $('#appliedBranches').selectpicker("refresh");
                    $('#appliedBranches').prop('disabled', true);
                } else if (data.result == 2) {
                    $('#appliedBranches')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="" disabled>Select Branch</option><option value="' + ONLINE_BRANCH_ID + '" selected>Online</option>')
                        .val(ONLINE_BRANCH_ID);
                        $("#appliedProducts").selectpicker("refresh");
                        $("#appliedBranches").selectpicker("refresh");
                        $('#appliedBranches').change();
                        //$('#appliedBranches').prop('disabled', true);
                } else if (data.result == 3) {
                    $('#appliedBranches').prop('disabled', false);
                    if (data.centers.length > 0) {
                        html = '<option value="" disabled>Select Branch</option>';
                        for (i = 0; i < data.centers.length; i++) {
                            var countryName = '';
                            if(countryType == '<?php echo COUNTRY_TYPE[1]; ?>') {
                                if(data.centers[i]['center_name'] != 'Online') {
                                    countryName = ' ('+data.centers[i]['country_name']+')';
                                }  
                            }
                            if (branchidsarr.includes(data.centers[i]['center_id'])) {
                                    html += '<option value=' + data.centers[i]['center_id'] + ' selected>' + data.centers[i]['center_name'] + countryName +' </option>';
                            } else {
                                html += '<option value=' + data.centers[i]['center_id'] + ' >' + data.centers[i]['center_name'] + countryName + ' </option>';
                            }
                        }
                        html += '</select>';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                    } else {
                        html = '';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                        // $('.branch_div_rt').hide(); 
                    }
                    var groupFilter = $('#appliedBranches');
                    groupFilter.selectpicker("refresh");
                    $('#appliedBranches').prop('disabled', false);
                    //$('#appliedBranches').prop('disabled', true);
                    $("#appliedBranches option[value='21']").remove();
                    var groupFilter = $('#appliedBranches');
                    groupFilter.selectpicker("refresh");
                } else if (data.result == 4) {
                    // $('#appliedTestType').selectpicker('val','');
                    // $('#appliedTestType').prop('multiple',false);
                    // $('#appliedTestType').selectpicker('refresh');
                    // $("div.appliedTestType li").removeClass('selected');

                    $('#appliedBranches')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="" disabled>Select Branch</option><option value="' + ONLINE_BRANCH_ID + '" selected>Online</option>')
                        .val(ONLINE_BRANCH_ID);
                        $("#appliedProducts").selectpicker("refresh");
                        $("#appliedBranches").selectpicker("refresh");
                        $('#appliedBranches').change();

                        var activeTestTypeIdsArray = [];
                        if(activeRealtyTestTypes.length) {
                            var activeRealtyTestObj = $.parseJSON(activeRealtyTestTypes);
                            var html = '<option value="" disabled>Select Courses</option>';
                            $.each(activeRealtyTestObj,function(key,value) {
                                activeTestTypeIdsArray.push(value['test_module_id']);
                                html += '<option value=' + value['test_module_id'] + ' >' + value['test_module_name'] + ' </option>';
                            });
                           
                            $('#appliedTestType')
                                .find('option')
                                .remove()
                                .end()
                                .append(html);
                            $('#appliedTestType').selectpicker('refresh');
                        }

                    /* $(".appliedPackagesSection").hide();

                    $('label.appliedBranchesLabel[for="appliedBranches"]').html('<span class="text-danger">*</span>Applied to Independent Branches');
                    if (data.centers.length > 0) {
                        html = '<option value="" disabled>Select Branch</option>';
                        for (i = 0; i < data.centers.length; i++) {
                            if (branchidsarr.includes(data.centers[i]['center_id'])) {
                                    html += '<option value=' + data.centers[i]['center_id'] + ' selected>' + data.centers[i]['center_name'] + ' </option>';
                            } else {
                                html += '<option value=' + data.centers[i]['center_id'] + ' >' + data.centers[i]['center_name'] + ' </option>';
                            }
                        }
                        html += '</select>';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                    } else {
                        html = '';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                        // $('.branch_div_rt').hide(); 
                    }
                    var groupFilter = $('#appliedBranches');
                    groupFilter.selectpicker("refresh");
                    $('#appliedBranches').prop('disabled', false);
                    //$('#appliedBranches').prop('disabled', true);
                    $("#appliedBranches option[value='21']").remove();
                    var groupFilter = $('#appliedBranches');
                    groupFilter.selectpicker("refresh"); */
                } else {
                    $('#appliedBranches').prop('disabled', false);
                    if (data.centers.length > 0) {
                        html = '<option value="" disabled>Select Branch</option>';
                        for (i = 0; i < data.centers.length; i++) {
                            var countryName = '';
                            if(countryType == '<?php echo COUNTRY_TYPE[1]; ?>') {
                                if(data.centers[i]['center_name'] != 'Online') {
                                    countryName = ' ('+data.centers[i]['country_name']+')';
                                }
                            }
                            if (branchidsarr.includes(data.centers[i]['center_id'])) {
                                    html += '<option value=' + data.centers[i]['center_id'] + ' selected>' + data.centers[i]['center_name'] + countryName +' </option>';
                            } else {
                                html += '<option value=' + data.centers[i]['center_id'] + ' >' + data.centers[i]['center_name'] + countryName + ' </option>';
                            }
                        }
                        html += '</select>';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                    } else {
                        html = '';
                        $('#appliedBranches').html(html);
                        $('#appliedBranches').selectpicker('refresh');
                        // $('.branch_div_rt').hide(); 
                    }
                    var groupFilter = $('#appliedBranches');
                    groupFilter.selectpicker("refresh");
                    $('#appliedBranches').prop('disabled', false);
                }
            }
        });
    });

    $(document).on('change', '#appliedBranches', function () {
        if ($('#discount_id').val() == "") {
            $('#appliedTestType option').attr("selected", false);
        }
        $('#appliedTestType').selectpicker('refresh');
        $('#appliedTestType').change();
    });

    $(document).on('change', '#appliedTestType', function () {
        var products = $("#appliedProducts").val();
        var branches = $("#appliedBranches").val();
        var min_purchase_value = $("#min_purchase_value").val();

        // if(products == 4 || products == 5) {
        //     $("div.appliedTestType li").removeClass('selected');
        // }

        var testtype = $(this).val();
        $.ajax({
            url: WOSA_ADMIN_URL + 'discount/ajax_get_testype_by_packandbranch',
            async: true,
            type: 'post',
            data: { testtype: testtype, branches: branches, products: products, min_purchase_value: min_purchase_value },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // html = '';
                var packids = $('#packageids').val();
                var packidsarr = [];
                if (packids != "") {
                    packidsarr = packids.split(",");
                } else {
                    packidsarr = [];
                }
                // alert(packidsarr[0]);
                if (data.result == 1) {
                    $('#appliedPackages').prop('disabled', true);
                } else if (data.result == 2) {
                    if (data.package.length > 0) {
                        html = '<option data-subtext="" disabled value="">Select package</option>';
                        for (i = 0; i < data.package.length; i++) {
                            if (data.package[i]['discounted_amount'] === data.package[i]['amount'] || data.package[i]['discounted_amount'] == null) {
                                if (packidsarr.includes(data.package[i]['package_id'])) {
                                    html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                } else {
                                    html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                }
                            } else {
                                if (packidsarr.includes(data.package[i]['package_id'])) {
                                    html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                } else {
                                    html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                }
                            }
                        }
                        html += '</select>';
                        $('#appliedPackages').html(html);
                        $('#appliedPackages').selectpicker('refresh');
                    } else {
                        html = '';
                        $('#appliedPackages').html(html);
                        $('#appliedPackages').selectpicker('refresh');
                        // $('.branch_div_rt').hide(); 
                    }
                } else if (data.result == 3) {
                    if (data.package.length > 0) {
                        html = '<option data-subtext="" disabled value="">Select package</option>';
                        for (i = 0; i < data.package.length; i++) {
                            if (data.package[i]['category_name']) { var cat = data.package[i]['category_name']; } else { var cat = 'ALL'; }
                            if (data.package[i]['discounted_amount'] === data.package[i]['amount'] || data.package[i]['discounted_amount'] == null) {
                                if (packidsarr.includes(data.package[i]['package_id'])) {
                                    html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                } else {
                                    html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                }
                            } else {
                                if (packidsarr.includes(data.package[i]['package_id'])) {
                                    html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                } else {
                                    html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
                                }
                            }
                        }
                        html += '</select>';
                        $('#appliedPackages').html(html);
                        $('#appliedPackages').selectpicker('refresh');
                        /* html='<option value="">Select Package</option>';
                            for(i=0; i<data.package.length; i++){                        
                                html += '<option value='+ data.package[i]['package_id'] +' >'+ data.package[i]['package_name'] +' </option>';                                       
                            }
                            html += '</select>';
                            $('#appliedPackages').html(html);
                            $('#appliedPackages').selectpicker('refresh');*/
                    } else {
                        html = '';
                        $('#appliedPackages').html(html);
                        $('#appliedPackages').selectpicker('refresh');
                        // $('.branch_div_rt').hide(); 
                    }
                } else {
                    $('#appliedPackages').prop('disabled', false);
                    html = '';
                    $('#appliedPackages').html(html);
                    $('#appliedPackages').selectpicker('refresh');
                }
            }
        });
    });

    $(document).on('change', '.ccode', function () {
        var html = '';
        $(this).find('option[value=""]').prop('selected',false);
        var country_id 		= $(this).val();
        var countryType 	= $('#country_type option:selected').val();
        var countryCurrency = $('#country_currency option:selected').val();
        $(".ccode [data-original-index='0']").removeClass('selected');

        if(countryType == '<?php echo COUNTRY_TYPE[0]; ?>') {
            $('#country_currency').selectpicker('val','default-currency');
        }

        $.ajax({
            url: WOSA_ADMIN_URL + 'discount/ajax_get_country_code',
            async: true,
            type: 'post',
            data: { country_id: country_id },
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                // $.ajax({
                //     url: WOSA_ADMIN_URL + 'discount/ajax_get_product_list',
                //     async: true,
                //     type: 'post',
                //     data: { country_id: country_id },
                //     dataType: 'json',
                //     success: function (data1) {
                //         $('#appliedProducts')
                //             .find('option')
                //             .remove()
                //             .end()
                //             .append(data1)
                //             .val('whatever');
                //         $("#appliedProducts").selectpicker("refresh");
                //     }
                // });
                
                $('.shide').show();
                $('.currBack').show();
                $('.currBack').html('');
                $('.currBack').html(data);
                var disType = $("#discount_type").val();
                var ccode = $('.curF').html();

                if(!ccode) {
                    ccode = DISCOUNT_MULTIPLE_COUNTRY_CURRENCY;
                }
                
                if (disType == "Percentage") {
                    $('.currBack').html(ccode);
                    //$('.curBD').show();
                    $('.currBack').show();
                    $('.curBD').html("%");
                }
                if (disType == "Amount") {
                    $('.curBD').show();
                    $('.curF').show();
                    $('.currBack').show();
                    $('.curBD').html(ccode);
                }
                
                if(countryType == '<?php echo COUNTRY_TYPE[1]; ?>' || (countryType == '<?php echo COUNTRY_TYPE[0]; ?>' && countryCurrency == DISCOUNT_MULTIPLE_COUNTRY_CURRENCY)) {
                    $('.curF').html(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                    $('.currBack').html(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                    $("#countryCurrency").val(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                }
                else {
                    $('.curF').html(ccode);
                    $('.currBack').html(ccode);
                    $("#countryCurrency").val(ccode);
                }

                
            }
        });
    });
    $(document).on('change', '#country_currency', function () {
        var html = '';
        var country_id 		= $('.ccode option:selected').val();
        var countryType 	= $('#country_type option:selected').val();
        var countryCurrency = $('#country_currency option:selected').val();
        
        $.ajax({
            url: WOSA_ADMIN_URL + 'discount/ajax_get_country_code',
            async: true,
            type: 'post',
            data: { country_id: country_id },
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                // $.ajax({
                //     url: WOSA_ADMIN_URL + 'discount/ajax_get_product_list',
                //     async: true,
                //     type: 'post',
                //     data: { country_id: country_id },
                //     dataType: 'json',
                //     success: function (data1) {
                //         $('#appliedProducts')
                //             .find('option')
                //             .remove()
                //             .end()
                //             .append(data1)
                //             .val('whatever');
                //         $("#appliedProducts").selectpicker("refresh");
                //     }
                // });
                
                $('.shide').show();
                $('.currBack').show();
                $('.currBack').html('');
                $('.currBack').html(data);
                var disType = $("#discount_type").val();
                var ccode = $('.curF').html();

                if(!ccode) {
                    ccode = DISCOUNT_MULTIPLE_COUNTRY_CURRENCY;
                }

                if (disType == "Percentage") {
                    $('.currBack').html(ccode);
                    //$('.curBD').show();
                    $('.currBack').show();
                    $('.curBD').html("%");
                }
                if (disType == "Amount") {
                    $('.curBD').show();
                    $('.curF').show();
                    $('.currBack').show();
                    $('.curBD').html(ccode);
                }

                if(countryType == '<?php echo COUNTRY_TYPE[1]; ?>' || (countryType == '<?php echo COUNTRY_TYPE[0]; ?>' && countryCurrency == DISCOUNT_MULTIPLE_COUNTRY_CURRENCY)) {
                    $('.curF').html(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                    $('.currBack').html(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                    $("#countryCurrency").val(DISCOUNT_MULTIPLE_COUNTRY_CURRENCY);
                }
                else {
                    $('.curF').html(ccode);
                    $('.currBack').html(ccode);
                    $("#countryCurrency").val(ccode);
                }
            }
        });
    });
    //common.js file code end

    $(document).on("change","#discount_division_id",function(){
        var divisionId = $(this).val();
        $.ajax({
            url: WOSA_ADMIN_URL + 'discount/ajax_get_products_according_to_division_id',
            async: true,
            type: 'post',
            data: { division_id: divisionId },
            dataType: 'json',
            success: function (response) {
                $('#appliedProducts')
						.find('option')
						.remove()
						.end()
						.append(response)
						.val('whatever');
					$("#appliedProducts").selectpicker("refresh");
            }
        })
    })
});
// set default dates
var start = new Date();
// set end date to max one year period:
var end = new Date(new Date().setYear(start.getFullYear() + 1));
$('#start_date').datepicker({
    format: 'dd-mm-yyyy',
    startDate: start,
    endDate: end,
    autoclose: true,
}).on('change', function() {
    $(this).valid(); // triggers a validation test
});
$("#end_date").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    startDate: start,
    //	endDate: '+10d'
}).on('change', function() {
    $(this).valid(); // triggers a validation test
});

$('#schedule_date').datepicker({
    format: 'dd-mm-yyyy',
    startDate: start,
    endDate: end,
    autoclose: true,
}).on('change', function() {
    $(this).valid(); // triggers a validation test
    // $(this) refers to $('#eventDate')
});
$(document).on("change","#country_type",function(){
	$(".selectCountry").prop("disabled",false);
	
	if($(this).val() == '<?php echo COUNTRY_TYPE[0] ?>' ) {
		$(".singleCountryTypeRelated").show();
		$(".selectCountry").prop("multiple",false);
		//$(".selectCountry").attr("data-actions-box",false);
		$(".selectCountry option").each(function(){
			if($(this).val() == '<?php echo INDIA_ID; ?>') {
				$(this).prop("disabled",false);
			}
		})
	}
	else if($(this).val() == '<?php echo COUNTRY_TYPE[1] ?>') {
		$(".singleCountryTypeRelated").hide();
		$(".selectCountry").prop("multiple",true);
		//$(".selectCountry").attr("data-actions-box",true);
		$(".selectCountry option").each(function(){
			if($(this).val() == '<?php echo INDIA_ID; ?>') {
				$(this).prop("disabled",true);
			}
		})
	}
    $(".selectpicker").selectpicker("refresh");
    $(".selectCountry").selectpicker('val','');
    $(".ccode li").removeClass('selected');
})

// function checkSelectedBranchesAccordingtoCountry() {
    
//     return validate;
// }
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>