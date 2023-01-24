<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>            	
                <?php echo $this->session->flashdata('flsh_msg');?>
            </div>
            <div class="table-ui-scroller">
            <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Classroom</th>
                        <th>Name</th>
                        <th>UID</th>
                        <th>Email</th>
                        <th>Mobile</th>				
						<th>Post</th>
                        <th>Post File</th>
                        <th>Post date</th>						
						<th><?php echo STATUS;?></th>
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($student_post as $s){$zero=0;$one=1;$pk='post_id'; $table='student_class_posts';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td> 
                        <td><?php echo $s['classroom_name']; ?></td>                       
                        <td><?php echo $s['fname'].' '.$s['lname']; ?></td>
                        <td>
                            <?php
                                if($s['student_identity']!=''){
                                    echo $s['student_identity'].'-'.$s['UID']; 
                                }else{
                                    echo $s['UID'];
                                }                            
                            ?>                                
                        </td>
                        <td><a href="mailto:<?php echo $s['email'];?>"><?php echo $s['email']; ?></a></td>                      
                        <td><?php echo $s['mobile']; ?></td>
                        <td><?php echo $s['post_text']; ?></td>
                        <td>
                            <?php if($s['post_image']){ ?>
                             <a href="<?php echo $s['post_image']; ?>" target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" title="Post File"><span class="fa fa-file"></span> </a>
                            <?php }else{ ?>
                                <?php echo NA;?>
                            <?php } ?>
                        </td>
                        <td><?php echo $s['created']; ?></td>						
						<td>
                            <?php 
                            if($s['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$s['post_id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$s['post_id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$s['post_id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$s['post_id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>  
						<td class="noPrint">
                            <?php if($s['isReplied']==1){ ?>
                                <?php 
                                if($this->Role_model->_has_access_('student_post','post_reply_')){
                                ?>
                                <a href="<?php echo site_url('adminController/student_post/post_reply_/'.$s['post_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reply again"><span class="fa fa-comments"></span> </a>
                            <?php }?>
                            <?php }else{ ?>
                                <?php 
                                if($this->Role_model->_has_access_('student_post','post_reply_')){
                                ?>
                            <a href="<?php echo site_url('adminController/student_post/post_reply_/'.$s['post_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Reply"><span class="fa fa-comments"></span> </a>
                            <?php }?>
                        <?php } ?>
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