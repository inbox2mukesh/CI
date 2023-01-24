<?php 
//echo "<pre>";
//print_r($data);
?>

<div class="modal-scroll">

			


<table class="table table-bordered">
 
 
  <?php 
  
	 foreach($data as $key=>$data_val)
	  { 
      
		?>
<tr>
  <th colspan="2" style="background-color: #f7f7f7 !important;"><?php echo $key?></th>
</tr> 
<?php 
    if(!empty($data_val['valid']))
    {
      ?>
    <tr>
    <td>Valid</td>
    <td>
    <?php foreach($data_val['valid'] as $dt_valid){?>    
    <span class="label label-success"><?php echo $dt_valid;?></span>
    <?php }?>
    </td>
    </tr>
    <?php }?>
    <?php 
    if(!empty($data_val['duplicate']))
    {
    ?>
    <tr>
    <td>Duplicate</td>
    <td>
    <?php foreach($data_val['duplicate'] as $dt_duplicate){?>
   
    <span class="label label-danger"><?php echo $dt_duplicate;?></span>
    
    <?php }?>
    </td>

    </tr>
    <?php }?>
</tr>
<?php }?>
    <!-- <tr>
      <td width="10%" style="background-color:#ffd5cf">Duplicate</td>
      <td><?php 
	 foreach($arr_dt['dupicate'] as $duplicate)
	  { 
		?>
		<span class="label label-danger"><?php echo $duplicate;?></span>
		<?php 
	  } 
	  ?></td>
 
    </tr>
	<?php if(!empty($dup['valid'])) {?>
	<tr>
      <td  width="10%" style="background-color:#ccffee">Valid</td>
      <td><?php 
	 foreach($dup['valid'] as $valid)
	  { 
		?>
		<span class="label label-success"><?php echo $valid;?></span>
		<?php 
	  } 
	  ?></td>
 
    </tr> -->
	<?php }?>

   
  
</table>
<br>
</div>