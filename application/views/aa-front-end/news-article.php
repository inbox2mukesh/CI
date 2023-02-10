<section>
	<div class="container">
		<div class="head-title font-weight-400 text-uppercase mb-10">Immigration <span class="text-red font-weight-600">News</span></div>
		
			<div class="row">
				<div class="col-md-8">
				<span class="news-article-reset">	<a href="<?php echo base_url('latest-news');?>" ><i class="fa fa-refresh text-red"></i> Reset all news</a></span>
					<div class="news-article-info">
						<div><img src="<?php echo base_url('uploads/news/'.$newsArticleData->error_message->data->media_file);?>" alt="" title="" class="img-rounded mb-15"></div>
							<?php
							if($newsArticleData->error_message->data->is_pinned==1){
	                        	$pin = '<span class="text-red"><i class="fa fa-thumb-tack"></i></span>';
			                }else{ $pin ='';}
							?>
						<h3><?php echo $pin;?> <?php echo $newsArticleData->error_message->data->title;?></h3> <span class="date">
							<?php 
								$date=date_create($newsArticleData->error_message->data->news_date);
                                $news_date = date_format($date,"M d, Y");    
                            ?>
						<?php echo $news_date;?></span>
						<p> <?php echo $newsArticleData->error_message->data->body;?> </p>
					</div>
					<!--Start Pagination-->
				</div>
				<div class="col-md-4">
				<?php include('new_pinned_tag_section.php');?>
				</div>
			</div>
	</div>
</section>

	