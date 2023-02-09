<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
margin-bottom: 5px;
}

.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}
</style>

<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
				<div class="box-tools pull-right">
                  <a href="<?php echo site_url('adminController/counseling_session/index'); ?>" class="btn btn-danger btn-sm">Counseling Session List</a>
				  <a href="<?php echo site_url('adminController/counseling_session/view_details_/'.$counseling_session['counseling_sessions_group_id']); ?>" class="btn btn-danger btn-sm">Back</a>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/counseling_session/edit/'.$counseling_session['id']); ?>
		    <?php				
			   
					
				$session_type=$counseling_session['session_type'];
				
				$counseling_session_id=$counseling_session['id'];
				
			?>			
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-4">
						<label for="session_type" class="control-label">Session Type<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="session_title" id="session_title" value="<?php echo $session_type?>" class="form-control" readonly disabled/>					
							<span class="text-danger"><?php echo form_error('session_type');?></span>
						</div>
					</div>
					<?php 
				        $session_date=$counseling_session['session_date'];
					?>
                    <div class="col-md-4">
						<label for="session_date" class="control-label">Date <span class="text-danger">*</span></label>
						<div class="form-group has-feedback">
							<input type="text" name="session_date_old" readonly value="<?php echo date('d-m-Y',strtotime($session_date)) ?>" class="has-datepicker form-control" id="session_date_old" maxlength="10" disabled />
							<span class="glyphicon form-control-feedback"><i class="fa fa-calendar"></i></span>
							<span class="text-danger"><?php echo form_error('session_date');?></span>
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $session_date?>" name="session_date" id="session_date_new">
					<input type="hidden" value="<?php echo $counseling_session['session_type']?>" name="session_title" id="session_title">
					<?php 
					$zoom_link=$this->input->post('zoom_link');
					$amount=$counseling_session['amount'];
					$paypal_link=$counseling_session['paypal_link'];
					if(empty($zoom_link)){
						$zoom_link=$counseling_session['zoom_link'];
					}
					?>
					  <div class="col-md-4"  id="amount" >
						<label for="amount" class="control-label">Price<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="amount" value="<?php echo $amount ?>" class="form-control" id="amount" onKeyPress="return nochar(event)" maxlength="5"/>
							<span class="text-danger"><?php echo form_error('amount');?></span>
							
						</div>
					</div>
					<?php if($session_type == "online") {?>
                    <div class="col-md-4"  id="zoomLinkDiv" >
						<label for="zoom_link" class="control-label">Meeting Link<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="zoom_link" value="<?php echo $zoom_link ?>" class="form-control validate_url" id="zoom_link"/>
							<span class="text-danger zoom_link_err"><?php echo form_error('zoom_link');?></span>
							
						</div>
					</div>
					<?php }?>
					<div class="col-md-4" id="duration" >
						<label for="duration" class="control-label">Duration(In Minutes)<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="duration" value="<?php echo $counseling_session['duration'] ?>" class="form-control" id="duration" maxlength="3"/>
							<span class="text-danger"><?php echo form_error('duration');?></span>
							
						</div>
					</div>		
					 <!-- <div class="col-md-4"  id="paypal_link" >
						<label for="paypal_link" class="control-label">PayPal Link<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="paypal_link" value="<?php //echo $paypal_link ?>" class="form-control" id="paypal_link"/>
							<span class="text-danger"><?php //echo form_error('paypal_link');?></span>
							
						</div>
					</div>				
					 -->
				
                    
					<?php
					//echo $counseling_session['time_slot'];
					   $counseling_session_time_slot=$this->input->post('counseling_session_time_slot');
					   if(empty($counseling_session_time_slot)){
						 
				          $counseling_session_time_slot=$counseling_session['time_slot'];
					    }
					 ?>
                    <div class="col-md-4">
					   <label for="branch" class="control-label">Time Slot<span class="text-danger">*</span></label>
						<div class="form-group">
	                            <select  class="form-control counseling_session_time_slots selectpicker"  data-show-subtext="true" data-live-search="true" name="counseling_session_time_slot" 
	                               id="counseling_session_time_slot" onchange="updateTimeSlotList()">
	                               <option value="">Select Time Slot  </option>
								<?php 
								foreach($time_slots as $key=>$b){
								    $selected='';
								    $val=$b['time_slot'].' '.$b['type'];
					                if($val==$counseling_session_time_slot){
											
												echo $selected='selected';
												
												
												
									}
									echo '<option value="'.$val.'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								}
								?>
								</select>
					    <span class="text-danger">
							<?php echo form_error('counseling_session_time_slot');?>		
						</span>
					    </div>
                    </div>							
					<div class="col-md-6">
						<div class="form-group">
							<label for="active" class="control-label">Active</label>
							<input type="checkbox" name="active" value="1" <?php echo ($counseling_session['active']==1 ? 'checked="checked"' : ''); ?> id='active'/>	
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>

 <?php
    $counseling_session_center_list=array_keys($counseling_session_center_list);
 ?>
<script src="<?php echo base_url('resources/js/jquery-3.2.1.js');?>"></script>
<script>
    var allTimeSlotList={};
   <?php 
	if(!empty($time_slots)){
	?>
	  allTimeSlotList=JSON.parse('<?php echo json_encode($time_slots)?>');  
	<?php
	}
    ?>
	var dateBranchTimeSlotList={};
	 <?php 
	if(!empty($dateBranchTimeSlotList)){
	?>
	  var dateBranchTimeSlotList=JSON.parse('<?php echo json_encode($dateBranchTimeSlotList)?>');  
	<?php
	}
	?>
    updateTimeSlotList();
    function updateTimeSlotList(){
		
		counseling_session_id='<?php echo $counseling_session_id?>';
		
	    var selectCentersSlotList={};
		counseling_session_center_list={};
		counseling_session_center_list=JSON.parse('<?php echo json_encode($counseling_session_center_list)?>');
		//console.log(counseling_session_center_list);
		
		$.each(counseling_session_center_list,function(key,val){
			//console.log(key);
			selectCentersSlotList[val]=val;
		})
		
		$('#counseling_session_centers option:selected').each(function(){
				
				var txt = $(this).text();
				var val = $(this).val();
				selectCentersSlotList[val]=val;
				
		});
		select_session_type=$("#session_title").val();
		//alert(select_session_type)
		session_date=$("#session_date_new").val();
		dates={};
		dates[session_date]=session_date;
		AllRedyAddTimeSlotList={};
		/*$.each(dateBranchTimeSlotList,function(key,val){
			
			sdate=val.session_date;
			stime_slot=val.time_slot;
			center_id=val.center_id;
			select_counseling_session_id=val.id;
			
			added_session_type=val.session_type;

			if(dates.hasOwnProperty(sdate)==false && select_session_type == added_session_type && counseling_session_id != select_counseling_session_id){
				//alert(dates.hasOwnProperty(sdate))
				AllRedyAddTimeSlotList[stime_slot]=stime_slot;
			}
		})
		  */
            			
			var counseling_session_time_slot=$('#counseling_session_time_slot').val();
			//alert(counseling_session_time_slot)
			html='';
			html +='<option value="">Select Time Slot</option>';
			
			$.each(allTimeSlotList,function(key,val){
				
				selected='';
				time_slot_val=val.time_slot+' '+val.type;
				
				if(AllRedyAddTimeSlotList.hasOwnProperty(time_slot_val)==false){

					if(counseling_session_time_slot==time_slot_val)
					{	
						
						
						selected='selected';
						html +='<option data-subtext="" value="'+time_slot_val+'" '+selected+'>'+val.time_slot+' '+val.type+'</option>';
						
					}else {
						
						html +='<option data-subtext="" value="'+time_slot_val+'" '+selected+'>'+val.time_slot+' '+val.type+' </option>';
					}
				}
				
			});
			
			$('#counseling_session_time_slot').html('');
			$('#counseling_session_time_slot').html(html);
			//$('#counseling_session_time_slot').selectpicker("refresh");
	  
    }
	
    function deleteCounselingSessionCourse(counseling_session_id,course_id){
        $.ajax({
            url: "<?php echo site_url('adminController/Counseling_session/ajax_delete_counseling_session_course');?>",
            async : true,
            type: 'post',
            data: {counseling_session_id:counseling_session_id, course_id:course_id},
            dataType: 'json',
            success: function(response){
                if(response==1){
                    window.location.href=window.location.href
                }             
            }
        });
    }
	function deleteCounselingSessionCenter(counseling_session_id,center_id){
		
        $.ajax({
            url: "<?php echo site_url('adminController/Counseling_session/ajax_delete_counseling_session_center');?>",
            async : true,
            type: 'post',
            data: {counseling_session_id: counseling_session_id,center_id:center_id},
            dataType: 'json',
            success: function(response){
                if(response==1){
                    window.location.href=window.location.href
                }             
            }
        });
    }
</script>