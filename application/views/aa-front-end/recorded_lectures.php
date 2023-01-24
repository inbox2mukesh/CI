<section class="lt-bg-lighter">
  <div class="container">
    <div class="content-wrapper">
      <!-- Left sidebar -->
      <?php include('includes/student_profile_sidebar_classroom.php'); ?>
      <!-- End Left sidebar -->
      <!-- Start Content Part -->
      <div class="content-aside classroom-dash-box">
        <div class="announcement-bar text-center">
          <ul>
            <li><span class="font-weight-600">CLASSROOM ID:</span><?php echo $_SESSION['classroom_name']; ?></li>
            <li><span class="font-weight-600">VALIDITY:</span><?php echo $_SESSION['classroom_Validity']; ?></li>
            <li><span class="font-weight-600">DAYS LEFT:</span><?php echo $_SESSION['classroom_daysleft']; ?></li>
          </ul>
        </div>
        <div class="content-part">
          <div class="filter-ylw-box">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group" id="search-icn">
                  <input type="text" name="fname" class="fstinput" id="rl_search" placeholder="Search" onkeyup="searchRecordedlecture();">
                  <button type="submit"><i class="fa fa-search"></i></button>
                  <!--div class="validation">Wrong</div>-->
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <select class="selectpicker form-control" data-live-search="true" onchange="searchRecordedlecture();" id="rl_content_type">
                    <option value="">Select Topic</option>
                    <?php foreach ($GET_REC_LEC_CONTENT_TYPE_URL->error_message->data as $p) { ?>
                      <option value="<?php echo $p->id; ?>"><?php echo $p->content_type_name ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12 col-sm-12" id="">
                <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i> Loading...Please Wait</span>
                <span class="pull-right font-weight-600" id="down"><a href="<?php echo site_url() ?>our_students/recorded_lectures">Clear All </a></span>
              </div>
            </div>
          </div>
          <div class="top-title mb-20 text-uppercase">Recorded Lectures  
          <span class="pull-right"><img id="ajax_refresh_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          <span class="btn btn-wht1 btn-sm font-12 red-text pointer" onclick="refresh_rec_lecture();">
          <i class="fa fa-refresh text-green" aria-hidden="true"></i> Refresh</span>
          </span>
          </div>
          <div class="classroom-schedule-row recorded-lecture ui-recored-lectures" id="sec_recorded_lecture">
            <?php
            if (count($REC_LEC_URL->error_message->data) > 0) {
              $i = 1;
              foreach ($REC_LEC_URL->error_message->data as $p) {
            ?>
              <?php include('includes/classroom_recorded_lecture_withoutrefresh_html.php');?>
              <?php $i++;
              }
            } else {
              ?>
              <div class="col-md-12">
                <div class="info">
                  <div class="text-red font-weight-500">No recorded lectures found!</h2>
                </div>
              </div>
            <?php
            } ?>
 </div>
        </div>
        <?php if ($REC_LEC_URL_COUNT > LOAD_MORE_LIMIT) { ?>
          <div class="text-center mb-10">
            <button class="btn btn-primary btn-sm loadmore" id="loadmore" onclick="loadmore();">Load More</button>
            <img id="ajax_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          </div>
        <?php } ?>
      </div>
      <!-- End Content Part -->
    </div>
  </div>
</section>
<input type="hidden" name="offset" id="offset" value="0" />
<script>
  function loadmore() 
  {
    var type="loadmore";
    rec_lec_data(type);
  }
  function rec_lec_data(type)
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
    var rl_content_type = $("#rl_content_type").val();
    var rl_search = $("#rl_search").val();   
    $.ajax({
      url: "<?php echo site_url('our_students/ajax_loadmore_recordedlectures'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val(), rl_content_type: rl_content_type,
        rl_search: rl_search,type:type
      },
      success: function(data) {      
        if(type =='refresh')
        {
        $('#ajax_refresh_loader').addClass('hide')
        }
        else {
        $('#ajax_loader').addClass('hide')
        }
        if(type =='loadmore')
        {
        $('#sec_recorded_lecture').append(data['html']);
        }
        else
        {
        $('#sec_recorded_lecture').html(data['html']);
        }
        $('#offset').val(newoffset)       
        if (data["count"] == 0) {
          $('.loadmore').addClass('hide')
        }
        else {
          $('.loadmore').removeClass('hide')
        }
        $('.media-start').each(function(i)
        {
        $(this).get(i).currentTime = 0;
        })       
        return false;
      }
    })
  }
  function refresh_rec_lecture() {
    var type="refresh";
    rec_lec_data(type);
  }
  function searchRecordedlecture() {
    var type="search";
    rec_lec_data(type);    
  }
  $(document).on("click",".lecture-video-box a", function() {
    $(this).parent().parent().addClass("popup-active");
    $('.media-start').each(function(i){
         $(this).get(i).currentTime = 0;
    })    
  });
  $(document).on("click",".recorded-lecture .close",function() {
    $(".recorded-lecture .r-lecture").removeClass("popup-active");
    $('.media-start').each(function(i){
      $(this).get(i).currentTime = 0;
    })  
  });
</script>
<!--Video Modal-->
<script>
$(document).ready(function() { 
  $(".ui-recored-lectures .rcd-lecture").each(function(i){		
        $(this).addClass("c-"+i);		
        $(this).children().eq(0).click(function(){	
          $(".c-"+i).find(".video-popup-widget").css("display","block");
          $(".video-overlay").remove();
          $("body").append("<div class='video-overlay'></div>");
          $('.media-start').get(i).currentTime = 0;    
        });
      });	
});
$(".close-tag").click(function(){   
    $(".video-popup-widget").css("display","none");
    $(".video-overlay").remove();
})
</script>
<!--End Video Modal-->