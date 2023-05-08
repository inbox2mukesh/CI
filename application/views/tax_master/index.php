<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('adminController/tax_master/add'); ?>" class="btn btn-danger btn-sm">Add</a>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th><?php echo SR; ?></th>
                            <th>Tax Name</th>
                            <th>Tax Percentage</th>
                            <th>Created On</th>
                            <th>Modified On</th>
                            <th><?php echo STATUS; ?></th>
                            <th><?php echo ACTION; ?></th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php $sr = 0;
                        foreach ($tax_master as $p) {
                            $zero = 0;
                            $one = 1;
                            $pk = 'id';
                            $table = 'tax_master';
                            $sr++; ?>
                            <tr>
                                <td><?php echo $sr; ?></td>
                                <td><?php echo $p['tax_name']; ?></td>
                                <td><?php echo $p['tax_per']; ?></td>
                                <td><?php
                                    echo changeDateFormat($p['created'], "d-m-Y h:i:s A"); ?>
                                </td>
                                <td><?php
                                    echo changeDateFormat($p['modified'], "d-m-Y h:i:s A"); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($p['active'] == 1) {
                                        echo '<span class="text-success"><a href="javascript:void(0);" id=' . $p['id'] . ' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete(' . $p['id'] . ',' . $zero . ',"' . $table . '","' . $pk . '") >' . ACTIVE . '</a></span>';
                                    } else {
                                        echo '<span class="text-danger"><a href="javascript:void(0);" id=' . $p['id'] . ' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete(' . $p['id'] . ',' . $one . ',"' . $table . '","' . $pk . '") >' . DEACTIVE . '</a></span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('adminController/tax_master/edit/' . $p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>