<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                        if($this->Role_model->_has_access_('test_module','add')){
                    ?>
                    <a href="<?php echo site_url('adminController/test_module/add'); ?>" class="btn btn-danger btn-sm">Add</a> <?php } ?>
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<th>Course</th>						
						<th>Course desc.</th>
						<th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                     if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                    foreach($test_modules as $p){ $zero=0;$one=1;$pk='test_module_id'; $table='test_module';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $p['test_module_name']; ?></td>	
						<td><?php echo $p['test_module_desc']; ?></td>

                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['test_module_id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['test_module_id'].' data-toggle="tooltip" title="In-active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <?php 
                                if($this->Role_model->_has_access_('test_module','edit')){
                            ?>
                            <a href="<?php echo site_url('adminController/test_module/edit/'.$p['test_module_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                            <?php } ?>
                            <!-- <a href="<?php echo site_url('adminController/test_module/remove/'.$p['test_module_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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