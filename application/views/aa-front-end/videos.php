<style type="text/css">
	.row.thumb-video {
		height: inherit!important;
	}
</style>
<!--Start FAQ Section-->
<section class="bg-lighter">
	<div class="container faq">
		<h2 class="font-weight-300 text-uppercase text-center">Our <span class="text-red font-weight-600">Videos</span></h2>
		<div class="row thumb-video">
	        <?php foreach ($videoData->error_message->data as $d) { ?>
			<div class="column">
				<!-- <iframe id="frm<?php echo $p->video_id; ?>" class="thumb-videos" src="<?php echo $d->video_url; ?>" allowfullscreen controls autoplay></iframe> -->
				<!-- <video id="frm<?php echo $p->video_id; ?>" class="thumb-videos" controls controlsList="nodownload" controlsList="noplaybackrate" disablepictureinpicture>
	  				<source src="<?php echo $d->video_url; ?>" type="video/mp4">  					
				</video> -->


				<video id="frm<?php echo $p->video_id; ?>" class="thumb-videos"  controls controlsList="nodownload" controlsList="noplaybackrate" disablepictureinpicture data-wf-ignore="true" data-object-fit="cover">
	  				<source src="<?php echo $d->video_url; ?>" type="video/mp4" data-wf-ignore="true" >  					
				</video>





			</div>
			
				<?php } ?>
		</div>






		<!--<div class="mt-20 text-center"><a class="btn btn-red btn-flat view-btn" href="#">View More →</a></div>-->
	</div>
</section>
<!--End FAQ Section-->
