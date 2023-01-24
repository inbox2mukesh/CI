<div class="modal-change-password">
    <div class="modal fade" id="modal-changeprofilepic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
            <h4 class="modal-title text-uppercase">Update Profile Photo</h4> </div>
          <div class="modal-body pd-20">
          <form method="post" id="upload_image_form" enctype="multipart/form-data">
          <div class="alert alert-danger hide font-12" id="fail_pass_update_msg" role="alert"></div>
          <div class="alert alert-success hide font-12" id="success_pass_update_msg" role="alert"></div>
              <div class="form-row clearfix">
                <div class="form-group col-md-12">
                  <label>Upload Image<span class="red-text">*</span>  <?php echo PROFILE_PIC_ALLOWED_TYPES_LABEL;?></label>
                
                  <input type="file" class="fstinput"  id="update_pp" name="update_pp"  onchange="validate_file_type_PJW(this.id)">
                  <div class="text-green update_pp_success"></div>
                  <div class="validation update_pp_err"><?php echo form_error('cp');?></div>
                </div>
                <div class="col-md-12 text-right">                
              
                  <button type="submit" class="btn btn-blue btn-mdl">UPDATE</button>
              
              </div>
          </div>
          <?php echo form_close(); ?>
          </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    
    $(document).ready(function () {
      $('#upload_image_form').on('submit', function (e) {
               
                e.preventDefault();
                if ($('#update_pp').val() == '') {
                 // $("#update_pp").focus();
                  $(".update_pp_err").text("Please Choose Image");
                  return false;
                    
                    document.getElementById("upload_image_form").reset();
                } else {
                  
                    $.ajax({
                        url: "<?php echo site_url('our_students/ajax_changeprofilepic');?>",
                        method: "POST",
                        data: new FormData(this),
                        processData:false,
                        contentType:false,
                        cache:false,
                         async:false,
                        success: function (res) {
                                                        
                           if (res == 1) {                               
                                $('.update_pp_success').html("Successfully update profile");
                                $('.update_pp_err').html("");                              
                            } else{
                              $('.update_pp_success').html("");
                              $('.update_pp_err').html("Oh! Your profile pic failed to update.Try again");
                            }
                            setTimeout(function () {
                               window.location.href = "<?php echo site_url('our_students/student_dashboard');?>";
                            }, 4000);
                           
                        }
                    });
                }
            });
    });

function submit_changeprofilepic()
{
    var update_pp = $("#update_pp").val();
   
    if(update_pp!=''){
      $(".update_pp_err").text('');
    }else{
      //$("#update_pp").focus();
      $(".update_pp_err").text("Please Choose Image");
      return false;
    }


    // $.ajax({
    //     url: "<?php echo site_url('our_students/ajax_changeprofilepic');?>",
    //     type: 'post',
    //     data:  {cp: cp,np:np,cnp:cnp},        
    //     success: function(response)
    //     { 
    //       if(response.status=='true')
    //       {
    //          $('#success_pass_update_msg').removeClass('hide');
    //          $('#success_pass_update_msg').html(response.msg);
    //         $('#fail_pass_update_msg').addClass('hide'); 
    //         setTimeout(function() {
    //    window.location.href = "<?php echo site_url('our_students/student_dashboard');?>"
    //   }, 1500);
    //       }
    //       else
    //       {
    //       $("#cp").val('');
    //       $("#np").val('');
    //       $("#cnp").val('');
    //       $("#cp").focus();
    //       $('#success_pass_update_msg').addClass('hide');
    //       $('#fail_pass_update_msg').removeClass('hide'); 
    //       $('#fail_pass_update_msg').html(response.msg);  
    //       } 
    //     },
    //     beforeSend: function(){
    //       $('#btn-complain').hide();
    //       $('.complaintBtnDiv_pro').show(); 
    //       $('.mainForm').show();     
    //     }
    // });
  }
  </script>