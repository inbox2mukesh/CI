<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
				<?php 
		        if($this->Role_model->_has_access_('center_location','add_center_department_')){
                ?>      
                    <a href="<?php echo site_url('adminController/center_location/add_center_department_/'.$center_id); ?>" class="btn btn-danger btn-sm">Add</a>
				<?php 
				}?>	
				<?php 
                  if($this->Role_model->_has_access_('center_location','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/center_location/index/'); ?>" class="btn btn-danger btn-sm">Branch List</a>
				<?php 
				}?>
                </div>
                <?php echo $this->session->flashdata('flsh_msg'); ?>
            </div>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Division</th>
						<th>Department</th>
                        <th>Executive Management Tier</th> 
                        <th>Department Management Tier</th>
                        <th>Department Head</th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0; foreach($center_department as $t){ 
					$zero=0;
					$one=1;
					$sr++; 
					?>
                    <tr>
                        <td><?php echo $sr; ?></td>	
						<td> <?php echo implode(', ',array_column($t['division_name'],'division_name')); ?>
						</td>
						
						<td><?php echo $t['department_name']; ?></td>                        
                        <td><?php  foreach($t['executive_management_tier_user_list'] as $employee){
							
							echo $employee['employeeCode'].' : '.$employee['fname'].' '.$employee['lname'].', ';
							
						} ?></td>
						 <td><?php  foreach($t['management_tier_user_list'] as $employee){
							echo $employee['employeeCode'].' : '.$employee['fname'].' '.$employee['lname'].', ';
							
						} ?></td>
                        <td><?php echo $t['employeeCode'].' : '.$t['fname'].' '.$t['lname']; ?></td>
                        <td>
						<?php 
		                 if($this->Role_model->_has_access_('center_location','edit_center_department_')){
                        ?> 
                            <a href="<?php echo site_url('adminController/center_location/edit_center_department_/'.$center_id.'/'.$t['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> 
							</a>
							
						 <?php 
						}?>
						<?php 
		                 if($this->Role_model->_has_access_('center_location','view_center_department_')){
                        ?> 
							<a href="<?php echo site_url('adminController/center_location/view_center_department_/'.$t['center_id'].'/'.$t['department_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="View Department"><span class="fa fa-eye"></span> 
							</a>
						 <?php 
						}?>	
							
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                    </div>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>