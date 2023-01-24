 <?php 
$p=$data->error_message->data;
$time_slot1=$p->info->time_slot1;
$time_slot2=$p->info->time_slot2;
$time_slot3=$p->info->time_slot3;
 ?>
 <div class=""><span class="text-danger">*</span> Select Time Slot</div>
                  <!-- <div class="font-12 text-red">Select Test Type and Branch to see Time Slots</div>-->
                  <!-- time slot 1 -->
                  <?php 
                  if($time_slot1)
                  {
                   
                   $slot1_per=$p->time_slot1;
                   if($slot1_per <=85)
                   {
                    $slot_1_text="Available";
                    $slot_1_color="avlbl";
                    $slot_1_readonly="time-slot";
                   }
                   else if($slot1_per >85 AND $slot1_per <=95)
                   {
                        $slot_1_text="Limited Seats Left";
                        $slot_1_color="lmtd-seat";
                        $slot_1_readonly="time-slot";
                   } 
                   else if($slot1_per >95 AND $slot1_per <100)
                   {
                        $slot_1_text="Filling Fast";
                        $slot_1_color="slt-fillingfast";
                        $slot_1_readonly="time-slot";
                   }
                   else if($slot1_per == 100)
                   {
                        $slot_1_text="Slot Full";
                        $slot_1_color="slt-full";
                        $slot_1_readonly="full-time-slot";
                   }

                    if(!$time_slot2 and !$time_slot3){
                    $checked="disabled='disabled'";
                    }else{
                    $checked='';
                    }
                  ?>
                  <div class="tm-slot-row ">
                    <div class="col-md-2 col-sm-3 col-sm-6">
                      <div class="tm-slot-box text-center">
                        <div class="<?php echo $slot_1_readonly;?>">
                          <input type="radio" id="time_slots" name="time_slots" value="<?php echo $time_slot1;?>" class="time_slots" >
                          <label class="<?php echo $slot_1_color;?>" for="time_slots"><?php echo $time_slot1;?></label>
                        </div>
                        <div class="text-black font-12 text-center"> <?php echo $slot_1_text;?></div>
                      </div>
                    </div>
                    </div><?php }?>
                    <!--END---time slot 1 -->

                  <!-- time slot 2 -->
                  <?php 

                  if($time_slot2)
                  {
                     $slot2_per=$p->time_slot2;
                     //$slot2_per=89;
                   if($slot2_per <=85)
                   {
                    $slot_2_text="Available";
                    $slot_2_color="avlbl";
                    $slot_2_readonly="time-slot";
                   }
                   else if($slot2_per >85 AND $slot2_per <=95)
                   {
                        $slot_2_text="Limited Seats Left";
                        $slot_2_color="lmtd-seat";
                        $slot_2_readonly="time-slot";
                   } 
                   else if($slot2_per >95 AND $slot2_per <100)
                   {
                        $slot_2_text="Filling Fast";
                        $slot_2_color="slt-fillingfast";
                        $slot_2_readonly="time-slot";
                   }
                   else if($slot2_per == 100)
                   {
                        $slot_2_text="Slot Full";
                        $slot_2_color="slt-full";
                        $slot_2_readonly="full-time-slot";
                   }
                    
                  ?>
                   <div class="tm-slot-row ">
                    <div class="col-md-2 col-sm-3 col-sm-6">
                      <div class="tm-slot-box text-center">
                        <div class="<?php echo $slot_2_readonly;?>">
                          <input type="radio"  id="time_slots2" name="time_slots" value="<?php echo $time_slot2;?>" class="time_slots">
                          <label class="<?php echo $slot_2_color;?>" for="time_slots2"><?php echo $time_slot2;?></label>
                        </div>
                        <div class="text-black font-12 text-center"> <?php echo $slot_2_text;?></div>
                      </div>
                    </div>
                    </div><?php }?>
                    <!--END---time slot 2 -->
                    <!-- time slot 3 -->
                  <?php 

                  if($time_slot3)
                  {
                    $slot3_per=$p->time_slot3;
                   if($slot3_per <=85)
                   {
                    $slot_3_text="Available";
                    $slot_3_color="avlbl";
                    $slot_3_readonly="time-slot";
                   }
                   else if($slot3_per >85 AND $slot3_per <=95)
                   {
                        $slot_3_text="Limited Seats Left";
                        $slot_3_color="lmtd-seat";
                        $slot_3_readonly="time-slot";
                   } 
                   else if($slot3_per >95 AND $slot3_per <100)
                   {
                        $slot_3_text="Filling Fast";
                        $slot_3_color="slt-fillingfast";
                        $slot_3_readonly="time-slot";
                   }
                   else if($slot3_per == 100)
                   {
                        $slot_3_text="Slot Full";
                        $slot_3_color="slt-full";
                        $slot_3_readonly="full-time-slot";
                   }
                    
                  ?>
                   <div class="tm-slot-row ">
                    <div class="col-md-2 col-sm-3 col-sm-6">
                      <div class="tm-slot-box text-center">
                        <div class="<?php echo $slot_3_readonly;?>">
                          <input type="radio" id="time_slots3" name="time_slots" value="<?php echo $time_slot3;?>" class="time_slots" >
                          <label class="<?php echo $slot_3_color;?>" for="time_slots3"><?php echo $time_slot3;?></label>
                        </div>
                        <div class="text-black font-12 text-center"> <?php echo $slot_3_text;?></div>
                      </div>
                    </div>
                    </div><?php }?>

                    <!--END---time slot 3 --> 
                    <div class="col-md-12">
                    <div class="valid-validation time_slots_error"></div> </div>