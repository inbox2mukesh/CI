<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                  <?php 
                  if($this->Role_model->_has_access_('center_location','add')){
                  ?>
                    <a href="<?php echo site_url('adminController/center_location/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                <?php }?>
                </div>
              
            </div>
            <div><?php echo $this->session->flashdata('flsh_msg'); ?></div>
           
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th><?php echo STATUS;?></th>
                        <th width="14%"><?php echo ACTION;?></th>
                        <th>Branch name</th>
                        <th>Code</th>
						<th>Physical?</th>
                        <th>Overseas?</th>
                        <th>Divisions</th>
                        <th>Contact</th> 
                        <th>Email</th>
                        <th>State</th>
                        <th>City</th>                                             
                        
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                    if(!empty($this->input->get('per_page'))){
                        $sr=$this->input->get('per_page');    
                    }else{    
                        $sr=0;    
                    }
                    foreach($center_location as $t){ $zero=0;$one=1;$pk='center_id'; $table='center_location';$sr++; 
                    ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
                        <td>
                            <?php 
                            if($t['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$t['center_id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$t['center_id'].' data-toggle="tooltip" title="De-Active">'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>              
                       
                        <td>
                        <?php 
                            if($this->Role_model->_has_access_('center_location','view_branch_details')){
                        ?>
                            <a href="<?php echo site_url('adminController/center_location/view_branch_details/'.$t['center_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="view branch Details"><span class="fa fa-eye"></span> </a>
                        <?php }?>

                        <?php 
                            if($this->Role_model->_has_access_('center_location','edit')){
                        ?>
                            <a href="<?php echo site_url('adminController/center_location/edit/'.$t['center_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                        <?php }?>

                        <!-- <?php 
                            if($this->Role_model->_has_access_('center_location','Generate_QR_Code_')){
                        ?>
                            <a href="<?php echo site_url('adminController/center_location/Generate_QR_Code_/'.$t['center_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Generate QR code"><span class="fa fa-qrcode"></span> </a> 
                        <?php }?> -->

                            <!-- <a href="<?php echo site_url(QR_CODE_PATH.$t['center_name'].'.png'); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Download QR code"><span class="fa fa-download"></span> </a> -->                             
                        <!-- <?php 
                            if($this->Role_model->_has_access_('center_location','add_center_department_')){
                        ?>
                            <a href="<?php echo site_url('adminController/center_location/add_center_department_/'.$t['center_id']); ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Department"><span class="fa fa-plus"></span> 
                            </a>
                        <?php }?> -->
                        <!-- <?php 
                            if($this->Role_model->_has_access_('center_location','list_center_department_')){
                        ?>
                            <a href="<?php echo site_url('adminController/center_location/list_center_department_/'.$t['center_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Department List"><span class="fa fa-building-o"></span></a>
                        <?php } ?> -->        
                        </td>	
						<td><?php echo $t['center_name']; ?></td>
                        <td><?php echo $t['center_code']; ?></td>
						<td><?php echo $t['physical_branch']==1 ? 'Yes':'No'; ?></td>
                        <td><?php echo $t['is_overseas']==1 ? 'Yes':'No'; ?></td>
                        <td>
                        <?php 
                            foreach ($t['centerDivisions'] as $cd) {
                                echo $division_name = $cd['division_name'].', ';
                            }
                        ?>                            
                        </td> 
						<td><?php echo $t['contact']; ?></td>                        
                        <td><?php echo $t['email']; ?></td>
                        <td><?php echo $t['state_name']; ?></td> 
                        <td><?php echo $t['city_name']; ?></td>                  

                        
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