<div class="box-body table-responsive table-cb-none mheight200" >
                <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th><?php echo SR; ?></th>
                                    <th>UID - Name</th>
                                    <th>Student E-mail</th>                                    
                                    <th>Student Phone Number</th>                                    
                                    <th>Added By</th>
                                    <th>Package Course</th>
                                    <th>Package Name</th>
                                    <th>Package Price</th>
                                    <th>Paid with out Tax</th>
                                    <th>Paid with Tax</th>
                                    <th>Tax Rates</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>Waiver</th>
                                    <th>Waiver By</th>
                                    <th>Paid On</th>
                                    <th>Payment ID</th>
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
                                    if(strpos($s['remarks'],'Initial')>=0)
                                    {
                                        $amountpaid = $s['amount_paid'];
                                    }
                                    else if(strpos($s['remarks'],'Refund')>=0)
                                    {
                                        $amountpaid = $s['amount'];
                                    }
                                    else
                                    {
                                        $amountpaid = $s['total_amount'];
                                    }
                                ?>
                                <tr>
                                        <td><?php echo $sr; ?></td>
                                        <td><?php echo 'UID- '.$s['UID'].'<br>'.$s['student_name']; ?></td>
                                        <td><?php echo $s['email'] ?></td>
                                        <td><?php echo $s['mobile'] ?></td>                                       
                                        <td><?php echo $s['fname'].' '.$s['lname'];?></td>
                                        <td><?php echo $s['test_module_name'] ?></td>
                                        <td><?php echo $s['package_name']; ?></td>
                                        <td><?php echo CURRENCY.' '.number_format($s['amount']/100,2); ?></td>
                                        <td><?php echo CURRENCY.' '.$s['total_paid_ext_tax']/100; ?></td>
                                        <td><?php echo CURRENCY.' '.number_format($amountpaid/100,2); ?></td>
                                        <td><?php echo (!empty($taxdetail))?'CGST@'.$taxdetail->cgst.'<br>SGST@'.$taxdetail->sgst:''; ?></td> 
                                        <td><?php echo CURRENCY.' '.number_format($s['cgst_amt']/100,2); ?></td>
                                        <td><?php echo CURRENCY.' '.number_format($s['sgst_amt']/100,2); ?></td>
                                        <td><?php echo CURRENCY.' '.number_format($s['waiver']/100,2); ?></td>
                                        <td><?php echo $s['waiver_by']; ?></td>
                                        <td><?php echo $s['requested_on'] ?></td>
                                        <td><?php echo $s['payment_id'] ?></td>
                                        <td><p <?php echo (strpos($s['remarks'],'Refund')) ? 'style="color:red"':''; ?>><?php echo $s['remarks']; ?></p></td> 
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>               
                    </div>
                    <div class="pull-right">
                            <?php echo $page_urls; ?>
                    </div>