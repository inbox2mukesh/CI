
	<!--End Header -->
	<!-- Section-->
	<section class="lt-bg-lighter">
		<div class="container">
			<div class="content-wrapper">
				<!-- Left sidebar -->
			 <?php include('includes/student_profile_sidebar_classroom.php');?>
				<!-- End Left sidebar -->
				<!-- Start Content Part -->
				<div class="content-aside classroom-dash-box" style="padding-bottom: 0px;">
					<div class="announcement-bar text-center">
						 <ul>
              <li><span class="font-weight-600">CLASSROOM ID:</span> <?php echo $_SESSION['classroom_name'];?></li>
              <li><span class="font-weight-600">VALIDITY:</span><?php echo $_SESSION['classroom_Validity'];?></li>
              <li><span class="font-weight-600">DAYS LEFT:</span>  <?php echo $_SESSION['classroom_daysleft'];?></li>
            </ul>
					</div>
					<div class="piechart-bg">
						<div class="row">

							<div class="col-md-4 col-sm-6 text-center">	
								<svg id="pie" width="400" height="400">
								  <g id="pie-group-container"></g>
								</svg>
							</div>

							<div class="col-md-8 col-sm-6">
								<div class="attendance-info">
									<p class="font-22">Overall Attendance - 90%</p>
									<p class="font-18">Last Week's Attendance - 60%</p>

									<p class="font-16 flex-cont"><span>Overall Attendance Rating -</span> <span class="bh-stars" data-bh-rating="4.5">

										  <svg version="1.1" class="bh-star bh-star--1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><path class="outline" d="M12,4.2L14.5,9l0.2,0.5l0.5,0.1l5.5,0.8L16.8,14l-0.4,0.4l0.1,0.5l1,5.3l-5-2.5L12,17.5l-0.4,0.2l-5,2.5L7.5,15l0.1-0.5 L7.2,14l-4-3.7l5.5-0.8l0.5-0.1L9.5,9L12,4.2 M11.9,2L8.6,8.6L1,9.7l5.5,5.1L5.2,22l6.8-3.4l6.8,3.4l-1.3-7.2L23,9.6l-7.6-1L11.9,2 L11.9,2z"></path><polygon class="full" points="18.8,22 12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2 15.4,8.6 23,9.6 17.5,14.7"></polygon><polyline class="left-half" points="12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2"></polyline></svg>
										  
										  <svg version="1.1" class="bh-star bh-star--2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><path class="outline" d="M12,4.2L14.5,9l0.2,0.5l0.5,0.1l5.5,0.8L16.8,14l-0.4,0.4l0.1,0.5l1,5.3l-5-2.5L12,17.5l-0.4,0.2l-5,2.5L7.5,15l0.1-0.5 L7.2,14l-4-3.7l5.5-0.8l0.5-0.1L9.5,9L12,4.2 M11.9,2L8.6,8.6L1,9.7l5.5,5.1L5.2,22l6.8-3.4l6.8,3.4l-1.3-7.2L23,9.6l-7.6-1L11.9,2 L11.9,2z"></path><polygon class="full" points="18.8,22 12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2 15.4,8.6 23,9.6 17.5,14.7"></polygon><polyline class="left-half" points="12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2"></polyline></svg>
										  
										  <svg version="1.1" class="bh-star bh-star--3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><path class="outline" d="M12,4.2L14.5,9l0.2,0.5l0.5,0.1l5.5,0.8L16.8,14l-0.4,0.4l0.1,0.5l1,5.3l-5-2.5L12,17.5l-0.4,0.2l-5,2.5L7.5,15l0.1-0.5 L7.2,14l-4-3.7l5.5-0.8l0.5-0.1L9.5,9L12,4.2 M11.9,2L8.6,8.6L1,9.7l5.5,5.1L5.2,22l6.8-3.4l6.8,3.4l-1.3-7.2L23,9.6l-7.6-1L11.9,2 L11.9,2z"></path><polygon class="full" points="18.8,22 12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2 15.4,8.6 23,9.6 17.5,14.7"></polygon><polyline class="left-half" points="12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2"></polyline></svg>
										  
										  <svg version="1.1" class="bh-star bh-star--4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><path class="outline" d="M12,4.2L14.5,9l0.2,0.5l0.5,0.1l5.5,0.8L16.8,14l-0.4,0.4l0.1,0.5l1,5.3l-5-2.5L12,17.5l-0.4,0.2l-5,2.5L7.5,15l0.1-0.5 L7.2,14l-4-3.7l5.5-0.8l0.5-0.1L9.5,9L12,4.2 M11.9,2L8.6,8.6L1,9.7l5.5,5.1L5.2,22l6.8-3.4l6.8,3.4l-1.3-7.2L23,9.6l-7.6-1L11.9,2 L11.9,2z"></path><polygon class="full" points="18.8,22 12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2 15.4,8.6 23,9.6 17.5,14.7"></polygon><polyline class="left-half" points="12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2"></polyline></svg>
										  
										  <svg version="1.1" class="bh-star bh-star--5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><path class="outline" d="M12,4.2L14.5,9l0.2,0.5l0.5,0.1l5.5,0.8L16.8,14l-0.4,0.4l0.1,0.5l1,5.3l-5-2.5L12,17.5l-0.4,0.2l-5,2.5L7.5,15l0.1-0.5 L7.2,14l-4-3.7l5.5-0.8l0.5-0.1L9.5,9L12,4.2 M11.9,2L8.6,8.6L1,9.7l5.5,5.1L5.2,22l6.8-3.4l6.8,3.4l-1.3-7.2L23,9.6l-7.6-1L11.9,2 L11.9,2z"></path><polygon class="full" points="18.8,22 12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2 15.4,8.6 23,9.6 17.5,14.7"></polygon><polyline class="left-half" points="12,18.6 5.2,22 6.5,14.8 1,9.7 8.6,8.6 11.9,2"></polyline></svg>
										  </span>
										<span class="font-12">Good</span></span>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="calendar-bg">
						<div id="container" class="calendar-container"></div>
					</div>
					<!-- End Content Part -->
					<!---Modal Attendance-->
					<div class="attendance">
						<div class="modal fade" id="modal-calendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
										<h4>Attendance for October 30th, 2021</h4> </div>
									<div class="modal-body">
										<div class="attendance-scroll" id="scroll-style">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th width="65%">Class</th>
															<th width="15%">Time</th>
															<th width="20%" class="text-center">Attendance</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>PTE - Summarize Written Text</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-check-circle text-green font-16"></i></td>
														</tr>
														<tr>
															<td>PTE - Write from Dictation</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-times-circle text-red font-16"></i></td>
														</tr>
														<tr>
															<td>PTE - Summarize Written Text</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-check-circle text-green font-16"></i></td>
														</tr>
														<tr>
															<td>PTE - Write from Dictation</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-times-circle text-red font-16"></i></td>
														</tr>
														<tr>
															<td>PTE - Summarize Written Text</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-check-circle text-green font-16"></i></td>
														</tr>
														<tr>
															<td>PTE - Write from Dictation</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-times-circle text-red font-16"></i></td>
														</tr>
														
														<tr>
															<td>PTE - Write from Dictation</td>
															<td>11.30 AM</td>
															<td class="text-center"><i class="fa fa-times-circle text-red font-16"></i></td>
														</tr>
									
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--End Modal Attendance-->
				</div>
			</div>
	</section>
	<!-- End Section-->
	<!-- Footer -->
		<footer id="footer" class="footer">
			<div class="container">
				<div class="row mob-display">
					<div class="col-sm-6 col-md-3">
						<h4 class="text-uppercase">Quick Links</h4>
						<ul>
							<li><a href="<?php echo base_url('');?>">Home</a></li>
							<li><a href="<?php echo base_url('about_us');?>">About Us</a></li>
							<li><a href="https://western-overseas.com/" target="_blank">Study Visa</a></li>
							<li><a href="<?php echo base_url('free_resources');?>">Free Resources</a></li>
							  <?php
                if($this->session->userdata('student_login_data')){
              ?>
							<li><a href="<?php echo base_url('our_students/student_dashboard');?>">Dashboard</a></li>
				<?php }?>
							<li><a href="<?php echo base_url('contact_us');?>">Contact Us</a></li>
						</ul>
					</div>
					<div class="col-sm-6 col-md-3">
						<h4 class="text-uppercase">Our Products</h4>
						<ul>
							<li><a href="<?php echo base_url('online_courses');?>">Online Courses</a></li>
							<li><a href="<?php echo base_url('offline_courses');?>">Inhouse Courses</a></li>
							<li><a href="<?php echo base_url('practice_packs');?>">Practice Packs</a></li>
							<li><a href="<?php echo base_url('upcoming_workshops');?>"> Events</a></li>
							<li><a href="<?php echo base_url('reality_test');?>">Reality Test</a></li>
						</ul>
					</div>
					<div class="col-sm-6 col-md-3">
						<h4 class="text-uppercase">Our Websites</h4>
						<ul class="list angle-double-right list-border">
							<li><a href="https://western-overseas.com/" target="_blank">www.western-overseas.com</a></li>
							<li><a href="https://www.westernoverseas.events/" target="_blank">www.westernoverseas.events</a></li>
							<li><a href="https://www.ieltsrealitytest.com/" target="_blank">www.ieltsrealitytest.com</a></li>
							<li><a href="https://www.westernoverseas.ca/" target="_blank">www.westernoverseas.ca</a></li>
						</ul>
					</div>
					<div class="col-sm-6 col-md-3">
						<h4 class="text-uppercase">OTHER LINKS</h4>
						<ul>
							<li><a href="#" data-toggle="modal" data-target="#modal-complaint">Complaints</a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal-feedback">Feedback</a></li>
							<li><a href="<?php echo base_url('student_testimonial');?>">Testimonials</a></li>
							<li><a href="<?php echo base_url('offers');?>">News &amp; Offers</a></li>
							<li><a href="<?php echo base_url('faq');?>">FAQ's</a></li>
							<li><a href="<?php echo base_url('term_condition');?>">Terms and Conditions</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-bottom text-center">
					<div class="social-media">
						<ul>
							<li><a href="<?php echo FB;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo TWT;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo YTD;?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
							<li><a href="<?php echo INST;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
					<p class="font-14 mt-20">© <?php echo YY;?> <?php echo COMPANY;?>. All Rights Reserved.</p>
				</div>
			</div>
		</footer> <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
		<!-- End Footer-->
		<!-- Footer Scripts -->
		<script src="<?php echo site_url('resources-f/js/fixed-footer.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/menu-active.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/overlay-menu.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/jquery-2.2.4.min.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/custom.js');?>"></script>
		<script src="<?php echo site_url('resources-f/js/jquery-plugin-collection.js');?>"></script>
		
		<script src="<?php echo site_url('resources-f/js/sidebar.menu.js');?>"></script>

		<script src="<?php echo site_url('resources-f/js/moment.js');?>"></script>
<script src="<?php echo site_url('resources-f/js/bootstrap-datepicker.js');?>">
	
</script>
<script src="<?php echo site_url('resources-f/js/bootstrap-select.js');?>"></script>
<!--<script src="<?php //echo site_url('resources-f/js/bootstrap-select.min.js');?>">-->
	
</script>
<!--
<link href="<?php echo site_url('resources-f/starr/starrr.css');?>" rel="stylesheet" type="text/css">
<script src="<?php echo site_url('resources-f/starr/starrr.js');?>"></script>-->
		<!-- Footer Scripts -->
		<script type="text/javascript"> 
				$('.selectpicker').selectpicker()
	$(document).ready(function() {
		//$("#myModal").modal('show');
	
	});
	
			var date=new Date();
    //$('.datepicker').datepicker({  maxDate: new Date ,format: 'dd-mm-yyyy'})
    $('.datepicker').datepicker({  maxDate: "-1d", format: 'dd-mm-yyyy'});
  </script>
  
	<script src="<?php echo site_url('resources-f/js/jquery.simple-calendar.js');?>"></script>
	<script>
		//$.noConflict();
	  var $calendar;
	  $(document).ready(function () {
	    let container = $("#container").simpleCalendar({
	      fixedStartDay: 0, // begin weeks by sunday
	      disableEmptyDetails: true,
	      events: [
	        // generate new event after tomorrow for one hour
	        {
	          startDate: new Date(new Date().setHours(new Date().getHours() + 24)).toDateString(),
	          endDate: new Date(new Date().setHours(new Date().getHours() + 25)).toISOString(),
	          summary: 'Visit of the Eiffel Tower'
	        },
	        // generate new event for yesterday at noon
	        {
	          startDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 12, 0)).toISOString(),
	          endDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 11)).getTime(),
	          summary: 'Restaurant'
	        },
	        // generate new event for the last two days
	        {
	          startDate: new Date(new Date().setHours(new Date().getHours() - 48)).toISOString(),
	          endDate: new Date(new Date().setHours(new Date().getHours() - 24)).getTime(),
	          summary: 'Visit of the Louvre'
	        }
	      ],

	    });
	    $calendar = container.data('plugin_simpleCalendar')
	  });
	</script>
	<script src="<?php echo site_url('resources-f/js/d3.min.js');?>"></script>
	<script>
	const pieColors = d3.scaleOrdinal(d3.schemeCategory10).domain(["30 %", "70 %"]);
	const radius = 200;
	const outerRadius = 200;
	const innerRadius = 0;
	const padAngle = Math.PI / 180;
	const cornerRadius = 4;

	const arc = d3.arc().
	cornerRadius(cornerRadius).
	innerRadius(innerRadius).
	padAngle(padAngle).
	outerRadius(outerRadius);

	const viz = d3.select("#pie-group-container").
	attr("transform", `translate(${radius},${radius})`);

	function render(pieData) {
	  const arcs = d3.pie().
	  value(d => d.value)(
	  pieData);

	  const pieViz = viz.selectAll("g.slice").
	  data(arcs, d => {
	    return '' + d.data.value + d.data.name + d.index;
	  });

	  const pieEnter = pieViz.
	  enter().
	  append("g").
	  attr("class", "slice").
	  each(function (d) {
	    this._current = d;
	  });;

	  pieEnter.
	  append("path").
	  attr("fill", (d, index) => pieColors(d.data.name)).
	  transition().
	  duration(2500).
	  attrTween("d", function (d) {
	    var interpolate = d3.interpolate(this._current, {
	      startAngle: d.startAngle,
	      endAngle: d.startAngle });

	    var _this = this;
	    return function (t) {
	      _this._current = interpolate(t);
	      return arc(_this._current);
	    };
	  });;

	  pieEnter.
	  append("text").
	  attr("fill", "cyan").
	  attr("transform", (d, i) => {
	    const points = arc.centroid(d);
	    return `translate(${points[0] * 1.5},${points[1] * 1.5})`;
	  }).
	  style("text-anchor", "middle").
	  text(d => d.data.name);

	  const pieUpdate = pieEnter.merge(pieViz);

	  pieUpdate.
	  selectAll("path").
	  transition().
	  duration(2500).
	  attrTween("d", function (d) {
	    var interpolate = d3.interpolate(this._current, {
	      startAngle: d.startAngle,
	      endAngle: d.endAngle });

	    var _this = this;
	    return function (t) {
	      _this._current = interpolate(t);
	      return arc(_this._current);
	    };
	  });

	  pieUpdate.
	  selectAll("text").
	  attr("transform", (d, i) => {
	    const points = arc.centroid(d);
	    return `translate(${points[0] * 1.5},${points[1] * 1.5})`;
	  }).
	  text(d => d.data.name);

	  const pieExit = pieViz.
	  exit().
	  remove();
	}

	render([
	{ name: "30 %", value: 3 },
	{ name: "70 %", value: 7 }]);


	setTimeout(() => render([
	{ name: "30 %", value: 3 },
	{ name: "70 %", value: 7 }]));
	
	</script>

	<style type="text/css">	
	.calendar-container table{width:100%}
	.calendar-container table thead td {  font-size: 20px;  text-transform: capitalize;  font-weight: 600;}
	.calendar-container table td{font-size:20px;text-transform:capitalize;text-align:center}
	.calendar-container .year{display:inline}
	.calendar-container header{margin-bottom:20px}
	.calendar-container .month{text-align:center;padding:12px 15px;text-transform:uppercase;font-size:18px;width:auto;background-color:#fff;border-radius:6px;margin:auto;box-shadow:0 0px 5px rgb(0 0 0 / 20%);line-height:28px;margin-bottom:10px}
	.calendar-container .day.wrong-month.disabled {  background: #e1e1e1;  color: #8f8f8f!important;}
	.calendar-container .btn-prev:before{content:"\f104";font:normal normal normal 14px/1 FontAwesome;font-size:30px}
	.calendar-container .btn-next:before{content:"\f105";font:normal normal normal 14px/1 FontAwesome;font-size:30px}
	.calendar-container a.simple-calendar-btn.btn-prev{font-size:31px;top:3px;position:absolute;left:15px}
	.calendar-container a.simple-calendar-btn.btn-next{font-size:31px;top:3px;position:absolute;right:15px}
	.calendar-container header{position:relative;width:50%;margin:0 auto}
	.calendar-container header{position:relative}
	.calendar-container{width:80%;margin:0 auto}
	.calendar-container .day{
		box-shadow: 0 0px 5px rgb(0 0 0 / 20%); background-color:#fff;font-weight:600;width:60px;height:60px;text-align:center;line-height:60px;border-radius:8px;margin:20px auto 0;font-size:14px}
	.calendar-container .day.has-event{background:#d2feda}
	.calendar-container .day.today{background:#fedcdb}

	#pie .slice path[fill="#ff7f0e"]{fill:#fff}
	#pie .slice path[fill="#1f77b4"]{fill:#fedcdb}
	#pie .slice text{color:#000!important;fill:#000;font-size:34px;font-weight:600}
	svg#pie{zoom:60%}

	/*-- star: rating--*/
	.flex-cont{display:flex;justify-content:unset;text-align:left}
	.bh-stars{display:flex;justify-content:left;margin:0 10px}
	.bh-stars + span.font-12{font-size:16px!important}
	.bh-stars .bh-star{width:1.5rem;height:1.5rem}
	.bh-stars .bh-star .outline{fill:#ffd700}
	.bh-stars .bh-star .full,.bh-stars .bh-star .left-half{fill:transparent}
	.bh-stars[data-bh-rating^="1"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="2"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="3"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="4"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="5"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="2"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="3"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="4"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="5"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="3"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="4"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="5"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="4"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="5"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="5"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars[data-bh-rating^="0.5"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="1.5"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="2.5"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="3.5"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="4.5"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="0.6"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="1.6"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="2.6"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="3.6"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="4.6"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="0.7"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="1.7"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="2.7"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="3.7"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="4.7"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="0.8"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="1.8"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="2.8"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="3.8"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="4.8"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="0.9"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="1.9"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="2.9"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="3.9"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars[data-bh-rating^="4.9"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="5"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="5"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="5"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="5"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="5"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.6"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.6"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.6"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.6"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.6"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.7"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.7"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.7"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.7"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.7"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.8"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.8"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.8"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.8"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.8"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.9"] .bh-star--1 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.9"] .bh-star--2 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.9"] .bh-star--3 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.9"] .bh-star--4 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.9"] .bh-star--5 .full{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.0"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.0"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.0"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.0"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.0"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.1"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.1"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.1"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.1"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.1"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.2"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.2"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.2"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.2"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.2"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.3"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.3"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.3"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.3"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.3"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.4"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.4"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.4"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.4"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.4"] .bh-star--5 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="0.5"] .bh-star--1 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="1.5"] .bh-star--2 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="2.5"] .bh-star--3 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="3.5"] .bh-star--4 .left-half{fill:#ffd700}
	.bh-stars.rounding-up[data-bh-rating^="4.5"] .bh-star--5 .left-half{fill:#ffd700}

	@media only screen and (max-width: 767px) {
		.calendar-container .day{width:30px;height:30px;line-height:30px}
		.calendar-container header{width:100%}
		.flex-cont{display:flex;justify-content:center;text-align:center;flex-direction:column}
		.bh-stars{display:flex;justify-content:center;margin:0 10px}
		.attendance-info p { margin-bottom: 5px!important;}
	}

	</style>

</body>

</html>
	<!-- End Footer-->
	<!-- Footer Scripts -->
	

	<!-- calendar:js -->
	