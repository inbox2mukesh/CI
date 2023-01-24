<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/mock_test/edit_ielts_report_/'.$reportRow['id']); ?>
			<div class="box-body">
				<div class="row clearfix">

					<div class="col-md-3">
						<label for="Test_Type" class="control-label"><span class="text-danger">*</span>Test Type</label>
						<div class="form-group has-feedback">
							<input type="text" name="Test_Type" value="<?php echo ($this->input->post('Test_Type') ? $this->input->post('Test_Type') : $reportRow['Test_Type']); ?>" class="form-control" id="Test_Type" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Test_Type');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Centre_Number" class="control-label"><span class="text-danger">*</span>Centre Number</label>
						<div class="form-group has-feedback">
							<input type="text" name="Centre_Number" value="<?php echo ($this->input->post('Centre_Number') ? $this->input->post('Centre_Number') : $reportRow['Centre_Number']); ?>" class="form-control" id="Centre_Number" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Centre_Number');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Candidate_Number" class="control-label"><span class="text-danger">*</span>Candidate Number</label>
						<div class="form-group has-feedback">
							<input type="text" name="Candidate_Number" value="<?php echo ($this->input->post('Candidate_Number') ? $this->input->post('Candidate_Number') : $reportRow['Candidate_Number']); ?>" class="form-control" id="Candidate_Number" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Candidate_Number');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Candidate_ID" class="control-label"><span class="text-danger">*</span>Candidate ID</label>
						<div class="form-group has-feedback">
							<input type="text" name="Candidate_ID" value="<?php echo ($this->input->post('Candidate_ID') ? $this->input->post('Candidate_ID') : $reportRow['Candidate_ID']); ?>" class="form-control" id="Candidate_ID" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Candidate_ID');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Date_of_Test" class="control-label"><span class="text-danger">*</span>Date of Test</label>
						<div class="form-group has-feedback">
							<input type="text" name="Date_of_Test" value="<?php echo ($this->input->post('Date_of_Test') ? $this->input->post('Date_of_Test') : $reportRow['Date_of_Test']); ?>" class="form-control" id="Date_of_Test" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Date_of_Test');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Date_of_Report" class="control-label"><span class="text-danger">*</span>Date of Report</label>
						<div class="form-group has-feedback">
							<input type="text" name="Date_of_Report" value="<?php echo ($this->input->post('Date_of_Report') ? $this->input->post('Date_of_Report') : $reportRow['Date_of_Report']); ?>" class="form-control" id="Date_of_Report" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Date_of_Report');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="listening" class="control-label"><span class="text-danger">*</span>Listening</label>
						<div class="form-group has-feedback">
							<input type="text" name="listening" value="<?php echo ($this->input->post('listening') ? $this->input->post('listening') : $reportRow['listening']); ?>" class="form-control" id="listening" onblur="validateMockTestScore(this.value,this.id)"/>
							<span class="text-danger listening_err"><?php echo form_error('listening');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="reading" class="control-label"><span class="text-danger">*</span>Reading</label>
						<div class="form-group has-feedback">
							<input type="text" name="reading" value="<?php echo ($this->input->post('reading') ? $this->input->post('reading') : $reportRow['reading']); ?>" class="form-control" id="reading" onblur="validateMockTestScore(this.value,this.id)"/>
							<span class="text-danger reading_err"><?php echo form_error('reading');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="writing" class="control-label"><span class="text-danger">*</span>Writing</label>
						<div class="form-group has-feedback">
							<input type="text" name="writing" value="<?php echo ($this->input->post('writing') ? $this->input->post('writing') : $reportRow['writing']); ?>" class="form-control" id="writing" onblur="validateMockTestScore(this.value,this.id)"/>
							<span class="text-danger writing_err"><?php echo form_error('writing');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="speaking" class="control-label"><span class="text-danger">*</span>Speaking</label>
						<div class="form-group has-feedback">
							<input type="text" name="speaking" value="<?php echo ($this->input->post('speaking') ? $this->input->post('speaking') : $reportRow['speaking']); ?>" class="form-control" id="speaking" onblur="validateMockTestScore(this.value,this.id)"/>
							<span class="text-danger speaking_err"><?php echo form_error('speaking');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="oa" class="control-label"><span class="text-danger">*</span>Over All</label>
						<div class="form-group has-feedback">
							<input type="text" name="oa" value="<?php echo ($this->input->post('oa') ? $this->input->post('oa') : $reportRow['oa']); ?>" class="form-control" id="oa" onblur="validateMockTestScore(this.value,this.id)"/>
							<span class="text-danger oa_err"><?php echo form_error('oa');?></span>
						</div>
					</div>
					
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-danger sbm">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>