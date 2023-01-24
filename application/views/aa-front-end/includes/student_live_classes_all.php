  <div class="top-title mb-20">Upcoming Classes <span class="pull-right">
      <a href="<?php echo base_url('our_students/live_class_shedules_all'); ?>" class="font-12 red-text hide">VIEW MORE all</a>
     
        <span class="pull-right"><img id="ajax_refresh_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          <span class="btn btn-wht1 btn-sm font-12 red-text pointer" onclick="refresh_content();">
          <i class="fa fa-refresh text-green" aria-hidden="true"></i> Refresh</span>
          </span>

    </span></div>
  <div class="classroom-schedule-row classroom_section <?php echo $class_row; ?>">
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
       // date_default_timezone_set(TIME_ZONE);
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
        } else {
          $liveIn = 'Status <i class="fa fa-circle text-red" aria-hidden="true"></i>';
          $btnDisabled = 'disabled';
         // $btn_pointerevent = 'pointer-events: none;';
          $bgColor = "coming-Cl";
          $class = "class-card";
        }
      ?>      
      <?php include('classroom_schedule_html.php');?>          
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
 
  <?php if ($allClassSchedule > LOAD_MORE_LIMIT) { ?>
          <div class="text-center mb-10">
            <button class="btn btn-primary btn-sm loadmore" id="loadmore" onclick="loadmore();">Load More</button>
            <img id="ajax_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          </div>
        <?php } ?>
  <?php
  $idd = '#' . $_SESSION["firstId"];
  ?>
  <input type="hidden" name="offset" id="offset" value="0" />
  <script src="<?php echo site_url('resources-f/js/jquery.min.js'); ?>"></script>
  <script type="text/javascript">
    function loadmore() {
      var type="loadmore";
      ajax_data(type);
    }

    function ajax_data(type)
    {  
      
      if(type =='loadmore')
      {
      var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT; ?>);
      var offset_v = parseInt($('#offset').val());
      var newoffset = limit_v + offset_v;
      }
      else 
      {
      var newoffset =0;
      }  

      if(type =='refresh')
      {
      $('#ajax_refresh_loader').removeClass('hide')
      }
      else {
      $('#ajax_loader').removeClass('hide')
      }

      var class_date  = $("#class_date").val();
      var classname  = $("#classname").val();

      $.ajax({
        url: "<?php echo site_url('our_students/ajax_loadmore'); ?>",
        type: 'post',
        dataType: 'json',
        data: {
          offset: $('#offset').val(),class_date:class_date,classname:classname,type:type
        },
        success: function(data) 
        {      
          
            $('#ajax_loader').addClass('hide')
            $('#offset').val(newoffset)
            if(type =='refresh')
            {
              $('#ajax_refresh_loader').addClass('hide')
            }
            else {
              $('#ajax_loader').addClass('hide')
            }

            if(type =='loadmore')
            {
              $('.classroom_section').append(data['html']);
            }
            else
            {
             $('.classroom_section').html(data['html']);
            }

            if (data["count"] == 0) {
             $('.loadmore').addClass('hide')
            }
            return false;
        }
      })
    }
    function refresh_content() {
      var type="refresh";
      ajax_data(type);
    }
    
  function searchClass() { 
    var type="search";
    ajax_data(type);
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
        beforeSend: function() {
         
        }
      });
    }
  
     
      // setInterval(function() {
      
      //   $("<?php echo $idd; ?>").load(window.location.href + " <?php echo $idd; ?>");
      // }, 1000); // 60000=1m
      function refresh_content11() {
        
        $.ajax({
          url: "<?php echo site_url('our_students/ajax_liveClasses_all'); ?>",
          type: 'post',
          success: function(response) {
            // alert(response)  
            $('.classroom_section').html(response);
          },
          beforeSend: function() {
           
          }
        });
      }
 
  </script>