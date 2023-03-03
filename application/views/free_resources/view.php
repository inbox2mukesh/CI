<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
margin-bottom: 5px;
}
.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}

h2{font-size: 22px;}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                    <?php 
				    if($this->Role_model->_has_access_('free_resources','index')){
					?>
                      <a href="<?php echo site_url('adminController/Free_resources/index'); ?>" class="btn btn-danger btn-sm">Free Resources List</a>
				    <?php 
				   }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
          	<div class="box-body">
			<?php
				

				$content_type_name=$free_resources['content_type_name'];
				
				?>
          			
					
					<div class="col-md-12">
						<label for="department_name" class="control-label bold">Content Type:</label> <?php echo ucfirst($content_type_name)?>
						<div class="form-group">
	
						</div>
					</div>
					<div class="col-md-12">
						<label for="department_name" class="control-label bold">Title:</label> <?php echo $free_resources['title']?>
						<div class="form-group">
	
						</div>
					</div>
					<div class="col-md-12">
						<label for="department_name" class="control-label bold">Image:<?php if($free_resources['image']){ ?><br>
                                <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.$free_resources['image']);?>"  height="200" width="200" id="thumbnailPreview" class="thumbnailPreview">
                            <?php }else{ ?>
                                <img src="<?php echo site_url(NO_IMAGE_PATH);?>"  height="200" width="200" id="thumbnailPreview" class="thumbnailPreview">
                            <?php } ?>
						</label>
						<div class="form-group">
	
						</div>
					</div>
					<div class="col-md-12">
						<label for="department_name" class="control-label bold">Description:</label><?php echo $free_resources['description']?>
						<div class="form-group">
	
						</div>
					</div>
                    <div class="col-md-12">
						<label for="department_executive_management_tier" class="control-label bold">Test Type :</label>
						
						<?php
							foreach ($free_resources_test_list as $c) {
							echo '<button type="button" class="btn  btn-md  btn-success del">
               				'.$c['test_module_name'].'</button>';
						 } 
						 
						?>
						<div class="form-group">
	
						</div>
					</div>
                    
					<div class="col-md-12">
					   <label for="department_management_tier" class="control-label bold">Section List</label>
					</div>
				
					 <!--------Employee Tire List-------->
					   <?php
					   $i=1;
					   foreach($free_resources_section_list as $key=>$val){
						$section=$free_resources_section_list[$i]['section'];
						$section_number=$free_resources_section_list[$i]['section_number'];
						$section_type=$free_resources_section_list[$i]['type'];
						?>
					<div class="col-md-12">
					   <div>
							<label class="control-label"><span class="sn"><?php echo $section_number ?> :<?php echo ucfirst($section_type)?></span> Section</label>
							</label>	
						</div>
						<div>
							<?php 
							if($section_type=='text'){ 
							   echo $section;	
							}else if($section_type=='image'){
							?>
							   <?php if(!empty($section)){?>
								  <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.$section);?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
							       <?php 
									 }else{?>
									  <img src="<?php echo site_url(NO_IMAGE_PATH);?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
									 <?php }?>
                            <?php 							
							}else if($section_type=='video'){
							?>
							 <?php if(!empty($section)){?>
									    <video controls  id="previewVideo<?php echo $i?>" height="400" width="400" class="previewVideo"src="<?php echo site_url(FREE_RESOURCES_VIDEO_PATH.$section);?>"></video>
									 <?php 
									 }else{
									    echo 'no video file';	 
									 ?>
									 
									 <?php 
									 }
									 ?>
							<?php }else if($section_type=='audio'){
								
								if(!empty($section)){
								?>
							   <audio controls  id="previewAudio<?php echo $i?>" class="previewAudio" src="<?php echo site_url(FREE_RESOURCES_AUDIO_PATH.$section);?>"></audio>  
								<?php
								}else{
								echo  'no audio file';	
								} 
							}?>
						</div>					
					 </div>
						<?php $i++;
						}?>
					</div>
		
      	</div>
    </div>
</div>