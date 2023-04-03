<div class="loader-cont" style="display:none;">
	 <div class="loader4"></div>   
</div>
<?php
$packActive=0;
$packActive=count($curPack->error_message->data);

// if(count($curPack->error_message->data)>0){
//   foreach($curPack->error_message->data as $p){
//     $packActive += $p->package_status;
//   }
// }

if($packActive>0){
  $_SESSION['packActive']=1;
}else{
  $_SESSION['packActive']=0;
}
//echo $_SESSION['packActive'];
?>

<section class="lt-bg-lighter">
		<div class="container">
			<div class="content-wrapper">
				<!-- Left sidebar -->				
				<?php include('includes/student_profile_sidebar.php'); ?>				
				<!-- End Left sidebar -->
				<!-- Start Content Part -->
				<div class="content-aside dash-main-box" style="padding-right: 25px;">
					<div class="row">
					<?php include('includes/center_studentprofile.php'); ?>					 
					
					<?php if(count($curPack->error_message->data)>0){ ?>
						<?php include('includes/student_cur_pack.php'); ?>
					<?php } ?>
					
					
					<?php if(count($curPack->error_message->data)==0){ ?>
						<?php include('includes/student_our_pack.php'); ?>  
					<?php } ?>				
						
					</div>
				</div>
				<!-- End Content Part -->
			</div>
		</div>
	</section>
	<!---Modal Available Promotions Codes-->
	<div class="avlble-pro-code">
		<div class="modal fade" id="modal-md-old" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
						<h4 class="modal-title text-uppercase">Available Promotion Codes</h4> </div>
					<div class="modal-body pd-20 promo-box">
						<div class="info mb-20">
							<p class="font-weight-600">Get 30% OFF up to INR 1,000</p>
							<p>Valid on purchase more than INR 5,0000</p>
							<p> For one time use only</p>
							<div class="mt-10 clearfix"> <span class="coupon">DIWALI7</span> </div>
						</div>
						<div class="info mb-20">
							<p class="font-weight-600">Get 30% OFF up to INR 1,000</p>
							<p>Valid on purchase more than INR 5,0000</p>
							<p> For one time use only</p>
							<div class="mt-10 clearfix"> <span class="coupon">DIWALI7</span> </div>
						</div>
						<p class="font-weight-500">Use Discount Codes at Checkout</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--End Available Promotions Codes-->
	<!---Modal Classroom-->
	<div class="classroom">
		<div class="modal fade" id="modal-classroom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
						<h4 class="modal-title text-uppercase">YOUR CLASSROOM</h4> </div>
					<div class="modal-body classroom-box">
						<div class="modal-scroll" id="scroll-style">
							<div class="row">
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-info mb-15 card-ht">
										<ul>
											<li><span class="font-weight-600">Classroom ID:</span> AMB001</li>
											<li><span class="font-weight-600">Current Package:</span> AMB001</li>
											<li><span class="font-weight-600">Validity: </span> 21st JAN 22 - 21st JAN 2021</li>
											<li><span class="font-weight-600">Days Left: </span> 02</li>
										</ul>
										<div class="ftr-btm"> <span class="font-weight-600">Status: </span> <span class="text-green">Active</span> <a href=""><span class="pull-right btn btn-blue btn-sm">Enter Class</span></a> </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--End Modal Classroom-->
	<!--response modal-->
	<div class="modal fade studentresponse-modal" id="responsemsgmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="responsemsgmodalLabel">Message</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="msg-content">
				...
			</div>			
			</div>
		</div>
	</div>
	<?php 
	include('change_password.php');
	include('update_profilepic.php');
	 ?>
	 
	<script>
		let baseurl= "<?php echo base_url(); ?>";
		//function formodule login
		function studentautologin()
		{
			$('.loader-cont').show();
			$.ajax({
				url: baseurl+'our_students/student_autoLogin',
				method:'POST',
				dataType:'json',
				success: function(resp)
				{
					if(resp.success == 1)
					{
						var url = 'http://'+resp.link;
						window.open(url, '_blank');
					}
					else if(resp.success == 0){
						$('#msg-content').html(resp.msg);
						$('#responsemsgmodal').modal('show');
						setTimeout(function(){
							$('#responsemsgmodal').modal('hide');
						},1500);
					}
					else{
						$('#msg-content').html('Something went wrong. Please try again later');
						$('#responsemsgmodal').modal('show');
						setTimeout(function(){
							$('#responsemsgmodal').modal('hide');
						},1500);
					}
					$('.loader-cont').hide();
				}

			});
		}
	</script>