<div class="student-student_trans">
<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title.': '.$studentData['fname'].' '.$studentData['lname'].SEP.$studentData['UID'];?></h3>
                <?php echo $this->session->flashdata('flsh_msg');?>
            </div>          

            <div class="table-ui-scroller">
            <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
						<th>Amount paid</th>
                        <th>Remarks</th>
                        <th>File</th>
                        <th>By</th>
                        <th>Created On</th>
						<th>Last Updated On</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($students_tran as $s){$zero=0;$one=1;$pk='tran_id'; $table='student_transaction_history';$sr++;

                        if($s['type']=='+'){
                            $type = '<b><span class="text-success">+</span></b>';
                        }elseif($s['type']=='-'){
                            $type = '<b><span class="text-danger">-</span></b>';
                        }else{
                            $type = '';
                        }
                        $employee_name = $s['fnameu'].' '.$s['lnameu'];
                        if($employee_name){

                        }else{
                            $employee_name='Self';
                        }
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>
						<td><?php echo $type.' '.$s['amount']; ?></td>
                        <td><?php echo $s['remarks']; ?></td>
                        <td>
                            <?php if (isset($s['file'])) { ?>
                                <a href="<?php echo base_url(PACK_HOLD_FILE_PATH . $s['file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hold application file"><span class="fa fa-file"></span> </a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                                if($this->Role_model->_has_access_('user','view_user_profile_')){
                            ?>
                                <a href="<?php echo base_url('adminController/user/view_user_profile_/'.base64_encode($s['uid']));?>" target="_blank"><?php echo $employee_name; ?></a> <?php }else{ ?>

                                <?php echo $employee_name; ?>
                            <?php } ?>
                        </td>
                        <td><?php echo $s['created']; ?></td>
						<td><?php echo $s['modified']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
             </div>
             <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
           
        </div>
    </div>
</div>
</div>