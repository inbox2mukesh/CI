<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open_multipart('adminController/counseling_session/general_edit/'.$generalInfo['id']); ?>
			<div class="box-body">
				<div class="row clearfix">				

					

					<div class="col-md-12">
						<label for="description" class="control-label">Description</label>
						<div class="form-group has-feedback">
							<textarea name="description" class="form-control myckeditor" id="description"><?php echo ($this->input->post('description') ? $this->input->post('description') : $generalInfo['description']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('description');?></span>
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