<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">

            <div class="box-header bg-danger">
                <h3 class="box-title text-primary">Agent Enquiry</h3>
                <div class="box-tools pull-right hide">
                    <a href="<?php echo site_url('adminController/student_enquiry/add_new_enquiry'); ?>" class="btn btn-warning btn-sm">Add New Enquiry</a>
                    <a href="<?php echo site_url('adminController/student_enquiry/enquiry'); ?>" class="btn btn-success btn-sm">ALL Enquiry</a>
                    <a href="<?php echo site_url('adminController/student_enquiry/enquiry_not_replied'); ?>" class="btn btn-danger btn-sm">UN-TOUCHED Enquiry</a>

                    <?php if (isset($_SESSION['date'])) { ?>
                        <a href="<?php echo site_url('adminController/student_enquiry/get_lead_CSV_date'); ?>" class="btn btn-warning btn-sm">Get CSV for <?php echo $_SESSION['date']; ?> </a>
                    <?php } ?>
                    <a href="<?php echo site_url('adminController/student_enquiry/get_lead_CSV'); ?>" class="btn btn-info btn-sm">Get All CSV</a>
                </div>
            </div>

            <div class="box-header hide">
                <div class="box-tools pull-right">
                    <?php foreach ($all_purpose as $t) {
                        $enquiry_purpose_id =  $t['id']; ?>
                        <a href="<?php echo site_url('adminController/student_enquiry/enquiry/' . $enquiry_purpose_id); ?>" class="btn btn-info btn-sm"><?php echo $t['enquiry_purpose_name']; ?></a>
                    <?php } ?>
                </div>
            </div>
            <br />
            <?php /*?>
            <form action="filter_booking" method="POST" onsubmit="return validate_sform();">
            <div class="col-md-12">
                <label for="date" class="control-label"><span class="text-danger">*</span>Filter By Date <?php echo DATE_FORMAT_LABEL_RT;?></label>
                <div class="form-group has-feedback">
                    <input type="text" name="date" value="<?php echo $this->input->post('date'); ?>" class="form-control has-datepicker" id="date" data-date-format="DD-MM-YYYY"/>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('date');?></span>
                </div>
            </div>
            <div class="col-md-12">
               <button type="submit" class="btn btn-danger" >
                    <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                </button>
            </div>
			<?php echo form_close(); 
			*/
            ?>
            <div class="col-md-12 mt-15"><a href="<?php echo site_url('adminController/agent/get_CSV'); ?>" class="btn btn-info btn-sm pull-right rd-20">Get All CSV</a></div>

            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller mt-10">
                <div class="box-body table-responsive table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><?php echo SR; ?></th>
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Contact No.</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Organization Name</th>
                                <th>Message</th>
                                <th>Created</th>
                                <th class="hide"><?php echo ACTION; ?></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $sr = 0;
                            foreach ($enquiry as $s) {
                                $zero = 0;
                                $one = 1;
                                $pk = 'enquiry_id';
                                $table = 'students_enquiry';
                                $sr++;
                                $student_id = $s['student_id'];
                            ?>
                                <tr>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $s['fname'] . ' ' . $s['lname']; ?></td>
                                    <td>
                                        <a href="mailto:<?php echo $s['email']; ?>"><?php echo $s['email']; ?></a>
                                    </td>
                                    <td><?php echo $s['country_code'] . '-' . $s['mobile']; ?></td>
                                    <td><?php echo $s['city']; ?></td>
                                    <td><?php echo $s['country']; ?></td>
                                    <td><?php echo $s['org_name']; ?></td>

                                    <td><?php echo $s['address']; ?></td>
                                    <td>
                                        <?php
                                        $date = date_create($s['created']);
                                        echo $created = date_format($date, "M d, Y");
                                        ?>
                                    </td>
                                    <?php if ($s['isReplied'] == 0 and $s['is_transfered'] == 0) { ?>
                                        <td class="hide">
                                            <a href="<?php echo site_url('adminController/student_enquiry/reply_to_student_enquiry/' . $s['enquiry_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Reply">Reply</a>

                                        </td>
                                    <?php } elseif ($s['isReplied'] == 1 and $s['is_transfered'] == 0) { ?>
                                        <td class="hide">
                                            <a href="<?php echo site_url('adminController/student_enquiry/reply_to_student_enquiry/' . $s['enquiry_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reply">Reply again</a>
                                        </td>
                                    <?php } ?>


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

<script type="text/javascript">
    function validate_sform() {
        //alert('bbbb');
        var date = $("#date");
        if (date.val() == "") {

            $('.date_err').text('Please select date!');
            $('#date_err').focus();
            return false;
        } else {
            $('.date_err').text('');
            return true;
        }
    }
</script>