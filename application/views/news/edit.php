<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php 
			$attributes = ['name' => 'news_edit_form', 'id' => 'news_edit_form'];
			echo form_open_multipart('adminController/news/edit/'.$news['id'],$attributes); ?>
				<input type="hidden"  value="<?php echo $news['id'];?>" name="hid_id" id="hid_id"/>
			<div class="box-body">
				<div class="">
					

					<div class="col-md-4">
						<label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group">
							<input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $news['title']); ?>" class="form-control input-ui-100 removeerrmessage" id="title" maxlength="100"/>
							<span class="text-danger title_err"><?php echo form_error('title');?></span>
						</div>
					</div>
					<div class="col-md-4 margin-bottom-20">
							<label for="event_title" class="control-label"><span class="text-danger">*</span>Url Slug</label>
							<div class="form-group">
								<input type="text" name="URLslug" value="<?php echo ($this->input->post('URLslug') ? $this->input->post('URLslug') : $news['URLslug']); ?>" class="form-control removeerrmessage allow_url_slug" id="URLslug" placeholder="URL" onKeyPress="return noNumbers(event)" maxlength="140" autocomplete="off" onchange="checkUrl('news',this.id)" onpaste="return false" />
								<span class="text-danger URLslug_err"><?php echo form_error('URLslug'); ?></span>
							</div>
						</div>

					<div class="col-md-4">
						<label for="card_image" class="control-label"><span class="text-danger">*</span>Card Image</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="card_image" value="<?php echo ($this->input->post('card_image') ? $this->input->post('card_image') : $news['card_image']); ?>" class="form-control input-ui-100 removeerrmessage" id="card_image"  onchange="validate_file_type_Webp(this.id)"/>
							<input type="hidden"  value="<?php echo $news['card_image'];?>" name="hid_card_image"/>
							<input type="hidden"  value="<?php echo $news['media_file'];?>" name="hid_media_file"/>
							<span>
								<?php 
								if($news['card_image']){      
                                    echo '<span>
                                            <a href="'.site_url(NEWS_FILE_PATH).$news['card_image'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
						</span>
						<div class="text-danger card_image_err"><?php echo form_error('card_image');?></div>
						</div>						
					</div>
					
					<div class="col-md-4">
						<label for="media_file" class="control-label"><span class="text-danger">*</span>Media File</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="media_file" value="<?php echo ($this->input->post('media_file') ? $this->input->post('media_file') : $news['media_file']); ?>" class="form-control input-ui-100 removeerrmessage" id="media_file" onchange="validate_file_type_Webp(this.id)" />
							<span>
								<?php 
								if($news['media_file']){      
                                    echo '<span>
                                            <a href="'.site_url(NEWS_FILE_PATH).$news['media_file'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
						</span>
						<div class="text-danger media_file_err"><?php echo form_error('card_image');?></div>
						</div>						
					</div>

					<div class="col-md-4">
						<label for="news_date" class="control-label"><span class="text-danger">*</span>News Date <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="news_date" value="<?php echo ($this->input->post('news_date') ? $this->input->post('news_date') : $news['news_date']); ?>" class="noBackFutureDate form-control input-ui-100 removeerrmessage" id="news_date" readonly/>
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger news_date_err"><?php echo form_error('news_date');?></span>
						</div>
					</div>
					<?php
					//print_r($news['TagData']);
					foreach ($news['TagData'] as $t) {
						$x .= implode($t, '').', ';
					}
					$x = rtrim($x, ", ");
					
					?>
				
					<div class="col-md-4">
						<label for="tags" class="control-label"> Tags</label>
						<div class="form-group">
							<input type="text" name="tags" value="<?php echo ($this->input->post('tags') ? $this->input->post('tags') : $x); ?>" class="form-control input-ui-100" id="tags" maxlength="100"/>
							<span class="text-danger"><?php echo form_error('tags');?></span>
						</div>
					</div>
				
					<div class="col-md-2">
						<div class="form-group form-checkbox mt-30">
							<input type="checkbox" name="is_pinned" value="1" <?php echo ($news['is_pinned']==1 ? 'checked="checked"' : ''); ?> id='is_pinned' />
							<label for="is_pinned" class="control-label">Is Pinned?</label>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group form-checkbox mt-30">
							<input type="checkbox" name="active" value="1" <?php echo ($news['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

					<div class="col-md-12">
						<label for="body" class="control-label"><span class="text-danger">*</span>Full News</label>
						<div class="form-group has-feedback">
							<textarea name="body" class="form-control myckeditor removeerrmessage" id="body"><?php echo ($this->input->post('body') ? $this->input->post('body') : $news['body']); ?></textarea>
							<span class="text-danger body_err"><?php echo form_error('body');?></span>
						</div>
					</div>
										
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
				<?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>


<?php ob_start(); ?>
<script>
$('#news_edit_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;
		var title=$('#title').val();
		var card_image=$('#card_image').val();
		var media_file=$('#media_file').val();
		var news_date=$('#news_date').val();
		var body=$('#body').val();		
		var hid_card_image=$('#hid_card_image').val();		
		var hid_media_file=$('#hid_media_file').val();		
		var URLslug=$('#URLslug').val();
		if(title == "")
		{			
			$(".title_err").html('The Title field is required.');
			flag=0;
		} else { $(".title_err").html(''); }
		if(URLslug == "")
		{			
			$(".URLslug_err").html('The Url Slug is required.');
			flag=0;
		} else { $(".URLslug_err").html(''); }
		if(hid_card_image == "" && card_image == "")
		{			
			$(".card_image_err").html('The Card Image field is required.');
			flag=0;
		} else { $(".card_image_err").html(''); }
		if(hid_media_file=="" && media_file == "")
		{			
			$(".media_file_err").html('The Media File field is required.');
			flag=0;
		} else { $(".media_file_err").html(''); }
		if(news_date == "")
		{			
			$(".news_date_err").html('The News Date field is required.');
			flag=0;
		} else { $(".news_date_err").html(''); }
		if(body == "")
		{			
			$(".body_err").html('The Body field is required.');
			flag=0;
		} else { $(".body_err").html(''); }
		
			
		if(flag == 1)
		{
			this.submit();			
		} 
       
    });
	</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>