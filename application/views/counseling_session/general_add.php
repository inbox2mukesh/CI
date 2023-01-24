<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools pull-right">
              	<a href="<?php echo site_url('adminController/faq_master/index'); ?>" class="btn btn-success btn-sm">ALL FAQ's</a>
              	
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open_multipart('adminController/faq_master/add'); ?>
          	<div class="box-body">          		
          		<div class="row clearfix">
					

					

					<div class="col-md-12">
						<label for="question" class="control-label">Question</label>
						<div class="form-group has-feedback">
							<textarea name="question" class="form-control" id="question"><?php echo $this->input->post('question'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('question');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<label for="answer" class="control-label">Answer</label>
						<div class="form-group has-feedback">
							<textarea name="answer" class="form-control" id="answer"><?php echo $this->input->post('answer'); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger"><?php echo form_error('answer');?></span>
						</div>
					</div>				
					
					<div class="col-md-12">
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