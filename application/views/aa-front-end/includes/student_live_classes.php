  <div class="top-title mb-20">Upcoming Classes
  <?php

//If there is no class scheduled, or if classes are less than 5, then hide Full Class Schedule page	

if (count($allClassSchedule->error_message->data) > 4) { ?>

  <span class="pull-right">

    <a href="<?php echo base_url('our_students/live_class_shedules_all'); ?>" class="font-12 red-text">VIEW MORE</a>

  </span>

<?php } ?>

  </div>
 
  <div class="classroom_section <?php echo $class_row;?>" id="scroll-style-x">
    


  <div class="classroom-schedule-row row ">

    <?php

    //classrooms-row;

    if (count($classSchedule->error_message->data) > 0) { ?>

      <?php

      $i = 0;

      foreach ($classSchedule->error_message->data as $p) { //echo "<pre>";

        //echo "<br>";

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

        //echo $diff;

        // if($diff >=0 AND $dmin <=CLASS_DURATION) AND $dmin <=$p->class_duration

        if ($diff >= 0 and $current_DateTimeStr <= $class_endat) {

          $liveIn = '<i class="fa fa-circle text-green" aria-hidden="true"></i> Live from ' . $totalmin;

          $btnDisabled = '';

          $btn_pointerevent = '';

          $bgColor = "live-Cl";

          $class = "l-class-card";
          $hreflink=$p->conf_URL;
          $target_bl='target="_blank"';
        } else {

          $liveIn = 'Status <i class="fa fa-circle text-red" aria-hidden="true"></i>';

          $btnDisabled = 'disabled';

          $btn_pointerevent = 'pointer-events:visible;';

          $bgColor = "coming-Cl";

          $class = "class-card";
          $hreflink="javascript:void(0)";
          $target_bl="";

        }

      ?>

        <div class="col-md-4">
<a href="<?php echo $hreflink;?>" class=" <?php echo $btnDisabled; ?> " onclick="class_att('<?php echo $p->id; ?>','<?php echo $_SESSION['classroom_isoffline'] ?>');" <?php echo $target_bl;?> <?php echo $btnDisabled; ?> style="<?php echo $btn_pointerevent; ?>">
          <div class="<?php echo $class; ?>">

            <div class="info">

              <h2><?php echo $day; ?> <?php echo $classDate2; ?> <span class="font-weight-300 text-white"> (<i><?php echo $p->dayname; ?></i>)</h2>

              <div>

                <p>TOPIC:</p>

                <p><?php echo substr($p->topic, 0, 21); ?></p>

              </div>

              <div class="mt-10">

                <p>DURATION:</p>

                <p><?php echo $p->class_duration . ' Minute(s)'; ?></p>

              </div>

              <div class="ftr-btm">

                <div class="time-info"><?php echo $day; ?> <?php echo $calssTime; ?></div>

                <?php

                if (!empty($p->conf_URL)) { ?>

                  <span class="btn btn-wht mt-15 mb-15 <?php echo $btnDisabled; ?>">Join Class</span>

                <?php } ?>

                <?php /* ?>

<a class="btn btn-wht mt-15 mb-15 <?php echo $btnDisabled;?> " onclick="class_att('<?php echo $p->id;?>','<?php echo $_SESSION['classroom_isoffline']?>');" " <?php echo $btnDisabled;?> style="<?php echo $btn_pointerevent;?>">Join Class</a>-->

<?php */ ?>

                <?php if ($i == 0) { ?>

                  <div id='<?php echo $_SESSION["firstId"]; ?>' class="status"><?php echo $liveIn; ?></div>

                <?php } else { ?>

                  <div class="status"><?php echo $liveIn; ?></div>

                <?php } ?>

              </div>

            </div>

          </div>
                </a>
        </div>

      <?php $i++;

      }

    } else {

      $_SESSION["firstId"] = ""; ?>

      <div class="col-md-4">

        <div class="class-card">

          <div class="info">

            <h2>No class is sheduled now!</h2>

          </div>

        </div>

      </div>

    <?php } ?>
    </div>
  </div>

  <?php

  $idd = '#' . $_SESSION["firstId"];

  ?>

  <script src="<?php echo site_url('resources-f/js/jquery.min.js'); ?>"></script>

  <script type="text/javascript">

    function class_att(sch_id, is_offline) {

      $.ajax({

        url: "<?php echo site_url('our_students/class_attandance'); ?>",

        type: 'post',

        data: {

          sch_id: sch_id,

          is_offline: is_offline

        },

        success: function(response) {

          //alert(response)  

          //$('.classroom_section').html(response);              

        },

        beforeSend: function() {

          // $('.complaintBtnDiv_pro').show(); 

          //  $('#reg_button').prop('disabled', true);

        }

      });

    }

    $(document).ready(function() {

      //alert('refresing')

      setInterval(function() {

        //alert();

        //console.log('kk')

    refresh_content();

        $("<?php echo $idd; ?>").load(window.location.href + " <?php echo $idd; ?>");

      }, 1000); // 60000=1m

      function refresh_content() {

        $.ajax({

          url: "<?php echo site_url('our_students/ajax_liveClasses'); ?>",

          type: 'post',

          success: function(response) {

            // alert(response)  

            $('.classroom_section').html(response);

          },

          beforeSend: function() {

            // $('.complaintBtnDiv_pro').show(); 

            //  $('#reg_button').prop('disabled', true);

          }

        });

      }

    });

  </script>