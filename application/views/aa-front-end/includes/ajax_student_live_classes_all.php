<?php
if (count($classSchedule->error_message->data) > 0) { ?>
  <?php
  $i = 0;
  foreach ($classSchedule->error_message->data as $p) { //echo "<pre>";
   
    if ($i == 0) {
      $_SESSION["firstId"] = $p->id;
    }
    $classDate = trim(substr($p->dateTime, 0, 10));
    $date = date_create($classDate);
    $classDate2 = date_format($date, "M d, Y");
    $calssTime=date('h:i A', strtotime($p->dateTime));
    $today  = date('d-m-Y');
    $todayStr = strtotime($today);
    $classDateStr = strtotime($classDate);
    if ($classDateStr == $todayStr) {
      $day = 'Today:';
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
    if ($diff >= 0 and $current_DateTimeStr <= $class_endat) {
      $liveIn = '<i class="fa fa-circle text-green" aria-hidden="true"></i> Live from ' . $totalmin;
      $btnDisabled = '';
      $bgColor = "live-Cl";
      $class = "l-class-card";
      $btn_pointerevent = '';
      $class = "l-class-card";
      $hreflink = $p->conf_URL;
      $target_bl = 'target="_blank"';
    } else {
      $liveIn = 'Status <i class="fa fa-circle text-red" aria-hidden="true"></i>';
      $btnDisabled = 'disabled';
      $btn_pointerevent = 'pointer-events:visible;';
      $bgColor = "coming-Cl";
      $class = "class-card";
      $class = "class-card";
      $hreflink = "javascript:void(0)";
      $target_bl = "";
    }
  ?>
    <?php include('classroom_schedule_html.php');?>         
  <?php $i++;
  }
} else {
  $_SESSION["firstId"] = ""; ?>
  <div class="row">
    <div class="col-md-4">
      <div class="class-card">
        <div class="info">
          <h2>No class is sheduled now!</h2>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
