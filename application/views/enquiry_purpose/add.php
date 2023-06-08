<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
						if($this->Role_model->_has_access_('enquiry_purpose','index')){
					?>
                  	<a href="<?php echo site_url('adminController/enquiry_purpose/index'); ?>" class="btn btn-danger btn-sm">Enquiry Purpose List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); $attributes = ['name' => 'enquiry_purpose_add', 'id' => 'enquiry_purpose_add'];?>
            <?php echo form_open_multipart('adminController/enquiry_purpose/add',$attributes); ?>
          	<div class="box-body">
          		<div class="">
					
					<div class="col-md-4">
						<label for="enquiry_purpose_name" class="control-label">Enquiry Purpose Name<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="enquiry_purpose_name" value="<?php echo $this->input->post('enquiry_purpose_name'); ?>" class="form-control input-ui-100" id="enquiry_purpose_name" maxlength="50"/>
							<span class="text-danger"><?php echo form_error('enquiry_purpose_name');?></span>
						</div>
					</div>	
					<div class="col-md-4 margin-bottom-20">
						<label for="event_title" class="control-label"><span class="text-danger">*</span>Url Slug</label>
						<div class="form-group">
						<input type="text" name="URLslug" value="<?php echo (isset($URLslug) && !empty($URLslug))?$URLslug:''; ?>" class="form-control removeerrmessage allow_url_slug" id="URLslug" placeholder="URL" onKeyPress="return noNumbers(event)" maxlength="140" autocomplete="off" onchange="checkUrl('visaservice',this.id)" onpaste="return false" />
						<span class="text-danger URLslug_err"><?php echo form_error('URLslug'); ?></span>
						</div>
					</div>	

					<?php 
						$division_id=$this->input->post('division_id');
					?>
                    <div class="col-md-4">
						<label for="division_id" class="control-label">Division<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="division_id[]" id="division_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" multiple="multiple" data-actions-box="true">
								<option value=""  disabled="disabled">Select Division</option>
								<?php 
								
								foreach($all_division as $b){
									if(in_array(strtolower($b['division_name']),array('visa','academy'))){
										
										$selected = in_array($b['id'],$division_id) ? ' selected="selected"' : "";
										echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('division_id[]');?></span>
						</div>
					</div>
					<div class="col-md-4">
						<label for="image" class="control-label">Service Image<span class="text-danger">*</span></label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
						<input type="file" name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control input-ui-100" id="image" required onchange="validate_file_type_Webp(this.id)"/>              
						<span class="text-danger image_err"><?php echo form_error('image');?></span>             
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
		  <div class="col-md-12">
            <label for="about_service" class="control-label">About service</label>
            <div class="form-group has-feedback">
              <textarea name="about_service" class="form-control myckeditor" id="about_service"><?php echo $this->input->post('about_service'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
			  <span class="text-danger about_service_err"><?php echo form_error('about_service');?></span>
            </div>
          </div>
					<?php
					$active=1;
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$active=$this->input->post('active');
					}
					?>	
                    <div class="col-md-12">
						<div class="form-group form-checkbox">
							
							<input type="checkbox" name="active" value="1" id="active" <?php if($active == 1){?> checked="checked" <?php }?>/>	
							<label for="active" class="control-label">Active</label>
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
<?php ob_start(); ?>
<script>
$(document).ready(function(){
		checkWordCountCkEditor('about_service');
		
	});
	$('#enquiry_purpose_add').on('submit', function(e){
        e.preventDefault();
		// alert('asdfa');
		var flag=1;	
		var description = $('#about_service').val();	
		var desc = description.split(' ');
		if(description == "")
		{	
			$(".about_service_err").html('The Topic field is required.');
			flag=0;
		} 
		else if(desc.length < 300)
		{			
			$(".about_service_err").html('Description should be minimum of 300 words.');
			flag=0;
		}
		else if(desc.length > 2000)
		{			
			$(".about_service_err").html('Description should be maximum of 2000 words.');
			flag=0;
		}
		else
		{
			this.submit();
			$(".about_service_err").html('');		
		}
	})	
</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>