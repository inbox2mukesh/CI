<style type="text/css">
  
  .myline {
  border-bottom: double;
  border-bottom-color: red;
  border-width: 1px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title;?></h3>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open_multipart('adminController/student_post/post_reply_/'.$postData['post_id']); ?>
            <div class="box-body">
            <div class="row clearfix">
              
            <div class="col-md-12">
              <label for="post_reply_text" class="control-label">Student Post Deatils:</label>
              <div class="form-group">
               <p class="text-info"><?php echo $postData['post_text'];?></p>
              </div>
            </div>

            <?php if($postData['post_image']){ ?>
            <div class="col-md-6">             
              <div class="form-group">               
               <p><img src= '<?php echo $postData["post_image"]; ?>' style="width: 50px; height:40px"/></p>
              </div>
            </div>
          <?php } ?>
          <hr>

            <div class="col-md-12">              
              <div class="form-group">
                <p class="text-danger">                  
                  <?php echo $postData['fname'].' '.$postData['lname'].' ( '.$postData['UID'].' ) ';?>
                  <?php echo '<br/>';?>
                  <?php echo $postData['email'].' | '.$postData['country_code'].'-'.$postData['mobile'];?>
                </p>
                <p class="text-warning">
                  <i>                    
                    <?php echo $postData['created'];?>                      
                  </i>
                </p>
              </div>
            </div>

            
            <div class="col-md-12" style="background-color: #EFE8D7">              
              <div class="form-group">
                <label for="post_reply_text" class="control-label">Previous Reply:</label>
                <?php foreach ($allPostReply as $r) { ?>                  
                <p class="text-danger"> 
                  <?php echo $r['post_reply_text']; ?><?php echo '<br/>';?><?php echo '<br/>';?>
                  <?php if($r["post_reply_image"]){ ?>
                    <img src= '<?php echo site_url(POST_REPLY_IMAGE_PATH.$r["post_reply_image"]); ?>' style="width: 50px; height:40px"/><?php echo '<br/>';?>
                  <?php } ?>

                  <i class="text-warning"><?php echo $r['created']; ?></i>
                </p>
                <hr/>
              <?php } ?>
              </div>
            </div>

            <div class="col-md-12">
              <label for="post_reply_text" class="control-label">Post Reply</label>
              <div class="form-group has-feedback">
                <textarea name="post_reply_text" class="form-control" id="post_reply_text"><?php echo $this->input->post('post_reply_text'); ?><?php echo $this->input->post('post_reply_text'); ?></textarea>
                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                <span class="text-danger"><?php echo form_error('post_reply_text');?></span>
              </div>
            </div>
          
            <div class="col-md-6">
              <label for="post_reply_image" class="control-label">Post File</label><?php echo POST_REPLY_ALLOWED_TYPES_LABEL;?>
              <div class="form-group">                
                <input type="file" name="post_reply_image" value="<?php echo $this->input->post('post_reply_image'); ?>" class="form-control" id="post_reply_image"/>
              </div>
            </div>          

            <div class="col-md-6">
              <div class="form-group">
                <input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
                <label for="active" class="control-label">Publish</label>
              </div>
            </div>
          
        </div>
      </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-danger">
                <i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
              </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>