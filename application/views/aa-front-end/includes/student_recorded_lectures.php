<div class="head-title mt-10">
  <h2 class="text-uppercase font-weight-300 font-20">Recorded  <span class="text-theme-color-2 font-weight-500">Lectures</span></h2>
</div>
<div class="text-right"> <a class="btn view-all-btn btn-sm" href="<?php echo base_url('our_students/recorded_lectures');?>">View All Recorded Lectures</a></div> 

<!-- end title section -->
<div class="row mt-20">
<div class="col-md-12">
<ul id="myTab" class="nav nav-tabs boot-tabs">
  <?php 
      $i=0;
      foreach($recordedLecturesCat->error_message->data as $p){
        if($i==0){
          $active = 'active';
        }else{
          $active = '';
        }
  ?>
  <li class="<?php echo $active;?>">
    <a href="<?php echo '#'.$p->category_name;?>" data-toggle="tab"><?php echo $p->category_name;?></a>
  </li>  
  <?php $i++;} ?>
</ul>
<?php if(count($recordedLecturesCat->error_message->data)>0){ ?>
<div id="myTabContent" class="tab-content">

<div class="tab-pane fade in active" id="Listening">
<div class="row">
  <?php      
      foreach($recordedLectures_Listening->error_message->data as $p){        
  ?>
  <div class="col-md-3">
    <div class="fluid-width-video-wrapper" style="padding-top: 100%;">
      <iframe class="embed-responsive-item" src="<?php echo $p->video_url;?>" id="fitvid0"></iframe>
    </div>
    <div class="testimonial-caption clearfix">
      <p> <?php echo $p->live_lecture_title;?></p>
      <span class="text-gray-darkgray"><i><?php echo $p->created;?></i></span>
    </div>
  </div>
<?php } ?>
</div>
</div>


<div class="tab-pane fade in" id="Reading">
<div class="row">
  <?php      
      foreach($recordedLectures_Reading->error_message->data as $p){        
  ?>
  <div class="col-md-3">
    <div class="fluid-width-video-wrapper" style="padding-top: 100%;">
      <iframe class="embed-responsive-item" src="<?php echo $p->video_url;?>" id="fitvid0"></iframe>
    </div>
    <div class="testimonial-caption clearfix">
      <p> <?php echo $p->live_lecture_title;?></p>
      <span class="text-gray-darkgray"><i><?php echo $p->created;?></i></span>
    </div>
  </div>
<?php } ?>
</div>
</div>

<div class="tab-pane fade in" id="Writing">
<div class="row">
  <?php      
      foreach($recordedLectures_Writing->error_message->data as $p){        
  ?>
  <div class="col-md-3">
    <div class="fluid-width-video-wrapper" style="padding-top: 100%;">
      <iframe class="embed-responsive-item" src="<?php echo $p->video_url;?>" id="fitvid0"></iframe>
    </div>
    <div class="testimonial-caption clearfix">
      <p> <?php echo $p->live_lecture_title;?></p>
      <span class="text-gray-darkgray"><i><?php echo $p->created;?></i></span>
    </div>
  </div>
<?php } ?>
</div>
</div>

<div class="tab-pane fade in" id="Speaking">
<div class="row">
  <?php      
      foreach($recordedLectures_Speaking->error_message->data as $p){        
  ?>
  <div class="col-md-3">
    <div class="fluid-width-video-wrapper" style="padding-top: 100%;">
      <iframe class="embed-responsive-item" src="<?php echo $p->video_url;?>" id="fitvid0"></iframe>
    </div>
    <div class="testimonial-caption clearfix">
      <p> <?php echo $p->live_lecture_title;?></p>
      <span class="text-gray-darkgray"><i><?php echo $p->created;?></i></span>
    </div>
  </div>
<?php } ?>
</div>
</div>

</div>
<?php } else{ ?>
<div class="classwork-section text-red text-center font-weight-300 font-18 mt-10">
No lectures available now!
</div>
<?php } ?>


</div>
</div>