<section>
		<div class="container">
			<?php if(count($WEB_MEDIA_URL->error_message->data) >0 ){?>
			<div class="vd-border">
				 <?php 
 foreach($WEB_MEDIA_URL->error_message->data as $p)
 {
				
       $video=$p->image;
      }
        ?>
				<div class="embed-responsive embed-responsive-16by9">
					<video autoplay preload="auto" loop="loop" muted="muted">
						<source src="<?php echo base_url();?>/<?php echo WEB_MEDIA_VIDEO_PATH;?>/<?php echo $video;?>"> </video>
				</div>
			</div>
		<?php }?>
			<div class="section-title mb-10 mt-30">
				<div class="row">
					<div class="text-center">
						<h2 class="mb-20 text-uppercase font-weight-300 font-28">Upcoming  <br class="mb-600"><span class="text-theme-color-2 font-weight-500"> Reality Test Dates</span></h2> </div>
				</div>
			</div>
			<!--Filter--->
			<div class="filter-box">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<select class="selectpicker form-control" data-live-search="true" id="course_select_option" onchange="searchRealityTest();">
							<option value="">Select Course</option>
							<?php //print_r($AllTestModule);?>
                <?php foreach($AllTestModule->error_message->data as $p)
{ ?>
                <option value="<?php echo $p->test_module_id?>"><?php echo $p->test_module_name?></option>
              <?php }?>
               
              
							</select>
						</div>
					</div>
					<div class="col-md-4 hide" id="branch_section">
						<div class="form-group">
							<select class="selectpicker form-control" data-live-search="true" id="branch_select" onchange="searchRealityTest();">
								<option value="">Select Branch</option>
								<?php foreach($AllRTBranch->error_message->data as $p)
{ ?>
                <option value="<?php echo $p->center_id;?>"><?php echo $p->center_name?></option>
              <?php }?>
							</select>
						</div>
					</div>
					<div class="col-md-4 hide" id="city_section">
						<div class="form-group">
							<select class="selectpicker form-control" data-live-search="true" id="city_select" onchange="searchRealityTest();">
								<option value="">Select City</option>
								<?php foreach($AllRTCity->error_message->data as $p)
{ ?>
                <option value="<?php echo $p->city_id;?>"><?php echo $p->city_name?></option>
              <?php }?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="has-feedback">
								<input type="date" class="fstinput"  id="date_select" onchange="searchRealityTest();"> <span class="fa fa-calendar form-group-icon"></span> </div>
						</div>
					</div>
					<div class="col-md-12" > <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i> Loading...Please Wait</span> <span class="pull-right font-weight-600" id="down"><a href="">Clear All </a></span> </div>
				</div>
			</div>
			<!---EndFilter--->
			<!--START GRID CONTAINER -->
			<?php 
		//	echo "<pre>";
//print_r($ALL_RT);
			?>
			<div class="grid-container mt-40">
				<div class="grid-flex-cont4" id="rt_section">
					<!--START GRID ITEM -->
						 <?php 
      foreach($ALL_RT->error_message->data as $p){
       $venue="In all branches";  
        foreach($p->Info as $ven_list)
        {
        	if(!empty($ven_list->venue))
        	{
        	 $venue=$ven_list->venue;
        	}

        }
         
          $id = base64_encode($p->id);
          $bg='blue-box';
                  
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
					<div class="grid-card-container">
						<div class="grid-card">
							<div class="ierltest-box mb-30 text-white evn-box">
								<div class="striped font-14">
									<p class="font-14 font-weight-500"><?php echo substr($p->title, 0,31);?></p>
									<p class="font-10 font-weight-500"><?php echo $p->test_module_name?></p>
								</div>
								<ul>
									<li class="font-weight-500 font-13"><i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo $venue;?></li>
									<li class="text-lt-gray hide">Patiala-Sangrur, Bypass, Phase I, Urban Estate, Patiala, Punjab 147002</li>
									<li> <i class="fa fa-calendar font-13" aria-hidden="true"></i> <span class="font-12">Date</span>: <span class="font-12"> <?php 
            $date=date_create($p->date);
            echo $date = date_format($date,"M d, Y");
          ?></span> </li>
									<li> <i class="fa fa-clock-o font-13" aria-hidden="true"></i> <span class="font-12">Time:</span> <span class="font-12"><?php echo $t;?></span> </li>
								</ul>
								<div class="ft-btn"> <span class="font-16 mr-20 font-weight-600">Rs.  <?php echo $p->amount;?></span> <a class="btn btn-white btn-sm" href="<?php echo base_url('book_reality_test/index/'.$id);?>">Book Now</a> </div>
							</div>
						</div>
					</div>
					<!--END GRID ITEM -->
				<?php } ?>	
				</div>
			</div>
			<!--END GRID CONTAINER -->
		</div>
		</div>
	</section>
	
	
	<section class="bg-lighter">
		<div class="container rl-test">
			<div class="section-title">
				<div class="row">
					<div class="text-center">
						<h2 class="mb-20 text-uppercase font-weight-300 font-28">What is <span class="text-theme-color-2 font-weight-500"> Reality Test ?</span></h2> </div>
				</div>
			</div>
			<p class="font-16"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
				<br>
				<br> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </p>
			<div class="panel-group accordion mt-20" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="active">
       Lorem ipsum dolor sit amet consectetur
      </a>
    </h4> </div>
					<div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
						<div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading2">
						<h4 class="panel-title">
      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
      Lorem ipsum dolor sit amet consectetur
      </a>
    </h4> </div>
					<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
						<div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading3">
						<h4 class="panel-title">
      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
    Lorem ipsum dolor sit amet consectetur
      </a>
    </h4> </div>
					<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
						<div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading4">
						<h4 class="panel-title">
      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
    Lorem ipsum dolor sit amet consectetur
      </a>
    </h4> </div>
					<div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
						<div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </div>
					</div>
				</div>
				<div class="panel panel-default mb-10">
					<div class="panel-heading" role="tab" id="heading5">
						<h4 class="panel-title">
      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
    Lorem ipsum dolor sit amet consectetur
      </a>
    </h4> </div>
					<div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5" aria-expanded="false">
						<div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Start TESTIMONIALS section -->
	<section>
		<div class="container">
			<div class="section-title mb-10 text-center">
				<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0">What Student Say About  <br class="mb-600"><span class="text-red font-weight-500"> Reality Test</span></h2> </div>
			<div class="row">
				<div class="col-md-6">
					<div class="testimonial-bx">
						<div class="owl-carousel text-carousel">
							<div class="item">
								<p class="font-weight-400">Hello everyone, I am Vikrant Rana. My qualifications are that I am a 12th 2017 pass out. I always wished to study in Germany. So I came to know about Western Overseas and applied for my German visa from here. In just 4 weeks I have got my German visa with the help of Western Overseas. </p>
								<p class="mt-20 text-right">- <span class="text-red">Catherine Grace,<small><em class="text-gray-lightgray"> CEO apple.inc</em></small></span></p>
							</div>
							
						</div>
					</div>
					<div class="mt-30 mb-20 text-center"><a class="btn btn-red btn-flat view-btn" href="reality-test-testimonials.html">View More →</a></div>
				</div>
				<div class="col-md-6">
					<div class="video-bx">
			
						<div class="owl-carousel owl-carousel-slider">
										<?php 
    $i=0; 
    foreach($All_TSMT_RT_SHORT->error_message->data as $p){     

    if($i==0){
      $class='col-md-12';
    }else{
      $class='col-md-4';
    }    
  ?>
							<div class="lg-video embed-responsive embed-responsive-16by9">
								 <iframe class="embed-responsive-item" src="<?php echo $p->url;?>"></iframe>
							</div>
							<?php $i++;}   ?>
						</div>
						 
					</div>
					<div class="mt-30 mb-20 text-center"><a class="btn btn-red btn-flat view-btn" href="<?php echo base_url('student_reality_test_video');?>">View More →</a></div>
				</div>
			</div>
		</div>
	</section>

<script>
	function searchRealityTest()
  {   
    var course_select_option  = $("#course_select_option option:selected").text();
    var course_select_option_val  = $("#course_select_option").val();    
    var city_select  = $("#city_select").val();
    var branch_select  = $("#branch_select").val();
    var date_select  = $("#date_select").val();
    if(course_select_option == "IELTS") //show city
    {
       $("#city_section").removeClass('hide');
       $("#branch_section").addClass('hide');
    }
    else 
     {
				if(course_select_option_val !="")//show branch
				{
				$("#city_section").addClass('hide');
				$("#branch_section").removeClass('hide');
				}
 		 }

       $.ajax({
          url: "<?php echo site_url('reality_test/searchRealityTest');?>",
          async : true,
          type: 'post',
          data: {course_select_option:course_select_option_val,city_select:city_select,branch_select:branch_select,date_select:date_select},
          success: function(data){

            if(data!=''){
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.success-res').show();*/
              $('#rt_section').html(data);
            }else{
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.no-res').show();
              $('.success-res').hide();*/
              $('#rt_section').html(data);
            }          
          },
          beforeSend: function(){
            
            $('#flter-btm-info').removeClass('hide');
           /* $('.processing-res').show();
            $('.success-res').hide();
            $('.failed-res').hide();
            $('.no-res').hide(); */     
          },
      });
  
  
    
    

  }
</script>
	