<!-- Start subscribe -->

<style>

	

	.bg-red-theme{background-color: #FEFAEE !important;}

</style>



<!-- ends -->

<?php 
if(count($TEST_PREPARATION_MATERIAL_CONTENT->error_message->data) >0 ){?>

	<section>

		<div class="container">
	<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0 text-center">Test Preparation <span class="text-red font-weight-600">Material</span></h2>
			<!--Filter Box--->

			<div class="filter-wht-box">

				<div class="filter-events">

					<div class="col" id="search-icn">

						<div class="form-group clearfix">

							<input type="text" name="fname" class="fstinput" placeholder="Search" onkeyup="searchTestPrepMaterial();" id="testtype_search">

							<button type="submit"><i class="fa fa-search"></i></button>

							<!--				       <div class="validation">Wrong</div>--></div>

					</div>

					<div class="col">

						<div class="form-group">

							<select class="selectpicker form-control" data-live-search="true" onchange="searchTestPrepMaterial();" id="testtype_select">

								<option value="">Select Topic</option>

								 <?php

                  foreach($FREE_RESOURCE_COURSE_LIST->error_message->data as $p){

                  ?>

                  <option value="<?php echo $p->topic_id;?>"><?php echo $p->topic;?></option>

                  <?php } ?>

							</select>

						</div>

						<!--<div class="validation">Wrong</div>--></div>

					<div class="col">

						<div class="form-group">

							<select class="selectpicker form-control" data-live-search="true"  onchange="searchTestPrepMaterial();" id="contenttype_select">

								<option value="">Select Content Type</option>

								    <?php

                  foreach($FREE_RESOURCE_CONTENT_TYPE->error_message->data as $p){

                  ?>

                  <option value="<?php echo $p->id;?>"><?php echo $p->content_type_name;?></option>

                  <?php } ?>

							</select>

						</div>

					</div>

					<div class="col">

						<div class="form-group">

							<select class="selectpicker form-control" onchange="searchTestPrepMaterial();" id="uploadtime_select">

								<option value="">Select Upload Time</option>

								<option value="week">This Week</option>

								<option value="month">This Month</option>

								<option value="6month">Last Six Month</option>

								<option value="year">This Year</option>

								<option value="lastyear">Last Year</option>

								<option value="archives">Archives</option>

							</select>

						</div>

					</div>

				</div>

				<div class="clearfix" > <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i> Loading...Please Wait </span> <span class="pull-right font-weight-600" id="down"><a href="" class="text-black">Clear All </a></span> </div>

			</div>

			<!--End Filter Box-->

			<!--Start Grid Container-->

			<div class="search">

			<div class="row" id="post_section">
			<?php 
			foreach($TEST_PREPARATION_MATERIAL_CONTENT->error_message->data as $p){
			?>

					<div class="col-md-4 col-sm-6">

						<a href="<?php echo base_url()?>test-preparation-material/<?php echo $p->URLslug; ?>">

							<div class="latest-img">

								<div class="img-area"> <img src="<?php echo $p->image;?>" class="img-responsive" alt=""> </div>

								<div class="img-text">

									<h4><?php echo ucwords($p->title);?></h4>

									<div class="font-weight-600 font-12 text-italic">

										<?php echo strtoupper($p->content_type_name);?> <span class="text-theme-colored">(

										<?php 

										$type="";

										foreach($p->Course as $pp){

											$type.=$pp->topic.', ';

										}

										echo rtrim($type,', ')?>

									)</span>

									</div>

									<div class="date mt-10"><?php echo $p->created;?></div>

									<p><?php echo ucfirst($p->description);?></p>

								</div>

							</div>

						</a>

					</div>

					<?php }?>
			</div>
			<?php if($total_pages > 1) { ?>
			<div class="mt-20 text-center load-more-section" data-total-pages="<?php echo $total_pages; ?>" data-offset="<?php echo FRONTEND_RECORDS_PER_PAGE; ?>" data-current-page="1"><a class="btn btn-red btn-flat view-btn" href="javascript:void(0);">Load More Content</a></div>
			<?php } ?>					
			</div>

			<!--End Grid Container-->

			

		</div>

	</section>

<?php } else {?>

<section>

		<div class="container">

				<h3 class="text-red text-center">No test preparation material found!</h3>

	</div>



</section>

<?php }?>

<script>
	$(document).ready(function(){
		$('.preloader').fadeIn(1500);
		$(document).on("click",".load-more-section",function(){
			var thisObj				 	= $(this);
			var totalPages 			 	= $(this).data("total-pages");
			var offset 				 	= $(this).data("offset");
			var currentPage			  	= $(this).data("current-page");
			var params 				  	= {}; 
			params["content_type"] 	   	= $("#contenttype_select").val();
			params["upload_time"] 	   	= $("#uploadtime_select").val();
			params["search_text"] 	    = $("#testtype_search").val().trim();
			params["testtype_select"]   = $("#testtype_select").val();
			$.ajax({
				url: "<?php echo WOSA_BASE_URL; ?>common/ajax_load_more",
				type: "POST",
				dataType: "json",
                data: {
					controller: 'test_preparation_material',
					offset: offset,
					params : params
				},
				success: function(data){
                    if(data["html"].indexOf !== 'undefined'){
						var recordPerPage = '<?php echo FRONTEND_RECORDS_PER_PAGE; ?>';
						offset = parseInt(offset) + parseInt(recordPerPage);
						currentPage = currentPage + 1;
						$("#post_section").append(data["html"]);
						if(currentPage < totalPages) {
							thisObj.data("offset",offset);
							thisObj.data("current-page",currentPage);
						}
						else {
							thisObj.data("offset",offset);
							thisObj.hide();
						}
					}
				}
			});
		});
	});
	$(document).on("blur","#testtype_search",function() {
		$(this).val($(this).val().trim());
		searchTestPrepMaterial();
	});
	$(document).on("click",".posts-search-button",function() {
		searchTestPrepMaterial();
	});
	function searchTestPrepMaterial() {
		var testtype_select  = $("#testtype_select").val(); 
		var contenttype_select  = $("#contenttype_select").val();  
		var uploadtime_select  = $("#uploadtime_select").val();
 		var testtype_search  = $("#testtype_search").val();

		var offset 						= 0;
		var params 						= {}; 
		params["content_type"] 	   	= $("#contenttype_select").val();
		params["upload_time"] 	   	= $("#uploadtime_select").val();
		params["search_text"] 	    = $("#testtype_search").val().trim();
		params["testtype_select"]   = $("#testtype_select").val();

		$.ajax({
			url: "<?php echo WOSA_BASE_URL; ?>common/ajax_load_more",
			async: true,
			type: 'POST',
			dataType: "json",
			data: {
				controller: 'test_preparation_material',
				offset: offset,
				params : params
			},
			success: function(data) {
				if(data["html"].indexOf !== 'undefined' && data["html"].trim() != ''){
					$('#flter-btm-info').addClass('hide');
					$('#post_section').html(data["html"]);
					$(".load-more-section").data("offset",'<?php echo FRONTEND_RECORDS_PER_PAGE; ?>');
					if(data["total_pages"].indexOf !== 'undefined') {
						if(data["total_pages"] > 1) {
							$(".load-more-section").show();
						}
						else {
							$(".load-more-section").hide();
						}
						$(".load-more-section").data("total-pages",data["total_pages"]);
						$(".load-more-section").data("current-page",1);
					}
				} else {
					$('#flter-btm-info').addClass('hide');
					$('#post_section').html('<div class="grid-card-container"><div class="grid-card"><h2 class="text-red">No Test Prep Material Found</h2></div></div>');
					$(".load-more-section").hide();
				}
			},
			beforeSend: function() {
				$('#flter-btm-info').removeClass('hide');
			},
		});
	}
</script>