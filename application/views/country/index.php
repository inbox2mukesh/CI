<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                    if($this->Role_model->_has_access_('country','add')){
                    ?>
                        <a href="<?php echo site_url('adminController/country/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                    <?php }?> 
                    <?php 
                    if($this->Role_model->_has_access_('country','index')){
                    ?>
                    <a href="<?php echo site_url('adminController/country/index'); ?>" class="btn btn-danger btn-sm">Country List</a>
                    <?php }?>
                    <?php 
                    if($this->Role_model->_has_access_('state','index')){
                    ?>
                    <a href="<?php echo site_url('adminController/state/index'); ?>" class="btn btn-danger btn-sm">State List</a>
                    <?php }?>
                    <?php 
                    if($this->Role_model->_has_access_('city','index')){
                    ?>
                    <a href="<?php echo site_url('adminController/city/index'); ?>" class="btn btn-danger btn-sm">City List</a>
                    <?php }?> 
                </div>                
            </div>
          
            <div class="box-body">
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/country/index',array('method'=>'get')); ?>
                
                <div class="clearfix">
                   
                    <!-- <input type="hidden" name="country_id_fake" value="fake" class="form-control" id="country_id_fake" /> -->
                    <div class="col-md-3 byNameBox">
                        <label for="search" class="control-label">Search</label>
                        <div class="form-group">
                            <input type="text" name="search" value="<?php echo $this->input->get('search'); ?>" class="form-control input-ui-100" id="search" />
                        </div>
                    </div>

                    <div class="col-md-3 advanceBox">
                        <label for="we_deal" class="control-label">We Deal?</label>
                        <div class="form-group">
                            <select name="we_deal" id="we_deal" class="form-control selectpicker selectpicker-ui-100">
                                <option value="">Select option</option>
                                <option value="1" <?php echo ($this->input->get('we_deal') == 1 ? 'selected=selected' : ''); ?> >Yes</option>
                                <option value="0" <?php echo ($this->input->get('we_deal') == 0 && $this->input->get('we_deal') != Null ? 'selected=selected' : ''); ?> >No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 advanceBox">
                        <label for="status" class="control-label">Status</label>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control selectpicker selectpicker-ui-100">
                                <option value="">Select status</option>
                                <option value="1" <?php echo ($this->input->get('status') == 1 ? 'selected=selected' : ''); ?> >Active</option>
                                <option value="0" <?php echo ($this->input->get('status') == 0 && $this->input->get('status') != Null ? 'selected=selected' : ''); ?> >De-Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 submitBtn mt-25">
                        <button type="submit" class="btn btn-danger rd-20" name="submit" value="search">
                            <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                        </button>
                        <a href="<?php echo site_url('adminController/country/index'); ?>" class="btn btn-reset rd-20 ml-5">
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
                        <th>ISO</th>					
						<th>Country name</th>						
						<th>Country code</th>
                        <th>Currency</th>
                        <th>Flag</th>	
                        <th>Phone no. length</th> 
                        <th>We deal?</th>  
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
                                              
                        foreach($country as $p){ 
                            $zero=0;$one=1;$pk='country_id'; $table='country';$sr++; 
                    ?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $p['iso3']; ?></td>
						<td><?php echo $p['name']; ?></td>
						<td><?php echo $p['country_code']; ?></td>
                        <td><?php echo $p['currency_code']; ?></td>
						<td>
                        <?php if($p['flag']){ ?>
                            <img src='<?php echo $p['flag'];?>' style="width:40px;height:30px">
                        <?php }else{ echo NO_ICON;?>
                                 
                        <?php } ?>
                        </td>
                        <td>
                            <?php 
                                if($p['min_phoneNo_limit']==$p['phoneNo_limit']){
                                    echo $p['min_phoneNo_limit'];
                                }else{
                                    echo $p['min_phoneNo_limit'].'-'.$p['phoneNo_limit'];
                                }
                                 
                            ?>
                                
                        </td>
                        <td>
                            <?php 
                                if($p['we_deal?']==1){
                                    echo 'Yes';
                                }else{
                                    echo 'No';
                                }

                            ?>                                
                        </td>
                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['country_id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['country_id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
                        
						<td>
                        <?php 
                            if($this->Role_model->_has_access_('country','edit')){
                        ?>
                            <a href="<?php echo site_url('adminController/country/edit/'.$p['country_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                        <?php }?>
                            <!-- <a href="<?php echo site_url('adminController/country/remove/'.$p['country_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
                        </td>
                    </tr>
                    <?php } ?>
                   
                </tbody>
                </table>

                </div>

                <div class="pull-left mt-15"> 
                        <?php if(isset($total_rows) && $total_rows) { ?>
                        <?php echo "Total Results: ".$total_rows; ?>
                    <?php } ?></div>

                    <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div> 
        
                    </div>

       
                            
            </div>
        </div>
    </div>
</div>
