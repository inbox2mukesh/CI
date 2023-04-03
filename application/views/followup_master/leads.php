<style>
    dd {
    
    margin-bottom: 5px;
}

</style>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>              
            </div>
       
                <form action="<?php echo base_url()?>adminController/lead_management/all_Leads" method="POST" >
                <div class="clearfix" style="padding:5px;">

                    <div class="col-md-3">
                    <label for="date" class="control-label">Search</label>
                    <div class="form-group has-feedback">
                    <input type="text" class="form-control input-ui-100" id="search_text" name="search_text"/>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <label for="date" class="control-label">Created By</label>
                    <div class="form-group">
                     <select name="by_user" id="by_user" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
                        <option value="" >select</option>
                        <?php                             
                        foreach ($alluser  as $p)
                        {                                
                        echo '<option value="'.$p['id'].'" >'.ucfirst($p['fname']).' '.ucfirst($p['lname']).' ('.$p['employeeCode'].')'.'</option>';
                        } 
                        ?>  
                        
                        </select>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <label for="date" class="control-label">Created On</label>
                    <div class="form-group has-feedback">
                    <input type="text" readonly name="leadCreateddate" value="<?php echo $this->input->post('leadCreateddate'); ?>" class="form-control date_range input-ui-100" id="leadCreateddate" />
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('leadCreateddate');?></span>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <label for="date" class="control-label">Created via</label>
                    <div class="form-group " >
                     <select name="lead_via" id="lead_via" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
                        <option value="" >select</option>
                        <option value="manual" >Manual</option>
                        <option value="web enquiry" >Web enquiry</option>
                        <option value="CRS tool" >CRS Tool</option>
                        <option value="counseling session" >Counseling session</option>
                        
                        </select>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <label for="date" class="control-label">Lead Status</label>
                    <div class="form-group">
                     <select name="active" id="active" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
                        <option value="" >select</option>
                        <option value="1" >Active</option>
                        <option value="2" >Hold</option>
                        <option value="3" >Closed</option> 
                        <option value="4" >Dropped</option>              
                        
                        </select>
                    </div>
                    </div>

                    <div class="col-md-3">
                <label for="date" class="control-label">Last Followup</label>
                <div class="form-group has-feedback">
                   <input type="text" readonly name="last_followupdate" value="<?php echo $this->input->post('last_followupdate'); ?>" class="form-control date_range input-ui-100" id="last_followupdate" />
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('last_followupdate');?></span>
                </div>
            </div>

            <div class="col-md-3">
                    <label for="date" class="control-label">Followup Status</label>
                    <div class="form-group">
                     <select name="option_followup_status" id="option_followup_status" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
                       <option value="">Select</option>
            <?php                             
            foreach ($followup_status  as $p)
            {                                
            echo '<option value="'.$p['id'].'" >'.ucfirst($p['title']).'</option>';
            } 
            ?>             
                        
                        </select>

                    </div>
                    </div>

                    <div class="col-md-3">
                <label for="date" class="control-label">Next Followup</label>
                <div class="form-group has-feedback">
                   <input type="text" readonly name="nxt_followupdate" value="<?php echo $this->input->post('nxt_followupdate'); ?>" class="form-control date_range input-ui-100" id="nxt_followupdate" />
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('session_datew');?></span>
                </div>
            </div>

            
             
            <div class="col-md-3">
            <label for="date" class="control-label">Service</label>
            <div class="form-group">
            <select class="selectpicker form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  name="enquiry_purpose_id" id="enquiry_purpose_id"  >
            <option value="">Select</option>
            <?php                             
            foreach ($all_purpose  as $p)
            {                                
            echo '<option value="'.$p['id'].'" >'.ucfirst($p['enquiry_purpose_name']).'</option>';
            } 
            ?>
            </select>
            </div>
            </div>
            
            
        
<div class="col-md-12">
 
               <button type="submit" class="btn btn-danger rd-20" name="search_btn" >
                  <?php echo SEARCH_LABEL;?>
                </button>

                <button type="reset" class="btn btn-reset rd-20 ml-5"  name="search_btn" >
                   Reset
                </button>
                
            </div>
                </div>
            
            <?php echo form_close(); ?>
           
            
     

  

          <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" style="padding:0px;">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                    <th><?php echo SR;?></th>  
                    <th>Lead Status</th>    
                    <th>UID</th>       
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Email Id</th>
                    <th>Lead Via</th>
                     <th>Created By</th>  
                    <th>Lead Created</th>
                    <th>Service</th>
                    <th>Last Followup</th>
                    <th>Followup Status</th>
                     <th>Followup Remark</th>
                    <th>Next Followup</th>
                    
                     						
                    <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                    if(!empty($allleads))
                    {
                    $sr=0;foreach($allleads as $s){$zero=0;$one=1;$pk='lead_id'; $table='leads';$sr++; 
                        //$student_id = $s['student_id'];
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>   
                        <td> 
                            <?php if($this->Role_model->_has_access_('lead_management','edit_lead_')){?>
                            <a href="<?php echo site_url('adminController/lead_management/edit_lead_/'.$s['lead_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Lead"  ><i class="fa fa-pencil"></i></a>
                            <?php }?>
                            <?php if($this->Role_model->_has_access_('lead_management','get_lead_detail_')){?>
                              <a href="javascript:void(0)" class="btn btn-success btn-xs" data-toggle="tooltip" title="New Followup" onclick="get_lead_detail('<?php echo $s['lead_id'];?>')"><i class="fa fa-cog"></i></a>
                              <?php }?>
                              <?php if($this->Role_model->_has_access_('lead_management','view_followup_')){?>
                              <a  class="btn btn-primary btn-xs" data-toggle="tooltip" onclick="view_followup('<?php echo $s['lead_id'];?>')" title="View Followup"><i class="fa fa-file"></i></a>
                              <?php }?>
                        </td>
                        <td><?php echo $s['lead_uid']; ?></td>                    
						<td><?php echo ucfirst($s['fname'].' '.$s['lname']); ?></td>
                        <td><?php echo $s['country_code'].'-'.$s['mobile']; ?></td>	
                        <td>
                            <a href="mailto:<?php echo $s['email'];?>"><?php echo $s['email']; ?></a>
                        </td>
                        <td><?php echo ucfirst($s['lead_via']); ?></td>  
                        <td><?php if($s['createdByName'] !="") {echo $s['createdByName'];} else { echo "auto";} ?></td>        
                        <td><?php echo $s['todayDate']; ?></td>
                        <td><?php echo $s['enquiry_purpose_name']; ?></td> 
                        <td><?php
                        if($s['last_followupdatetime'] == "" OR $s['last_followupdatetime'] == "0000-00-00 00:00:00")
                        {
                            echo "N/A";
                        }
                        else {
                            $dtw=date_create($s['last_followupdatetime']);
                         echo date_format($dtw,"d-m-Y H:i:s");
                        }
                         
                          ?></td> 
                        <td><?php
                        if($s['followup_status'] == "")
                        {
                            echo "N/A";
                        } 
                        else
                        {
                            foreach($followup_status as $followup_statusn)
                            {
                                if($followup_statusn['id']==$s['followup_status'] )
                                {
                                    echo $followup_statusn['title'];
                                }

                            }
                        }
                       
                       //
                       
                         ?></td>
                         <td><?php echo $s['followup_remark']; ?></td> 
                        <td><?php 
                         if($s['next_followupdatetime'] == "" OR $s['next_followupdatetime'] == "0000-00-00 00:00:00")
                        {
                            echo "N/A";
                        }
                        else {
                            $dt=date_create($s['next_followupdatetime']);
                        echo date_format($dt,"d-m-Y H:i:s");
                        }
                        
                         ?></td> 
                        <td><?php if($s['active'] == 1){ echo "Active";} else if($s['active'] == 2) { echo "Hold";}  else if($s['active'] == 3) { echo "Closed";} ?></td>     	
						  
                        
                    </tr>
                    <?php } } else {?>
                    <tr><td colspan="14">No record</td></tr>
                    <?php }?>
                </tbody>
                </table>
                        
            </div>

            <div class="pull-right mt-15">
                    <?php echo $this->pagination->create_links(); ?>               
                </div>    

            <div class="clearfix mt-15 pull-left">
            Total: <?php echo $total_rows; ?>
            <?php echo $this->session->flashdata('flsh_msg');
            ?>

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
                <h4 class="modal-heading text-info">Manage Lead</h4>
                <h5 class="" id="msg_lead"></h5>
              </div>
             <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">      
                            <div class="box-body">
                                <div class="row clearfix">
                                <div class="col-md-6">
                                <label for="session_booking_remarks" class="control-label"><span class="text-danger">*</span>Lead Status </label>
                                <div class="form-group">
                                <select name="lead_status" id="lead_status" class="form-control" onchange="option_check(this.value)">
                                <option value="" >Select </option>
                                <option value="1">Active </option>
                                 <option value="2">Hold </option>
                                  <option value="3">Closed </option>
                                   <option value="4" >Dropped</option> 
                                </select>
                                </div>
                                </div>

                                 <div class="col-md-6" id="followup_status_div">
                                <label for="session_booking_remarks" class="control-label">Followup Status </label>
                                <div class="form-group">
                                <select name="followup_status" id="followup_status" class="form-control">
                                <option value="" >Select </option>
 <?php foreach($followup_status as $key=>$val){
                           
          
                            ?>
                        <option value="<?php echo $val['id']?>"><?php echo $val['title']?></option>
                        <?php 
                        }?> 
                                </select>
                                <span class="text-danger" id="followstatus"></span>
                                </div>
                                </div>

                                    <div class="col-md-12" id="followup_remark_div">
                                        <label for="session_booking_remarks" class="control-label">Remarks</label>
                                        <div class="form-group">
                                        <textarea name="followup_remark" class="form-control" id="followup_remark"></textarea>
                                        </div>
                                     </div>
                                              
                                     <div class="col-md-3" id="next_followupdatetime_div">
                                        <div class="form-group"> 
                                         <label for="is_attended" class="control-label">Next Followup DateTime?</label>
                                          <input type="text" class="form-control has-datepicker" id="next_followupdatetime" name="next_followupdatetime"  id="next_followupdatetime" />
                                        </div>
                                     </div>
                                    <input type="hidden" name="hid_leadId" id="hid_leadId">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">Close</button>
            <span id="plzwait"></span>
                <button type="button" class="btn btn-info" id="update_followup" onclick="update_followup();">Save Status</button>
            </div>
            </div>
          </div>
        </div>
    </div>

<!-- modal box for add session ends-->

<!-- modal box for add session starts-->

        <div class="modal fade" id="modal_viewfollowup" style="display: none;">
          <div class="modal-dialog " >
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info">Remarks</h4>
                <h5 class="" id="msg_lead"></h5>
              </div>
             <div class="modal-body" id="content_viewfollowup" style="    max-height: 400px;
    overflow: auto;">
                
            </div>
          </div>
        </div>
    </div>

<!-- modal box for add session ends-->

<script type="text/javascript">
    
    function validate_sform(){
        //alert('bbbb');
        var date = $("#date");        
        if(date.val() == "") {
            
            $('.date_err').text('Please select date!');
            $('#date_err').focus();
            return false;
        }else{            
            $('.date_err').text('');
            return true;             
        } 
    }
</script>