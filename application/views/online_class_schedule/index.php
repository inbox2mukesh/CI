<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                  if($this->Role_model->_has_access_('online_class_schedule','add')){
                  ?>
                    <a href="<?php echo site_url('adminController/online_class_schedule/add/'.$classroom_id); ?>" class="btn btn-danger btn-sm">Add</a>
                <?php }?>
                <?php 
                  if($this->Role_model->_has_access_('online_class_schedule','index')){
                  ?>
                    <a href="<?php echo site_url('adminController/online_class_schedule/index/'.$classroom_id); ?>" class="btn btn-success btn-sm">ALL Schedules</a> 
                    <?php }?>                   
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
           
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Classroom</th>                       					
						<th>DateTime | Day</th>
                        <th>Topic</th>
                        <th>Duration(in Min.)</th>
                        <!-- <th>Trainer</th> -->
                        <th>URL</th>						
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
                        foreach($online_class_schedule as $p){ $zero=0;$one=1;$pk='id'; $table='online_class_schedules';$sr++;
                            
                            if($p['active']==1){ 
                                $rowColor='#B4F8AE';
                            }else{
                                $rowColor='#F8BBAE';
                            }
                    ?>
                    <tr style="background-color: <?php echo $rowColor;?>">
						<td><?php echo $sr; ?></td>	
                        <td><?php echo $p['classroom_name']; ?></td>		
						<td>
                            <?php                                
                                echo $p['dateTime'].' ('.GMT_TIME.')'.' | '.$p['dayname']; 
                            ?>                          
                        </td>						
                        <td><div class="topic"><?php echo $p['topic']; ?></div></td>
                        <td><?php echo $p['class_duration']; ?></td>
                        <!-- <td><?php echo $p['fname'].' '.$p['lname']; ?></td> -->
                        <td>
                            <?php if($p['conf_URL']){ ?>
                            <a href="<?php echo $p['conf_URL']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >Conference Link</a>
                            <?php }else{ echo NA;}?>                       
                        </td>						
                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="De-Active"  >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                         <?php 
                         if($this->Role_model->_has_access_('online_class_schedule','edit') AND $p['active']==1){
                         ?>                            
                            <a href="<?php echo site_url('adminController/online_class_schedule/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                        <?php }?>                          

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
