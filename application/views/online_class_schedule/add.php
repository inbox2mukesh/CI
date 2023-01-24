<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools">
              	  <?php 
                  if($this->Role_model->_has_access_('online_class_schedule','index')){
                  ?>
                    <a href="<?php echo site_url('adminController/online_class_schedule/index/'.$classroom_id); ?>" class="btn btn-success btn-sm">ALL Schedules</a> 
                    <?php }?>                   
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php $dup=$this->session->flashdata('flsh_msg_duplicate');?>
<?php
if(isset($dup)){
?>
<div class="col-md-12">
<h5><b>Duplicate schedule found. Please create unique schedule</b></h5>
	<table class="table table-bordered" style="border: 1px solid #f4f4f4">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Dates</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td width="10%" style="background-color:#ffd5cf">Duplicate</td>
      <td><?php 
	 	foreach($dup['duplicate_record'] as $duplicate){ ?>
		<span class="label label-danger"><?php echo $duplicate;?></span>
		<?php } ?>
	  </td> 
    </tr>
	<?php if(!empty($dup['valid_record'])) {?>
	<tr>
      <td  width="10%" style="background-color:#ccffee">Valid</td>
      <td><?php 
	 	foreach($dup['valid_record'] as $valid){ ?>
			<span class="label label-success"><?php echo $valid;?></span>
		<?php } ?>
	 </td> 
    </tr>
	<?php }?>   
  </tbody>
</table>
<br>
</div>
<?php }?>
	
            <?php 
			//$attributes = array('name' => 'schform');
			$attributes = ['name' => 'schform', 'id' => 'schform_add_form'];
			if($classroom_id){ ?>
            	<?php echo form_open('adminController/online_class_schedule/add/'.$classroom_id,$schform); ?>
        	<?php } else{ ?>
 				<?php echo form_open('adminController/online_class_schedule/add',$attributes); ?>
        	<?php } ?>
          	<div class="box-body">
          		<div class="">
          			<?php 
          				if($classroom_id>0){
          					$displayFilterBox='none';
          				}else{
          					$displayFilterBox='block';
          				}
          				$pattern = "/Trainer/i";
						      $isTrainer = preg_match($pattern, $_SESSION['roleName']);
          				if(!$isTrainer){
          			?>
          			<div style="display: <?php echo $displayFilterBox;?>">
          			<div class="col-md-2">
                        <label for="test_module_id" class="control-label">Course</label>
                        <div class="form-group">
                            <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom');loadClassroom();">
                                <option value="">Select Course</option>
                                <?php 
                                foreach($all_test_module as $p){
                                    $selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="classsroomPage" id="classsroomPage" value="classsroomPage">
                    <div class="col-md-3">
                        <label for="programe_id" class="control-label">Program</label>
                        <div class="form-group">
                            <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);loadClassroom();">
                                <option data-subtext="" value="">Select Program</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 catBox">
                        <label for="category_id" class="control-label"> Category</label>
                        <div class="form-group">
                            <select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadClassroom();" >
                                <option value="" disabled="disabled">Select Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="batch_id" class="control-label"> Batch</label>
                        <div class="form-group">
                            <select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
                                <option value="">Select Batch</option>
                                <?php 
                                foreach($all_batches as $b){
                                    $selected = ($b['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>          

                    <div class="col-md-2">
                        <label for="center_id" class="control-label"> Branch</label>
                        <div class="form-group">
                            <select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
                                <option value="">Select Branch</option>
                                <?php 
                                foreach($all_branch as $b){
                                    $selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>				
					</div>
					<?php } ?>

					<?php $classroom_id_post = $this->input->post('classroom_id[]');?>
          				<div class="col-md-4">
						<label for="classroom_id" class="control-label"><span class="text-danger">*</span>Classroom </label>
						<div class="form-group">
							<select name="classroom_id[]" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" id="classroom_id"  multiple="multiple" data-actions-box="true">
								<option value="" disabled="disabled">Select Classroom</option>
								<?php								
								foreach($all_classroom as $p)
								{
									$ck=0;
									if($classroom_id!=0 && $p['id']==$classroom_id)
									{
										$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];
										$selected='';
										if(in_array($p['id'],$classroom_id_post)){
										$selected='selected="selected"';
										}
										if($classroom_id){
										$selected = ($p['id'] == $classroom_id) ? ' selected="selected" ' : "disabled='disabled'";
										}
										echo '<option value="'.$p['id'].'" '.$selected.' data-name="'.$p['classroom_name'].'">'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
									}
									if($classroom_id==0 )
									{
										if($p['active'] !=0)
										{										
										$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];										
										echo '<option value="'.$p['id'].'" data-name="'.$p['classroom_name'].'">'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
										}
									}
										
									}	
								?>
							</select>
							<span class="text-danger classroom_id_err"><?php echo form_error('classroom_id[]');?></span>
						</div>
					</div>          			

					<div class="col-md-4">	
						<label for="dateTime" class="control-label"><span class="text-danger">*</span>Date Time </label>
						<div class="form-group has-feedback">
							<input type="text" name="dateTime" id="dateTime" class="form-control user_activity_report_datetimepicker input-ui-100 removeerrmessage" value="<?php echo $this->input->post('dateTime'); ?>" />
							<span class="text-danger dateTime_err"><?php echo form_error('dateTime');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="till_date" class="control-label">Till Date<?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="till_date" value="<?php echo $this->input->post('till_date'); ?>" class="noBackDatep form-control input-ui-100 removeerrmessage" id="till_date" autocomplete="off" readonly="readonly" maxlength="10"/>
							<span class="text-danger till_date_err"><?php echo form_error('till_date');?></span>
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>					

					<div class="col-md-4">
						<label for="class_duration" class="control-label"><span class="text-danger">*</span>Class Duration(In Minutes)</label>
						<div class="form-group has-feedback">
							<input type="text" name="class_duration" value="<?php echo $this->input->post('class_duration'); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="class_duration" maxlength="3" onblur="validate_duration(this.value,this.id)"/>
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger class_duration_err"><?php echo form_error('class_duration');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="topic" class="control-label"><span class="text-danger">*</span>Class Topic</label>
						<div class="form-group has-feedback">
							<input type="text" name="topic" value="<?php echo $this->input->post('topic'); ?>" class="form-control input-ui-100 removeerrmessage" id="topic" maxlength="50"/>
							<span class="glyphicon glyphicon-book form-control-feedback"></span>
							<span class="text-danger topic_err"><?php echo form_error('topic');?></span>
						</div>
					</div>

					<!-- <div class="col-md-6">
						<label for="trainer_id" class="control-label">Trainer</label>
						<div class="form-group">
							<select id="trainer_id" name="trainer_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Trainer</option>
								<?php 
								foreach($all_trainer as $b){
									$selected = ($b['trainer_id'] == $this->input->post('trainer_id')) ? ' selected="selected"' : "";
									$name = $b['fname'].' '.$b['lname'];
									echo '<option value="'.$b['trainer_id'].'" '.$selected.'>'.$name.'</option>';
								} 
								?>
							</select>
							<span class="text-danger trainer_id_err"><?php echo form_error('trainer_id');?></span>
						</div>
					</div> -->

					<div class="col-md-4">
						<label for="conf_URL" class="control-label">Conf. Link</label>
						<div class="form-group has-feedback">
							<input type="text" name="conf_URL" value="<?php echo $this->input->post('conf_URL'); ?>" class="form-control input-ui-100" id="conf_URL" maxlength="255" onblur="valid_url_classroom();"/>
							<span class="glyphicon glyphicon-link form-control-feedback"></span>
							<span class="text-danger conf_URL_err"><?php echo form_error('conf_URL');?></span>
						</div>
					</div>					
					<?php /*?>		
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" id="active" checked="checked" readonly/>		
							<label for="active" class="control-label">Active</label>					
						</div>
					</div>	
					<?php */?>				
					
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20" onclick="return check_duplicate_sch();">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
				</div>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="duplicate_data_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <b>Duplicate schedule found. Please create unique schedule</b>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tb-border" id="duplicate_data_model_body">
    
      </div>
      
    </div>
  </div>
</div>
<?php ob_start();?> 
<script>

function check_duplicate_sch(){	
	var flag;
	var class_arr = {};
	var classroom = [];
	flag = 1;	
		var classroom_id=$('#classroom_id').val();
		var dateTime=$('#dateTime').val();
		var till_date=$('#till_date').val();
		var class_duration=$('#class_duration').val();
		var topic=$('#topic').val();
		var video_url=$('#video_url').val();
		
		if(classroom_id == "")
		{			
			$(".classroom_id_err").html('The Classroom field is required.');
			flag=0;
		} else { $(".classroom_id_err").html(''); }
		if(dateTime == "")
		{			
			$(".dateTime_err").html('The Date Time field is required.');
			flag=0;
		} else { $(".dateTime_err").html(''); }
		if(till_date == "")
		{			
			$(".till_date_err").html('The Till Time field is required.');
			flag=0;
		} else { $(".till_date_err").html(''); }
		if(class_duration == "")
		{			
			$(".class_duration_err").html('The Class Duration field is required.');
			flag=0;
		} else { $(".class_duration_err").html(''); }
		if(topic == "")
		{			
			$(".topic_err").html('The Topic field is required.');
			flag=0;
		} else { $(".topic_err").html(''); }


	$('#classroom_id option:selected').each(function(){
		var abc1 = {};
		abc1['id'] = $(this).val();
		abc1['name'] = $(this).data("name");
		classroom.push(abc1);
	})
	
	class_arr['classroom_id']	= $('#classroom_id').val();
	class_arr['dateTime']		= $('#dateTime').val();
	class_arr['till_date']		= $('#till_date').val();
	class_arr['class_duration']	= $('#class_duration').val();
	class_arr['classroom']		= classroom;
	var form = document.getElementById('schform'); //id of form
    $.ajax({
        url: "<?php echo site_url('adminController/online_class_schedule/ajax_check_duplicate_sch');?>",
        type: 'post',
		async : false,
       // data: form_data,   
        data: class_arr,      	
        success: function(response)
		{           
			if(response !=1)
			{
				flag = 0;
				$('#duplicate_data_model').modal("show") ;              
				$('#duplicate_data_model_body').html(response);
				return false;
			} 				             
        },
        beforeSend: function(){              
        }
    });
	
	if(flag == 0)
	{
		return false;
	}
	else {
		return true;
	}	
}

	
	const date = new Date();
	let caDate = subtractMinutes(630, date);
 	$(".user_activity_report_datetimepicker").datetimepicker({
        format: 'DD-MM-YYYY HH:mm',
		minDate:caDate
    });

	$('.user_activity_report_datetimepicker').on('dp.change', function(e){ 
		var dt=$(this).val();
		var dtp=dt.split(" ");	
		$(".noBackDatep").val('');	
		$(".noBackDatep").datepicker("destroy");
		$(".noBackDatep").datepicker({					
				startDate:dtp[0],
				autoclose: true,					
			});		
		
	})       
</script>
<?php global $customJs;
$customJs=ob_get_clean();
?> 

