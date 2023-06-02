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
            <?php echo $this->session->flashdata('flsh_msg'); $attributes = array('id'=>'upload_banner','name'=>'upload_banner');?>
            <?php echo form_open_multipart('adminController/enquiry_purpose/add_banner',$attributes); ?>
          	<div class="box-body">
          		<div class="row">
					<div class="col-md-4">
						<label for="banner" class="control-label">Service Image<span class="text-danger">*</span></label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
						<input type="file" name="banner[]" value="<?php echo $this->input->post('banner'); ?>" class="form-control input-ui-100" id="banner" multiple onchange="checkuploadedcount(this.files);" accept="image/*"/>              
						<span class="text-danger banner_err"><?php echo form_error('banner');?></span>             
						</div>
					</div>						
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="button" id="submit" name="submit" class="btn btn-danger rd-20 submit_btn">
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
		
		$('.submit_btn').click(function(){
			if($('#banner').get(0).files.length <= 0){
				$('.banner_err').html('Please select file');
			}
			else{
				$('#upload_banner').submit();
			}
		});
		
	});
	function checkuploadedcount(files)
	{
		if(files.length > 5)
		{
			$('.banner_err').html('Only 5 files are allowed');
			$('#banner').val('');
		}
		else{
			$('.banner_err').html('');
		}
	}
	// checkWordCountCkEditor('about_service');	
</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>