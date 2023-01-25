<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
margin-bottom: 5px;
}

.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}
</style>

<div class="user-index">
    <div class="box">
    <div class="box-header bg-danger">
        <h3 class="box-title text-primary"><?php echo $title;?></h3>
                    <div class="box-tools">
                        <?php
                            if($this->Role_model->_has_access_('user','add')){
                        ?>
                        <a href="<?php echo site_url('adminController/user/add'); ?>" class="btn btn-danger btn-sm">Add</a> <?php } ?>                        
                    </div>
                </div>
                <?php echo $this->session->flashdata('flsh_msg');?>
                <div class="table-ui-scroller">
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th><?php echo SR;?></th>
                            <th><?php echo ACTION;?></th>
                            <th>Status</th>
                            <th>P.A.</th>
                            <th>W.P.</th>
                            <th>R.P.</th>
                            <th>Emp Code</th>
                            <th>Pic</th>
                            <th>Name</th>                            
                            <th>Role</th>
                            <th>Home Branch</th>
                            <th>Func. Branch</th>
                            <th>Division</th>
                            <th>Cent. Dept.</th>
                            <th>Decent. Dept.</th>
                            <th>Off. Phone</th>
                            <th>Off. Email</th>
                            <th>Desg.</th>
                            <th>DOB</th>
                            <th>DOJ</th>
                            <th>DOE</th>                                                        
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                            $json = json_decode($user);
                            if(!empty($this->input->get('per_page'))){
                                $sr=$this->input->get('per_page');            
                            }else{ $sr=0;}
                            
                            foreach($json as $u){
                            $zero=0;$one=1;$pk='id'; $table='user';$sr++;
                            $id= $u->id;
                            $encId= base64_encode($u->id);

                            if($_SESSION['UserId']==$u->id){
                                $selfProfileEdit=0;
                            }else{
                                $selfProfileEdit=1;
                            }

                            $roleName = $u->name;
                            $pattern = "/Trainer/i";
                            $isTrainer = preg_match($pattern, $roleName);
                            //echo $u->active;
                        ?>
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>
                                <?php if($selfProfileEdit==1){ ?>

                                <?php 
                                    if($this->Role_model->_has_access_('user','edit')){
                                ?>
                                <a href="<?php echo site_url('adminController/user/edit/'.$encId); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a><?php } ?>

                                <?php 
                                    if($this->Role_model->_has_access_('user','Update_Special_Access_')){
                                ?>
                                <a href="javascript:void(0)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-special-access" name="<?php echo $u->role_id;?>" id="<?php echo $id;?>" title="<?php echo $u->name; ?>" onclick="getUserSpecialAccess(this.id,this.name,this.title)"><span class="fa fa-gavel"></span> </a>
                                <?php }} ?>

                                <?php
                                if($isTrainer){
                                    if($this->Role_model->_has_access_('user','manage_trainer_access_')){ ?>
                                    <a href="<?php echo site_url('adminController/user/manage_trainer_access_/'.$encId); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Trainer access"><span class="fa fa-user"></span> </a>
                                <?php }} ?>

                                <?php 
                                    if($this->Role_model->_has_access_('user','view_user_profile_')){
                                ?>
                                <a href="<?php echo site_url('adminController/user/view_user_profile_/'.$encId); ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-eye"></span> </a><?php } ?>
                            </td>
                            <td>
                                <?php
                                if($u->active==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$id.' data-toggle="tooltip" title="Active" onclick=user_activate_deactivete('.$id.','.$zero.',"'.$table.'","'.$pk.'")>'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u->id.' data-toggle="tooltip" title="In-active" onclick=user_activate_deactivete('.$id.','.$one.',"'.$table.'","'.$pk.'")>'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u->portal_access==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" data-toggle="tooltip" title="Portal access")>'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="No Portal access">'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u->waiver_power==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$id.' data-toggle="tooltip" title="Waiver power">'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u->id.' data-toggle="tooltip" title="No Waiver power">'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u->refund_power==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$id.' data-toggle="tooltip" title="Refund power">'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u->id.' data-toggle="tooltip" title="No Refund power" >'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>
                            <td><?php echo $u->employeeCode; ?></td>
                            <td>
                                <?php if($u->image){ ?>
                                    <img src="<?php echo site_url(EMP_IMAGE_PATH.$u->image);?>" style="width:50px; height:50px">
                                <?php }else{ ?>
                                    <img src="<?php echo site_url(EMP_IMAGE_PATH.'avatar-300x300-200x200.png');?>" style="width:50px; height:50px">
                                <?php } ?>
                            </td>
                            <td><?php echo $u->fname.' '.$u->lname; ?></td>
                            <td class="text-warning"><?php echo $u->name; ?></td>
                            <td class="text-info"><?php echo $u->center_name; ?></td>

                            <td class="text-success">
                            
                                <?php
                                    if(isset($u->Branch)){
                                        foreach ($u->Branch as $b) {
                                            echo $b->center_name.', ';
                                        }
                                    }

                                ?>
                    
                            </td>
                            <td class="text-success">
                                <?php
                                    if(isset($u->Division)){
                                        foreach ($u->Division as $b) {
                                            echo $b->division_name.', ';
                                        }
                                    }
                                ?>
                            </td>
                            <td class="text-success">
                                <?php
                                    if(isset($u->centralised_department)){
                                        foreach ($u->centralised_department as $b) {
                                            echo $b.', ';
                                        }
                                    }
                                ?>
                            </td>
                            <td class="text-success">
                                <?php
                                    if(isset($u->decentralised_department)){
                                    foreach ($u->decentralised_department as $b) {
                                        echo $b.', ';
                                    }}
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($u->mobile!=''){
                                        echo $u->country_code_offc.'-'.$u->mobile;
                                    }else{
                                        echo NILL;
                                    }

                                ?>
                            </td>
                            <td><?php echo $u->email; ?></td>
                            <td class="text-warning"><?php echo $u->designation_name; ?></td>
                            <td>
                                <?php
                                if($u->dob){
                                    $date=date_create($u->dob);
                                    echo $dob = date_format($date,"M d, Y");
                                }else{
                                    echo 'None';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($u->DOJ){
                                    $date=date_create($u->DOJ);
                                    echo $DOJ = date_format($date,"M d, Y");
                                }else{
                                    echo 'None';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($u->DOE){
                                    $date=date_create($u->DOE);
                                    echo $DOE = date_format($date,"M d, Y");
                                }else{
                                    echo 'None';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>

                            </div>

               
            </div>
  

    <!-- modal box for special access starts-->
            <div class="modal fade" id="modal-special-access" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-heading text-info">Special Access Control </h4>
                    <h5 class="spl_acc_response"></h5>
                </div>

                <div class="modal-body clearfix">
                    <input type="hidden" name="user_id_spl_acc" id="user_id_spl_acc">
                    <input type="hidden" name="role_id_hidden" id="role_id_hidden">
                    <input type="hidden" name="portal_access_hidden" id="portal_access_hidden">

                    <div class="col-md-12">
                        <label for="role_id" class="control-label"><span class="text-danger">*</span>Role</label>
                        <div class="form-group ri">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="portal_access" class="control-label">Portal access?</label>
                        <div class="form-group pa">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="waiver_power" class="control-label">Waiver power?</label>
                        <div class="form-group wp">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="waiver_upto" class="control-label">Waiver limit</label>
                        <div class="form-group wut">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="refund_power" class="control-label">Refund power?</label>
                        <div class="form-group rp">
                        </div>
                    </div>

                    <div class="col-md-12 sendMail_pa_class" style="display: none;">
                      
                        <div class="form-group form-checkbox">
                            <input type="checkbox" name="sendMail_pa" id="sendMail_pa" value="1">
                            <label for="sendMail_pa" class="control-label">Send mail?</label>
                            <span class="text-danger sendMail_pa_err"></span>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <div class="col-md-12">
                    <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">Close</button> -->
                    <?php
                        if($this->Role_model->_has_access_('user','Update_Special_Access_')){
                    ?>
                    <button type="button" class="btn btn-danger rd-20" id="Update_Special_Access" onclick="Update_Special_Access();">Save Access</button><?php } ?>
                </div>
                </div>

                </div>
            </div>
            </div>
    <!-- modal box for special access ends-->

</div>

<?php ob_start(); ?>
<script>
//activate/deactivate for all
function user_activate_deactivete(id,active,table,pk){

    var idd = '#'+id;
    $.ajax({

        url: "<?php echo site_url('adminController/user/user_activate_deactivete_');?>",
        async : true,
        type: 'post',
        data: {id: id,active: active,table: table,pk: pk},
        dataType: 'json',
        success: function(response){

            if(response==1){
                window.location.href=window.location.href
            }else{
                $(idd).html('');
            }
        }
    });
}
</script>
<?php global $customJs;
$customJs=ob_get_clean();?>