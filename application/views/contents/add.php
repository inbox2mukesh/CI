<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/contents/add'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
					
					<div class="col-md-4">
						<label for="title" class="control-label"><span class="text-danger">*</span>Short Code</label>
						<div class="form-group">
							<input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control" id="title" maxlength="10"/>
							<span class="text-danger"><?php echo form_error('title');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="sub_title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group">
							<input type="text" name="sub_title" value="<?php echo $this->input->post('sub_title'); ?>" class="form-control" id="title" maxlength="100"/>
							<span class="text-danger"><?php echo form_error('sub_title');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="tag" class="control-label"><span class="text-danger">*</span>Tag</label>
						<div class="form-group">
							<input type="text" name="tag" value="<?php echo $this->input->post('tag'); ?>" class="form-control" id="tag" maxlength="100"/>
							<span class="text-danger"><?php echo form_error('tag');?></span>
						</div>
					</div>					
					
					<div class="col-md-12">
						<label for="description" class="control-label"> Description</label>
						<div class="form-group has-feedback">
							<textarea name="description" class="form-control myckeditor" id="description"><?php echo $this->input->post('description'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>