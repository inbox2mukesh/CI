<section>
			<div class="container">
				<div class="section-title mb-10 text-center">
					<h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0">Upcoming <span class="red-text font-weight-500">  Reality Test</span></h2> </div>
				<div class="scroll-tab">
					<ul class="nav nav-tabs text-center">
					
					
					<!--
						<li class="active"> <a href="#All-DATES" data-toggle="tab">All DATES</a></li>
						<li><a href="#IELTS-PAPER-BASED" data-toggle="tab">IELTS PAPER BASED</a></li>
						<li><a href="#UP-PTE" data-toggle="tab">PTE</a></li>-->
						<?php 
						/*$lcount=1;
						$cl_class="";
    foreach($AllTestModule_RT->error_message->data as $p)
	{
		$cl_class="";
		if($lcount == 1)
		{
			$cl_active="active";
			$cl_class="pills-rt-".$p->test_module_name;
			
		}
?>
<li class="<?php echo $cl_active?>" ><a href="#pills-rt-<?php echo $p->test_module_name;?>" data-toggle="tab"><?php echo $p->test_module_name;?></a></li>
<?php $lcount++; }*/ ?>

<?php 
$i=0;
    foreach($AllTestModule_RT->error_message->data as $p){
	if($i==0)
	{
		$class="active";
		$cl_class="pills-rt-".$p->test_module_name;
	}
	else {
		$class="";
	}
//	echo $cl_class;
?>

<li class="<?php echo $class;?>"><a href="#pills-rt-<?php echo $p->test_module_name;?>" data-toggle="tab"><?php echo $p->test_module_name;?></a></li>
<?php $i++; } ?>
						
						
						
					</ul>
				</div>
				<div id="myTabContent" class="tab-content pb-0">
					<div class="tab-pane fade <?php if($cl_class=="pills-rt-CD-IELTS") {?>active in<?php }?>" id="pills-rt-CD-IELTS">
						<!--START GRID CONTAINER -->
						<div class="grid-container">
							<div class="grid-flex-cont4">
								<!--START GRID ITEM -->
								 <?php 
      foreach($CD_IELTS_RT_short->error_message->data as $p){
          

          $id = base64_encode($p->id);
          $bg='blue-box';
          $venue="In all branches";          
          //time
          if($p->time_slot1 and $p->time_slot2 and $p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2.' | '.$p->time_slot3;
          }elseif($p->time_slot1 and $p->time_slot2 and !$p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2;
          }elseif($p->time_slot1 and !$p->time_slot2){
              $t = $p->time_slot1;
          }else{
              $t = $p->time_slot1;
          } 

          
  ?>
  <a class="btn btn-white btn-sm" href="<?php echo base_url('book_reality_test/index/'.$id);?>">
								<div class="grid-card-container">
									<div class="grid-card">
										<div class="ierltest-box mb-30 text-white evn-box">
											<div class="striped font-14">
												<p class="font-14 font-weight-500"><?php echo substr($p->title, 0,31);?></p>
												<p class="font-10 font-weight-500"><?php echo $p->test_module_name;?></p>
											</div>
											<ul>
												<li class="font-weight-500 font-13"><i class="fa fa-map-marker"></i>  <?php echo $venue;?></li>
											
												<li> <i class="fa fa-calendar font-13"></i> <span class="font-12">Date</span>: <span class="font-12"> <?php 
            $date=date_create($p->date);
            echo $date = date_format($date,"M d, Y");
          ?></span> </li>
												<li> <i class="fa fa-clock-o font-13"></i> <span class="font-12">Time:</span> <span class="font-12"><?php echo $t;?></span> </li>
											</ul>
											<div class="ft-btn"> <span class="font-16 mr-20 font-weight-600">Rs. <?php echo $p->amount;?></span> <span class="btn btn-white btn-sm">Book Now</span> </div>
										</div>
									</div>
								</div></a>
								<!--END GRID ITEM -->
 <?php } ?>								
							</div>
						</div>
						<!--END GRID CONTAINER -->
					</div>
					<div class="tab-pane fade <?php if($cl_class=="pills-rt-IELTS") {?>active  in<?php }?> " id="pills-rt-IELTS">
						<!--START GRID CONTAINER -->
						<div class="grid-container">
						
							<div class="grid-flex-cont4">
								<!--START GRID ITEM -->
								<?php 
								foreach($IELTS_RT_short->error_message->data as $p){
								//program
								
								$id = base64_encode($p->id);
								$bg='red-box';

								if($p->time_slot1 and $p->time_slot2 and $p->time_slot3){
								$t = $p->time_slot1.' | '.$p->time_slot2.' | '.$p->time_slot3;
								$slot_count=3;
								}elseif($p->time_slot1 and $p->time_slot2 and !$p->time_slot3){
								$t = $p->time_slot1.' | '.$p->time_slot2;
								$slot_count=2;
								}elseif($p->time_slot1 and !$p->time_slot2){
								$t = $p->time_slot1;
								$slot_count=1;
								}else{
								$t = $p->time_slot1;
								$slot_count=0;
								} 

								foreach ($p->Info as $inf){
								$venue = $inf->venue;
								$seats = $inf->seats;
								}
								$total_seats = $seats*$slot_count;
							/*	$bookingCount = $p->bookingCount;
								if($bookingCount<$total_seats){
								$soldOut=0;
								}else{
								$soldOut=1;
								}*/
								?>
								<a  href="<?php echo base_url('book_reality_test/index/'.$id);?>">
								<div class="grid-card-container">
									<div class="grid-card">
										<div class="ierltest-box mb-30 text-white evn-box">
											<div class="striped font-14">
												<p class="font-14 font-weight-500"><?php echo substr($p->title, 0,31);?></p>
												<p class="font-10 font-weight-500"><?php echo $p->test_module_name;?></p>
											</div>
											<ul>
												<li class="font-weight-500 font-13"><i class="fa fa-map-marker"></i>  <?php echo $venue;?></li>
												
												<li> <i class="fa fa-calendar font-13"></i> <span class="font-12">Date</span>: <span class="font-12"> <?php 
            $date=date_create($p->date);
            echo $date = date_format($date,"M d, Y");
          ?> </span> </li>
												<li> <i class="fa fa-clock-o font-13"></i> <span class="font-12">Time:</span> <span class="font-12"><?php echo $t;?></span> </li>
											</ul>
											<div class="ft-btn"> <span class="font-16 mr-20 font-weight-600">Rs. <?php echo $p->amount;?></span> <span class="btn btn-white btn-sm">Book Now</span> </div>
										</div>
									</div>
								</div></a>
								<?php }?>
								<!--END GRID ITEM -->								
							</div>
						</div>
						<!--END GRID CONTAINER -->
					</div>
					<div class="tab-pane fade <?php if($cl_class=="pills-rt-PTE") {?>active  in<?php }?> " id="pills-rt-PTE" >
						<!--START GRID CONTAINER -->
						<div class="grid-container">
							<div class="grid-flex-cont4">
								<!--START GRID ITEM -->
								<?php 
						//		print_r($PTE_RT_short);
								foreach($PTE_RT_short->error_message->data as $p)
								{

								$id = base64_encode($p->id);
								$bg='yellow-box';
								$venue= "In all branches"; 
								//time
								if($p->time_slot1 and $p->time_slot2 and $p->time_slot3){
								$t = $p->time_slot1.' | '.$p->time_slot2.' | '.$p->time_slot3;
								}elseif($p->time_slot1 and $p->time_slot2 and !$p->time_slot3){
								$t = $p->time_slot1.' | '.$p->time_slot2;
								}elseif($p->time_slot1 and !$p->time_slot2){
								$t = $p->time_slot1;
								}else{
								$t = $p->time_slot1;
								} 
								?>
								<a class="btn btn-white btn-sm" href="<?php echo base_url('book_reality_test/index/'.$id);?>">
								<div class="grid-card-container">
									<div class="grid-card">
										<div class="ierltest-box mb-30 text-white evn-box">
											<div class="striped font-14">
												<p class="font-14 font-weight-500"><?php echo substr($p->title, 0,31);?></p>
												<p class="font-10 font-weight-500"><?php echo $p->test_module_name;?></p>
											</div>
											<ul>
												<li class="font-weight-500 font-13"><i class="fa fa-map-marker"></i>  <?php echo $venue;?></li>
											
												<li> <i class="fa fa-calendar font-13"></i> <span class="font-12">Date</span>: <span class="font-12"><?php 
            $date=date_create($p->date);
            echo $date = date_format($date,"M d, Y");
          ?>   </span> </li>
												<li> <i class="fa fa-clock-o font-13"></i> <span class="font-12">Time:</span> <span class="font-12"><?php echo $t;?></span> </li>
											</ul>
											<div class="ft-btn"> <span class="font-16 mr-20 font-weight-600">Rs. <?php echo $p->amount;?></span> <span class="btn btn-white btn-sm">Book Now</span> </div>
										</div>
									</div>
								</div></a>
								<!--END GRID ITEM -->
								<?php }?>
								
							</div>
						</div>
						<!--END GRID CONTAINER -->
					</div>
				</div>
				<div class="text-center"> <a class="btn btn-red btn-flat view-btn mt-20" href="<?php echo base_url('reality_test');?>">View All →</a></div>
			</div>
		</section>