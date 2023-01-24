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
            <?php echo form_open('adminController/center_location/edit_center_department_/'.$center_id.'/'.$department['id'],array('id'=>'department_add_from')); 
			$department_id=$department['department_id'];
			?>
          	<div class="box-body">
          		<div class="clearfix">
				    <?php 
					   
					    $division_id=array_column($department_division,'division_id');
					?>			
					<div class="col-md-4">
						<label for="department_name" class="control-label">Division<span class="text-danger">*</span></label>
						<div class="form-group">
						<select class="form-control selectpicker selectpicker-ui-100" data-live-search="true"  multiple="multiple" data-actions-box="true" disabled>
								<?php foreach($all_division_list as $division){?>
								<option value="<?php echo $division['id']?>" <?php echo in_array($division['id'],$division_id) ? 'selected="selected"':''?>>
								<?php echo $division['division_name']?></option>
								<?php 
								}?>
							</select>						
							<span class="text-danger"><?php echo form_error('division_id');?></span>
						</div>
					</div>
					<?php 	
				  
					$departmentList=$this->Department_model->getDecentralisedDepartmentByDivisionId($division_id);
			        ?>
					<div class="col-md-4">
						<label for="department_name" class="control-label">Department<span class="text-danger">*</span></label>
						<div class="form-group">
							<select  class="form-control selectpicker selectpicker-ui-100" disabled>
								<option value="">
								Select Department</option>
								<?php foreach($departmentList as $departmentdata){?>
								<option value="<?php echo $departmentdata['id']?>" <?php echo $department_id==$departmentdata['id'] ? 'selected="selected"':''?>>
								<?php echo $departmentdata['department_name']?></option>
								<?php 
								}?>
							</select>
							 <input type="hidden" value="<?php echo $department_id ?>" name="department_id">			
							<span class="text-danger department_error"><?php echo form_error('department_id');?></span>
							
						</div>
					</div>
					<?php 	
			            
				        $department_executive_management_tier=array();
						if(isset($_POST['department_executive_management_tier'])){
							
							$department_executive_management_tier=$this->input->post('department_executive_management_tier[]');
						}
						$selectedExecutiveManagementTier=array_merge($department_executive_management_tier,array_keys($executive_management_tier_user_list));
						$selectedExecutiveManagementTier=array_unique($selectedExecutiveManagementTier);
						
			        ?>
                    <div class="col-md-12">
						<label for="department_executive_management_tier" class="control-label">Executive Management Tier <span class="text-danger">*</span></label>
						<?php
                            $count=count($executive_management_tier_user_list);
							foreach ($executive_management_tier_user_list as $c) {
							if(!empty($c["fname"])){
								
								if($count > 1 && $this->Role_model->_has_access_('center_location','delete_user_center_executive_management_tier_')){
									
							   echo '<button type="button" class="btn btn-success btn-md del" onclick=deleteUserCenterExecutiveManagementTier('.$center_id.','.$c["department_id"].','.$c["id"].')>
               				'.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'<i class="fa fa-close cross-icn"></i></button>';
								}else{
									
								   echo '<button type="button" class="btn btn-md btn-success del">
               				       '.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'</button>';
								}
							}
						}
						?>
						<div class="form-group">
					    <select name="department_executive_management_tier[]" id="department_executive_management_tier" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="updateEmployeeList()" <?php  echo $count==0 ? 'required':''?>>
								<option value="" disabled="disabled">Select Executive Management Tier <span class="text-danger">*</span></option>
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
						$department_management_tier=array();
						if(isset($_POST['department_management_tier'])){
							
							$department_management_tier=$this->input->post('department_management_tier[]');
						}
						
						$selectDepartmentManagementTier=array_merge($department_management_tier,array_keys($management_tier_user_list));
						
						$selectDepartmentManagementTier=array_unique($selectDepartmentManagementTier);
						
			        ?>
                    <div class="col-md-12">
						<label for="department_management_tier" class="control-label">Department Management Tier <span class="text-danger">*</span></label>
						<?php
						   $count=count($management_tier_user_list);
							foreach ($management_tier_user_list as $c) {
								if(!empty($c["fname"])){
									if($count > 1 && $this->Role_model->_has_access_('center_location','delete_user_department_management_tier_')){
										
								    echo '<button type="button" class="btn btn-warning btn-md del" onclick=deleteUserCenterDepartmentManagement('.$center_id.','.$c["department_id"].','.$c["id"].')>
								   '.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'<i class="fa fa-close cross-icn"></i></button>';
								   
									}else{
										 echo '<button type="button" class="btn btn-warning btn-md del">
								        '.$c['employeeCode'].' : '.$c["fname"].' '.$c["lname"].'</button>';
									}
							    }
						    }
						?>
						<div class="form-group">
							<select name="department_management_tier[]" id="department_management_tier" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="updateEmployeeList()" <?php  echo $count==0 ? 'required':''?>>
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
					    if(empty($department_head)){
							
					      $department_head=$department['department_head'];
						}
			        ?>
                    <div class="col-md-12">
						<label for="department_head" class="control-label">Department Head <span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="department_head" id="department_head" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select Department Head</option>
								<?php 
								foreach($user_list as $b)
								{
								    if(in_array($b['id'],$selectDepartmentManagementTier)){
										
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
					<div class="col-md-12">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddEmployeeTire()"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button><label for="department_management_tier" class="control-label">Add Employee Tier </label>
					</div>
					<hr>
					 <?php
					
		             $total_employee_tier=isset($_POST['total_employee_tier']) ? $this->input->post('total_employee_tier'):$department['total_employee_tier'];
						
					
					?>
					<input type="hidden" name="total_employee_tier" id="total_employee_tier" value="<?php echo $total_employee_tier ?>">
					
					<div id="EmployeeTierId">
					   <!--------Employee Tire List-------->
					    <?php
                        $selectEmployeeTrie=array();
						for($i=1; $i<=$total_employee_tier; $i++){
							
							$department_employee_tier=isset($_POST['department_employee_tier'.$i]) ? $this->input->post('department_employee_tier'.$i):$employee_tier_user_ids[$i]['ids'];
							
							if(!empty($department_employee_tier)){
							   $selectEmployeeTrie=array_merge($selectEmployeeTrie,$department_employee_tier);
							}
						}
						$selectEmployeeTrie=array_unique($selectEmployeeTrie);
						//pr($selectEmployeeTrie);
						$notEmployeeList=array_merge($selectedExecutiveManagementTier,$selectDepartmentManagementTier);
						$notEmployeeList=array_unique($notEmployeeList);
						
						$selectEmployeeTrie_temp=$selectedExecutiveManagementTier_temp=$selectDepartmentManagementTier_temp=array();
						$employeeTrie=array();
						
						foreach($user_list as $key =>$val){
							
							if(in_array($key,$selectEmployeeTrie)){
								$selectEmployeeTrie_temp[$key]=$val;
							}
							if(in_array($key,$selectedExecutiveManagementTier)){
								$selectedExecutiveManagementTier_temp[$key]=$val;
							}
							if(in_array($key,$selectDepartmentManagementTier)){
								$selectDepartmentManagementTier_temp[$key]=$val;
							}
							
							if(!in_array($key,$notEmployeeList)){
								$employeeTrie[$key]=$val;
							}
							
						}
						$selectEmployeeTrie=$selectEmployeeTrie_temp;
						$selectedExecutiveManagementTier=$selectedExecutiveManagementTier_temp;
						$selectDepartmentManagementTier=$selectDepartmentManagementTier_temp;
						
					    for($i=1; $i<=$total_employee_tier; $i++){
							  
							$department_employee_tier=isset($_POST['department_employee_tier'.$i]) ? $this->input->post('department_employee_tier'.$i):$employee_tier_user_ids[$i]['ids'];
							
						    $tire_sn=isset($_POST['tire_sn'.$i]) ? $this->input->post('tire_sn'.$i) :$employee_tier_user_ids[$i]['tier'];
							$tier_title=isset($_POST['tier_title'.$i]) ? $this->input->post('tier_title'.$i) :$employee_tier_user_ids[$i]['tier_title'];
							//pr($employee_tier_user_ids);
						?>
						<div class="col-md-12 employeeTierDiv" id="employeeTierDiv-<?php echo $i?>">
						   <div class="col-md-2">
									<div class="form-group">
									<label  class="control-label"> Tier 
									</label>
									<input type="text" class="form-control tire-sn" placeholder="Enter Tier Number"  onkeyup="checkTireNumber($(this))" required=required value="<?php echo $tire_sn?>" name="<?php echo 'tire_sn'.$i?>" id="<?php echo 'tire_sn'.$i?>">
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
								<label  class="control-label">
								 Add Employee  
								</label>
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
								<div class="form-group" style="margin-top: 24px;">
									<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;" onclick="removeEmployeeTire('<?php echo $i?>')">
									<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>						
						</div>
						<?php 
						}?>
						
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
						<label  class="control-label">
						 Add Employee  <span class="text-danger">*</span>
						</label>
						<div class="form-group">
							<select  class="form-control department_employee_tier" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" required="required">
								<option value="" disabled="disabled">Select Employee</option>
							</select>	
						</div>
					</div>
                    <div class="col-md-2">
						<div class="form-group" style="margin-top: 24px;">
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
<?php ob_start();?>
<script>
	function deleteUserCenterExecutiveManagementTier(center_id,department_id,user_id){
		
        $.ajax({
            url: "<?php echo site_url('adminController/Center_location/delete_user_center_executive_management_tier_');?>",

            async : true,

            type: 'post',

            data: {center_id:center_id,department_id: department_id,user_id: user_id},

            dataType: 'json',

            success: function(response){

                if(response==1){

                    window.location.href=window.location.href

                }             

            }

        });

    }
	function deleteUserCenterDepartmentManagement(center_id,department_id,user_id){
		
        $.ajax({
            url: "<?php echo site_url('adminController/Center_location/delete_user_center_department_management_tier_');?>",

            async : true,

            type: 'post',

            data: {center_id:center_id,department_id: department_id,user_id: user_id},

            dataType: 'json',

            success: function(response){

                if(response==1){

                    window.location.href=window.location.href

                }             

            }

        });

    }
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
	
function updateEmployeeList(){
	
	selectedExecutiveManagementTier={};
	<?php 
	if(!empty($executive_management_tier_user_list)){
	?>
	  var selectedExecutiveManagementTier=JSON.parse('<?php echo json_encode($executive_management_tier_user_list)?>');  
	<?php
	}
	?>
	selectDepartmentManagementTier={};
	<?php 
	if(!empty($management_tier_user_list)){
	?>
	  var selectDepartmentManagementTier=JSON.parse('<?php echo json_encode($management_tier_user_list)?>');  
	<?php
	}
	?>
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
	console.log(selectDepartmentManagementTier);
	
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
        if (typeof val === 'object'){
			
			val=setNameFormate(val);
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
	//console.log(selectEmployeeTrie);
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
			$(this).find('.tire-title').val();
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
                maxlength: 50
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
		if (element.attr("name") == "department_id")	
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