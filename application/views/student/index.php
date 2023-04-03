    <style type="text/css">
        .liveStd{
            background-color:  #33ff33;
        }
        .offlineStd{
            background-color:  #c2c2a3;
        }
    </style>

<div class="student-index_widget">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header bg-danger">
                    <h3 class="box-title text-primary"><?php echo $title;?></h3>
                    <div class="box-tools">
                    </div>
                    <?php echo $this->session->flashdata('flsh_msg');?>
                </div>
                <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200" id="printableArea">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>                            
                        <tr>
                            <th><?php echo SR;?></th>                            
                            <th><?php echo ACTION;?></th>
                            <th><?php echo STATUS;?></th>
                            <th>Verified?</th>
                            <th>Name</th>
                            <th>Classroom</th>
                            <th>UID</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Branch</th>
                            <!-- <th>Dues <?php echo CURRENCY;?></th> -->
                            <th>Contact no.</th>                            
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                             if(!empty($this->input->get('per_page'))){
                                $sr=$this->input->get('per_page');
                             }else{
                                $sr=0;            
                             }
                             
                            foreach($students as $s){$zero=0;$one=1;$pk='id'; $table='students';$sr++;
                            if($s['loggedIn']==1){
                                $class='liveStd';
                            }else{
                                $class='offlineStd';
                            }
                            $packCount = $s['offlineCount']+$s['onlineCount']+$s['ppCount'];
                            $encId = base64_encode($s['id']);
                        ?>
                        <tr>
                            <td><?php echo $sr;?></td>                            
                            <td class="noPrint">
                                <?php
                                    if($this->Role_model->_has_access_('student','edit')){
                                ?>
                                <a href="<?php echo site_url('adminController/student/edit/'.$encId); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Manage Student"><span class="fa fa-user"></span> </a><?php } ?>
                                <?php
                                    if($this->Role_model->_has_access_('student','student_full_details_')){
                                ?>
                                <a href="<?php echo site_url('adminController/student/student_full_details_/'.$encId); ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Full Details"><span class="fa fa-eye"></span> </a><?php } ?>
                            </td>
                            <td>
                                <?php
                                    if($s['active']==1){
                                        echo '<span class="text-success"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip">'.ACTIVE.'</a></span>';
                                    }else{
                                        echo '<span class="text-danger"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip" >'.DEACTIVE.'</a></span>';
                                    }
                                ?>
                            </td>

                            <td>
                                <?php 
                                    if($s['is_otp_verified']==1){
                                        echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Verified contact"><span class="fa fa-phone text-success"></span> </a>';
                                    }else{
                                        echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Un-Verified contact"><span class="fa fa-phone text-danger"></span> </a>';
                                    }

                                    if($s['is_email_verified']==1){
                                        echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Verified email"><span class="fa fa-envelope text-success"></span> </a>';
                                    }else{
                                        echo '<a href="" class="btn btn-info btn-xs" data-toggle="tooltip" title="Un-Verified email"><span class="fa fa-envelope text-danger"></span> </a>';
                                    }
                                ?>                                    
                            </td>
                            <!-- <td>
                                <img src="<?php echo base_url($s['profile_pic']);?>" style="width:50px;height:40px;">
                            </td> -->
                            <td class="<?php echo $class;?>"><?php echo $s['fname'].' '.$s['lname']; ?></td>
                            <td>
                                <?php
                                    if(@$s['Pack']){
                                        $classname="";
                                        foreach ($s['Pack'] as $p) {
                                            if($p['classroom_name'] !="")
                                            {
                                                $classname .= $p['classroom_name'].', ';
                                            }
                                            
                                        }
                                        echo rtrim($classname,', ');
                                    }else{
                                        echo DEFINE_NIL;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($s['student_identity']!='') {
                                        echo $s['UID'];
                                    }else{
                                        echo $s['UID'];
                                    }
                                ?>
                            </td>
                            <?php
                                if($packCount>0){
                            ?>
                            <td>
                                <?php
                                $test_prog_name="";
                                if(is_array($s['Pack']) && isset($s['Pack']))
                                {
                                    foreach ($s['Pack'] as $p) {
                                        $test_prog_name .= $p['test_module_name'].'-'.$p['programe_name'].', ';
                                    }
                                    $test_prog_name = rtrim($test_prog_name,', ');

                                }
                                echo $test_prog_name;
                                    
                                ?>
                            </td>
                            <td>
                                <?php
                                $batch_name="";
                                    foreach ($s['Pack'] as $p) {
                                        if($p['batch_name'] !="")
                                        {
                                            $batch_name .= $p['batch_name'].', ';
                                        }
                                        
                                    }
                                 echo rtrim($batch_name,', ');
                                ?>
                            </td>

                            <td>
                                <?php
                                $center_name="";
                                    foreach ($s['Pack'] as $p) {
                                         $center_name .= $p['center_name'].', ';
                                    }
                                   echo rtrim($center_name,', ');
                                ?>
                            </td>

                            <?php }else{ $test_prog_name=""; ?>
                            <td>
                                <?php
                                
                                     $test_prog_name .= $s['test_module_name'].'-'.$s['programe_name'];
                                      rtrim($test_prog_name,', ');
                                     echo rtrim($test_prog_name,'-');
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo NA;
                                ?>
                            </td>

                            <td>
                                <?php
                                    echo $s['center_name'];
                                ?>
                            </td>

                            <?php } ?>

                            <!-- <td>
                                <?php
                                    echo number_format($s['amount_due']/100,2);
                                ?>
                            </td> -->
                            <td><?php echo $s['country_code'].'- '.$s['mobile']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                 
                </div>
                <div class="pull-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
                <!--end:table:ui -->
            </div>
        </div>
    </div>
</div>