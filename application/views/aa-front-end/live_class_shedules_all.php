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
            <div class="filter-ylw-box ">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="form-group" id="search-icn">
                    <input type="text" name="classname" id="classname" class="fstinput filteraction" placeholder="Search" onkeyup="searchClass();">
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <!--                <div class="validation">Wrong</div>--></div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                    <input type="text" name="class_date" id="class_date" class="fstinput datepicker filteraction" placeholder="Date" autocomplete="off" readonly  onchange="searchClass();">
                    </select>
                  </div>
                  <!--                  <div class="validation">Wrong</div>--></div>
                <div class="col-md-12 col-sm-12" > <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i>Loading...Please Wait</span> <span class="pull-right font-weight-600" id="down"><a href="<?php echo site_url()?>our_students/live_class_shedules_all">Clear All </a></span> </div>
              </div>
            </div>
            <!-- start announcement -->
 <?php if($_SESSION['classroom_id']){ ?>
    <?php //nclude('includes/student_announcements.php');?>
     <?php
$classSchedule=$ClassSchedulea;
$class_row="";
$timelimit='1000';
$_SESSION['timelimit']=1000;
//$class_row="classrooms-row";
    include('includes/student_live_classes_all.php');?>
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
  var ref_content="";
/* $(document).ready(function(){
    setInterval(function(){
          $("<?php echo $idd;?>").load(window.location.href + " <?php echo $idd;?>" );
    }, 60000);
});*/







function searchClassp()
{

 clearInterval(ref_content);

    var class_date  = $("#class_date").val();
    var classname  = $("#classname").val();
   
     //var testtype_search  = $("#testtype_search").val();
     $.ajax({
          url: "<?php echo site_url('our_students/ajax_searchClass');?>",
          async : true,
          type: 'post',
          data: {class_date:class_date,classname:classname},
          success: function(data){
           
            if(data!=''){
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.success-res').show();*/
               $('.classroom_section').html(data);
            }else{
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.no-res').show();
              $('.success-res').hide();*/
               $('.classroom_section').html(data);
            }          
          },
          beforeSend: function(){            
            $('#flter-btm-info').removeClass('hide');             
          },
      });   

}
</script>