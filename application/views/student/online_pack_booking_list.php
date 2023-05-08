<?php if (count($student_package_online) > 0) { ?>
    <div class="col-md-12">
        <div class="head-bg" role="alert"> Online Class Pack </div>
            <div class="form-group bg-success" style="padding-top:10px;padding-bottom:10px;">
            <!-- table start -->
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-success">
                            <tr><?php echo TR_ONLINE_OFFLINE; ?></tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                        
                            foreach ($student_package_online as $sp) {
                            $encId = base64_encode($sp['student_id']);
                            $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                            $classroom_id = $sp['classroom_id'];
                            $classroom_name = $sp['classroom_name'];
                            $holdDateFrom = $sp['holdDateFrom'];
                            $holdDateTo = $sp['holdDateTo'];
                            if(WOSA_ONLINE_DOMAIN==1){
                                if($sp['waiver_by']) {
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
                            <td style="text-align: center;">
                                <?php
                                    if($sp['packCloseReason'] == NULL) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or ( $sp['packCloseReason'] == 'Pack on hold' AND $sp['onHold'] == 1) or $sp['packCloseReason'] == 'Due') {
                                            echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                    }else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else if ($sp['packCloseReason'] == 'Have to be start' AND $sp['package_status']==0) {
                                        echo '<span class="text-red"><a href="javascript:void(0);"data-toggle="tooltip" title="Have to be start"  >' . DEACTIVE . '</a></span>';
                                    }else{
                                        echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                    }
                                   
                                    ?>
                                     <div><?php echo $sp['packCloseReason'];?></div>
                                    </td>
                                    <td><?php echo $sp['package_name']; ?></td>
                                    <td><?php echo $sp['test_module_name'].'/'.$sp['programe_name']; ?></td>
                                    <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration']; ?></td>
                                    <td><a class="text-blue" id="showdata_<?php echo $sp['student_package_id']; ?>" href="javascript:void(0)" onmouseover="show_classroom_desc('<?php echo $classroom_name; ?>','<?php echo $classroom_id; ?>','<?php echo $sp['student_package_id']; ?>')" data-toggle="tooltip" data-placement="top"><?php echo $classroom_name; ?></a></td>
                                    <!-- <td><?php echo $sp['payment_id']; ?></td> -->
                                    <td><?php echo $sp['package_cost']; ?></td>
                                    <td><span>CGST-<?php echo CURRENCY.' '.$sp['cgst_amt'] ?></span></br><span>SGST-<?php echo CURRENCY.' '.$sp['sgst_amt'] ?></span></td>
                                    <?php $totalpackamt = $sp['package_amount'] + $sp['cgst_amt']+$sp['sgst_amt']; ?>
                                    <?php $totalTax = number_format($sp['cgst_amt']+$sp['sgst_amt'],2); ?>
                                    <td><?php echo CURRENCY.' '.$totalpackamt; ?></td>
                                    <td><?php echo CURRENCY.' '.number_format($sp['total_paid_ext_tax'],2); ?></td>
                                    <td><?php echo CURRENCY.' '.$totalTax; ?></td>
                                    <td><?php echo CURRENCY.' '.number_format($sp['amount_paid'],2); ?></td>
                                    <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                    
                                    <td><?php echo $sp['ext_amount']; ?></td>
                                    <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                        <td><?php echo $sp['waiver']; ?></td>
                                        <td><?php echo $waiver_by; ?></td>
                                    <?php } ?>
                                    <!-- <td><?php echo $sp['other_discount']; ?></td> -->
                                    <?php if ($sp['amount_due'] == '0.00') { ?>
                                        <td ><?php echo $sp['amount_due']; ?></td>
                                    <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['amount_due']; ?></td><?php } ?>
                                    <?php if ($sp['irr_dues'] == '0.00') { ?>
                                        <td ><?php echo $sp['irr_dues']; ?></td>
                                    <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                                    <?php } ?>
                                    <td>
                                    <?php
                                        if($sp['due_commitment_date'] != 0){
                                            echo date('d-m-Y', $sp['due_commitment_date']);
                                        }else{
                                            echo NA;
                                        }
                                    ?>
                                    </td>
                                    <td><?php echo $sp['amount_refund']; ?></td>
                                    <td><?php echo date('d-m-Y', $sp['subscribed_on']); ?></td>
                                    <td>
                                        <?php
                                            if(strtotime(date('d-m-Y')) <= strtotime($sp['holdDateTo'])){
                                                echo $sp['holdDateFrom'].' to '. $sp['holdDateTo'];
                                            }else { echo "N/A";}
                                        ?>                                            
                                    </td>
                                    <td><?php echo date('d-m-Y', $sp['expired_on']); ?></td>
                                    <td><?php echo $sp['requested_on']; ?></td>                 
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
        <!-- table ends -->
        </div>
    </div>
    <?php } ?>