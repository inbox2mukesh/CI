<style type="text/css">
  .bgdiv{background-color: #fff;}
  .bgdiv_rep{ background-color:#9999991c; padding:10px; color:#000;margin-bottom:10px; border-radius:4px; font-size:16px; text-transform:uppercase;}
</style>
<div class="row"> 
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border bg-danger">
              	<h3 class="box-title text-primary"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/student_enquiry/reply_to_student_enquiry_/'.base64_encode($enquiryData['enquiry_id'])); ?>
          	<div class="box-body">
          		<div class="clearfix">
              <div class="col-md-4 bgdiv">
                <label for="admin_reply" class="control-label bold">Enquiry No:</label>
                <div class="form-group has-feedback">
                  <?php echo $enquiryData['enquiry_no']; ?>                  
                </div>
              </div>
              <div class="col-md-4 bgdiv">
                <label for="admin_reply" class="control-label bold">Name</label>
                <div class="form-group has-feedback">
                  <?php echo $enquiryData['fname'].' '.$enquiryData['lname']; ?>                  
                </div>
              </div>

              <div class="col-md-4 bgdiv">
                <label for="admin_reply" class="control-label bold">Email</label>
                <div class="form-group has-feedback">                     
                  <a href="mailto:<?php echo $enquiryData["email"];?>"><?php echo $enquiryData["email"]; ?></a>                              
                </div>
              </div>

              <div class="col-md-4 bgdiv">
                <label for="admin_reply" class="control-label bold">Mobile</label>
                <div class="form-group has-feedback">
                  <?php echo $enquiryData['country_code'].'-'.$enquiryData['mobile']; ?>                  
                </div>
              </div>

              <div class="col-md-4 bgdiv">
                <label for="admin_reply" class="control-label bold">Purpose</label>
                <div class="form-group has-feedback">
                  <?php echo $enquiryData['enquiry_purpose_name']; ?>                  
                </div>
              </div>

              <div class="col-md-12 bgdiv">
                <label for="admin_reply" class="control-label bold">Message/Query from Student</label>
                <div class="form-group has-feedback">
                  <?php echo $enquiryData['message']; ?>                  
                </div>
              </div>

              <div class="col-md-12 bgdiv">
                <label for="admin_reply" class="control-label bold">Enquiry Sent on:</label>
                <div class="form-group has-feedback">
                  <?php                  
                    $date=date_create($enquiryData['created']);
                    echo date_format($date,"M d, Y H:i"); 
                  ?>                  
                </div>
              </div>

              <div class="col-md-12">
                <div class="bgdiv_rep">
                <label for="admin_reply" class="control-label bold">Admin previously replied:</label>
                <?php $c=0; foreach ($preReplies as $pr) { $c++;?>
                  
                <div class="form-group has-feedback">
                  <?php 
                  echo $c.'-'.$pr['admin_reply']; 
                  echo '<br/>';
                  $date=date_create($pr['created']);
                  echo date_format($date,"M d, Y H:i"); 
                  ?>                  
                </div>
              <?php } ?>
              </div>       
              </div>              

    					<div class="col-md-12">
    						<label for="admin_reply" class="control-label">Reply</label>
    						<div class="form-group has-feedback">
    							<textarea name="admin_reply" class="form-control" id="admin_reply"><?php echo $this->input->post('admin_reply'); ?></textarea>
    							<span class="fa fa-commenting form-control-feedback"></span>
    						</div>
    					</div>	

              <div class="col-md-12">
                <label for="note" class="control-label text-primary">Note:</label> <span class="text-info">This reply will be sent on user email mentioned above.</span></label>               
              </div>		

				  </div>
			 </div>
          	<div class="box-footer">
            <div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> Send
            	</button>
          	</div>
            </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>