<style>
.box-flex-widget .btn-group.bootstrap-select {margin-bottom:0px;}
.box-flex-widget .box-body{padding:5px!important;}

</style>

<div class="user-user_activity_report">
    <div class="row">
        <div class="col-md-12">
        <div class="box box-info">
                <div class="box-header bg-danger">
                    <h3 class="box-title text-primary"><?php echo $title;?></h3>
                </div>
                <?php echo form_open('adminController/user/user_activity_report/search/',array('method'=>'post')); ?>
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="" class="control-label">Branches</label>
                            <div class="form-group">

                                <?php if(isset($_SESSION["userActivitySearch"]["center_id"]) && !empty($_SESSION["userActivitySearch"]["center_id"])) {
                                    $centerId = $_SESSION["userActivitySearch"]["center_id"];
                                }
                                else {
                                    $centerId = $this->input->post("center_id");
                                }
                                ?>


                                <select name="center_id[]" class="form-control selectpicker selectpicker-ui-100" id="center_id" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple>
                                    <option data-subtext="" value="" disabled>Select Branch</option>
                                    <?php
                                    foreach($center_location as $p){
                                        $selected='';
                                        if(in_array($p['center_id'], $centerId)){
                                            $selected='selected="selected"';
                                        }
                                        echo '<option value="'.$p['center_id'].'"  '.$selected.'>'.$p['center_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php if(isset($_SESSION["userActivitySearch"]["active"]) && !empty($_SESSION["userActivitySearch"]["active"])) {
                            $searchActive = $_SESSION["userActivitySearch"]["active"];
                        }
                        else {
                            $searchActive = $this->input->post("employee_status");
                        }
                        ?>

                        <div class="col-md-4">
                            <label for="state_id" class="control-label">Employee Status</label>
                            <div class="form-group">
                            <select name="employee_status[]" id="employee_status" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple>
                                    <option data-subtext="" value="" disabled>Select Employee Status</option>
                                    <option value="1" <?php echo (in_array(1, $searchActive) ? 'selected=selected' : ''); ?>>Active</option>
                                    <option value="0" <?php echo (in_array(0, $searchActive) ? 'selected=selected' : ''); ?>>InActive</option>
                                </select>
                            </div>
                        </div>
                        <?php if(isset($_SESSION["userActivitySearch"]["employee_id"]) && !empty($_SESSION["userActivitySearch"]["employee_id"])) {
                            $employeeIds = $_SESSION["userActivitySearch"]["employee_id"];
                        }
                        else {
                            $employeeIds = $this->input->post("employee_status");
                        }
                        ?>
                        <div class="col-md-4">
                            <label for="test_module_id" class="control-label">Employees</label>
                            <div class="form-group">
                            <select name="employee_id[]" id="employee_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple>
                                    <option data-subtext="" value="" disabled>Select Employee</option>
                                    <?php
                                    if(is_array($employeesList) && !empty($employeesList)) {
                                        foreach($employeesList as $employee)
                                        {
                                            $selected='';
                                            if(in_array($employee['id'],$employeeIds)){

                                                $selected='selected="selected"';
                                            }
                                            echo '<option value="'.$employee['id'].'"  '.$selected.'>'.$employee['full_name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php if(isset($_SESSION["userActivitySearch"]["from_date"]) && !empty($_SESSION["userActivitySearch"]["from_date"])) {
                            $searchFromDate = $_SESSION["userActivitySearch"]["from_date"];
                        }
                        else {
                            $searchFromDate = $this->input->post("from_date");
                        }
                        ?>

                        <div class="col-md-4">
                            <label for="test_module_id" class="control-label">From Date</label>
                            <div class="form-group">
                                <input type="text" name="from_date" class="form-control user_activity_report_datetimepicker input-ui-100" value="<?php echo $searchFromDate; ?>" />
                            </div>
                        </div>

                        <?php if(isset($_SESSION["userActivitySearch"]["to_date"]) && !empty($_SESSION["userActivitySearch"]["to_date"])) {
                            $searchToDate = $_SESSION["userActivitySearch"]["to_date"];
                        }
                        else {
                            $searchToDate = $this->input->post("to_date");
                        }
                        ?>
                        <div class="col-md-4">
                            <label for="test_module_id" class="control-label">To Date</label>
                            <div class="form-group">
                                <input type="text" name="to_date" class="form-control user_activity_report_datetimepicker input-ui-100" value="<?php echo $searchToDate; ?>" />
                            </div>
                        </div>

                        <div class="col-md-12">
                    
                                <button type="submit" class="btn btn-danger rd-20" name="action" value="search" style="margin-right:5px;">
                                 Search
                                </button>
                                <a href="<?php echo site_url('adminController/user/user_activity_report'); ?>" class="btn btn-reset rd-20">
                                    Reset All
                                </a>
                       
                        </div>
   
                <?php echo form_close(); ?>
                    </div>
                    </div>

                <div class="table-ui-scroller">
                <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200" style="padding:0px!important;">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th><?php echo SR;?></th>
                            <th>By User</th>
                            <th>Activity</th>
                            <th>Desc.</th>
                            <th>Pack</th>
                            <th>Branch</th>
                            <th>Lat/Long</th>
                            <th>Country</th>
                            <th width="10%">State</th>
                            <th width="10%">City</th>
                            <th width="10%">IP</th>
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
                            <td><?php echo $ua['full_name']; ?></td>
                            <td style="color: blue"><?php echo $ua['activity_name'];?></td>
                            <td><?php echo $description;?></td>
                            <td><?php echo $ua['student_package_id'];?></td>
                            <td><?php echo $ua['center_name'];?></td>
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
            </div>
            <div class="pagination-right">
                    <?php echo $this->pagination->create_links(); ?>
                 </div>
            </div>
           
    </div>
    </div>
    </div>

</div>

<?php ob_start(); ?>
<script>
$(document).ready(function(){
    $(".user_activity_report_datetimepicker").datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });

    $(document).on("change","#center_id,#employee_status",function(){
       var params                   = {};
       params["branch_id"]          = $("#center_id").val();
       params["employee_status"]    = $('#employee_status').val();
       getEmployeeList(params);
    })

    function getEmployeeList(params) {
        $.ajax({
            url: WOSA_ADMIN_URL + 'user/ajax_get_users_list',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(data) {
                if(data) {
                    html = '<option data-subtext="" disabled value="">Select Employee</option>';
                    for (i = 0; i < data["employees"].length; i++) {
                        html += '<option value=' + data["employees"][i]['id'] + ' >' + data["employees"][i]['full_name'] + '</option>';
                    }
                    $("#employee_id").html(html);
                    $("#employee_id").selectpicker('refresh');
                }
                else {
                    html = '<option data-subtext="" disabled value="">Select Employee</option>';
                    $("#employee_id").html(html);
                    $("#employee_id").selectpicker('refresh');
                }
            }
        })
    }
})
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>