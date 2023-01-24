<!--Start Why Canada Section-->
	<section>
		<div class="container">
			
			<div class="owl-carousel-slider" data-dots="" data-nav="true">
				<?php foreach ($provinceImages->error_message->data as $img) { ?>					
				<div class="item mb-30">
					<img src="<?php echo base_url('uploads/provinces/'.$img['image']);?>" alt="<?php echo $provinceDetails['province_name'];?>" title="<?php echo $provinceDetails['province_name'];?>" class="top-slider-img img-rounded">
				</div>
				<?php } ?>
			</div>

			<div class="wraper-content">
				
				<div class="sub-service-info">
					<h4 class="title-head-bar"><?php echo $provinceDetails->province_name;?></h4>
					<div class="about-sub-info">
						<p><?php echo $provinceDetails->about;?></p>
					</div>
				</div>

				<div class="sub-service-info">
					<h4 class="title-head-bar">Education in Province</h4>
					<div class="about-sub-info">
						<p><?php echo $provinceDetails->education;?></p>
					</div>
				</div>

				<div class="sub-service-info">
					<h4 class="title-head-bar">Jobs in Province</h4>
					<div class="about-sub-info">
						<p><?php echo $provinceDetails->jobs;?></p>
					</div>
				</div>

				<div class="sub-service-info">
					<h4 class="title-head-bar">Way of Life in Province</h4>
					<div class="about-sub-info">
						<p><?php echo $provinceDetails->way_of_life;?></p>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End Why Canada Section-->