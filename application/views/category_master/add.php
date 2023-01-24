<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
               <div class="box-tools pull-right">
               	<?php 
					if($this->Role_model->_has_access_('category_master','index')){
				?>
              	<a href="<?php echo site_url('adminController/category_master/index'); ?>" class="btn btn-success btn-sm">ALL categories</a>    
              	<?php 
              		foreach ($all_testModule as $t) { $test_module_id=  $t['test_module_id'];?>
                        <a href="<?php echo site_url('adminController/category_master/index/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
                <?php } ?>
                <?php } ?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/category_master/add'); ?>
          	<div class="box-body">          		
          		
					<div class="col-md-4">
						<label for="category_name" class="control-label"><span class="text-danger">*</span>Category Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="category_name" value="<?php echo $this->input->post('category_name'); ?>" class="form-control input-ui-100" id="category_name" maxlength="10"/>
							<span class="text-danger"><?php echo form_error('category_name');?></span>	
						</div>
					</div>

					<div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select</option>
								<?php 
								foreach($all_test_module as $p){
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option data-subtext="'.$p['programe_name'].'" value="'.$p['test_module_id'].'" >'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option data-subtext="" value="">Select Program</option>
								<?php 
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>			
					
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
			
			</div>
          	<div class="box-footer">
			  <div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>