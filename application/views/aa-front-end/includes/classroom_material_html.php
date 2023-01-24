<div class="col-md-4 col-sm-6">
  <a href="<?php echo site_url('our_students/shared_documents_view/'.$p->Content->id)?>/">
    <div class="classroom-info-box">
		<div class="top-sec">
			<div class="icon"><img src="<?php echo site_url() ?>resources-f/images/school-material.svg" alt=""></div>
			<div class="c-info">
			<div class="t-head limit-one-line"><?php echo $p->Content->title; ?></div>
			<div class="limit-one-clone"></div>
			</div>
		</div>
	<div class="ft">
        <ul>
          <li><span class="font-weight-600 mr-2">Topic:</span><?php echo rtrim($con_type_val, ', '); ?></li>         
          <li><span class="font-weight-600 mr-2">Date Added:</span><?php echo $p->Content->created; ?></li>
        </ul>
   </div>
     
    </div>
  </a>
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
