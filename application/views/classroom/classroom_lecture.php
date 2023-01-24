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
						<th>Title</th>
						<th>Video Url</th>
						<th>Screen</th>
                        <th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                     <tbody id="myTable">
                    <?php $sr=0; foreach($classroom_lecture as $l){$zero=0;$one=1;$pk='live_lecture_id'; $table='live_lectures';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $l['classroom_name']; ?></td>
						<td><?php echo $l['live_lecture_title']; ?></td>
						<td>
                            <?php if(isset($l['video_url'])){ ?>
                            <a href="<?php echo $l['video_url']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >View Video</a>
                            <?php }else{ echo NO_FILE;}?>                       
                        </td>

						<td>
                            <?php 
                                if(isset($l['screenshot'])){   
                                    echo '<span>
                                            <a href="'.$l['screenshot'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }                                
                            ?>   
                        </td>
                        <td>
                            <?php 
                            if($l['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$l['live_lecture_id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$l['live_lecture_id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                             <a href="<?php echo site_url('adminController/live_lecture/edit/'.$l['live_lecture_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                            <!--<a href="<?php echo site_url('adminController/live_lecture/remove/'.$l['live_lecture_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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
