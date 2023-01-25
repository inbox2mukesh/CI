<div class="role-index">

        <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <span class="text-info" style="margin-left:5px;"><i><span class="text-red">Note</span>: Before assigning role please refresh role</i></span>
            	<div class="box-tools">
                    <?php
                        if($this->Role_model->_has_access_('role','add')){
                    ?>
                    <a href="<?php echo site_url('adminController/role/add'); ?>" class="btn btn-danger btn-sm">Add Role</a> <?php } ?>
                    <?php if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){?>
                    <!-- <a href="<?php echo site_url('adminController/role/auto_clean_assigned_role'); ?>" class="btn btn-danger btn-sm">Empty Access Role</a> -->
                    <?php }?>
                </div>
                <?php
                    if($this->Role_model->_has_access_('role','run_role')){
                ?>
                <a href="<?php echo site_url('adminController/role/run_role');?>" class="btn btn-warning btn-sm"> <i class="fa fa-refresh text-green"></i> Refresh role </a> <?php } ?>
            </div>
            <div class="col-md-12"> <?php echo $this->session->flashdata('flsh_msg'); ?> </div>
            <div class="table-ui-scroller">
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<!-- <th>ID</th>	 -->
						<th>Role name</th>
                        <th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php 
                     if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                    foreach($roles as $r){$zero=0;$one=1;$pk='id'; $table='roles';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                       <!--  <td><?php echo $r['id']; ?></td> -->
						<td><?php echo $r['name']; ?></td>
                        <td>
                            <?php
                            if($r['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="In-active">'.DEACTIVE.'</a></span>';
                            }
                            ?>
                        </td>
                        <?php if($r['name']!=ADMIN){ ?>
						<td>
                            <?php
                                if($this->Role_model->_has_access_('role','manage_role_')){
                                    if($r['active']==1){
                            ?>
                            <a href="<?php echo site_url('adminController/role/manage_role_/'.$r['id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Manage & assign roles"><span class="fa fa-users"></span> Manage role</a> <?php }} ?>

                            <?php
                                if($this->Role_model->_has_access_('role','edit')){
                            ?>
                            <a href="<?php echo site_url('adminController/role/edit/'.$r['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>

                            <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="tooltip" title="Copy role"><span class="fa fa-copy"></span>Copy role </a>

                            <!-- <a href="<?php echo site_url('adminController/role/remove/'.$r['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->

                        </td><?php } ?>
                    </tr>

                    <?php } ?>
                    </tbody>
                </table>

            </div>
           
            </div>

            <div class="pagination-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>

        </div>

 </div>
