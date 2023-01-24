<style type="text/css">
  .correct-accept.nocorrect{
        color:red!important;
        }
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	 
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
			<?php echo form_open_multipart('adminController/Photo/edit/'.$photo['id']); ?>
			<div class="box-body">
				<div class="">
					
					<div class="col-md-6">
						<label for="image" class="control-label"><span class="text-danger">*</span>Image</label> <?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="image" value="<?php echo ($this->input->post('image') ? $this->input->post('image') : $photo['image']); ?>" class="form-control input-ui-100 imagegallery-300x200" id="image"  />
							<!-- <span class="text-danger image_err"><?php echo form_error('image');?></span>  -->
							<div class="correct-accept text-blue image-size-label" style="position:absolute;">Accept Only Webp img Size 300x200</div>
							<Br/>
							<div>
								<?php 
								if(isset($photo['image'])){      
                                    echo '<span>
                                            <a href="'.site_url(PHOTO_IMAGE_PATH.$photo['image']).'" target="_blank">'.$photo['image'].'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
								<input type="hidden" value="<?php echo PHOTO_IMAGE_PATH.$photo['image'];?>" name="hid_image"/>
						</div>
						</div>						
					</div>

					<div class="col-md-12">
					<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($photo['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20 sbm_btn">
				<?php echo UPDATE_LABEL;?>
				</button>
			</div>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div><?php ob_start(); ?>
<script type="text/javascript">
  $( ".imagegallery-300x200" ).change(function( i ) {

    var fi = document.getElementById('image');
    for (var i = 0; i <= fi.files.length - 1; i++) {
        readImageFile(fi.files.item(i));
  }

    function readImageFile(file) {

        console.log(file);
        var webPonly = file.type;
        if ( webPonly=="image/webp" ){
            var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.src = e.target.result;
                    img.onload = function () {
                        var w = this.width;
                        var h = this.height;
                        if( w == 300 && h == 200 ) {
                            $('.correct-accept').addClass('active');
                            $(".correct-accept").removeClass("nocorrect");
                            $('.sbm_btn').prop('disabled', false);
                        }else{
                            $(".imagegallery-300x200").val('');
                            $(".correct-accept").addClass("nocorrect");
                            $(".correct-accept").html("Accept Only Image Size 300x200");
                            $('.sbm_btn').prop('disabled', true);
                        }
                    }
                };
                reader.readAsDataURL(file);

        }else{        

          $(".correct-accept").text("Accept Only Webp Image");
          $(".correct-accept").addClass("nocorrect");
          $(".imagegallery-300x200").val('');
          $('.sbm_btn').prop('disabled', true);
        }
    }
});
</script>
<?php global $customJs;
$customJs = ob_get_clean(); ?>