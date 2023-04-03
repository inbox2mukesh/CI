
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                <?php
                   /* if($this->Role_model->_has_access_('student_enquiry','add_new_enquiry')){
                ?>
                <a href="<?php echo site_url('adminController/student_enquiry/add_new_enquiry'); ?>" class="btn btn-warning btn-sm">Add New Enquiry</a><?php } */?>
                <?php
                    if($this->Role_model->_has_access_('student_enquiry','enquiry')){
                ?>
                <a href="<?php echo site_url('adminController/student_enquiry/enquiry'); ?>" class="btn btn-success btn-sm">ALL Enquiry</a> <?php } ?>
                <?php
                    if($this->Role_model->_has_access_('student_enquiry','enquiry_not_replied')){
                ?>
                <a href="<?php echo site_url('adminController/student_enquiry/enquiry_not_replied'); ?>" class="btn btn-danger btn-sm">Un-Touched Enquiry</a><?php } ?>
                                  
                <?php foreach ($all_purpose as $t) { $enquiry_purpose_id=  $t['id'];?>
                    <a href="<?php echo site_url('adminController/student_enquiry/enquiry/'. $enquiry_purpose_id); ?>" class="btn btn-info btn-sm"><?php echo $t['enquiry_purpose_name'];?></a>
                <?php } ?>
                </div>   
            </div>
        
            <div class="box-body">
                <div class="col-md-4 mt-10">         
                    <select name="filter" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="filterEnquiryByDate(this.value)">
                        <option value="">Select Date to filter</option>
                        <?php 
                            foreach($all_enquiryDates as $p){                                  
                                echo '<option value="'.$p['todayDate'].'">'.$p['todayDate'].'</option>';
                            } 
                        ?>
                    </select> 
                </div>
                <a href="<?php echo site_url('adminController/student_enquiry/enquiry'); ?>" class="btn btn-info btn-sm">Refresh</a>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
    
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th> 
                        <th><?php echo ACTION;?></th>
                        <th><?php echo ACTION.'2';?></th>
                        <th>Enquiry No.</th>                       
                        <th>UID</th>                       
						<th>Name</th>
                        <th>DOB</th>
						<th>Email Id</th>
                        <th>Contact No.</th>
                        <th>Verified?</th>					
						
                        <th>Purpose</th>
						<th>Message</th>             
                        <th>Created</th>
                        
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($enquiry as $s){$zero=0;$one=1;$pk='enquiry_id'; $table='students_enquiry';$sr++; 
                        $student_id = $s['student_id'];
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <?php  if($s['isReplied']==0 and $s['is_transfered']==0 ){ 
                           
                            if($this->Role_model->_has_access_('student_enquiry','reply_to_student_enquiry_'))
                            {                            
                        ?> 
                        <td> 
                            <a href="<?php echo site_url('adminController/student_enquiry/reply_to_student_enquiry_/'.base64_encode($s['enquiry_id'])); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Reply">Reply</a>
                            
                        </td>
                         <?php } } elseif( $s['isReplied']==1 and $s['is_transfered']==0){
                            if($this->Role_model->_has_access_('student_enquiry','reply_to_student_enquiry_'))
                            {  
                            ?>
                        <td> 
                            <a href="<?php echo site_url('adminController/student_enquiry/reply_to_student_enquiry_/'.base64_encode($s['enquiry_id'])); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reply">Reply again</a>
                        </td>                           
                            <?php }} ?>
                        <td>
                            <?php 
                                if($this->Role_model->_has_access_('student','edit')){ 
                            ?>
                            <a href="<?php echo site_url('adminController/student/edit/'.base64_encode($student_id)); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Manage Student"><span class="fa fa-user"></span> </a> 
                            <?php }?>                           
                        </td> 
						<td><?php echo  $s['enquiry_no']; ?></td> 
                        <td><?php echo $s['UID']; ?></td>                       
						<td><?php echo $s['fname'].' '.$s['lname']; ?></td>	
                        <td><?php echo $s['dob']; ?></td> 					
						<td>
                            <a href="mailto:<?php echo $s['email'];?>"><?php echo $s['email']; ?></a>
                        </td>
                        <td><?php echo $s['country_code'].'-'.$s['mobile']; ?></td>
                       <td>
                            <?php 


if($s['is_otp_verified']==1){
    echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Verified contact"><span class="fa fa-phone text-success"></span> </a>';
}else{
    echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Un-Verified contact"><span class="fa fa-phone text-danger"></span> </a>';
}

if($s['is_email_verified']==1){
    echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Verified email"><span class="fa fa-envelope text-success"></span> </a>';
}else{
    echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Un-Verified email"><span class="fa fa-envelope text-danger"></span> </a>';
}

                            ?>                                
                        </td>  
                        
                        <td><?php echo $s['enquiry_purpose_name']; ?></td>
						<td><?php echo $s['message']; ?></td>
						<td>
                            <?php 
                            $date=date_create($s['created']);
                            echo $created = date_format($date,"M d, Y");
                            ?>                                
                        </td>					
						
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            </div>           
        
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                   
                </div>                
            </div>
      
     
    </div>
</div>