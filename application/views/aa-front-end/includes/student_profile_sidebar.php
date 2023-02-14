<div class="left-aside">
					<div class="no-lg-display">
						<button onclick="myFunction()" id="toggle" class="closed dropbtn">DASHBOARD MENU <span class="pull-right"><i class="fa fa-angle-right font-18 icon-rotate"></i></span></button>
					</div>
					<!-- sidebar -->
					<div class="sidebarnav sidemenu-content" id="myDropdown">
						<!-- Start Sidebar menu -->
						<div class="scrollbar scrollbar-use-navbar scrollbar-bg-white">
							<ul class="list list-bg-white">
								<li><a href="<?php echo base_url('our_students/student_dashboard');?>" class="text-uppercase  <?php if($segment=="student_dashboard"){ echo "active-text"; }?>">Dashboard</a></li>								
								<li><a href="https://practice.western-overseas.com" class="text-uppercase" target="_blank">Practice Portal</a></li>
								<!-- <li class="list-item"><a href="#" class="link-arrow text-uppercase link-current">Practice Portal</a>
					<ul class="list-unstyled list-hidden mt-5">
						<div class="submenu link-current">
							<ul>
								<li><a href="https://www.westernoverseas.ca/practice/" target="_blank">IELTS Practice Portal</a></li>
								<li><a href="https://westernoverseas.org/login" target="_blank">PTE Practice Portal</a></li>
							</ul>
						</div>
					</ul>
				</li> -->
								<li class="hide"><a href="#" class="text-uppercase" data-toggle="modal" data-target="#modal-classroom">Classroom Home</a></li>
								<li class=""><a href="<?php echo base_url('our_students/mock_test_reports');?>" class="text-uppercase <?php if($segment=="mock_test_reports"){echo "active-text"; }else{echo "";}?>">Mock Test Report</a></li>
								<li class="list-item hide"><a href="#" class="link-arrow text-uppercase link-current">Booking</a>
									<ul class="list-unstyled list-hidden mt-5">
										<div class="submenu link-current">
											<ul>
												<li><a href="<?php echo base_url('our_students/reality_test_booking');?>">Reality Test</a></li>
											    <li><a href="events-booking.html">Events</a></li>
											    
												<li><a href="<?php echo base_url('our_students/exam_booking');?>">Exam Booking</a></li>
												<li><a href="<?php echo base_url('our_students/session_booking');?>">Session Booking</a></li>
											</ul>
										</div>
									</ul>
								</li>
								<li class="list-item hide"><a href="#" class="link-arrow text-uppercase link-current">Reports</a>
									<ul class="list-unstyled list-hidden mt-5">
										<div class="submenu">
											<ul>
												<li><a href="<?php echo base_url('our_students/reality_test_reports');?>" class="<?php if($segment=="reality_test_reports"){echo "active-text"; }else{echo "";}?>">Reality Test Report</a></li>
												<li><a href="<?php echo base_url('our_students/mock_test_reports');?>" class="<?php if($segment=="mock_test_reports"){echo "active-text"; }else{echo "";}?>">Mock Test Report</a> </	li>
											</ul>
										</div>
									</ul>
								</li>
								<li class="hide"><a href="<?php echo base_url('our_students/student_complains');?>" class="text-uppercase">Complaints<span class="pull-right"><i class="fa fa-bell text-red"></i></span></a></li>
								<li class="hide"><a href="<?php echo base_url('our_students/student_request');?>" class="text-uppercase">Student Requests<span class="pull-right"><i class="fa fa-bell text-red"></i></span></a></li>
								<li class="hide"><a href="<?php echo base_url('our_students/shared_documents');?>" class="text-uppercase  <?php if($segment=="shared_documents"){echo "active-text"; }else{echo "";}?>">My Documents</a></li>
								<li><a href="<?php echo base_url('our_students/order_history');?>" class="text-uppercase <?php if($segment=="order_history"){echo "active-text"; }else{echo "";}?>">Order History</a></li>
								<li class="hide"><a title="Logout" class="logout-btn bg-theme-color" href="<?php echo site_url()?>my_login/student_logout">Logout</a></li>
								

							</ul>
						</div>
						<!--End sidebar menu -->
					</div>
				</div>
				


