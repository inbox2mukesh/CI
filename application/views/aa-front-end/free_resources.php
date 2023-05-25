<!-- Start subscribe -->

<style>	.bg-red-theme{background-color: #FEFAEE !important;}</style>



<!-- ends -->

<?php if(count($FREE_RESOURCE_CONTENT->error_message->data) >0 ){?>

	<section>

		<div class="container">
		<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0 text-center"><span class="text-red font-weight-600">Articles</span></h2>
			<!--Filter Box--->

			<div class="filter-wht-box">

				<div class="filter-events">

					<div class="col" id="search-icn">

						<div class="form-group clearfix">

							<input type="text" name="fname" class="fstinput" placeholder="Search" onkeyup="searchFreeResource();" id="testtype_search">

							<button type="submit"><i class="fa fa-search"></i></button>

							<!--				       <div class="validation">Wrong</div>--></div>

					</div>

					<div class="col">

						<div class="form-group">

							<select class="selectpicker form-control" data-live-search="true" onchange="searchFreeResource();" id="testtype_select">

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

							<select class="selectpicker form-control" data-live-search="true"  onchange="searchFreeResource();" id="contenttype_select">

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

							<select class="selectpicker form-control" onchange="searchFreeResource();" id="uploadtime_select">

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

				<div class="row" id="freeresource_section">

<?php 



foreach($FREE_RESOURCE_CONTENT->error_message->data as $p){

?>

					<div class="col-md-4 col-sm-6">

						<a href="<?php echo base_url()?>articles/post/<?php echo $p->URLslug; ?>">

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

					<div class="mt-20 text-center hide"><a class="btn btn-red btn-flat view-btn" href="free-resources.html">Load More Content</a></div>

				</div>

			</div>

			<!--End Grid Container-->

			

		</div>

	</section>

<?php } else {?>

<section>

		<div class="container">

				<h3 class="text-red text-center">No articles found!</h3>

	</div>



</section>

<?php }?>

<script>

 function searchFreeResource()

  {       

    var testtype_select  = $("#testtype_select").val(); 

    var contenttype_select  = $("#contenttype_select").val();  

    var uploadtime_select  = $("#uploadtime_select").val();

     var testtype_search  = $("#testtype_search").val();

    

      

    /*var city_select  = $("#city_select").val();

    var branch_select  = $("#branch_select").val();

    var date_select  = $("#date_select").val();*/   



       $.ajax({

          url: "<?php echo site_url('free_resources/searchFreeResource');?>",

          async : true,

          type: 'post',

          data: {testtype_select:testtype_select,contenttype_select:contenttype_select,uploadtime_select:uploadtime_select,testtype_search:testtype_search},

          success: function(data){

            if(data!=''){

              $('#flter-btm-info').addClass('hide');

              /*$('.processing-res').hide();

              $('.success-res').show();*/

              $('#freeresource_section').html(data);

            }else{

              $('#flter-btm-info').addClass('hide');

              /*$('.processing-res').hide();

              $('.no-res').show();

              $('.success-res').hide();*/

              $('#freeresource_section').html(data);

            }          

          },

          beforeSend: function(){            

            $('#flter-btm-info').removeClass('hide');             

          },

      });   

}

</script>