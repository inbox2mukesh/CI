
<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <div class="box-tools">
                    <?php 
                        if($this->Role_model->_has_access_('mock_test','upload_mock_test')){
                    ?>
                    <a href="<?php echo site_url('adminController/mock_test/upload_mock_test'); ?>" class="btn btn-danger btn-sm">Upload Mock Test Report</a><?php }?>
                </div> 
            </div>
            <div class="col-md-12">  <?php echo $this->session->flashdata('flsh_msg');?> </div> 
                <div class="col-md-12 table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                <table class="table table-striped table-bordered table-sm">

                    <thead>
                        <tr>     
                        <th><?php echo SR;?></th>                         
                        <th>Test Module</th>
                        <th>Program</th> 
                        <th>Title</th>                                                
                        <th><?php echo STATUS;?></th>
                        <th class='noPrint'><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0; foreach($all_rt_csv as $t){ $zero=0;$one=1;$pk='id'; $table='reality_test_report_masters';$sr++; ?>

                    <tr> 
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $t['test_module_name'];?></td>
                        <td><?php echo $t['programe_name'];?></td>
                        <td><?php echo $t['title'];?></td>
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
                        <?php 
                            if($this->Role_model->_has_access_('mock_test','remove_mock_test_report_CSV_')){
                            ?>                           
                                <a href="<?php echo site_url('adminController/mock_test/remove_mock_test_report_CSV_/'.$t['id'].'/'.$t['test_module_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>
                            <?php }?>
                            <?php 
                                if($this->Role_model->_has_access_('mock_test','ViewUploadedReport_')){
                            ?>
                                <a href="<?php echo site_url('adminController/mock_test/ViewUploadedReport_/'.$t['id'].'/'.$t['test_module_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="View Report" ><span class="fa fa-eye"></span> </a>
                            <?php }?>
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
<!-- list view of all test series ends-->

