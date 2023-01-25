	<div id="preloader" style="text-align:center;position: absolute;left: 45%;">
		<div id="spinner">
			<div class="preloader-dot-loading">
				<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
			</div>
		</div>
		<div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>
	</div>
	<section>
		<div class="container">
			<div class="vd-border">
				<div class="embed-responsive embed-responsive-16by9">
					<video autoplay preload="auto" loop="loop" muted="muted">
						<source src="<?php echo base_url('resources-f/video/aus-vid.mp4'); ?>">
					</video>
				</div>
			</div>
			<div class="wraper-content">
				<h2 class="font-weight-400 text-uppercase text-center mt-40">Why <span class="text-red font-weight-600">Australia</span></h2>
				<p class="text-center mb-50">Hosting nearly half a million international students, Australia is known to offer high quality education at an affordable tuition fee which individuals can easily afford and global recognition of degrees is also a plus point for their personal growth. Not only does Australia have a well deserved reputation for being the most welcoming places on earth but it's also considered to be one of the safest places to live. When most countries have shut their immigration programs due to coronavirus pandemic, Australia has been quick to open migration opportunities in 2021. Before making plans to live in Australia make sure that you are well-aware of the major provinces so as to carefully choose the one to reside in. Below are Australia’s major provinces that form the part of the second largest country in the world, endowing employment opportunities, high quality lifestyle, safety and security and much more.
				</p>
				<!--  <div class="mt-20 text-center"><a class="btn btn-blue btn-flat view-btn" href="about.html">More About Us →</a></div>-->
				<?php
				$i = 0;
				foreach ($provinceData->error_message->data as $pd) {
					if ($i == 0) {
						$mt = 'mt-30';
					} else {
						$mt = 'mt-30';
					}
				?>
					<div class="about-sub-info <?php echo $mt; ?>">
						<div class="disc">
							<img src="<?php echo base_url('uploads/provinces/' . $pd->parent_image); ?>" alt="" class="pull-left no-padding-left img-responsive col-md-4 mr-20 no-pd-rt">
							<h3><?php echo $pd->province_name; ?></h3>
							<p> <?php echo substr($pd->about, 0, 500) . ' ...'; ?> </p>
							<a href="<?php echo base_url('provinces/province_details/' . $pd->id); ?>"><span class="btn btn-red btn-circled btn-sm mt-20">More details <i class="fa fa-chevron-right font-10"></i></span></a>
						</div>
					</div>
				<?php $i++;
				} ?>
			</div>
		</div>
	</section>
	<!--End Why Canada Section-->
	<section class="bg-lighter">
		<div class="container why-canada" style="padding-top:0px;">
			<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
								A country with less population; more land
							</a>
						</h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body"> Canada is home to a population of close to 35 million, but boasts the 2nd largest land area of any nation at 9,985,000 Sq. Km. It is an absolutely stunning place, vast and unspoilt. There are heaps of land which is virtually untouched by human feet.</div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading2">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
								A muti-cultural, open and free society
							</a>
						</h4>
					</div>
					<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
						<div class="panel-body"> Canada is also popularly known for its high standard of living combined with quality of life. It is a country really built for families. In the sub urban streets there is a feeling of safety and togetherness with lots of community events such as barbeque and festivals catering to families with kids. </div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading3">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
								An active and stable economy to support you and your business
							</a>
						</h4>
					</div>
					<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
						<div class="panel-body">
							Canada is the home to the 10th largest economy in the world which is constantly growing and diversifying, needless to say growth inspires more need which opens up all sorts of opportunities for different kinds of professions.
						</div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading4">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
								Magnificent standard of living with continually being voted as one of the world’s best
							</a>
						</h4>
					</div>
					<div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
						<div class="panel-body"> Canada is voted 7th best country to live in by a survey conducted in 2014-15, hence, popularly known for its high standard of living combined with quality of life. Once you arrive and get settled here you will come to understand why survey after survey finds Canada to be such a great place</div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading5">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
								Excellent and boundless opportunities for students
							</a>
						</h4>
					</div>
					<div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
						<div class="panel-body"> Adding on to it, an excellent quality of life and high standard of academics is why Canadian education stands unique and popular among students across the globe.</div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading6">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
								Home to an economy supporting skilled workers
							</a>
						</h4>
					</div>
					<div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
						<div class="panel-body"> Being a resource based economy that is based on conservative banking policies, Canada remained somewhat stable while the rest of the world suffered through the most recent Financial Crisis. Under the federal skilled workers program, there are currently 347 occupations that can qualify you for a Fast Track entry.</div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading7">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
								Free medical care available to all
							</a>
						</h4>
					</div>
					<div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
						<div class="panel-body"> Canada's Medicare system of free basic health care to everyone based on need rather than ability to pay is paid by the Canadian citizens pitching in towards the system via taxes. Should it be a simple visit to the doctor for a check-up or open heart surgery, the cost is the same – FREE!</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Start Photo Gallery and latest Video Section-->
	<!--End Photo Gallery and Latest Video Section-->