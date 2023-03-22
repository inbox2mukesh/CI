<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right"> 
                  <?php 
                    if($this->Role_model->_has_access_('gallery','index')){
                  ?>                 
                  <a href="<?php echo site_url('adminController/gallery/index'); ?>" class="btn btn-danger btn-sm">Gallery List</a> <?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php if(isset($error)) {echo $error;}?>
            <?php echo form_open_multipart('adminController/gallery/add', array('onsubmit' => 'return validate_gallery_form();'));?>
            <div class="box-body">
            
          <div class="col-md-4">
            <label for="media_type" class="control-label"><span class="text-danger">*</span> Media Type</label>
            <div class="form-group">
              <select name="media_type" id="media_type" class="form-control selectpicker selectpicker-ui-100">
                <option value="">Select Type</option>
                <option value="Image">Image</option>
                <option value="Audio">Audio</option>
                <option value="Video">Video</option>
              </select>
              <span class="text-danger media_type_err"><?php echo form_error('media_type');?></span>
            </div>
          </div>
          <input type="hidden" name="file_hidden" id="file_hidden" value="">
          <div class="col-md-4">
            <label for="image" class="control-label"><span class="text-danger">*</span>File</label><?php echo GALLERY_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">
              <input type="file" name="image" class="form-control input-ui-100" id="image" onchange="validate_file_type_gallary(this.id)" /> 
              <span class="text-danger image_err"><?php echo form_error('image');?></span>
            </div>
          </div>

          <div class="col-md-4">
            <label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
            <div class="form-group">
              <input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control input-ui-100" id="title" maxlength="50"/>
              <span class="text-danger title_err"><?php echo form_error('title');?></span>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group form-checkbox">
              <input type="checkbox" name="active" value="1" id="active" checked="checked"/>
              <label for="active" class="control-label">Active</label>
            </div>
          </div>
          
 
      </div>
            <div class="box-footer">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger rd-20">
                <i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
              </button>
            </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>