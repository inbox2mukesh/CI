<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('adminController/tax_master/add'); ?>" class="btn btn-danger btn-sm">Add</a>
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
                            <th><?php echo STATUS; ?></th>
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
                            <td><img src="<?php echo BASEURL.VISA_BANNER_IMAGE_PATH.$bannlist['banner_img']; ?>" style="height: 100px;width:100px;"></td>
                            <td><?php echo $bannlist['added_by'];?></td>
                            <td><?php echo $bannlist['added_at'];?></td>
                            <td><?php echo $bannlist['modified_at'];?></td>
                            <td></td>
                            <td>
                                <a href="http://localhost/wosa-online/adminController/free_resources/edit/17" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                                <a href="http://localhost/wosa-online/adminController/free_resources/view_details_/17" class="btn btn-info btn-xs" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span> </a> 
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