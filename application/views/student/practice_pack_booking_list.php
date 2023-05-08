<?php if (count($student_package_pp) > 0) {?>
                            <div class="col-md-12">
                                <div class="head-bg" role="alert">Practice Pack </div>
                                <div class="form-group bg-warning" style="padding-top:10px;padding-bottom:10px;">
                                    <!-- table start -->
                                    <div class="table-ui-scroller">
                                        <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                                            <table class="table table-striped table-bordered table-sm pp-bg">
                                                <thead class="bg-warning">
                                                    <tr class="bg-warning">
                                                        <?php echo TR_PRACTICE_PACK; ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php foreach ($student_package_pp as $sp) {
                                                        $encId = base64_encode($sp['student_id']);
                                                        $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                                                        if(WOSA_ONLINE_DOMAIN==1){
                                                            if($sp['waiver_by']) {
                                                                $waiver_by = $sp['waiver_by'];
                                                            }else{
                                                                $waiver_by = NA;
                                                            }
                                                        }
                                                        $tax_detail = json_decode($sp['tax_detail']); 
                                                        $cgst_per = $tax_detail->cgst;
                                                        $sgst_per = $tax_detail->sgst;
                                                        $cgst_amt = ($sp['package_amount'] * $cgst_per)/100;
                                                        $sgst_amt = ($sp['package_amount'] * $sgst_per)/100;
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
                                                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                                                <?php if ($sp['payment_file'] != '') { ?>
                                                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_PP . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?php
                                                                  if ($sp['packCloseReason'] == NULL) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                } else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Pack on hold' or $sp['packCloseReason'] == 'Due') {
                                                                    echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                                                } 
                                                                else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                }else if ($sp['packCloseReason'] == 'Have to be start' AND $sp['package_status']==0) {
                                                                    echo '<span class="text-res"><a href="javascript:void(0);"data-toggle="tooltip" title="Have to be start"  >' . DEACTIVE . '</a></span>';
                                                                }else {
                                                                    echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                                                }
                                                                ?>
                                                                
                                                                <div><?php echo $sp['packCloseReason']?></div>
                                                            </td>
                                                            <td><?php echo $sp['package_name']; ?></td>
                                                            <td><?php echo $sp['test_module_name'] . '/' . $sp['programe_name']; ?></td>
                                                            <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration'] ?></td>                                          
                                                            <td><?php echo $sp['package_cost']; ?></td>
                                                            <td><span>CGST-<?php echo CURRENCY.' '.$cgst_amt ?></span></br><span>SGST-<?php echo CURRENCY.' '.$sgst_amt ?></span></td>
                                                            <!-- price + taxes -->
                                                            <?php $totalpackamt = $sp['package_amount'] + $sgst_amt+$cgst_amt; 
                                                            $totaltax = $sp['cgst_amt']+$sp['sgst_amt'];
                                                            ?>
                                                            <td><?php echo CURRENCY.' '.number_format($totalpackamt,2); ?></td>
                                                            <td><?php echo  CURRENCY.' '.number_format($sp['total_paid_ext_tax'],2); ?></td>
                                                            
                                                            <td><?php echo CURRENCY.' '.number_format($sp['cgst_amt']+$sp['sgst_amt'],2); ?></td>
                                                            <td><?php echo CURRENCY.' '.number_format($sp['amount_paid'],2); ?></td>
                                                            <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                                            <!-- <td><?php echo $sp['package_cost']; ?></td>
                                                            <td><?php echo $sp['package_cost']; ?></td>
                                                            <td><span>CGST-<?php echo CURRENCY.' '.$sp['cgst_amt'] ?></span></br><span>SGST-<?php echo CURRENCY.' '.$sp['sgst_amt'] ?></span></td> -->
                                                            
                                                            <td><?php echo $sp['ext_amount']; ?></td>
                                                            <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                                                <td><?php echo $sp['waiver']; ?></td>
                                                                <td><?php echo $waiver_by; ?></td>
                                                            <?php } ?>
                                                            <!-- <td><?php echo $sp['other_discount']; ?></td> -->
                                                            <?php if ($sp['amount_due'] == '0.00') { ?>
                                                                <td ><?php echo $sp['amount_due']; ?></td>
                                                            <?php } else { ?>
                                                                <td style="color:red"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } ?>
                                                            <?php if ($sp['irr_dues'] == '0.00') { ?>
                                                                <td ><?php echo $sp['irr_dues']; ?></td>
                                                            <?php } else { ?>
                                                                <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                                                            <?php } ?>
                                                            <td>
                                                                <?php
                                                                if ($sp['due_commitment_date'] != 0) {
                                                                    echo date('d-m-Y', $sp['due_commitment_date']);
                                                                } else {
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
                                                            ?></td>                                                           
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