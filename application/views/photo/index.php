<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php if($this->Role_model->_has_access_('photo','add')){ ?>
                    <a href="<?php echo site_url('adminController/photo/add'); ?>" class="btn btn-danger btn-sm">Add</a> <?php } ?>
                    <?php if($this->Role_model->_has_access_('photo','index')){ ?>
                    <a href="<?php echo site_url('adminController/photo/index'); ?>" class="btn btn-success btn-sm">ALL Photo</a> <?php } ?>
                    
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>								
						<th>Image</th> 
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
                        foreach($photo as $r){ $zero=0;$one=1;$pk='id'; $table='photo'; $sr++;
                            $link=site_url(PHOTO_IMAGE_PATH.$r['image']);
                        ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
						<td>
                            <?php 

                                $ext = pathinfo($r['image'], PATHINFO_EXTENSION);
                                if( isset( $r['image']) and ( $ext=='JPG' or $ext=='jpg' or $ext=='jpeg' or $ext=='gif' or $ext=='png' or $ext=='webp') ){
                            ?>
                            <img src= '<?php echo site_url(PHOTO_IMAGE_PATH.$r["image"]); ?>' style="width: 50px; height:50px"/>

                            <?php }elseif( isset($r['image']) and ($ext=='mp4' or $ext=='mp3') ){ ?> 

                                <?php echo '<a href="'.$link.'" target="_blank">'.OPEN_FILE.'</a>';?>
                            <?php }else{ ?>

                                <?php echo NO_FILE; ?>
                            
                            <?php } ?>
                        </td>
                        
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
                            <?php if($this->Role_model->_has_access_('photo','edit')){ ?>
                            <a href="<?php echo site_url('adminController/photo/edit/'.$r['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>
                            <?php if($this->Role_model->_has_access_('photo','remove')){ ?>
                            <a href="<?php echo site_url('adminController/photo/remove/'.$r['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a><?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
                <div class="pull-right">
                <?php echo $links; ?>                  
                </div>                
            </div>
        </div>
    </div>
</div>