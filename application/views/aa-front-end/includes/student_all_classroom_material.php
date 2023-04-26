<!--SECTION: LIVE CLASSES--->


<div class="classroom_section <?php echo $class_row; ?>" id="scroll-style-x">
<?php  if($allClassSchedule>0) {?>
<div class="head-title">
  <div class="top-title mb-20 text-uppercase">Upcoming Classes
  <?php
 if ($allClassSchedule > 3) { ?>
  <span class="pull-right"><a href="<?php echo base_url('our_students/live_class_shedules_all'); ?>" class="font-11 btn btn-wht">VIEW MORE</a></span>
  <?php } ?>
  </div>
</div>
<?php }?>
  <?php
  // classroom schedule section
  if (isset($allClassroomMaterial) && count($allClassroomMaterial->error_message->data->classroom_schedule) > 0)
  { ?>
  <div class="classroom-schedule-row row">
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
        $calssTime=date('h:i A', strtotime($p->dateTime));
        //$calssTime = trim(substr($p->dateTime, 11));
        $today  = date('d-m-Y');
        $todayStr = strtotime($today);
        $classDateStr = strtotime($classDate);
        if ($classDateStr == $todayStr) {
          $day = 'Today - ';
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
    //  date_default_timezone_set(TIME_ZONE);        
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
       $totalhour = $diffh->format("%h");
        if($totalhour >0)
{
$totalmin=$totalhour.' Hour'.' '. $diffh->format("%i Min");
}
else {
  $totalmin = $diffh->format("%i Min");
}
      //echo $diff;  
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
          // $btn_pointerevent = 'pointer-events:visible;';
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
  <?php if (isset($allClassroomMaterial) &&  isset($_SESSION['classroom_id']) && is_countable($allClassroomMaterial->error_message->data->classroom_doc) && count($allClassroomMaterial->error_message->data->classroom_doc) > 0) { 
   
    ?>
  <div class="clearfix"> 
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
  <div class="clearfix"> 
    <div class="head-title">
    <div class="top-title mb-20 mt-20 text-uppercase">Recent Recorded Lectures
    <?php if ($REC_LEC_URL_COUNT > 3) { ?>
    <span class="pull-right"><a href="<?php echo base_url('our_students/recorded_lectures'); ?>" class="font-11 btn btn-wht">VIEW MORE</a></span>
    <?php }?>
    </div>
    </div>
    <div class="classroom-schedule-row recorded-lecture clearfix ui-student-classroom" id="sec_recorded_lecture">
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
 if (isset($allClassroomMaterial) && count($allClassroomMaterial->error_message->data->classroom_schedule) == 0 AND count($allClassroomMaterial->error_message->data->classroom_doc) == 0 AND count($allClassroomMaterial->error_message->data->classroom_lecture) == 0)
 {
 ?>
 <div class="col-md-12">
 <div class="text-red font-weight-500">No record found!</div>
      </div>

 <?php
 }
?>
</div>
<?php
$idd = (isset($_SESSION["firstId"]) && !empty($_SESSION["firstId"]))?'#' . $_SESSION["firstId"]:'';
?>

<script src="<?php echo site_url('resources-f/js/jquery.min.js'); ?>" ></script>
<script type="text/javascript">


var myInterval;

function setint()
{
  myInterval= setInterval(function() {
      refresh_content();
    }, '<?php echo CLASSROOM_ALL_MATERIAL_REFRESH_TIME;?>'); // 60000=1m

}
setint(); 

function clearInt() {
  clearInterval(myInterval);
}
  $(document).ready(function() {
    $(document).on('click','.ancher_video',function(){
      clearInt();
    });
    $(document).on('click','.close_ancher_video',function(){
      setint();
    });
  });


  function refresh_content() {
      $.ajax({
        url: "<?php echo site_url('our_students/ajax_liveClasses'); ?>",
        type: 'post',
        success: function(response) {
         //alert(response)
          $('.classroom_section').html(response);
        },
      });
    }



    function class_att(sch_id, is_offline) {
    $.ajax({
      url: "<?php echo site_url('our_students/class_attandance'); ?>",
      type: 'post',
      data: {
        sch_id: sch_id,
        is_offline: is_offline
      },
      success: function(response) {
        
      },
    });
  }

  $(".lecture-video-box  > a").each(function(i) {
    $(this).on("click", function() {
      $(this).parent().parent().addClass("popup-active");
      $('.media-start').get(i).currentTime = 0;
    });
  });

  $(".recorded-lecture .close").each(function(i) {
    $(this).on("click", function() {
      $(".recorded-lecture .r-lecture").removeClass("popup-active");
      $('.media-start').get(i).currentTime = 0;
    });
  });


</script>

