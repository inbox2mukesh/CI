<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                        if($this->Role_model->_has_access_('classroom_documents','add')){
                    ?>
                    <a href="<?php echo site_url('adminController/classroom_documents/add'); ?>" class="btn btn-danger btn-sm">Add</a> <?php } ?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>

            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<th>Classroom</th>
						<th>Content Type</th>
						<th>Documents Title</th>
						<th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                    if(!empty($classroom_docs))
                    {
					if(!empty($this->input->get('per_page'))){
                        $sr=$this->input->get('per_page');
                    }else{
                        $sr=0;
                    }
					foreach($classroom_docs as $p){ 
    					$zero=0;
    					$one=1;
    					$pk='id'; 
    					$table='classroom_documents';
    					$sr++;
					?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $p['classroom_name'];?>
						</td>
						<td><?php 
                        $content_type_name="";
						foreach($p['classroom_documents_content_type'] as $key=>$val){
							
							$content_type_name .= $val['content_type_name'].', ';
						}                        
                        echo rtrim($content_type_name,', ');
						?>
                        
						</td>
						 <td><?php echo $p['title']; ?></td>
                        <td>
                            <?php 
							#pr($p);
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$p['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$p['id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <a href="<?php echo site_url('adminController/classroom_documents/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
							<a href="<?php echo site_url('adminController/classroom_documents/view_document_details_/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span> </a> 
							
                            <!--<a href="<?php echo site_url('adminController/classroom_documents/remove/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>-->
                        </td>
                    </tr>
                    <?php } } else {?>
                        <tr><td colspan="6">No Doc Found</td></tr>
                    <?php }?>
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
</div>