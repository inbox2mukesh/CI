<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
/* margin-bottom: 5px; */
}

.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                  <a href="<?php echo site_url('adminController/Classroom_documents/index'); ?>" class="btn btn-danger btn-sm">Classroom Documents List</a>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
          	<div class="box-body">
      					
					<?php 	
			            $classroom_documents_test=$this->input->post('classroom_documents_test[]');
			        ?>
                    <div class="col-md-12 mb-10">
						<label for="classroom_documents_test" class="control-label">Classroom(s)</label>
						<?php
							foreach ($classroom_documents_class as $c) {
							echo '<button type="button" class="btn  btn-md  btn-success del">
               				'.$c['classroom_name'].'</button>';
						    } 
						?>
					</div>

					<div class="col-md-12 mb-10">
						<label for="classroom_documents_content_type" class="control-label">Content Type(s)</label>
						<?php
							foreach ($classroom_documents_content_type as $c) {
							echo '<button type="button" class="btn  btn-md  btn-info del">
               				'.$c['content_type_name'].'</button>';
						    }						  
						?>
					</div>				
	
					<?php $title=$classroom_documents['title'];?>
                     <div class="col-md-12">
						<label for="zoom_link" class="control-label">Title</label>
						<div class="form-group">
                            <input type="text" name="title" value="<?php echo $title ?>" class="form-control input-ui-100" id="title" maxlength="50" readonly />
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($classroom_documents['active']==1 ? 'checked="checked"' : ''); ?> id='active' disabled />	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
					</hr>

					<?php $total_section=$classroom_documents['total_section'];?>
					<div id="EmployeeTierId">
					<h3 class="box-title"> Classroom Section</h1>
					 <!--------Time Slot  List-------->
					<?php
					    for($i=1; $i<=$total_section; $i++){
							$classroom_documents_section=isset($_POST['classroom_documents_section'.$i]) ? $_POST['classroom_documents_section'.$i]:$classroom_documents_section_list[$i]['section'];
							$old_section=$classroom_documents_section_list[$i]['section'];
							$section_no=isset($_POST['section_no'.$i]) ? $this->input->post('section_no'.$i):$classroom_documents_section_list[$i]['section_number'];
							$section_type=isset($_POST['section_type'.$i]) ? $this->input->post('section_type'.$i):$classroom_documents_section_list[$i]['type'];
							
					?>
						    
							<div id="ClassroomDocumentsDiv-<?php echo $i?>">
							<div class="ClassroomDocumentsDiv">
								<div class="col-md-2">
										<label  class="control-label"><span class="sn">
										<?php echo ucfirst($section_type);?></span> Section </label>
										<div class="form-group">
										   <input type="text" name="section_no<?php echo $i?>"  id="section_no<?php echo $i?>" class="form-control section_no" placeholder="section number" onkeyup="checkSectionNumber($(this))" required=required  value="<?php echo $section_no?>" readonly />
										</div>
								</div>
								<div class="col-md-10">
									<div class="form-group" style="margin-top: 20px;">
									    <?php 
										if($section_type=='text'){
											$old_section='';
										?>
	                                     <p><?php echo $classroom_documents_section?></p>
										<?php 
										} else if($section_type=='image'){
										?>
					               <div>
								   <div class="col-md-6">
								     <?php if(!empty($old_section)){?>
								     <img src="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH.$old_section);?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
									 <?php 
									 }else{?>
									  <img src="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH.'no-image.png');?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
									 <?php }?>
								   </div>
                                   </div>
									<?php 
									}else if($section_type=='video'){
									?>
                                   <div> 
								  
								    <div class="col-md-6">
									  <?php if(!empty($old_section)){?>
									    <video controls  id="previewVideo<?php echo $i?>" height="150" width="150" class="previewVideo"src="<?php echo site_url(CLASSROOM_DOCUMENTS_VIDEO_PATH.$old_section);?>"></video>
									 <?php 
									 }else{?>
									  <video controls  id="previewVideo<?php echo $i?>" height="150" width="150" class="previewVideo"></video>
									 <?php 
									 }?>
								    
								    </div>
					
								</div>
								<?php
								}else if($section_type=='audio'){ ?>
								<div>
								<div class="col-md-12">								
								 <?php 
								 if(!empty($old_section)){?>
									<audio controls  id="previewAudio<?php echo $i?>" class="previewAudio"src="<?php echo site_url(CLASSROOM_DOCUMENTS_AUDIO_PATH.$old_section);?>"></audio>
								<?php }else{?>
									<audio controls  id="previewAudio<?php echo $i?>" class="previewAudio"></audio>
								<?php } ?>
								 </div>
								</div>
                                <?php } ?>
								</div>
								</div>		
								</div>													
							</div>							
						<?php } ?>
					</div>
			
			</div>
          	
			
      	</div>
    </div>
</div>