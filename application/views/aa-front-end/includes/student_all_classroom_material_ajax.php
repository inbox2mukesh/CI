  <div class="classroom-schedule-row">
  <?php  if($allClassSchedule>0) {?>
<div class="head-title m-10">
  <div class="top-title mb-20  text-uppercase">Upcoming Classes
  <?php
 if ($allClassSchedule > 3) { ?>
  <span class="pull-right"><a href="<?php echo base_url('our_students/live_class_shedules_all'); ?>" class="font-11 btn btn-wht">VIEW MORE</a></span>
  <?php } ?>
  </div>
</div>
<?php }?>
<?php

  // classroom schedule section
  if (!empty($allClassroomMaterial) && count($allClassroomMaterial->error_message->data->classroom_schedule) > 0)
  { ?>
  <?php
      $i = 0;
      foreach ($allClassroomMaterial->error_message->data->classroom_schedule as $p) 
      {
        if ($i == 0) {
          $_SESSION["firstId"] = $p->id;
        }
        $classDate = trim(substr($p->dateTime, 0, 10));
        $date = date_create($classDate);
        $classDate2 = date_format($date, "M d, Y");
        //$calssTime = trim(substr($p->dateTime, 11));
        $calssTime=date('h:i A', strtotime($p->dateTime));
        $today  = date('d-m-Y');
        $todayStr = strtotime($today);
        $classDateStr = strtotime($classDate);
        if ($classDateStr == $todayStr) {
          $day = 'Today :';
        } else {
          $day = '';
        }
        if ($p->fname == '' and $p->lname == '') {
          $trainerName = 'Not mentioned!';
        } else {
          $trainerName = $p->fname . ' ' . $p->lname;
          if ($p->gender == 1) {
            $trainerName = 'Mr. ' . $trainerName;
          } elseif ($p->gender == 2) {
            $trainerName = 'Ms. ' . $trainerName;
          } else {
            $trainerName = $trainerName;
          }
        }
        //date_default_timezone_set(TIME_ZONE);
        $current_DateTime = date("d-m-Y G:i");
        $current_DateTimeStr = strtotime($current_DateTime); //500-200=300
        $class_DateTimeStr = $p->strdate; //500
        $datetime_from = strtotime("-1 minutes", $p->strdate);
        $class_endat = strtotime('+ ' . $p->class_duration . ' minutes',  $p->strdate);
        $diff = $current_DateTimeStr - $datetime_from;
        $dmin = date('i', $diff);
        $date1 = date_create($p->dateTime);
        $date2 = date_create($current_DateTime);
        $diffh = date_diff($date1, $date2);
        $totalmin = $diffh->format("%i Min");
        $totalhour = $diffh->format("%h");
        if($totalhour >0)
        {
        $totalmin=$totalhour.' Hour'.' '. $diffh->format("%i Min");
        }
        else {
          $totalmin = $diffh->format("%i Min");
        }
        if ($diff >= 0 and $current_DateTimeStr <= $class_endat) {
          $liveIn = '<i class="fa fa-circle text-green" aria-hidden="true"></i> Live from ' . $totalmin;
          $btnDisabled = '';
          $btn_pointerevent = '';
          $bgColor = "live-Cl";
          $class = "l-class-card";
          $hreflink = $p->conf_URL;
          $target_bl = 'target="_blank"';
        } else {
          $liveIn = 'Status <i class="fa fa-circle text-red" aria-hidden="true"></i>';
          $btnDisabled = 'disabled';
          $btn_pointerevent = 'pointer-events:visible;';
          $bgColor = "coming-Cl";
          $class = "class-card";
          $hreflink = "javascript:void(0)";
          $target_bl = "";
        }
      ?>
      <?php include('classroom_schedule_html.php');?>
      <?php }?>
  </div>
  <?php } ?>
  <!--ENDS--->
  <!--SECTION: SHARED DOC--->
  <?php if (isset($allClassroomMaterial) && isset($_SESSION['classroom_id']) && is_countable($allClassroomMaterial->error_message->data->classroom_doc) && count($allClassroomMaterial->error_message->data->classroom_doc) > 0) { ?>
  <div class="col-md-12 clearfix"> 
    <div class="head-title">
    <div class="top-title mb-20 mt-20 text-uppercase">Recent Classroom Material
    <?php if ($allSharedDocsCount > 3) { ?>
    <span class="pull-right"><a href="<?php echo base_url('our_students/shared_documents'); ?>" class="font-11 btn btn-wht">VIEW MORE</a></span>
    <?php } ?>
    </div>
    </div>
    <div class="classroom-schedule-row clearfix" id="Shareddoc_section">
   <?php
    //	echo "<pre>";
    foreach ($allClassroomMaterial->error_message->data->classroom_doc as $p) {
      $con_type_val = "";
      foreach ($p->ContentType as $con_type) {
        //echo $con_type;
        $con_type_val .= $con_type->content_type_name . ', ';
      }
    ?>
      <?php include('classroom_material_html.php');?>
    <?php }  ?>
</div>
  </div>
  <?php }?>
  <!--ENDS--->
  <!--SECTION: RECORDED LECTURE--->
  <?php
  if (isset($allClassroomMaterial) && count($allClassroomMaterial->error_message->data->classroom_lecture) > 0) 
  {
  ?>
  <div class="col-md-12 clearfix"> 
    <div class="head-title">
    <div class="top-title mb-20 mt-20 text-uppercase">Recent Recorded Lectures
    <?php if ($REC_LEC_URL_COUNT > 3) { ?>
    <span class="pull-right"><a href="<?php echo base_url('our_students/recorded_lectures'); ?>" class="font-11 btn btn-wht">VIEW MORE</a></span>
    <?php }?>
    </div>
    </div>
    <div class="row recorded-lecture clearfix" id="sec_recorded_lecture">
  <?php
    $i = 1;
    foreach ($allClassroomMaterial->error_message->data->classroom_lecture as $p) {
  ?>
    <?php include('classroom_recorded_lecture_html.php');?>

    <?php $i++; }?>
</div>
  </div>
  <?php }?>
   <!--ENDS--->
   <?php
if (empty($allClassroomMaterial->error_message->data))
 {
 ?>
 <div class="col-md-12">
 <div class="text-red font-weight-500">No record found!</div>
      </div>

 <?php
 }
?>