<?php
	$date = date('d-m-Y');
	$todayStr = strtotime($date);
	$yesterday = date('d-m-Y', strtotime($date. ' - 1 days'));
	$yesterdayStr = strtotime($yesterday);
?>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools">
					                   
                </div> 	                       
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/student_attendance/attendance_report'); ?>
          	<div class="box-body">
          		<div class="row clearfix">

          			<div class="col-md-6">
						<label for="UID" class="control-label"> Search by single student</label>
						<div class="form-group">
							<input type="text" name="UID" id="UID" value="<?php echo ($this->input->post('UID') ? $this->input->post('UID') : ''); ?>" class="form-control b1 input-ui-100"  placeholder="Enter Student UID" onblur="attendanceFilterformEligibility(this.id);" />
							<span class="text-danger"><?php echo form_error('UID');?></span>
							</div>
							<span><a style="font-size:12px;color:#ee1c24;text-decoration: underline; margin-top:-10px;position:absolute" href="javascript:void(0)" onclick="resetB2AttendanceFilterForm('b1');">Reset all & enable this</a></span>
						
					</div>

					<div class="col-md-6">
						<label for="byMonth2" class="control-label"> By month</label>
						<div class="form-group">
							<input type="text" name="byMonth2" id="byMonth2" class="form-control b1 input-ui-100" onblur="attendanceFilterformEligibility(this.id);" autocomplete='off' disabled="disabled" />
						</div>						
					</div>															

					<div class="col-md-12" style="margin-bottom:10px;">
						
						<div class="form-group">
							<label class="control-label text-primary">OR</label>
						</div>
					</div>					
					<?php 	
					$classroom_id=$this->input->post('classroom_id');
					?>
          			<div class="col-md-6">
						<label for="classroom_id" class="control-label"><span class="text-danger">*</span>Classroom</label>
						<div class="form-group">
							<select name="classroom_id" class="form-control selectpicker b2 selectpicker-ui-100" data-show-subtext="true" data-live-search="true" id="classroom_id" onchange="attendanceFilterformEligibility(this.id);">
								<option value="">Select Classroom</option>
								<?php								
									foreach($all_classroom as $p){
									$selected='';
									if($p['id']==$classroom_id){
									$selected='selected="selected"';
									}
									$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];
									//$selected='';
									/*if(in_array($p['id'],$classroom_id_post)){
										$selected='selected="selected"';
									}*/
									/*if($classroom_id){
										$selected = ($p['id'] == $classroom_id) ? ' selected="selected"' : "";
									}*/
									
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
									}	
								?>
							</select>
							<span class="text-danger classroom_id_err"><?php echo form_error('classroom_id');?></span>
						</div>
					</div>

					<div class="col-md-6">
<div class="row">
					<div class="col-md-5">
						<label for="byMonth1" class="control-label"> By month</label>
						<div class="form-group">
							<input type="text" name="byMonth1" id="byMonth1"  value="<?php echo ($this->input->post('byMonth1') ? $this->input->post('byMonth1') : ''); ?>" class="form-control b2 input-ui-100" onblur="attendanceFilterformEligibility(this.id);" autocomplete='off' />
						</div>						
					</div>

					<div class="col-md-1 text-center">
						<label class="control-label"> &nbsp;</label>
						<div class="form-group">
							<label class="control-label text-primary"> &nbsp;OR</label>
						</div>
					</div>

					<div class="col-md-6">
						<label for="allPresent1" class="control-label"> All present</label>

						<div class="form-group">
							<select name="allPresent1" id="allPresent1" class="form-control selectpicker b2 selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="attendanceFilterformEligibility(this.id);">
								<option value="">Select Day</option>
								<option value="<?php echo $todayStr;?>" <?php if($this->input->post('allPresent1') == $todayStr){ echo "selected";}?>>Today</option>
								<option value="<?php echo $yesterdayStr;?>" <?php if($this->input->post('allPresent1') == $yesterdayStr){ echo "selected";}?>>Yesterday</option>
							</select>
						</div>						
					</div>
					</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<a style="font-size:12px;color:#ee1c24;text-decoration: underline; margin-top:-10px;position:absolute" href="javascript:void(0)" onclick="resetB2AttendanceFilterForm('b2');">Reset all & enable this</a>
						</div>
					</div>
					<input type="hidden" name="hiddenField" id="hiddenField" value="hiddenField">

				</div>
			</div>
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">
            <div class="box-header bg-danger">
            	<?php $resultCount = count($attendanceData);?>
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <span class="text-success ml-5"><?php echo '| Searched '.$resultCount.' '.'Result(s)';?></span>
            </div>

		
			<div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
						<th>UID</th>
						<th>Name</th>
						
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                        $sr=0;foreach($attendanceData as $sp){$zero=0;$one=1;$pk='id'; $table='students';$sr++;
                   
					?>                     
                    <tr>
						<td><?php echo $sr; ?></td>                        
                        <td><?php echo $sp['UID']; ?></td> 
						<td><?php echo $sp['fname'].' '.$sp['lname']; ?></td>
						
						<td>

							<?php if(@$sp['date']){ ?>
							<a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-Attendance" name="<?php echo $sp['pack_type'];?>" id="<?php echo $sp['id'];?>" title="View Attendance" onclick="getAttendanceHistoryByMonth(this.id,this.name,'<?php echo substr($sp['date'],-7);?>');"><span class="fa fa-eye"></span> &nbsp;View Attendance</a> 

                            <a href="<?php echo site_url('adminController/student_attendance/download_csv_ByMonth_/'.$sp['id'].'/'.$sp['pack_type'].'/'.substr($sp['date'],-7).'/'.$sp['classroom_id']);?>" class="btn btn-warning" data-toggle="tooltip" title="Download CSV"><span class="fa fa-arrow-down"></span></a>

							<?php }else if(@$sp['strDate']){ ?>

								<a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-Attendance" name="<?php echo $sp['pack_type'];?>" id="<?php echo $sp['id'];?>" title="View Attendance" onclick="getAttendanceHistoryByPresenseDay(this.id,this.name,'<?php echo $sp['strDate'];?>');"><span class="fa fa-eye"></span> &nbsp;View Attendance</a> 

	                            <a href="<?php echo site_url('adminController/student_attendance/download_csv_PresenseDay_/'.$sp['id'].'/'.$sp['pack_type'].'/'.$sp['strDate'].'/'.$this->input->post('classroom_id'));?>" class="btn btn-warning" data-toggle="tooltip" title="Download CSV"><span class="fa fa-arrow-down"></span></a>

							<?php }else{ ?>

	                            <a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-Attendance" name="<?php echo $sp['pack_type'];?>" id="<?php echo $sp['id'];?>" title="View Attendance" onclick="getAttendanceHistory(this.id,this.name);"><span class="fa fa-eye"></span> &nbsp;View Attendance</a>

	                            <a href="<?php echo site_url('adminController/student_attendance/download_csv_/'.$sp['id'].'/'.$sp['pack_type'].'/'.$this->input->post('classroom_id'));?>" class="btn btn-warning" data-toggle="tooltip" title="Download CSV"><span class="fa fa-arrow-down"></span></a>

                            <?php } ?>	
                        </td>                    
                    </tr>
                    <?php } ?>
                </tbody>
                </table> 
                             
            </div>
			<div class="pull-right">
                    <?php //echo $this->pagination->create_links(); ?>                    
                </div>
			</div>
        </div>
    </div>
</div>

<!-- modal box for  attendance starts-->
        <div class="modal fade" id="modal-Attendance" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info">Student Attendance Sheet</h4>
                <h5 class="msg_attendance"></h5>
              </div>

              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        
                            <div class="attendance_tran_history"></div>                            
                       
                    </div>
                </div>
              </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            Close
            </button>            
            </div>

            </div>
          </div>
        </div>
<!-- modal box for attendance ends-->

<?php ob_start();?>
<script type="text/javascript">
	$("#byMonth1").datepicker( {
	    format: "mm-yyyy",
	    startView: "months", 
	    minViewMode: "months"
	});
	$("#byMonth2").datepicker( {
	    format: "mm-yyyy",
	    startView: "months", 
	    minViewMode: "months"
	});
</script>
<?php global $customJs; $customJs = ob_get_clean();?>



