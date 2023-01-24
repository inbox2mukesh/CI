<section>
    <div class="container">
      <div class="section-title">
        <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0">Reality Test <span class="text-red font-weight-500">  BOOKING</span></h2> </div>
        <?php //echo "<pre>";print_r($GetRtInfo->error_message->data->id);?>
      <div class="form-wrapper">
        <div class="row">
          <div class="col-md-3">
            <div class="info">
              <h4>Preview</h4>
              <?php 
 $p=$GetRtInfo->error_message->data;

           
                $RT_ID=$p->id;
                $package_id=$p->id;
                
                 $title=$p->title;
                $test_module_name=$p->test_module_name;
                $amount=$p->amount;
                $time_slot1=$p->time_slot1;
                $time_slot2=$p->time_slot2;
                $time_slot3=$p->time_slot3;
                
                 $date=date_create($p->date);
                $date = date_format($date,"M d, Y");

                //time
          if($p->time_slot1 and $p->time_slot2 and $p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2.' | '.$p->time_slot3;
          }elseif($p->time_slot1 and $p->time_slot2 and !$p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2;
          }elseif($p->time_slot1 and !$p->time_slot2){
              $t = $p->time_slot1;
          }else{
              $t = $p->time_slot1;
          }

           $venue="In all branches";  
        foreach($p->Info as $ven_list)
        {
          $seats=$ven_list->seats;
          if(!empty($ven_list->venue))
          {
           $venue=$ven_list->venue;
          }

        }
        /*--Branch dropdown show/hide codition-------*/
        if(($p->test_module_name=='PTE' OR $p->test_module_name=='CD-IELTS' ) and $venue=='In all branches')
        {
        $show_branch="";   //"open branch DD";
        $show_status=0;  
        }
        else
        {
        $show_branch='hide'; //"hide branch DD";
        $show_status=1;  
        }
        /*---end-----*/
             
              ?>
              <input type="hidden" value="<?php echo $RT_ID?>" id="rt_id"/>

              <ul>
                <li><span class="text-uppercase">Title:</span>
                  <p class="text-yellow"><?php echo $title;?></p>
                </li>
                <li><span class="text-uppercase">Test:</span>
                  <p class="text-yellow"> <?php echo $test_module_name;?></p>
                </li>
                <li><span class="text-uppercase">Date:</span>
                  <p class="text-yellow"><?php echo $date;?></p>
                </li>
                <li><span class="text-uppercase">Time Slot:</span>
                  <p class="text-yellow tm-slot"> <?php echo $t;?> </p>
                </li>
                <li><span class="text-uppercase">Venue:</span>
                  <p class="text-yellow"><?php echo $venue;?></p>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-box">
              <form action="#" method="post" enctype="multipart/form-data" id="rt_form" class="mt-15 theme-bg">
                     <?php 
   if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
     $readOnly_dis='disabled="disabled" ';
  }else{
    $readOnly=''; 
    $readOnly_dis=""; }?>
    <input type="hidden" name="test_module_name"  id="test_module_name" value="<?php echo $p->test_module_name;?>"/>
                <div class="font-weight-600 font-18 mb-10 text-uppercase clearfix"> Candidate <span class="red-text">Details</span> </div>
                <div class="row">
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> First Name:</label>
                    <input type="text" class="fstinput" name="online_fname" id="rt_fname" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>> 
                    <div class="valid-validation rt_fname_error"><?php echo form_error('fname');?></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class="">Last Name:</label>
                    <input type="text" class="fstinput" name="online_lname" id="rt_lname"  value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>> 
 <div class="valid-validation rt_lname_error"><?php echo form_error('fname');?></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label>Date of Birth<span class="red-text">*</span></label>
                    <div class="has-feedback">
                      <input type="text" readonly autocomplete="off" class="fstinput datepicker"  name="dob" id="rt_dob" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" maxlength="10" autocomplete='off' data-date-format="dd-mm-yyyy" <?php echo $readOnly_dis;?>> <span class="fa fa-calendar form-group-icon"></span>

                       </div>
                       <div class="valid-validation rt_dob_error"></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Country Code:</label>
                    <select class="selectpicker form-control" data-live-search="true" <?php echo $readOnly_dis;?> name="online_country_code" id="rt_country_code">
                     <option value="">Choose Country Code</option>
                         <?php 
                            foreach ($countryCode->error_message->data as $p)
                            {
                              $selected = ($p->country_code == "+91") ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';                             
                            } 
                        ?>
                    </select>
                     <div class="valid-validation rt_country_code_error"><?php echo form_error('country_code');?></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Mobile No.:</label>
                    <input type="text" class="fstinput" name="onlinec_mobile" id="rt_mobile" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>" maxlength="10" <?php echo $readOnly;?>>
                     <div class="valid-validation rt_mobile_error"><?php echo form_error('mobile');?></div>
                   </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Email ID:</label>
                    <input type="email" class="fstinput"  name="online_email" id="rt_email" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" maxlength="60" <?php echo $readOnly;?>>  
 <div class="valid-validation rt_email_erro"><?php echo form_error('email');?></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Interested Country:</label>
                    <select class="selectpicker form-control" data-live-search="true"  name="int_country" id="int_country" >
                      <option value="">Country</option>
                       <?php 
                             foreach ($allDealCnt->error_message->data as $p)
                             {
                                $selected = ($p->country_id == $this->input->post('country_id')) ? ' selected="selected"' : "";
                                echo '<option value="'.$p->country_id.'" '.$selected.'>'.$p->name.'</option>';
                            } 
                        ?>
                    </select>
                    <div class="valid-validation int_country_error"><?php echo form_error('country_id');?></div>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Current Education:</label>
                    <select id="qualification" name="qualification" class="selectpicker form-control">
                      <option value="">Choose Qualification</option>
                      <?php 
                             foreach ($allQua->error_message->data as $p)
                             {
                                $selected = ($p->id == $this->input->post('qualification_id')) ? ' selected="selected"' : "";
                                echo '<option value="'.$p->id.'" '.$selected.'>'.$p->qualification_name.'</option>';
                            } 
                        ?>
                    </select>
                    <div class="valid-validation qualification_error"><?php echo form_error('qualification_id');?></div> 
                  </div>
                </div>
                <?php 
                /*
                docStatus ==1 i.e document is uploaded
                docStatus ==0 i.e document is not uploaded
                */
                if($DOC_STATUS->error_message->docStatus ==0)
                {
                  ?>
                <div class="row">
                  <div class="col-md-12 font-weight-600 font-18 mb-10 text-uppercase clearfix"> ID <span class="red-text">Verification</span> </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label class=""><span class="text-danger">*</span> Document Type:</label>
                    <select class="selectpicker form-control" name="document_type" id="document_type">
                      <option value="">Select Document</option>
                      <?php 
                            foreach ($passport_doc_type->error_message->data as $p)
                            {
                              
                              echo '<option value="'.$p->id.'">'.$p->document_type_name.'</option>';                             
                            } 
                        ?>
                    </select>
                    <div class="valid-validation document_type_error"></div> 
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label for="idProof_front"><span class="text-danger">*</span> Upload Id Proof (Front)</label>
                    <input type="file" class="file-input" id="front" name="front" >
                    <div class="valid-validation front_error"></div>
                    </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label for="idProof_back"> <span class="text-danger">*</span>Upload Id Proof (Back)</label>
                    <input type="file" class="file-input" id="back" name="back">
                    <div class="valid-validation back_error"></div>
                     </div>
                </div>
              <?php }?>
                <div class="lt-blue-bg clearfix mt-10">
                  <div class="font-weight-600 font-18 mb-10 text-uppercase">Book <span class="red-text">For</span></div>
                  <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                      <label class=""><span class="text-danger">*</span>Test Type:</label>
                      <select class="selectpicker form-control <?php if($show_status ==1) { ?>select_test_type<?php }?>" data-live-search="true"  id="select_test_type" name="programe_id" >
                        <option value="">Select</option>
                        <?php 
                             foreach ($allPgm->error_message->data as $p)
                             {
                                $selected = ($p->programe_id == $this->input->post('programe_id')) ? ' selected="selected"' : "";
                                echo '<option value="'.$p->programe_id.'" '.$selected.'>'.$p->programe_name.'</option>';
                            } 
                        ?>
                      </select>
                       <div class="valid-validation select_test_type_error"></div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 <?php echo $show_branch;?>">
                      <label class=""><span class="text-danger">*</span> Branch:</label>
                      <select class="selectpicker form-control" data-live-search="true" id="test_branch" name="center_id">
                        <option value="">Select</option>
                         <?php 
                        foreach ($GetRtBranch->error_message->data as $p)
                        {
                          $selected = ($p->center_id == $this->input->post('center_id')) ? ' selected="selected"' : "";
                          echo '<option value="'.$p->center_id.'" '.$selected.'>'.$p->center_name.'</option>';
                        } 
                      ?>
                      </select>
                      <div class="valid-validation test_branch_error"></div>
                    </div>
                  </div>

                  <div id="timeslotsection"></div>
                                  
                  </div>
                  <div class="text-right mt-20">
                  <a href="javascript:window.history.go(-1);" class="btn btn-black btn-mdl mb-10"> <i class="fa fa-angle-left" aria-hidden="true"></i> Back</a> 
                  <input type="hidden" value="reality test" name="pack_type" id="pack_type" />
                  <input type="hidden" value="<?php echo $package_id?>" id="package_id" name="package_id"/>
                  <input type="hidden" value="<?php echo $DOC_STATUS->error_message->docStatus;?>" id="docStatus" name="docStatus"/>
                 
                  <button type="button" id="checkout_btn<?php echo $package_id; ?>"  onclick="return check_booking(<?php echo $package_id; ?>);" class="btn btn-blue btn-mdl mb-10 ml-10"> Book @ Rs. <?php echo $amount;?></a>
                   </div>
                    <div class="row">
                            <div class="col-md-12">
                              <div class="mt-10" id="regmain_msg_danger<?php echo $package_id; ?>"></div>
                            </div>
                          
                        </div>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<script>    
$(".select_test_type" ).change(function() {
    var rt_id=$('#rt_id').val();
    $.ajax({
        url: "<?php echo site_url('book_reality_test/getTimeslot');?>",
        type: 'post',
        data: {rt_id: rt_id},            
        success: function(response)
        { 
        //alert(response) 
        $('#timeslotsection').html(response)                 
        },
        
  });
});
$("#test_branch" ).change(function() {
    var rt_id=$('#rt_id').val();
      var center_id=$(this).val();
    $.ajax({
        url: "<?php echo site_url('book_reality_test/getTimeslot');?>",
        type: 'post',
        data: {rt_id: rt_id,center_id:center_id},            
        success: function(response)
        { 
      // alert(response)    
        $('#timeslotsection').html(response)            
        },        
  });
});
function check_booking(package_id)
    {
     var document_type="";
     var front="";
     var back="";
      var docStatus = $("#docStatus").val();
      var numberes = /^[0-9-+]+$/;
      var letters = /^[A-Za-z ]+$/;
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
      //var package_id = $("#package_id").val();
      var fname = $("#rt_fname").val();
      var email = $("#rt_email").val();
      var mobile = $("#rt_mobile").val();
      var country_code = $("#rt_country_code").val();
      var dob = $("#rt_dob").val();
      var int_country = $("#int_country").val();
      var qualification = $("#qualification").val();
      if(docStatus == 0)
      {
      var document_type = $("#document_type").val();
      var front = $("#front").val().split('\\').pop();
      var back = $("#back").val().split('\\').pop();
      }
      var select_test_type = $("#select_test_type").val();
      var test_module_name = $("#test_module_name").val();
      var test_branch = $("#test_branch").val();
      var form = document.getElementById('rt_form'); //id of form
      var formdata = new FormData(form);
 
      if(fname.match(letters)){
      $(".rt_fname_error").text('');
      }else{
      $("#rt_fname").focus();
      $(".rt_fname_error").text("Please enter valid Name. Numbers not allowed!");
      return false;
      }

      if(mobile.length>10 || mobile.length<10){
      $("#rt_mobile").focus();
      $(".rt_mobile_error").text('Please enter valid Number of 10 digit');rt_mobile
      return false;
      }else{ 
      $(".rt_mobile_error").text('');
      }

    if(dob == ""){
    $("#rt_dob").focus();
    $(".rt_dob_error").text('Please select dob');
    return false;
    }else{ 
    $(".rt_dob_error").text('');
    }

    if(validate_complaint_email(email)){
    $(".rt_email_error").text('');
    }else{ 
    $("#rt_email").focus();
    $(".rt_email_error").text('Please enter valid Email Id');
    return false;
    }

    if(country_code == ""){
    $("#rt_country_code").focus();
    $(".rt_country_code_error").text('Please select country code');
    return false;
    }else{ 
    $(".rt_country_code_error").text('');
    }

    if(int_country == ""){
    $("#int_country").focus();
    $(".int_country_error").text('Please select interested Country');
    return false;
    }else{ 
    $(".int_country_error").text('');
    }

    if(qualification == ""){
    $("#qualification").focus();
    $(".qualification_error").text('Please select Current Education');
    return false;
    }else{ 
    $(".qualification_error").text('');
    }

    if(docStatus == 0)
    {
     if(document_type == ""){
    $("#document_type").focus();
    $(".document_type_error").text('Please select Document Type');
    return false;
    }else{ 
    $(".document_type_error").text('');
    }

  if(front !="")
   {
    if(validate(front) == 1)
    {
      $(".front_error").text('');
      }else{
      $("#front").val('');
      $("#front").focus();
      $(".front_error").text("File Format not supported!");
      return false;
    }
   }

   if(front =="")
   {
      $("#front").val('');
      $("#front").focus();
      $(".front_error").text("Please Choose Upload Id Proof (Front)");
      return false;
   }

   if(back !="")
   {
    if(validate(back) == 1)
    {
      $(".back_error").text('');
      }else{
      $("#back").val('');
      $("#back").focus();
      $(".back_error").text("File Format not supported!");
      return false;
    }
   }

   if(back =="")
   {
      $("#back").val('');
      $("#back").focus();
      $(".back_error").text("Please Choose Upload Id Proof (Back)");
      return false;
   }

}
    if(select_test_type == ""){
    $("#select_test_type").focus();
    $(".select_test_type_error").text('Please select Test Type');
    return false;
    }else{ 
    $(".select_test_type_error").text('');
    }
   if(test_module_name=='PTE' || test_module_name=='CD-IELTS' )
      {
        if(test_branch == ""){
        $("#test_branch").focus();
        $(".test_branch_error").text('Please select Test Branch');
        return false;
        }else{ 
        $(".test_branch_error").text('');
        }
         if ($('.time_slots:checked').length) 
         {
           // at least one of the radio buttons was checked
           $(".time_slots_error").text('');
          //return true;
          //alert('pp') // allow whatever action would normally happen to continue
          }
          else 
          {
             // no radio button was checked              
              $(".time_slots_error").text('Please choose time slot');
             return false; // stop whatever action would normally happen
          }
      }
      else 
      {
          if ($('.time_slots:checked').length) {
          // at least one of the radio buttons was checked
          $(".time_slots_error").text('');
         // return true; // allow whatever action would normally happen to continue
         
          }
          else {
          // no radio button was checked
          $(".time_slots_error").text('Please choose time slot');
          return false; // stop whatever action would normally happen
          }
         
      }

  
    $.ajax({
        url: "<?php echo site_url('booking/check_booking');?>",
        type: 'post',
        data: formdata,
        processData: false,
        contentType: false,             
        success: function(response){  
        if(response.status=='true')
        {
        $('#onlinecoursemodel'+package_id).modal('hide');
        $('#modal-reg-OTP').modal('show');       
        }
        else if(response.status==2)
        {
        /*window.location.href = "<?php ///echo site_url('booking/checkout');?>"*/
         $('#onlinecoursemodel'+package_id).modal('hide');
         $('#modal-login').modal('show');   
        }
        else if(response.status==3)
        {
        window.location.href = "<?php echo site_url('booking/checkout');?>"          

        }
        else
        {
        $('#checkout_btn'+package_id).prop('disabled', false);
          $('#regmain_msg_danger'+package_id).html(response.msg);
          $(".anc_clickhere").focus();
          }                  
        },
        beforeSend: function(){
           $('#checkout_btn'+package_id).prop('disabled', true);
        }
    });
    }
  function validate(file) {
    //alert(file)
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["jpg" , "jpeg", "png",'pdf'];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
      return -1;
        //$("#image").val("");
    }
  else {
    return 1;
  }
}
function getFilePath(){
     $('input[type=file]').change(function () {
         var filePath=$('#fileUpload').val(); 
     });
}
  </script>