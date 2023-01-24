<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>                 
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="col-md-12 table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                        <th class='noPrint'><?php echo ACTION;?></th>     
                        <th><?php echo SR;?></th>
                        <th>Test Taker ID</th> 
                        <th>Registration ID</th> 
                        <th>Test Centre ID</th>   
                        <th>Test Date</th>                                 
                        <th>Report Date</th>
                        <th>OA</th>
                        <th>L</th>                       
                        <th>R</th>
                        <th>W</th>                        
                        <th>S</th>
                        <th>GR</th>
                        <th>OF</th>
                        <th>PR</th>
                        <th>SP</th>
                        <th>VO</th>
                        <th>WD</th>
                      
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                    if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                    
                    
                    foreach($report as $t){ $zero=0;$one=1;$pk='id'; $table='mock_test_report_pte';$sr++; ?>
                    <tr>
                    <td class='noPrint'>
                            <?php
                                if($this->Role_model->_has_access_('mock_test','edit_pte_report_')){
                            ?>
                            <a href="<?php echo site_url('adminController/mock_test/edit_pte_report_/'.$t['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Report"><span class="fa fa-pencil"></span></a><?php } ?>
                        </td> 
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $t['Test_Taker_ID'];?></td>
                        <td><?php echo $t['Registration_ID'];?></td>
                        <td><?php echo $t['Test_Centre_ID'];?></td> 
                        <td><?php echo $t['Date_of_Test'];?></td>
                        <td><?php echo $t['Date_of_Report'];?></td>                   
                        <td><?php echo $t['oa'];?></td>
                        <td><?php echo $t['listening'];?></td>
                        <td><?php echo $t['reading'];?></td>                      
                        <td><?php echo $t['writing'];?></td>
                        <td><?php echo $t['speaking'];?></td>
                        <td><?php echo $t['gr'];?></td>
                        <td><?php echo $t['of'];?></td> 
                        <td><?php echo $t['pr'];?></td>
                        <td><?php echo $t['sp'];?></td>
                        <td><?php echo $t['vo'];?></td>
                        <td><?php echo $t['wd'];?></td>
                       
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
<!-- list view of all test series ends-->

