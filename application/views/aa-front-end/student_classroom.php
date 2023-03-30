<section class="lt-theme-bg">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
          <?php include('includes/student_profile_sidebar_classroom.php');?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside classroom-dash-box">
          <div class="announcement-bar text-center">
            <ul>
              <li><span class="font-weight-600">CLASSROOM ID:</span><?php echo $_SESSION['classroom_name'];?></li>
              <li><span class="font-weight-600">VALIDITY:</span><?php echo $_SESSION['classroom_Validity'];?></li>
              <li><span class="font-weight-600">DAYS LEFT:</span><?php echo $_SESSION['classroom_daysleft'];?></li>
            </ul>
          </div>
          <div class="content-part">
            <!-- start announcement -->
 <?php if($_SESSION['classroom_id']){ ?>
    <?php include('includes/student_announcements.php');?>

     <?php
     $class_row="";
     include('includes/student_all_classroom_material.php');?>
 <?php } ?>
<!-- end announcement -->

          </div>
        </div>
        <!-- End Content Part -->
      </div>
    </div>
  </section>
  <?php
  $idd = (isset($_SESSION["firstId"]))?'#'.$_SESSION["firstId"]:'';
?>



