<option value="">Select </option>
<?php                             
foreach ($SESSION_TIMESLOT_URL->error_message->data as $p)
{                                
echo '<option value="'.$p->time_slot.'" >'.ucfirst($p->time_slot).'</option>';
} 
?>
        
            