<style>
.has-feedback .form-control { padding-right: 42.5px; position: relative !important; bottom: inherit !important;}
.has-feedback .error { position: absolute;bottom: -23px;}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php 
			$attributes = array('id' => 'edit_pte_marks','name' => 'edit_pte_marks');
			echo form_open('adminController/mock_test/edit_pte_report_/'.$reportRow['id'],$attributes); ?>
			<div class="box-body">
				<div class="row clearfix">

					<div class="col-md-3">
						<label for="Test_Taker_ID" class="control-label"><span class="text-danger">*</span>Test Taker ID</label>
						<div class="form-group has-feedback">
							<input type="text" name="Test_Taker_ID" value="<?php echo ($this->input->post('Test_Taker_ID') ? $this->input->post('Test_Taker_ID') : $reportRow['Test_Taker_ID']); ?>" class="form-control" id="Test_Taker_ID" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Test_Taker_ID');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Registration_ID" class="control-label"><span class="text-danger">*</span>Registration ID</label>
						<div class="form-group has-feedback">
							<input type="text" name="Registration_ID" value="<?php echo ($this->input->post('Registration_ID') ? $this->input->post('Registration_ID') : $reportRow['Registration_ID']); ?>" class="form-control" id="Registration_ID" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Registration_ID');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="Test_Centre_ID" class="control-label"><span class="text-danger">*</span>Test Centre ID</label>
						<div class="form-group has-feedback">
							<input type="text" name="Test_Centre_ID" value="<?php echo ($this->input->post('Test_Centre_ID') ? $this->input->post('Test_Centre_ID') : $reportRow['Test_Centre_ID']); ?>" class="form-control" id="Test_Centre_ID" readonly/>
							<span class="text-danger title_err"><?php echo form_error('Test_Centre_ID');?></span>
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
						<label for="oa" class="control-label"><span class="text-danger">*</span>Overall</label>
						<div class="form-group has-feedback">
							<input type="text" name="oa" value="<?php echo ($this->input->post('oa') ? $this->input->post('oa') : $reportRow['oa']); ?>" class="form-control score" id="oa" />
							<span class="text-danger oa_err"><?php echo form_error('oa');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="listening" class="control-label"><span class="text-danger">*</span>Listening</label>
						<div class="form-group has-feedback">
							<input type="text" name="listening" value="<?php echo ($this->input->post('listening') ? $this->input->post('listening') : $reportRow['listening']); ?>" class="form-control score" id="listening" />
							<span class="text-danger listening_err"><?php echo form_error('listening');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="reading" class="control-label"><span class="text-danger">*</span>Reading</label>
						<div class="form-group has-feedback">
							<input type="text" name="reading" value="<?php echo ($this->input->post('reading') ? $this->input->post('reading') : $reportRow['reading']); ?>" class="form-control score" id="reading" />
							<span class="text-danger reading_err"><?php echo form_error('reading');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="writing" class="control-label"><span class="text-danger">*</span>Writing</label>
						<div class="form-group has-feedback">
							<input type="text" name="writing" value="<?php echo ($this->input->post('writing') ? $this->input->post('writing') : $reportRow['writing']); ?>" class="form-control score" id="writing" />
							<span class="text-danger writing_err"><?php echo form_error('writing');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="speaking" class="control-label"><span class="text-danger">*</span>Speaking</label>
						<div class="form-group has-feedback">
							<input type="text" name="speaking" value="<?php echo ($this->input->post('speaking') ? $this->input->post('speaking') : $reportRow['speaking']); ?>" class="form-control score" />
							<span class="text-danger speaking_err"><?php echo form_error('speaking');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="gr" class="control-label"><span class="text-danger">*</span>Grammar</label>
						<div class="form-group has-feedback">
							<input type="text" name="gr" value="<?php echo ($this->input->post('gr') ? $this->input->post('gr') : $reportRow['gr']); ?>" class="form-control score" id="gr" />
							<span class="text-danger gr_err"><?php echo form_error('gr');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="of" class="control-label"><span class="text-danger">*</span>Oral Fluency</label>
						<div class="form-group has-feedback">
							<input type="text" name="of" value="<?php echo ($this->input->post('of') ? $this->input->post('of') : $reportRow['of']); ?>" class="form-control score" id="of" />
							<span class="text-danger of_err"><?php echo form_error('gr');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="pr" class="control-label"><span class="text-danger">*</span>Pronunciation</label>
						<div class="form-group has-feedback">
							<input type="text" name="pr" value="<?php echo ($this->input->post('pr') ? $this->input->post('pr') : $reportRow['pr']); ?>" class="form-control score" id="pr" />
							<span class="text-danger pr_err"><?php echo form_error('pr');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="sp" class="control-label"><span class="text-danger">*</span>Spelling</label>
						<div class="form-group has-feedback">
							<input type="text" name="sp" value="<?php echo ($this->input->post('sp') ? $this->input->post('sp') : $reportRow['sp']); ?>" class="form-control score" id="sp" />
							<span class="text-danger sp_err"><?php echo form_error('sp');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="vo" class="control-label"><span class="text-danger">*</span>Vocabulary</label>
						<div class="form-group has-feedback">
							<input type="text" name="vo" value="<?php echo ($this->input->post('vo') ? $this->input->post('vo') : $reportRow['vo']); ?>" class="form-control score" id="vo" />
							<span class="text-danger vo_err"><?php echo form_error('vo');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="wd" class="control-label"><span class="text-danger">*</span>Written Discourse </label>
						<div class="form-group has-feedback">
							<input type="text" name="wd" value="<?php echo ($this->input->post('wd') ? $this->input->post('wd') : $reportRow['wd']); ?>" class="form-control score" id="wd" />
							<span class="text-danger wd_err"><?php echo form_error('wd');?></span>
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
<script src="<?php echo site_url(''.DESIGN_VERSION.'/js/jquery-3.6.0.min.js?v='.JS_CSS_VERSION);?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
            $( document ).ready(function() {
                $('.score').keyup(function (e) {
					var inputval = this.value;	
					var self = $(this);
					self.val(self.val().replace(/[^a-zA-Z0-9]/, ""));	
					if(self.val().length >= 3 || self.val() > 90)
					{
						self.val(self.val().replace(inputval, ""));
					}			
      			});
            });

			//form submit validation
			$('#edit_pte_marks').validate({
				ignore:[],
					rules:{
						'oa':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'listening':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'reading':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'writing':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'speaking':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'gr':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'of':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'pr':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'sp':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'vo':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						'wd':{
							required: true,
							// max: 90,
    						lettersallowed : true,
						},
						

				},
				errorPlacement: function(error, element) {
					if  (element.attr("name") == "oa" )
							error.insertAfter(".oa_err");
					if  (element.attr("name") == "listening" )
						error.insertAfter(".listening_err");
					if  (element.attr("name") == "reading" )
						error.insertAfter(".reading_err");
					if  (element.attr("name") == "writing" )
						error.insertAfter(".writing_err");
					if  (element.attr("name") == "speaking" )
						error.insertAfter(".speaking_err");
					if  (element.attr("name") == "gr" )
						error.insertAfter(".gr_err");
					if  (element.attr("name") == "pr" )
						error.insertAfter(".pr_err");
					if  (element.attr("name") == "sp" )
						error.insertAfter(".sp_err");
					if  (element.attr("name") == "of" )
						error.insertAfter(".of_err");
					if  (element.attr("name") == "vo" )
						error.insertAfter(".vo_err");
					if  (element.attr("name") == "wd" )
						error.insertAfter(".wd_err");
					

				},
				messages: {
					oa:'Please Enter valid marks',
					listening:'Please Enter valid marks',
					reading:'Please Enter valid marks',
					writing:'Please Enter valid marks',
					speaking:'Please Enter valid marks',
					gr:'Please Enter valid marks',
					of:'Please Enter valid marks',
					pr:'Please Enter valid marks',
					sp:'Please Enter valid marks',
					vo:'Please Enter valid marks',
					wd:'Please Enter valid marks',

				}

			});
			jQuery.validator.addMethod("lettersallowed", function(value, element) {
				return this.optional(element) || value <= 90 || value == 'NA' || value == 'AB';
			}, "* Amount must be greater than zero");



</script>