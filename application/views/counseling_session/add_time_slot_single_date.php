<div class="row">
	<input type="hidden" id="prev_session_date_from" value="<?php echo $counseling_session_group['session_date_from']?>">
	<input type="hidden" id="prev_session_date_to" value="<?php echo $counseling_session_group['session_date_to']?>">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                  <a href="<?php echo site_url('adminController/counseling_session/index'); ?>" class="btn btn-danger btn-sm">Counseling Session List</a>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/counseling_session/addTimeSlotSingleDate_/'.$counseling_session_group['id']); ?>
			<?php 	
			    $session_title=$counseling_session_group['session_type'];
				$sessiontypeList=getSessionType();
				
				
				$session_date_from=$counseling_session_group['session_date_from'];
				$session_date_to=$counseling_session_group['session_date_to'];
				
				//pr($counseling_session_group);
				
			?>
          	<div class="box-body">
          		<div class="row clearfix">
					<div class="col-md-4">
						<label for="session_type" class="control-label">Session Type<span class="text-danger">*</span></label>
						<div class="form-group">
						  
						   	<select name="session_title" id="session_title" class="form-control" onchange="checkSessionType()">
						<?php foreach($sessiontypeList as $key=>$val){?>
						<option value="<?php echo $key?>" <?php echo $key==$session_type ? 'selected="selected"':''?>>
						<?php echo $val?></option>
						<?php 
						}?>	
						</select>						
							<span class="text-danger"><?php echo form_error('session_title');?></span>
						</div>
					</div>
					<input type="hidden" value="<?php echo $session_title?>" name="session_title" id="session_title">
                    <?php 
					$session_date=$this->input->post('session_date');
					if(empty($session_date)){
						
						$session_date=$session_date_from.' - '.$session_date_to;
					}
					?>
                    <div class="col-md-4">
						<label for="session_date" class="control-label">Date(from:to)<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="session_date" value="<?php echo $session_date ?>" readonly class="form-control" id="session_date_new"  onchange="updateTimeSlotList()"/>
							<span class="text-danger"><?php echo form_error('session_date');?></span>
							
						</div>
					</div>
					 <div class="col-md-4"  id="amount" >
						<label for="amount" class="control-label">Price<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="amount" value="<?php echo $counseling_session_group['amount']?>" class="form-control" id="amount" onKeyPress="return nochar(event)"/>
							<span class="text-danger"><?php echo form_error('amount');?></span>							
						</div>
					</div>
					<?php 
					 $zoom_link=$this->input->post('zoom_link');
					 if(empty($zoom_link)){
						 
						  $zoom_link=$counseling_session_group['zoom_link'];
					 }
					?>
                    <div class="col-md-4" id="zoomLinkDiv" >
						<label for="zoom_link" class="control-label">Meeting Link<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="zoom_link" value="<?php echo $zoom_link ?>" class="form-control" id="zoom_link" maxlength="150"/>
							<span class="text-danger"><?php echo form_error('zoom_link');?></span>
							
						</div>
					</div>	
					 <!-- <div class="col-md-4"  id="paypal_link" >
						<label for="paypal_link" class="control-label">PayPal Link<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="paypal_link" value="<?php echo $counseling_session_group['paypal_link']?>" class="form-control" id="paypal_link"/>
							<span class="text-danger"><?php echo form_error('paypal_link');?></span>
							
						</div>
					</div>		 -->			
					
				
					<div class="col-md-6">
						<div class="form-group">
							<label for="active" class="control-label">Active</label>
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
						</div>
					</div>
					
					<div class="col-md-12" style="    margin-bottom: 20px;">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddTimeSlot()"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Time Slot </label>
					</div>
					</hr>
					<?php 
					 $total_time_slot=$this->input->post('total_time_slot');
					 if(empty($total_time_slot)){
						 $total_time_slot=1; 
					 }
					?>
					<input type="hidden" name="total_time_slot" id="total_time_slot" value="<?php echo  $total_time_slot?>">
					<div class="col-md-12">
					   <div class="col-md-2">
							<label  class="control-label"> Sn.
							</label>	
						</div>
						<div class="col-md-8">
							<label  class="control-label">
							Time Slot  
							</label>
						</div>
						<div class="col-md-2">
							<label  class="control-label">
							Action  
							</label>
						</div>						
					</div>
					<div id="EmployeeTierId">
					 <!--------Time Slot  List-------->
					    <?php
						
						$selectTimeSlotList=array();
						for($i=1; $i<=$total_time_slot; $i++){
							
							$counseling_session_time_slots=$this->input-> post('counseling_session_time_slots'.$i);
							
							if(!empty($counseling_session_time_slots)){
								
							   $selectTimeSlotList[$counseling_session_time_slots]=$counseling_session_time_slots;
							}
						}
						
						$selectTimeSlotList=array_unique($selectTimeSlotList);
						
						$counseling_session_time_requerd='';
						if(!empty($selectTimeSlotList)){
							
							$counseling_session_time_requerd=1;
						}
						$counseling_session_time_slots=array();
					    for($i=1; $i<=$total_time_slot; $i++){
					        
                            $counseling_session_time_slots=$this->input-> post('counseling_session_time_slots'.$i);
							
							//$active=isset($_POST['active']) ? $this->input->post('active'.$i):1;
							
						?>
							<div class="col-md-12 employeeTierDiv" id="employeeTierDiv-<?php echo $i?>">
								<div class="col-md-2">
										<div class="form-group">
										<label  class="control-label sn"> <?php echo $i?>
										</label>
										</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
	                                    <select  class="form-control counseling_session_time_slots selectpicker"  data-show-subtext="true" data-live-search="true" name="counseling_session_time_slots<?php echo $i;?>" 
	                               id="counseling_session_time_slots<?php echo $i;?>" onchange="updateTimeSlotList()">
	                               <option value="">Select Time Slot</option>
								<?php 
								foreach($time_slots as $key=>$b){
									
								  $selected='';
								  $val=$b['time_slot'].' '.$b['type'];
					              if($val==$counseling_session_time_slots){
											
												$selected='selected="selected"';
												
												echo '<option value="'.$val.'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
												
									}else if(!array_key_exists($val,$selectTimeSlotList)){
										echo '<option value="'.$val.'">'.$b['time_slot'].' '.$b['type'].'</option>';
													
									}
									
								}
											?>
										</select>	
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
									    <?php 
										$class="";
										if($total_time_slot==1){
											
										    $class="none";
										}
										?>
										<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px; display:<?php  echo $class?>" onclick="removeTimeSlot('<?php echo $i?>')">
										<i class="fa fa-minus" aria-hidden="true"></i>
										</button>
										<!--<input type="hidden" class="active-inactive-time-slot active" value="<?php echo $active ?>" name="active"<?php echo $i?>>
										<?php if($active==1){ ?>
										<button type="button" class="btn btn-md btn-success active-time-slot" style="margin-right:10px;" data-toggle="tooltip" data-original-title="Click to De-activate"onclick="activeInactiveTime('<?php echo $i?>','0')">
													<i class="fa fa-check"></i>
												</button>
										<?php 
										}else{ ?>
										   <button type="button" class="btn btn-md btn-success active-time-slot" style="margin-right:10px;" data-toggle="tooltip" data-original-title="Click to Activate" onclick="activeInactiveTime('<?php echo $i?>','1')">
										   <i class="fa fa-close"></i>
										   </button>
										<?php
										}?>-->
									</div>
								</div>						
							</div>
						<?php 
						}?>
					</div>
					<div class="col-md-12">
					<input type="hidden" value="<?php echo $counseling_session_time_requerd?>" id="counseling_session_time_requerd" name="counseling_session_time_requerd">
					<span class="text-danger"><?php echo form_error('counseling_session_time_requerd');?></span>
					</div>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
            <?php echo form_close(); ?>
			<!---EmployeeTierId Data --->
			<div id="EmployeeTierIdData" style="display:none">
				<div class="col-md-12 employeeTierDiv">
				   <div class="col-md-2">
						<div class="form-group">
							<label  class="control-label sn">1</label>
					    </div>
				    </div>
					<div class="col-md-8">
						<div class="form-group">
							<select  class="form-control counseling_session_time_slots" data-show-subtext="true" data-live-search="true">
								<option value="">Select Time Slot</option>
							</select>
						</div>
					</div>
                    <div class="col-md-2">
						<div class="form-group">
							<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;">
					        <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
							<input type="hidden" class="active-inactive-time-slot active" value="1">
							<!--<button type="button" class="btn btn-md btn-success active-time-slot" style="margin-right:10px;" data-toggle="tooltip" data-original-title="Click to De-activate">
					        <i class="fa fa-check"></i>
                            </button>-->
						</div>
					</div>						
				</div>
			</div>
			
      	</div>
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-3.2.1.js');?>"></script>
<script>
    var all_branch={};
	all_branch=JSON.parse('<?php echo json_encode($all_branch)?>'); 
    function checkSessionType(){
		
		session_type=$("#session_type").val();
		if(session_type=='online-demo-session' || session_type=='online-counselling-session'){
			
		    $("#zoomLinkDiv").show();
			 all_branch=JSON.parse('<?php echo json_encode($all_branch_nonphysical)?>'); 
		}else{
			
			$("#zoomLinkDiv").hide();
			 all_branch=JSON.parse('<?php echo json_encode($all_branch_physical)?>'); 
		}
		
		html ='<option value="" disabled="disabled">Select Branch</option>';
		$.each(all_branch,function(key,val){
			
			html +='<option data-subtext="" value="'+val.center_id+'">'+val.center_name+'</option>';
		});
		$('#counseling_session_centers').html('');
		$('#counseling_session_centers').html(html);
	    $('#counseling_session_centers').selectpicker("refresh");
	}
    var allTimeSlotList={};
   <?php 
	if(!empty($time_slots)){
	?>
	  allTimeSlotList=JSON.parse('<?php echo json_encode($time_slots)?>');  
	<?php
	}
    ?>
    <?php 
	if(!empty($selectTimeSlotList)){
		
	?>
	  var selectTimeSlotList=JSON.parse('<?php echo json_encode($selectTimeSlotList)?>');  
	<?php
	}
	?>
	var selectTimeSlotList={};
    var dateBranchTimeSlotList={};
	 <?php 
	if(!empty($dateBranchTimeSlotList)){
	?>
	  var dateBranchTimeSlotList=JSON.parse('<?php echo json_encode($dateBranchTimeSlotList)?>'); 
	  //console.log(dateBranchTimeSlotList); 
	<?php
	}
	?>
    function updateTimeSlotList(){
		
	var total =$("#EmployeeTierId .employeeTierDiv").length;
	var selectTimeSlotList={};
	$("#counseling_session_time_requerd").val('');
	var i=1;
	$("#EmployeeTierId .employeeTierDiv").each(function(){
		
		$(this).find('#counseling_session_time_slots'+i+" option:selected").each(function(){
			
			var txt = $(this).text();
		    var val = $(this).val();
			selectTimeSlotList[txt]=txt;
			if(val !=''){
				
			    $("#counseling_session_time_requerd").val(1);
			}
	    });
		i++;
	});
	
	var selectCentersSlotList={};	
	
	select_session_type=$("#session_title").val();
	
	//alert(select_session_type);
	session_date=$("#session_date_new").val();
	const myArray = session_date.split(" - ");
	//console.log(myArray);
	fromDate=myArray[0];
	toDate=myArray[1];
	fromDate= fromDate.split("-");
	toDate= toDate.split("-");
	console.log(fromDate);
	console.log(toDate);
	const dates = getDates(new Date(fromDate[0], fromDate[1], fromDate[2]), new Date(toDate[0], toDate[1], toDate[2]));

	console.log(dates);
	//console.log(selectCentersSlotList);
	//console.log(dateBranchTimeSlotList);
	AllRedyAddTimeSlotList={};
	console.log(dateBranchTimeSlotList);
	$.each(dateBranchTimeSlotList,function(key,val){
		//console.log(dates);
		
		sdate=val.session_date;
		stime_slot=val.time_slot;
		center_id=val.center_id;
		added_session_type=val.session_type;
		
		//console.log(added_session_type);
		//alert(dates.hasOwnProperty(sdate))
		if(dates.hasOwnProperty(sdate)==true && select_session_type == added_session_type){
			//alert(added_session_type)
			AllRedyAddTimeSlotList[stime_slot]=stime_slot;
		}
		
	})
	//console.log(AllRedyAddTimeSlotList);
	//alert(JSON.stringify(AllRedyAddTimeSlotList))
	var i=1;
	$("#EmployeeTierId .employeeTierDiv").each(function(){
		
		var time_select={};
		$(this).find('#counseling_session_time_slots'+i+" option:selected").each(function(){
			var txt = $(this).text();
		    var val = $(this).val();
		    time_select[txt]=txt;
			
		});
		html='';
		html +='<option value="">Select Time Slot</option>';
		
		$.each(allTimeSlotList,function(key,val){
			
			selected='';
			time_slot_val=val.time_slot+' '+val.type;
			if(AllRedyAddTimeSlotList.hasOwnProperty(time_slot_val)==false){
				
				if(time_select.hasOwnProperty(time_slot_val) ==true){
					
					
					selected='selected="selected"';
					html +='<option data-subtext="" value="'+time_slot_val+'" '+selected+'>'+val.time_slot+' '+val.type+'</option>';
					
				}else if(selectTimeSlotList.hasOwnProperty(time_slot_val) ==false){
					
					html +='<option data-subtext="" value="'+time_slot_val+'" '+selected+'>'+val.time_slot+' '+val.type+'</option>';
				}
			}
			
		});
		$(this).find('#counseling_session_time_slots'+i).html('');
		$(this).find('#counseling_session_time_slots'+i).html(html);
	    $(this).find('#counseling_session_time_slots'+i).selectpicker("refresh");
		
	    if(total==1){
			$(this).find('.remove-div').hide();
		}else{
			$(this).find('.remove-div').show();
		}
		i++;
	});
	var length =$("#EmployeeTierId .employeeTierDiv").length;
	$("#total_time_slot").val(length);
	
    }

	function AddTimeSlot(){
		
		var employeeTierIdDataHtml=$("#EmployeeTierIdData").html();
		$("#EmployeeTierId").append(employeeTierIdDataHtml);
		var total =$("#EmployeeTierId .employeeTierDiv").length;
		i=1;
		console.log(allTimeSlotList);
		$("#EmployeeTierId .employeeTierDiv").each(function(){
			
			$(this).find('.sn').text(i);
			$(this).attr('id','employeeTierDiv-'+i);
			$(this).find('.remove-div').show();
			$(this).find('.remove-div').attr('onclick','removeTimeSlot("'+i+'")');
			$(this).find('.counseling_session_time_slots').attr('name','counseling_session_time_slots'+i);
			$(this).find('.counseling_session_time_slots').attr('id','counseling_session_time_slots'+i);
			$(this).find('.counseling_session_time_slots').attr('onchange','updateTimeSlotList()');
			
			if(i==total){
				
				html='';
			    html +='<option value="">Select Time Slot</option>';
			    var temp={};
			    $.each(allTimeSlotList,function(key,val){
					
					time_slot_val=val.time_slot+' '+val.type;
					if(selectTimeSlotList.hasOwnProperty(time_slot_val) ==false){
						
					    html +='<option data-subtext="" value="'+val.time_slot+'">'+val.time_slot+' '+val.type+'</option>';
					}
			    });
			    $(this).find('#counseling_session_time_slots'+i).html('');
			    $(this).find('#counseling_session_time_slots'+i).html(html);
			    $(this).find('#counseling_session_time_slots'+i).selectpicker("refresh");
			}
			
			if(total==1){
				$(this).find('.remove-div').hide();
			}else{
				
				$(this).find('.remove-div').show();
			}
			i++;
		});
		var length =$("#EmployeeTierId .employeeTierDiv").length;
		$("#total_time_slot").val(length);
	}
	
	function removeTimeSlot(j){
		
		$("#employeeTierDiv-"+j).remove();
		var i=1;
		$("#EmployeeTierId .employeeTierDiv").each(function(){
			
				$(this).find('.sn').text(i);
				$(this).attr('id','employeeTierDiv-'+i);
				$(this).find('.remove-div').attr('onclick','removeTimeSlot("'+i+'")');
				$(this).find('.counseling_session_time_slots').attr('name','counseling_session_time_slots'+i);
				$(this).find('.counseling_session_time_slots').attr('id','counseling_session_time_slots'+i);
				$(this).find('.counseling_session_time_slots').attr('onchange','updateTimeSlotList()');
				i++;
		});
		updateTimeSlotList();
		var length =$("#EmployeeTierId .employeeTierDiv").length;
		$("#total_time_slot").val(length);
	}
	
	function getDates(startDate, endDate) {
		const dates = []
		let currentDate = startDate
		const addDays = function (days) {

			const date = new Date(this.valueOf())
			date.setDate(date.getDate() + days)
			return date
		}
		
		while (currentDate <= endDate) {
			
			y= currentDate.getFullYear();
			m=currentDate.getMonth();
			d=currentDate.getDate();
			if(m <=9){

			m='0'+m;
			}
			if(d <=9){

			d='0'+d;
			}

			newDate=y+'-'+m+'-'+d;  
			//dates.push(newDate)
			dates[newDate]=newDate;
			currentDate = addDays.call(currentDate, 1)
		}
		
		return dates
	}

$(document).ready(function() {
	
	var today = new Date();
	$('#session_date_new').daterangepicker(
	{    
		locale: {
		  format: 'YYYY-MM-DD'
		},
		minDate:"<?php echo $session_date_from?>",
		maxDate:'<?php echo $session_date_to?>',
	}, 
	function(start, end, label) {
		
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
})
</script>
