<div class="left-aside">
<div class="no-lg-display">
<button onclick="myFunction()" id="toggle" class="closed dropbtn">DASHBOARD MENU <span class="pull-right"><i class="fa fa-angle-right font-18 icon-rotate"></i></span></button>
</div>
<!-- sidebar -->
<div class="sidebarnav sidemenu-content" id="myDropdown">
<!-- Start Sidebar menu -->
<div class="scrollbar scrollbar-use-navbar scrollbar-bg-white">
<ul class="list list-bg-white">
<li>
<a href="<?php echo base_url('our_students/student_dashboard'); ?>" class="text-uppercase  <?php if ($segment == "student_dashboard") {
													echo "active-text";
												} ?>">Dashboard</a>
</li>
<?php  if(DEFAULT_COUNTRY ==101){?>
								<li class="list-item"><a href="#" class="link-arrow text-uppercase link-current">Practice Portal</a>
								<ul class="list-unstyled list-hidden mt-5">
								<div class="submenu link-current">
								<ul>
								<li><a href="https://westernoverseas.ca/practice/" target="_blank">IELTS Practice Portal</a></li>
								<li><a href="https://westernoverseas.org/login" target="_blank">PTE Practice Portal</a></li>
								<li><a href="https://practice.western-overseas.com/login" target="_blank">TOEFL Practice Portal</a></li>
								</ul>
								</div>
								</ul>
								</li> 
								<?php } else {?>
								<li><a href="https://practice.western-overseas.com" class="text-uppercase" target="_blank">Practice Portal</a></li>
								<?php }?>
<?php
if (count($curPack->error_message->data) > 1) {
?>
<li><a href="#" class="text-uppercase" data-toggle="modal" data-target="#modal-classroom">Switch Classroom</a></li>
<?php } ?>
<li><a href="<?php echo base_url('our_students/student_classroom'); ?>" class="text-uppercase <?php if ($segment == "student_classroom") {
													echo "active-text";
												} else {
													echo "noactive";
												} ?>">Classroom Home</a></li>
<?php
//If there is no class scheduled, or if classes are less than 5, then hide Full Class Schedule page		
			
if ($allClassSchedule > LOAD_MORE_LIMIT) { ?>
<li>
<a class="text-uppercase <?php if ($segment == "live_class_shedules_all") {
echo "active-text";
} else {
echo "noactive";
} ?>" href="<?php echo base_url('our_students/live_class_shedules_all'); ?>">Full Class Schedule</a>
</li>
<?php } ?>
<li class="hide"><a href="<?php echo base_url('our_students/student_classroomForum'); ?>" class="text-uppercase <?php if ($segment == "student_classroomForum") {
														echo "active-text";
													} else {
														echo "noactive";
													} ?>">Classroom forum</a></li>

<li><a class="text-uppercase <?php if ($segment == "shared_documents") {
echo "active-text";
} else {
echo "noactive";
} ?>" href="<?php echo base_url('our_students/shared_documents'); ?>">Classroom Material</a></li>
<li><a class="text-uppercase <?php if ($segment == "recorded_lectures") {
echo "active-text";
} else {
echo "noactive";
} ?>" href="<?php echo base_url('our_students/recorded_lectures'); ?>">Recorded Lecture</a></li>
<li><a class="text-uppercase <?php if ($segment == "announcements") {
echo "active-text";
} else {
echo "noactive";
} ?>" href="<?php echo base_url('our_students/announcements'); ?>">Announcements</a></li>
<li class="hide"><a href="<?php echo base_url('our_students/attendance'); ?>" class="text-uppercase">Attendance</a></li>
<li><a href="#" class="text-uppercase" data-toggle="modal" data-target="#modal-assistance">Need Assistance</a></li>
<li class="hide"><a title="Logout" class="logout-btn bg-theme-color" href="<?php echo site_url() ?>my_login/student_logout">Logout</a></li>
</ul>
</div>
<!--End sidebar menu -->
</div>
</div>
<div class="classroom">
<div class="modal fade" id="modal-classroom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
<h4 class="modal-title text-uppercase">YOUR CLASSROOM</h4>
</div>
<div class="modal-body classroom-box">
<div class="modal-scroll" id="scroll-style">
<div class="row">
<?php
foreach ($curPack->error_message->data as $p) {
	if ($p->package_status !=1) 
	{
		continue;

	}


$daysLeft = strtotime($p->expired_on) - strtotime(date('Y-m-d'));
$daysLeft = round($daysLeft / (60 * 60 * 24));

$daysLeft=$daysLeft+1;
if($daysLeft==0)
{
	$daysLeft=1;
}

if($daysLeft<0)
{
	$daysLeft="N/A";
}

if(strtotime($p->expired_on) < strtotime(date('Y-m-d')))
{
	$daysLeft=NA;

}

?>
<div class="col-md-6">
<div class="card-info card-ht">
<ul>
<li><span class="font-weight-600">Classroom ID:</span> </span> <?php echo $p->classroom_name; ?></li>
<li><span class="font-weight-600 mr-5">Classroom Information:</span><?php echo strtoupper($p->test_module_name);?>
<?php if($p->programe_name !='None'){ echo '- '.strtoupper($p->programe_name); } echo '-'.strtoupper($p->category_name).'-'.strtoupper($p->batch_name);?></li>
<li><span class="font-weight-600">Current Package:</span> <?php echo strtoupper($p->package_name); ?>
<input type="hidden" id="classroom_Validity" class="classroom_Validity<?php echo $p->student_package_id ?>" value="<?php echo $p->subscribed_on; ?> - <?php echo $p->expired_on; ?>" />
</li>
<li><span class="font-weight-600">Validity: </span> </span><?php echo $p->subscribed_on; ?> to <?php echo $p->expired_on; ?>

</li>
<input type="hidden" id="classroom_daysleft" class="classroom_daysleft<?php echo $p->student_package_id ?>" value="<?php echo strip_tags($daysLeft) ?>" />
<input type="hidden" id="classroom_isoffline" class="classroom_isoffline<?php echo $p->student_package_id?>" value="<?php echo $p->is_offline;?>"/>
<input type="hidden" id="student_package_id" class="student_package_id<?php echo $p->student_package_id?>" value="<?php echo $p->student_package_id?>"/>
<?php if($daysLeft !=NA){?>
<li><span class="font-weight-600">Days Left: </span> <?php echo $daysLeft; ?></li><?php }?>
</ul>
<div class="ftr-btm"> <span class="font-weight-600">Package Status: </span><?php if ($p->package_status == 1 and $_SESSION['packActive'] == 1) { ?><span class="text-green font-weight-600">ACTIVE</span>
<?php } else { ?>
<span class="text-red font-weight-600">INACTIVE</span>
<?php }

if ($p->package_status == 1 and $_SESSION['packActive'] == 1 and $_SESSION['stucurrent_package_id'] != $p->student_package_id) {
?>
<a href="javascript:void();" onclick="createClassroomSession(<?php echo $p->classroom_id ?>,<?php echo $p->student_package_id; ?>)"><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a>
<?php } else {
	?>
	<span class="pull-right btn btn-green btn-sm">Currently In</span>
	<?php 
} ?>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!---Modal Need Assistance-->
<div class="classroom">

<div class="modal fade" id="modal-assistance" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
</div>
<div class="modal-body" style="padding-top: 0px;">
<div class="assistance-info">
<h3>Student Support</h3>
<p class="mb-10"><a href="tel:+91-99916-83777"><i class="fa fa-phone text-red mr-5"></i> +91-9991683777</a></p>
<p><a href="mailto:support@westernoverseas.online"><i class="fa fa-envelope-o text-red mr-5"></i> support@westernoverseas.online</a></p>
</div>
<div class="assistance-info mt-20">
<h3>Addmissions Team</h3>
<p class="mb-10"><a href="tel:+91-99915-55120"><i class="fa fa-phone text-red mr-5"></i> +91-9991555120</a></p>
<p><a href="mailto:admissions@westernoverseas.online"><i class="fa fa-envelope-o text-red mr-5"></i> admissions@westernoverseas.online</a></p>
</div>
<div class="mt-30">More info on <a href="<?php echo site_url() ?>contact_us" class="text-red">Contact Page</a></div>
</div>
</div>
</div>
</div>
</div>
<!--End Modal Need Assistance-->
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