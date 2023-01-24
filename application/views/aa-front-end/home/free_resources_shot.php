<?php if(count($FREE_RESOURCE_CONTENT_FEATURED->error_message->data)>0){ ?>
<section class="bg-lighter-theme">
			<div class="container">
				<div class="latest-video-content">
					<div class="section-title mb-10">
						<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0">Latest <span class="red-text font-weight-500"> Posts</span></h2> </div>
					<!--Start Grid Container-->
					<div class="thumb-grid-container">
						<div class="thumb-grid-flex-cont4">
							<!--Start Items-->
							<?php 
foreach($FREE_RESOURCE_CONTENT_FEATURED->error_message->data as $p){
							?>
							<div class="thumb-grid-card-container4">
								<div class="thumb-grid-card">
									<a href="<?php echo base_url()?>free_resources/free_resource_post/<?php echo base64_encode($p->id); ?>">
										<div class="featured-img">
											<div class="img-area"> <img src="<?php echo $p->image;?>" class="img-responsive" alt=""> </div>
											<div class="img-text">
												<h4><?php echo $p->title?></h4>
												<div class="font-weight-600 font-12 text-italic">
													
													<?php echo strtoupper($p->content_type_name);?>  <span class="text-theme-colored">(
										<?php 
$type="";
										foreach($p->Course as $pp){
											$type.=$pp->test_module_name.', ';
										}
										echo rtrim($type,', ')?>
									)</span>
												</div>
												<div class="date"><?php echo $p->created;?></div>
												<p><?php echo ucfirst($p->description);?></p>
											</div>
										</div>
									</a>
								</div>
							</div>
						<?php }?>
							<!--End Items-->
							
						</div>
					</div>
					<!--End Grid Container-->
					<div class="mt-30 mb-10 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url()?>free_resources">View More →</a></div>
				</div>
			</div>
		</section>
		<?php }?>