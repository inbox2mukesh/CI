<!--Start FAQ Section-->
	<section class="bg-lighter">
		<div class="container faq">
			<h2 class="font-weight-300 text-uppercase text-center">Photo <span class="text-red font-weight-600">Gallery</span></h2>
			<div class="row popup-gallery thumb-gallery">
				<?php foreach ($photoData->error_message->data as $d) { 
					?>
				<div class="column gallery-img-border">
					<a href="<?php echo base_url('uploads/photo/'.$d->image);?>"><img src="<?php echo base_url('uploads/photo/'.$d->image);?>" alt="" title="" class=""></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<script>
		$(document).ready(function() {
			$('.popup-gallery').magnificPopup({
				delegate: 'a',
				type: 'image',
				closeOnBgClick: false,
				mainClass: 'mfp-img-mobile',			
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
				},
			});
		});
		</script>


	<!--End FAQ Section-->

	