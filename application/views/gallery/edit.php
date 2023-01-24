<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Edit Gallery</h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
			<?php echo form_open_multipart('adminController/gallery/edit/'.$gallery['id'], array('onsubmit' => 'return validate_gallery_form();'));?>
			<div class="box-body">
			

					<?php
						if($gallery['media_type']=='Image'){
							$selectedIMG = ' selected = "selected" ';
						}elseif($gallery['media_type']=='Audio'){
							$selectedAUD = ' selected = "selected" ';
						}elseif($gallery['media_type']=='Video'){
							$selectedVID = ' selected = "selected" ';
						}else{
							$selectedIMG ='';
							$selectedAUD = '';
							$selectedVID='';
						}
					?>
					<div class="col-md-4">
			            <label for="media_type" class="control-label"><span class="text-danger">*</span> Media Type</label>
			            <div class="form-group">
			              <select name="media_type" id="media_type" class="form-control selectpicker selectpicker-ui-100">
			                <option value="">Select Type</option>
			                <option value="Image" <?php echo $selectedIMG;?> >Image</option>
			                <option value="Audio" <?php echo $selectedAUD;?> >Audio</option>
			                <option value="Video" <?php echo $selectedVID;?> >Video</option>
			              </select>
			              <span class="text-danger media_type_err"><?php echo form_error('media_type');?></span>
			            </div>
			        </div>
					<input type="hidden" name="file_hidden" id="file_hidden" value="<?php echo site_url(GALLERY_IMAGE_PATH.$gallery['image']);?>">
					<div class="col-md-4">
						<label for="image" class="control-label"><span class="text-danger">*</span>File</label><?php echo GALLERY_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="image" value="<?php echo ($this->input->post('image') ? $this->input->post('image') : $gallery['image']); ?>" class="form-control input-ui-100" id="image" onchange="validate_file_type_gallary(this.id)"/>	
							<span class="text-danger image_err"><?php echo form_error('image');?></span>	
							<span>
								<?php 
								if(isset($gallery['image'])){      
                                    echo '<a href="'.site_url(GALLERY_IMAGE_PATH.$gallery['image']).'" target="_blank">'.$gallery['image'].'</a>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
						</span>						
						</div>            			
									
					</div>

					<div class="col-md-4">
			            <label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
			            <div class="form-group">
			              <input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $gallery['title']); ?>" class="form-control input-ui-100" id="title" required="required" maxlength="50"/>
			              <span class="text-danger title_err"><?php echo form_error('title');?></span>
			            </div>
			         </div>

					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($gallery['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
		
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>