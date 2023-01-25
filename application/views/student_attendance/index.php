<div class="row">
    <div class="col-md-12">
        <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3> 
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/student_attendance/mark_attendance'); ?>
            <div class="box-body clearfix" style="padding:10px!important;">
              
                    <div class="col-md-6">
                        <label for="center_id" class="control-label">Spell For</label>
                        <div class="form-group">
                            <select name="spell" id="spell" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
                                <option value="">Select Attendance Spell</option>
                                <option value="Morning">Morning</option>
                                <option value="Evening">Evening</option>
                            </select>
                            <span class="text-danger spell_err"><?php echo form_error('spell');?></span>
                        </div>                        
                    </div>
                    
                    <div class="col-md-6 filterBox">
                        <label for="classroom_id" class="control-label">Classroom</label>
                        <div class="form-group">
                            <select name="classroom_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" id="classroom_id" onchange="loadStudents(this.value);">
                                <option value="" >Select Classroom</option>
                                <?php                               
                                    foreach($all_classroom as $p){

                                    $clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];
                                    $selected='';
                                    if(in_array($p['id'],$classroom_id_post)){
                                        $selected='selected="selected"';
                                    }
                                    if($classroom_id){
                                        $selected = ($p['id'] == $classroom_id) ? ' selected="selected"' : "";
                                    }
                                    
                                    echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
                                    }   
                                ?>
                            </select>
                            <span class="text-danger classroom_id_err"><?php echo form_error('classroom_id');?></span>
                        </div>
                    </div>
        
                    <div class="table-ui-scroller">
                <div class="box-body table-responsive table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Attendance id</th>
                        <th>UID</th>
                        <th>Student name</th>
                        <th>Branch</th>
                        <th>Classroom</th>
                        <th>Morning</th>
                        <th>Evening</th>
                        <th>Attendance Date</th>
                        <th>Last Attendance Time</th>
                        <th>
                         
                            <input type="button" onclick='selectAlL()' value="Select All"/>  
                            <input type="button" onclick='deSelectAll()' value="Deselect All"/> 
                         
                        </th>
                    </tr>
                    </thead>
                    <tbody id="myTable" class="resp">
                    </tbody>
                </table>
                           
       
                                </div>
                                <div class="pull-right">
                    <?php //echo $this->pagination->create_links(); ?>                  
                </div>  
                                </div>
            <div class="box-footer mt-15">          
                <button type="submit" class="btn btn-danger rd-20">
                    <i class="fa fa-hand-paper-o"></i> <?php echo ATTENDANCE_LABEL;?>
                </button>
                
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    </div>
</div>

