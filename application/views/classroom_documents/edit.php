<style type="text/css">
	.del {
		font-size: 12px;
		padding: 3px 10px 3px 10px !important;
		margin-left: 5px;
		margin-bottom: 5px;
	}

	.cross-icn {
		position: absolute;
		margin-top: -10px;
		padding: 2px 0px;
		border-radius: 10px;
		color: #cd1515;
		background-color: #fff;
		width: 14px;
		height: 14px;
		box-shadow: 1px 2px 2px #a3a3a3;
		font-size: 11px;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?> </h3>
				<div class="box-tools pull-right">
					<a href="<?php echo site_url('adminController/Classroom_documents/index'); ?>" class="btn btn-danger btn-sm">Classroom Documents List</a>
				</div>
			</div>
			<?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php
			$attributes = ['name' => 'classroomdoc_edit_form', 'id' => 'classroomdoc_edit_form'];

			echo form_open_multipart('adminController/Classroom_documents/edit/' . $classroom_documents['id'], $attributes);
			?>
			<div class="box-body">
				<div class="">
					<?php
					$pattern = "/Trainer/i";
					$isTrainer = preg_match($pattern, $_SESSION['roleName']);
					if (!$isTrainer) {
					?>
						<div class="" style="background-color: <?php echo FILTER_BOX_COLOR; ?>;">
							<div class="col-md-2">
								<label for="test_module_id" class="control-label">Course</label>
								<div class="form-group">
									<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'announcement');loadClassroom();">
										<option value="">Select course</option>
										<?php
										foreach ($all_test_module as $p) {
											$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
											echo '<option value="' . $p['test_module_id'] . '" ' . $selected . '>' . $p['test_module_name'] . '</option>';
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
										foreach ($all_programe_masters as $p) {
											$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
											echo '<option value="' . $p['programe_id'] . '" ' . $selected . '>' . $p['programe_name'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-md-3 catBox">
								<label for="category_id" class="control-label"> Category</label>
								<div class="form-group">
									<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadClassroom();">
										<option value="" disabled="disabled">Select Category</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<label for="batch_id" class="control-label"> Batch</label>
								<div class="form-group">
									<select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();">
										<option value="">Select Batch</option>
										<?php
										foreach ($all_batches as $b) {
											$selected = ($b['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
											echo '<option value="' . $b['batch_id'] . '" ' . $selected . '>' . $b['batch_name'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<label for="center_id" class="control-label"> Branch</label>
								<div class="form-group">
									<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();">
										<option value="">Select Branch</option>
										<?php
										foreach ($all_branch as $b) {
											$selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
											echo '<option value="' . $b['center_id'] . '" ' . $selected . '>' . $b['center_name'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php
					$classroom_ids = $this->input->post('classroom_id');
					//pr($classroom_documents_class);
					?>
					<div class="col-md-12">
						<label for="classroom_id" class="control-label"><span class="text-danger">*</span>Classroom</label>
						<?php
						if(isset($classroom_documents_class) && $classroom_documents_class) {
							$classDocCount = count($classroom_documents_class);

							foreach ($classroom_documents_class as $c) {
								if ($c['delete_action'] == 'yes' && $classDocCount > 1) {
									echo '<button type="button" class="btn btn-md btn-success del" onclick=deleteClassroomDocumentsClass(' . $c["classroom_documents_id"] . ',' . $c["id"] . ')>
								' . $c['classroom_name'] . '<i class="fa fa-close cross-icn"></i></button>';
								} else {
									echo '<button type="button" class="btn  btn-md  btn-success del")>
								' . $c['classroom_name'] . '</button>';
								}
							}
						}
						?>
						<div class="form-group">
							<select name="classroom_id[]" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" id="classroom_id" multiple="multiple" data-actions-box="true">
								<option data-subtext="" value="" disabled="disabled">Select Classroom</option>
								<?php
								foreach ($all_classroom as $p) {
									if ($p['active'] != 0) {
										$clssroomProperty = $p['test_module_name'] . '-' . $p['programe_name'] . '-' . $p['Category']['category_name'] . '-' . $p['batch_name'] . '-' . $p['center_name'];
										$selected = in_array($p['id'], $classroom_ids) ? ' selected="selected"' : "";
										echo '<option value="' . $p['id'] . '" ' . $selected . '>' . $p['classroom_name'] . ' / ' . $clssroomProperty . '</option>';
									}
								}
								?>
							</select>
							<span class="text-danger classroom_id_err"><?php echo form_error('classroom_id[]'); ?></span>
						</div>
					</div>
					<?php
					$content_type_id = $this->input->post('content_type_id');
					if (isset($content_type_id)) {
					} else {
						$content_type_id = [];
					}
					//pr($classroom_documents_content_type);
					?>
					<div class="col-md-6">
						<label for="content_type_id" class="control-label">Content Type<span class="text-danger">*</span></label>
						<?php
						if (isset($classroom_documents_content_type) && $classroom_documents_content_type) {
							$docContentTypeCount = count($classroom_documents_content_type);
							foreach ($classroom_documents_content_type as $c) {
								if($docContentTypeCount == 1) {
									echo '<button type="button" class="btn  btn-md  btn-info del">
               				  ' . $c['content_type_name'] .'</button>';
								}
								else {
									echo '<button type="button" class="btn  btn-md  btn-info del" onclick=deleteClassroomDocumentsContentType(' . $c["classroom_documents_id"] . ',' . $c["id"] . ')>
               				  ' . $c['content_type_name'] . '<i class="fa fa-close cross-icn"></i></button>';
								}
							}
						}
						?>
						<div class="form-group">
							<select name="content_type_id[]" id="content_type_id" class="form-control selectpicker selectpicker-ui-100" multiple="multiple" data-actions-box="true" data-live-search="true">
								<option value="" disabled="disabled">Select Content Type</option>
								<?php foreach ($content_type_list as $key => $val) { ?>
									<option value="<?php echo $val['id'] ?>" <?php echo in_array($val['id'], $content_type_id) ? 'selected="selected"' : '' ?>>
										<?php echo $val['content_type_name'] ?></option>
								<?php
								} ?>
							</select>
							<span class="text-danger content_type_id_err"><?php echo form_error('content_type_id[]'); ?></span>
						</div>
					</div>
					<?php
					$title = $this->input->post('title');
					if (empty($title)) {

						$title = $classroom_documents['title'];
					}
					?>
					<div class="col-md-6">
						<label for="zoom_link" class="control-label">Title<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="title" value="<?php echo $title ?>" class="form-control input-ui-100" id="title" maxlength="50" />
							<span class="text-danger title_err"><?php echo form_error('title'); ?></span>

						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1" <?php echo ($classroom_documents['active'] == 1 ? 'checked="checked"' : ''); ?> id='active' />
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

					$total_section = $this->input->post('total_section');
					if (empty($total_section)) {

						$total_section = $classroom_documents['total_section'];
					}
					if ($total_section == "") {
						$total_section = 0;
					}
					?>
					<input type="hidden" name="total_section" id="total_section" value="<?php echo  $total_section ?>">
					<div id="EmployeeTierId">
						<!--------Time Slot  List-------->
						<?php
						for ($i = 1; $i <= $total_section; $i++) {


							$classroom_documents_section = isset($_POST['classroom_documents_section' . $i]) ? $_POST['classroom_documents_section' . $i] : $classroom_documents_section_list[$i]['section'];


							$old_section = $classroom_documents_section_list[$i]['section'];

							$section_no = isset($_POST['section_no' . $i]) ? $this->input->post('section_no' . $i) : $classroom_documents_section_list[$i]['section_number'];
							$section_type = isset($_POST['section_type' . $i]) ? $this->input->post('section_type' . $i) : $classroom_documents_section_list[$i]['type'];



						?>
							<div class="col-md-12 ClassroomDocumentsDiv" id="ClassroomDocumentsDiv-<?php echo $i ?>">
								<div class="col-md-2">
									<label class="control-label"><span class="sn"><?php echo ucfirst($section_type); ?></span> Section </label>
									<div class="form-group">
										<input type="text" name="section_no<?php echo $i ?>" id="section_no<?php echo $i ?>" class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))" value="<?php echo $section_no ?>" />
										<span class="text-danger section_no<?php echo $i ?>_err"></span>
										<input type="hidden" class="section_type" value="<?php echo $section_type ?>" name="section_type<?php echo $i ?>" id="section_type<?php echo $i ?>">


									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<?php
										if ($section_type == 'text') {
											$old_section = '';
										?>
											<span class="text-danger classroom_documents_section<?php echo $i ?>_err" id="classroom_documents_section<?php echo $i ?>_err">*</span>
											<textarea rows="4" cols="100" placeholder="Add Text" class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i ?>" name="classroom_documents_section<?php echo $i ?>"><?php echo $classroom_documents_section ?></textarea>
											<span class="text-danger classroom_documents_section<?php echo $i ?>_err"></span>
										<?php
										} else if ($section_type == 'image') {
										?>
											<div>
												<div class="col-md-6">
													<?php if (!empty($old_section)) { ?>
														<img src="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH . $old_section); ?>" height="150" width="150" id="previewImg<?php echo $i ?>" class="previewImg">
													<?php
													} else { ?>
														<img src="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH . 'no-image.png'); ?>" height="150" width="150" id="previewImg<?php echo $i ?>" class="previewImg">
													<?php } ?>
												</div>
												<div class="col-md-6">
													<input type="file" id="classroom_documents_section<?php echo $i ?>" name="classroom_documents_section<?php echo $i ?>" class="form-control classroom_documents_section" value="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH . $old_section); ?>" onchange="isImage('<?php echo $i ?>')" />[Allowed: webp]
													<input type="hidden" id="old_classroom_documents_section<?php echo $i ?>" value="<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH . $old_section); ?>" />
													<span class="text-danger classroom_documents_section<?php echo $i ?>_err"></span>
												</div>
											</div>
										<?php
										} else if ($section_type == 'video') {
										?>
											<div>

												<div class="col-md-6">
													<?php if (!empty($old_section)) { ?>
														<video controls id="previewVideo<?php echo $i ?>" height="150" width="150" class="previewVideo" src="<?php echo site_url(CLASSROOM_DOCUMENTS_VIDEO_PATH . $old_section); ?>"></video>
													<?php
													} else { ?>
														<video controls id="previewVideo<?php echo $i ?>" height="150" width="150" class="previewVideo"></video>
													<?php
													} ?>

												</div>
												<div class="col-md-6">
													<input type="file" class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i ?>" name="classroom_documents_section<?php echo $i ?>" onchange="isVideo('<?php echo $i ?>')" />[Allowed: MP4, WebM,Ogg]
													<span class="text-danger classroom_documents_section<?php echo $i ?>_err"></span>
													<input type="hidden" id="old_classroom_documents_section<?php echo $i ?>" value="<?php echo site_url(CLASSROOM_DOCUMENTS_VIDEO_PATH . $old_section); ?>" />
												</div>
											</div>
										<?php
										} else if ($section_type == 'audio') {
										?>
											<div>
												<div class="col-md-6">

													<?php if (!empty($old_section)) { ?>
														<audio controls id="previewAudio<?php echo $i ?>" class="previewAudio" src="<?php echo site_url(CLASSROOM_DOCUMENTS_AUDIO_PATH . $old_section); ?>"></audio>

													<?php
													} else { ?>
														<audio controls id="previewAudio<?php echo $i ?>" class="previewAudio"></audio>
													<?php
													} ?>
												</div>
												<div class="col-md-6">
													<input type="file" class="form-control classroom_documents_section" id="classroom_documents_section<?php echo $i ?>" name="classroom_documents_section<?php echo $i ?>" onchange="isAudio('<?php echo $i ?>')" />[Allowed: MP3, WAV,OGG]
													<span class="text-danger classroom_documents_section<?php echo $i ?>_err"></span>
													<input type="hidden" id="old_classroom_documents_section<?php echo $i ?>" value="<?php echo site_url(CLASSROOM_DOCUMENTS_AUDIO_PATH . $old_section); ?>" />
												</div>
											</div>
										<?php
										} ?>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="button" class="btn btn-md btn-danger remove-div" style="margin-right:10px;" onclick="removeRow('<?php echo $i ?>')">
											<i class="fa fa-minus" aria-hidden="true"></i>
										</button>
									</div>
								</div>
							</div>
							<input type="hidden" class="old_section" value="<?php echo $old_section ?>" name="old_section<?php echo $i ?>" id="old_section<?php echo $i ?>">
						<?php
						} ?>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger rd-20">
						<i class="fa fa-check"></i> <?php echo UPDATE_LABEL; ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
			<!---EmployeeTierId Data --->
			<div id="EmployeeTierIdData" style="display:none">
				<div class="col-md-12 ClassroomDocumentsDiv">
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label"><span class="sn">Text</span> Section </label>
							<div class="form-group">
								<input type="text" name="" class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))" />
								<span class="text-danger "></span>
								<input type="hidden" class="section_type" value="text">
								<input type="hidden" class="old_section">
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group section">
							<textarea rows="4" cols="100" placeholder="Add Text" class="form-control classroom_documents_section"></textarea>
							<span class="text-danger"></span>
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
<?php ob_start(); ?>
<script>
	$('#classroomdoc_edit_form').on('submit', function(e) {
		e.preventDefault();
		var flag = 1;
		var classroom_id = $('#classroom_id').val();
		var content_type_id = $('#content_type_id').val();
		var title = $('#title').val();
		var total_section = $('#total_section').val();
		var section_no1 = $('#section_no1').val();

		var classroom_documents_class = '<?php echo count($classroom_documents_class);  ?>';
		var classroom_documents_content_type = '<?php echo count($classroom_documents_content_type);  ?>';
		if (classroom_id == "" && classroom_documents_class == 0) {
			$(".classroom_id_err").html('The Classroom field is required.');
			flag = 0;
		} else {
			$(".classroom_id_err").html('');
		}

		if (content_type_id == "" && classroom_documents_content_type == 0) {
			$(".content_type_id_err").html('The Content Type field is required.');
			flag = 0;
		} else {
			$(".content_type_id_err").html('');
		}

		if (title == "") {
			$(".title_err").html('The Title field is required.');
			flag = 0;
		} else {
			$(".title_err").html('');
		}



		var flg = 0;
		$(".section_no").each(function(i) {
			if ($(this).val() > 0) {
				flg = 1;
			}
		});
		if (flg == 0) {
			$("#comm_err").text("Please add at least one option text, image, video or audio");
			//return false;		
		} else {
			$("#comm_err").text("");
			//return true;
		}
		var total_section = $("#total_section").val();
		if (total_section == 0) {
			flag = 0;
		}
		if (total_section == 0) {
			flag = 0;
		}
		for (i = 1; i <= total_section; i++) {
			var section_no1 = $('#section_no' + i).val();
			if (section_no1 == "") {
				$(".section_no" + i + '_err').html('The Text Section field is required.');
				$("#comm_err").text("");
				flag = 0;
			} else {
				$(".section_no" + i + '_err').html('');
			}

			if (typeof CKEDITOR.instances["classroom_documents_section" + i] !== 'undefined' && CKEDITOR.instances["classroom_documents_section" + i].getData().replace(/(<([^>]+)>)/ig, "").trim() == "") {
				$('.classroom_documents_section' + i + "_err").html('The Text field is required.');
				flag = 0;
				$("#comm_err").text("");
			} else if (($('#old_classroom_documents_section' + i).val() == "" || $('#old_classroom_documents_section' + i).val() == undefined) && $('#classroom_documents_section' + i).attr("type") == "file") {


				if ($('#classroom_documents_section' + i).val() == "") {
					$('.classroom_documents_section' + i + "_err").html('The File Input is required.');
					$("#comm_err").text("");
					flag = 0;
				} else {
					$('.classroom_documents_section' + i + "_err").html('');
					// $("#comm_err").text("");
					// flag=1;
				}
			}

			/* else if(($('#classroom_documents_section'+i).val()=="" &&  $('#classroom_documents_section'+i).attr("type") == "file")) {				
				$('.classroom_documents_section'+i+"_err").html('The File Input is required.');
			     $("#comm_err").text("");
				 flag=0;
				
			} */
			else {
				$('.classroom_documents_section' + i + "_err").html("");
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

		if(classroom_documents_section1.nodeName.toLowerCase() === 'textarea' ) {
	
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
			
 if($('#classroom_documents_section1').val() == "" && ($('#old_classroom_documents_section').val()=="" || $('#old_classroom_documents_section1').val()  === undefined ))
		  {
			
			flag=0;
			$(".classroom_documents_section1_err").html('The File Input is required.');
			$("#comm_err").text("");
		  }
		  else {
			$(".classroom_documents_section1_err").html('');
		  }
		} */

		if (flag == 1) {
			this.submit();
		}
	});
</script>

<script>
	function deleteClassroomDocumentsClass(classroom_documents_id, classroom_id) {
		$.ajax({
			url: "<?php echo site_url('adminController/classroom_documents/ajax_delete_classroom_documents_class'); ?>",
			async: true,
			type: 'post',
			data: {
				classroom_documents_id: classroom_documents_id,
				classroom_id: classroom_id
			},
			dataType: 'json',
			success: function(response) {
				if (response == 1) {
					window.location.href = window.location.href
				}
			}
		});
	}

	function deleteClassroomDocumentsContentType(classroom_documents_id, content_type_id) {
		$.ajax({
			url: "<?php echo site_url('adminController/classroom_documents/ajax_delete_classroom_documents_content_type'); ?>",
			async: true,
			type: 'post',
			data: {
				classroom_documents_id: classroom_documents_id,
				content_type_id: content_type_id
			},
			dataType: 'json',
			success: function(response) {
				if (response == 1) {
					window.location.href = window.location.href
				}
			}
		});
	}
	var DEMO_IMAGE_URL = '<?php echo site_url(CLASSROOM_DOCUMENTS_IMAGE_PATH . "no-image.png"); ?>';

	function AddRow(type) {

		var employeeTierIdDataHtml = $("#EmployeeTierIdData").html();
		$("#EmployeeTierId").append(employeeTierIdDataHtml);
		var total = $("#EmployeeTierId .ClassroomDocumentsDiv").length;

		i = 1;
		$("#EmployeeTierId .ClassroomDocumentsDiv").each(function() {

			$(this).attr('id', 'ClassroomDocumentsDiv-' + i);
			$(this).find('.remove-div').attr('onclick', 'removeRow("' + i + '")');
			$(this).find('.classroom_documents_section').attr('name', 'classroom_documents_section' + i);
			$(this).find('.classroom_documents_section').attr('id', 'classroom_documents_section' + i);

			$(this).find('.section_no').attr('name', 'section_no' + i);
			$(this).find('.section_no').attr('id', 'section_no' + i);
			$(this).find('.section_type').attr('name', 'section_type' + i);
			$(this).find('.section_type').attr('id', 'section_type' + i);
			$(this).find('.old_section').attr('name', 'old_section' + i);
			$(this).find('.old_section').attr('id', 'old_section' + i);
			$(this).find('.section_no').next("span").addClass('section_no' + i + '_err');
			$(this).find('.previewImg').attr('id', 'previewImg' + i);
			$(this).find('.previewVideo').attr('id', 'previewVideo' + i);
			$(this).find('.previewAudio').attr('id', 'previewAudio' + i);
			if (i == total) {

				$(this).find('.sn').text(type);
				$(this).find('.sn').css('text-transform', 'capitalize');
				$(this).find('.section_type').val(type);
				html = '';
				if (type == 'text') {
					    CKEDITOR.replace('classroom_documents_section'+i);
					//checkWordCountCkEditor('classroom_documents_section' + i);
					$(this).find('#classroom_documents_section' + i).next("span").addClass('classroom_documents_section' + i + '_err');
				} else if (type == 'image') {
					var id = 'classroom_documents_section' + i;
					var imgid = 'previewImg' + i;
					html = '<div><div class="col-md-6"><img src="' + DEMO_IMAGE_URL + '" height="150" width="150" id="' + imgid + '" class="previewImg"></div><div class="col-md-6">';
					html += '<input type="file"  id="' + id + '" name="' + id + '" class="form-control classroom_documents_section" onchange="isImage(' + i + ')"/>[Allowed: webp]<span class="text-danger ' + id + '_err"></span></div></div>';
					$(this).find('.section').html(html);


				} else if (type == 'video') {
					var id = 'classroom_documents_section' + i;
					var vid = 'previewVideo' + i;
					html = '<div><div class="col-md-6"><video controls  id="' + vid + '" height="150" width="150" class="previewVideo"></video></div><div class="col-md-6">';
					html += '<input type="file"  id="' + id + '" name="' + id + '" class="form-control classroom_documents_section" onchange="isVideo(' + i + ')"/>[Allowed: MP4, WebM,Ogg]<span class="text-danger ' + id + '_err"></span> </div></div>';
					$(this).find('.section').html(html);
				} else if (type == 'audio') {

					var id = 'classroom_documents_section' + i;
					var vid = 'previewAudio' + i;
					html = '<div><div class="col-md-6"><audio controls  id="' + vid + '" height="150" width="150" class="previewAudio"></audio></div><div class="col-md-6">';
					html += '<input type="file" id="' + id + '" name="' + id + '" class="form-control classroom_documents_section" onchange="isAudio(' + i + ')"/>[Allowed: MP3, WAV,OGG]<span class="text-danger ' + id + '_err"></span> </div></div>';
					$(this).find('.section').html(html);
				}

			}
			i++;
		});
		var length = $("#EmployeeTierId .ClassroomDocumentsDiv").length;
		$("#total_section").val(length);
	}


	function removeRow(j) {

		$("#ClassroomDocumentsDiv-" + j).remove();
		var total_section = $("#total_section").val();
		var i = 1;
		$("#EmployeeTierId .ClassroomDocumentsDiv").each(function() {

			$(this).attr('id', 'ClassroomDocumentsDiv-' + i);
			$(this).find('.remove-div').attr('onclick', 'removeRow("' + i + '")');
			$(this).find('.classroom_documents_section').attr('name', 'classroom_documents_section' + i);
			$(this).find('.classroom_documents_section').attr('id', 'classroom_documents_section' + i);
			$(this).find('.classroom_documents_section').next().next().attr('class', 'text-red classroom_documents_section' + i + '_err');
			$(this).find('.section_type').attr('name', 'section_type' + i);
			type = $(this).find('.section_type').val();
			//$(this).find('.classroom_documents_section').next().attr('id','cke_classroom_documents_section'+i);

			if (type == 'text') {
				/* var editor = CKEDITOR.instances['classroom_documents_section' + total_section];
				if (editor) {
					editor.destroy(true);
				} */
				CKEDITOR.replace('classroom_documents_section'+i);
				//checkWordCountCkEditor('classroom_documents_section' + i);
				$(this).find('#classroom_documents_section' + i).next("span").addClass('classroom_documents_section' + i + '_err');
			} else if (type == 'image') {

				$(this).find('.classroom_documents_section').attr('onchange', 'isImage("' + i + '")');
				$(this).find('.classroom_documents_section').next().attr('class', 'text-red classroom_documents_section' + i + '_err');

			} else if (type == 'video') {
				$(this).find('.classroom_documents_section').attr('onchange', 'isVideo("' + i + '")');
				$(this).find('.classroom_documents_section').next().attr('class', 'text-red classroom_documents_section' + i + '_err');
			} else if (type == 'audio') {
				$(this).find('.classroom_documents_section').attr('onchange', 'isAudio("' + i + '")');
				$(this).find('.classroom_documents_section').next().attr('class', 'text-red classroom_documents_section' + i + '_err');
			}
			$(this).find('.section_no').attr('name', 'section_no' + i);
			$(this).find('.section_no').attr('id', 'section_no' + i);
			$(this).find('.section_no').next("span").attr('class', 'text-red section_no' + i + '_err');
			$(this).find('.section_type').attr('name', 'section_type' + i);
			$(this).find('.previewImg').attr('id', 'previewImg' + i);
			$(this).find('.previewVideo').attr('id', 'previewVideo' + i);
			$(this).find('.previewAudio').attr('id', 'previewAudio' + i);
			i++;
		});

		var length = $("#EmployeeTierId .ClassroomDocumentsDiv").length;
		$("#total_section").val(length);
	}


	function checkSectionNumber(section_no) {

		section_no_val = section_no.val().replace(/[^0-9\.]/g, '');
		section_no_val = section_no_val.replace(/^0+/, '');
		if (section_no_val.length == 1 && section_no_val == 0) {
			section_no_val = section_no.val().replace(/[^1-9\.]/g, '');
		}
		if (section_no == '') {
			section_no.val(section_no_val);
			return false;
		}
		section_no.val(section_no_val);
		$("#EmployeeTierId .section_no").removeClass('cr');
		section_no.addClass("cr");
		var allReadyAdd = false;
		$("#EmployeeTierId .section_no").each(function() {

			cr_section_no = $(this).val();
			if ($(this).hasClass('cr')) {
				//Cruent Text Boox
			} else {
				if (section_no_val != '' && cr_section_no == section_no_val) {
					section_no.val('');
					allReadyAdd = true;
				}
			}
		});
		if (allReadyAdd) {
			return false;
		}
	}

	function updateCkEditer() {
		var i = 1;
		$("#EmployeeTierId .ClassroomDocumentsDiv").each(function() {
			type = $(this).find('.section_type').val();
			if (type == 'text') {
				 CKEDITOR.replace('classroom_documents_section'+i);
				//checkWordCountCkEditor('classroom_documents_section' + i);
			}
		});
		i++;
	}

	function imagePreview(id) {
		var file = $('#' + id)[0].files[0];
		size = file.size;
		type = file.type;
		name = file.name;
		//return file['type'].split('/')[0]=='image');//returns true or false 
		FREE_RESOURCES_IMAGE_TYPES = '<?php echo WEBP_FILE_TYPES ?>';
		FREE_RESOURCES_IMAGE_TYPES = FREE_RESOURCES_IMAGE_TYPES.split("|");
		var type = type.replace('image/', '');
		//console.log(FREE_RESOURCES_IMAGE_TYPES);

		if (FREE_RESOURCES_IMAGE_TYPES.includes(type)) {

			var reader = new FileReader();
			reader.onload = function() {
				$("#thumbnailPreview").attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		} else {
			alert('Allowed type only: <?php echo WEBP_FILE_TYPES ?>');
			$('#classroom_documents_section' + i).val('');
			$("#thumbnailPreview").attr("src", DEMO_IMAGE_URL);;
		}

	}

	function isImage(i) {

		var file = $('#classroom_documents_section' + i)[0].files[0];
		size = file.size;
		type = file.type;
		name = file.name;
		//return file['type'].split('/')[0]=='image');//returns true or false 
		FREE_RESOURCES_IMAGE_TYPES = '<?php echo WEBP_FILE_TYPES ?>';
		FREE_RESOURCES_IMAGE_TYPES = FREE_RESOURCES_IMAGE_TYPES.split("|");
		var type = type.replace('image/', '');
		//console.log(FREE_RESOURCES_IMAGE_TYPES);

		if (FREE_RESOURCES_IMAGE_TYPES.includes(type)) {

			var reader = new FileReader();

			reader.onload = function() {

				$("#previewImg" + i).attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		} else {
			alert('Allowed type only: <?php echo WEBP_FILE_TYPES ?>');
			$('#classroom_documents_section' + i).val('');
			$("#previewImg" + i).attr("src", DEMO_IMAGE_URL);;
		}

	}

	function isVideo(i) {

		var file = $('#classroom_documents_section' + i)[0].files[0];
		size = file.size;
		type = file.type;
		name = file.name;
		//return file['type'].split('/')[0]=='image');//returns true or false 
		FREE_RESOURCES_VIDEO_TYPES = '<?php echo FREE_RESOURCES_VIDEO_TYPES ?>';
		FREE_RESOURCES_VIDEO_TYPES = FREE_RESOURCES_VIDEO_TYPES.split("|");
		var type = type.replace('video/', '');
		//console.log(FREE_RESOURCES_IMAGE_TYPES);

		if (FREE_RESOURCES_VIDEO_TYPES.includes(type)) {

			var reader = new FileReader();
			reader.onload = function() {
				$("#previewVideo" + i).attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		} else {
			alert('Allowed type only: <?php echo FREE_RESOURCES_VIDEO_TYPES ?>');
			$('#classroom_documents_section' + i).val('');
			$("#previewVideo" + i).attr("src", '');
		}

	}

	function isAudio(i) {

		var file = $('#classroom_documents_section' + i)[0].files[0];
		size = file.size;
		type = file.type;
		name = file.name;
		//return file['type'].split('/')[0]=='image');//returns true or false 
		FREE_RESOURCES_AUDIO_TYPES = '<?php echo FREE_RESOURCES_AUDIO_TYPES ?>';
		FREE_RESOURCES_AUDIO_TYPES = FREE_RESOURCES_AUDIO_TYPES.split("|");
		var type = type.replace('audio/', '');
		//console.log(FREE_RESOURCES_IMAGE_TYPES);

		if (FREE_RESOURCES_AUDIO_TYPES.includes(type)) {

			var reader = new FileReader();
			reader.onload = function() {
				$("#previewAudio" + i).attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		} else {
			alert('Allowed type only: <?php echo FREE_RESOURCES_AUDIO_TYPES ?>');
			$('#classroom_documents_section' + i).val('');
			$("#previewAudio" + i).attr("src", '');
		}


	}
</script>

<?php global $customJs;
$customJs = ob_get_clean();
?>