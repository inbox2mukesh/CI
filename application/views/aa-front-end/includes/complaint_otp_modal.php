<div class="reg-otp" >
    <div class="modal fade" id="modal-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="reg-modal clearfix"> <span class="cross-btn pull-right text-white hide-btn" data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
                        <div class="reg-otp-info text-center text-white ">
                            <h3>Verification Code</h3>
                            <p class="mb-10 font-12">Verification Code has been sent on your phone/email.</p>

                            <div class="form-group">
                                <div class="subs-group">
                                    <input type="text" class="form-control" name="complaint_otp" id="complaint_otp" maxlength="4" placeholder="Please Enter OTP" style="height:55px;">
                                    <button class="btn btn-red btn-subs"  onclick="return Verify_Complaints_n(this.value);" id="verifyBtn" type="button">Verify</button>			
                                </div>
                                <div class="validation hide"> Wrong OTP!</div>
                            </div>
                            <div class="alert alert-success hide font-12" id="opt_success" role="alert">
                                <div><i class="fa fa-check-circle font-48"></i></div> Verification Code Message Successfully Verified! 
                            </div>
                            <div class="alert alert-danger hide font-12" id="opt_danger" role="alert">

                            </div>

                            <div class="mt-30 hide">
                                <button type="button" class="btn btn-yellow verifyBtn mt-20" onclick="return Verify_Complaints_n(this.value);" id="verifyBtn">Verify</button>  
                            </div>

                        </div>
                        <!--End Login Popup-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function Verify_Complaints_n() {
        var complaint_otp = $("#complaint_otp").val();
        var student_id = $("#comp_student_id").val();
        if (complaint_otp !== '') {
            $(".complaint_otp_err").text('');
        } else {
            $("#complaint_otp").focus();
            $(".complaint_otp_err").text("Please enter otp!");
            return false;
        }
        $.ajax({
            url: "<?php echo site_url('Complaints/verify_student_otp'); ?>",
            type: 'post',
            data: {otp: complaint_otp, student_id: student_id},
            success: function (response) {
                if (response.status == 'true')
                {
                    $('#modal-OTP').modal('hide');
                    $('#modal_complaint_success').modal('show');
                    //modal_complaint_success
//                    $("#complaint_otp").addClass('hide');
//                    $('#opt_success').removeClass('hide');
//                    $('#opt_danger').addClass('hide');
//                    $('#opt_success').html(response.msg);
//                    $('#verifyBtn').addClass('hide');
                } else
                {
                    $("#complaint_otp").val('');
                    $("#complaint_otp").focus();
                    $('#opt_success').addClass('hide');
                    $('#opt_danger').removeClass('hide');
                }
            },
            beforeSend: function () {
                $('.complaintBtnDiv').hide();
                $('.complaintBtnDiv_pro').show();
            }
        });
    }
</script>