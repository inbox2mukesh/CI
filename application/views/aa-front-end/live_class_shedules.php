<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
          <?php include('includes/student_profile_sidebar_classroom.php');?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside classroom-dash-box">
          <div class="announcement-bar text-center">
            <ul>
              <li><span class="font-weight-600">CLASSROOM ID:</span> <?php echo $_SESSION['classroom_name'];?></li>
              <li><span class="font-weight-600">VALIDITY:</span> <?php echo $_SESSION['classroom_Validity'];?></li>
              <li><span class="font-weight-600">DAYS LEFT:</span> <?php echo $_SESSION['classroom_daysleft'];?></li>
            </ul>
          </div>
          <div class="content-part">
            <!-- start announcement -->
 <?php if($_SESSION['classroom_id']){ ?>
    <?php include('includes/student_announcements.php');?>
     <?php
$classSchedule=$allClassSchedule;
$class_row="classrooms-row";
      include('includes/student_live_classes.php');?>
 <?php } ?>
<!-- end announcement -->
          
          </div>
        </div>
        <!-- End Content Part -->
      </div>
    </div>
  </section>
  <?php 
  $idd = '#'.$_SESSION["firstId"];
?> 
<script src="<?php echo site_url('resources-f/js/jquery.min.js');?>"></script>
<?php if(base_url()!=BASEURL){ ?>
<script type="text/javascript">
  /*$(document).bind("contextmenu", function (e){
    e.preventDefault();
  });*/
</script>
<?php } ?>

<script type="text/javascript">
 $(document).ready(function(){
    setInterval(function(){
          $("<?php echo $idd;?>").load(window.location.href + " <?php echo $idd;?>" );
    }, 60000);
});
</script>