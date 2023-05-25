<div class="row practice_packages">
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
                        <div class="col-md-3">
                            <label for="test_module_id" class="control-label">Course</label>
                            <div class="form-group">
                                <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom_schedule');">
                                    <option value="">Select course</option>
                                    <?php 
                                    if(!empty($all_test_module)){
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
                                }
                                    ?>
                                </select>
                            </div>
                        </div>
                 
                        <div class="col-md-3">
                            <label for="programe_id" class="control-label">Program</label>
                            <div class="form-group">
                                <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
                                    <option data-subtext="" value="">Select program</option>
                                    <?php 
                                    if(!empty($all_programe_masters)){
                                        foreach($all_programe_masters as $p)
                                        {
                                            $selected = ($p['programe_id'] == $this->input->get('programe_id')) ? ' selected="selected"' : "";
                                            echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
                                        } 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php $category_id_post=$this->input->get('category_id[]'); ?>

                        <div class="col-md-3 catBox">
                            <label for="category_id" class="control-label">Category</label>
                            <div class="form-group">
                                <select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
                                    <option value="" disabled="disabled">Select Category</option>
                                    <?php
                                    if(!empty($all_category)){ 
                                    foreach($all_category as $p){
                                        $selected='';
                                        if(in_array($p['category_id'],$category_id_post)){
                                            $selected='selected="selected"';
                                        }
                                        echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].' | '.$p['programe_name'].' | '.$p['category_name'].'</option>';
                                    } 
                                }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="duration_type" class="control-label">Duration type</label>
                            <div class="form-group">
                                <select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100">
                                    <option value="">Select</option>
                                    <?php 
                                    if(!empty($all_duration_type)){
                                    foreach($all_duration_type as $p){
                                        $selected = ($p['id'] == $this->input->get('duration_type')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['duration_type'].'</option>';
                                    } 
                                }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="duration" class="control-label">Duration</label>
                            <div class="form-group has-feedback">
                                <input type="text" placeholder="e.g. 30" name="duration" value="<?php echo $this->input->get('duration'); ?>" class="form-control chknum1 input-ui-100" id="duration" maxlength="3"/>
                                <span class="glyphicon glyphicon-time form-control-feedback"></span>
                                <span class="text-danger duration_err"><?php echo form_error('duration');?></span>
                            </div>
                        </div>

                       

                        <div class="col-md-3">
                            <label for="status" class="control-label">Status</label>
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
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                        <?php 
                        if($this->Role_model->_has_access_('practice_packages','add')) { ?>
                            <a href="<?php echo site_url('adminController/practice_packages/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                            <?php 
                        } 
                         
                        /*if($this->Role_model->_has_access_('practice_packages','index')){ ?>
                            <a href="<?php echo site_url('adminController/practice_packages/index'); ?>" class="btn btn-success btn-sm">ALL Practice Packs</a> 
                            <?php 
                        } 
                         
                        if($this->Role_model->_has_access_('practice_packages','index')){
                            foreach ($all_testModule as $t) { 
                                $test_module_id=  $t['test_module_id'];?>
                                <a href="<?php echo site_url('adminController/practice_packages/index/'. $test_module_id); ?>" class="btn btn-info btn-sm"><?php echo $t['test_module_name'];?></a>
                                <?php 
                            }
                        }*/
                        ?> 
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body">
            <div class="col-md-12" style="margin-top:10px">
                <?php $listRecordActionArray = LIST_RECORD_ACTIONS; ?>
                <?php 
            
                if($this->Role_model->_has_access_('practice_packages','active_deactive_') || $this->Role_model->_has_access_('practice_packages','publish_unpublish_')){ ?>
                    <div class="col-md-4 no-padding">
                        <select class="form-control listCheckboxAction selectpicker selectpicker-ui-100">
                            <option value="">Select Action</option>
                            <?php if(LIST_RECORD_ACTIONS) { ?>
                                <?php 
                                    if(!$this->Role_model->_has_access_('practice_packages','active_deactive_')) {
                                        unset($listRecordActionArray[0]);
                                        unset($listRecordActionArray[1]);
                                    }

                                    if(!$this->Role_model->_has_access_('practice_packages','publish_unpublish_')) {
                                        unset($listRecordActionArray[2]);
                                        unset($listRecordActionArray[3]);
                                    }
                                ?>    

                                <?php foreach($listRecordActionArray as $value) { ?>
                                    <option value="<?php echo $value; ?>"><?php echo ucfirst(strtolower($value)); ?></option>    
                                    <?php 
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger list_checkbox_action_err"></span>
                    </div>
                    <div class="col-md-2">
                        <input type="button" class="btn listCheckboxActionButton rd-20" value="Go" />    
                    </div>
                    <?php 
                } 
                ?>
                
                <?php if($total_rows > RECORDS_PER_PAGE) { ?>
                    <input type="hidden" class="hiddenValueOfSelectAllRecords" value="0" />
                    <div class="row allListRecords" style="display:none;">
                        All <?php echo RECORDS_PER_PAGE; ?> records on this page are selected. <a href="javascript:void(0);" class="selectAllListRecords">Select all <?php echo $total_rows;  ?> records in Primary</a>
                    </div>
                    <div class="row allListRecordsSelected" style="display:none;">
                        All <?php echo $total_rows; ?> records in Primary are selected. <a href="javascript:void(0);" class="clearListRecords">Clear selection</a>
                    </div>
                <?php } ?>
                </div>

                <div style="margin-top:20px;">
                <div  class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="checkboxAllRecords" /></th>
                        <th><?php echo SR;?></th>
                        <th>ID</th>
                        <th><?php echo ACTION;?></th>
                        <th>Package Name</th>
                        <th>Image</th>
                        <th>Course</th>
                        <th>Program</th>
                        <th>Category</th>
                        <th>Branch</th>  
                        <th>Country</th>  
                        <th>Currency</th>  
                        <th>Real Price</th>
                        <th>Fake Price</th>
                        <th>Duration</th>
						<th>Active</th>
                        <th>Publish</th>
                       
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php 
                     if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                     if(!empty($practice_packages)){
                        foreach($practice_packages as $p){ 
                            $zero=0;$one=1;$pk='package_id'; $table='practice_package_masters';$sr++; ?>
                    <tr>
                        <td><input type="checkbox" name="listCheckboxRecord[]" class="listCheckboxRecord" value="<?php echo $p['package_id']; ?>" /></td>
						<td><?php echo $sr; ?></td>	
                        <td><?php echo PREFIX_PRACTICE_PACK_ID.$p['package_id']; ?></td>
                        <td>
                            <?php 
                                if($this->Role_model->_has_access_('practice_packages','edit')){
                            ?>
                            <a href="<?php echo site_url('adminController/practice_packages/edit/'.$p['package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> <?php } ?>

                            <!-- <a href="<?php echo site_url('adminController/practice_packages/remove/'.$p['package_id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a> -->
                        </td>	
                        <td><?php echo $p['package_name']; ?></td>
                        <td>
                            <?php 
                                if($p['image']){   
                                    echo '<span>
                                            <a href="'.site_url(PACKAGE_FILE_PATH).$p['image'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }                                
                            ?>   
                        </td>
                        <td><?php echo $p['test_module_name']; ?></td>
                        <td><?php echo $p['programe_name']; ?></td>
                        <td>
                        <?php
                           $category_name="";
                            foreach ($p['Package_category'] as $pc) {
                                 $category_name .= $pc['category_name'].', ';
                            }
                            echo rtrim($category_name,', ');
                        ?>                                                    
                        </td>
                        <td> 
                            <?php 
                            
                                if($p['center_name']==null){
                                    echo 'ALL';
                                }else{
                                    echo $p['center_name'];
                                } 
                            ?>
                                
                        </td>
                        <td><?php echo $p['country_name']; ?></td>
                        <td><?php echo $p['currency_code']; ?></td>  
                        <td><?php echo $p['discounted_amount']; ?></td>
                        <td><?php echo $p['amount']; ?></td>
                        <td><?php echo $p['duration'].' '.$p['duration_type_name']; ?></td>
                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"   style="pointer-events: none;>'.ACTIVE.'</span>';
                            }else{
                                echo '<span class="text-danger"   style="pointer-events: none;>'.DEACTIVE.'</span>';
                            }
                            ?>                                
                        </td>
                        <td>
                            <?php 
                            if($p['publish']==1){
                                echo '<span class="text-success"   style="pointer-events: none;>'.ACTIVE.'</span>';
                            }else{
                                echo '<span class="text-danger"   style="pointer-events: none;>'.DEACTIVE.'</span>';
                            }
                            ?>                                
                        </td>
						
                    </tr>
                    <?php } }?>
                   
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
    </div>
</div>

<?php ob_start(); ?>
<script>
$(document).ready(function(){
    $(document).on("click",".selectAllListRecords",function(){
        $(".hiddenValueOfSelectAllRecords").val(1);
        $(".allListRecords").hide();
        $(".allListRecordsSelected").show();
    });

    $(document).on("click",".clearListRecords",function(){
        $(".hiddenValueOfSelectAllRecords").val(0);
        $(".allListRecordsSelected").hide();
        $(".checkboxAllRecords").trigger("click");
    })

    $(document).on("change",".checkboxAllRecords",function(){
        if($(this).is(":checked")) {
            $(".listCheckboxRecord").prop("checked",true);
            if($(".allListRecords").length > 0) {
                $(".allListRecords").show();
            }
        }
        else {
            $(".listCheckboxRecord").prop("checked",false);
            $(".hiddenValueOfSelectAllRecords").val(0);
            if($(".allListRecords").length > 0) {
                $(".allListRecords").hide();
            }
        }
    });

    $(document).on("change",".listCheckboxRecord",function(){
        if($(this).is(":checked")) {
            $(".list_checkbox_action_err").html("");
        }
    });

    $(document).on("change",".listCheckboxAction",function(){
        if($(this).val()) {
            $(".list_checkbox_action_err").html("");
        }
    })

    $(document).on("click",".listCheckboxActionButton",function(){
        if($(".listCheckboxAction").val() == '') {
            $(".list_checkbox_action_err").html("Please select action from the dropdown.");
            return false;
        }

        if($(".listCheckboxRecord:checked").length == 0) {
            $(".list_checkbox_action_err").html("Please select alteast one record from the list.");
            return false;
        }
        var listRecords = []
        $(".listCheckboxRecord:checked").each(function(){
            listRecords.push($(this).val());
        })

        if(listRecords) {
            var functionName                        = '';
            var dataParameters                      = {};
            dataParameters["records"]               = listRecords;
            dataParameters["action"]                = $(".listCheckboxAction").val();

            if($(".listCheckboxAction").val() == '<?php echo LIST_RECORD_ACTIONS[0]; ?>' || $(".listCheckboxAction").val() == '<?php echo LIST_RECORD_ACTIONS[1]; ?>') {
                functionName = "active_deactive_";
            }
            else if($(".listCheckboxAction").val() == '<?php echo LIST_RECORD_ACTIONS[2]; ?>' || $(".listCheckboxAction").val() == '<?php echo LIST_RECORD_ACTIONS[3]; ?>') {
                functionName = "publish_unpublish_";
            }

            if($(".hiddenValueOfSelectAllRecords").length > 0) {
                dataParameters["all_records_selected"]  = $(".hiddenValueOfSelectAllRecords").val();
            }

            <?php if(!empty($this->input->get("submit")) && $this->input->get("submit") == "search") { ?>
                dataParameters["is_search"]         =  1;
                dataParameters["search_parameters"] = '<?php echo json_encode($_GET); ?>';
                <?php
            }
            ?>

            $.ajax({
                url: WOSA_ADMIN_URL + 'practice_packages/'+functionName,
                type: "POST",
                data: dataParameters,
                success: function(data) {
                    location.reload(); 
                }
            })
        }
    });
})
</script>

<?php 
global $customJs;
$customJs = ob_get_clean();
?>
