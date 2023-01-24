<?php 


if(count($classSchedule->error_message->data)>0){ ?>

  <div class="classroom-schedule-row row ">

<?php

$i=0;

foreach($classSchedule->error_message->data as $p){ //echo "<pre>";



//print_r($p);

//echo "<br>";

if($i==0){

$_SESSION["firstId"] = $p->id;

}    



$classDate = trim(substr($p->dateTime,0,10));

$date=date_create($classDate);

$classDate2 = date_format($date,"M d, Y");



$calssTime=date('h:i A', strtotime($p->dateTime));



$today  = date('d-m-Y');

$todayStr = strtotime($today);

$classDateStr = strtotime($classDate);



if($classDateStr==$todayStr){

$day = 'Today:';

}else{

$day = '';

}



if($p->fname=='' and $p->lname==''){

$trainerName = 'Not mentioned!';

}else{

$trainerName = $p->fname.' '.$p->lname;

if($p->gender==1){

$trainerName = 'Mr. '.$trainerName;

}elseif($p->gender==2){

$trainerName = 'Ms. '.$trainerName;

}else{

$trainerName = $trainerName;

}

} 

//date_default_timezone_set(TIME_ZONE);  

$current_DateTime = date("d-m-Y G:i");
$current_DateTimeStr = strtotime($current_DateTime);//500-200=300
$class_DateTimeStr = $p->strdate;//500
$datetime_from = strtotime("-1 minutes", $p->strdate); 
$class_endat = strtotime('+ '.$p->class_duration.' minutes',  $p->strdate);
$diff = $current_DateTimeStr-$datetime_from;

$dmin=date('i', $diff);



$date1=date_create($p->dateTime);

$date2=date_create($current_DateTime);

$diffh=date_diff($date1,$date2);

$totalmin=$diffh->format("%i Min");





 if($diff >=0 AND $current_DateTimeStr<=$class_endat)

        {          

          $liveIn = '<i class="fa fa-circle text-green" aria-hidden="true"></i> Live from '. $totalmin;

$btnDisabled = '';

$bgColor = "live-Cl";

$class = "l-class-card";

 $btn_pointerevent = '';
 $class = "l-class-card";
 $hreflink=$p->conf_URL;
 $target_bl='target="_blank"';

}else{

$liveIn = 'Status <i class="fa fa-circle text-red" aria-hidden="true"></i>';

$btnDisabled = 'disabled';

$btn_pointerevent = 'pointer-events:visible;';

$bgColor = "coming-Cl";

$class = "class-card";

 $class = "class-card";
          $hreflink="javascript:void(0)";
          $target_bl="";
} 

?>



<div class="col-md-4">
<a href="<?php echo $hreflink;?>" class=" <?php echo $btnDisabled; ?> " onclick="class_att('<?php echo $p->id; ?>','<?php echo $_SESSION['classroom_isoffline'] ?>');" <?php echo $target_bl;?> <?php echo $btnDisabled; ?> style="<?php echo $btn_pointerevent; ?>">
<div class="<?php echo $class;?>">

<div class="info">

<h2><?php echo $day;?> <?php echo $classDate2;?> <span class="font-weight-300 text-white"> (<i><?php echo $p->dayname;?></i>)</h2>

<div>

<p>TOPIC:</p>

<p><?php echo substr($p->topic,0,21);?></p>

</div>

<div class="mt-10">

<p>DURATION:</p>

<p><?php echo $p->class_duration.' Minute(s)';?></p>

</div>

<div class="ftr-btm">

<div class="time-info"><?php echo $day;?> <?php echo $calssTime;?></div>

<?php /* ?> 

<a   href="<?php echo $p->conf_URL;?>" class="btn btn-wht mt-15 mb-15 <?php echo $btnDisabled;?>"  target="_blank" style="<?php echo $btn_pointerevent;?>">Join Class</a><?php */?>

<?php

                         if(!empty($p->conf_URL)) {?>
<span class="btn btn-wht mt-15 mb-15 <?php echo $btnDisabled; ?>">Join Class</span>

<?php }?>

<?php

                         if(!empty($p->conf_URL)) {?>

<?php if($i==0)

{ ?>

<div id='<?php echo $_SESSION["firstId"];?>' class="status"><?php echo $liveIn;?></div>

<?php }else{ ?>

<div class="status"><?php echo $liveIn;?></div>

<?php } ?>      <?php } ?>                 



</div>

</div>

</div>
</a>
</div>

<?php  $i++;}} else { $_SESSION["firstId"]="";?>

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
       
  </div>  
    
  <?php 
              if($allClassSchedule->error_message->data > 0)
              {
            ?>
  <button class="btn btn-primary btn-sm loadmore" id="" onclick="loadmore();">Load More</button>
  <?php }?>

