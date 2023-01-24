<?php 
	#pr($eventList);
	if($eventList->error_message->success==1){
	?>
	<div class="grid-flex-cont4"> 
		<?php 
		$lists=$eventList->error_message->data->event;
		foreach($lists as $key=>$list){
			
			$eventCardImage=$list->eventCardImage;
			$eventCardImageBasePath=FCPATH.'uploads/events/';
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
					  <a href="<?php echo $list->eventUrl?>">
						<div class="workshop-img">
						  <div class="img-area"> <img src="<?php echo site_url(EVENTS_IMAGE_PATH.$eventCardImage);?>" class="img-responsive" alt="<?php echo $list->eventCardImageAlt?>" title="<?php echo $list->eventCardImageTitle?>"> </div>
						  <div class="img-text">
							<h4>
								<?php 
								//echo word_limiter(ucfirst($list->eventTitle),10);
								echo ucfirst(substr($list->eventTitle,0,100));
								?>
							</h4>                         
							<div class="workshop-info">
							   <ul>
								<li>
								<span class="font-weight-600">Venue:</span> <?php 
								//echo word_limiter($venue,10);
							    echo ucfirst(substr($venue,0,100));
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