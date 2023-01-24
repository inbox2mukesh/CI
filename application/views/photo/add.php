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
                <div class="box-tools pull-right"> 
                <?php if($this->Role_model->_has_access_('photo','index')){ ?>
                <a href="<?php echo site_url('adminController/photo/index'); ?>" class="btn btn-success btn-sm">ALL Photo</a><?php } ?>             
                 
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open_multipart('adminController/photo/add'); ?>
            <div class="box-body">
            <div class="">
          <div class="col-md-6">
            <label for="image" class="control-label">Image<span class="text-danger">*</span></label><?php echo SEP;?> <?php echo WEBP_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">

              <input type="file" name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control input-ui-100 imagegallery-300x200" id="image" />
              <!-- <span class="text-danger image_err"><?php //echo form_error('image');?></span>  -->
              <div class="correct-accept text-blue image-size-label" style="position:absolute;">Accept Only Webp img Size 300x200</div>         
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
              <button type="submit" class="btn btn-danger rd-20 sbm_btn">
              <?php echo SAVE_LABEL;?>
              </button>
               </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>< 
<?php ob_start(); ?>
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