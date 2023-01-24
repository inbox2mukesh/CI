<option value="">Choose City</option>
<?php 
  foreach ($allcity->error_message->data as $pcity)
  {
  ?>
   <option value="<?php echo $pcity->city_id?>"><?php echo $pcity->city_name?></option>
<?php }?>
 