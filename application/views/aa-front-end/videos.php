<style type="text/css">
	.row.thumb-video {height: inherit!important;}
	.video-border{padding:10px 10px 3px 10px; background-color:#fff; border: solid 1px #e3e3e3;}


	
</style>
<!--Start FAQ Section-->
<section class="bg-lighter">
	<div class="container faq">
		<h2 class="font-weight-300 text-uppercase text-center">Our <span class="text-red font-weight-600">Videos</span></h2>
		<div class="row thumb-video">			
	        <?php foreach ($videoData->error_message->data as $d) { ?>
			<div class="column">

				<!-- <iframe id="frm<?php echo $p->video_id; ?>" class="thumb-videos" src="<?php echo $d->video_url; ?>" allowfullscreen controls autoplay></iframe> -->
				<div class="video-border">
				<video id="frm<?php echo $p->video_id; ?>" class="thumb-videos" controls controlsList="nodownload" controlsList="noplaybackrate" poster="resources-f/images/poster.jpg">
	  				<source src="<?php echo $d->video_url; ?>" type="video/mp4">  					
				</video>
			</div>
			</div>
				<?php } ?>
		</div>
		<!--<div class="mt-20 text-center"><a class="btn btn-red btn-flat view-btn" href="#">View More →</a></div>-->
	</div>
</section>
<!--End FAQ Section-->


