<?php
foreach ($newsData as $d) {
	$date = date_create($d['news_date']);
	$news_date = date_format($date, "M d, Y");
	if ($d['is_pinned'] == 1) {
		$pin = '<span class="text-red"><i class="fa fa-thumb-tack"></i></span>';
	} else {
		$pin = '';
	}
?>
	<a href="<?php echo base_url('news-detail/' . $d['URLslug']); ?>">
		<div class="news-panel-info">
			<div class="disc">
				<img src="<?php echo base_url('uploads/news/' . $d['card_image']); ?>" alt="" title="" class="pull-right img-responsive ml-15">
				<h3><?php echo $pin; ?> <?php echo $d['title']; ?></h3> <span class="date"><?php echo $news_date; ?></span>
				<p> <?php echo  substr(strip_tags($d['body']), 0, 120); ?></p>
			</div>
		</div>
	</a>
<?php } ?>