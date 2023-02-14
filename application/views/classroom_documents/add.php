<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
              	  <?php 
                  if($this->Role_model->_has_access_('Classroom_documents','index')){
                  ?>
                  <a href="<?php echo site_url('adminController/Classroom_documents/index'); ?>" class="btn btn-danger btn-sm">Classroom Documents List</a>
                <?php }?>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php 
			$attributes = ['name' => 'classroomdoc_add_form', 'id' => 'classroomdoc_add_form'];
			    if($classroom_id >0){ 
			        echo form_open_multipart('adminController/Classroom_documents/add/'.$classroom_id,$attributes);
			    }else{
					echo form_open_multipart('adminController/Classroom_documents/add/',$attributes);
				}
			  ?>
			<?php 	
			    $content_type_id=$this->input->post('content_type_id');
				//pr($_POST);
			?>
          	<div class="box-body">
          		<div class="">
				   <?php 
          			if($classroom_id>0){
          				$displayFilterBox='none';
          			}else{
          				$displayFilterBox='block';
          			}
          			$pattern = "/Trainer/i";
					$isTrainer = preg_match($pattern, $_SESSION['roleName']);
          			if(!$isTrainer){
          		?>
          		<div class="" style="background-color: <?php echo FILTER_BOX_COLOR;?>; display: <?php echo $displayFilterBox;?>">
          			<div class="col-md-2">
						<label for="test_module_id" class="control-label">Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'announcement');loadClassroom();">
								<option value="">Select course</option>
								<?php 
								foreach($all_test_module as $p)
								{
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<label for="programe_id" class="control-label">Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);loadClassroom();">
								<option data-subtext="" value="">Select program</option>
								<?php 
								foreach($all_programe_masters as $p)
								{
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>

					<div class="col-md-3 catBox">
						<label for="category_id" class="control-label"> Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadClassroom();" >
								<option value="" disabled="disabled">Select Category</option>
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<label for="batch_id" class="control-label"> Batch</label>
						<div class="form-group">
							<select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
								<option value="">Select Batch</option>
								<?php 
								foreach($all_batches as $b)
								{
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
							<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b)
								{
									$selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>
					</div>
					<?php } ?>

					<?php $classroom_id_post = $this->input->post('classroom_id[]');?>
					<div class="col-md-12">
						<label for="classroom_id" class="control-label"><span class="text-danger">*</span>Classroom</label>
						<div class="form-group">
							<select name="classroom_id[]" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" id="classroom_id" multiple="multiple" data-actions-box="true">
								<option value="" disabled="disabled">Select Classroom</option>
								<?php								
									foreach($all_classroom as $p){

										if($classroom_id!=0 && $p['id']==$classroom_id)
										{
											$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];
											$selected='';
											if(in_array($p['id'],$classroom_id_post)){
											$selected='selected="selected"';
											}
											if($classroom_id){
											$selected = ($p['id'] == $classroom_id) ? ' selected="selected"' : "disabled='disabled'";
											}
											echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
										}
										if($classroom_id==0 )
										{
											if($p['active'] !=0)
										{										
										$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];										
										echo '<option value="'.$p['id'].'" >'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
										}
										}
									}	
								?>
							</select>
							<span class="text-danger classroom_id_err"><?php echo form_error('classroom_id[]');?></span>
						</div>
					</div>
					<?php 	
			            $content_type_id=$this->input->post('content_type_id');
			            if(isset($content_type_id)){

			            }else{
			            	$content_type_id=[];
			            }
			        ?>
					<div class="col-md-6">
						<label for="content_type_id" class="control-label">Content Type<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="content_type_id[]" id="content_type_id" class="form-control selectpicker selectpicker-ui-100" multiple="multiple" data-actions-box="true" data-live-search="true">
							<option value="" disabled="disabled">Select Content Type</option>
							<?php foreach($content_type_list as $key=>$val){?>
								<option value="<?php echo $val['id']?>" <?php echo in_array($val['id'],$content_type_id) ? 'selected="selected"':''?>>
								<?php echo $val['content_type_name']?></option>
								<?php 
								}?>	
							</select>						
							<span class="text-danger content_type_id_err"><?php echo form_error('content_type_id[]');?></span>
						</div>
					</div>
					<?php 	
			            $title=$this->input->post('title');
			        ?>
                     <div class="col-md-6">
						<label for="zoom_link" class="control-label">Document Title<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="title" value="<?php echo $title ?>" class="form-control input-ui-100" id="title"/>
							<span class="text-danger title_err "><?php echo form_error('title');?></span>
							
						</div>
					</div>
					
					<?php 	
			            $description=$this->input->post('description');
			        ?>
					<div class="col-md-12">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
						<div class="text-danger" id="comm_err" style="margin-bottom: 10px;"></div>
					</div>
					<div class="col-md-3" style="margin-bottom: 20px;">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('text')">
					   <i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Text
					</div>
					<div class="col-md-3" style="margin-bottom: 20px;">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('image')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Image </label>
					</div>
					<div class="col-md-3" style="margin-bottom: 20px;">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('video')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Video </label>
					</div>
					<div class="col-md-3" style="margin-bottom: 20px;">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('audio')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Audio </label> </label>
					</div>
					</hr>
					<?php 
					
					 $total_section=$this->input->post('total_section');
					 if(empty($total_section)){
							
						$total_section=$free_resources['total_section'];
					}
					if($total_section =="")
					{
				   $total_section=0;	
					}
					?>
					<input type="hidden" name="total_section" id="total_section" value="<?php echo  $total_section?>">
					<div id="EmployeeTierId">
					 <!--------Time Slot  List-------->
					    <?php
					    for($i=1; $i<=$total_section; $i++){
					        
                            //$classroom_documents_section=$this->input-> post('classroom_documents_section'.$i);
							$classroom_documents_section=$_POST['classroom_documents_section'.$i];
							$section_no=$this->input-> post('section_no'.$i);
							$section_type=$this->input-> post('section_type'.$i);
							
							
						?>
							<div class="col-md-12 ClassroomDocumentsDiv" id="ClassroomDocumentsDiv-<?php echo $i?>">
								<div class="col-md-2">
										<label  class="control-label"><span class="sn"><?php $section_type?></span> Section pppp</label>
										<div class="form-group">
										   <input type="text" name="section_no<?php echo $i?>"  id="section_no<?php echo $i?>" class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))" required=required  value="<?php echo $section_no?>"/>
										   <span class="text-danger "></span>	
										   <input type="hidden" class="section_type" value="<?php echo $section_type?>"   name="section_type<?php echo $i?>"  id="section_type<?php echo $i?>"> 							   
										</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
									    <?php 
										if($section_type=='text'){ 
										?>
	                                     <textarea  rows="4" cols="100" placeholder="Add Text" class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i?>" name="classroom_documents_section<?php echo $i?>"><?php echo $classroom_documents_section?></textarea>
										<?php 
										} else if($section_type=='image'){
										?>
					               <div>
								   <div class="col-md-6">
								   <img src="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH.'no-image.png');?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg"></div>
								  <div class="col-md-6">
					              <input type="file"  class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i?>" name="classroom_documents_section<?php echo $i?>"  onchange="isImage('<?php echo $i?>')"/><span>[Allowed: jpg, png,jpeg]</span>
								   </div>
                                   </div>
									<?php 
									}else if($section_type=='video'){
									?>
                                   <div> 
								  
								    <div class="col-md-6">
								     <video controls  id="previewVideo<?php echo $i?>" height="150" width="150" class="previewVideo"></video>
								    </div>
								   <div class="col-md-6">
					                    <input type="file"  class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i?>" name="classroom_documents_section<?php echo $i?>" onchange="isVideo('<?php echo $i?>')"/>[Allowed: MP4, WebM,Ogg]	

                                </div>
								</div>
								<?php
								}else if($section_type=='audio'){
										?>
								<div>
								 <div class="col-md-6">
								 <audio controls  id="previewAudio<?php echo $i?>" class="previewAudio"></audio>
								 </div>
								<div class="col-md-6">
					              <input type="file"  class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i?>" name="classroom_documents_section<?php echo $i?>"  onchange="isAudio('<?php echo $i?>')"/>[Allowed: MP3, WAV,OGG]
								  </div>
								</div>
                                 <?php		
								}?>
								</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;" onclick="removeRow('<?php echo $i?>')">
										<i class="fa fa-minus" aria-hidden="true"></i>
										</button>
									</div>
								</div>						
							</div>
						<?php 
						}?>
					</div>
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
				</div>
          	</div>
            <?php echo form_close(); ?>
			<!---EmployeeTierId Data --->
			<div id="EmployeeTierIdData" style="display:none">
				<div class="col-md-12 ClassroomDocumentsDiv">
				   <div class="col-md-2">
						<div class="form-group">
							<label  class="control-label"><span class="sn">Text</span> Section </label>
							<div class="form-group">
							   <input type="text" name=""   class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))" />
							   <span class="text-danger "></span>	
                               <input type="hidden" class="section_type" value="text">							   
							</div>
					    </div>
				    </div>
					<div class="col-md-8">
						<div class="form-group section">
			            <textarea  rows="4" cols="100" placeholder="Add Text" class="form-control classroom_documents_section"></textarea>
						<span class="text-danger "></span>	
						</div>
					</div>
                    <div class="col-md-2">
						<div class="form-group">
							<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;">
					        <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
						</div>
					</div>						
				</div>
			</div>
      	</div>
    </div>
</div>
<?php ob_start();?> 
<script>
	$(".allow_numeric").on("input", function (evt) {
		alert('jjj');	
	var self = $(this);
	self.val(self.val().replace(/\D/g, ""));
	if ((evt.which < 48 || evt.which > 57)) {
		evt.preventDefault();
	}
});
$('#classroomdoc_add_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;		
		var classroom_id=$('#classroom_id').val();
		var content_type_id=$('#content_type_id').val();
		var title=$('#title').val();	
		var free_resources_topic=$('#free_resources_topic').val();
		var total_section=$('#total_section').val();		
		var section_no1=$('#section_no1').val();

		if(classroom_id == "")
		{			
			$(".classroom_id_err").html('The Classroom field is required.');
			flag=0;
		} else { $(".classroom_id_err").html(''); }
		
		if(content_type_id == "")
		{			
			$(".content_type_id_err").html('The Content Type field is required.');
			flag=0;
		} else { $(".content_type_id_err").html(''); }

		if(title == "")
		{			
			$(".title_err").html('The Title field is required.');
			flag=0;
		} else { $(".title_err").html(''); }


		var flg=0;
		$(".section_no").each(function(i)
		{		
			if($(this).val() >0)
			{
				flg=1;
			}
		});		
		if(flg == 0)
		{
			$("#comm_err").text("Please add at least one option text, image, video or audio");
			//return false;		
		}
		else {
			$("#comm_err").text("");
			//return true;
		}

		var total_section=$("#total_section").val();
		if(total_section == 0)
		{
			flag=0;
		}
		for (i = 1; i <= total_section; i++) 
		{
			var section_no1=$('#section_no'+i).val();
			if(section_no1 == "")
			{			
				$(".section_no"+i+'_err').html('The Text Section field is required.');
				$("#comm_err").text("");
				flag=0;
			} else { $(".section_no"+i+'_err').html(''); }
          
			if(typeof CKEDITOR.instances["classroom_documents_section"+i] !== 'undefined' && CKEDITOR.instances["classroom_documents_section"+i].getData().replace(/(<([^>]+)>)/ig,"").trim() == "") {	
				$('.classroom_documents_section'+i+"_err").html('The Text field is required.');
				flag=0;
				$("#comm_err").text("");
			}
			else if(($('#classroom_documents_section'+i).val()=="" &&  $('#classroom_documents_section'+i).attr("type") == "file")) {				
				$('.classroom_documents_section'+i+"_err").html('The File Input is required.');
			     $("#comm_err").text("");
				 flag=0;
				
			}
			else {
				$('.classroom_documents_section'+i+"_err").html("");
				//flag=1;
				
			}
		
			/* if(free_Section.toLowerCase() === 'textarea' ) {
				alert('yes')
				
		   if(CKEDITOR.instances.free_Section.getData() == "")
		   {
			 flag=0;			
			 $('.'+free_Section+"_err").html('The Text field is required.');
			 $("#comm_err").text("");
		   }
		   else {
			 $("."+free_Section+"_err").html('');
			// $(".free_resources_section1_err").html('');
		   }
		 }
		 else if(free_Section.nodeName.toLowerCase() === 'input')
		 {			
		  if($('#'+free_Section).val() == "")
		   {
			 flag=0;
			 $('.'+free_Section+"_err").html('The File Input is required.');
			 $("#comm_err").text("");
		   }
		   else {
			$('.'+free_Section+"_err").html('');
		   }
		 } */

		}		


		/* if(section_no1 == "")
		{			
			$(".section_no1_err").html('The Text Section field is required.');
			$("#comm_err").text("");
			flag=0;
		} else { $(".section_no1_err").html(''); }

		if( classroom_documents_section1.nodeName.toLowerCase() === 'textarea' ) {
		
		  if(CKEDITOR.instances.classroom_documents_section1.getData() == "")
		  {
			flag=0;			
			$(".classroom_documents_section1_err").html('The Text field is required.');
			$("#comm_err").text("");
		  }
		  else {
			$(".classroom_documents_section1_err").html('');
		  }
		}
		else if(classroom_documents_section1.nodeName.toLowerCase() === 'input')
		{			
		 if($('#classroom_documents_section1').val() == "")
		  {
			flag=0;
			$(".classroom_documents_section1_err").html('The File Input is required.');
			$("#comm_err").text("");
		  }
		  else {
			$(".classroom_documents_section1_err").html('');
		  }
		} */
	
		if(flag == 1)
		{
			this.submit();			
		} 
       
    });
	</script>


<script>
	  
	 
    var DEMO_IMAGE_URL='<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH."no-image.png");?>';
	function AddRow(type){
		
		var employeeTierIdDataHtml=$("#EmployeeTierIdData").html();
		$("#EmployeeTierId").append(employeeTierIdDataHtml);
		var total =$("#EmployeeTierId .ClassroomDocumentsDiv").length;
		
		i=1;
		$("#EmployeeTierId .ClassroomDocumentsDiv").each(function(){
			
			$(this).attr('id','ClassroomDocumentsDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeRow("'+i+'")');
			$(this).find('.classroom_documents_section').attr('name','classroom_documents_section'+i);
			$(this).find('.classroom_documents_section').attr('id','classroom_documents_section'+i);
			
			$(this).find('.section_no').attr('name','section_no'+i);
			$(this).find('.section_no').attr('id','section_no'+i);
			$(this).find('.section_no').next("span").addClass('section_no'+i+'_err');
			$(this).find('.section_type').attr('name','section_type'+i);
			$(this).find('.section_type').attr('id','section_type'+i);
			
			$(this).find('.previewImg').attr('id','previewImg'+i);
			$(this).find('.previewVideo').attr('id','previewVideo'+i);
			$(this).find('.previewAudio').attr('id','previewAudio'+i);
			
			if(i==total){
				
				$(this).find('.sn').text(type);
			    $(this).find('.sn').css('text-transform', 'capitalize');
				$(this).find('.section_type').val(type);
				html='';
				if(type=='text'){
				   CKEDITOR.replace('classroom_documents_section'+i);
				   $(this).find('#classroom_documents_section'+i).next("span").addClass('classroom_documents_section'+i+'_err');
				}else if(type=='image'){
					 var id='classroom_documents_section'+i;
					 var imgid='previewImg'+i;
					 html ='<div><div class="col-md-6"><img src="'+DEMO_IMAGE_URL+'" height="150" width="150" id="'+imgid+'" class="previewImg"></div><div class="col-md-6">';
					 html +='<input type="file"  id="'+id+'" name="'+id+'" class="form-control classroom_documents_section" onchange="isImage('+i+')"/>[Allowed: webp]<span class="text-danger '+id+'_err"></span></div></div>';
					 $(this).find('.section').html(html);
					 
				
				}else if(type=='video'){
					 var id='classroom_documents_section'+i;
					 var vid='previewVideo'+i;
					 html='<div><div class="col-md-6"><video controls  id="'+vid+'" height="150" width="150" class="previewVideo"></video></div><div class="col-md-6">';
					 html +='<input type="file"  id="'+id+'" name="'+id+'" class="form-control classroom_documents_section" onchange="isVideo('+i+')"/>[Allowed: MP4, WebM,Ogg]<span class="text-danger '+id+'_err"></span> </div></div>';
					 $(this).find('.section').html(html);
				}else if(type=='audio'){
					
					 var id='classroom_documents_section'+i;
					 var vid='previewAudio'+i;
					 html='<div><div class="col-md-6"><audio controls  id="'+vid+'" height="150" width="150" class="previewAudio"></audio></div><div class="col-md-6">';
					 html +='<input type="file" id="'+id+'" name="'+id+'" class="form-control classroom_documents_section" onchange="isAudio('+i+')"/>[Allowed: MP3, WAV,OGG] <span class="text-danger '+id+'_err"></span></div></div>';
					 $(this).find('.section').html(html);
				}
			    
			}
			i++;
		});
		var length =$("#EmployeeTierId .ClassroomDocumentsDiv").length;
		$("#total_section").val(length);
	}
	
	function removeRow(j){
		
		$("#ClassroomDocumentsDiv-"+j).remove();
		var i=1;
		var total_section=$("#total_section").val();
		$("#EmployeeTierId .ClassroomDocumentsDiv").each(function(){
			
			$(this).attr('id','ClassroomDocumentsDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeRow("'+i+'")');
			$(this).find('.classroom_documents_section').attr('name','classroom_documents_section'+i);
			$(this).find('.classroom_documents_section').attr('id','classroom_documents_section'+i);
			$(this).find('.classroom_documents_section').next().next().attr('class','text-red classroom_documents_section'+i+'_err');
			$(this).find('.section_type').attr('name','section_type'+i);
			type=$(this).find('.section_type').val();
			if(type=='text'){
				var editor = CKEDITOR.instances['classroom_documents_section'+total_section];
    if (editor) { editor.destroy(true); }
				   CKEDITOR.replace('classroom_documents_section'+i);
				   $(this).find('#classroom_documents_section'+i).next("span").addClass('classroom_documents_section'+i+'_err');
				}
			else if(type=='image'){
				$(this).find('.classroom_documents_section').attr('onchange','isImage("'+i+'")');
				$(this).find('.classroom_documents_section').next().attr('class','text-red classroom_documents_section'+i+'_err');
			}else if(type=='video'){
				$(this).find('.classroom_documents_section').attr('onchange','isVideo("'+i+'")');
				$(this).find('.classroom_documents_section').next().attr('class','text-red classroom_documents_section'+i+'_err');
			}else if(type=='audio'){
				$(this).find('.classroom_documents_section').attr('onchange','isAudio("'+i+'")');
				$(this).find('.classroom_documents_section').next().attr('class','text-red classroom_documents_section'+i+'_err');
			}
			$(this).find('.section_no').attr('name','section_no'+i);
			$(this).find('.section_no').attr('id','section_no'+i);
			$(this).find('.section_no').next("span").attr('class','text-red section_no'+i+'_err');
			$(this).find('.section_type').attr('name','section_type'+i);
			$(this).find('.previewImg').attr('id','previewImg'+i);
			$(this).find('.previewVideo').attr('id','previewVideo'+i);
			$(this).find('.previewAudio').attr('id','previewAudio'+i);
		    i++;
		});
		
		var length =$("#EmployeeTierId .ClassroomDocumentsDiv").length;
		$("#total_section").val(length);
	}
	
  function checkSectionNumber(section_no){	
  
	section_no_val = section_no.val().replace(/[^0-9\.]/g,'');
	section_no_val = section_no_val.replace(/^0+/,'');
	if(section_no_val.length==1 && section_no_val==0){
	   section_no_val = section_no.val().replace(/[^1-9\.]/g,'');
	}
	if(section_no==''){
		section_no.val(section_no_val);
		return false;
	}
	section_no.val(section_no_val);
	$("#EmployeeTierId .section_no").removeClass('cr');
	section_no.addClass("cr");
	var allReadyAdd=false;
	$("#EmployeeTierId .section_no").each(function(){
		
		cr_section_no=$(this).val();
		if($(this).hasClass('cr')){
			//Cruent Text Boox
        }else{
			    if(section_no_val !='' && cr_section_no==section_no_val){
					section_no.val('');
					allReadyAdd=true;
		        }
		}
	});
	if(allReadyAdd){
		return false;
	}
}
function updateCkEditer(){
	var i=1;
	$("#EmployeeTierId .ClassroomDocumentsDiv").each(function(){
		type=$(this).find('.section_type').val();
		if(type=='text'){
			CKEDITOR.replace('classroom_documents_section'+i);
		}
	});
	i++;
}

function imagePreview(id){
	var file=$('#'+id)[0].files[0];
	size=file.size;
	type=file.type;
	name=file.name;
    //return file['type'].split('/')[0]=='image');//returns true or false 
	FREE_RESOURCES_IMAGE_TYPES='<?php echo WEBP_FILE_TYPES ?>';
	FREE_RESOURCES_IMAGE_TYPES=FREE_RESOURCES_IMAGE_TYPES.split("|");
	var type = type.replace('image/','');
	//console.log(FREE_RESOURCES_IMAGE_TYPES);
	
	if(FREE_RESOURCES_IMAGE_TYPES.includes(type)){
		
	        var reader = new FileReader();
			reader.onload = function(){
			  $("#thumbnailPreview").attr("src", reader.result);
		    }
			reader.readAsDataURL(file);
	}else{
		alert('Allowed type only: <?php echo WEBP_FILE_TYPES ?>');
		$('#classroom_documents_section'+i).val('');
		$("#thumbnailPreview").attr("src",DEMO_IMAGE_URL);;
	}
    
}


function isImage(i){
	
	var file=$('#classroom_documents_section'+i)[0].files[0];
	size=file.size;
	type=file.type;
	name=file.name;
    //return file['type'].split('/')[0]=='image');//returns true or false 
	FREE_RESOURCES_IMAGE_TYPES='<?php echo WEBP_FILE_TYPES ?>';
	FREE_RESOURCES_IMAGE_TYPES=FREE_RESOURCES_IMAGE_TYPES.split("|");
	var type = type.replace('image/','');
	//console.log(FREE_RESOURCES_IMAGE_TYPES);
	
	if(FREE_RESOURCES_IMAGE_TYPES.includes(type)){
		
	        var reader = new FileReader();
			
			reader.onload = function(){
				
			   $("#previewImg"+i).attr("src", reader.result);
		    }
			reader.readAsDataURL(file);
	}else{
		alert('Allowed type only: <?php echo WEBP_FILE_TYPES ?>');
		$('#classroom_documents_section'+i).val('');
		$("#previewImg"+i).attr("src",DEMO_IMAGE_URL);;
	}
    
}
function isVideo(i){
	
	var file=$('#classroom_documents_section'+i)[0].files[0];
	size=file.size;
	type=file.type;
	name=file.name;
    //return file['type'].split('/')[0]=='image');//returns true or false 
	FREE_RESOURCES_VIDEO_TYPES='<?php echo FREE_RESOURCES_VIDEO_TYPES ?>';
	FREE_RESOURCES_VIDEO_TYPES=FREE_RESOURCES_VIDEO_TYPES.split("|");
	var type = type.replace('video/','');
	//console.log(FREE_RESOURCES_IMAGE_TYPES);
	
	if(FREE_RESOURCES_VIDEO_TYPES.includes(type)){
		
	        var reader = new FileReader();
			reader.onload = function(){
			  $("#previewVideo"+i).attr("src", reader.result);
		    }
			reader.readAsDataURL(file);
	}else{
		alert('Allowed type only: <?php echo FREE_RESOURCES_VIDEO_TYPES ?>');
		$('#classroom_documents_section'+i).val('');
		$("#previewVideo"+i).attr("src",'');
	}
    
}
function isAudio(i){
	
	var file=$('#classroom_documents_section'+i)[0].files[0];
	size=file.size;
	type=file.type;
	name=file.name;
    //return file['type'].split('/')[0]=='image');//returns true or false 
	FREE_RESOURCES_AUDIO_TYPES='<?php echo FREE_RESOURCES_AUDIO_TYPES ?>';
	FREE_RESOURCES_AUDIO_TYPES=FREE_RESOURCES_AUDIO_TYPES.split("|");
	var type = type.replace('audio/','');
	//console.log(FREE_RESOURCES_IMAGE_TYPES);
	
	if(FREE_RESOURCES_AUDIO_TYPES.includes(type)){
		
	        var reader = new FileReader();
			reader.onload = function(){
			  $("#previewAudio"+i).attr("src", reader.result);
		    }
			reader.readAsDataURL(file);
	}else{
		alert('Allowed type only: <?php echo FREE_RESOURCES_AUDIO_TYPES ?>');
		$('#classroom_documents_section'+i).val('');
		$("#previewAudio"+i).attr("src",'');
	} 
}
</script>
<?php global $customJs;
$customJs=ob_get_clean();
?> 
