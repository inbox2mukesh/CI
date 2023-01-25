<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php if($this->Role_model->_has_access_('video','add')){?>
                        <a href="<?php echo site_url('adminController/video/add'); ?>" class="btn btn-danger btn-sm">Add</a><?php } ?>                 
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
						<th>Video Url</th>
                        <th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                     <tbody id="myTable">
                    <?php
                      if(!empty($this->input->get('per_page'))){
                            $sr=$this->input->get('per_page');
                        }else{
                            $sr=0;
                        }
                    foreach($videos as $l){$zero=0;$one=1;$pk='video_id'; $table='video';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>                        
						<td>
                            <?php if(isset($l['video_url'])){ ?>
                            <a href="<?php echo $l['video_url']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >View Video</a>
                            <?php }else{ echo NO_FILE;}?>                       
                        </td>
                        <td>
                            <?php 
                            if($l['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$l['video_id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$l['video_id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$l['video_id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$l['video_id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>

                            <?php if($this->Role_model->_has_access_('video','edit')){?>
                                <a href="<?php echo site_url('adminController/video/edit/'.$l['video_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a><?php } ?>
                            <?php if($this->Role_model->_has_access_('video','remove')){?>
                                <a href="<?php echo site_url('adminController/video/remove/'.$l['video_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a><?php } ?>
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
