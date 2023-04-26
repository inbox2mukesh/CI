<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools"> 
                    <?php if(ENVIRONMENT=='development' or ENVIRONMENT=='testing' or ENVIRONMENT=='staging'){ ?>
                        <a href="<?php echo site_url('adminController/ERP_settings/set_erp_softly'); ?>" class="btn btn-danger btn-sm">Init ERP(Softly)</a>
                        <a href="<?php echo site_url('adminController/ERP_settings/set_erp_hardly'); ?>" class="btn btn-danger btn-sm">Init ERP(Hardly)</a>
                        <a href="<?php echo site_url('adminController/role/auto_clean_assigned_role'); ?>" class="btn btn-danger btn-sm link-btn-ui-100">Empty Access Role</a>
                        <a href="<?php echo site_url('adminController/student/clear_all_'); ?>" class="btn btn-danger btn-sm">Clear all Students(Testing purpose)</a>
                        <a href="<?php echo site_url('adminController/user/auto_clean_employee'); ?>" class="btn btn-danger btn-sm">Clean all employee</a>
						 
                    <?php } ?>
                    <?php 
                    if($this->Role_model->_has_access_('sitemap','updateSiteMap')){
                     ?>
                     <a href="<?php echo site_url('adminController/sitemap/updateSiteMap'); ?>" class="btn btn-danger btn-sm">Run Sitemap</a>  
                    <?php }?>              
                </div>
            </div>           
            <div class="box-body">
            <?php echo $this->session->flashdata('flsh_msg'); ?>            
                <div class="col-md-12">
                    <div class="box-body table-responsive table-cb-none mheight200">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>						
                                    <th>Command</th>
                                    <th><?php echo ACTION;?></th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                            <?php 
                                if($this->Role_model->_has_access_('ERP_settings','settings')){
                            ?>                    
                                <tr>						
                                    <td>Start pack by start date</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_startPackByStartDate'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td> 						
                                </tr> 
                                <tr>                        
                                    <td>Deactivate Expired pack</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_DeactivateExpiredPack'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Irrecoverable Due</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_calculateIrrDuesForExpiredPack'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Activate pack that is on hold</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_activatePackWhichIsOnHold_finished'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Start on hold pack</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_startPackOnHold'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Suspend pack after due committment date</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_suspendPackAfterDueCommittmentDate'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>  
                                <tr>                        
                                    <td>Update due committment date</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_updateDueCommittmentDate'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Deactivate Approved Waiver Not Used After Two Days</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_deactivateApprovedWaiverNotUsedAfterTwoDays'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <tr>                        
                                    <td>Deactivate Approved Refund Not Used After Two Days</td>     
                                    <td>
                                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_deactivateApprovedRefundNotUsedAfterTwoDays'); ?>" class="btn btn-success btn-sm">Run Command</a>
                                    </td>                       
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>                
                </div>                             
            </div>
    </div>
    </div>
</div>