<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">

                    <a href="<?php echo site_url('adminController/package_transaction/alltransationsbreakdown'); ?>" class="btn btn-success btn-sm">ALL transaction list</a>
                   
                    <!-- <button class="btn btn-default pull-right" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button> -->
                </div>

            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller">
                <h4>Filter Tags</h4>
                <div class="row">
                    <div class="col-md-12" id="schedule-date" style="margin-top:15px;">
                        <button type="button" class="btn btn-warning btn-sm del">Initial Payment
                        </button>
                        <button type="button" class="btn btn-success btn-sm del">Payment Added
                        </button>
                        <button type="button" class="btn btn-info btn-sm del">Pack Extension
                        </button>
                    </div>
                    <!-- <div class="col-md-12" id="schedule-date" style="margin-top:15px;">
                        <button type="button" class="btn btn-success btn-sm del">Payment Added
                        </button>
                    </div>
                    <div class="col-md-12" id="schedule-date" style="margin-top:15px;">
                        <button type="button" class="btn btn-info btn-sm del">Pack Extension
                        </button>
                    </div> -->
                </div>
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><?php echo SR; ?></th>
                                <th>Name</th>
                                <th>Added By</th>
                                <th>Package Name</th>
                                <th>Paid with out Tax</th>
                                <th>Paid with Tax</th>
                                <th>Tax Rates</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>Waiver</th>
                                <th>Waiver By</th>
                                <th>Remarks</th>                               
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
                                $sr++;
                                $taxdetail = json_decode($s['tax_detail']);
                            ?>
                            <tr>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $s['student_name']; ?></td>
                                    <td><?php echo $s['fname'].' '.$s['lname'];?></td>
                                    <td><?php echo $s['package_name']; ?></td>
                                    <td><?php echo CURRENCY.' '.number_format($s['total_paid_ext_tax']/100,2); ?></td>
                                    <td><?php echo CURRENCY.' '.number_format($s['amount_paid']/100,2); ?></td>
                                    <td><?php echo (!empty($taxdetail))?'CGST@'.$taxdetail->cgst.'<br>SGST@'.$taxdetail->sgst:''; ?></td> 
                                    <td><?php echo CURRENCY.' '.number_format($s['cgst_amt']/100,2); ?></td>
                                    <td><?php echo CURRENCY.' '.number_format($s['sgst_amt']/100,2); ?></td>
                                    <td><?php echo number_format($s['waiver']/100,2); ?></td>
                                    <td><?php echo $s['waiver_by']; ?></td>
                                    <td><?php echo $s['remarks']; ?></td> 
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