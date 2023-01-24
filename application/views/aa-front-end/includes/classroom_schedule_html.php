<div class="col-md-4">
  <a href="<?php echo $hreflink; ?>" class="<?php echo $btnDisabled; ?> " <?php if($btnDisabled !="disabled"){?>onclick="class_att('<?php echo $p->id; ?>','<?php echo $_SESSION['classroom_isoffline'] ?>');" <?php }?> <?php echo $target_bl; ?> <?php echo $btnDisabled; ?> style="<?php echo $btn_pointerevent; ?>">
    <div class="<?php echo $class; ?>">
      <div class="info">
       <div>
            <h2 class="txt-45"><?php echo substr($p->topic, 0, 50); ?></h2>
            <div class="tooltiptext">
          </div>
      </div>
        <p class="font-11">Live Online Classes</p>
        <div class="mt-20">
          <p>Duration: <?php echo $p->class_duration . ' Minute(s)'; ?></p>
          <p>Date: <?php echo $day; ?> <?php echo $classDate2; ?> <span class=""> (<i><?php echo $p->dayname; ?></i>)</p>
          <p>Time: <?php echo $calssTime; ?> (<?php echo GMT_TIME; ?>) </p>
        </div>
        <div class="ftr-btm">
          <?php
          if (!empty($p->conf_URL)) { ?>
            <span class="btn btn-wht mt-15 mb-15 rd-30 <?php echo $btnDisabled; ?>">Join Class</span>
          <?php } ?>
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
<script>

$('.txt-45').each(function(i){
  $(this).addClass('ct_'+i);
  var jh2 = $('.ct_'+i ).text();
  $('.ct_'+i).next().html(jh2);
  var textlenght = $('.ct_'+i).text().length;
  var textcorrect =  $('.ct_'+i).text();
  if (textlenght > 42) {
    $('.ct_'+i).next().text($(this).text().substr(0,42)+'...');
  }

  $(this).next().hover(function(){
    if (textlenght > 42) {
      $('.ct_'+i).addClass("active");
      var hg = $('.ct_'+i).height()+12;
      $('.ct_'+i).css("top", -hg);
    }
  }, function(){
    $('.ct_'+i).removeClass("active");
  })
})



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