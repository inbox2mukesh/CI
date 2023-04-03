<?php //echo phpinfo();?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title.' -'.ENVIRONMENT;?></h3>
               <div class="box-tools"> 
                    
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg');?>   
            <div class="col-md-12"><a href="<?php echo site_url('adminController/user/user_activity_'); ?>" class="text-blue">More Activity log</a></div>  
            <div class="clearfix">               
                   
            <div class="table-ui-scroller">
            <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm"> 
                    <thead>
                    <tr>            
                        <th><?php echo SR;?></th>
                        <th>Activity</th>
                        <th>Desc.</th>
                        <!-- <th>Pack</th> -->
                        <th>Lat/Long</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>IP</th>
                        <th>Proxy?</th>
                        <th>Suspicious?</th>
                        <th>Date/Time</th>
                    </tr>
                    </thead>
                    <tbody id="myTable"> 
                    <?php $sr=0;foreach($UserActivityData as $ua){ $zero=0;$one=1;$pk='activity_id'; $table='user_activity';$sr++; 

                      if($ua['isProxy']==0){
                        $isProxy = 'N';
                      }elseif($ua['isProxy']==1){
                        $isProxy = '<span class="text-danger">Y</span>';
                      }else{
                        $isProxy = NA;
                      }

                      if($ua['isSuspicious']==0){
                        $isSuspicious = 'N';
                      }elseif($ua['isSuspicious']==1){
                        $isSuspicious = '<span class="text-danger">Y</span>';
                      }else{
                        $isSuspicious = NA;
                      }

                      if($ua['description']!=''){
                        $description = $ua['description'];
                      }else{
                        $description = NA;
                      }

                    ?>                   
                    <tr>
                        <td><?php echo $sr;?></td>
                        <td class="text-info"><?php echo $ua['activity_name'];?></td>
                        <td><?php echo $description;?></td>
                        <!-- <td><?php echo $ua['student_package_id'];?></td> -->
                        <td><?php echo $ua['latitude'].','.$ua['longitude'];?></td>
                        <td><?php echo $ua['country'];?></td>
                        <td><?php echo $ua['state'];?></td>
                        <td><?php echo $ua['city'];?></td>
                        <td><?php echo $ua['IP_address'];?></td>
                        <td><?php echo $isProxy;?></td>
                        <td><?php echo $isSuspicious;?></td>
                        <td><?php echo $ua['created'];?></td>
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