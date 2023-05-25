<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo $title; ?></h3>
			</div>
			<?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open('adminController/tax_master/edit/' . $Tax['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="tax_name" class="control-label"><span class="text-danger">*</span>Tax Name</label>
						<div class="form-group has-feedback">
							<input type="text" name="tax_name" value="<?php echo $Tax['tax_name']; ?>" class="form-control allow_alphabets" id="tax_name" autocomplete="off" ondrop="return false;" onpaste="return false;" />
							<span class="text-danger tax_name_err"><?php echo form_error('tax_name'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="tax_per" class="control-label"><span class="text-danger">*</span>Tax percentage</label>
						<div class="form-group has-feedback">
							<input type="text" name="tax_per" value="<?php echo $Tax['tax_per']; ?>" class="form-control allow_decimal" id="tax_per" maxlength="5" autocomplete="off" ondrop="return false;" onpaste="return false;" onblur="percentage_validation(this);" pattern="^[0-9]+(\.[0-9]+)?$"/>
							<span class="text-danger tax_per_err"><?php echo form_error('tax_per'); ?></span>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="checkbox" name="active" value="1" <?php echo ($Tax['active'] == 1 ? 'checked="checked"' : ''); ?> id='active' />
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-danger">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL; ?>
				</button>
				&nbsp; &nbsp; &nbsp;
				<button type="button" class="btn btn-warning" onclick="return location.replace('<?php echo site_url('adminController/tax_master/index'); ?>');">
					<?php echo CANCEL_LABEL; ?>
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<?php ob_start();?> 
<script>

</script>
<?php global $customJs;
$customJs=ob_get_clean();
?> 
