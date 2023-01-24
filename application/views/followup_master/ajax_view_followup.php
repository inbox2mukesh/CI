<?php 
//print_r($viewfollowup);
if(!empty($viewfollowup))
{
foreach($viewfollowup as $val)
{
?>

<dl>
  <dd><b>Date:</b> <?php 
                        $dt=date_create($val['next_followupdatetime']);
                        echo date_format($dt,"d-m-Y H:i:s");
                         ?></dd>
  <dd><b>Followup Status: </b><?php echo ucfirst($val['title']);?></dd>
   <dd><b>Remark: </b><?php if($val['followup_remark'] == ""){ echo "N/A";} else{ echo ucfirst($val['followup_remark']);} ?></dd>
</dl>
<hr>
<?php } } else {
  ?>
<dl>
  <dd>No followup detail found </dd>
</dl>
  <?php }?>