<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
				<?php 
                  if($this->Role_model->_has_access_('center_location','list_center_department_')){
                  ?>
                  <a href="<?php echo site_url('adminController/center_location/list_center_department_/'.$center_id); ?>" class="btn btn-danger btn-sm">Department List</a>
				<?php 
				}?>
				<?php 
                  if($this->Role_model->_has_access_('center_location','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/center_location/index/'); ?>" class="btn btn-danger btn-sm">Branch List</a>
				<?php 
				}?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/center_location/add_center_department_/'.$center_id,array('id'=>'department_add_from')); ?>
          	<div class="box-body">
          		<div class="clearfix">
									
					<?php 	
			        $division_id=$this->input->post('division_id');
			        ?>
					<div class="col-md-4">
						<label for="department_name" class="control-label">Division<span class="text-danger">*</span></label>
						<div class="form-group">
						    <select name="division_id[]" id="division_id" class="form-control selectpicker selectpicker-ui-100" onchange="get_department_list()" data-live-search="true"  multiple="multiple" data-actions-box="true">
								<option value="" disabled="disabled">
								Select Division</option>
								<?php foreach($all_division_list as $division){?>
								<option value="<?php echo $division['id']?>" <?php echo $division_id==$division['id'] ? 'selected="selected"':''?>>
								<?php echo $division['division_name']?></option>
								<?php 
								}?>
							</select>						
							<span class="text-danger division_id_error"><?php echo form_error('division_id[]');?></span>
						</div>
					</div>
					<?php 	
			        $department_id=$this->input->post('department_id');
					$user_list=array();
					if(isset($_POST['department_id']) && !empty($division_id)){
						
						$departmentList=$this->Department_model->getDecentralisedDepartmentByDivisionId($division_id);
						$user_list=$this->User_model->getUserListByFunctionalBranchIdAndDivisionId($center_id,$division_id);
					}
			        ?>
					<div class="col-md-4">
						<label for="department_name" class="control-label">Department<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="department_id" id="department_id" class="form-control selectpicker selectpicker-ui-100" data-live-search="true">
								<option value="">
								Select Department</option>
								<?php foreach($departmentList as $department){?>
								<option value="<?php echo $department['id']?>" <?php echo $department_id==$department['id'] ? 'selected="selected"':''?>>
								<?php echo $department['department_name']?></option>
								<?php 
								}?>
							</select>					
							<span class="text-danger department_error"><?php echo form_error('department_id');?></span>
						</div>
					</div>
					<?php 	
			            $department_executive_management_tier=$this->input->post('department_executive_management_tier[]');
			            if(!empty($department_executive_management_tier)){

			            }else{
			            	$department_executive_management_tier=[];
			            }
			        ?>
                    <div class="col-md-4">
						<label for="department_executive_management_tier" class="control-label">Executive Management Tier <span class="text-danger">*</span></label>
						
						<div class="form-group">
					    <select name="department_executive_management_tier[]" id="department_executive_management_tier" class="form-control selectpicker selectpicker-ui-100" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="updateEmployeeList()">
								<option value="" disabled="disabled" >Select Executive Management Tier <span class="text-danger">*</span></option>
								<?php 
								foreach($user_list as $b)
								{
								    $selected='';
									if(in_array($b['id'],$department_executive_management_tier)){
										$selected='selected="selected"';
									}
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
									
								} 
								?>
							</select>
							<span class="text-danger department_executive_management_tier_error"><?php echo form_error('department_executive_management_tier[]');?></span>
						</div>
					</div>
					<?php 	
			            $department_management_tier=$this->input->post('department_management_tier[]');
			            if(!empty($department_management_tier)){

			            }else{
			            	$department_management_tier=[];
			            }
			        ?>
                    <div class="col-md-4">
						<label for="department_management_tier" class="control-label">Department Management Tier <span class="text-danger">*</span></label>
						
						<div class="form-group">
							<select name="department_management_tier[]" id="department_management_tier" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="updateEmployeeList();">
								<option value="" disabled="disabled">Select Department Management Tier</option>
								<?php 
								foreach($user_list as $b)
								{
								    $selected='';
									if(in_array($b['id'],$department_management_tier)){
										$selected='selected="selected"';
									}
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger department_management_tier_error"><?php echo form_error('department_management_tier[]');?></span>
						</div>
					</div>
					<?php 	
			            $department_head=$this->input->post('department_head');
			        ?>
                    <div class="col-md-4">
						<label for="department_head" class="control-label">Department Head <span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="department_head" id="department_head" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select Department Head</option>
								<?php 
								foreach($user_list as $b)
								{
								    if(in_array($b['id'],$department_management_tier)){
										
									$selected='';
									if($department_head==$b['id']){
										$selected='selected="selected"';
									}
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
									}
								}
								?>
							</select>
							<span class="text-danger department_head_error"><?php echo form_error('department_head');?></span>
						</div>
					</div>
					<div class="col-md-12" style="margin-right:10px; margin-bottom:10px;">
					   <button type="button" class="btn btn-sm btn-success" onclick="AddEmployeeTire()"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button><label for="department_management_tier" class="control-label ml-5">Add Employee Tier </label>
					</div>
					<hr>
					<?php 
					 $total_employee_tier=$this->input->post('total_employee_tier');
					?>
					
					<input type="hidden" name="total_employee_tier" id="total_employee_tier" value="<?php echo $total_employee_tier ?>">
					<div id="EmployeeTierId">
					 <!--------Employee Tire List-------->
					    <?php
						$selectEmployeeTrie=array();
						for($i=1; $i<=$total_employee_tier; $i++){
							
							$department_employee_tier=$this->input-> post('department_employee_tier'.$i);
							
							if(!empty($department_employee_tier)){
								
							   $selectEmployeeTrie=array_merge($selectEmployeeTrie,$department_employee_tier);
							}
						}
						
						$selectEmployeeTrie=array_unique($selectEmployeeTrie);
						//pr($selectEmployeeTrie);
						$notEmployeeList=array_merge($department_management_tier,$department_executive_management_tier);
						$notEmployeeList=array_unique($notEmployeeList);
						$selectEmployeeTrie_temp=array();
						$employeeTrie=array();
						
						foreach($user_list as $key =>$val){
							
							if(in_array($key,$selectEmployeeTrie)){
								$selectEmployeeTrie_temp[$key]=$val;
							}
							if(!in_array($key,$notEmployeeList)){
								$employeeTrie[$key]=$val;
							}
							
						}
						$selectEmployeeTrie=$selectEmployeeTrie_temp;
						
					    for($i=1; $i<=$total_employee_tier; $i++){
					        
                             $department_employee_tier=$this->input-> post('department_employee_tier'.$i);
							 //pr($department_employee_tier);
							 $tire_sn=$this->input->post('tire_sn'.$i);
							$tier_title=$this->input->post('tier_title'.$i);
						?>
						<div class="col-md-12" id="employeeTierDiv-<?php echo $i?>">
						<div class="employeeTierDiv">
				   <div class="col-md-2">
						    <div class="form-group">
							<label  class="control-label"> Tier 
							</label>
							<input type="text" class="form-control tire-sn" placeholder="Enter Tier Number"  onfocusout="checkTireNumber($(this))" required=required value="<?php echo $tire_sn?>" name="<?php echo 'tire_sn'.$i?>" id="<?php echo 'tire_sn'.$i?>">
							</div>
				    </div>
					<div class="col-md-4">
									<div class="form-group">
									<label  class="control-label"> Tier Title<span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control tire-title" placeholder="Enter Tier Title"  required="required" maxlength="100"  name="<?php echo 'tier_title'.$i?>" id="<?php echo 'tier_title'.$i?>" value="<?php echo $tier_title?>">
									</div>
				    </div>
					<div class="col-md-4">
						<label  class="control-label">Add Employee </label>
						<div class="form-group">
							<select  class="form-control department_employee_tier selectpicker <?php echo $tire_sn?>" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" name="department_employee_tier<?php echo $i;?>[]" 
								id="department_employee_tier<?php echo $i;?>" onchange="updateEmployeeList()">
								<option value="" disabled="disabled" >Select Employee</option>
								<?php
								
							   
								foreach($employeeTrie as $key=>$b)
								{
					                
										
										$selected='';
					                    if(in_array($b['id'],$department_employee_tier)){
											
											$selected='selected="selected"';
											echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
											
					                    }else if(!array_key_exists($b['id'],$selectEmployeeTrie)){
											
										    echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['employeeCode'].' : '.$b['fname'].' '.$b['lname'].'</option>';
										}
									
								}
								?>
							</select>	
						</div>
					</div>
                    <div class="col-md-2">
						<div class="form-group" style="margin-top: 28px;">
							<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;" onclick="removeEmployeeTire('<?php echo $i?>')">
					        <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
						</div>
					</div>		
					</div>					
				</div>
						<?php 
						}?>
					</div>
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
					</div>
          	</div>
            <?php echo form_close(); ?>
			
			<!---EmployeeTierId Data --->
			<div id="EmployeeTierIdData" style="display:none">
				<div class="col-md-12">
					<div class="employeeTierDiv clearfix">
				    <div class="col-md-2">
						    <div class="form-group">
							<label  class="control-label"> Tier No.<span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control tire-sn" placeholder="Enter Tier Number"  onfocusout="checkTireNumber($(this))" required="required">
							</div>
				    </div>
					<div class="col-md-4">
						    <div class="form-group">
							<label  class="control-label"> Tier Title<span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control tire-title" placeholder="Enter Tier Title" required="required" maxlength="100">
							</div>
				    </div>
					<div class="col-md-4">
					<div class="form-group">
						<label  class="control-label"> Add Employee <span class="text-danger">*</span></label>
						
							<select  class="form-control department_employee_tier" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" required="required">
								<option value="" disabled="disabled">Select Employee</option>
							</select>	
						</div>
					</div>
                    <div class="col-md-2">
						<div class="form-group" style="margin-top: 28px;">
							<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;">
					        <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
						</div>
					</div>						
				</div>
				</div>
			</div>
      	</div>
    </div>
</div>
<?php ob_start();?>
<script>
var employeeList={};
<?php 
if(!empty($user_list)){
?>
  var employeeList=JSON.parse('<?php echo json_encode($user_list)?>');  
<?php
}
?>
var selectedExecutiveManagementTier={};
var selectDepartmentManagementTier={};
var selectDepartmentHead={};
var employeeTrie={};
<?php 
if(!empty($employeeTrie)){
?>
  var employeeTrie=JSON.parse('<?php echo json_encode($employeeTrie)?>');  
<?php
}
?>
var selectEmployeeTrie={};
<?php 
if(!empty($selectEmployeeTrie)){
?>
  var selectEmployeeTrie=JSON.parse('<?php echo json_encode($selectEmployeeTrie)?>');  
<?php
}
?>
var center_id='<?php echo $center_id?>';
function get_department_list(){
	
    selectedExecutiveManagementTier={};
    selectDepartmentManagementTier={};
    selectDepartmentHead={};
	employeeTrie={};
    var selectEmployeeTrie={};
    
    var html='';
	$('.department_error').html('');
	$("#department_executive_management_tier option:selected").each(function(){
		var txt = $(this).text();
		var val = $(this).val();
		selectedExecutiveManagementTier[val]=txt;
	});
	$("#department_management_tier option:selected").each(function(){
		var txt = $(this).text();
		var val = $(this).val();
		selectDepartmentManagementTier[val]=txt;
	});
	var division_id=$("#division_id").val();
	var htmlDepartment ='<option value="">Select Department</option>';
	$('#department_id').html(htmlDepartment);
	var htmlEMT ='<option value="" disabled="disabled">Select Executive Management Tier</option>';
	$('#department_executive_management_tier').html(htmlEMT);
	$('#department_executive_management_tier').selectpicker('refresh');
	var htmlMT ='<option value="" disabled="disabled">Select Department Management Tier</option>';
	$('#department_management_tier').html(htmlMT);
	$('#department_management_tier').selectpicker('refresh');
	employeeList={};
	updateEmployeeList();
    $.ajax({
        url: "<?php echo site_url('adminController/Center_location/ajax_get_department_list');?>",
        async : true,
        type: 'post',
        data: {division_id:division_id,center_id:center_id},
        dataType: 'html',                
        success: function(data){
            var json=JSON.parse(data);
			//set department_list 
            html = '';
            html='<option data-subtext="" value="">Select Department </option>';
			$.each(json.department_list, function( key, value ) {
               html += '<option value='+value.id+' >'+value.department_name+'</option>';
			   
            });
            $('#department_id').html(html);
            $('#department_id').selectpicker('refresh');
			//set Executive Management Tier
			html = '';
            html='<option data-subtext="" value="" disabled="disabled">Select Executive Management Tier </option>';
			$.each(json.user_list, function( key, value ) {
				selected='';
			    if(selectedExecutiveManagementTier.hasOwnProperty(value.id) ==true){
				   
				    selected='selected="selected"';
				}
                html += '<option value='+value.id+' '+selected+'>'+setNameFormate(value)+'</option>';
			    employeeList[value.id]=value;
			    employeeTrie[value.id]=value;
            });
            $('#department_executive_management_tier').html(html);
            $('#department_executive_management_tier').selectpicker('refresh');
			//set Department Management Tier
			html = '';
            html='<option data-subtext="" value="" disabled="disabled">Select Department Management Tier </option>';
			$.each(json.user_list, function( key, value ) {
				var selected='';
				if(selectDepartmentManagementTier.hasOwnProperty(value.id) ==true){
					
						selected='selected="selected"';
				}
                html += '<option value='+value.id+' '+selected+'>'+setNameFormate(value)+'</option>';
            });
            $('#department_management_tier').html(html);
            $('#department_management_tier').selectpicker('refresh');
			updateEmployeeList();
        }
    });
}

function check_department_availibility(){
	$(".department_error").text('');
	department_id=$("#department_id").val();
	old_department_id='';
	if(department_id !='' && center_id!=''){
		
        $(':button[type="submit"]').prop('disabled',true);       
        $.ajax({
            url: "<?php echo site_url('adminController/Center_location/ajax_check_department_availibility');?>",
            type: 'post',
            data: {department_id: department_id,center_id:center_id,'old_department_id':old_department_id},                              
            success: function(response){
				
			    $(':button[type="submit"]').prop('disabled', false);
                if(response.status=='true'){
					
                    $('.department_error').html(response.msg); 					
                }else{
					
                    $('.department_error').html(response.msg)
                    $('#department_id').val('');
					$('#department_id').selectpicker('refresh');
                }                  
            }
        });
    }
}
function updateEmployeeList(){
	
	selectedExecutiveManagementTier={};
	selectDepartmentManagementTier={};
    selectDepartmentHead={};
	employeeTrie={};
	selectEmployeeTrie={};
	$("#department_executive_management_tier option:selected").each(function(){
		var txt = $(this).text();
		var val = $(this).val();
		selectedExecutiveManagementTier[val]=txt;
	});
	
	$("#department_management_tier option:selected").each(function(){
		var txt = $(this).text();
		var val = $(this).val();
		selectDepartmentManagementTier[val]=txt;
	});
	
	$.each(employeeList,function(key,val){
		
	    if(selectedExecutiveManagementTier.hasOwnProperty(key) ==false && selectDepartmentManagementTier.hasOwnProperty(key) ==false){
			employeeTrie[key]=val;
		}
	});
	
	var department_head_selected=$("#department_head option:selected").val();
	$('#department_head').html('');
	html='<option data-subtext="" value="">Select Department Head</option>';
	
    $.each(selectDepartmentManagementTier,function(key,val){
		
        selected='';
        if(key==department_head_selected){
			
			selected='selected="selected"';
		}		
		html +='<option data-subtext="" value="'+key+'" '+selected+'>'+val+'</option>';
	});
	$('#department_head').html(html);
	$('#department_head').selectpicker("refresh");
	var i=1;
	$("#EmployeeTierId .employeeTierDiv").each(function(){
		$(this).find('#department_employee_tier'+i+" option:selected").each(function(){
			var txt = $(this).text();
		    var val = $(this).val();
			selectEmployeeTrie[val]=txt;
	    });
		i++;
	});
	var i=1;
	$("#EmployeeTierId .employeeTierDiv").each(function(){
		var employee_tier_select={};
		$(this).find('#department_employee_tier'+i+" option:selected").each(function(){
			var txt = $(this).text();
		    var val = $(this).val();
		    employee_tier_select[val]=txt;
			
		});
		html='';
		html +='<option value="" disabled="disabled">Select Employee</option>';
		$.each(employeeTrie,function(key,val){
			
			selected='';
			if(employee_tier_select.hasOwnProperty(key) ==true){
				selected='selected="selected"';
				html +='<option data-subtext="" value="'+key+'" '+selected+'>'+setNameFormate(val)+'</option>';
			}else if(selectEmployeeTrie.hasOwnProperty(key) ==false){
				
				html +='<option data-subtext="" value="'+key+'" '+selected+'>'+setNameFormate(val)+'</option>';
			}
		});
		$(this).find('#department_employee_tier'+i).html('');
		$(this).find('#department_employee_tier'+i).html(html);
	    $(this).find('#department_employee_tier'+i).selectpicker("refresh");
		i++;
		
	});
}
function AddEmployeeTire(){
	
		var employeeTierIdDataHtml=$("#EmployeeTierIdData").html();
		i=1;
		$("#EmployeeTierId").append(employeeTierIdDataHtml);
		
		total=$("#EmployeeTierId .employeeTierDiv").length;
		
		$("#EmployeeTierId .employeeTierDiv").each(function(){
			
			$(this).find('.tire-sn').val();
			$(this).find('.tire-sn').attr('name','tire_sn'+i);
			$(this).find('.tire-sn').attr('id','tire_sn'+i);
			$(this).find('.tire-title').attr('name','tier_title'+i);
			$(this).find('.tire-title').attr('id','tier_title'+i);
			$(this).attr('id','employeeTierDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeEmployeeTire("'+i+'")');
			$(this).find('.department_employee_tier').attr('name','department_employee_tier'+i+'[]');
			$(this).find('.department_employee_tier').attr('id','department_employee_tier'+i);
			$(this).find('.department_employee_tier').attr('onchange','updateEmployeeList()');
			
			if(i==total){
				
				html='';
			    html +='<option value="" disabled="disabled">Select Employee</option>';
				
			    var temp={};
			    $.each(employeeTrie,function(key,val){
					
					if(selectEmployeeTrie.hasOwnProperty(key) ==false){
						
					    html +='<option data-subtext="" value="'+key+'">'+setNameFormate(val)+'</option>';
					}
			    });
			    $(this).find('#department_employee_tier'+i).html('');
			    $(this).find('#department_employee_tier'+i).html(html);
			    $(this).find('#department_employee_tier'+i).selectpicker("refresh");
			}
			i++;
		});
		//console.log(employeeTrieIndexBased);
		var length =$("#EmployeeTierId .employeeTierDiv").length;
        $("#total_employee_tier").val(length);
}

function setNameFormate(val){
	
	return val.employeeCode+' : '+val.fname+' '+val.lname;
}
function removeEmployeeTire(j){
	
	$("#employeeTierDiv-"+j).remove();
	var i=1;
	$("#EmployeeTierId .employeeTierDiv").each(function(){
			
			$(this).find('.tire-sn').val();
			$(this).find('.tire-sn').attr('name','tire_sn'+i);
			$(this).find('.tire-sn').attr('id','tire_sn'+i);
			$(this).find('.tire-title').val();
			$(this).find('.tire-title').attr('name','tier_title'+i);
			$(this).find('.tire-title').attr('id','tier_title'+i);
			$(this).attr('id','employeeTierDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeEmployeeTire("'+i+'")');
			$(this).find('.department_employee_tier').attr('name','department_employee_tier'+i+'[]');
			$(this).find('.department_employee_tier').attr('id','department_employee_tier'+i);
			$(this).find('.department_employee_tier').attr('onchange','updateEmployeeList()');
			i++;
	});
	updateEmployeeList();
	var length =$("#EmployeeTierId .employeeTierDiv").length;
	$("#total_employee_tier").val(length);
}
function checkTireNumber(tire_numebr){	
	tire_numebr_val = tire_numebr.val().replace(/[^0-9\.]/g,'');
	if(tire_numebr_val.length==1 && tire_numebr_val==0){
	   tire_numebr_val = tire_numebr.val().replace(/[^1-9\.]/g,'');
	}
	if(tire_numebr_val==''){
		tire_numebr.val(tire_numebr_val);
		return false;
	}
	tire_numebr.val(tire_numebr_val);
	$("#EmployeeTierId .tire-sn").removeClass('cr');
	tire_numebr.addClass("cr");
	total_employee_tier=$("#EmployeeTierId .tire-sn").length;
	//alert(total_employee_tier);
	var allReadyAdd=false;
	$("#EmployeeTierId .tire-sn").each(function(){
		
		cr_tire_numebr=$(this).val();
		if($(this).hasClass('cr')){
			//Cruent Text Boox
        }else{
			    if(tire_numebr_val !='' && cr_tire_numebr==tire_numebr_val){
					tire_numebr.val('');
					allReadyAdd=true;
		        }
		}
	});
	if(allReadyAdd){
		return false;
	}
}

$(document).ready(function() {
	
	$('.selectpicker').selectpicker().change(function(){
        $(this).valid()
    });
    $("#department_add_from").validate({
		ignore: "",
        rules: {
            department_id: {
                required: true,
			    remote:{
					url: WOSA_ADMIN_URL+"center_location/ajax_check_department_availibility",
					type: "post",
					data: {
						department_id: function () {
							return $("#department_id").val();
						},
						center_id:center_id
					}
                },
                maxlength: 50
            },
			'division_id[]':{
				 required: true,
			},
			'department_executive_management_tier[]':{
				required:true, 
			},
			'department_management_tier[]':{
				required:true, 
			},
			'department_executive_management_tier[]':{
				required:true, 
			},
			'department_head':{
				required:true, 
			},
        },
        messages : {
            department_id: {
                required: "Please select department name",
				remote:'Oops! this department already exist in branch,Please try another'
            },
			'division_id[]':{
				 required: 'Please select division name',
			},
			'department_executive_management_tier[]':{
				required: 'Please select executive management tier',
			},
			'department_management_tier[]':{
				required: 'Please select department management tier',
			},
			'department_head':{
				required: 'Please select department head',
			}
			
        },
		errorPlacement: function(error, element) {
		console.log(element.attr("class"));	
		if (element.attr("name") == "division_id[]")
			error.insertAfter(".division_id_error");
		else if (element.attr("name") == "department_id")	
			error.insertAfter(".department_error");
		else if (element.attr("name") == "department_executive_management_tier[]" )
			error.insertAfter(".department_executive_management_tier_error");
		else if  (element.attr("name") == "department_management_tier[]" )
			error.insertAfter(".department_management_tier_error");
		else if  (element.attr("name") == "department_head" )
			error.insertAfter(".department_head_error");
        else if  (element.attr("class") == "department_employee_tier")
			    error.insertAfter(".department_employee_tier");		
		else
			error.insertAfter(element);
	    },
    });
});
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>

