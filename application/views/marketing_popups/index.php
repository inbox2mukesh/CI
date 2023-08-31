<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                  if($this->Role_model->_has_access_('marketing_popups','add')){
                   if(count($marketing_popups)<1){
                  ?>
                    <a href="<?php echo site_url(BACKEND_DIR.'/marketing_popups/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                <?php } }?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Date</th>
                        <th>Title</th>												
						<th>File: Image<?php echo SEP;?>Icon<?php echo SEP;?>Video<?php echo SEP;?>Audio</th>                        
                        <th>Link</th>
                        <th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php if(!empty($this->input->get('per_page'))){
                            $sr=$this->input->get('per_page');            
                        }else{ $sr=0;}
                        foreach($marketing_popups as $r){
                             $zero=0;$one=1;$pk='id'; $table='marketing_popups'; $sr++;
                            $link=site_url(MARKETING_POPUPS_IMAGE_PATH.$r['image']);
                        ?>
                    <tr>
                        <td><?php echo $sr; ?></td>	
                        <td><?php echo $r['start_date'].' TO '.$r['end_date']; ?></td> 
                        <td><?php echo $r['title']; ?></td>								 
						<td>
                            <?php 

                                $ext = pathinfo($r['image'], PATHINFO_EXTENSION);
                                if( isset( $r['image']) and ( $ext=='JPG' or $ext=='jpg' or $ext=='jpeg' or $ext=='gif' or $ext=='png' or $ext=='svg' or $ext=='webp') ){
                            ?>
                            <img src= '<?php echo site_url(MARKETING_POPUPS_IMAGE_PATH.$r["image"]); ?>' style="width: 50px; height:40px"/>

                            <?php }elseif( isset($r['image']) and ($ext=='mp4' or $ext=='mp3') ){ ?> 

                                <?php echo '<a href="'.$link.'" target="_blank">'.OPEN_FILE.'</a>';?>
                            <?php }else{ ?>

                                <?php echo NO_FILE; ?>
                            
                            <?php } ?>
                        </td>
                        
                        <td>
                            <?php echo $r['link']; ?>                            
                        </td>
                        
                        <td>
                            <?php 
                            if($r['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>                                
                        
						<td>
                  <?php 
                  if($this->Role_model->_has_access_('marketing_popups','edit')){
                  ?>
                            <a href="<?php echo site_url(BACKEND_DIR.'/marketing_popups/edit/'.$r['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                        <?php }?>
                            <!-- <a href="<?php echo site_url(BACKEND_DIR.'/marketing_popups/remove/'.$r['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
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