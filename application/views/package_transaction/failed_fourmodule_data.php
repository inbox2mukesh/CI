<div class="row hide">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Search Practice Pack</h3>
            </div>
           
            <?php echo form_open('adminController/practice_packages/index',array('method'=>'get')); ?>
                <div class="box-body">
                   
                        <?php $searchInput=$this->input->get('search'); ?>

                        <div class="col-md-3">
                            <label for="search" class="control-label">Search</label>
                            <div class="form-group">
                                <input type="text" name="search" class="form-control input-ui-100" value="<?php echo (isset($searchInput) ? $searchInput : ""); ?>">
                            </div>
                        </div>

                        <div class="col-md-3 hide">
                            <label for="country_id" class="control-label">Country</label>
                            <div class="form-group">
                                <?php // pr($all_countries,1) ?>
                                <select id="country_id" name="country_id[]" class="form-control inDis selectpicker ccode selectCountry selectpicker-ui-100" data-live-search="true" data-show-subtext="true" data-actions-box="true" multiple="multiple">
                                    <option data-subtext="" value="" disabled>Select Country</option>
                                    <?php 
                                    foreach($all_countries as $p) {
                                        $selected = "";
                                        if(in_array($p['country_id'],$this->input->get('country_id'))) {
                                            $selected = 'selected=selected';
                                        }
                                        echo '<option  value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 hide">
                            <label for="test_module_id" class="control-label">Course</label>
                            <div class="form-group">
                                <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom_schedule');">
                                    <option value="">Select course</option>
                                    <?php 
                                    foreach($all_test_module as $p)
                                    {
                                        if($test_module_id) {
                                            $selected = ($p['test_module_id'] == $test_module_id) ? ' selected="selected"' : "";
                                        }
                                        else {
                                            $selected = ($p['test_module_id'] == $this->input->get('test_module_id')) ? ' selected="selected"' : "";
                                        }
                                        echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                 
                        <div class="col-md-3 hide">
                            <label for="programe_id" class="control-label">Program</label>
                            <div class="form-group">
                                <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
                                    <option data-subtext="" value="">Select program</option>
                                    <?php 
                                    foreach($all_programe_masters as $p)
                                    {
                                        $selected = ($p['programe_id'] == $this->input->get('programe_id')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php $category_id_post=$this->input->get('category_id[]'); ?>

                        <div class="col-md-3 catBox hide">
                            <label for="category_id" class="control-label">Category</label>
                            <div class="form-group">
                                <select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
                                    <option value="" disabled="disabled">Select Category</option>
                                    <?php 
                                    foreach($all_category as $p){
                                        $selected='';
                                        if(in_array($p['category_id'],$category_id_post)){
                                            $selected='selected="selected"';
                                        }
                                        echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].' | '.$p['programe_name'].' | '.$p['category_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 hide">
                            <label for="duration_type" class="control-label">Duration type</label>
                            <div class="form-group">
                                <select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100">
                                    <option value="">Select</option>
                                    <?php 
                                    foreach($all_duration_type as $p){
                                        $selected = ($p['id'] == $this->input->get('duration_type')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['duration_type'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 hide">
                            <label for="duration" class="control-label">Duration</label>
                            <div class="form-group has-feedback">
                                <input type="text" placeholder="e.g. 30" name="duration" value="<?php echo $this->input->get('duration'); ?>" class="form-control chknum1 input-ui-100" id="duration" maxlength="3"/>
                                <span class="glyphicon glyphicon-time form-control-feedback"></span>
                                <span class="text-danger duration_err"><?php echo form_error('duration');?></span>
                            </div>
                        </div>

                       

                        <div class="col-md-3">
                            <label for="status" class="control-label">Package Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control selectpicker selectpicker-ui-100">
                                    <option value="">Select</option>
                                    <option value="1" <?php echo ($this->input->get('status') == 1 ? "selected=selected" : ""); ?>>Active</option>
                                    <option value="0" <?php echo ($this->input->get('status') == 0  && $this->input->get('status') != Null ? "selected=selected" : ""); ?>>De-active</option>
                                </select>
                            </div>
                        </div>
            
                </div>
                <div class="box-footer">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger rd-20" name="submit" value="search" style="margin-right:5px;">
                        <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                    </button>
                    <a href="<?php echo site_url('adminController/practice_packages/index'); ?>" class="btn btn-reset rd-20"> Reset</a>
                </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title; 
                                                    ?></h3>
                <div class="box-tools">
                <div class="pull-right" style="margin-right: 10px;">
                <?php if($this->Role_model->_has_access_('Package_transaction','get_CSV')){ ?>
                <a href="<?php echo site_url('adminController/Package_transaction/get_CSV');?>" id="csv_down" class="btn btn-info btn-sm">Get All CSV</a>
                <?php }?>
            </div>
                    <!-- 
                    <a href="<?php echo site_url('adminController/package_transaction/index'); ?>" class="btn btn-success btn-sm">ALL transaction list</a> -->
                    <?php /* foreach ($all_testModule as $t) {
                        $test_module_id =  $t['test_module_id']; ?>
                        <a href="<?php echo site_url('adminController/package_transaction/index/' . $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name']; ?></a>
                    <?php } */ ?>
                    <!--  <button class="btn btn-default pull-right" onclick="printDiv('printableArea')">
                        <i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button> -->
                </div>

            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>

            <div  class="table-ui-scroller">
            <div class="table-responsive table-hr-scroller mheight200" id="printableArea">        
                <table class="table table-striped table-bordered table-sm">
                      <thead>
                            <tr>
                                <th><?php echo SR; ?></th>                               
                                <th>Student Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>                             
                                <th>Package Detail</th> 
                                <th>Fourmodule API Call</th>                                                             
                                <th>Fourmodule API Status</th>                                                             
                                <th>Fourmodule API Response</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            if (!empty($this->input->get('per_page'))) {

                                $sr = $this->input->get('per_page');
                            } else {

                                $sr = 0;
                            }
                            foreach ($transaction as $s)
                             {
                                $zero = 0;
                                $one = 1;
                                $pk = 'student_package_id';
                                $table = 'student_package';
                                $sr++;
                               ?>
                                <tr>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $s['fname'] . ' ' . $s['lname'].' ('.$s['UID'].')'; ?></td>
                                    <td><?php echo $s['mobile']; ?></td>
                                    <td><?php echo $s['email']; ?></td>                                   
                                    <td><?php 
                                    $date_st=date_create($s['subscribed_on']);
                                    $date_st=date_format($date_st,"d-m-Y");
                                    $date_end=date_create($s['expired_on']);
                                    $date_end=date_format($date_end,"d-m-Y");
                                    echo $s['test_module_name'].' - '.$s['programe_name'].' - '.$s['package_name'].' - '.$s['package_duration'].' - '.$s['batch_name'].' - Start: '.$date_st.' - Expired: '.$date_end; ?></td>                                  
                                    <td><?php if($s['fourmodule_api_called'] == 1) { echo "Enrollment API";} else if($s['fourmodule_api_called'] == 2){ echo "Re-Enrollment API";} else { echo "Add-program API";}?></td>
                                    <td><?php echo $s['fourmodule_status'];?></td>
                                    <td><?php echo $s['fourmodule_response'];?></td>
                                    <td>
                                    <?php if($this->Role_model->_has_access_('Package_transaction','update_fourmodulestatus')){ ?>    
                                    <button class="btn btn-primary btn-xs" onclick="update_status(<?php echo $s['student_package_id']?>);">Update Status</button>
                                    <input type="hidden" value='<?php echo $s['fourmodule_json']?>' id="json_<?php echo $s['student_package_id']?>"/>
                                <?php }?>
                                  </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <?php //echo $this->pagination->create_links(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function update_status(id)
{
    if (confirm('Confirm to update status')) {
    //alert("ok")
   // return false;
  var jsondata= $('#json_'+id).val();
 
    $.ajax({
    url: WOSA_ADMIN_URL + 'Package_transaction/update_fourmodulestatus',
    async : true,
    type: 'post',
    data: {id: id,jsondata:jsondata},
    success: function(response)
    {
       alert(response)
       // $('#content_viewfollowup').html(response);
    }
    });
    } else {}
}
</script>