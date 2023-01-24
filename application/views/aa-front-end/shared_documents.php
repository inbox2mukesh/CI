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
                  <input type="text" name="fname" id="sd_search" class="fstinput" placeholder="Search" onkeyup="searchSharedDoc();">
                  <button type="submit"><i class="fa fa-search"></i></button>
                  <!--								<div class="validation">Wrong</div>-->
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <select class="selectpicker form-control" data-live-search="true" onchange="searchSharedDoc();" id="sd_content_type">
                    <option value="">Select Topic</option>
                    <?php foreach ($SHARED_DOCS_CONTENT_TYPE_URL->error_message->data as $p) { ?>
                      <option value="<?php echo $p->id ?>"><?php echo $p->content_type_name ?></option>
                    <?php } ?>
                  </select>
                </div>
                <!--									<div class="validation">Wrong</div>-->
              </div>
              <div class="col-md-12 col-sm-12"> <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i>Loading...Please Wait</span> <span class="pull-right font-weight-600" id="down"><a href="<?php echo site_url() ?>our_students/shared_documents">Clear All </a></span> </div>
            </div>
          </div>
          <div class="top-title mb-20 text-uppercase">Classroom Material
            <?php
            if (count($allSharedDocs->error_message->data) > 0) {
            ?>
              <span class="pull-right"><img id="ajax_refresh_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
                <span class="btn btn-wht1 btn-sm font-12 red-text pointer" onclick="refresh_document();">
                  <i class="fa fa-refresh text-green" aria-hidden="true"></i> Refresh</span>
              </span>
            <?php } ?>
          </div>
          <div class="classroom-schedule-row " id="Shareddoc_section">
            <?php if ($_SESSION['classroom_id'] and count($allSharedDocs->error_message->data) > 0) { ?>
              <?php
              //	echo "<pre>"; 
              foreach ($allSharedDocs->error_message->data as $p) {
                $con_type_val = "";
                foreach ($p->ContentType as $con_type) {
                  //echo $con_type;
                  $con_type_val .= $con_type->content_type_name . ', ';
                }
              ?>
               <?php include('includes/classroom_material_html.php');?>
                
              <?php }
            } else { ?>
              <div class="col-md-12">
              
                  <div class="info">
                    <div class="text-red font-weight-500"> No classroom material is available now!</div>
                  </div>
               
              </div>
            <?php } ?>
          </div>
        </div>
        <?php
        if ($allSharedDocsCount > LOAD_MORE_LIMIT) { ?>
          <div class="text-center mb-10">
            <button class="btn btn-primary btn-sm loadmore" id="loadmore" onclick="loadmore();">Load More</button>
            <img id="ajax_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          </div>
        <?php } ?>
      </div>
      <!-- End Content Part -->
    </div>
  </div>
  <input type="hidden" name="offset" id="offset" value="0" />
</section>
<script>
  function loadmore() {
    var sd_content_type = $("#sd_content_type").val();
    var sd_search = $("#sd_search").val();
    
    $('#ajax_loader').removeClass('hide')
    var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT; ?>);
    var offset_v = parseInt($('#offset').val());
    var newoffset = limit_v + offset_v;

    if(sd_content_type !="" || sd_search !="")
    {
      $.ajax({
      url: "<?php echo site_url('our_students/ajax_searchSharedDoc'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val(),sd_content_type: sd_content_type,sd_search: sd_search
      },
      success: function(data) {
        $('#ajax_loader').addClass('hide')
        $('#Shareddoc_section').append(data['html']);
        $('#offset').val(newoffset)
        if (data["count"] == 0) {
          $('.loadmore').addClass('hide')
        }
        else{
          $('.loadmore').removeClass('hide')
        }
        return false;
      }
    })

    }
    else {
      $.ajax({
      url: "<?php echo site_url('our_students/ajax_loadmore_classroomDoc'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val(),sd_content_type: sd_content_type,sd_search: sd_search
      },
      success: function(data) {
        $('#ajax_loader').addClass('hide')
        $('#Shareddoc_section').append(data['html']);
        $('#offset').val(newoffset)
        if (data["count"] == 0) {
          $('.loadmore').addClass('hide')
        }
        else{
          $('.loadmore').removeClass('hide')
        }
        return false;
      }
    })
    }

   
  }
  // $(document).ready(function(){    
  //   setInterval(function(){       
  //   refresh_document();
  //   }, 300000);// 60000=1m ,300000=5m
  // })
  function refresh_document() {
    $('#offset').val(0)
    $('#ajax_refresh_loader').removeClass('hide')
    $.ajax({
      url: "<?php echo site_url('our_students/ajax_shareddocuement'); ?>",
      type: 'post',
      dataType: 'json',
      success: function(data) {
        $('#Shareddoc_section').html(data['html']);
        $('#ajax_refresh_loader').addClass('hide')
        if (data["count"] == 0) {
          $('.loadmore').addClass('hide')
        }
        else{
          $('.loadmore').removeClass('hide')
        }
        
      },
      beforeSend: function() {}
    });
  }

  function searchSharedDoc() {
    $('#offset').val(0)
    var sd_content_type = $("#sd_content_type").val();
    var sd_search = $("#sd_search").val();
    var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT; ?>);
    var offset_v = parseInt($('#offset').val());
    var newoffset = limit_v + offset_v;
    $.ajax({
      url: "<?php echo site_url('our_students/searchSharedDoc'); ?>",
      async: true,
      type: 'post',
      dataType: 'json',
      data: {
        sd_content_type: sd_content_type,
        sd_search: sd_search
      },
      success: function(data) {
        //alert(data['count']);
        if (data['html'] != '') {
          $('#flter-btm-info').addClass('hide');
          $('#Shareddoc_section').html(data['html']);
          if(data['count'] >0)
          {
            $('#offset').val(newoffset)
          }
         
        } else {
          $('#flter-btm-info').addClass('hide');
          $('#Shareddoc_section').html(data['html']);
        }
      },
      beforeSend: function() {
        $('#flter-btm-info').removeClass('hide');
      },
    });
  }
</script>