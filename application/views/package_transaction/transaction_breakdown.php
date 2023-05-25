<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('adminController/package_transaction/alltransationsbreakdown'); ?>" class="btn btn-success btn-sm">ALL transaction list</a>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller">
                <h4>Filter</h4>
                    <div class="row">
                            <div class="col-md-12" id="schedule-date" style="margin-top:15px;">
                                <?php
                                $attribs = array('class' => '','id' => 'transaction_search','name' => 'transaction_search','method' => 'post') ;
                                echo form_open('',$attribs); ?>
                                    <div class="clearfix" style="padding:5px;">
                                        <div class="col-md-4">
                                                <label for="search_text" class="control-label">Search</label>
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control input-ui-100" id="search_text" name="search_text" value="<?php echo $this->input->post('search_text'); ?>"/>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <label for="added_by" class="control-label">Added By</label>
                                                <div class="form-group has-feedback">
                                                    <select name="added_by[]" id="added_by" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple"> 
                                                        <option value="">Select User</option>
                                                        <?php
                                                        $paddedby = $this->input->post('added_by'); 
                                                        foreach($userlist as $usr) { ?>
                                                            <option value="<?php echo $usr['id'] ?>"<?php echo (is_array($paddedby) && in_array($usr['id'],$paddedby)) ?'selected':'';?>><?php echo $usr['fname'].' '.$usr['lname'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <label for="courses" class="control-label">Course</label>
                                                <div class="form-group has-feedback">
                                                    <select name="courses[]" id="courses" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple"> 
                                                        <option value="">Select Course</option>
                                                        <?php
                                                        $courseby = $this->input->post('courses');  
                                                        foreach($course as $crse) { ?>
                                                            <option value="<?php echo $crse['test_module_id'] ?>" <?php echo (is_array($courseby) && in_array($crse['test_module_id'],$courseby)) ?'selected':'';?>><?php echo $crse['test_module_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date" class="control-label">Payment Date</label>
                                            <div class="form-group has-feedback">
                                                <input type="text" readonly name="paymentdate" value="<?php echo $this->input->post('paymentdate'); ?>" class="form-control payment_date_range input-ui-100" id="paymentdate" />
                                                <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                                <span class="text-danger paymentdate_err"><?php echo form_error('paymentdate');?></span>
                                            </div>
                                        </div>       
                                        <div class="col-md-12"> 
                                            <button type="submit" class="btn btn-danger rd-20" name="search_btn" >
                                                <?php echo SEARCH_LABEL;?>
                                            </button>
                                            <button type="button" class="btn btn-reset rd-20 ml-5"  name="reset_btn" onclick="formReset();">
                                                Reset
                                            </button>            
                                        </div>
                                    </div>            
                                <?php echo form_close(); ?>
                            </div>
                    </div>
                    
                <h4>Filter Tags</h4>
                <div class="row">
                <div class="clearfix" style="padding:5px;">
                    <div class="col-md-12" id="schedule-date" style="margin-top:15px;">
                        <button type="button" class="btn btn-warning btn-sm del" onclick="filtertransaction('Initial payment');">Initial Payment</button>
                        <button type="button" class="btn btn-success btn-sm del" onclick="filtertransaction('Add Payment');">Payment Added</button>
                        <button type="button" class="btn btn-info btn-sm del" onclick="filtertransaction('Pack Extension');">Pack Extension</button>
                        <button type="button" class="btn btn-info btn-sm del" onclick="filtertransaction('Partial Refund');">Partial Refund</button>
                        <button type="button" class="btn btn-info btn-sm del" onclick="filtertransaction('Full Refund');">Full Refund</button>
                        <button type="button" class="btn btn-info btn-sm del" onclick="filtertransaction('reset');">Reset</button>
                    </div>
                </div>
                <div id="printableArea">
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
                </div>
            </div>
        </div>

    </div>
</div>
<?php ob_start();?> 
<script>
    function filtertransaction(filteron=null)
    {
        let srchtext = $('#search_text').val();
        let srchpaymentdate = $('#payment_date').val();
        if(filteron)
        {
            $.ajax({
                url:WOSA_ADMIN_URL+'Package_transaction/ajax_filtertransaction',
                method:'POST',
                data:{filtertype:filteron,srchtext:srchtext,srchpaymentdate:srchpaymentdate},
                success:function(data)
                {
                    $('#printableArea').html(data);
                }

            });
        }
    }
    

    function formReset()
    {
        $('#search_text').val('');
        $('#paymentdate').val('');
        $("#added_by option:selected").removeAttr("selected");
        $("#courses option:selected").removeAttr("selected");
        $("#transaction_search").submit();
    }
    $(document).ready(function(){
        $('input[name="paymentdate"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YY',
                cancelLabel: 'Clear'
                }

        });
        $('input[name="paymentdate"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

        });

        $('input[name="paymentdate"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        picker.setStartDate({});
        picker.setEndDate({});
        });

    });
</script>
<?php global $customJs;
$customJs=ob_get_clean();
?> 