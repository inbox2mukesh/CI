

 <div class="col-md-4 col-sm-6 rcd-lecture r-lecture ">
   <div class="video-popup">
   <div class="classroom-info-box">
   <div class="top-sec">
        <div class="icon"><img src="<?php echo site_url() ?>resources-f/images/video-call.svg" alt=""></div>
        <div class="c-info">
        <div class="t-head limit-one-line"><?php echo $p->live_lecture_title ?></div>
        <div class="limit-one-clone"></div>
      </div>
	  </div>
	  <div class="ft">
        <ul>
        <li><span class="font-weight-600 mr-2">Topic:</span><?php echo $p->content_type_name ?></li>
        <li><span class="font-weight-600 mr-2">Date:</span><?php echo $p->created ?></li>
        </ul>
        </div>
        </div>
		</div>

<div class="video-popup-widget" style="display: none">
    <h2><?php echo $p->live_lecture_title ?></h2>
			<div class="close-tag" href="#">&times;</div>
			<div class="content">
			<div class="embed-responsive" style="height:440px!important;">	
         <video style="height:440px!important;object-fit:cover;width: -webkit-fill-available;" class="media-start"autoplay preload="auto" loop="loop" muted="muted" controls controlsList="nodownload" controlsList="noplaybackrate" disablepictureinpicture>
                  <source src="<?php echo $p->video_url ?>">
         </video>
		
			</div>
			</div>
</div>
</div>

<script>

$('.limit-one-line').each(function(i){
	$(this).addClass('ot_'+i);
	var jh22 = $('.ot_'+i ).text();
	$('.ot_'+i).next().html(jh22);
	var textlenght1 = $('.ot_'+i).text().length;
	var textcorrect1 =  $('.ot_'+i).text();
	if (textlenght1 > 50) {
	$('.ot_'+i).next().text($(this).text().substr(0,50)+'...');
	}

	$(this).next().hover(function(){
	if (textlenght1 > 50) {
		$('.ot_'+i).addClass("active");
		var hg1 = $('.ot_'+i).height()+5;
		$('.ot_'+i).css("top", -hg1);
	}
	}, function(){
	$('.ot_'+i).removeClass("active");
	})
})
</script>