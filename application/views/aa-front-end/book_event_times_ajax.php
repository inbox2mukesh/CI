    <?php
    $timeSlot=array();
    $eventLocationData=array();
    if($data->error_message->success==1){
		
	    $timeSlot=$data->error_message->data->timeSlot;
	    $eventLocationData=$data->error_message->data->eventLocationData;
    }
	if(!empty($eventLocationData) && !empty($timeSlot)){
		
		foreach($timeSlot as $key=>$val){
			
			$val=(array)$val;
			$totalRemeingSeats=$val['seats']-$val['bookedSeats'];
			$seats=$val['seats'];
			$eventLocationData=(array)$eventLocationData;
			$capacity=$eventLocationData['capacity'];
            $availabilityData=$val['availabilityData'];
            $availabilityData=(array)$availabilityData;
			$available=$availabilityData['available'];
			$availabilityClass=$availabilityData['class'];
			$availabilityLabel=$availabilityData['label'];
            $locationTimeAmount=0;
            if($eventLocationData['eventCharges']=="paid"){

               $locationTimeAmount=round($val['locationTimeAmount']/100,2);
            }

    ?>
		<div class="col-md-3 tm-slot">
			<div class="tm-slot-box text-center" style="width:100%;">
				<div class="time-slot">
                    <input type="hidden" value="<?php echo $availabilityLabel?>" id="etl-<?php echo $val['id'];?>" class="etl">
					<input type="hidden" value="<?php echo $availabilityClass?>" id="etc-<?php echo $val['id'];?>" class="etc">
					<input type="hidden" value="<?php echo $locationTimeAmount?>" id="locationTimeAmount-<?php echo $val['id'];?>">
                    <input type="radio" id="event_location_time-<?php echo $val['id']?>" name="event_location_time" value="<?php echo $val['event_id']?>-<?php echo $val['event_location_id']?>-<?php echo $val['id']?>" 
					<?php if($available=='yes'){ ?>
					onclick="selectEventTime('<?php echo $val['id']?>')" 
					<?php } ?>
					<?php if($available=='no'){ ?> disabled="disabled" <?php }?> class="event-time" />

					<label class="<?php echo $availabilityClass?> event-time-label" for="event_location_time-<?php echo $val['id']?>" id="et-<?php echo $val['id'];?>"><?php echo $val['fromTimeSlot']?> - <?php echo $val['toTimeSlot']?> 
					  <div class="font-12 text-center event-time-label-div" id="et-div-<?php echo $val['id'];?>"><?php echo $availabilityLabel?>
                      </div>
                     <?php 
						if($eventLocationData['eventCharges']=="paid"){
							
							$locationTimeAmount=round($val['locationTimeAmount']/100,2);
						?>
						<div class="font-12 text-center"><?php echo $locationTimeAmount?> <?php 
						echo $val['currencyType']?>
                        </div>
						<?php 
						}else{
						?>
						<div class="font-12 text-center">Free</div>
						<?php 
						}?>
                    </label> 
					<?php 
					?>
				</div>
			</div>
		</div>
    <?php 
		}
	}else{?>
	    <div class="alert alert-danger" role="alert">
            Event booking all time slot is over for selected date
        </div>
	<?php 
	}?>
	