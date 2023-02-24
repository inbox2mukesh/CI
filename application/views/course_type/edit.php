<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/course_type/edit/'.$course_type['id']); ?>
			<div class="box-body">
		
					<input type="hidden" name="course_type_id_hidden" id="course_type_id_hidden" value="<?php echo $course_type['id'];?>" >
					<div class="col-md-6">
						<label for="course_timing" class="control-label"><span class="text-danger">*</span>Course Type</label>
						<div class="form-group">
							<input type="text" name="course_timing" value="<?php echo ($this->input->post('course_timing') ? $this->input->post('course_timing') : $course_type['course_timing']); ?>" class="form-control input-ui-100" id="course_timing" maxlength="40" onblur="check_course_type_duplicacy(this.value);"/>
							<span class="text-danger course_name_err"><?php echo form_error('course_timing');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($course_type['active']==1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>					
			
			</div>
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>