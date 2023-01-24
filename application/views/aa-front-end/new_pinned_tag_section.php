<div class="rt-sidebar mob-display">
<div class="news-articles">
	<h3><i class="fa fa-thumb-tack"></i> Pinned Articles</h3>
		<ul>
			<?php 
				foreach ($pinnedNewsData->error_message->data as $d){ 
				$date=date_create($d->news_date);
				$news_date = date_format($date,"M d, Y");
			?>
			<li><a href="<?php echo base_url('news_article/index/'.$d->id);?>"><?php echo $d->title;?><p><?php echo $news_date;?></p></a></li>
		<?php } ?>
		</ul>
</div>

	<div class="news-topics mt-20">
	<h3>Topics in News</h3>
	<ul>
		<?php foreach ($newsTag->error_message->data as $d){ ?>
			<li><a href="<?php echo base_url('latest_news/index/'.base64_encode($d->tags));?>"><?php echo $d->tags;?></a></li>
		<?php } ?>	
	</ul>
	</div>
</div>