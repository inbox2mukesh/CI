<script type="text/javascript" src="<?php echo base_url('resources/js/jquery-3.2.1.js');?>"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('adminController/mock_test/add'); ?>" class="btn btn-danger btn-sm">Add</a>
                     <a href="<?php echo site_url('adminController/mock_test/index'); ?>" class="btn btn-success btn-sm">ALL Reality Tests</a>
                    <?php foreach ($all_testModule as $t) { $test_module_id=  $t['test_module_id'];?>
                        <a href="<?php echo site_url('adminController/mock_test/index/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
                    <?php } ?>
                     <a href="<?php echo site_url('adminController/mock_test/search_mock_test'); ?>" class="btn btn-warning btn-sm">Search</a>
                     <button class="btn btn-default" onclick="printDiv('printableArea')">
                    <i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button>
                </div> 
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="box-body table-responsive" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>     
                        <th><?php echo SR;?></th>
                        <th>Title</th> 
                        <th>Test Module</th> 
                        <th>Program</th>   
                        <th>Branch</th>                                 
                        <th>Test dates</th>
                        <th>Time Slot1</th>
                        <th>Time Slot2</th>                       
                        <th>Time Slot3</th>
                        <th>Seats</th>                        
                        <th>Venue</th>
                        <th>Booking Price (in Rs.)</th>                        
                        <th><?php echo STATUS;?></th>
                        <th class='noPrint'><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                     if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                    
                    foreach($mock_test as $t){ $zero=0;$one=1;$pk='id'; $table='real_test_dates';$sr++; ?>

                    <tr> 
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $t['title'];?></td>
                        <td><?php echo $t['test_module_name'];?></td>
                        <td><?php echo $t['programe_name'];?></td> 
                        <td><?php echo $t['center_name'];?></td>                       
                        <td>
                            <?php
                                $date=date_create($t['date']);
                                echo $date = date_format($date,"M d, Y");
                            ?>                            
                        </td>
                        <td>
                            <?php 
                                if($t['time_slot1']){
                                    echo $t['time_slot1'];
                                }else{
                                    echo NA;
                                }
                            ?>                                
                        </td>

                        <td>
                            <?php 
                                if($t['time_slot2']){
                                    echo $t['time_slot2'];
                                }else{
                                    echo NA;
                                }
                            ?>                                
                        </td> 

                        <td>
                            <?php 
                                if($t['time_slot3']){
                                    echo $t['time_slot3'];
                                }else{
                                    echo NA;
                                }
                            ?>                                
                        </td>    
                        <td><?php echo $t['seats'];?></td>                   
                        <td><?php echo $t['venue'];?></td>
                        <td><?php echo $t['amount'];?></td>                      
                       
                        <td>
                            <?php 
                            if($t['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$t['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$t['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$t['id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$t['id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                 
                        </td> 
                        <td class='noPrint'>
                            <a href="<?php echo site_url('adminController/mock_test/edit/'.$t['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Realty test"><span class="fa fa-pencil"></span></a> 
                            <!-- <a href="<?php echo site_url('adminController/mock_test/remove/'.$t['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>                
            </div>
        </div>
    </div>
</div>
<!-- list view of all test series ends-->

