<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">     
                <?php 
                  if($this->Role_model->_has_access_('marketing_popups','index')){
                  ?>             
                  <a href="<?php echo site_url(BACKEND_DIR.'/marketing_popups/index'); ?>" class="btn btn-success btn-sm"> All Popups List</a>
                <?php }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php if(isset($error)) {echo $error;}?>
            <?php echo form_open_multipart(BACKEND_DIR.'/marketing_popups/add', array('onsubmit' => 'return validate_marketing_popup_form();'));?>
            <div class="box-body">
              <div class="">
          <input type="hidden" name="fake" id="fake" value="add">
          <div class="col-md-3">
            <label for="marketing_date" class="control-label"><span class="text-danger">*</span>Date(from:to)</label>
            <div class="form-group has-feedback">
              <input type="text" name="marketing_date" value="<?php echo $this->input->post('marketing_date'); ?>" class="form-control input-ui-100" id="marketing_date" autocomplete="off" data-date-format="dd-mm-yyyy" readonly="readonly"/>
              <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
              <span class="text-danger marketing_date_err"><?php echo form_error('marketing_date');?></span>
            </div>
          </div>

          <div class="col-md-3">
            <label for="image" class="control-label"><span class="text-danger">*</span>Image</label> <?php echo MARKETING_POPUPS_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">
              <span class="input-ui-relative file0">
              <input type="file" name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control input-file-ui-100 input-file-ui" id="image" onchange="validate_file_type(this.id)"/> 
                  </span>
                  <span class="text-danger image_err"><?php echo form_error('image');?></span>
                 </div>
           
          </div>

          <div class="col-md-3">
            <label for="title" class="control-label"><span class="text-danger">*</span>Title</label>
            <div class="form-group">
              <input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control input-ui-100" id="title" maxlength="50"/>
              <span class="text-danger title_err"><?php echo form_error('title');?></span>
            </div>
          </div>

          <div class="col-md-3">
            <label for="link" class="control-label"><span class="text-danger">*</span>Link/URL</label>
            <div class="form-group">
              <input type="text" name="link" value="<?php echo $this->input->post('link'); ?>" class="form-control input-ui-100" id="link" maxlength="255" onblur="validURL(this.value);"/>
              <span class="text-danger link_err"><?php echo form_error('link');?></span>
            </div>
          </div>

          <div class="col-md-12">
            <label for="desc" class="control-label">Description</label>
            <div class="form-group has-feedback">
              <textarea name="desc" class="form-control" id="desc"><?php echo $this->input->post('desc'); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group form-checkbox">
              <input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
              <label for="active" class="control-label">Active</label>
            </div>
          </div>
          <div class="col-md-12 box-footer">
              <button type="submit" class="btn btn-danger rd-20">
                <i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
              </button>
            </div>
          
        </div>
      </div>
        
            <?php echo form_close(); ?>
        </div>
    </div>
</div>