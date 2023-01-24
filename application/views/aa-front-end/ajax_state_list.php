<option value="">Select State</option>
<?php 
  foreach ($allstate->error_message->data as $pst)
  {
  ?>
   <option value="<?php echo $pst->state_id?>"><?php echo $pst->state_name?></option>
<?php }?>
 