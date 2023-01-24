<style type="text/css">
	input[type="checkbox"][readonly] {
  	pointer-events: none;
}
.currBack {
position: absolute;top: 0;right: 0;z-index: 2;display: block;width: 50px;height: 34px;line-height: 34px;text-align: center;pointer-events: none; background-color:#e0dede; display:none;
}
.currFront {
position: absolute;top: 0;left: 0;z-index: 2;display: block;width: 70px;height: 34px;line-height: 34px;text-align: center;pointer-events: none; background-color:#e0dede;
}
.currFrontP {
position: absolute;top: 0;left: 0;z-index: 2;display: block;width: 104px;height: 34px;line-height: 34px;text-align: center;pointer-events: none; background-color:#e0dede;
}
.currFrontE {
position: absolute;top: 0;left: 0;z-index: 2;display: block;width: 70px;height: 34px;line-height: 34px;text-align: center;pointer-events: none; background-color:#e0dede;
}
.currFrontG {
position: absolute;top: 0;left: 0;z-index: 2;display: block;width: 120px;height: 34px;line-height: 34px;text-align: center;pointer-events: none; background-color:#e0dede;
}
</style>
<style>
.error {
color:#a94442; font-weight:normal;
}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
               <div class="box-tools pull-right">
              	<a href="<?php echo site_url('adminController/discount/index'); ?>" class="btn btn-success btn-sm">ALL Discount list</a>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/discount/edit/'.$discount_details['id'], array('id' => 'frmDiscount')); ?>
            
          	<div class="box-body">          		
          		<div class="row clearfix">
                <input type="hidden" name="discount_id" id="discount_id" value="<?php echo $discount_details['id'] ?>" />

          		<div class="col-md-4">
						<label for="country_id" class="control-label"><span class="text-danger">*</span> Applied to Country</label>
						<div class="form-group">
							<select name="country_id" id="country_id" class="form-control selectpicker ccode" disabled="disabled" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select country</option>
								<?php 
								foreach($all_country_currency_code as $p)
								{	
								
									
									$selected = ($p['country_id'] == $discount_details['country_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger country_id_err"><?php echo form_error('country_id');?></span>
						</div>
					</div>	
                    
               <div class="shide">
                    <div class="col-md-4">
						<label for="start_date" class="control-label"><span class="text-danger">*</span> Start Date | Time</label>
                       
						<div class="form-group">
                         <div class="col-md-6" style="padding-left:0px;">
							<input type="text" name="start_date" value="<?php echo date('d-m-Y',strtotime($discount_details['start_date'])); ?>" class="noBackDate dpick form-control" id="start_date" maxlength="10"/>
							<span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i class="fa fa-birthday-cake"></i></span>
                            <span class="text-danger start_date_err" ><?php echo form_error('start_date');?></span>
                          </div>
                          <?php
$begin = new DateTime("00:00");
$end   = new DateTime("23:00");

$interval = DateInterval::createFromDateString('1 hour');

$times    = new DatePeriod($begin, $interval, $end);
						  ?>
                          
                          <div class="col-md-6" > 
                           <select name="start_time" id="start_time" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
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
									$selected = ($b['time_slot'] == $discount_details['start_time']) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].'" '.$selected.'>'.$b['time_slot'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger start_time_err"><?php echo form_error('start_time');?></span>
                           
					
                          </div>
                          </div>
                           
                           
					</div>	
                    
                    <div class="col-md-4">
						<label for="end_date" class="control-label"><span class="text-danger">*</span> End Date | Time</label>
						<div class="form-group">
                         <div class="col-md-6" style="padding-left:0px;">
							<input type="text" name="end_date" value="<?php echo date('d-m-Y',strtotime($discount_details['end_date'])); ?>" class="noBackDate form-control" id="end_date" maxlength="10"/>
							<span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i class="fa fa-birthday-cake"></i></span>
                            <span class="text-danger end_date_err" ><?php echo form_error('end_time');?></span>
                          </div>
                          <div class="col-md-6"> 
                           <select name="end_time" id="end_time" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
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
									$selected = ($b['time_slot'] == $discount_details['end_time']) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].'" '.$selected.'>'.$b['time_slot'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger end_time_err"><?php echo form_error('end_time');?></span>
                           
					
                          </div>
                          </div>
					</div>		
                    </div>		
</div>
<div class="row clearfix shide" >
	<div class="col-md-4">
						<label for="amount" class="control-label"><span class="text-danger">*</span>Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="disc_name" value="<?php echo $discount_details['disc_name']; ?>" class="form-control" id="disc_name" />
							<span class="text-danger disc_name_err"><?php echo form_error('disc_name');?></span>	
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="waiver_type" class="control-label"><span class="text-danger">*</span> Type of Discount Code</label>
						<div class="form-group">
							<select name="type_of_discount" id="type_of_discount" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
								<option value="">Select Type</option>
								<option value="General" <?php echo ("General" == $discount_details['type_of_discount']) ? ' selected="selected"' : ""; ?>>General</option>
								<option value="Special" <?php echo ("Special" == $discount_details['type_of_discount']) ? ' selected="selected"' : ""; ?>>Special</option>
								<option value="Bulk" <?php echo ("Bulk" == $discount_details['type_of_discount']) ? ' selected="selected"' : ""; ?>>Bulk</option>
                               <!-- <option value="Template">Template</option>-->
							</select>
							<span class="text-danger type_of_discount_err"><?php echo form_error('type_of_discount');?></span>
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="discount_type" class="control-label"><span class="text-danger">*</span> Discount Type</label>
						<div class="form-group">
							<select name="discount_type" id="discount_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Type</option>
								<option value="Percentage" <?php echo ("Percentage" == $discount_details['discount_type']) ? ' selected="selected"' : ""; ?>>Percentage</option>
								<option value="Amount" <?php echo ("Amount" == $discount_details['discount_type']) ? ' selected="selected"' : ""; ?>>Amount</option>
								
							</select>
							<span class="text-danger discount_type_err"><?php echo form_error('discount_type');?></span>
						</div>
					</div>	
</div>
<div class="row clearfix shide" >					
                    <div class="col-md-4">
						<label for="amount" class="control-label"><span class="text-danger">*</span>Max Discount</label>
						<div class="form-group has-feedback">
							<input type="text" name="max_discount" value="<?php echo $discount_details['max_discount']; ?>" class="form-control chknum1" id="max_discount" maxlength="5" /><span class="currBack curBD">AUD</span>
							<span class="text-danger max_discount_err"><?php echo form_error('max_discount');?></span>	
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="amount" class="control-label">Not Exceeding</label>
						<div class="form-group has-feedback">
							<input type="text" name="not_exceeding" value="<?php echo $discount_details['not_exceeding']; ?>" class="form-control chknum1" id="not_exceeding" maxlength="5" /><span class="currBack curF">AUD</span>
							<span class="text-danger"><?php echo form_error('not_exceeding');?></span>	
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="amount" class="control-label">Minimum Purchase Value</label>
						<div class="form-group has-feedback">
							<input type="text" name="min_purchase_value" value="<?php echo $discount_details['min_purchase_value']; ?>" class="form-control chknum1" id="min_purchase_value" maxlength="5" />
                            <span class="currBack">AUD</span>
							<span class="text-danger"><?php echo form_error('min_purchase_value');?></span>	
						</div>
					</div>
                    
                <div class="col-md-12"> 
               <label for="amount" class="control-label">Range 1</label>  
                </div> 
              <div id="tbody">  
              <?php
			  
			  if(isset($discount_range_details) && count($discount_range_details)>0) {
			   foreach($discount_range_details as $kr=>$kval) {?>
              <div class="col-md-12">
               <div class="col-md-3">
				<div class="form-group has-feedback">
                        <span class="currFront">From</span>
							<input type="text" name="range_from[]" value="<?php echo $kval['range_from']; ?>" class="form-control chkRange chkMin chkFrom chknum1" id="range_from"  style="padding-left: 75px;" maxlength="5" />
                            <span class="currBack">AUD</span>
							
						</div>
					</div>	
                    
                    <div class="col-md-3">
						<div class="form-group has-feedback">
                        <span class="currFront">To</span>
							<input type="text" name="range_to[]" value="<?php echo $kval['range_to']; ?>" class="form-control chkRange chkMin chkTo chknum1" id="range_to"   style="padding-left: 75px;" maxlength="5" />
                            <span class="currBack">AUD</span>
								
						</div>
					</div>	
                    
                    <div class="col-md-3">
						<div class="form-group has-feedback">
                        <span class="currFront">Discount</span>
							<input type="text" name="range_discount[]" value="<?php echo $kval['range_discount']; ?>" class="form-control chkRange chkDisc chknum1" id="range_discount"   style="padding-left: 75px;" maxlength="5"/>
                            <span class="currBack curBD">AUD</span>
								
						</div>
					</div>	
                    <div class="col-md-3"><button class="btn btn-danger remove" data-del="1" type="button">X</button></div>
                  </div> 
                 <?php }
				 } else {
				 ?> 
                 <div class="col-md-12">
               <div class="col-md-3">
				<div class="form-group has-feedback">
                        <span class="currFront">From</span>
							<input type="text" name="range_from[]" value="" class="form-control chkRange chkMin chkFrom chknum1" id="range_from"  style="padding-left: 75px;" maxlength="5" />
                            <span class="currBack">AUD</span>
							
						</div>
					</div>	
                    
                    <div class="col-md-3">
						<div class="form-group has-feedback">
                        <span class="currFront">To</span>
							<input type="text" name="range_to[]" value="" class="form-control chkRange chkMin chkTo chknum1" id="range_to"   style="padding-left: 75px;" maxlength="5" />
                            <span class="currBack">AUD</span>
								
						</div>
					</div>	
                    
                    <div class="col-md-3">
						<div class="form-group has-feedback">
                        <span class="currFront">Discount</span>
							<input type="text" name="range_discount[]" value="" class="form-control chkRange chkDisc chknum1" id="range_discount"   style="padding-left: 75px;" maxlength="5"/>
                            <span class="currBack curBD">AUD</span>
								
						</div>
					</div>	
                    
                  </div>
                 
                 <?php }?>
                  
                  </div>   
                 <div class="col-md-12 chkAdd" ><a href="javascript:void(0);" class="btn btn-success btn-sm" id="addBtn">Add New Ranges +</a> <Br /><span class="text-danger" id="rangeid"></span><Br /><span class="text-danger" id="rangedisc"></span><Br /><span class="text-danger" id="rangeempty"></span>
                
                 </div>   
                   <div class="col-md-12" style="margin-top:20px;"> &nbsp;</div>
                 <div class="col-md-12">   
                    <div class="col-md-4">
						<label for="user_per_code" class="control-label"><span class="text-danger">*</span>Uses per Code</label>
						<div class="form-group has-feedback">
							<input type="text" name="user_per_code" value="<?php echo $discount_details['user_per_code']; ?>" class="form-control chknum1" id="user_per_code" maxlength="5" />
							<span class="text-danger user_per_code_err"><?php echo form_error('user_per_code');?></span>	
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="uses_per_user" class="control-label"><span class="text-danger">*</span>Uses per User</label>
						<div class="form-group has-feedback">
							<input type="text" name="uses_per_user" value="<?php echo $discount_details['uses_per_user']; ?>" class="form-control chknum1" id="uses_per_user" maxlength="5" />
							<span class="text-danger uses_per_user_err" ><?php echo form_error('uses_per_user');?></span>	
						</div>
					</div>	
                    
                  </div>  
                    
             <div class="col-md-12">       
                    <div class="col-md-4">
						<label for="appliedProducts" class="control-label"><span class="text-danger">*</span> Applied to Products</label>
						<div class="form-group">
							<select name="appliedProducts" id="appliedProducts" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true">
								<option value="">Select Product</option>
								<option value="1" <?php if($discount_details['appliedProducts']==1) echo "selected";?>>Inhouse pack</option>
								<option value="2" <?php if($discount_details['appliedProducts']==2) echo "selected";?>>Online pack</option>
								<option value="3" <?php if($discount_details['appliedProducts']==3) echo "selected";?>>Practice Pack</option>
                                <option value="4" <?php if($discount_details['appliedProducts']==4) echo "selected";?>>Reality Test</option>
                                <option value="5" <?php if($discount_details['appliedProducts']==5) echo "selected";?>>Exam Booking</option>
							</select>

							<span class="text-danger appliedProducts_err"><?php echo form_error('appliedProducts[]');?></span>
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="appliedBranches" class="control-label"><span class="text-danger">*</span> Applied to Branches</label>
						<div class="form-group">
						<input type="hidden" name="branchids" id="branchids" value="<?php echo $discount_details['appliedBranches']?>" />
                            <select name="appliedBranches[]" id="appliedBranches" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b)
								{
								$appliedBranches=explode(",",$discount_details['appliedBranches']);
									if(in_array($b['center_id'],$appliedBranches)) {
									echo '<option value="'.$b['center_id'].'" selected>'.$b['center_name'].'</option>';
									} else {
									echo '<option value="'.$b['center_id'].'">'.$b['center_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger appliedBranches_err"><?php echo form_error('appliedBranches[]');?></span>
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="appliedTestType" class="control-label"> Applied to Test Type</label>
						<div class="form-group">
                        <input type="hidden" name="testtypeids" id="testtypeids" value="<?php echo $discount_details['appliedTestType']?>" />
							<select name="appliedTestType[]" id="appliedTestType" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Test Type</option>
								<?php 
								foreach($all_testtype_list as $b)
								{
								$appliedTestType=explode(",",$discount_details['appliedTestType']);
									if(in_array($b['test_module_id'],$appliedTestType)) {
									echo '<option value="'.$b['test_module_id'].'" selected>'.$b['test_module_name'].'</option>';
									} else {
									echo '<option value="'.$b['test_module_id'].'" >'.$b['test_module_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('appliedTestType');?></span>
						</div>
					</div>				
</div>
     <div class="col-md-12">       
                    <div class="col-md-4">
						<label for="appliedPackages" class="control-label"> Applied to Packages / Practice Packs</label>
						<div class="form-group">
                        <input type="hidden" name="packageids" id="packageids" value="<?php echo $discount_details['appliedPackages']?>" />
							<select name="appliedPackages[]" id="appliedPackages" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Type</option>

							</select>
							<span class="text-danger"><?php echo form_error('appliedPackages');?></span>
						</div>
					</div>	
                    </div>               
                     <div class="col-md-12"> &nbsp;</div>	
                     <div class="col-md-12" style="margin-left:13px;"><label for="amount" class="control-label">Generate Codes</label></div>
                 <div class="col-md-12">   
                   <div class="col-md-4">
						<div class="form-group has-feedback">
                        <div class="col-md-6">
                        <span class="currFrontG">Auto</span>
                        <?php if($discount_details['isAuto']==1) {
						$ischeck='checked="checked"';
						$dis="";
						$disM='disabled="disabled"';
						} else {
						$dis='disabled="disabled"';
						$disM='';
						$ischeck="";
						}
						?>
                       
                   
							<input type="checkbox" name="isAuto" value="0"  id="isAuto" <?php echo $ischeck ?> <?php echo $dis ?> style="margin-left: 122px; margin-top:9px; padding-right:5px;"  />
                          </div>  
     <div class="col-md-6">
                            <span class="currFrontG">Characters</span>
							<input type="text" name="disCharacter" value="<?php echo $discount_details['disCharacter']; ?>" <?php echo $dis ?> class="form-control" id="disCharacter" style="padding-left: 114px; padding-right:5px;" maxlength="5" />
							<span class="text-danger"><?php echo form_error('disCharacter');?></span>	
						</div>
                        </div>
					</div>	
                    
                    <div class="col-md-4">
						<div class="form-group has-feedback">
                        <span class="currFrontG">Prefix</span>
							<input type="text" name="disPrefix" value="<?php echo $discount_details['disPrefix']; ?>" <?php echo $dis ?> class="form-control" id="disPrefix" style="padding-left: 125px; padding-right:5px;" maxlength="5"/>
							<span class="text-danger"><?php echo form_error('disPrefix');?></span>	
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<div class="form-group has-feedback"><span class="currFrontG">Suffix</span>
							<input type="text" name="disSuffix" value="<?php echo $discount_details['disSuffix']; ?>" <?php echo $dis ?> class="form-control" id="disSuffix" style="padding-left: 125px; padding-right:5px;" maxlength="5" />
                            
							<span class="text-danger"><?php echo form_error('disSuffix');?></span>	
						</div>
					</div> 
                    <div class="col-md-12 nmanual" style="margin-bottom:15px; display:none;">Or</div>
                    
                    
                    <div class="col-md-4 nmanual" style="display:none;">
						<div class="form-group has-feedback">
                        <div class="col-md-12">
                        <span class="currFrontG">Manual</span>
							<input type="text" name="disc_manual" value="<?php echo $discount_details['disc_manual']; ?>" <?php echo $disM ?> class="form-control" id="disc_manual" style="padding-left: 114px; padding-right:5px;" maxlength="10" />
                          </div>  
     
                        </div>
					</div>	
                    <div class="col-md-12 ncodes" style="margin-bottom:15px;display:none;"></div> 
                    <div class="col-md-4 ncodes" style="display:none;">
                    <label for="appliedPackages" class="control-label"><span class="text-danger">*</span>Number of Codes</label>
						<div class="form-group has-feedback">

                       
							<input type="text" name="no_of_codes" value="<?php echo $discount_details['no_of_codes']; ?>" class="form-control" id="no_of_codes"  maxlength="5" />
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
							<select name="country_code" id="country_code" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
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
							<input type="text" name="phoneNumber" value="<?php echo $discount_details['phoneNumber']; ?>" class="form-control chknum1" id="phoneNumber" style="padding-left: 112px;"  />
                            <input type="hidden" name="phoneemail" id="phoneemail" value="" />
							<span class="text-danger chkphone phoneNumber_err"><?php echo form_error('phoneNumber');?></span>	
						</div>
					</div>	
                     <div style="float:left; font-size:16px;">
                     /
                     </div>
                    
                    <div class="col-md-3">
						<div class="form-group has-feedback">
                        <span class="currFrontE">Email</span>
							<input type="text" name="bemail" value="<?php echo $discount_details['bemail']; ?>" class="form-control" id="bemail" style="padding-left: 75px;" />
                           
							<span class="text-danger chkemail bemail_err"><?php echo form_error('bemail');?></span>	
						</div>
					</div>	
                    <div class="col-md-3 upcsv">
                    <select name="leadgroup[]" id="leadgroup" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" disabled="disabled"  data-actions-box="true">
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
						<label for="package_desc" class="control-label"><span class="text-danger">*</span>Template</label>
						<div class="form-group has-feedback">
							<textarea name="template_description" class="form-control myckeditor" id="template_description"></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>
                 </div>   
				</div>
			</div>
            
            <input type="hidden" name="btnCheck" id="btnCheck" value="0" />
           <div class="shide" > 
          	<div class="box-footer gencode">
            	<button type="submit" class="btn btn-danger btndis btnchckval" data-val="0">
            		<i class="fa fa-check"></i> <?php echo GENERATE_LABEL;?>
            	</button>
                
          	</div>
            <div class="box-footer specialid" style="display:none;">
            	<button type="submit" class="btn btn-danger btndis btnchckval" data-val="0" >
            		<i class="fa fa-check"></i> <?php echo GENERATE_SEND_LABEL;?>
            	</button>
                
          	</div>
            
           <div class="specialid" style="display:none;"> 
        <div class="col-md-12" style="margin-top:20px; margin-bottom:30px;">    
          <div class="col-md-4">
						<label for="waiver_type" class="control-label"><span class="text-danger">*</span> Schedule for Later</label>
                       
						<div class="form-group">
                         <div class="col-md-6" style="padding-left:0px;">
							<input type="text" name="schedule_date" value="<?php echo (isset($discount_details['schedule_date']) && $discount_details['schedule_date']!="1970-01-01")?date('d-m-Y',strtotime($discount_details['schedule_date'])):""; ?>" class="noBackDate form-control" id="schedule_date" maxlength="10"/>
							<span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i class="fa fa-birthday-cake"></i></span>
                          </div>
                          <?php
$begin = new DateTime("00:00");
$end   = new DateTime("23:00");

$interval = DateInterval::createFromDateString('1 hour');

$times    = new DatePeriod($begin, $interval, $end);
						  ?>
                          
                          <div class="col-md-6" > 
                           <select name="schedule_time" id="schedule_time" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
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
									$selected = ($b['time_slot'] == $discount_details['schedule_time']) ? ' selected="selected"' : "";
									echo '<option value="'.$b['time_slot'].'" '.$selected.'>'.$b['time_slot'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger schedule_time_err"><?php echo form_error('schedule_time');?></span>
                           
					
                          </div>
                          </div>
                           
                       </div>       
					</div>
                    
                    <div class="box-footer">
            	<button type="submit" class="btn btn-danger btnchckval" data-val="1" style="color:#000; background-color:#FFFF00; font-weight:bold; border:none; padding:10px;">
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

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>



<script type="text/javascript">

$(document).ready(function() {
<?php if(!empty($discount_details['country_id'])) {?>
$("#country_id").change();
<?php }?>
<?php if(!empty($discount_details['type_of_discount'])) {?>
$("#type_of_discount").change();
<?php }?>
<?php if(!empty($discount_details['appliedTestType'])) {?>
$("#appliedTestType").change();
<?php }?>
<?php if(!empty($discount_details['appliedProducts'])) {?>
$('select[name=appliedProducts]').val(<?php echo $discount_details['appliedProducts']?>);
$('#appliedProducts').selectpicker('refresh');
$('#appliedProducts').change();

<?php }?>

$("#frmDiscount").validate({
 ignore: [],
		rules: {

		   "country_id": {
				required: true,

			},
			"start_date": {
				required: true,

			},
			"start_time": {
				required: true,

			},
			"end_date": {
				required: true,

			},
			"end_time": {
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
			"appliedProducts": {
			required: true,
			},
			/*"appliedBranches[]": {
			required: true,
			},*/	
			"no_of_codes":{
			required: function(element){
					if($("#type_of_discount").val()=='Bulk') {
                        return true;
					} else {
						return false;
					}
                }
			
			},	
			"phoneemail":{
			required: function(element){
					if($("#type_of_discount").val()=='Special' && $("#phoneemail").val()=="") {
                        return true;
					} else {
						return false;
					}
                }
			
			},			
			"schedule_date":{
			required: function(element){
					if($("#type_of_discount").val()=='Special' && $("#btnCheck").val()==1) {
                        return true;
					} else {
						return false;
					}
                }
			
			},
			"schedule_time":{
			required: function(element){
					if($("#type_of_discount").val()=='Special' && $("#btnCheck").val()==1) {
                        return true;
					} else {
						return false;
					}
                }
			
			},
						
		},
	errorPlacement: function(error, element) {
    if (element.attr("name") == "country_id" )
        error.insertAfter(".country_id_err");
    else if  (element.attr("name") == "start_time" )
        error.insertAfter(".start_time_err");
	 else if  (element.attr("name") == "end_time" )
        error.insertAfter(".end_time_err");
	 else if  (element.attr("name") == "type_of_discount" )
        error.insertAfter(".type_of_discount_err");
	 else if  (element.attr("name") == "discount_type" )
        error.insertAfter(".discount_type_err");
	 else if  (element.attr("id") == "appliedProducts" )
        error.insertAfter(".appliedProducts_err");	
	/*else if  (element.attr("id") == "appliedBranches" )
        error.insertAfter(".appliedBranches_err");*/
	else if  (element.attr("id") == "schedule_time" )
        error.insertAfter(".schedule_time_err");						
    else
        error.insertAfter(element);
},
	 
		messages: {
			
			country_id:"Please select country",
			start_date:"Please enter start date",
			start_time:"Please select start time",
			end_date:"Please enter start date",
			end_time:"Please select end time",
			disc_name:"Please enter discount name",
			type_of_discount:"Please select type of discount",
			discount_type:"Please select discount type",
			max_discount:"Please enter max discount",
			user_per_code:"Please enter user per code",
			uses_per_user:"Please enter uses per user",
			'appliedProducts':"Please select products",
			//'appliedBranches[]':"Please select branch",
			'no_of_codes':"Please enter number of codes",
			'phoneemail':"Please enter phone number or email",
			'schedule_date':"Please enter schedule date",
			'schedule_time':"Please select schedule time",

			
			
		},
		//perform an AJAX post to ajax.php
		submitHandler: function(form) {
			
			//$("form#frmDiscount" ).submit();
   // return true;
				form.submit();
			}
		
	});
});


	// set default dates
var start = new Date();
// set end date to max one year period:
var end = new Date(new Date().setYear(start.getFullYear()+1));

$('#start_date').datepicker({ 
	format: 'dd-mm-yyyy',
	startDate : start,
    endDate   : end,
	autoclose: true,
    });
 
	
	$("#end_date").datepicker({
       format: 'dd-mm-yyyy',
       autoclose: true,
	   startDate : start,
   		endDate: '+10d'
   })
	

$('#schedule_date').datepicker({ 
	format: 'dd-mm-yyyy',
	startDate : start,
    endDate   : end,
	autoclose: true,
    });	 
	
	
	
		
	  
</script>