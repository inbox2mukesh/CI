<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open_multipart('adminController/faq_master/edit/'.$faq_master['id']); ?>
			<div class="box-body">
				<div class="">				

					<!-- <div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Test module</label>
						<div class="form-group">
							<select name="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select </option>
								<?php 
								foreach($all_test_module as $t){
									$selected = ($t['test_module_id'] == $faq_master['test_module_id']) ? ' selected="selected"' : "";
									echo '<option data-subtext="'.$t['test_module_name'].'" value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div> -->

					<div class="col-md-12">
						<label for="question" class="control-label"><span class="text-danger">*</span>Question</label>
						<div class="form-group has-feedback">
							<textarea name="question" class="form-control" id="question"><?php echo ($this->input->post('question') ? $this->input->post('question') : $faq_master['question']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('question');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<label for="answer" class="control-label"><span class="text-danger">*</span>Answer</label>
						<div class="form-group has-feedback">
							<textarea name="answer" class="form-control" id="answer"><?php echo ($this->input->post('answer') ? $this->input->post('answer') : $faq_master['answer']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('answer');?></span>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($faq_master['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
				</div>	
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>