<div class="student-online_registration_leads">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <?php echo $this->session->flashdata('flsh_msg');?>
            </div>
            <div class="box-body table-responsive" id="printableArea">
                <div class="col-md-12">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Pic</th>
                        <th>Student's Status</th>
						<th>Name</th>
						<th>Email Id</th>
						<th>Contact no.</th>
						<th><?php echo STATUS;?></th>
                        <th class="noPrint"><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                        $sr=0;foreach($students as $s){$zero=0;$one=1;$pk='id'; $table='students';$sr++;
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td>
                            <img src="<?php echo base_url($s['profile_pic']);?>" style="width:50px;height:40px;">
                        </td>

                        <td>
                            <?php
                                if($s['student_identity']!='') {
                                    echo $s['student_identity'].'-'.$s['UID'];
                                }else{
                                    echo $s['UID'];
                                }
                            ?>
                        </td>

						<td class="<?php echo (isset($class) && $class !='') ?$class:'' ;?>"><?php echo $s['fname'].' '.$s['lname']; ?></td>
						<td><a href="mailto:<?php echo $s['email'];?>"><?php echo $s['email']; ?></a></td>
						<td><?php echo $s['country_code'].'- '.$s['mobile']; ?></td>

						<td>
                            <?php
                                if($s['active']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip">'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$s['id'].' data-toggle="tooltip" >'.DEACTIVE.'</a></span>';
                                }
                            ?>
                        </td>
						<td class="noPrint">

                            <a href="<?php echo site_url('adminController/student/edit/'.base64_encode($s['id'])); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>

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
</div>
</div>