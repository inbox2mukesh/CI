<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<!-- <div class="box-tools">
                    <button class="btn btn-default" onclick="printDiv('printableArea')">
                    <i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button> 
                </div> -->
                <?php echo $this->session->flashdata('flsh_msg');?>
            </div>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Pic</th>
                        <th>Student's Status</th>
                        <th>Name</th>				
						<th>Gender</th>
                        <th>DOB</th>						
						<th><?php echo STATUS;?></th>
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($classroom_students as $s){$zero=0;$one=1;$pk='id'; $table='students';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td>
                            <img src="<?php echo base_url($s['profile_pic']);?>" style="width:50px;height:40px;">                                
                        </td>
                        <td>
                            <?php
                            if($s['student_identity']!='') {
                                echo $s['student_identity'].'-'.$s['UID']; 
                            }else{
                                echo $s['UID']; 
                            }
                            
                            ?>                                
                        </td>
                        <td><?php echo $s['fname'].' '.$s['lname']; ?></td>
						<td><?php echo $s['gender_name']; ?></td>
                        <td><?php echo $s['dob']; ?></td>						
						<td>
                            <?php                         

                            if($s['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>  
						<td class="noPrint">
                            <?php
                                if($this->Role_model->_has_access_('student','student_full_details_')){
                            ?>
                                <a href="<?php echo site_url('adminController/student/student_full_details_/'.base64_encode($s['id'])); ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Full Details"><span class="fa fa-eye"></span> </a><?php } ?>
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