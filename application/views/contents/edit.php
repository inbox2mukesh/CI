<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/contents/edit/'.$contents['id']); ?>
			<div class="box-body">
				<div class="row clearfix">	
					
					<div class="col-md-4">
						<label for="title" class="control-label"><span class="text-danger">*</span>Short Code</label>
						<div class="form-group">
							<input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $contents['title']); ?>" class="form-control" id="title" maxlength="10"/>
							<span class="text-danger"><?php echo form_error('title');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="sub_title" class="control-label"><span class="text-danger">*</span>Title</label>
						<div class="form-group">
							<input type="text" name="sub_title" value="<?php echo ($this->input->post('sub_title') ? $this->input->post('sub_title') : $contents['title']); ?>" class="form-control" id="sub_title" maxlength="100"/>
							<span class="text-danger"><?php echo form_error('sub_title');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="tag" class="control-label"><span class="text-danger">*</span>Tag</label>
						<div class="form-group">
							<input type="text" name="tag" value="<?php echo ($this->input->post('tag') ? $this->input->post('tag') : $contents['tag']); ?>" class="form-control" id="tag" maxlength="100"/>
							<span class="text-danger"><?php echo form_error('tag');?></span>
						</div>
					</div>


					<div class="col-md-12">
						<label for="description" class="control-label"> Description</label>
						<div class="form-group has-feedback">
							<textarea name="description" class="form-control myckeditor" id="description"><?php echo ($this->input->post('description') ? $this->input->post('description') : $contents['description']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="active" value="1" <?php echo ($contents['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>