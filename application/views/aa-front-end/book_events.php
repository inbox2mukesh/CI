<!-- Section-->
    <?php
	$eventBannerImage='no-image.png';
	$eventVideo='';
	$locations=array();
	$locations_dropdown='';
	$eventDescription='';
	if($eventList->error_message->success==1){
		
		$list=$eventList->error_message->data->event;
		$eventBannerImage=$list->eventBannerImage;
		$eventVideo=$list->eventVideo;
		$division_name=strtolower($list->division_name);
		$locations_dropdown=$list->locations_dropdown;
		$eventDescription=$list->eventDescription;
	}
    $eventBannerImageBasePath=FCPATH.'uploads/events/';
	if(!file_exists($eventBannerImageBasePath.$eventBannerImage)){
		
		$eventBannerImage='no-image.png';
	}
	//pr($list,1);
	?>
	<form action="#" method="post" enctype="multipart/form-data" id="ws_form" class="mt-15 theme-bg">	
	<section>
	    <input type="hidden" name="book_pack_type" value="event">
		<input type="hidden" name="package_id" value="<?php echo $list->id?>">
		
		<div class="main-slider"> <img src="<?php echo site_url(EVENTS_IMAGE_PATH.$eventBannerImage);?>" alt="<?php echo $list->eventBannerImageAlt?>" title="<?php echo $list->eventBannerImageTitle?>" class="img-f-full"> </div>
		<div class="container">
			<div class="evnt-video">
				<div class="embed-responsive embed-responsive-16by9">
					<video autoplay preload="auto" loop="loop" muted="muted">
					<source src="<?php echo site_url(EVENTS_IMAGE_PATH.$eventVideo);?>"> 
					</video>
				</div>
			</div>
			<div class="events-form-box event-booking">
				<div class="section-title text-center">
					<h2 class="text-uppercase font-weight-300 font-24 mt-0"><?php echo $title1?> <span class="text-red font-weight-500">  <?php echo $title2?></span></h2> </div>
				<!-----  Form Start  ----->
				<div class="row" style="display: flex; flex-wrap:wrap;">
					<div class="form-group col-md-4 col-sm-6">
						<label>First Name<span class="red-text">*</span></label>
						 <input type="text" class="fstinput" name="fname" id="ws_fname" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>> 
                         <div class="valid-validation ws_fname_error"><?php echo form_error('fname');?></div>
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Last Name</label>
						  <input type="text" class="fstinput" name="lname" id="ws_lname"  value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>> 
                          <div class="valid-validation ws_lname_error"><?php echo form_error('lname');?></div>
						
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Date of Birth<span class="red-text">*</span></label>
						<div class="has-feedback">
                            <input type="text" readonly autocomplete="off" class="fstinput datepicker"  name="dob" id="ws_dob" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" maxlength="10" data-date-format="dd-mm-yyyy" <?php echo $readOnly_dis;?>> <span class="fa fa-calendar form-group-icon"></span>

                        </div>
                       <div class="valid-validation ws_dob_error"></div>
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Country Code<span class="red-text">*</span></label>
				       <select class="selectpicker form-control" data-live-search="true" <?php echo $readOnly_dis;?> name="online_country_code" id="ws_country_code">
                        <option value="">Choose Country Code</option>
                         <?php 
                            foreach ($countryCode->error_message->data as $p)
                            {
                              $selected = ($p->country_code == "+91") ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';                             
                            } 
                        ?>
                    </select>
                     <div class="valid-validation ws_country_code_error"><?php echo form_error('country_code');?></div>
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Mobile Number:<span class="red-text">*</span></label>
						 <input type="text" class="fstinput" name="onlinec_mobile" id="ws_mobile" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>" maxlength="10" <?php echo $readOnly;?>  onkeypress="return isNumberKey(event)" autocomplete="off">
                        <div class="valid-validation ws_mobile_error"><?php echo form_error('mobile');?></div>
						
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Email<span class="red-text">*</span></label>
						 <input type="email" class="fstinput"  name="online_email" id="ws_email" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" maxlength="60" <?php echo $readOnly;?>>  
                        <div class="valid-validation ws_email_error"><?php echo form_error('email');?></div>
					</div>
					
					<!--<div class="form-group col-md-4 col-sm-6">
						<label>Your City<span class="red-text">*</span></label>
						<input type="text" class="fstinput form-control" placeholder="XYZ"> 
					</div>-->
					<div class="form-group col-md-4 col-sm-6">
						<label>Interested Country<span class="red-text">*</span></label>
						<select class="selectpicker form-control" data-live-search="true"  name="int_country" id="ws_int_country" >
                        <option value="">Country</option>
                       <?php 
                             foreach ($allDealCnt->error_message->data as $p)
                             {
                                $selected = ($p->country_id == $this->input->post('country_id')) ? ' selected="selected"' : "";
                                echo '<option value="'.$p->country_id.'" '.$selected.'>'.$p->name.'</option>';
                            } 
                        ?>
                        </select>
                        <div class="valid-validation ws_int_country_error"><?php echo form_error('country_id');?></div>
					</div>
					<div class="form-group col-md-4 col-sm-6">
						<label>Current Education<span class="red-text">*</span></label>
						<select id="ws_qualification" name="qualification" class="selectpicker form-control">
						<option value="">Choose Qualification</option>
						  <?php 
								 foreach ($allQua->error_message->data as $p)
								 {
									$selected = ($p->id == $this->input->post('qualification_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p->id.'" '.$selected.'>'.$p->qualification_name.'</option>';
								} 
							?>
						</select>
						<div class="valid-validation ws_qualification_error"><?php echo form_error('qualification_id');?>
						</div>
					</div>
					
				</div>
				<?php 
                /*
                docStatus ==1 i.e document is uploaded
                docStatus ==0 i.e document is not uploaded
                */
                if($DOC_STATUS->error_message->docStatus ==0)
                {
                  ?>
                <div class="row">
                  <div class="col-md-12 font-weight-600 font-18 mb-10 text-uppercase clearfix"> ID <span class="red-text">Verification</span> </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Document Type:</label>
                    <select class="selectpicker form-control" name="document_type" id="ws_document_type">
                      <option value="">Select Document</option>
                      <?php 
                            foreach ($passport_doc_type->error_message->data as $p)
                            {
                              
                              echo '<option value="'.$p->id.'">'.$p->document_type_name.'</option>';                             
                            } 
                        ?>
                    </select>
                    <div class="valid-validation ws_document_type_error"></div> 
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label for="idProof_front"><span class="text-danger">*</span> Upload Id Proof (Front)</label>
                    <input type="file" class="file-input" id="ws_front" name="front" >
                    <div class="valid-validation ws_front_error"></div>
                    </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label for="idProof_back"> <span class="text-danger">*</span>Upload Id Proof (Back)</label>
                    <input type="file" class="file-input" id="ws_back" name="back">
                    <div class="valid-validation ws_back_error"></div>
                     </div>
                </div>
              <?php }?>
				<!----- Sub Form Start  ----->
				<div class="row">
				    <!-------Hidden Fiels------------->
					<input type="hidden" value="<?php echo $DOC_STATUS->error_message->docStatus;?>" id="wsdocStatus" name="docStatus"/>
					<input type="hidden" value="<?php echo $division_name;?>" id="ws_division_name" name="division_name"/>
					<input type="hidden" name="event_booking_date" value="" id="event_booking_date">
					<input type="hidden" name="event_booking_date_time" value="" id="event_booking_date_time">
					<div class="col-md-12 mt-20">
						<div class="sub-events-form-box">
							<div class="row">
								<div class="form-group col-md-4 col-sm-6">
									<label>Location<span class="red-text">*</span></label>
									<select name="event_location_id" id="ws_event_location_id" class="form-control selectpicker" data-live-search="true" <?php if($division_name=='visa') {?> onchange="getEventLocationCountries()" <?php }else{?> onchange="getEventLocationCourses()"<?php }?>>
										<option value="">Select Location</option>
										<?php 
									    foreach($locations_dropdown as $key=>$val){
										?>
 										<option value="<?php echo $key ?>"><?php echo $val ?></option>
										<?php 
										}
										?>
									</select>
									<div class="valid-validation ws_event_location_id_error"></div>	
								</div>
								<?php 
								if($division_name=='visa'){
								?>
								<div class="form-group col-md-4 col-sm-6">
									<label>Countries<span class="red-text">*</span></label>
									<select name="event_location_countries_id" id="event_location_countries_id"
                                     class="form-control selectpicker" data-live-search="true"
                                    onchange="getEventDateData('countries')">
                                    <option value="">Select Countries</option>
								    </select>
									<div class="valid-validation event_location_course_countries_error"></div>	
								   
								    </span>
								</div>
								<?php 
								}else{?>
								<div class="form-group col-md-4 col-sm-6">
								
									<label>Course<span class="red-text">*</span></label>
									<select name="event_location_course_id" id="event_location_course_id"
										class="form-control selectpicker"  data-live-search="true"
										onchange="getEventDateData('course')">
										<option value="">Select Course</option>
									</select>
									<div class="valid-validation event_location_course_countries_error"></div>	
								</div>
								<?php 
								}?>
								<div class="col-md-12">
									<label>Date &amp; Time<span class="red-text">*</span></label>
									<div class="valid-validation event_booking_date_time_error"></div>
								</div>
								<div class="col-md-12">
									<div class="timeslot-box clearfix" style="display:none" id="dateTimeDiv">
										<div class="glider-contain multiple">
											<div class="timeslot-card-row">
											    <div class="glider dateDiv" id="glider-cut" style="display:none">
												</div>
											</div>
											<button role="button" aria-label="Previous" class="glider-prev" id="cut-prev"><i class="fa fa-chevron-left"></i></i>
											</button>
											<button role="button" aria-label="Next" class="glider-next" id="cut-next"><i class="fa fa-chevron-right"></i></i>
											</button>
										</div>
										<hr>
										<div class="tm-slot-row clearfix" id="timeDiv" style="display:none">
											<!--End Time slot Card info-->
										</div>
									</div>
									<div class="timeslot-box clearfix mt-30" id="load-dates">
										<div class="text-center">Please Select Parameters to load Dates </div>
									</div>
									<div class="timeslot-box clearfix mt-30" id="load-time">
										<div class="text-center">Please Select a date to load Time Slots</div>
									</div>
									<div class="text-right mt-20 lordear-class" style="display:none">
										<span class="text-left font-weight-600 pull-left " id="up"><i class="fa fa-spinner fa-spin mr-10"></i> Available To Load. 
										 </span>
									</div>
									
								</div>
							</div>
						</div>
						<div class="mt-30 text-right">
							<button type="button" class="btn btn-red btn-mdl" onclick="return check_booking()" id="event-booking-submit" disabled="disabled">BOOK</button>
							
						</div>
					</div>
					<!----- End Form Start  ----->
				</div>
			</div>
		</div>
	</section>
	</form>
	<!-- End Section-->
	<!--Content Section-->
	<section class="bg-lighter">
		<div class="container">
		  <div class="section-title text-center">
			<h2 class="text-uppercase font-weight-500 font-24 mt-0">Event Details</h2> </div>
			<div class="events-info">
			<?php 
			  echo $eventDescription;
			?>
			</div>
		</div>
	</section>
	<!-- End Content Section-->
	<script>
	var student_id ='<?php echo $student_id;?>';
	student_id=parseInt(student_id);
	function getEventLocationCountries() {
		
		$("#event-booking-submit").attr("disabled",true);
		$(".event_booking_date_time_error").html('');
		$("#event_booking_date").val('');
		$("#event_booking_date_time").val('');
		$("#event-booking-submit").attr("disabled",true);
		$("#load-time").show();
		$("#load-dates").show();
		$("#dateTimeDiv").hide();
		$(".dateDiv").hide();
		$("#timeDiv").hide();
		
		$('#event_location_countries_id').html('<option data-subtext="" value="">Select Countries</option>');
		$('#event_location_countries_id').selectpicker('refresh');
		event_location_id = $("#ws_event_location_id").val();
		
		if (event_location_id != '') {
			$.ajax({
				url: "<?php echo site_url('book_events/ajax_get_event_location_countries_list_');?>",
				async: true,
				type: 'post',
				data: {
					'event_location_id':event_location_id
				},
				dataType: 'json',
				success: function(data) {
					
					html = '<option data-subtext="" value="">Selec Countries</option>';
					
					for (i = 0; i < data.length; i++) {
						
						val = data[i]['country_id'];
						text = data[i]['name'];
						html += '<option value=' + val + ' >' + text + '</option>';
					}
					$('#event_location_countries_id').html(html);
					$('#event_location_countries_id').selectpicker('refresh');
				}
			});
		}
	}
	
	function getEventLocationCourses() {
		
		$("#event-booking-submit").attr("disabled",true);
	    $(".event_booking_date_time_error").html('');
		$("#event_booking_date").val('');
		$("#event_booking_date_time").val('');
		$("#event-booking-submit").attr("disabled",true);
		$("#load-time").show();
		$("#load-dates").show();
		$("#dateTimeDiv").hide();
		$(".dateDiv").hide();
		$("#timeDiv").hide();
		
		$('#event_location_course_id').html('<option data-subtext="" value="">Select Countries</option>');
		$('#event_location_course_id').selectpicker('refresh');
		event_location_id = $("#ws_event_location_id").val();
		
		
		if (event_location_id  != '') {
			
			$.ajax({
				url: "<?php echo site_url('book_events/ajax_get_event_location_course_list_');?>",
				async: true,
				type: 'post',
				data: {
					'event_location_id': event_location_id
				},
				dataType: 'json',
				success: function(data) {

					//console.log(data);
					html = '<option data-subtext="" value="">Select Course</option>';
					for (i = 0; i < data.length; i++) {
						val = data[i]['test_type_id'];
						text = data[i]['test_module_name'];
						html += '<option value=' + val + ' >' + text + '</option>';

					}
					$('#event_location_course_id').html(html);
					$('#event_location_course_id').selectpicker('refresh');
				}
			});
		}
    }
	
	function getEventDateData(type) {
		
		$("#event-booking-submit").attr("disabled",true);
		$(".event_booking_date_time_error").html('');
		$("#event-booking-submit").attr("disabled",true);
		$("#event_booking_date").val('');
		$("#event_booking_date_time").val('');
		$("#load-time").show();
		$("#dateTimeDiv").hide();
		$(".dateDiv").hide();
		$("#timeDiv").hide();
		
		event_location_id = $("#ws_event_location_id").val();
		event_location_countries_id = $("#event_location_countries_id").val();
		event_location_course_id = $("#event_location_course_id").val();
		
		if (event_location_countries_id == '' && type == 'countries') {
			
			$("#load-dates").show();
			
		} else if (event_location_course_id == '' && type == 'course') {
			
			$("#load-dates").show();
		} else {
			$.ajax({
				url: "<?php echo site_url('book_events/ajax_get_event_location_date_');?>",
				async: true,
				type: 'post',
				data: {
					'event_location_id': event_location_id,
					'event_location_countries_id': event_location_countries_id,
					'event_location_course_id': event_location_course_id,
					'type': type
				},
				dataType: 'html',
				success: function(data) {
					
					$("#load-dates").hide();
					$("#dateTimeDiv").show();
					$(".dateDiv").show();
					$(".dateDiv").html(data);
				}
			});
		}
	}
	
	function getEventLocationTime(event_location_id) {
		
	   $("#event-booking-submit").attr("disabled",true);
	   $(".event_booking_date_time_error").html('');
	   $("#event_booking_date_time").val('');
	   $('.event_date_label').removeClass('sltd'); 
	   $("#l-"+event_location_id).addClass('sltd');
	   $("#timeDiv").show();
	   $("#load-time").show();
	   if (event_location_id == '') {
		   
			$("#load-time").show();
			
	   } else {
		   
			$.ajax({
				url: "<?php echo site_url('book_events/ajax_get_event_location_time_');?>",
				async: true,
				type: 'post',
				data: {
					'event_location_id': event_location_id
				},
				dataType: 'html',
				success: function(data) {
					
					$("#load-time").hide();
					$("#timeDiv").show();
					$("#timeDiv").html(data);
					$("#event_booking_date").val(event_location_id);
				}
			});
		}
	}

	function selectEventTime(time_id) {

		$(".event_booking_date_time_error").html('');
		$("#event_booking_date_time").val(time_id);
		$("#timeDiv .tm-slot").each(function() {
			$(this).find(".event-time-label").removeClass('sltd');
			etl=$(this).find(".etl").val();
			etc=$(this).find(".etc").val();
			$(this).find(".event-time-label").addClass(etc);
			$(this).find(".event-time-label-div ").text(etl);
		})
		
		$("#et-"+time_id).addClass('sltd');
		$("#et-div-"+time_id).text('Selected');
		$("#event-booking-submit").attr("disabled",false);
		if(student_id > 0){
			$("#event-booking-submit").attr("disabled",true);
			$.ajax({
				url: "<?php echo site_url('events/ajax_check_event_location_time_booked_');?>",
				async: true,
				type: 'post',
				data: {
					'time_id': time_id,
					'student_id':student_id
				},
				dataType: 'html',
				success: function(data) {
					if(data==1){
						
						var etc_class=$("#etc-"+time_id).val();
						var etc_labal=$("#etl-"+time_id).val();
						$("#et-div-"+time_id).text(etc_labal);
						$('.event-time-label').removeClass('sltd');
						$("#et-"+time_id).addClass(etc_class);
						$("#event_location_time-"+time_id).prop('checked', false);
						$("#event_booking_date_time").val('');
						
						$(".event_booking_date_time_error").html('This time slot already booked for this student');
						$("#event-booking-submit").attr("disabled",true);
					}else{
						$("#event-booking-submit").attr("disabled",false);
					}
				}
			});
		}
    }
	
	function check_booking()
    {
		var document_type="";
		var front="";
		var back="";
		var event_location_countries_id=event_location_course_id='';
		var docStatus = $("#wsdocStatus").val();
		var numberes = /^[0-9-+]+$/;
		var letters = /^[A-Za-z ]+$/;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var package_id = $("#package_id").val();
		var fname = $("#ws_fname").val();
		var lname = $("#ws_lname").val();
		var email = $("#ws_email").val();
		var mobile = $("#ws_mobile").val();
		var country_code = $("#ws_country_code").val();
		var dob = $("#ws_dob").val();
		var int_country = $("#ws_int_country").val();
		var qualification = $("#ws_qualification").val();
		var event_location_id=$("#ws_event_location_id").val();
		var division_name=$("#ws_division_name").val();
		var event_booking_date=$("#event_booking_date").val();
		var event_booking_date_time=$("#event_booking_date_time").val();
		if(docStatus == 0){
			
			var document_type = $("#ws_document_type").val();
			var front = $("#ws_front").val().split('\\').pop();
			var back = $("#ws_back").val().split('\\').pop();
		}
		if(division_name=='visa'){
			
			event_location_countries_id=$("#event_location_countries_id").val();
		}else{
			event_location_course_id=$("#event_location_course_id").val();
		}
		var checkValidation=true;	
		var form = document.getElementById('ws_form'); //id of form
		var formdata = new FormData(form);
		$(".ws_fname_error").text('');
		$(".ws_lname_error").text('');
		$(".ws_dob_error").text('');
		$(".ws_country_code_error").text('');
		$(".ws_mobile_error").text('');
		$(".ws_email_error").text('');
		$(".ws_int_country_error").text('');
		$(".ws_qualification_error").text('');
		$(".ws_document_type_error").text('');
		$(".ws_front_error").text('');
		$(".ws_back_error").text('');
		$(".ws_event_location_id_error").text('');
		$(".event_location_course_countries_error").text('');
		$(".event_booking_date_time_error").text('');
		
		if(!fname.match(letters)){
			
			$("#ws_fname").focus();
			$(".ws_fname_error").text("Please enter valid Name. Numbers not allowed!");
			checkValidation=false;
		}
		if(!lname.match(letters) && lname !=''){
			alert
			$("#ws_lname").focus();
			$(".ws_lname_error").text("Please enter valid Last Name. Numbers not allowed!");
			checkValidation=false;
		}
		
		if(dob == ""){
			//$("#ws_dob").focus();
			$(".ws_dob_error").text('Please select dob');
			checkValidation=false;
		}
		if(country_code == ""){
			
			$("#ws_country_code").focus();
			$(".ws_country_code_error").text('Please select country code');
			checkValidation=false;
		}
		if(mobile.length >10 || mobile.length <10){
			
			$("#ws_mobile").focus();
			$(".ws_mobile_error").text('Please enter valid Number of 10 digit');
			checkValidation=false;
		}
		if(!validate_complaint_email(email)){
			
			checkValidation=false;
			$("#ws_email").focus();
			$(".ws_email_error").text('Please enter valid Email Id');
		}
		if(int_country == ""){
			
			$("#ws_int_country").focus();
			$(".ws_int_country_error").text('Please select interested Country');
			checkValidation=false;
		}
		if(qualification == ""){
			
			$("#ws_qualification").focus();
			$(".ws_qualification_error").text('Please select Current Education');
			checkValidation=false;
		}
		if(docStatus == 0)
		{
			if(document_type == ""){
				
				$("#ws_document_type").focus();
				$(".ws_document_type_error").text('Please select Document Type');
				checkValidation=false;
			}
			if(front =="")
			{
			  $("#ws_front").val('');
			  $("#ws_front").focus();
			  $(".ws_front_error").text("Please Choose Upload Id Proof (Front)");
			  checkValidation=false;
			}else if(validate(front) !=1){
			  $("#ws_front").val('');
			  $("#ws_front").focus();
			  $(".ws_front_error").text("File Format not supported!");
			  checkValidation=false;
			}
			if(back =="")
			{
			  $("#ws_back").val('');
			  $("#ws_back").focus();
			  $(".ws_back_error").text("Please Choose Upload Id Proof (Back)");
			  checkValidation=false;
			}else if(validate(back) !=1){
			  $("#ws_back").val('');
			  $("#ws_back").focus();
			  $(".ws_back_error").text("File Format not supported!");
			  checkValidation=false;
			}
		}
		if(event_location_id==''){
			
			$("#event_location_id").focus();
			$(".ws_event_location_id_error").text("Please select location");
			checkValidation=false;
		}
		if(division_name=='visa'){
			
			if(event_location_countries_id==''){
				
				$("#event_location_countries_id").focus();
				$(".event_location_course_countries_error").text("Please select location");
				checkValidation=false;
			}
		}else{
			
			if(event_location_course_id==''){
				
				$("#event_location_course_id").focus();
				$(".event_location_course_countries_error").text("Please select location");
				checkValidation=false;
			}
		}
		if(event_booking_date==''){
			
			$(".event_booking_date_time_error").text("Please select date");
			checkValidation=false;
			
		}else if(event_booking_date_time==''){
			
			$(".event_booking_date_time_error").text("Please select time");
			checkValidation=false;
		}
	    
		if(checkValidation){
			
			$.ajax({
				url: "<?php echo site_url('booking/check_booking');?>",
				type: 'post',
				data: formdata,
				processData: false,
				contentType: false,             
				success: function(response){  
				if(response.status=='true')
				{
				$('#onlinecoursemodel'+package_id).modal('hide');
				$('#modal-reg-OTP').modal('show');       
				}
				else if(response.status==2)
				{
				  /*window.location.href = "<?php ///echo site_url('booking/checkout');?>"*/
				 $('#onlinecoursemodel'+package_id).modal('hide');
				 $('#modal-login').modal('show');   
				}
				else if(response.status==3)
				{
				window.location.href = "<?php echo site_url('booking/checkout');?>"          

				}
				else
				{
				$('#checkout_btn'+package_id).prop('disabled', false);
				  $('#regmain_msg_danger'+package_id).html(response.msg);
				  $(".anc_clickhere").focus();
				  }                  
				},
				beforeSend: function(){
				   $('#checkout_btn'+package_id).prop('disabled', true);
				}
			});
		}else{
			return checkValidation;
		}
    }
	
    function validate(file) {
		var ext = file.split(".");
		ext = ext[ext.length-1].toLowerCase();      
		var arrayExtensions = ["jpg" , "jpeg", "png",'pdf'];
		if (arrayExtensions.lastIndexOf(ext) == -1) {
		  return -1;
		}
	    else {
		   return 1;
	    }
	}
	function getFilePath(){
		
		 $('input[type=file]').change(function () {
			 var filePath=$('#fileUpload').val(); 
		 });
	}
	function validate_complaint_email(email){
	  
		var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		if(email.match(mailformat)){
			$(".ws_email_error").text('');
			return true;
		}else{
			$(".ws_email_error").text("Please enter valid email Id!");
			$('#ws_email').focus();
		   return false;
		}
	}
	
	function isNumberKey(evt) {
		
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
		return false;
		return true;
    }
	</script>