<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
                <div class="box-tools">
                <a href="<?php echo site_url('adminController/mock_test/add'); ?>" class="btn btn-danger btn-sm">Add</a>
                <a href="<?php echo site_url('adminController/mock_test/index'); ?>" class="btn btn-success btn-sm">ALL Mock Tests</a>
                    <?php foreach ($all_testModule as $t) { $test_module_id=  $t['test_module_id'];?>
                        <a href="<?php echo site_url('adminController/mock_test/index/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
                    <?php } ?>
                </div>
            </div>           
            <?php echo form_open('adminController/mock_test/search_mock_test'); ?>
          	<div class="box-body">
          		<div class="row clearfix">

          			<div class="col-md-4">
						<label for="test_module_id" class="control-label">Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'mock_test');">
								<option value="">Select course</option>
								<?php 
								foreach($all_test_module as $p)
								{
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id" class="control-label">Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select program</option>
								<?php 
								foreach($all_programe_masters as $p)
								{
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>	

                    <div class="col-md-4">
                        <label for="center_id" class="control-label"> Branch</label>
                        <div class="form-group">
                            <select name="center_id" id="center_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option value="">Select Branch</option>
                                <?php 
                                foreach($all_branch as $b)
                                {
                                    $selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";

                                    echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
                                } 
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('center_id');?></span>
                        </div>
                    </div>  				

					<div class="col-md-6">
						<label for="from_date" class="control-label"><span class="text-danger">*</span>Date from</label>
						<div class="form-group has-feedback">
							<input type="text" name="from_date" value="<?php echo $this->input->post('from_date'); ?>" class="form-control has-datepicker" id="from_date" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('from_date');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="to_date" class="control-label"><span class="text-danger">*</span>To</label>
						<div class="form-group has-feedback">
							<input type="text" name="to_date" value="<?php echo $this->input->post('to_date'); ?>" class="form-control has-datepicker" id="to_date" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('to_date');?></span>
						</div>
					</div>
					
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
            		<i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary">Results</h3> 
                 <button class="btn btn-default pull-right" onclick="printDiv('printableArea')">
                    <i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button>
            </div>                        
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive" id="printableArea">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Test Module</th>
                        <th>Program</th>
                        <th>Branch</th>				
						<th>Date</th>
						<th>Time</th>
                        <th>Venue</th>
                        <th>Amount</th>						
						<th><?php echo STATUS;?></th>
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                    	$sr=0;
                    	if(!empty($searched_data)){
                    	foreach($searched_data as $p){ $zero=0;$one=1;$pk='id'; $table='real_test_dates';$sr++; 

                            if($p['active']==1){ 
                            	$rowColor='#B4F8AE';
                            }else{
                            	$rowColor='#F8BBAE';
                            }

                            ?>
                    	
                    <tr style="background-color: <?php echo $rowColor;?>">
						<td><?php echo $sr; ?></td>	
                        <td><?php echo $p['test_module_name']; ?></td>
                        <td><?php echo $p['programe_name']; ?></td>
                        <td><?php echo $p['center_name']; ?></td>                     		
						<td>
							<?php 
								$date=date_create($p['date']);
                        		$date2 = date_format($date,"M d, Y");
								echo $date2; 
							?>							
						</td>
						<td><?php echo $p['time_slot1'].' | '.$p['time_slot2'].' | '.$p['time_slot3']; ?></td>
                        <td><?php echo $p['venue']; ?></td>
                        <td><?php echo $p['amount']; ?></td>						
                         <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Active"  >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td class="noPrint">
                            <a href="<?php echo site_url('adminController/mock_test/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                            <a href="<?php echo site_url('adminController/mock_test/remove/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
                </table>
                <div class="pull-right">
                    <?php //echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>
