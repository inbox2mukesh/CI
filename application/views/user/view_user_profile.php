<div class="user-view_user_profile">
    <div class="row">
        <div class="col-md-12">
            <div class="box clearfix box-flex-widget">
            <div class="box-header bg-danger">
                    <h3 class="box-title text-primary"><?php echo $title;?></h3>
                </div>
                <?php echo $this->session->flashdata('flsh_msg');?>
     
                <div class="col-md-12 table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>Pic</th>
                            <th>Employee Code</th>
                            <th>Role</th>
                            <th>Home Branch</th>
                            <th>Name</th>
                            <th>Desg.</th>
                            <th>Official Email Id</th>
                            <th>Contact no.</th>
                            <th>DOB</th>
                            <th>DOJ</th>
                            <th>Status</th>
                            <th>Portal access</th>
                            <th>Waiver power?</th>
                            <th>Refund power?</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php foreach($user as $u){ $zero=0;$one=1;$pk='id'; $table='user'; ?>
                        <tr>
                            <td>
                                <?php if(isset($u['image'])){ ?>
                                    <img src="<?php echo site_url(EMP_IMAGE_PATH.$u['image']);?>" style="width:50px; height:50px">
                                <?php }else{ ?>
                                    <img src="<?php echo site_url(EMP_IMAGE_PATH.'avatar-300x300-200x200.png');?>" style="width:50px; height:50px">
                                <?php } ?>
                            </td>
                            <td><?php echo $u['employeeCode']; ?></td>
                            <td><?php echo $u['name']; ?></td>
                            <td><?php echo @$u['center_name']; ?></td>
                            <td><?php echo $u['fname'].' '.$u['lname']; ?></td>
                            <td><?php echo $u['designation_name']; ?></td>
                            <td>
                                <a href="mailto:<?php echo $u['email'];?>"><?php echo $u['email']; ?></a>
                            </td>
                            <td><?php echo $u['country_code_offc'].'-'.$u['mobile']; ?></td>
                            <td>
                                <?php
                                //echo $s['dob'];
                                $date=date_create($u['dob']);
                                echo $dob = date_format($date,"M d, Y");
                                ?>
                            </td>
                            <td>
                                <?php
                                //echo $s['dob'];
                                $date=date_create($u['DOJ']);
                                echo $doj = date_format($date,"M d, Y");
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u['portal_access']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$u['id'].'  >'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u['id'].'  >'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u['active']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$u['id'].'  >'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u['id'].'  >'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if($u['waiver_power']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$u['id'].'  >'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u['id'].'  >'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($u['refund_power']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$u['id'].'  >'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$u['id'].'  >'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
                <div class="pagination-right">
                        <?php //echo $this->pagination->create_links(); ?>
                    </div>
                </div>
           
            
            </div>
          
        </div>
    </div>
</div>
