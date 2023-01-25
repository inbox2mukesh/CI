<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                <?php 
                if($this->Role_model->_has_access_('state','add')){
                ?>  
                    <a href="<?php echo site_url('adminController/state/add'); ?>" class="btn btn-danger btn-sm">Add</a>
                <?php } ?> 
                <?php 
                if($this->Role_model->_has_access_('country','index')){
                ?>   
                    <a href="<?php echo site_url('adminController/country/index'); ?>" class="btn btn-danger btn-sm">Country List</a>
                <?php } ?>
                <?php 
                if($this->Role_model->_has_access_('state','index')){
                ?>       
                    <a href="<?php echo site_url('adminController/state/index'); ?>" class="btn btn-danger btn-sm">State List</a>
                <?php } ?>
                <?php 
                if($this->Role_model->_has_access_('city','index')){
                ?> 
                    <a href="<?php echo site_url('adminController/city/index'); ?>" class="btn btn-danger btn-sm">City List</a>
                <?php } ?> 
                </div>
            </div>
           
            <div class="box-body">
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/state/index',array("method" => "get")); ?>
                <div class="clearfix">
                   
                    <!-- <input type="hidden" name="state_id_fake" value="fake" class="form-control" id="state_id_fake"/> -->
                    <?php $searchValue = $this->input->get("search"); ?>
                    <div class="col-md-3">
                        <label for="search" class="control-label">Search</label>
                        <div class="form-group">
                            <input type="text" name="search" class="form-control input-ui-100" value="<?php echo $searchValue; ?>" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="country_id" class="control-label">Country</label>
                        <div class="form-group">
                            <select name="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                <option value="">Select country</option>
                                <?php 
                                foreach($all_country_list as $p)
                                {   
                                    $selected = ($p['country_id'] == $this->input->get('country_id')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <?php $statusVal = $this->input->get('status'); ?>
                    <div class="col-md-3">
                        <label for="status" class="control-label">Status of state</label>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                <option value="">Select status</option>
                                <option value="1" <?php echo ($statusVal == 1 ? 'selected=selected' : '');?> >Active</option>
                                <option value="0" <?php echo ($statusVal == 0 && $statusVal != Null ? 'selected=selected' : ''); ?> >De-Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 submitBtn mt-25">
                        <button type="submit" class="btn btn-danger rd-20" name="submit" value="search">
                            <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                        </button>
                        <a href="<?php echo site_url('adminController/state/index'); ?>" class="btn btn-reset rd-20">
                            <i class="fa fa-refresh"></i> Reset
                        </a>    
                    </div>            
                </div>
                <?php echo form_close(); ?>
                <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Country</th>
                        <th>State</th>
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
                    foreach($state as $c){$zero=0;$one=1;$pk='state_id'; $table='state';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $c['name']; ?></td>     
                        <td><?php echo $c['state_name']; ?></td> 
                        <td>
                            <?php 
                            if($c['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$c['state_id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$c['state_id'].' data-toggle="tooltip" title="De-Active"  >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <?php 
                            if($this->Role_model->_has_access_('state','edit')){
                            ?> 
                            <a href="<?php echo site_url('adminController/state/edit/'.$c['state_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                           <?php }?>
                            
                        </td>
                    </tr>
                    <?php } ?>
                    
                    </tbody>
                </table>
                </div>

                <div class="pull-left mt-15"> 

                      <?php if(isset($total_rows) && $total_rows) { ?>
                      
                                    <?php echo "Total Results: ".$total_rows; ?>
                                
                    <?php } ?>

                      </div>



                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div> 
                    </div>

                             
            </div>
        </div>
    </div>
</div>