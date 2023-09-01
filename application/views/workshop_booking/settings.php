<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools pull-right">
                    <?php if ($this->Role_model->_has_access_('workshop_booking', 'index')) { ?>
                        <a href="<?php echo site_url('adminController/workshop_booking/index'); ?>" class="btn btn-success btn-sm">ALL Workshop Booking List</a> <?php } ?>
                </div>
            </div>
            <div class="box-body">
                <?php echo $this->session->flashdata('flsh_msg'); ?>
                <?php echo form_open("adminController/workshop_booking/settings"); ?>
                    <div class="col-md-2 mt-10">
                        <input type="checkbox" id="active" name="active" value="1" <?php echo (isset($active) && $active ? "checked=checked" : ""); ?> /> Acitve
                    </div>
                    <input type="submit" name="submit" class="btn btn-info btn-sm" value="Submit" />
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>