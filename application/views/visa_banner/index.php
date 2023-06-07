<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('adminController/visa_banner/add'); ?>" class="btn btn-danger btn-sm">Add</a>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th><?php echo SR; ?></th>
                            <th>Banner Image</th>
                            <th>Added By</th>
                            <th>Created On</th>
                            <th>Modified On</th>
                            <!-- <th><?php echo STATUS; ?></th> -->
                            <th><?php echo ACTION; ?></th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php 
                        $sr=0;
                        foreach($banner as $bannlist)
                        { ?>
                            <tr>
                            <td><?php echo ++$sr; ?></td>
                            <td><img src="<?php echo base_url(VISA_BANNER_IMAGE_PATH.$bannlist['banner_img']); ?>" style="height: 100px;width:100px;"></td>
                            <td><?php echo $bannlist['username'];?></td>
                            <td><?php echo $bannlist['added_at'];?></td>
                            <td><?php echo $bannlist['modified_at'];?></td>
                            <!-- <td></td> -->
                            <td>
                            <?php if($this->Role_model->_has_access_('video','remove')){?>
                                <a href="<?php echo site_url('adminController/visa_banner/remove/'.$bannlist['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a><?php } ?>
                            </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                <div class="pull-right">
                    <?php //echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>