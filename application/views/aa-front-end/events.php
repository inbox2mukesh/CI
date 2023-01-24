<style>
.clear{
    clear:both;
    margin-top: 20px;
}
#searchResult {
	list-style: none;
	padding: 0px;
	width: auto;
	position: absolute;
	margin: 0;
	z-index: 100;
	top: 40px;
	box-shadow: 0px 0px 2px 2px rgb(0 0 0 / 6%);
	width: 92%;
	border-radius: 4px;
	background: #fff;
	padding: 4px;
}

#searchResult li {
	background: #fff;
	padding: 4px;
	margin-bottom: 1px;
}
#searchResult li:nth-child(2n) {
	background: #d72a22;
	color: white;
}
#searchResult li:hover{
    cursor: pointer;
}
</style>
<section>
    <div class="container">
      <div class="vd-border">
         <?php 
 foreach($WEB_MEDIA_URL->error_message->data as $p)
 {
        
       $video=$p->image;
      }
        ?>
        <div class="embed-responsive embed-responsive-16by9">
          <video autoplay preload="auto" loop="loop" muted="muted">
            <source src="<?php echo base_url();?>/<?php echo WEB_MEDIA_VIDEO_PATH;?>/<?php echo $video;?>"> 
			</video>
        </div>
      </div>
      <div class="section-title mb-10 mt-30">
        <div class="row">
          <div class="text-center">
            <h2 class="mb-20 text-uppercase font-weight-300 font-28"><?php echo $title1?> <br class="mb-600"><span class="text-theme-color-2 font-weight-500"> <?php echo $title2?></span></h2> </div>
        </div>
      </div>
      <!--Filter--->
	    <?php
		$eventsTypeArray=array();
		$eventDates=array();
		if($eventList->error_message->success==1){
			$eventDates=$eventList->error_message->data->eventDates;
			$eventDates=(array)$eventDates;
			$eventDates=array_values($eventDates);
			$eventsTypeArray=$eventList->error_message->data->eventType;
		}
		//pr($lists=$eventList->error_message->data->event);
	    ?>
      <div class="filter-box">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" id="search-icn">
                     <input type="text" name="search" class="fstinput typeahead" placeholder="Search By Event Title" id="add-autocomplete">
                    <button type="button"><i class="fa fa-search"></i></button>
					<input type="hidden" value="" name="event_id" id="sevent_id"> 
            </div>
			<ul id="searchResult" style="display:none"></ul>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <select class="selectpicker form-control" data-live-search="true" id="sevents_type" onchange="searchEvent()">
                <option value="">Filter By Events Type</option>
                <?php 
				foreach($eventsTypeArray as $key=>$val){?>
				<option value="<?php echo $key?>"><?php echo $val?></option>
				<?php 
				}?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div class="has-feedback">
                <input type="text" class="fstinput datepickerp" readonly autocomplete="off" id="event_date" onchange="searchEvent()"> <span class="fa fa-calendar form-group-icon"></span> 
				</div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12" id="flter-btm-info"> 
		  <span class="text-left font-weight-600 pull-left lordear-class" id="up" style="display:none"> 
		        <i class="fa fa-spinner fa-spin mr-10"></i> Available To Load. 
		  </span> 
		  <span class="pull-right font-weight-600" id="down"><a href="javascript:void(0)" onclick="showAll()">Show All </a></span> </div>
        </div>
      </div>
      <!---EndFilter--->
      <!--START GRID CONTAINER -->
        <div class="grid-container mt-40" id="eventData">    
				<?php 
                #pr($eventList);
				if($eventList->error_message->success==1){
				?>
				<div class="grid-flex-cont4"> 
					<?php 
					$lists=$eventList->error_message->data->event;
					$eventCardImageBasePath=FCPATH.'uploads/events/';
					foreach($lists as $key=>$list){
						
						$eventCardImage=$list->eventCardImage;
						if(empty($eventCardImage)){
							$eventCardImage='no-image.png';
						}else if(!file_exists($eventCardImageBasePath.$eventCardImage)){
							
				            $eventCardImage='no-image.png';
			            }
						$eventDate='';
						$locations=$list->locations;
						$timeslots=$locations->timeslots;
						$eventDateArray=array_column($locations,'eventDate','eventDate');
						$branchArray=array_column($locations,'center_name','eventBranchId');
						$outHouseLocationArray=array_column($locations,'full_location_name','locationId');
						$venue=$timing='';
						if(count($eventDateArray) > 1){
							$eventDate='Multiple';
						}else{
							$eventDate=reset($eventDateArray);
							$eventDate=date('F d, Y',strtotime($eventDate));
						}
						if($list->locationType=='outhouse'){
							
							if(count($outHouseLocationArray) > 1){
								
							    $venue='Multiple';
							}else{
								//pr($outHouseLocationArray);
								$venue=reset($outHouseLocationArray);
							}
						}else{
							
							if(count($branchArray) > 1){
								
							    $venue='Multiple';
							}else{
								$venue=reset($branchArray);
							}
						}
						
						$locationsTimeslotsArray=array_column($locationsArray,'fromTimeSlot');
						
						if($eventDate=='Multiple'){
							$timing='Multiple';
							
						}else{
							$timing=array();
							$locationsArray=array_column($locations,'timeslots','id');
							//pr($locationsArray);
							
							foreach($locationsArray as $key=>$timeslots){
								
								foreach($timeslots as $key1=>$val1){
									
									$timing[]=$val1->fromTimeSlot.'-'.$val1->toTimeSlot;
								}
							}
							
							$timing=array_unique($timing);
							sort($timing);
							if(count($timing) ==1){
								
								$timing=implode('',$timing);
							}else{
								$timing='Multiple';
							}
							
						}
					?>
						<!--Start Grid Items-->
							<div class="grid-card-container">
								<div class="grid-card">
								  <a href="<?php echo site_url($list->eventSlug)?>">
									<div class="workshop-img">
									  <div class="img-area"> <img src="<?php echo site_url(EVENTS_IMAGE_PATH.$eventCardImage);?>" class="img-responsive" alt="<?php echo $list->eventCardImageAlt?>" title="<?php echo $list->eventCardImageTitle?>"> </div>
									  <div class="img-text">
										<h4>
											<?php 
											echo word_limiter(ucfirst($list->eventTitle),10);
											?>
										</h4>                         
										<div class="workshop-info">
										   <ul>
											<li>
											<span class="font-weight-600">Venue:</span> <?php 
											echo word_limiter($venue,10);
											?>
											</li>
											<li><span class="font-weight-600">Date: </span><?php echo $eventDate?></li>
											<li class="font-weight-600"><span class="font-weight-600">Timing: </span><?php 
											echo $timing;
											?>
											</li>
										   </ul>
										</div>
										<div class="btn btn-white ft-btn">Book Now</div>
									  </div>
									</div>
								  </a>
								</div>
							</div>
						    <!--Start Grid Items End-->
						   <!--End Grid Items-->
					<?php 
					}?>
				</div>
				<?php 	
				}else{?> 
					<div class="alert alert-info" role="alert">
					 <?php echo $eventList->error_message->message;?>
					</div>
				<?php 
				}?>
        </div>
      <!--END GRID CONTAINER -->
    </div>
	
  </section>
  <!-- Start TESTIMONIALS section -->
  <script src="<?php echo site_url()?>resources-f/js/bootstrap-datepicker.js">
  </script>
<script>
var datesEnabled={};
datesEnabled=JSON.parse('<?php echo json_encode($eventDates)?>');
$('.datepickerp').datepicker({format: 'dd-mm-yyyy',autoclose: true, todayBtn: false,
        todayHighlight: false,beforeShowDay: function (date) 
        {
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var hhh=('0' + date.getDate()).slice(-2);
			var allDates =  ('0' + date.getDate()).slice(-2) + '-' + month +'-' + date.getFullYear();
			if(datesEnabled.indexOf(allDates) != -1)
			{
			return true;
			}
			else
			{
			return false;
			}
			return false;
        }
    });
	
    $("input#add-autocomplete").keyup(function(){
		
                var query = $(this).val();
				$("#sevent_id").val('');
		        var event_type=$("#sevents_type").val();
		        var event_date=$("#event_date").val();
				$(".lordear-class").show();
                if(query != ""){
					
                    $.ajax({
                        url: '<?php echo base_url("events/autoSearchEvent/")?>',
                        type: 'post',
                        data: {query:query,event_type:event_type,event_date:event_date},
                        dataType: 'json',
                        success:function(response){
							
                            var len = response.length;
							$("#searchResult").show();
                            $("#searchResult").empty();
							$(".lordear-class").hide();
							if(len > 0){
								
								for( var i = 0; i<len; i++){
									
									var id = response[i]['id'];
									var name = response[i]['name'];
									$("#searchResult").append("<li value='"+id+"'>"+name+"</li>");
								}
								
							}else{
								
								$("#searchResult").append("<li value=''>result not found</li>");
							}
                            // binding click event to li
                            $("#searchResult li").bind("click",function(){
								
								inputval=$(this).val();
								text=$(this).text();
                                setText(inputval,text);
                            });
                        }
                    });
                }
    });
	
	function setText(inputval,text){
		
		//alert(text);
        $("#sevent_id").val(inputval);
		if(inputval ==''){
			
			$("#add-autocomplete").val('');
		}else{
			$("#add-autocomplete").val(text);
		}
		searchEvent();		
	}
	
	/*$("input#add-autocomplete").change(function(){
		
		var sevent_id=$("#sevent_id").val();
		alert(sevent_id);
		if(sevent_id==''){
			
			$("#add-autocomplete").val('');
		}
		searchEvent();
	})*/
	
	function searchEvent(){
		
		$(".lordear-class").show();
		var event_id=$("#sevent_id").val();
		var event_type=$("#sevents_type").val();
		var event_date=$("#event_date").val();
		$("#searchResult").hide();
        $("#searchResult").empty();
		
		$.ajax({
			url: '<?php echo base_url("events/searchEvent/")?>',
			type: 'post',
			data: {event_id:event_id,event_type:event_type,event_date:event_date},
			dataType: 'html',
			success:function(response){
				$(".lordear-class").hide();
				$("#eventData").html(response);
			}
        });
	}
	function showAll(){
		
		$("#sevent_id").val('');
		$("#sevents_type").val('');
		$("#event_date").val('');
		$("#add-autocomplete").val('');
		searchEvent();
	}
	
	$(window).click(function() {
		
		$("#searchResult").hide();
        $("#searchResult").empty();
		var sevent_id=$("#sevent_id").val();
		
		if(sevent_id==''){
			$("#add-autocomplete").val('');
		}
		searchEvent();
    });
</script>