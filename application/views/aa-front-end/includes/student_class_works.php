
<div class="head-title mt-10">
  <h2 class="text-uppercase font-weight-300 font-20">Class <span class="text-theme-color-2 font-weight-500">Forum</span></h2>
</div>
<div class="text-right"> <a class="btn view-all-btn btn-sm" href="#">View All Class Forum</a></div> 

<div class="classwork-section mt-10">
<h2 class="text-uppercase font-weight-300 font-18 mt-0">Create <span class="text-theme-color-2 font-weight-500">Post</span></h2>
<?php echo form_open_multipart('our_students/student_class_post', array('name'=>'class-post-form', 'class'=>'')); ?>
<div class="create-post mt-10">
<div class="post-info">
<div class="form-group">
<textarea name="post_text" id="post_text" placeholder="Write your post/query" rows="3" class="form-control"></textarea>
<span class="text-danger small post_text_err"><?php echo form_error('post_text');?></span>
</div>

<div>
<span class="text-info small">Supported file format:</span>
<span> Only jpg, jpeg, png & pdf</span>
<input id="post_image" name="post_image" class="form-control wosa-height" type="file">
<span class="text-danger small post_image_err"><?php echo form_error('post_image');?></span>
</div>

<div class="text-right mt-10">
<button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Post</button>
</div>

</div>
</div>
<?php echo form_close(); ?>

<?php 
    foreach($stdPost->error_message->data as $p){
?>
<div class="posted mt-10">
<div class="head-panel">
<span class="title">Posted By you</span>
<span class="posted-date pull-right">Posted on: <?php echo $p->created;?></span>
</div>

<div class="post-info"><?php echo $p->post_text;?>
<?php 
  if($p->post_image){
  $type = pathinfo($p->post_image, PATHINFO_EXTENSION);
?>
<div class="mt-10">
<span>
<a class="image-popup-vertical-fit" title="" href="<?php echo $p->post_image;?>">
  <?php if($type=='png' or $type=='jpg' or $type=='jpeg'){ ?>
  <img src="<?php echo $p->post_image;?>" width="60px" height="60px" alt=""></a>
<?php }else{ ?>
<a href="<?php echo $p->post_image;?>" target="_blank"><div class="document">
    <img src="<?php echo base_url('resources-f/images/doc-icn.png');?>">
    </div></a>
<?php } ?>

</span>
</div>
<?php } ?>
</div>
</div>
<?php } ?>

<!-- <div class="mt-10">
<a href="#" class="btn btn-warning btn-flat btn-lg">Reply</a>
<div class="form-group mt-10">
<textarea placeholder="" rows="3" class="form-control"></textarea>
<div class="text-right mt-10">
<a href="#" class="btn btn-blue btn-flat">Submit</a>
</div>
</div>
</div> -->

<!-- <div class="chat-panel mt-10">
<div class="chat-info">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</div>
<div class="text-right"><span class="name text-right">Jane Doe</span></div>
</div> -->

</div>