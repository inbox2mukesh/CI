<?php
if (count($SESSION_TIMESLOT_URL->error_message->data) > 0) {
    foreach ($SESSION_TIMESLOT_URL->error_message->data as $key => $p) {
        //echo '<option value="'.$p->time_slot.'" >'.ucfirst($p->time_slot).'</option>';

?>
        <div class="col-md-3 col-sm-3">
            <div class="time-card">
                <div class="time-slot">
                    <input type="radio" class="cs_bookingtime" id="radio<?php echo $key; ?>" name="cs_timeslot" value="<?php echo $p->time_slot ?>" onclick="getFinalSession(this.value)">
                    <label class="avlbl text-center" for="radio<?php echo $key; ?>"> <span class="tm-info"><?php echo $p->time_slot ?> </span><br>Available</label>
                </div>
            </div>
        </div>
    <?php }
} else { ?>

    <div class="col-md-6">
        No Time slot available for this date
    </div>
<?php  } ?>