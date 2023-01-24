<?php if(count($All_RR_short->error_message->data)>0){ ?>
<section class="bg-lighter">
			<div class="container">
				<div class="section-title mb-10 text-center">
					<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0">Latest <span class="red-text font-weight-500"> Result</span></h2> </div>
				<div class="latest-photo-content">
					<!--START Grid CONTAINER-->
					<div class="thumb-grid-container">
						<div class="thumb-grid-flex-cont-glry popup-gallery">
							<!--Start Grid Items-->
							
							  <?php
        if(count($All_RR_short->error_message->data)>0){
            foreach($All_RR_short->error_message->data as $p){
            $img = site_url().'uploads/recent_results/'.$p->image;
    ?>  
							<div class="thumb-grid-card-container-glry">
								<div class="thumb-grid-card">
									<div class="shdw">
										<a href="<?php echo $img;?>" title="<?php echo $p->title;?>" >
										<img src="<?php echo $img;?>" alt="<?php echo $p->title;?>" title="<?php echo $p->title;?>" class="result-glry img-rounded">
										</a>
									</div>
								</div>
							</div>
							  <?php }} ?>  
							<!--Start Grid Items-->
							
						</div>
					</div>
					<!--End Grid CONTAINER-->
					<div class="mt-30 mb-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url('recent_results');?>">View More →</a></div>
				</div>
			</div>
			<script>
			$(document).ready(function() {
				$('.popup-gallery').magnificPopup({
					delegate: 'a',
					type: 'image',
					mainClass: 'mfp-img-mobile',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
					},
				});
			});
			</script>
		</section>
		<?php } ?>