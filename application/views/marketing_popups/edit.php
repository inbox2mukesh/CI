<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
			<?php echo form_open_multipart(BACKEND_DIR.'/marketing_popups/edit/'.$marketing_popups['id'], array('onsubmit' => 'return validate_marketing_popup_form();'));?>
			<div class="box-body">
				<div class="">					
					<?php 
						$marketing_date = $marketing_popups['start_date'].' - '.$marketing_popups['end_date'];
					?>
					<input type="hidden" name="fake" id="fake" value="edit">
					<div class="col-md-3">
						<label for="marketing_date" class="control-label"><span class="text-danger">*</span>Date(from:to) </label>
						<div class="form-group has-feedback">
							<input type="text" name="marketing_date" value="<?php echo ($this->input->post('marketing_date') ? $this->input->post('marketing_date') : $marketing_date); ?>" class="form-control input-ui-100" id="marketing_date" autocomplete="off" data-date-format="dd-mm-yyyy" readonly="readonly"/>
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger marketing_date_err"><?php echo form_error('marketing_date');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="image" class="control-MARKETING_POPUPS_ALLOWED_TYPES_LABEL"><span class="text-danger">*</span>Image</label><?php echo MARKETING_POPUPS_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
						<span class="input-ui-relative file0">
							<input type="file" name="image" class="form-control input-file-ui-100 input-file-ui" id="image"/>
                            </span>
							<div>
								<?php 
								if(isset($marketing_popups['image'])){      
                                    echo '<span>
                                            <a href="'.site_url(MARKETING_POPUPS_IMAGE_PATH.$marketing_popups['image']).'" target="_blank">'.$marketing_popups['image'].'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
						</div>	
						<span class="text-danger image_err"><?php echo form_error('image');?></span>
						</div>
								
					</div>

					<div class="col-md-3">
			            <label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
			            <div class="form-group">
			              <input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $marketing_popups['title']); ?>" class="form-control input-ui-100" id="title" required="required" maxlength="50"/>
			              <span class="text-danger"><?php echo form_error('title');?></span>
			            </div>
			         </div>

			         <div class="col-md-3">
			            <label for="link" class="control-label"><span class="text-danger">*</span>Title</label>
			            <div class="form-group">
			              <input type="text" name="link" value="<?php echo ($this->input->post('link') ? $this->input->post('link') : $marketing_popups['link']); ?>" class="form-control input-ui-100" id="link" required="required" maxlength="50" onblur="validURL(this.value);"/>
			              <span class="text-danger"><?php echo form_error('link');?></span>
			            </div>
			         </div>

			         <div class="col-md-12">
						<label for="desc" class="control-label">Description</label>
						<div class="form-group has-feedback">
							<textarea name="desc" class="form-control" id="desc"><?php echo ($this->input->post('desc') ? $this->input->post('desc') : $marketing_popups['desc']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="active" value="1" <?php echo ($marketing_popups['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

					<div class="col-md-12 box-footer">
            	<button type="submit" class="btn btn-upd btn-danger rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
				</div>
			</div>
					
			<?php echo form_close(); ?>
		</div>
    </div>
</div>