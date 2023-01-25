<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('adminController/contents/add'); ?>" class="btn btn-success btn-sm">Add</a>
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
					    <th>Short Code</th>						
						<th>Title</th>
						<th>Tag</th>
						<th>Description</th>
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
                    foreach($contents as $l){$zero=0;$one=1;$pk='id'; $table='contents';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $l['title']; ?></td>	
						<td><?php echo $l['sub_title']; ?></td>
						<td><?php echo $l['tag']; ?></td>
						<td><?php echo $l['description']; ?></td>
                        <td>
                            <?php 
                            if($l['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$l['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$l['id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <a href="<?php echo site_url('adminController/contents/edit/'.$l['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                            <!-- <a href="<?php echo site_url('adminController/contents/remove/'.$l['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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
