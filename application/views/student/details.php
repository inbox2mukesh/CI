<div class="student-details_widget">
   <div class="row panel panel-info">
        <!-- <div class="panel-heading lead">
        <div class="row">
        </div>
    </div>    -->
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12">

                        <div class="student-tab-flex">
                            <div class="heading">
                                <i class="fa fa-user text-danger"></i> <?php echo $title;?>
                            </div>
                            <div class="nav-flex-right">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#Summery" class="bg-primary"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a data-toggle="tab" href="#DOCUMENTS" class="bg-success"><i class="fa fa-file"></i> Docs.</a></li>
                                    <li><a data-toggle="tab" href="#JOURNEY" class="bg-warning"><i class="fa fa-paw"></i> Journey</a></li>
                                    <li><a data-toggle="tab" href="#OF_PACK" class="bg-info"><i class="fa fa-briefcase"></i> Inhouse Pack</a></li>
                                    <li><a data-toggle="tab" href="#OL_PACK" class="bg-primary"><i class="fa fa-briefcase"></i> Online Pack</a></li>
                                    <li><a data-toggle="tab" href="#PP_PACK" class="bg-success"><i class="fa fa-briefcase"></i> Practice Pack</a></li>
                                    <li><a data-toggle="tab" href="#MT_REPORT_IELTS" class="bg-warning"><i class="fa fa-leanpub"></i> MT Report-IELTS</a></li>
                                    <li><a data-toggle="tab" href="#MT_REPORT_PTE" class="bg-info"><i class="fa fa-leanpub"></i> MT Report-PTE</a></li> 
                                    <li><a data-toggle="tab" href="#MT_REPORT_TOEFL" class="bg-info"><i class="fa fa-leanpub"></i> MT Report-TOEFL</a></li>
                                </ul>             

                        </div>
                        </div>

                    <div class="tab-content">

                <div id="Summery" class="tab-pane fade in active">

                <!--tab-design-->
                <div class="student-info-widget">

                        <div class="student-pro-left">

                                <div class="user-profile">
                                    <?php if($basic['profile_pic']){ ?>
                                    <img src='<?php echo base_url($basic['profile_pic']);?>' class="img-responsive img-thumbnail">
                                    </span>
                                    <?php }else{ ?>
                                    <img src='<?php echo 'default_profile_pic.png';?>' class="img-responsive img-thumbnail">
                                    <?php } ?>
                                </div>

                                <div class="user-bal">
                                    <div class="student-balance">
                                        <label>Total Balance</label>
                                        <div class="val"><span>Rs</span><?php echo $basic['wallet']; ?></div>
                                    </div>

                                    <div class="student-id">
                                        <label>Registration Id</label>
                                        <div class="reg-no"><?php echo $basic['student_identity'].'-'.$basic['UID']; ?></div>
                                    </div>
                                </div>

                                <ul class="tab-profile">
                                    <li class="active">Overview</li>
                                </ul>
                                <!-- end:tab-profile -->

                        </div>
                        <!-- end:left-side -->


                        <div class="student-pro-right">

                            <div class="overview-tab">
                                <h3>Overview</h3>
                                <table>

                                    <tr>
                                        <td><b>Registration Id</b></td>
                                        <td><?php echo $basic['student_identity'].'-'.$basic['UID']; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><?php echo $basic['fname'].' '.$basic['lname']; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Father's Name</b></td>
                                        <td><?php echo $basic['father_name']; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Source</b></td>
                                        <td><?php echo $basic['source_name']; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Contact</b></td>
                                        <td><?php echo $basic['country_code'].'-'.$basic['mobile'];?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Email</b></td>
                                        <td>
                                            <a href="mailto:<?php echo $basic['email'];?>"><?php echo $basic['email'];?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Gender</b></td>
                                        <td> 
                                            <?php
                                                if($basic['gender']==1){
                                                    echo 'Male';
                                                }elseif($basic['gender']==2){
                                                    echo 'Female';
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>DOB</b></td>
                                        <td>
                                            <?php
                                                echo $basic['dob'];
                                                $date=date_create($basic['dob']);
                                                $dob = date_format($date,"M d, Y");
                                                echo $dob;
                                            ?>                                                        
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Address</b></td>
                                        <td><?php echo $basic['residential_address'];?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- end:right-side -->
                </div>
                <!--tab-design-->
            </div>



    

    <!-- Practice pack start -->
    <div id="PP_PACK" class="tab-pane fade">

    <div class="panel row"> 
    <div  class="table-ui-scroller"> 
    <div class="box-body table-responsive">

    <table class="table table-striped table-bordered table-sm">
        <thead class="bg-success">
            <tr><?php echo TR_PRACTICE_PACK; ?></tr>
        </thead>
        <tbody id="myTable">
        <?php 
            foreach($student_package_pp as $sp){ 
                $encId = base64_encode($sp['student_id']);
                $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                if(WOSA_ONLINE_DOMAIN==1){
                    if ($sp['waiver_by']) {
                        $waiver_by = $sp['waiver_by'];
                    }else{
                        $waiver_by = NA;
                    }
                }
        ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                <?php if ($sp['payment_file'] != '') { ?>
                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_PP . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if ($sp['packCloseReason'] == NULL){
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else if(($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Pack on hold' or $sp['packCloseReason'] == 'Due') {
                                        echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                    }else if(($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)){
                                            echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else{
                                        echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                    }
                                ?>
                            </td>
                            <td><?php echo $sp['package_name']; ?></td>
                            <td><?php echo $sp['test_module_name'] . '/' . $sp['programe_name']; ?></td>
                            <td><?php echo $sp['discounted_amount'] . '/' . $sp['package_cost'] . '/' . $sp['package_duration'] ?></td>
                            <td><?php echo $sp['amount_paid']; ?></td>
                            <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                            <td><?php echo $sp['ext_amount']; ?></td>
                            <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                <td><?php echo $sp['waiver']; ?></td>
                                <td><?php echo $waiver_by; ?></td>
                            <?php } ?>
                            <!-- <td><?php echo $sp['other_discount']; ?></td> -->
                            <?php if ($sp['amount_due'] == '0.00') { ?>
                                <td><?php echo $sp['amount_due']; ?></td>
                            <?php }else { ?>
                                <td style="color:red"><?php echo $sp['amount_due']; ?></td>
                            <?php } ?>
                            <?php if ($sp['irr_dues'] == '0.00') { ?>
                                <td><?php echo $sp['irr_dues']; ?></td>
                            <?php }else { ?>
                                <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                            <?php } ?>
                            <td>
                                <?php
                                    if($sp['due_commitment_date'] != 0) {
                                        echo date('d-m-Y', $sp['due_commitment_date']);
                                    }else{
                                        echo NA;
                                    }
                                ?>
                            </td>
                            <td><?php echo $sp['amount_refund']; ?></td>
                            <td><?php echo $sp['subscribed_on2']; ?></td>
                            <td>
                                <?php
                                    if(date('d-m-Y') <= $sp['holdDateTo']){
                                        //echo $sp['holdDateFrom'].' - '. $sp['holdDateTo'];
                                        $date=date_create($sp['holdDateFrom']);
                                        $date2=date_create($sp['holdDateTo']);
                                        echo date_format($date,"jS M Y").' - '.date_format($date2,"jS M Y");
                                    }else{
                                        echo "N/A";
                                    }
                            ?></td>                        
                            <td><?php echo $sp['expired_on2']; ?></td>
                            <td><?php echo $sp['requested_on']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
    </div>
    </div>
       </div>
    </div>
    <!-- Practice Pack closed -->

    <!-- OL pack start -->
    <div id="OF_PACK" class="tab-pane fade">
    <div class="panel row"> 
    <div  class="table-ui-scroller"> 
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-warning">
                        <tr>
                            <?php echo TR_OFFLINE;?>
                        </tr>
                        </thead>
                        <tbody id="myTable">                        
                        <?php foreach ($student_package_offline as $sp) {
                            $encId = base64_encode($sp['student_id']);
                            $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                                $classroom_id = $sp['classroom_id'];
                                $classroom_name = $sp['classroom_name'];
                                if ($sp['waiver_by']) {
                                    $waiver_by = $sp['waiver_by'];
                                } else {
                                    $waiver_by = NA;
                                }
                            ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                <?php if ($sp['payment_file'] != '') { ?>
                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span></a>
                                <?php } ?>
                            </td>
                            <td>
                                                                <?php
                                                                if ($sp['packCloseReason'] == NULL) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                } else if ($sp['packCloseReason'] == 'Partial Refund' or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Pack on hold' or $sp['packCloseReason'] == 'Due
                                                                    ') {
                                                                    echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                                                } else {
                                                                    echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $sp['package_name']; ?></td>
                                                            <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration']; ?></td>
                                                            <td><a id="<?php echo $sp['student_package_id']; ?>" href="javascript:void(0)" onmouseover="show_classroom_desc('<?php echo $classroom_name; ?>','<?php echo $classroom_id; ?>','<?php echo $sp['student_package_id'];?>')" data-toggle="tooltip" data-placement="top"><?php echo $classroom_name; ?></a></td>
                                                            <td><?php echo $sp['amount_paid']; ?></td>
                                                            <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                                            <td><?php echo $sp['ext_amount']; ?></td>
                                                            <td><?php echo $sp['waiver']; ?></td>
                                                            <td><?php echo $waiver_by; ?></td>
                                                            <td><?php echo $sp['other_discount']; ?></td>
                                                            <?php if ($sp['amount_due'] == '0.00') { ?>
                                                                <td class="bg-green"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } else { ?>
                                                                <td class="bg-orange"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } ?>
                                                            <td class="bg-danger"><?php echo $sp['irr_dues']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($sp['due_commitment_date']) {
                                                                    echo date('d-m-Y', $sp['due_commitment_date']);
                                                                } else {
                                                                    echo NA;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                        <?php
                                                          if(date('d-m-Y') <= $sp['holdDateTo'] )
                                                          {
                                                            //echo $sp['holdDateFrom'].' - '. $sp['holdDateTo'];
                                                            $date=date_create($sp['holdDateFrom']);
                                                            $date2=date_create($sp['holdDateTo']);
                                                            echo date_format($date,"jS M Y").' - '.date_format($date2,"jS M Y");
                                                          }
                                                          else {
                                                            echo "N/A";
                                                          }
                                                        ?></td>
                                                            <td><?php echo $sp['amount_refund']; ?></td>
                                                            <td><?php echo $sp['subscribed_on2']; ?></td>
                                                            
                                                            <td><?php echo $sp['expired_on2']; ?></td>
                                                            <td><?php echo $sp['requested_on']; ?></td> 
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
                </div>
   

    </div>
    </div>
    <!-- Pack closed -->



    <!-- OL pack start -->
    <div id="OL_PACK" class="tab-pane fade">
            <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-info">
                        <tr>
                            <tr><?php echo TR_ONLINE_OFFLINE; ?></tr>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php 
                            foreach($student_package_online as $sp){ 
                                $encId = base64_encode($sp['student_id']);
                                $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                                $classroom_id = $sp['classroom_id'];
                                $classroom_name = $sp['classroom_name'];
                                $holdDateFrom = $sp['holdDateFrom'];
                                $holdDateTo = $sp['holdDateTo'];

                                if(WOSA_ONLINE_DOMAIN==1){
                                    if($sp['waiver_by']){
                                        $waiver_by = $sp['waiver_by'];
                                    }else{
                                        $waiver_by = NA;
                                    }
                                }

                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span> </a>
                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span> </a>
                                <?php if (isset($sp['payment_file'])) { ?>
                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_ONLINE . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span> </a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if ($sp['packCloseReason'] == NULL) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    } else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or ( $sp['packCloseReason'] == 'Pack on hold' AND $sp['onHold'] == 1) or $sp['packCloseReason'] == 'Due') {
                                    echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                    } 
                                    else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }
                                    else {
                                        echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $sp['package_name']; ?></td>
                                <td><?php echo $sp['test_module_name'].'/'.$sp['programe_name']; ?></td>
                                <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration']; ?></td>
                                <td><a class="text-blue" id="<?php echo $sp['student_package_id']; ?>" href="javascript:void(0)" onmouseover="show_classroom_desc('<?php echo $classroom_name; ?>','<?php echo $classroom_id; ?>','<?php echo $sp['student_package_id']; ?>')" data-toggle="tooltip" data-placement="top"><?php echo $classroom_name; ?></a></td>
                                <!-- <td><?php echo $sp['payment_id']; ?></td> -->
                                <td><?php echo $sp['amount_paid']; ?></td>
                                <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                <td><?php echo $sp['ext_amount']; ?></td>
                                <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                    <td><?php echo $sp['waiver']; ?></td>
                                    <td><?php echo $waiver_by; ?></td>
                                <?php } ?>
                                <!--  <td><?php echo $sp['other_discount']; ?></td> -->
                                <?php if ($sp['amount_due'] == '0.00') { ?>
                                    <td><?php echo $sp['amount_due']; ?></td>
                                <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['amount_due']; ?></td>
                                <?php } ?>
                                <?php if ($sp['irr_dues'] == '0.00') { ?>
                                    <td><?php echo $sp['irr_dues']; ?></td>
                                <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                                <?php } ?>
                                <td>
                                    <?php
                                        if($sp['due_commitment_date'] != 0) {
                                            echo date('d-m-Y', $sp['due_commitment_date']);
                                        }else{
                                            echo NA;
                                        }
                                    ?>
                                </td>
                                <td><?php echo $sp['amount_refund']; ?></td>
                                <td><?php echo $sp['subscribed_on2']; ?></td>
                                <td>
                                    <?php
                                        if(date('d-m-Y') <= $sp['holdDateTo'] ){
                                            //echo $sp['holdDateFrom'].' - '. $sp['holdDateTo'];
                                            $date=date_create($sp['holdDateFrom']);
                                            $date2=date_create($sp['holdDateTo']);
                                            echo date_format($date,"jS M Y").' - '.date_format($date2,"jS M Y");
                                        }
                                        else{
                                            echo "N/A";
                                        }
                                    ?>                                        
                                </td>                      
                                <td><?php echo $sp['expired_on2']; ?></td>
                                <td><?php echo $sp['requested_on']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
         
                </div>
                </div>
    </div>
    <!-- Pack closed -->


    <!-- Journey start -->
    <div id="JOURNEY" class="tab-pane fade">
    <div class="table-responsive panel">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-primary">
                        <tr>
                            <th>Journey</th>
                            <th>Details(code-branch-course)</th>
                            <th>By</th>
                            <th>Created</th>
                            <th>Updated</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($journey as $s){ ?>
                        <tr>
                            <td><?php echo $s['student_identity']; ?></td>
                            <td>
                                <?php echo $s['details']; ?>
                            </td>
                            <td>
                            <?php if($s['fnameu']){ ?>
                                <a href="<?php echo base_url('adminController/user/view_user_profile_/'.base64_encode($s['id']));?>" target="_blank"><?php echo $s['fnameu'].' '.$s['lnameu']; ?></a>
                            <?php } else{ ?>
                                <a href="javascript:void(0);">SELF</a>
                            <?php } ?>
                            </td>
                            <td><?php echo $s['created']; ?></td>
                            <td><?php echo $s['modified']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
      
    </div>
    </div>
    <!-- Journey closed -->


    <!---------Code Add By Neelu ----------->
    <!-- EVENT_PACK start -->
    <div id="EVENT_PACK" class="tab-pane fade">


    <div class="panel row"> 
    <div  class="table-ui-scroller"> 
    <div class="box-body table-responsive">
        <?php
       // $this->load->view('event/student_event_booking_history.php');
        ?>   
    </div>
    </div>
    </div>
    </div>
    <!-- End EVENT_PACK start -->



    <!-- Documents start -->
    <div id="DOCUMENTS" class="tab-pane fade">    

                <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-info">
                        <tr>
                            <th>Type</th>
                            <th>File</th>
                            <th>Uploaded On</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($std_docs as $s){ ?>
                        <tr>
                            <td><?php echo $s['document_type_name']; ?></td>
                            <td>
                                <a href="<?php echo base_url(STD_DOC_FILE_PATH.$s['document_file']);?>" target="_blank"><?php echo OPEN_FILE; ?></a>
                            </td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
         
              

    </div>
    <!-- Documents closed -->

    <!-- RT_REPORT_IELTS start -->
    <div id="RT_REPORT_IELTS" class="tab-pane fade">
   
    <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-primary">
                        <tr>
                            <th>Test Type</th>
                            <th>Centre Number</th>
                            <th>Candidate Number</th>
                            <th>Date of Test</th>
                            <th>Date of Report</th>
                            <th>listening</th>
                            <th>reading</th>
                            <th>writing</th>
                            <th>speaking</th>
                            <th>oa</th>
                            <th>created</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($rtReportIELTS as $s){ ?>
                        <tr>
                            <td><?php echo $s['Test_Type']; ?></td>
                            <td><?php echo $s['Centre_Number']; ?></td>
                            <td><?php echo $s['Candidate_Number']; ?></td>
                            <td><?php echo $s['Date_of_Test']; ?></td>
                            <td><?php echo $s['Date_of_Report']; ?></td>
                            <td><?php echo $s['listening']; ?></td>
                            <td><?php echo $s['reading']; ?></td>
                            <td><?php echo $s['writing']; ?></td>
                            <td><?php echo $s['speaking']; ?></td>
                            <td><?php echo $s['oa']; ?></td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
             
 
    </div>
    </div>
    </div>
    </div>
    <!-- RT_REPORT_IELTS closed -->

    <!-- RT_REPORT_PTE start -->
    <div id="RT_REPORT_PTE" class="tab-pane fade">
    <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
  <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-success">
                        <tr>
                            <th>Test_Taker_ID</th>
                            <th>Test_Centre_ID</th>
                            <th>Date_of_Test</th>
                            <th>Date_of_Report</th>
                            <th>listening</th>
                            <th>reading</th>
                            <th>writing</th>
                            <th>speaking</th>
                            <th>oa</th>
                            <th>gr</th>
                            <th>of</th>
                            <th>pr</th>
                            <th>sp</th>
                            <th>vo</th>
                            <th>wd</th>
                            <th>created</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($rtReportPTE as $s){ ?>
                        <tr>
                            <td><?php echo $s['Test_Taker_ID']; ?></td>
                            <td><?php echo $s['Test_Centre_ID']; ?></td>
                            <td><?php echo $s['Date_of_Test']; ?></td>
                            <td><?php echo $s['Date_of_Report']; ?></td>
                            <td><?php echo $s['listening']; ?></td>
                            <td><?php echo $s['reading']; ?></td>
                            <td><?php echo $s['writing']; ?></td>
                            <td><?php echo $s['speaking']; ?></td>
                            <td><?php echo $s['oa']; ?></td>
                            <td><?php echo $s['gr']; ?></td>
                            <td><?php echo $s['of']; ?></td>
                            <td><?php echo $s['pr']; ?></td>
                            <td><?php echo $s['sp']; ?></td>
                            <td><?php echo $s['vo']; ?></td>
                            <td><?php echo $s['wd']; ?></td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
               
    </div>
    </div>
    </div>
    </div>
    <!-- RT_REPORT_PTE closed -->

    <!-- MT_REPORT_IELTS start -->
    <div id="MT_REPORT_IELTS" class="tab-pane fade">
    <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-warning">
                        <tr>
                            <th>Test_Type</th>
                            <th>Centre_Number</th>
                            <th>Candidate_Number</th>
                            <th>Date_of_Test</th>
                            <th>Date_of_Report</th>
                            <th>listening</th>
                            <th>reading</th>
                            <th>writing</th>
                            <th>speaking</th>
                            <th>oa</th>
                            <th>created</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($mtReportIELTS as $s){ ?>
                        <tr>
                            <td><?php echo $s['Test_Type']; ?></td>
                            <td><?php echo $s['Centre_Number']; ?></td>
                            <td><?php echo $s['Candidate_Number']; ?></td>
                            <td><?php echo $s['Date_of_Test']; ?></td>
                            <td><?php echo $s['Date_of_Report']; ?></td>
                            <td><?php echo $s['listening']; ?></td>
                            <td><?php echo $s['reading']; ?></td>
                            <td><?php echo $s['writing']; ?></td>
                            <td><?php echo $s['speaking']; ?></td>
                            <td><?php echo $s['oa']; ?></td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
                </div>
                </div>
    </div>
    <!-- MT_REPORT_IELTS closed -->

    <!-- MT_REPORT_PTE start -->
    <div id="MT_REPORT_PTE" class="tab-pane fade">
    <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-info">
                        <tr>
                            <th>Test_Taker_ID</th>
                            <th>Test_Centre_ID</th>
                            <th>Date_of_Test</th>
                            <th>Date_of_Report</th>
                            <th>listening</th>
                            <th>reading</th>
                            <th>writing</th>
                            <th>speaking</th>
                            <th>oa</th>
                            <th>gr</th>
                            <th>of</th>
                            <th>pr</th>
                            <th>sp</th>
                            <th>vo</th>
                            <th>wd</th>
                            <th>created</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($mtReportPTE as $s){ ?>
                        <tr>
                            <td><?php echo $s['Test_Taker_ID']; ?></td>
                            <td><?php echo $s['Test_Centre_ID']; ?></td>
                            <td><?php echo $s['Date_of_Test']; ?></td>
                            <td><?php echo $s['Date_of_Report']; ?></td>
                            <td><?php echo $s['listening']; ?></td>
                            <td><?php echo $s['reading']; ?></td>
                            <td><?php echo $s['writing']; ?></td>
                            <td><?php echo $s['speaking']; ?></td>
                            <td><?php echo $s['oa']; ?></td>
                            <td><?php echo $s['gr']; ?></td>
                            <td><?php echo $s['of']; ?></td>
                            <td><?php echo $s['pr']; ?></td>
                            <td><?php echo $s['sp']; ?></td>
                            <td><?php echo $s['vo']; ?></td>
                            <td><?php echo $s['wd']; ?></td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
                </div>
                </div>     
    </div>
    <!-- MT_REPORT_PTE closed -->

    <!-- MT_REPORT_TOEFL start -->
    <div id="MT_REPORT_TOEFL" class="tab-pane fade">
    <div class="row panel">
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-info">
                        <tr>
                            <th>Test_Taker_ID</th>
                            <th>Test_Centre_ID</th>
                            <th>Date_of_Test</th>
                            <th>Date_of_Report</th>
                            <th>listening</th>
                            <th>reading</th>
                            <th>writing</th>
                            <th>speaking</th>
                            <th>oa</th>                            
                            <th>created</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($mtReportTOEFL as $s){ ?>
                        <tr>
                            <td><?php echo $s['Test_Taker_ID']; ?></td>
                            <td><?php echo $s['Test_Centre_ID']; ?></td>
                            <td><?php echo $s['Date_of_Test']; ?></td>
                            <td><?php echo $s['Date_of_Report']; ?></td>
                            <td><?php echo $s['listening']; ?></td>
                            <td><?php echo $s['reading']; ?></td>
                            <td><?php echo $s['writing']; ?></td>
                            <td><?php echo $s['speaking']; ?></td>
                            <td><?php echo $s['oa']; ?></td>
                            <td><?php echo $s['created']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
                </div>
                </div>     
    </div>
    <!-- MT_REPORT_TOEFL closed -->

    <!-- Complaints start -->
    <div id="COMPLAINT" class="tab-pane fade">
    <div class="table-responsive panel">
 
                <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-primary">
                        <tr>
                            <th>ID</th>
                            <!-- <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th> -->
                            <th>Subject</th>
                            <th>Complaint Id</th>
                            <th>Complaint</th>
                            <th>Sent On</th>
                            <th><?php echo STATUS;?></th>
                            <th><?php echo ACTION;?></th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($complaints_box as $p){ ?>
                        <tr>

                            <td><?php echo $p['id']; ?></td>
                            <!-- <td><?php echo $p['fname'].' '.$p['lname']; ?></td>
                            <td><?php echo $p['email']; ?></td>
                            <td><?php echo $p['mobile']; ?></td> -->
                            <td><?php echo $p['subject']; ?></td>
                            <td style="background-color: yellow"><?php echo $p['complain_id']; ?></td>
                            <td><?php echo $p['complaint_text']; ?></td>
                            <td><?php echo $p['created']; ?></td>
                            <td>
                                <?php
                                if($p['active']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to Close Complaint" onclick=activate_deactivete('.$p['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.OPEN.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to Open Complaint" onclick=activate_deactivete('.$p['id'].','.$one.',"'.$table.'","'.$pk.'") >'.CLOSED.'</a></span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($p['isReplied']==0 and $p['active']==1){ ?>
                                <a href="<?php echo site_url('adminController/complaints_box/reply_to_complaints_/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Reply"><span class="fa fa-comments"></span> </a>
                                <?php }elseif($p['active']==1){ ?>
                                <a href="<?php echo site_url('adminController/complaints_box/reply_to_complaints_/'.$p['id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reply again"><span class="fa fa-comment"></span> </a>
                                <?php }else{ ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
               
    </div>
    </div>
    <!-- Complaints closed -->






                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.table-responsive -->
        </div>
    </div>
</div>