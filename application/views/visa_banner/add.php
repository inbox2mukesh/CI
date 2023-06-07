<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              		<?php 
						if($this->Role_model->_has_access_('visa_banner','index')){
					?>
                  	<a href="<?php echo site_url('adminController/visa_banner/index'); ?>" class="btn btn-danger btn-sm">Visa Banner List</a><?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); $attributes = array('id'=>'upload_banner','name'=>'upload_banner');?>
            <?php echo form_open_multipart('adminController/visa_banner/add',$attributes); ?>
          	<div class="box-body">
          		<div class="row">
					<div class="col-md-4">
						<label for="banner" class="control-label">Service Image<span class="text-danger">*</span></label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
						<input type="file" name="banner[]" value="<?php echo $this->input->post('banner'); ?>" class="form-control input-ui-100" id="banner" multiple onchange="checkuploadedcounts(this.files);" accept=".webp"/>              
						<span class="text-danger banner_err"><?php echo form_error('banner');?></span>             
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
// $(document).ready(function(){
		
		$('#upload_banner').on('submit', function(e)
		{
			e.preventDefault();
			if($('#banner').get(0).files.length <= 0){
				$('.banner_err').html('Please select file');
			}
			else{
				this.submit();
			}
		});
		
	//});
	function checkuploadedcounts(files)
	{
		var _URL = window.URL || window.webkitURL;
		var file, img;
		file = files[0];
		img = new Image();
		var objectUrl = _URL.createObjectURL(file);
		var file_sp = file.name.split('.');
		var fileext = file_sp[1].toLowerCase();
		var objectUrl = _URL.createObjectURL(file);
		if(file)
		{
			img.onload = function () {
				if(this.height < 500 && this.width< 1200 && file!='')
				{
					$('.banner_err').html('Please upload 1200 * 500 image');
					$('#banner').val('');
					_URL.revokeObjectURL(objectUrl);
				}
				else{
					return true;
				}
			};
			img.src = objectUrl;
		}
		else if(files.length > 5)
		{
			$('.banner_err').html('Only 5 files are allowed');
			$('#banner').val('');
		}
		else if(fileext != 'webp')
		{
			
			$('.banner_err').html('Only .webp is allowed');
			$('#banner').val('');
		}
		else{
			$('.banner_err').html('');
		}
	}	
</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>