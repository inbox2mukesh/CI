<li> <a target="_blank" href="<?php echo site_url('');?>"> <i class="fa fa-globe text-light"></i> <span>Go to Web </span> </a> </li>
<?php 
    if($this->Role_model->_has_access_('ERP_settings','settings')){
?>
<li> <a href="<?php echo site_url('adminController/ERP_settings/settings');?>"> <i class="fa fa-cog text-light"></i> <span>Settings </span> </a> </li><?php } ?>
<li class="txt-act"> <a href="#"> <i class="fa fa-gavel text-light"></i> <span>Admin/Employee </span> </a>
  <ul class="treeview-menu">

    <?php
        if($this->Role_model->_has_access_('user','employee_list')){
    ?>
    <li> <a href="<?php echo site_url('adminController/user/employee_list');?>"><i class="fa fa-list-ul"></i> Employee List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('role','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/role/index');?>"><i class="fa fa-list-ul"></i> Role List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('role','manage_controller')){
    ?>
    <li> <a href="<?php echo site_url('adminController/role/manage_controller');?>"><i class="fa fa-list-ul"></i> Manage modules</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('role','manage_controller_method')){
    ?>
    <li> <a href="<?php echo site_url('adminController/role/manage_controller_method');?>"><i class="fa fa-list-ul"></i> Manage methods</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-users text-light"></i> <span>Students</span> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('student','student_verification')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student/student_verification');?>"><i class="fa fa-id-card-o"></i> Verification</a> </li>
    <?php } ?>
    <?php
        if($this->Role_model->_has_access_('student','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student/index');?>"><i class="fa fa-list-ul"></i> List (Active Students)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('student','inactive_student')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student/inactive_student');?>"><i class="fa fa-list-ul"></i> List (In-Active Students)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('package_transaction','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_transaction/index');?>"><i class="fa fa-inr"></i> Transaction List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('package_transaction','success_package_payment')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_transaction/success_package_payment'); ?>"><i class="fa fa-inr"></i> Success Package Payment</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('package_transaction','all_package_payment')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_transaction/all_package_payment'); ?>"><i class="fa fa-inr"></i> All Package Payment</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('package_transaction','failed_fourmodule_data')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_transaction/failed_fourmodule_data'); ?>"><i class="fa fa-inr"></i> Failed Fourmodule Data</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-file text-light"></i> <span>Reports </span> </a>
  <ul class="treeview-menu">
    <!-- <?php
        if($this->Role_model->_has_access_('reports','waiver_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/reports/waiver_report');?>"><i class="fa fa-list-ul"></i> Waiver Report</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('reports','refund_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/reports/refund_report');?>"><i class="fa fa-list-ul"></i> Refund Report</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('reports','promocode_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/reports/promocode_report');?>"><i class="fa fa-list-ul"></i> Promocode Report</a> </li><?php } ?> -->
    <!-- <?php
        if($this->Role_model->_has_access_('reports','due_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/reports/due_report');?>"><i class="fa fa-list-ul"></i> Dues Report</a> </li><?php } ?> -->
    <?php
        if($this->Role_model->_has_access_('user','user_activity_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/user/user_activity_report');?>"><i class="fa fa-list-ul"></i> User Activity Report</a> </li><?php } ?>
  </ul>
</li>

<li>
  <a href="#">
    <i class="fa fa-list-alt text-light"></i> <span>Lead management </span>
  </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('lead_management','all_Leads')){
    ?>
    <li class="active">
      <a href="<?php echo site_url('adminController/lead_management/all_Leads'); ?>"><i class="fa fa-plus"></i> All Leads</a>
    </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('lead_management','add_new_lead')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/lead_management/add_new_lead'); ?>"><i class="fa fa-plus"></i>Add New Lead</a>
    </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('student','online_registration_leads')){
    ?>
    <li>
    <a href="<?php echo site_url('adminController/student/online_registration_leads'); ?>"><i class="fa fa-globe"></i>Online registration</a>
    </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('student_enquiry','enquiry')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/student_enquiry/enquiry/'); ?>"><i class="fa fa-list-ul"></i> Enquiry List (ALL)</a>
    </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('agent','index')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/agent'); ?>"><i class="fa fa-list-ul"></i> Become An Agent (ALL)</a>
    </li><?php } ?>
    <?php
       /* if($this->Role_model->_has_access_('lead_management','crs_list')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/lead_management/crs_list'); ?>"><i class="fa fa-plus"></i>Leads From CRS</a>
    </li><?php } */?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-university text-light"></i> <span>Classrooms </span> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('classroom','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/classroom/index');?>"><i class="fa fa-list-ul"></i> All classroom</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('classroom_post','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/classroom_post/index');?>"><i class="fa fa-list-ul"></i> List (Trainer Post)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('classroom_announcement','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/classroom_announcement/index');?>"><i class="fa fa-list-ul"></i> List (Announcements)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('online_class_schedule','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/online_class_schedule/index');?>"><i class="fa fa-list-ul"></i> All schedules</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('student_post','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student_post/view_student_post');?>"><i class="fa fa-comments"></i> Live Class Posts</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('live_lecture','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/live_lecture/index');?>"><i class="fa fa-list-ul"></i> List (ALL lecture)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('classroom_documents','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/classroom_documents/index');?>"><i class="fa fa-list"></i> Classroom docs</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-globe text-light"></i> <span>Web Contents(CMS) </span> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('faq_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/faq_master/index');?>"><i class="fa fa-list-ul"></i>FAQ's </a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('free_resources','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/free_resources/index');?>"><i class="fa fa-list"></i> Free Resource</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('other_contents','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/other_contents/index');?>"><i class="fa fa-list"></i> Other Content</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('photo','index')){
    ?>
    <li><a href="<?php echo site_url('adminController/photo/index'); ?>"><i class="fa fa-list-ul"></i>Photo Gallery</a> </li>
    <?php }?>
    <?php
        if($this->Role_model->_has_access_('video','index')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/video/index'); ?>"><i class="fa fa-list-ul"></i>Video List</a>
    </li>
    <?php }?>
    <?php
        if($this->Role_model->_has_access_('news','index')){
    ?>
    <li> 
      <a href="<?php echo site_url('adminController/news/index'); ?>"><i class="fa fa-list-ul"></i>News List</a>
    </li>
    <?php }?>
    <?php
        if($this->Role_model->_has_access_('provinces','index')){
    ?>
    <li>
      <a href="<?php echo site_url('adminController/provinces/index'); ?>"><i class="fa fa-list-ul"></i> List Province</a>
    </li>
    <?php }?>
    <?php
        if($this->Role_model->_has_access_('lead_management','followup_status_list')){
    ?>
    <li class="active"><a href="<?php echo site_url('adminController/lead_management/followup_status_list'); ?>"><i class="fa fa-plus"></i> Followup Status Master</a></li>
    <?php }?>
    <?php
        /*if($this->Role_model->_has_access_('web_media','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/web_media/index');?>"><i class="fa fa-list"></i> Web Media</a> </li><?php } */?>
    <?php
        /*if($this->Role_model->_has_access_('web_banner','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/web_banner/index');?>"><i class="fa fa-list"></i> Web Banner</a> </li><?php } */?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-database text-light"></i><span>Master Inputs </span> </a>
  <ul class="treeview-menu">
    
    <?php
        if($this->Role_model->_has_access_('division_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/division_master/index');?>"><i class="fa fa-list-ul"></i> Division </a> </li><?php } ?>
    
    <?php
        if($this->Role_model->_has_access_('programe_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/programe_master/index');?>"><i class="fa fa-list-ul"></i> Programe </a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('test_module','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/test_module/index');?>"><i class="fa fa-list-ul"></i> Course </a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('category_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/category_master/index');?>"><i class="fa fa-list-ul"></i> Category </a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('batch_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/batch_master/index');?>"><i class="fa fa-list-ul"></i> Batch </a> </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('course_type','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/course_type/index');?>"><i class="fa fa-list-ul"></i> Course type</a> </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('enquiry_purpose','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/enquiry_purpose/index');?>"><i class="fa fa-list-ul"></i> Enquiry Purpose</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('qualification_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/qualification_master/index');?>"><i class="fa fa-list-ul"></i> Qualifications</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('designation_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/designation_master/index');?>"><i class="fa fa-list-ul"></i> Designation</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('source_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/source_master/index');?>"><i class="fa fa-list-ul"></i> Sources</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('document_type','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/document_type/index');?>"><i class="fa fa-list-ul"></i> Document type</a> </li><?php } ?>    
    
    <?php
        if($this->Role_model->_has_access_('content_type_master','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/content_type_master/index');?>"><i class="fa fa-list-ul"></i> Content Type</a> </li><?php } ?>
   
   <?php
        if($this->Role_model->_has_access_('free_resources_topic','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/free_resources_topic/index');?>"><i class="fa fa-list-ul"></i> Free resource Type</a> </li><?php } ?>

    <?php
        if($this->Role_model->_has_access_('gallery','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/gallery/index');?>"><i class="fa fa-list-ul"></i> Gallery</a> </li><?php } ?> 
  </ul>
</li>
<!-- 
<li> <a href="#"> <i class="fa fa-desktop text-light"></i> <span> Counseling Sessions </span> </i> </a>
  <ul class="treeview-menu">
  <?php 
      if($this->Role_model->_has_access_('counseling_session','index')){
    ?>
  <li>
      <a href="<?php echo site_url('adminController/counseling_session/index');?>"><i class="fa fa-list"></i>Counseling List</a>
      </li>
      <?php }?>
  <?php 
      if($this->Role_model->_has_access_('counseling_session','general')){
    ?>
      <li>
      <a href="<?php echo site_url('adminController/counseling_session/general');?>"><i class="fa fa-list"></i>Counseling General Info</a>
      </li>
      <?php }?>
      <?php 
      if($this->Role_model->_has_access_('counseling_session','counselling_booking_list')){
      ?>
      <li>
      <a href="<?php echo site_url('adminController/counseling_session/counselling_booking_list/');?>"><i class="fa fa-list-ul"></i>All booking Lead</a>
      </li>
      <?php }?>
      <?php 
      if($this->Role_model->_has_access_('counseling_session','counselling_booking_completed_list')){
      ?>
      <li>
      <a href="<?php echo site_url('adminController/counseling_session/counselling_booking_completed_list/');?>"><i class="fa fa-list-ul"></i>Success booking Lead</a>
      </li>
      <?php }?> 
   
  </ul>
</li>
 -->
<li> <a href="#"> <i class="fa fa-newspaper-o text-light"></i> <span>Mock Test </span> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('mock_test','upload_mock_test')){
    ?>
    <li> <a href="<?php echo site_url('adminController/mock_test/upload_mock_test');?>"><i class="fa fa-arrow-up"></i> Upload Mock test Report</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('mock_test','all_mockTest_Uploaded')){
    ?>
    <li> <a href="<?php echo site_url('adminController/mock_test/all_mockTest_Uploaded');?>"><i class="fa fa-list"></i>Uploaded Mock test Report list</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-briefcase text-light"></i> <span>Packages </span> </a>
  <ul class="treeview-menu">

    <?php
      if(WOSA_ONLINE_DOMAIN==1){
    ?>
      <?php
          if($this->Role_model->_has_access_('package_master','add_offline_pack')){
      ?>
      <li> <a href="<?php echo site_url('adminController/package_master/add_offline_pack');?>"><i class="fa fa-plus"></i> Add Inhouse Pack</a> </li><?php } ?>
      
      <?php
          if($this->Role_model->_has_access_('package_master','offline_pack')){
      ?>
      <li> <a href="<?php echo site_url('adminController/package_master/offline_pack');?>"><i class="fa fa-list-ul"></i> List (Inhouse)</a> </li><?php } ?>    
   <?php } ?>

    <?php
        if($this->Role_model->_has_access_('package_master','add_online_pack')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_master/add_online_pack');?>"><i class="fa fa-plus"></i> Add Online Pack</a> </li><?php } ?>
    
    <?php
        if($this->Role_model->_has_access_('package_master','online_pack')){
    ?>
    <li> <a href="<?php echo site_url('adminController/package_master/online_pack');?>"><i class="fa fa-list-ul"></i> List (Online)</a> </li><?php } ?>
    
    <?php
        if($this->Role_model->_has_access_('practice_packages','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/practice_packages/add');?>"><i class="fa fa-plus"></i> Add Practice Pack</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('practice_packages','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/practice_packages/index');?>"><i class="fa fa-list-ul"></i> List (Practice Pack)</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-hand-paper-o text-light"></i> <span> Attendance </span> </i> </a>
  <ul class="treeview-menu">

    <?php
      if(WOSA_ONLINE_DOMAIN==1){
    ?>
    <?php
        if($this->Role_model->_has_access_('student_attendance','mark_attendance')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student_attendance/mark_attendance');?>"><i class="fa fa-hand-paper-o text-light"></i> Mark Inhouse Attendance</a> </li>
    <?php } ?>
    <?php } ?>

    <?php
        if($this->Role_model->_has_access_('student_attendance','attendance_report')){
    ?>
    <li> <a href="<?php echo site_url('adminController/student_attendance/attendance_report');?>"><i class="fa fa-file text-light"></i>Attendance Report</a> </li>
    <?php } ?>
  </ul>
</li>

 <li> <a href="#"> <i class="fa fa-usd text-light"></i> <span> Dues </span> </i> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('dues','irrecoverable_dues')){
    ?>
    <li> <a href="<?php echo site_url('adminController/dues/irrecoverable_dues');?>"><i class="text-danger fa fa-usd"></i> Irrecoverable Dues</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('dues','recoverable_dues')){
    ?>
    <li> <a href="<?php echo site_url('adminController/dues/recoverable_dues');?>"><i class="text-success fa fa-usd"></i> Recoverable Dues</a> </li><?php } ?>
  </ul>
</li>

 <li> <a href="#"> <i class="fa fa-arrow-right text-light"></i> <span> Waiver/Refund Request </span> </i> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('waiver','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/waiver/add');?>"><i class="fa fa-list-ul"></i> Raise waiver request</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('waiver','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/waiver/index');?>"><i class="fa fa-list-ul"></i> List (Waiver request)</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('refund','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/refund/add');?>"><i class="fa fa-list-ul"></i> Raise refund request</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('refund','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/refund/index');?>"><i class="fa fa-list-ul"></i> List (Refund request)</a> </li><?php } ?>
  </ul>
</li>

<li> <a href="#"> <i class="fa fa-map-marker text-light"></i> <span>Location master </span> </a>
  <ul class="treeview-menu">
    <?php
        if($this->Role_model->_has_access_('center_location','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/center_location/add');?>"><i class="fa fa-plus"></i> Add Branch</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('center_location','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/center_location/index');?>"><i class="fa fa-list-ul"></i> Branch List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('country','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/country/add');?>"><i class="fa fa-plus"></i> Add country</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('country','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/country/index');?>"><i class="fa fa-list-ul"></i> Country List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('state','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/state/add');?>"><i class="fa fa-plus"></i> Add state</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('state','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/state/index');?>"><i class="fa fa-list-ul"></i> State List</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('city','add')){
    ?>
    <li> <a href="<?php echo site_url('adminController/city/add');?>"><i class="fa fa-plus"></i> Add city</a> </li><?php } ?>
    <?php
        if($this->Role_model->_has_access_('city','index')){
    ?>
    <li> <a href="<?php echo site_url('adminController/city/index');?>"><i class="fa fa-list-ul"></i> City List</a> </li><?php } ?>    
  </ul>
</li>

