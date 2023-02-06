<?php 
if(count($PackBatch->error_message->data) >1)
{
  ?>
  <div class="form-group" >
  <lable class="font-weight-600">Select Batch<span class="text-red">*</span></lable>
  <select class="selectpicker form-control select_removeerrmessage packageBatch" name="batch_id" title="Select" id="batch_option_<?php echo $package_id; ?>" onchange="GetPackageSchedule(this.value,<?php echo $package_id ?>)">
  <option value="">Select Batch</option>
  <?php 
  foreach ($PackBatch->error_message->data as $p)
  {
  ?>
   <option value="<?php echo $p->batch_id?>"><?php echo $p->batch_name?></option>
  <?php }?>
  </select>
  <div class="validation font-11 red-text batch_option_<?php echo $p->package_id; ?>_err"></div>
  </div>
  <?php 
}
else { 
?>
<!-- <lable  class="font-weight-600">Batch<span class="text-red">*</span></lable> -->
<input type="hidden" class="fstinput " value="<?php echo $PackBatch->error_message->data[0]->batch_name;?>" disabled>
<input type="hidden" class="packageBatch" name="batch_id" id="batch_option_<?php echo $package_id; ?>" value="<?php echo $PackBatch->error_message->data[0]->batch_id;?>">
<?php 
}
?>