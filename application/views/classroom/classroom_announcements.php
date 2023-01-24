<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Classroom</th>
					    <th>Subject</th>
						<th>Body</th>
                        <th>File</th>
                        <th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                     <tbody id="myTable">
                    <?php $sr=0; foreach($classroom_announcements as $l){$zero=0;$one=1;$pk='id'; $table='announcements';$sr++; ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
						<td><?php echo $l['classroom_name']; ?></td>                   
                        <td><?php echo $l['subject']; ?></td>					
						<td><?php echo $l['body']; ?></td>					

						<td>
                            <?php 
                                if($l['media_file']){   
                                    echo '<span>
                                            <a href="'.site_url(ANNOUNCEMENT_FILE_PATH).$l['media_file'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }                                
                            ?>   
                        </td>
						
                        <td>
                            <?php 
                            if($l['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="De-Active"  >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
                        
						<td>
                            <?php
                                if($this->Role_model->_has_access_('classroom_announcement','edit')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom_announcement/edit/'.$l['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>
                            <!-- <a href="<?php echo site_url('adminController/classroom_announcement/remove/'.$l['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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
