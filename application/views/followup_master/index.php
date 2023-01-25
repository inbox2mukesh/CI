<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php if($this->Role_model->_has_access_('lead_management','add_followup_status_')){?>
                    <a href="<?php echo site_url('adminController/lead_management/add_followup_status_'); ?>" class="btn btn-danger btn-sm">Add Followup Status</a> <?php } ?>
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>				
						<th>Title</th>
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
                    
                    foreach($followup as $r){$zero=0;$one=1;$pk='id'; $table='followup_master';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>					 
						<td><?php echo $r['title']; ?></td>
                        <td>
                            <?php 
                            if($r['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$r['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$r['id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>  
                        <?php if($this->Role_model->_has_access_('lead_management','edit_followup_status_')){?>                          
                            <a href="<?php echo site_url('adminController/lead_management/edit_followup_status_/'.$r['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>
                            <!-- <a href="<?php echo site_url('adminController/followup/remove/'.$r['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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
