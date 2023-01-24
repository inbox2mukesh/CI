<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');
            $sessiontypeList = getSessionType();
            ?>
            <br>
            <form action="<?php echo base_url() ?>adminController/counseling_session/counselling_booking_list/" method="POST" onsubmit="return validate_sform();">
                <div class="box-body">
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Session Type</label>
                        <div class="form-group">
                            <select name="session_type" id="session_type" class="form-control selectpicker selectpicker-ui-100">
                                <option value="">Select <?php echo $this->input->post('session_type'); ?></option>
                                <?php foreach ($sessiontypeList as $key => $val) {
                                    $selec;
                                    if ($val == $this->input->post('session_type')) {
                                        $selec = "selected";
                                    }
                                ?>
                                    <option value="<?php echo $key ?>" <?php echo $selec; ?>>
                                        <?php echo $val ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Booking Date </label>
                        <div class="form-group has-feedback">
                            <input type="text" readonly name="booking_pdate" value="" class="form-control date_range input-ui-100" id="booking_pdate" />
                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                            <span class="text-danger date_err"><?php echo form_error('booking_pdate'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Session Date </label>
                        <div class="form-group has-feedback">
                            <input type="text" readonly name="session_datew" value="<?php echo $this->input->post('session_datew'); ?>" class="form-control date_range input-ui-100" id="session_datew" />
                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                            <span class="text-danger date_err"><?php echo form_error('session_datew'); ?></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                <label for="date" class="control-label"><span class="text-danger">*</span>Session Date</label>
                <div class="form-group has-feedback">
                    <input type="text" name="session_datew" value="<?php echo $this->input->post('session_datew'); ?>" class="form-control has-datepicker" id="date" data-date-format="DD-MM-YYYY"/>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('date'); ?></span>
                </div>
            </div> -->
                    <div class="col-md-3 hide">
                        <label for="date" class="control-label"><span class="text-danger">*</span>OTP Status</label>
                        <div class="form-group">
                            <select name="session_otp" id="session_otp" class="form-control selectpicker selectpicker-ui-100">
                                <?php
                                ?>
                                <option value="">Select</option>
                                <option value="1" <?php if ($this->input->post('session_otp') == 1) {
                                                        echo "selected";
                                                    } ?>>Verified</option>
                                <option value="0" <?php if ($this->input->post('session_otp') == "0") {
                                                        echo "selected";
                                                    } ?>>Not-Verified</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Service</label>
                        <div class="form-group">
                            <select class="form-control selectpicker selectpicker-ui-100" name="service_id" id="service_id">
                                <option value="">Select</option>
                                <?php
                                foreach ($serviceData  as $p) {
                                    echo '<option value="' . $p['id'] . '" >' . ucfirst($p['enquiry_purpose_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Payment Type </label>
                        <div class="form-group">
                            <select name="payment_type" id="payment_type" class="form-control selectpicker selectpicker-ui-100">
                                <option value="">Select </option>
                                <option value="paypal">Paypal </option>
                                <option value="email">Email </option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Payment Date </label>
                        <div class="form-group has-feedback">
                            <input type="text" readonly name="session_pdate" value="<?php echo $this->input->post('session_pdate'); ?>" class="form-control date_range input-ui-100" id="session_pdate" />
                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                            <span class="text-danger date_err"><?php echo form_error('date'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="control-label"><span class="text-danger">*</span>Payment Status </label>
                        <div class="form-group">
                            <select name="session_paymentStatus" id="session_paymentStatus" class="form-control selectpicker selectpicker-ui-100">
                                <option value="">Select <?php echo $this->input->post('session_paymentStatus'); ?></option>
                                <?php foreach ($payment_status as $key => $payment_status) {
                                    // $selectp;
                                    if ($payment_status['payment_status'] == $this->input->post('session_paymentStatus')) {
                                        $selectp = "selected";
                                    } else {
                                        $selectp = "";
                                    }
                                ?>
                                    <option value="<?php echo $payment_status['payment_status'] ?>" <?php echo $selectp; ?>>
                                        <?php echo ucfirst($payment_status['payment_status']); ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-danger rd-20" name="search_btn">
                            <i class="fa fa-search"></i> <?php echo SEARCH_LABEL; ?>
                        </button>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <div class="clearfix"></div>
                <div  class="table-ui-scroller">
            <div class="table-responsive table-hr-scroller mheight200" id="printableArea">        
                <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><?php echo SR; ?></th>
                                <th>Student</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Session type</th>
                                <th>Service</th>
                                <th>Booking Date/Time</th>
                                <th>Session Date/Time</th>
                                <th>Message</th>
                                <th>Session Status</th>
                                <th>Payment Status</th>
                                <th>Payment Date</th>
                                <th>Token No</th>
                                <th>Ref.No</th>
                                <th>Payment Gateway ID</th>
                                <th>Payment Method</th>
                                <th>Last Visit Page</th>
                                <th>Has attended?</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            //print_r($counselling_booking_list);
                            if (!empty($counselling_booking_list)) {
                                $sr = 0;
                                foreach ($counselling_booking_list as $sp) {
                                    $zero = 0;
                                    $one = 1;
                                    $pk = 'booking_id';
                                    $table = 'session_booking';
                                    $sr++; ?>
                                    <tr>
                                        <td><?php echo $sr; ?></td>
                                        <td><?php echo $sp['fname'] . ' ' . $sp['lname']; ?></td>
                                        <td><?php echo $sp['country_code'] . ' ' . $sp['mobile']; ?></td>
                                        <td><?php echo $sp['email']; ?></td>
                                        <td><?php echo $sp['session_type']; ?></td>
                                        <td><?php echo $sp['service_name']; ?></td>
                                        <td><?php $tt = date_create($sp['created']);
                                            echo $dt = date_format($tt, 'd-m-Y'); ?></td>
                                        <td><?php echo $sp['booking_date'] . ' ' . $sp['booking_time_slot']; ?></td>
                                        <td><?php echo ucfirst($sp['message']); ?></td>
                                        <td><?php if ($sp['active'] == 1) {
                                                echo "Active";
                                            } else {
                                                echo "De-active";
                                            } ?></td>
                                        <td><?php echo $sp['payment_status']; ?></td>
                                        <td><?php echo $sp['payment_date']; ?></td>
                                        <td><?php echo $sp['checkout_token_no']; ?></td>
                                        <td><?php echo $sp['sessBookingNo']; ?></td>
                                        <td><?php echo $sp['payment_id']; ?></td>
                                        <td><?php echo ucfirst($sp['method']) ?></td>
                                        <td><?php echo ucfirst($sp['page']) ?> Page</td>
                                        <td>
                                            <?php
                                            if ($sp['attended'] == 0) {
                                            ?>
                                                <i class="fa fa-times text-red"></i>
                                            <?php
                                            } else { ?>
                                                <i class="fa fa-check text-green"></i>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#exampleModalshortview<?php echo $sr; ?>">Short View</a>
                                            <a data-toggle="modal" data-target="#exampleModal<?php echo $sr; ?>">Detail View</a>
                                            <div class="modal fade" id="exampleModalshortview<?php echo $sr; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel" style="float: left; font-weight:600">Short Payment Response</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                            $payment_full_response = $sp['response'];
                                                            $json_string = json_decode($payment_full_response, JSON_PRETTY_PRINT);
                                                            if (!empty($json_string['last_payment_error']['message'])) {
                                                                echo $json_string['last_payment_error']['message'];
                                                            } else {
                                                                if ($json_string['status'] != "N") {
                                                                    echo ucwords($json_string['status']);
                                                                } else {
                                                                    $dt = rtrim($payment_full_response, '"');
                                                                    echo ltrim($dt, '"');
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModal<?php echo $sr; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel" style="float: left; font-weight:600">Full Payment Response</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="height:400px; overflow-y:auto">
                                                            <?php
                                                            $payment_full_response = $sp['response'];
                                                            $json_string = json_decode($payment_full_response, JSON_PRETTY_PRINT);
                                                            echo '<pre>';
                                                            print_r($json_string);
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="9">No record found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <div class="pull-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
            </div>
                </div>
        </div>
    </div>
</div>
<!-- modal box for add session starts-->
<div class="modal fade" id="modal-session" style="display: none;">
    <div class="modal-dialog" style="width:1000px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info">Add session status</h4>
                <h5 class="msg_session"></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <label for="session_booking_remarks" class="control-label"><span class="text-danger">*</span>Remarks</label>
                                        <div class="form-group">
                                            <textarea name="session_booking_remarks" class="form-control" id="session_booking_remarks"></textarea>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="is_attended" class="control-label">Has attended?</label>
                                                <input type="checkbox" name="is_attended" id="is_attended" />
                                            </div>
                                        </div>
                                        <input type="hidden" name="session_booking_id" id="session_booking_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">
                        Close
                    </button>
                    <button type="button" class="btn btn-info" id="saveSessionStatus" onclick="saveSessionStatus();">Save Status</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal box for add session ends-->
<?php ob_start(); ?>
<script>
    function UpdatePaymentStatusPay(booking_id) {
        if (confirm("Confirm!") == true) {
            $.ajax({
                url: "<?php echo site_url('adminController/counseling_session/update_session_status_'); ?>",
                async: true,
                type: 'post',
                data: {
                    session_booking_id: booking_id
                },
                success: function(response) {
                    window.location = '<?php echo site_url('adminController/counseling_session/counselling_booking_list'); ?>';
                }
            });
        } else {}
        //$("#session_booking_id").val(booking_id)
    }
</script>