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
                    if($this->Role_model->_has_access_('center_location','list_center_department_/'.$center_id)){
                ?>
                  <a href="<?php echo site_url('adminController/center_location/list_center_department_/'.$center_id); ?>" class="btn btn-danger btn-sm">Department List
				  </a>
				<?php 
				}?> 
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
          	<div class="box-body">
			<?php
				$executive_management_tier_user_list=$center_department['executive_management_tier_user_list'];
				$management_tier_user_list=$center_department['management_tier_user_list'];
				$management_tier_user_list=$center_department['management_tier_user_list'];
				$employee_tier=$center_department['employee_tier'];
				$department_head_name=$department["employeeCode"].' : '.$center_department['fname'].' '.$department['lname'];
				$department_id=$center_department['department_id'];
				$id=$department['id'];
				$department_head=$center_department['department_head'];
				$department_division=$center_department['department_division'];
				?>
          		<div class="row clearfix">		
					<div class="col-md-4">
						<label for="department_name" class="control-label">Division:<b><?php echo $department['division_name']?></b>
						</label>
						<div class="form-group">
	                      <?php 
						   foreach ($department_division as $c) {
							echo '<button type="button" class="btn  btn-md btn-success del">
               				'.$c["division_name"].'</button>';
						   }
						   ?>
						</div>
					</div>
					
					<div class="col-md-4">
						<label for="department_name" class="control-label">Department:<?php echo $department['department_name']?></label>
						<div class="form-group">
	
						</div>
					</div>
                    <div class="col-md-12">
						<label for="department_executive_management_tier" class="control-label">Executive Management Tier :</label>
						
						<?php 
						foreach ($executive_management_tier_user_list as $c) {
							echo '<button type="button" class="btn btn-success btn-md del">
               				'.$c["employeeCode"].' : '.$c["fname"].' '.$c["lname"].'</button>';
						}
						?>
						<div class="form-group">
	
						</div>
					</div>
                    <div class="col-md-12">
						<label for="department_management_tier" class="control-label">Department Management Tier :</label>
						<?php
							foreach ($management_tier_user_list as $c) {
							echo '<button type="button" class="btn-warning btn-sm del">
               				'.$c["employeeCode"].' : '.$c["fname"].' '.$c["lname"].'</button>';
						 } ?>
						<div class="form-group">
						</div>
					</div>
                    <div class="col-md-12">
						<label for="department_head" class="control-label">Department Head :<?php echo !empty($department_head)  ? '<button type="button" class="btn-primary btn-sm del">
               				'. $department_head_name.'</button>':'';?></label>
						<div class="form-group">
						</div>
					</div>
					<div class="col-md-12">
					   
					    <label for="department_management_tier" class="control-label">Employee Tier:</label>
					   
					   <div class="row">
							<div class="col-md-2 employeeTierDiv">
							 <label  class="control-label"> Tier No.</label>
							</div>
							<div class="col-md-2 employeeTierDiv">
							 <label  class="control-label"> Tier Title</label>
							</div>
							<div class="col-md-6 employeeTierDiv">
							 <label  class="control-label"> Employee Name</label>
							</div>
						</div>
						<?php 
						foreach($employee_tier as $key=>$val){
						?>
						<div class="row">
							<div class="col-md-2">
							 <label  class="control-label"> <?php echo $val['tier'];?></label>
							</div>
							<div class="col-md-2 ">
							 <label  class="control-label"> <?php echo $val['tier_title'];?></label>
							</div>
							<div class="col-md-8">
							 <label  class="control-label"> 
									<?php 
				echo '<button type="button" class="btn btn-info btn-md del">'.$val["employeeCode"].' : '.$val["fname"].' '.$val["lname"].'</button>';
							?>
							 </label>
							</div>
						</div>	
						<?php 
						}?>
					</div>
					
					</div>
			</div>
      	</div>
    </div>
</div>