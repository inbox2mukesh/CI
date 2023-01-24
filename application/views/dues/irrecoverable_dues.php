<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>	                       
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/dues/irrecoverable_dues'); ?>
          	<div class="box-body">
          		<div class="clearfix">

          			<div class="col-md-3">
						<label for="center_id" class="control-label"><span class="text-danger">*</span> Branch</label>
						<div class="form-group">
							<select name="center_id[]" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Branch</option>
								<?php 
								foreach($all_branch as $b){	
									if (in_array($b['center_id'], $this->input->post('center_id')))
									{
										$selected ="selected";
									}
									else {
										$selected ="";
									}								
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_id');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="pack_type" class="control-label"><span class="text-danger">*</span> Pack Type</label>
						<div class="form-group">
							<?php 
							/*if($this->input->post('pack_type')=='offline'){
								$offline= 'selected';
								$online= '';
								$practice= '';
								$rt= '';
							}else*/ if($this->input->post('pack_type')=='online'){
								$online= 'selected';
								//$offline= '';
								$practice= '';
								//$rt= '';
							}else if($this->input->post('pack_type')=='practice'){
								$practice= 'selected';
								//$offline= '';
								$online= '';
								//$rt= '';
							}/*else if($this->input->post('pack_type')=='reality test'){
								$rt= 'selected';
								$offline= '';
								$online= '';
								$practice= '';
							}*/else{
								//$offline= '';
								$online= '';
								$practice= '';
								//$rt= '';
							}
							?>
							<select name="pack_type" id="pack_type" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option value="">Select Pack Type</option>
								<!-- <option value="offline" <?php echo $offline;?> >Inhouse pack</option> -->
								<option value="online" <?php echo $online;?> >Online pack</option>
								<option value="practice" <?php echo $practice;?> >Practice pack</option>
								<!-- <option value="reality test" <?php echo $rt;?> >reality test</option> -->
							</select>
							<span class="text-danger"><?php echo form_error('pack_type');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="test_module_id" class="control-label"> Course</label>
						<div class="form-group">
							<select name="test_module_id[]" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple" onchange="reflectPgmBatch(this.value,'irr_dues');">
								<option value="" disabled="disabled">Select Course</option>
								<?php 
								foreach($all_test_module as $t){									
									if (in_array($t['test_module_id'], $this->input->post('test_module_id')))
									{
										$selected ="selected";
									}
									else {
										$selected ="";
									}


									//$selected = ($t['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								}  
								?>
							</select>
						</div>
					</div>
					
					<div class="col-md-3">
						<label for="programe_id" class="control-label">Program</label>
						<div class="form-group">
							<select name="programe_id[]" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Program</option>
								<?php 
								foreach($all_programe_masters as $p){	
									if (in_array($p['programe_id'], $this->input->post('programe_id')))
									{
										$selected ="selected";
									}
									else {
										$selected ="";
									}								
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>	

					 <div class="col-md-12 radiCourse">
						<div class="form-group time-slot" style="margin-bottom:10px">
							<?php 
							if($this->input->post('dateType')==1){
								$checked1= ' checked = "checked" ';
								$checked2= '';
							}else if($this->input->post('dateType')==2){
								$checked1= '';
								$checked2= ' checked = "checked" ';
							}else{
								$checked1= '';
								$checked2= '';
							}
							?>
							<!-- <input type="radio" name="dateType" id="committmentDate" value='1' class='byDate' <?php echo $checked1;?> />
							<label for="committmentDate" class="control-label">Committment Date</label> -->

							<input type="radio" name="dateType" id="sellingDate" value='2' class='byDate' <?php echo $checked2;?> checked="checked"/>
							<label for="sellingDate" class="control-label">By Selling Date</label>
							<span class="text-danger"><?php echo form_error('dateType');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="date_from" class="control-label">From <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="date_from" value="<?php echo $this->input->post('date_from'); ?>" class="form-control input-ui-100 " id="date_from" readonly/><span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="date_to" class="control-label">To <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="date_to" value="<?php echo $this->input->post('date_to'); ?>" class="form-control input-ui-100 " id="date_to"  readonly/><span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>	
					<?php 
						$today = date('d-m-Y');
						$yesterday = date('d-m-Y', strtotime($today. ' - 1 days'));
						$tomarrow  = date('d-m-Y', strtotime($today. ' + 1 days'));
					?>

					<div class="col-md-12">
						<input type="button" class="date_btn <?php if($yesterday == $this->input->post('date_to')){?>tb-active<?php } ?>" name="yesterday" value="Yesterday" onclick="fillCalendar('<?php echo $yesterday;?>')"> &nbsp;
						<input type="button" class="date_btn <?php if($today == $this->input->post('date_to')){?>tb-active<?php } ?>"name="today" value="Today" onclick="fillCalendar('<?php echo $today;?>')"> &nbsp;
						<input type="button" class="date_btn <?php if($tomarrow == $this->input->post('date_to')){?>tb-active<?php } ?>" name="tomarrow" value="Tomorrow" onclick="fillCalendar('<?php echo $tomarrow;?>')"> &nbsp;
					</div>						

				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
            	</button>
						</div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
	<div class="box box-flex-widget">
            <div class="box-header bg-danger">
            	<?php
                       $resultCount = count($irrDuesData);    
                ?>
                <h3 class="box-title text-primary"><?php echo $title;?></h3>  

                <h4 class="box-title text-success float-left"><?php echo '| Searched '.$resultCount.' '.'Result(s)';?></h4>

            </div>
			<div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
						<th>UID</th>
						<th>Name</th>
						<th>Branch</th>
						<th>Package</th> 
						<th>Pack Type</th>                        				
						<th>Irr Dues</th>
                        <th>Selling Date</th>
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                        $sr=0;$totalAmountDue=0;
                        if(count($irrDuesData)>0){
                        foreach($irrDuesData as $sp){$zero=0;$one=1;$pk='student_package_id'; $table='student_package';$sr++;
                        $totalAmountDue +=  $sp['irr_dues']/100;     
                    ?>                     
                    <tr>
						<td><?php echo $sr; ?></td>                        
                        <td><?php echo $sp['UID']; ?></td> 
						<td><?php echo $sp['fname'].' '.$sp['lname']; ?></td>
						<td><?php echo $sp['center_name']; ?></td>
						<td><?php echo @$sp['package_name']; ?></td>
						<td><?php echo $sp['pack_type']; ?></td>
						<td><?php echo CURRENCY.' '. ($sp['irr_dues']/100).'/-'; ?></td>
						<td><?php echo date('M d, Y', $sp['subscribed_on_str']);?></td>					
						<td>
	                        <a href="<?php echo site_url('adminController/student/edit/'.base64_encode($sp['id'])); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Manage Student"><span class="fa fa-user"></span></a>
	                        
	                        <?php if($sp['pack_type']=='offline' or $sp['pack_type']=='online'){ ?>
	                            <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/'.$sp['student_package_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>

	                        <?php }elseif($sp['pack_type']=='practice'){ ?>
	                        	<a href="<?php echo site_url('adminController/student/adjust_practice_pack_/'.$sp['student_package_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>

	                        <?php }elseif($sp['pack_type']=='reality test'){ ?>
	                        	<a href="<?php echo site_url('adminController/student/adjust_reality_test_/'.$sp['student_package_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
	                    	<?php }else{} ?>                    	
                        </td>
                    
                    </tr>
                    <?php }} ?>
                </tbody>
                </table>
			</div>
                <?php if($totalAmountDue>0){ ?>
                <div class="pull-right bg-warning"><h5 class="text-success"><?php echo 'Total Sum of Dues is '.CURRENCY.' '.$totalAmountDue.'/-';?></h5></div>
            	<?php }else{ $totalAmountDue=0.00; ?>
            		<div class="pull-right bg-warning"><h5 class="text-success"><?php echo 'Total Sum of Dues is '.CURRENCY.' '.$totalAmountDue.'/-';?></h5></div>
            	<?php } ?>

                 <div class="pull-right">
                    <?php //echo $this->pagination->create_links(); ?>                    
                </div>              
            </div>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<script>


  $("#date_from").datepicker({format: 'dd-mm-yyyy',
    onSelect: function(dateText) {
    // alert("sel")
    }
  }).on("change", function() {
	$("#date_to").val(""); 
	$("#date_to").datepicker("destroy"); 
	$("#date_to").datepicker({
				startDate: this.value,
				//endDate: enddate,
			}); 		
  }); 
	
	 function fillCalendar(value){
		$('.date_btn').removeClass('tb-active');
		$('#date_to').val(value);
		$('#date_from').val(value)
	} 
</script>
<?php global $customJs;
	$customJs = ob_get_clean();
	?>