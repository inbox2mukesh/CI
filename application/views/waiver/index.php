
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                  if($this->Role_model->_has_access_('waiver','add')){
                  ?>
                    <a href="<?php echo site_url('adminController/waiver/add'); ?>" class="btn btn-danger btn-sm">Raise new request</a>  
                    <?php } ?>                                     
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="table-ui-scroller">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Type</th>
                        <th>Waiver for</th>
                        <th>Requested to</th>
                        <th>Request From</th>
                        <th>Ref. By</th>
                        <th>Requested Amount</th>
                        <th>Actual Used Amount</th>
                        <th>Remarks</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th><?php echo STATUS;?></th>
                        <th width="20%"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                     if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                    foreach($waiver as $c){$zero=0;$one=1;$pk='id'; $table='waiver_request';$sr++; ?>                    
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $c['waiver_type']; ?></td>
                        <td><?php echo $c['UID'].' | '.$c['sfname'].' '.$c['slname']; ?></td>  
                        <td><?php echo $c['to_fname'].' '.$c['to_lname'].'-'.$c['to_mobile']; ?></td>
                        <td><?php echo $c['from_fname'].' '.$c['from_lname'].'-'.$c['from_mobile']; ?></td><td><?php echo $c['ref_fname'].' '.$c['ref_lname'].'-'.$c['ref_mobile']; ?></td>
                        <td><?php echo $c['amount']; ?></td>
                        <td><?php echo $c['actually_used_amount']; ?></td>	
                        <td><?php echo $c['remarks']; ?></td>
                        <td><?php echo $c['created']; ?></td>
                        <td>
                            <?php 
                            if($c['active']==1 and $c['approve']==1){
                                echo '<span class="text-success">Active to use</span>';
                            }else if($c['active']==0 and $c['approve']==1){
                                echo '<span class="text-info">can not use</span>';
                            }else if($c['active']==0 and $c['approve']==3){

                                echo '<span class="text-danger">Expired</span>';
                            }else if($c['active']==1 and $c['approve']==0){

                                echo '<span class="text-warning">Pending for approval- Can not use</span>';
                            }
                            else{
                                echo '<span class="text-warning">Pending for approval- Can not use</span>';
                            }
                            ?>                                
                        </td>
                        <td>
                            <?php 
                            if($c['active']==1 and $c['approve']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Active to use">'.ACTIVE.'</a></span>';
                            }else if($c['active']==0 and $c['approve']==1){
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="can not use">'.DEACTIVE.'</a></span>';
                            }else if($c['active']==0 and $c['approve']==3){

                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Expired">'.DEACTIVE.'</a></span>';
                            }else if($c['active']==1 and $c['approve']==0){

                                echo '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                            }
                            else{
                                echo '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <?php 
                                $by_user= $_SESSION['UserId'];
                                if($c['to_id']==$by_user and $c['approve']==0){
                            ?>
                            
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Approve" data-toggle="modal" data-target="#modal-waiver-history1" id="<?php echo $c['wid'];?>" onclick="senddatatomodal(this.id,'<?php echo $c['sid'];?>','A')">Approve</span> </a>

                                <a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Reject" data-toggle="modal" data-target="#modal-waiver-history1" id="<?php echo $c['wid'];?>" onclick="senddatatomodal(this.id,'<?php echo $c['sid'];?>','R')">Reject</span> </a>

                            <?php }elseif($c['to_id']==$by_user and $c['approve']==1 and $c['active']==1){ ?>
                                
                                <a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a>
                                <?php 
                                if($this->Role_model->_has_access_('waiver','disApprove_waiver_')){
                                ?>
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick="disApprove_waiver('<?php echo $c['wid'];?>');">Back to pending</span> </a>
                                <?php }?>                               

                            <?php }elseif($c['to_id']==$by_user and $c['approve']==2 and $c['active']==1){ ?>
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>
                                <?php 
                                if($this->Role_model->_has_access_('waiver','disApprove_waiver_')){
                                ?>
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick="disApprove_waiver('<?php echo $c['wid'];?>');">Back to pending</span> </a>
                            <?php }?>

                            <?php }elseif($c['to_id']!=$by_user and $c['approve']==0){ ?>
                                
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Pending">Pending</span> </a>
                               <?php 
                                if($this->Role_model->_has_access_('waiver','remove')){
                                ?>
                                <a href="<?php echo site_url('adminController/waiver/remove/'.$c['wid']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>
                            <?php }?>

                            <?php }elseif($c['to_id']!=$by_user and $c['approve']==1){ ?>

                                <a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a>
                                <?php 
                                if($this->Role_model->_has_access_('waiver','doExpire_waiver_')){
                                ?>
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Do expire" onclick="doExpire_waiver('<?php echo $c['wid'];?>');">Do expire</span> </a>
                            <?php }?>

                            <?php }elseif($c['to_id']!=$by_user and $c['approve']==2){ ?>
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>

                            <?php }else{ ?> 
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Expired">Expired</span> </a>
                            <?php } ?> 
                        </td>
                    </tr>
                    <?php } ?>
                    
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
            </div>
   
</div>

<!-- modal box for waiver history2 starts-->
        <div class="modal fade" id="modal-waiver-history1" style="display: none;">
          <div class="modal-dialog modal-xlg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                <span aria-hidden="true">×</span></button>
                <h4><b>Previous Waiver History:</b> </h4>
                <h5 class="msg"></h5>
              </div>

              <div class="modal-body">
        
                        <div class="box box-info">            
                           
                            <div class="box-body">
                                <div class="clearfix">
                                </div>
                            </div>
                            
                        </div>
             
              </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">Close</button>
                <?php 
                  if($this->Role_model->_has_access_('waiver','approve_reject_waiver_')){
                  ?>
                <div class="makeBtn"></div>
                <?php }?>                
            </div>

            </div>
          </div>
        </div>
<!-- modal box for waiver history2 ends-->