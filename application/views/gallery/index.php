<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                        if($this->Role_model->_has_access_('gallery','add')){
                    ?> 
                    <a href="<?php echo site_url('adminController/gallery/add'); ?>" class="btn btn-danger btn-sm">Add</a> <?php } ?>
                    
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Media type</th>
                        <th>Title</th>												
						<th>File</th>                        
                        <th width="30%">Link</th>
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
                        foreach($gallery as $r){ $zero=0;$one=1;$pk='id'; $table='galleries'; $sr++;
                            $link=site_url(ltrim(GALLERY_IMAGE_PATH,'./').$r['image']);
                            //echo $linkk=base_url().''.ltrim(GALLERY_IMAGE_PATH,'./').$r['image'];
                        ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $r['media_type']; ?></td>	
                        <td><?php echo $r['title']; ?></td>								 
						<td>
                            <?php
                          
                                $ext = pathinfo($r['image'], PATHINFO_EXTENSION);
                                if( isset( $r['image']) and ( $ext=='JPG' or $ext=='jpg' or $ext=='jpeg' or $ext=='gif' or $ext=='png' or $ext=='svg' or  $ext=='webp') ){
                            ?>
                            <a href="<?php echo site_url(GALLERY_IMAGE_PATH.$r["image"]);?>" target="_blank"><img src= '<?php echo site_url(GALLERY_IMAGE_PATH.$r["image"]); ?>' style="width: 50px; height:50px"/></a>

                            <?php }elseif( isset($r['image']) and ($ext=='mp4' or $ext=='mp3') ){ ?> 

                                <?php echo '<a href="'.$link.'" target="_blank">'.OPEN_FILE.'</a>';?>
                            <?php }else{ ?>

                                <?php echo NO_FILE; ?>
                            
                            <?php } ?>
                        </td>
                        
                        <td>
                            <div class="d-inline">
                                <?php if($r['active']==1){ ?>
                                <input type="text" class="form-control" value="<?php echo $link; ?>" id="<?php echo $sr;?>">
                                <button class="btn btn-info btn-xs" onclick="copy_link('<?php echo $sr;?>')"><span class="fa fa-copy"></span> Copy link</button>
                                <?php }else{ echo NIL;?>

                                <?php } ?>       
                            </div>                     
                        </td>
                        
                        <td>
                            <?php 
                            if($r['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="In-active">'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>                                
                        
						<td>
                            <?php 
                                if($this->Role_model->_has_access_('gallery','edit')){
                            ?> 
                            <a href="<?php echo site_url('adminController/gallery/edit/'.$r['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>
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