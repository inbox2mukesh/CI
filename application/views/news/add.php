<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3> 
              	<div class="box-tools">
              		<?php if($this->Role_model->_has_access_('news','index')){?>
                    <a href="<?php echo site_url('adminController/news/index'); ?>" class="btn btn-success btn-sm">All News List</a>  <?php } ?>                  
                </div>              	
                </div>
        
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php 
			$attributes = ['name' => 'news_add_form', 'id' => 'news_add_form'];
			echo form_open_multipart('adminController/news/add',$attributes); ?>
          	<div class="box-body">
          		<div class=""> 

					<div class="col-md-4">
						<label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group">
							<input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control input-ui-100 removeerrmessage" id="title" maxlength="100"/>
							<span class="text-danger title_err"><?php echo form_error('title');?></span>
						</div>
					</div>	
					<div class="col-md-4 margin-bottom-20">
							<label for="event_title" class="control-label"><span class="text-danger">*</span>Url Slug</label>
							<div class="form-group">
								<input type="text" name="URLslug" value="<?php echo $URLslug; ?>" class="form-control removeerrmessage allow_url_slug" id="URLslug" placeholder="URL" onKeyPress="return noNumbers(event)" maxlength="140" autocomplete="off" onchange="checkUrl('news',this.id)" onpaste="return false" />
								<span class="text-danger URLslug_err"><?php echo form_error('URLslug'); ?></span>
							</div>
						</div>				

					<div class="col-md-4">
						<label for="" class="control-label"><span class="text-danger">*</span>Card Image</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="card_image" value="<?php echo $this->input->post('card_image'); ?>" class="form-control input-ui-100 removeerrmessage" id="card_image" onchange="validate_file_type_Webp(this.id)"  />
							<span class="text-danger card_image_err"><?php echo form_error('card_image');?></span>
						</div>
					</div>
					<div class="col-md-4">
						<label for="media_file" class="control-label"><span class="text-danger">*</span>Media File</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="media_file" value="<?php echo $this->input->post('media_file'); ?>" class="form-control input-ui-100 removeerrmessage" id="media_file" onchange="validate_file_type_Webp(this.id)"  />
							<span class="text-danger media_file_err"><?php echo form_error('media_file');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="news_date" class="control-label"><span class="text-danger">*</span>News Date <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="news_date" value="<?php echo $this->input->post('news_date'); ?>" readonly class="noBackFutureDate form-control input-ui-100 removeerrmessage" id="news_date" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger news_date_err"><?php echo form_error('news_date');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="tags" class="control-label"> Tags</label>
						<div class="form-group">
							<input type="text" name="tags" value="<?php echo $this->input->post('tags'); ?>" class="form-control input-ui-100" id="tags" maxlength="100" placeholder="Enter comma seprated value"/>
							<span class="text-danger tags_err"><?php echo form_error('tags');?></span>
						</div>
					</div>
					<div class="col-md-6 margin-bottom-20">
						<label for="keywords" class="control-label"><span class="text-danger">*</span>SEO Keywords</label>
						<div class="form-group">
						<input type="text" name="keywords" value="<?php echo (isset($keywords) && !empty($keywords))?$keywords:''; ?>" class="form-control input-ui-100 removeerrmessage" id="keywords" placeholder="SEO Keywords" />
						<span class="text-danger keywords_err"><?php echo form_error('keywords'); ?></span>
						</div>
					</div>
					<div class="col-md-6 margin-bottom-20">
						<label for="seo_title" class="control-label"><span class="text-danger">*</span>SEO Title</label>
						<div class="form-group">
						<input type="text" name="seo_title" value="<?php echo (isset($seo_title) && !empty($seo_title))?$seo_title:''; ?>" class="form-control input-ui-100 removeerrmessage" id="seo_title" placeholder="SEO Title"   />
						<span class="text-danger seo_title_err"><?php echo form_error('seo_title'); ?></span>
						</div>
					</div>
					<div class="col-md-12 margin-bottom-20">
						<label for="seo_desc" class="control-label"><span class="text-danger">*</span>SEO Description</label>
						<div class="form-group">
						<textarea name="seo_desc" value="<?php echo (isset($seo_desc) && !empty($seo_title))?$seo_title:''; ?>" class="form-control input-ui-100 removeerrmessage" id="seo_desc" placeholder="SEO Description" rows="4" style="resize:none;"></textarea>
						<span class="text-danger seo_desc_err"><?php echo form_error('seo_title'); ?></span>
						</div>
					</div>	
					<div class="col-md-2">
						<div class="form-group form-checkbox mt-30">
							<input type="checkbox" name="is_pinned" value="1" id="is_pinned" checked="checked"/>
							<label for="is_pinned" class="control-label">Is Pinned?</label>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group form-checkbox mt-30">
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

					<div class="col-md-12">
						<label for="body" class="control-label"><span class="text-danger">*</span>Full News</label>
						<div class="form-group has-feedback">
							<textarea name="body" class="form-control myckeditor removeerrmessage" id="body"><?php echo $this->input->post('body'); ?></textarea>
							<span class="text-danger body_err"><?php echo form_error('body');?></span>
						</div>
					</div>

					
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20 submit_btn">
				 <?php echo SAVE_LABEL;?>
				</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
		  </div>
    </div>
</div>

<?php ob_start(); ?>
<script>

$('#news_add_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;
		var title=$('#title').val();
		var card_image=$('#card_image').val();
		var media_file=$('#media_file').val();
		var news_date=$('#news_date').val();
		var URLslug=$('#URLslug').val();
		//var body=$('#body').val();		
		var body=CKEDITOR.instances.body.getData();	
		var desc = body.split(' ');	
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
		if(card_image == "")
		{			
			$(".card_image_err").html('The Card Image field is required.');
			flag=0;
		} else { $(".card_image_err").html(''); }
		if(media_file == "")
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
		if(desc.length < 300)
		{			
			$(".body_err").html('The Body field should be minimum of 300 words.');
			flag=0;
		} else { $(".body_err").html(''); }
		if(desc.length > 2000)
		{		
			$(".body_err").html('The Body field should be maximum of 2000 words.');
			flag=0;
		} else { $(".body_err").html(''); }
		if($('#keywords').val() == "")
		{			
			$(".keywords_err").html('The Keywords is required.');
			flag=0;
		} else { $(".keywords_err").html(''); }
		if($('#seo_title').val() == "")
		{			
			$(".seo_title_err").html('The SEO Title is required.');
			flag=0;
		} else { $(".seo_title_err").html(''); }	
		if($('#seo_desc').val() == "")
		{			
			$(".seo_desc_err").html('The SEO Description is required.');
			flag=0;
		} else { $(".seo_desc_err").html(''); }
		if(flag == 1)
		{
			this.submit();			
		} 
       
    });
	$(document).ready(function(){
			checkWordCountCkEditor('body');
			
		});
	</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>