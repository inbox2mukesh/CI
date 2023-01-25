<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                <!-- <?php 
                  if($this->Role_model->_has_access_('classroom','add')){
                ?>
                    <a href="<?php echo site_url('adminController/classroom/add'); ?>" class="btn btn-danger btn-sm">Add new classroom</a>
                <?php }?> -->
                <?php 
                  if($this->Role_model->_has_access_('classroom','index')){
                ?>
                    <a href="<?php echo site_url('adminController/classroom/index'); ?>" class="btn btn-info btn-sm">All classroom</a>
                <?php }?>                    
                </div>                
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>

                <?php 
                    if(isset($classroom_id) and $classroom_id>0){
                        $displayFilterBox='none';
                    }else{
                        $displayFilterBox='block';
                    }
                    $pattern = "/Trainer/i";
                    $isTrainer = preg_match($pattern, $_SESSION['roleName']);
                    if(!$isTrainer){
                ?>
                <div class="box-body" style="display: <?php echo $displayFilterBox;?>">
                    <div class="col-md-2">
                        <label for="test_module_id" class="control-label">Course</label>
                        <div class="form-group">
                            <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'classroom');loadClassroom2new();">
                                <option value="">Select Course</option>
                                <?php 
                                foreach($all_test_module as $p){
                                    $selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="classsroomPage" id="classsroomPage" value="classsroomPage">
                    <div class="col-md-3">
                        <label for="programe_id" class="control-label">Program</label>
                        <div class="form-group">
                            <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);loadClassroom2new();">
                                <option data-subtext="" value="">Select Program</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 catBox">
                        <label for="category_id" class="control-label"> Category</label>
                        <div class="form-group">
                            <select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadClassroom2new();" >
                                <option value="" disabled="disabled">Select Category</option>                              
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="batch_id" class="control-label"> Batch</label>
                        <div class="form-group">
                            <select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom2new();" >
                                <option value="">Select Batch</option>
                                <?php 
                                foreach($all_batches as $b){
                                    $selected = ($b['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>          

                    <div class="col-md-2">
                        <label for="center_id" class="control-label"> Branch</label>
                        <div class="form-group">
                            <select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom2new();" >
                                <option value="">Select Branch</option>
                                <?php 
                                foreach($all_branch as $b){
                                    $selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
                                    echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    </div>
                <?php } ?>
                <div  class="table-ui-scroller">
            <div class="box-body table-responsive">          
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Classroom name</th>
                        <th>Test</th>
                        <th>Program</th>
                        <th>Category</th>
                        <th>Batch</th>					
						<th>Branch</th>						
						<th><?php echo STATUS;?></th>
                        <th>View</th>
                        <th>Add New</th>
                        <th>Modify</th>
                    </tr>
                    </thead>
                    <tbody id="myTable" class="resp">
                    <?php 
                       if(!empty($this->input->get('per_page'))) {

                        $sr=$this->input->get('per_page');
    
                     } else{
    
                         $sr=0;
    
                     }
                       
                       
                       foreach($classroom as $p){ $zero=0;$one=1;$pk='id'; $table='classroom';$sr++;
                            
                            if($p['active']==1){ 
                                $rowColor='#B4F8AE';
                            }else{
                                $rowColor='#F8BBAE';
                            }
                            
                    ?>
                    <tr style="background-color: <?php echo $rowColor;?>">
						<td><?php echo $sr; ?></td>	
                        <td><?php echo $p['classroom_name']; ?></td>
                        <td><?php echo $p['test_module_name']; ?></td>
                        <td><?php echo $p['programe_name']; ?></td>	
                        <td>
                            <?php 
                               echo $p['Category']['category_name'];
                            
                            ?>                                
                        </td>
                        <td><?php echo $p['batch_name']; ?></td>		
						<td><?php echo $p['center_name']; ?></td>
                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Active" >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                            <?php 
                            if($this->Role_model->_has_access_('online_class_schedule','index')){
                            ?>
                            <a href="<?php echo site_url('adminController/online_class_schedule/index/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="View class schedule"><span class="fa fa-calendar"></span> </a>
                           <?php } ?>
                           <?php 
                            if($this->Role_model->_has_access_('classroom','classroom_students_')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/classroom_students_/'.$p['id']); ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="View classroom students"><span class="fa fa-users"></span> </a>
                            <?php } ?>
                            <?php /*
                            if($this->Role_model->_has_access_('classroom_documents','index')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom_documents/index'); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Shared Docs"><span class="fa fa-file"></span> </a>
                            <?php }*/ ?>

                            <?php 
                            if($this->Role_model->_has_access_('classroom','classroom_docs_')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/classroom_docs_/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Shared Docs"><span class="fa fa-file"></span> </a>
                            <?php } ?>

                            <?php 
                            if($this->Role_model->_has_access_('classroom','classroom_lecture_')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/classroom_lecture_/'.$p['id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View Classroom Recorded lectures"><span class="fa fa-video-camera"></span> </a>
                            <?php } ?> 
                             <?php 
                            if($this->Role_model->_has_access_('classroom','classroom_announcements_')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/classroom_announcements_/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Announcement"><span class="fa fa-bullhorn"></span> </a> 
                            <?php } ?> 
                             <?php 
                            if($this->Role_model->_has_access_('classroom','classroom_post_')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/classroom_post_/'.$p['id']); ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="View Classroom Posts"><span class="fa fa-comments"></span> </a><?php } ?>                          
                        </td>

                        <td>
                            <?php if($p['active'] == 1){?>
                             <?php 
                            if($this->Role_model->_has_access_('online_class_schedule','add')){
                            ?>
                            <a href="<?php echo site_url('adminController/online_class_schedule/add/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Add New Schedule"><span class="fa fa-plus"></span> <span class="fa fa-calendar"></span> </a>
                            <?php } ?>  
                            <?php 
                            if($this->Role_model->_has_access_('classroom_documents','add')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom_documents/add/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Docs"><span class="fa fa-plus"></span> <span class="fa fa-file"></span> </a>
                            <?php } ?>  
                            <?php 
                            if($this->Role_model->_has_access_('live_lecture','add')){
                            ?>
                            <a href="<?php echo site_url('adminController/live_lecture/add/'.$p['id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Add New Lectures"><span class="fa fa-plus"> <span class="fa fa-video-camera"></span> </a>
                            <?php } ?>
                            <?php 
                            if($this->Role_model->_has_access_('classroom_announcement','add')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom_announcement/add/'.$p['id']);?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Announcement"><span class="fa fa-plus"></span> <span class="fa fa-bullhorn"></span> </a>
                             <?php } ?>   
                             <?php }?>                                                     
                        </td>

                        <td> 
                            <?php 
                            if($this->Role_model->_has_access_('classroom','edit')){
                            ?>
                            <a href="<?php echo site_url('adminController/classroom/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                            <?php } ?>                        
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
        
             </div>
                <div class="pull-right pagination">
                    <?php echo $this->pagination->create_links(); ?>                  
                </div>                
            </div>
        </div>
    </div>
</div>

<script>


function loadClassroom2new() {
   	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	var category_id = [];
	var batch_id = $("#batch_id").val();
	var center_id = $("#center_id").val();
    var online_class_schedule_Url_tag="";
    var classroom_students_Url_tag="";
    var classroom_docs_Url_tag="";
    var classroom_lecture_Url_tag="";
    var classroom_announcements_Url_tag="";
    var classroom_post_Url_tag="";
    var add_online_class_schedule_Url_tag="";
    var add_shared_doc_Url_tag="";
    var add_live_lecture_Url_tag="";
    var add_announcements_Url_tag="";
    var classroom_edit_Url_tag="";
	$('#category_id :selected').each(function (i, selected) {
		category_id[i] = $(selected).val();
	});
	//alert(category_id)
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom/ajax_loadClassroom2',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, category_id: category_id, batch_id: batch_id, center_id: center_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			zero = 0; one = 1; table = 'classroom'; pk = 'id';
			sr = 0;
			for (i = 0; i < data.length; i++) {
				sr++;
				idd = data[i]['id'];
				baseUrl = WOSA_ADMIN_URL + ''; 
                
                
				online_class_schedule_Url = baseUrl + 'online_class_schedule/index/' + idd;
                <?php 
                if($this->Role_model->_has_access_('online_class_schedule','index')){
                ?>
                online_class_schedule_Url_tag='<a href="' + online_class_schedule_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="View class schedule"><span class="fa fa-calendar"></span> </a>';
                <?php }?> 

				classroom_students_Url = baseUrl + 'classroom/classroom_students_/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','classroom_students_')){
                ?>
                classroom_students_Url_tag='<a href="' + classroom_students_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="View classroom students"><span class="fa fa-users"></span> </a>';
                <?php }?> 

				classroom_docs_Url = baseUrl + 'classroom/classroom_docs_/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','classroom_docs_')){
                ?>
                classroom_docs_Url_tag='<a href="' + classroom_docs_Url + ' " class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Shared Docs"><span class="fa fa-file"></span> </a>';
                <?php }?> 


				classroom_lecture_Url = baseUrl + 'classroom/classroom_lecture_/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','classroom_lecture_')){
                ?>
                classroom_lecture_Url_tag='<a href="' + classroom_lecture_Url + ' " class="btn btn-warning btn-xs" data-toggle="tooltip" title="View Classroom Recorded lectures"><span class="fa fa-video-camera"></span> </a>';
                <?php }?> 


				classroom_announcements_Url = baseUrl + 'classroom/classroom_announcements_/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','classroom_announcements_')){
                ?>
                classroom_announcements_Url_tag='<a href="' + classroom_announcements_Url + ' "  class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Announcement"><span class="fa fa-bullhorn"></span> </a>';
                <?php }?> 

				classroom_post_Url = baseUrl + 'classroom/classroom_post_/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','classroom_post_')){
                ?>
                classroom_post_Url_tag='<a href="' + classroom_post_Url + ' "  class="btn btn-success btn-xs" data-toggle="tooltip" title="View Classroom Posts"><span class="fa fa-comments"></span> </a>';
                <?php }?> 

				add_online_class_schedule_Url = baseUrl + 'online_class_schedule/add/' + idd;
                <?php 
                if($this->Role_model->_has_access_('online_class_schedule','add')){
                ?>
                add_online_class_schedule_Url_tag='<a href="' + add_online_class_schedule_Url + ' "  class="btn btn-info btn-xs" data-toggle="tooltip" title="Add New Schedule"><span class="fa fa-plus"></span> <span class="fa fa-calendar"></span> </a> ';
                <?php }?> 

				add_shared_doc_Url = baseUrl + 'classroom_documents/add/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom_documents','add')){
                ?>
                add_shared_doc_Url_tag='<a href="' + add_shared_doc_Url + ' " " class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Docs"><span class="fa fa-plus"></span> <span class="fa fa-file"></span> </a> ';
                <?php }?> 

				add_live_lecture_Url = baseUrl + 'live_lecture/add/' + idd;
                <?php 
                if($this->Role_model->_has_access_('live_lecture','add')){
                ?>
                add_live_lecture_Url_tag='<a href="' + add_live_lecture_Url + ' " " class="btn btn-warning btn-xs" data-toggle="tooltip" title="Add New Lectures"><span class="fa fa-plus"> <span class="fa fa-video-camera"></span> </a>';
                <?php }?> 

				add_announcements_Url = baseUrl + 'classroom_announcement/add/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom_announcement','add')){
                ?>
                add_announcements_Url_tag='<a href="' + add_announcements_Url + ' " " class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Announcement"><span class="fa fa-plus"></span> <span class="fa fa-bullhorn"></span> </a>';
                <?php }?> 

				classroom_edit_Url = baseUrl + 'classroom/edit/' + idd;
                <?php 
                if($this->Role_model->_has_access_('classroom','edit')){
                ?>
                classroom_edit_Url_tag='<a href="' + classroom_edit_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> ';
                <?php }?> 


				classroom_remove_Url = baseUrl + 'classroom/remove/' + idd;
				if (data[i]['active'] == 1) {
					rowColor = '#B4F8AE';
				} else {
					rowColor = '#F8BBAE';
				}
				/*if(data[i]['category_name']){
					category_name = data[i]['category_name'];
				}else{
					category_name = 'ALL';
				}*/
				if (data[i]['active'] == 1) {
					active = '<span class="text-success"><a href="javascript:void(0);" id=' + data[i]['id'] + ' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete(' + data[i]['id'] + ',' + zero + ',' + table + ',' + pk + ') ><span class="text-success"><i class="fa fa-check"></i></span></a></span>';
				} else {
					active = '<span class="text-success"><a href="javascript:void(0);" id=' + data[i]['id'] + ' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete(' + data[i]['id'] + ',' + one + ',' + table + ',' + pk + ') ><span class="text-danger"><i class="fa fa-close"></i></span></a></span>';
				}
				html += '<tr style="background-color: ' + rowColor + ' ">';
				html += '<td>' + sr + '</td>';
				html += '<td>' + data[i]['classroom_name'] + '</td>';
				html += '<td>' + data[i]['test_module_name'] + '</td>';
				html += '<td>' + data[i]['programe_name'] + '</td>';
				html += '<td>' + data[i]['Category']['category_name'] + '</td>';
				html += '<td>' + data[i]['batch_name'] + '</td>';
				html += '<td>' + data[i]['center_name'] + '</td>';
				html += '<td>' + active + '</td>';
				html += '<td>'  + online_class_schedule_Url_tag +''+ classroom_students_Url_tag +''+classroom_docs_Url_tag+'<a href=" ' + classroom_lecture_Url +''+classroom_lecture_Url_tag+''+classroom_announcements_Url_tag+ '<a href=" ' + classroom_post_Url +''+classroom_post_Url_tag+ '</td>';
				if (data[i]['active'] == 1) {
				html += '<td>'+add_online_class_schedule_Url_tag+''+add_shared_doc_Url_tag+''+add_live_lecture_Url_tag+''+add_announcements_Url_tag+'</td>';
				}
				else {
					html += '<td></td>';
				}
				
				html += '<td>'+classroom_edit_Url_tag+'</td>';
			}
			html += '</tr>';
			$('.resp').html(html);
			$('.pagination').hide();
		}
	});
}

</script>