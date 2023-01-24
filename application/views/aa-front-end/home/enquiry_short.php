<section class="parallax">
	<div class="maximage-slider mob-display">
		<div id="maximage"> 
			<!--<img src="<?php echo base_url();?>/resources-f/images/slider/slider-1.jpg" alt=""> 
			<img src="<?php echo base_url();?>/resources-f/images/slider/slider-2.jpg" alt="">-->
<?php 
foreach($WEB_MEDIA_URL->error_message->data as $p){				?>
<img src="<?php echo base_url();?>/<?php echo WEB_MEDIA_IMAGE_PATH;?>/<?php echo $p->image;?>" alt=""> 
<?php }?>
		</div>
		<div class="fullscreen-controls"> <a class="img-prev"><i class="fa fa-angle-left text-black"></i></a> <a class="img-next"><i class="fa fa-angle-right text-black"></i></a> </div>
	</div>
		
			<div class="container mob-display">
				<div class="sl-form mb-39">
					<div class="topFormpanel text-left">
						<?php include('enquiry_form.php');?>
					</div>
				</div>
			</div>
			<!-- end quick form -->
			<!---Modal Quick Enquiry-->
			<div class="modal-enqury">
				<div class="modal fade" id="modal-quick-enquiry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close text-black"></i></button>
								<div class="text-uppercase font-20 mb-10"><span class="font-weight-300 ml-5">&nbsp; </span> <span class="text-red font-weight-600">&nbsp;</span></div>
								<div class="modal-scroll-400" id="scroll-style">
									<?php include('enquiry_form.php');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--End Modal Quick Enquiry-->
			<!--Form Multiple Value Selector-->
			<script>
				
			$(function() {
				$('.selector').change(function() {
					$('.show-vlu').hide();
					$('#' + $(this).val()).show();
				});
			});
			</script>
			<!--End Form Multiple Value Selector-->
		</section>