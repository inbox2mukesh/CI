<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
               
                <div class="box-tools">
                    <?php if($this->Role_model->_has_access_('news','add')){?>
                    <a href="<?php echo site_url('adminController/news/add'); ?>" class="btn btn-danger btn-sm">Add News</a> <?php } ?>
                    <?php if($this->Role_model->_has_access_('news','index')){?>
                    <a href="<?php echo site_url('adminController/news/index'); ?>" class="btn btn-success btn-sm">ALL News</a><?php } ?>
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
					    <th>URL Slug</th>
						<th>Date</th>
						<th>Card Image</th>
                        <th>File</th>
                        <th>Is Pinned?</th>
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
                    foreach($news as $l){$zero=0;$one=1;$pk='id'; $table='news';$sr++; ?>
                    <tr>
                        <td><?php echo $sr; ?></td>                   
                        <td><?php echo $l['title']; ?></td>					
                        <td><?php echo $l['URLslug']; ?></td>					
						<td><?php echo $l['news_date']; ?></td>			
						<td>
                            <?php 
                                if($l['card_image']){   
                                    echo '<span>
                                            <a href="'.site_url(NEWS_FILE_PATH).$l['card_image'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }                                
                            ?>   
                        </td>
						<td>
                            <?php 
                                if($l['media_file']){   
                                    echo '<span>
                                            <a href="'.site_url(NEWS_FILE_PATH).$l['media_file'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }                                
                            ?>   
                        </td>
                       
                        <td>
                            <?php 
                            if($l['is_pinned']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="Pinned">PINNED</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$l['id'].' data-toggle="tooltip" title="" >UNPINNED</a></span>';
                            }
                            ?>                                
                        </td>
						
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
                            <?php if($this->Role_model->_has_access_('news','edit')){?>
                            <a href="<?php echo site_url('adminController/news/edit/'.$l['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>
                            <?php if($this->Role_model->_has_access_('news','remove')){?>
                            <a href="<?php echo site_url('adminController/news/remove/'.$l['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a><?php } ?>
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
