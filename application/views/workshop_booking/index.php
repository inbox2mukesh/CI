<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                <?php
                    if($this->Role_model->_has_access_('workshop_booking','index')){
                ?>
                <a href="<?php echo site_url('adminController/workshop_booking/index'); ?>" class="btn btn-success btn-sm">ALL Workshop Booking List</a> <?php } ?>
                </div>   
            </div>
            <div class="box-body">
                <div class="col-md-4 mt-10">         
                    <select name="filter" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="filterWorkshopBookingByDate(this.value)">
                        <option value="">Select Date to filter</option>
                        <?php 
                            foreach($all_enquiryDates as $p){                                  
                                echo '<option value="'.$p['todayDate'].'">'.$p['todayDate'].'</option>';
                            } 
                        ?>
                    </select> 
                </div>
                <a href="<?php echo site_url('adminController/workshop_booking/index'); ?>" class="btn btn-info btn-sm">Refresh</a>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th> 
                        <th>Enquiry No.</th>                       
                        <th>UID</th>                       
						<th>Name</th>
                        <th>DOB</th>
						<th>Email Id</th>
                        <th>Contact No.</th>
                        <th>Course</th>   
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($enquiry as $s){$zero=0;$one=1;$pk='enquiry_id'; $table='students_enquiry';$sr++; 
                        $student_id = $s['student_id'];
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>
						<td><?php echo  $s['enquiry_no']; ?></td> 
                        <td><?php echo $s['UID']; ?></td>                       
						<td><?php echo $s['fname'].' '.$s['lname']; ?></td>	
                        <td><?php echo $s['dob']; ?></td> 					
						<td>
                            <a href="mailto:<?php echo $s['email'];?>"><?php echo $s['email']; ?></a>
                        </td>
                        <td><?php echo $s['country_code'].'-'.$s['mobile']; ?></td>
                        <td><?php echo $s['courseName']; ?></td>
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


<?php ob_start(); ?>

<script>
function filterWorkshopBookingByDate(dateVal) {
    var baseUrl = WOSA_ADMIN_URL + 'workshop_booking/ajax_filterWorkshopBookingByDate/';
	window.location = baseUrl + dateVal;
}
</script>    

<?php global $customJs; ?>
<?php $customJs = ob_get_clean(); ?>