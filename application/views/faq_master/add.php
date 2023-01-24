<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools pull-right">
              		<?php 
                  if($this->Role_model->_has_access_('faq_master','index')){
                  ?>
              	<a href="<?php echo site_url('adminController/faq_master/index'); ?>" class="btn btn-success btn-sm">ALL FAQ's</a>
              <?php }?>
              	<?php 
              	 if($this->Role_model->_has_access_('faq_master','index')){
              	foreach ($all_testModule as $t) { $test_module_id=  $t['test_module_id'];?>
                  <a href="<?php echo site_url('adminController/faq_master/index/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
              	<?php }} ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/faq_master/add'); ?>
          	<div class="box-body">          		
          		<div class="">				

					<!-- <div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Test module</label>
						<div class="form-group">
							<select name="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select</option>
								<?php 
								foreach($all_test_module as $p){
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option data-subtext="'.$p['programe_name'].'" value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div> -->

					<div class="col-md-12">
						<label for="question" class="control-label"><span class="text-danger">*</span>Question</label>
						<div class="form-group has-feedback">
							<textarea name="question" class="form-control" id="question"><?php echo $this->input->post('question'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('question');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<label for="answer" class="control-label"><span class="text-danger">*</span>Answer</label>
						<div class="form-group has-feedback">
							<textarea name="answer" class="form-control" id="answer"><?php echo $this->input->post('answer'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('answer');?></span>
						</div>
					</div>				
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>