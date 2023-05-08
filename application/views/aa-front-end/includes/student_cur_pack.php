<div class="col-md-7">
<div class="lt-gray-box">
<div class="classroom-box">
<h4>Your Classrooms</h4>
<!-- <p class="font-weight-600 text-red">You don't have any Classrooms</p>
<div class="font-weight-600 mt-10 mb-10 text-blue">Purchase Packages to reflect Classrooms.</div> -->
<!--
<p class="font-weight-600">You don't have any classrooms</p>
<p class="font-weight-600">Purchase Packages to reflect classrooms.</p>
-->
<div class="global-page-scroll_3" id="scroll-style">
<div class="classroom-wrapper">
<?php

foreach($curPack->error_message->data as $p)
{
	                     
$daysLeft = strtotime($p->expired_on) - strtotime(date('d-m-Y'));
$daysLeft = round($daysLeft / (60 * 60 * 24));
   
$daysLeft=$daysLeft+1;
if($daysLeft==0)
{
	$daysLeft=1;
}

if($daysLeft<0)
{
	$daysLeft=NA;
}
if(strtotime($p->expired_on) < strtotime(date('d-m-Y')))
{
	$daysLeft=NA;

}
// echo $daysLeft; 
//$_SESSION['packActive']=$p->package_status;
?>

<div class="card-info">
<input type="hidden" id="student_package_id" class="student_package_id<?php echo $p->student_package_id?>" value="<?php echo $p->student_package_id?>"/>
<ul>
<li><span class="font-weight-600">Classroom ID:</span> <?php echo $p->classroom_name;?>
</li>
<li><span class="font-weight-600 mr-5">Classroom Information:</span><?php echo strtoupper($p->test_module_name);?>
<?php if($p->programe_name !='None'){ echo '- '.strtoupper($p->programe_name); } echo '-'.strtoupper($p->category_name).'-'.strtoupper($p->batch_name);?></li>
<li><span class="font-weight-600">Current Package:</span> <?php echo strtoupper($p->package_name);?></li>
<li><span class="font-weight-600">Validity: </span><?php echo $p->subscribed_on;?> to <?php echo $p->expired_on;?>

</li>
<?php if($daysLeft !=NA && $p->package_status==1){?>
<li><span class="font-weight-600">Days Left: </span> <?php echo $daysLeft;?></li>
<?php }?>
<li class="mt-10"> <span class="font-weight-600">Package Status: </span> 
<?php

if($p->package_status==1 && $daysLeft >=1){ 


?><span class="text-green font-weight-600 ">ACTIVE</span>
<?php }else{ ?>
<span class="text-red font-weight-600">INACTIVE 
<?php if($p->packCloseReason !=""){?>	
<span class="font-11">[<?php echo $p->packCloseReason?>]</span>
<?php }?>
</span>
<?php } 
if($p->classroom_status  == 1)
{

if($p->package_status==1 and $_SESSION['packActive']==1){ 
?>
<input type="hidden" id="classroom_Validity" class="classroom_Validity<?php echo $p->student_package_id?>" value="<?php echo $p->subscribed_on;?> to <?php echo $p->expired_on;?>"/>
<input type="hidden" id="classroom_isoffline" class="classroom_isoffline<?php echo $p->student_package_id?>" value="<?php echo $p->is_offline;?>"/>
<input type="hidden" id="classroom_daysleft" class="classroom_daysleft<?php echo $p->student_package_id?>" value="<?php echo strip_tags($daysLeft);?>"/>
<a href="javascript:void();" onclick="createClassroomSession(<?php echo $p->classroom_id?>,<?php echo $p->student_package_id;?>)"><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> 
<?php } } else {?>
	<span class="pull-right btn btn-disabled btn-sm nopointer">Classroom Disabled</span>
	<?php }?>
</li>
</ul>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">	
function createClassroomSession(classroom_id,package_id){
	var classroom_name=$('#classroom_name').val();
	var classroom_Validity=$('.classroom_Validity'+package_id).val();
	var classroom_daysleft=$('.classroom_daysleft'+package_id).val();
	var classroom_isoffline=$('.classroom_isoffline'+package_id).val();
	var student_package_id=$('.student_package_id'+package_id).val();

$.ajax({
url: "<?php echo site_url('our_students/createClassroomSession');?>",
async : true,
type: 'post',
data: {classroom_id: classroom_id,classroom_Validity:classroom_Validity,classroom_daysleft:classroom_daysleft,classroom_isoffline:classroom_isoffline,package_id:package_id,student_package_id:student_package_id},
dataType: 'json',
success: function(response){
	//alert(response)
if(response==1){
window.location.href = "<?php echo site_url('our_students/student_classroom');?>";
}else{
alert('Please select classroom!')
window.location.href = "<?php echo site_url('our_students/student_classroom');?>";
}               
}
});
}
</script>