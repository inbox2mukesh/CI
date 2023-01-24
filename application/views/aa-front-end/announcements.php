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
					<div class="top-title mb-20"><?php echo $title ?>
					
			<?php
            	if(count($announcements->error_message->data) > 0){
            ?>
              <span class="pull-right"><img id="ajax_refresh_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
                <span class="btn btn-wht1 btn-sm font-12 red-text pointer" onclick="refresh_announcement();">
                  <i class="fa fa-refresh text-green" aria-hidden="true"></i> Refresh</span>
              </span>
            <?php } ?>
				
				</div>
				<div class="announcement">
					<?php if (count($announcements->error_message->data) > 0) { ?>
						<?php if ($_SESSION['classroom_id']) { ?>
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<?php
								$i = 0;
								foreach ($announcements->error_message->data as $p) {
									if ($segment2 == '') {
										if ($i == 0) {
											$in = 'in';
										} else {
											$in = '';
										}
									} elseif ($segment2 == $p->id){
										$in = 'in';
									} else {
										$in = '';
									}
									$custom_class="";
									if(empty($p->media_file) and empty($p->body)){
										$custom_class="no-panel-body";
									}
								?>
									<div class="panel">
										<div class="panel-heading">
											<div class="panel-title <?php echo $custom_class;?>"> <a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#toggle' . $p->id; ?>" class=""><span class="open-sub"></span>
												<div class="date-bar">
													<div class="title"><?php echo $p->created; ?></div><span class="mb-inline"><?php echo $p->subject; ?> </span>
												</div>
											</a> </div>
										</div>
										<?php
											if($p->media_file or $p->body){
										?>
										<div id="<?php echo 'toggle' . $p->id; ?>" class="panel-collapse collapse <?php echo $in; ?>">
											<div class="panel-body"> 
												<?php
													if($p->media_file){
												?>
												<img src="<?php echo site_url(str_replace("./","",ANNOUNCEMENT_FILE_PATH) . '' . $p->media_file); ?>" class="pull-left img-responsive col-md-5 no-padding-left">
												<?php } ?>
										<?php echo $p->body; ?>
											</div>
										</div>
									<?php } ?>

									</div>
								<?php $i++;
								} ?>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="info">
							<h2 class="text-red">No Announcement Found</h2>
						</div>
					<?php
					} ?>
				</div>
				</div>
				<?php
        if ($announcements_count > LOAD_MORE_LIMIT_10) { ?>
          <div class="text-center mb-10">
            <button class="btn btn-primary btn-sm loadmore" id="loadmore" onclick="loadmore();">Load More</button>
            <img id="ajax_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">
          </div>
        <?php } ?>
			</div>
			<!-- End Content Part -->
			
		</div>
		<input type="hidden" name="offset" id="offset" value="0" />
	</div>
</section>

<script>
  function loadmore() {
    
    $('#ajax_loader').removeClass('hide')
    var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT_10; ?>);
    var offset_v = parseInt($('#offset').val());
    var newoffset = limit_v + offset_v;

    
      $.ajax({
      url: "<?php echo site_url('our_students/ajax_loadmore_announcement'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val()
      },
      success: function(data) {
        $('#ajax_loader').addClass('hide')
        $('.announcement').append(data['html']);
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
  function refresh_announcement() {
    $('#offset').val(0)
    $('#ajax_refresh_loader').removeClass('hide')
    $.ajax({
      url: "<?php echo site_url('our_students/ajax_refresh_announcement'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val()
      },
      success: function(data) {
        $('#ajax_refresh_loader').addClass('hide')
        $('.announcement').html(data['html']);      
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
  
</script>