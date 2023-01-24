<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools">
              		<?php if($this->Role_model->_has_access_('video','index')){?>
                   <a href="<?php echo site_url('adminController/video/index'); ?>" class="btn btn-success btn-sm">ALL Video</a>  <?php } ?>                  
                </div>
                </div>
       
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/video/add'); ?>
          	<div class="box-body">
          		<div class="">

					<div class="col-md-6">						
						<label for="video_url" class="control-label"><span class="text-danger">*</span>Video URL</label>
						<?php if($this->Role_model->_has_access_('gallery','add')){?>	
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/add');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL;?></a>
						</span>
						]&nbsp;<?php } ?>	
						<?php if($this->Role_model->_has_access_('gallery','index')){?>
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/index');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL_LIST;?></a>
						</span>
						]	<?php } ?>				
						<div class="form-group has-feedback">
							<input type="url" name="video_url" value="<?php echo $this->input->post('video_url'); ?>" class="form-control input-ui-100" id="video_url" onblur="ValidURL(this.value,this.id),validate_video_url_mp4(this.id)" />
							<span class="glyphicon glyphicon-link form-control-feedback"></span>
							<span class="text-danger video_url_err"><?php echo form_error('video_url');?></span>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
				<?php echo SAVE_LABEL;?>
				</button>
                </div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>