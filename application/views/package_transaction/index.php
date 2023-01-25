<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">

                    <a href="<?php echo site_url('adminController/package_transaction/index'); ?>" class="btn btn-success btn-sm">ALL transaction list</a>
                    <?php foreach ($all_testModule as $t) {
                        $test_module_id =  $t['test_module_id']; ?>
                        <a href="<?php echo site_url('adminController/package_transaction/index/' . $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name']; ?></a>
                    <?php } ?>
                    <!-- <button class="btn btn-default pull-right" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button> -->
                </div>

            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><?php echo SR; ?></th>
                                <th class='noPrint'><?php echo ACTION; ?></th>
                                <th>Pack Status</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Pack/Cost</th>
                                <th>Type</th>
                                <th>Amount Paid</th>
                                <th>Waiver</th>
                                <th>Dis.</th>
                                <th>Dues</th>
                                <th>Refunds</th>
                                <th>Method</th>                                
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>Subscribed</th>
                                <th>Expiry</th>
                                <th>Requested</th>                                
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            if (!empty($this->input->get('per_page'))) {

                                $sr = $this->input->get('per_page');
                            } else {

                                $sr = 0;
                            }
                            foreach ($transaction as $s) {
                                $zero = 0;
                                $one = 1;
                                $pk = 'student_package_id';
                                $table = 'student_package';
                                $sr++;
                                if (!$s['package_name']) {
                                    $package_name = 'Reality Test';
                                } else {
                                    $package_name = $s['package_name'];
                                }
                                $encId = base64_encode($s['id']);
                                $url = site_url('adminController/student/student_transaction_/' . $s['student_package_id'] . '/' . $encId);
                                $pack_type = $s['pack_type'];
                            ?>
                                <tr>
                                    <td><?php echo $sr; ?></td>
                                    <td class='noPrint'>
                                        <?php if ($pack_type == 'online' or $pack_type == 'offline') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><span class="fa fa-usd"></span></a>
                                        <?php } elseif ($pack_type == 'practice') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><span class="fa fa-usd"></span></a>
                                        <?php } else { ?> 
                                        
                                        <?php } ?>
                                        <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($s['package_status'] == 1) {
                                            echo '<span class="text-danger">' . ACTIVE . '</span>';
                                        } else {
                                            echo '<span class="text-danger">' . DEACTIVE . '</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $s['fname'] . ' ' . $s['lname']; ?></td>
                                    <td><?php echo $s['contact']; ?></td>
                                    <td><?php echo $package_name . SEP . $s['amount']; ?></td>
                                    <td><?php echo $pack_type; ?></td>
                                    <td><?php echo $s['amount_paid']; ?></td>
                                    <td><?php echo $s['waiver']; ?></td>
                                    <td><?php echo $s['other_discount']; ?></td>
                                    <td><?php echo $s['amount_due']; ?></td>
                                    <td><?php echo $s['amount_refund']; ?></td>
                                    <td><?php echo $s['method']; ?></td>
                                    <td>
                                        <?php if ($pack_type == 'online' or $pack_type == 'offline') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['order_id'] ?></a>
                                        <?php } elseif ($pack_type == 'practice') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['order_id']; ?></a>
                                        <?php } elseif ($pack_type == 'reality test') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_reality_test_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['order_id']; ?></a>
                                        <?php } else { ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($pack_type == 'online' or $pack_type == 'offline') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['payment_id'] ?></a>
                                        <?php } elseif ($pack_type == 'practice') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['payment_id']; ?></a>
                                        <?php } elseif ($pack_type == 'reality test') { ?>
                                            <a href="<?php echo site_url('adminController/student/adjust_reality_test_/' . $s['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment"><?php echo $s['payment_id']; ?></a>
                                        <?php } else { ?>
                                        <?php } ?>                                       
                                    </td>
                                    <td><?php echo $s['subscribed_on']; ?></td>
                                    <td><?php echo $s['expired_on']; ?></td>
                                    <td><?php echo $s['requested_on']; ?></td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>                 
                </div>
                <div class="pull-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>