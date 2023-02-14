<style type="text/css">
.del {
font-size: 12px;
padding:3px 10px 3px 10px!important;
margin-left: 5px;
margin-bottom: 5px;
}

.cross-icn{
position: absolute;
margin-top: -7px;
padding: 2px 0px;
border-radius: 10px;
}
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?> </h3>
              	<div class="box-tools pull-right">
                  <a href="<?php echo site_url('adminController/Free_resources/index'); ?>" class="btn btn-danger btn-sm">Free Resources List</a>
               </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php 
			
			$attributes = ['name' => 'freeresourse_edit_form', 'id' => 'freeresourse_edit_form'];
		   echo form_open_multipart('adminController/Free_resources/edit/'.$free_resources['id'],$attributes);
		
			?>
			<input type="hidden"  value="<?php echo $free_resources['id'];?>" name="hid_id" id="hid_id"/>
			<!-- <form action="<?php echo site_url();?>adminController/Free_resources/edit/<?php echo $free_resources['id']?>" method="post" enctype="multipart/form-data" onsubmit="return valiform();"> -->
			<?php 	
			    $content_type_id=$this->input->post('content_type_id');
				if(empty($content_type_id)){
					
				    $content_type_id=$free_resources['content_type_id'];
				}
				
			?>
          	<div class="box-body">
          		
					<div class="col-md-4">
						<label for="content_type_id" class="control-label">Content Type<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="content_type_id" id="content_type_id" class="form-control selectpicker selectpicker-ui-100">
							<option value="">Select Content Type</option>
							<?php foreach($content_type_list as $key=>$val){?>
								<option value="<?php echo $val['id']?>" <?php echo $val['id']==$content_type_id ? 'selected="selected"':''?>>
								<?php echo $val['content_type_name']?></option>
								<?php 
								}?>	
							</select>						
							<span class="text-danger content_type_id_err"><?php echo form_error('content_type_id');?></span>
						</div>
					</div>
					<?php 	
			            $title=$this->input->post('title');
						if(empty($title)){
					
				            $title=$free_resources['title'];
				        }
			        ?>
                     <div class="col-md-4">
						<label for="zoom_link" class="control-label">Title<span class="text-danger">*</span></label>
						<div class="form-group">
                            <input type="text" name="title" value="<?php echo $title ?>" class="form-control input-ui-100" id="title" maxlength="50"/>
							<span class="text-danger title_err"><?php echo form_error('title');?></span>
							
						</div>
					</div>
                    <div class="col-md-4">
						
						<div class="form-group">
							<div class="row">
						    <div class="col-md-3">
							<?php if($free_resources['image']){ ?>
                                <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.$free_resources['image']);?>"  height="85" width="85" id="thumbnailPreview" class="thumbnailPreview photo-border" style="position:absolute;">
                            <?php }else{ ?>
                                <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.'no-image.png');?>"  height="85" width="85" id="thumbnailPreview" class="thumbnailPreview photo-border">
                            <?php } ?>
							<input type="hidden" name="old_image" id="old_image" value="<?php echo $free_resources['image']?>">
							</div>
							<div class="col-md-9">
							<label for="image" class="control-label">Upload Thumbnail <?php echo WEBP_ALLOWED_TYPES_LABEL;?><span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control input-ui-100" id="image"  
							onchange="validate_file_type_Webp(this.id)"/>
							<span class="text-danger image_err"><?php echo form_error('image');?>
							</div>
							</span>
						</div>
						</div>
					</div>						
					<?php 	
			            $free_resources_test=$this->input->post('free_resources_test[]');
						#pr($time_slots);
						
			        ?>
					<div class="col-md-6 margin-bottom-20">
						<label for="event_title" class="control-label"><span class="text-danger">*</span>Url Slug</label>
						<div class="form-group">
						<input type="text" name="URLslug" value="<?php echo ($this->input->post('URLslug') ? $this->input->post('URLslug') : $free_resources['URLslug']); ?>" class="form-control input-ui-100 removeerrmessage allow_url_slug" id="URLslug" placeholder="URL" onKeyPress="return noNumbers(event)" maxlength="140" autocomplete="off" onchange="checkUrl('freeresourse',this.id)" onpaste="return false" />
						<span class="text-danger URLslug_err"><?php echo form_error('URLslug'); ?></span>
						</div>
					</div>	
                    <div class="col-md-6">
						<label for="free_resources_test" class="control-label">Test Type<span class="text-danger">*</span></label>
						<?php
							foreach ($free_resources_test_list as $c) {
							echo '<button type="button" class="btn btn-md btn-info del" onclick=deletefreeResourcesTestType('.$c["free_resources_id"].','.$c["topic_id"].')>
               				'.$c['topic'].'<i class="fa fa-close cross-icn"></i></button>';
						 } 
						?>
						<div class="form-group">
					    <select name="free_resources_topic[]" id="free_resources_topic" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Test Type<span class="text-danger">*</span></option>
								<?php 								
                                //$free_resources_test_list=explode(', ',$free_resources_test_list);
								foreach($topic_list as $key=>$b)
								{
								    $selected='';
								
									echo '<option value="'.$b['topic_id'].'" '.$selected.'>'.$b['topic'].'</option>';									
								} 
								?>
							</select>
							<span class="text-danger free_resources_topic_err"><?php echo form_error('free_resources_topic[]');?></span>
						</div>
					</div>
					<?php 	
			            $description=$this->input->post('description');
						if(empty($description)){
					
				            $description=$free_resources['description'];
				        }
			        ?>
                     <div class="col-md-12">
						<label for="zoom_link" class="control-label">Description<span class="text-danger">*</span></label>
						<div class="form-group">
						    <textarea id="description" name="description" rows="4" cols="163" placeholder="description..." class=" form-control" maxlength="100"><?php echo $description ?></textarea>
							<span class="text-danger description_err"><?php echo form_error('description');?></span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form-checkbox">						
							<input type="checkbox" name="active" value="1" <?php echo ($free_resources['active']==1 ? 'checked="checked"' : ''); ?> id='active'/>	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group form-checkbox">
						
							<input type="checkbox" name="isPinned" <?php echo ($free_resources['isPinned']==1 ? 'checked="checked"' : ''); ?>  id="isPinned"/>
							<label for="isPinned" class="control-label">Is Featured?</label>
						</div>
						
					</div>
					<div class="row" style="margin-bottom:20px;margin-top:30px;">
					<div class="col-md-12">
					<div class="text-danger" id="comm_err" style="margin-bottom: 10px;    margin-left: 10px;"></div>
					<div class="col-md-3">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('text')">
					   <i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Text
					</div>
					<div class="col-md-3">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('image')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Image </label>
					</div>
					<div class="col-md-3">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('video')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Video </label>
					</div>
					<div class="col-md-3">
					   <button type="button" class="btn btn-sm btn-success" style="margin-right:10px;" onclick="AddRow('audio')"><i class="fa fa-plus" aria-hidden="true"></i>
                       </button>
					   <label class="control-label">Add Audio </label> </label>
					</div>
					</div>
					</div>
					
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
					        
							$free_resources_section=isset($_POST['free_resources_section'.$i]) ? $_POST['free_resources_section'.$i]:$free_resources_section_list[$i]['section'];
							
							$old_section=$free_resources_section_list[$i]['section'];
							
							$section_no=isset($_POST['section_no'.$i]) ? $this->input->post('section_no'.$i):$free_resources_section_list[$i]['section_number'];
							$section_type=isset($_POST['section_type'.$i]) ? $this->input->post('section_type'.$i):$free_resources_section_list[$i]['type'];
							
							
							
						?>
							<div class="col-md-12 employeeTierDiv sec-bg" id="employeeTierDiv-<?php echo $i?>">
								<div class="col-md-2">
										<label  class="control-label"><span class="sn"><?php $section_type?></span> Section </label>
										<div class="form-group">
										   <input type="text" name="section_no<?php echo $i?>"  id="section_no<?php echo $i?>" class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))"  value="<?php echo $section_no?>"/>
										   <span class="text-danger section_no<?php echo $i?>_err"></span>
										   <input type="hidden" class="section_type" value="<?php echo $section_type?>"   name="section_type<?php echo $i?>"  id="section_type<?php echo $i?>">
										   
										    							   
										</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
									    <?php 
										if($section_type=='text'){
                                            $old_section='';											
										?>
	                                     <textarea  rows="4" cols="100" placeholder="Add Text" class="form-control free_resources_section" id="free_resources_section<?php echo $i?>" name="free_resources_section<?php echo $i?>"><?php echo $free_resources_section?></textarea>
										 <span class="text-danger free_resources_section<?php echo $i?>_err"></span>
										<?php 
										} else if($section_type=='image'){
										?>
					               <div>
								   <div class="col-md-6">
								     <?php if(!empty($old_section)){?>
								     <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.$old_section);?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
									 <?php 
									 }else{?>
									  <img src="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.'no-image.png');?>" height="150" width="150" id="previewImg<?php echo $i?>" class="previewImg">
									  
									 <?php }?>
								   </div>
								  <div class="col-md-6">
					              <input type="file" id="free_resources_section<?php echo $i?>" name="free_resources_section<?php echo $i?>" class="form-control free_resources_section" value="<?php echo site_url(FREE_RESOURCES_IMAGE_PATH.$old_section);?>" onchange="isImage('<?php echo $i?>')"/>[Allowed: jpg, png,jpeg]
								  <span class="text-danger free_resources_section<?php echo $i?>_err"></span>
								  <input  type="hidden" id="old_free_resources_section<?php echo $i?>" value="<?php echo site_url(FREE_RESOURCES_VIDEO_PATH.$old_section);?>"/>  
								</div>
                                   </div>
									<?php 
									}else if($section_type=='video'){
									?>
                                   <div > 
								  
								    <div class="col-md-6">
									  <?php if(!empty($old_section)){?>
									    <video controls  id="previewVideo<?php echo $i?>" height="150" width="150" class="previewVideo"src="<?php echo site_url(FREE_RESOURCES_VIDEO_PATH.$old_section);?>"></video>
										
									 <?php 
									 }else{?>
									  <video controls  id="previewVideo<?php echo $i?>" height="150" width="150" class="previewVideo"></video>
									 <?php 
									 }?>
								    
								    </div>
								   <div class="col-md-6">
					                    <input type="file"  class="form-control free_resources_section" id="free_resources_section<?php echo $i?>" name="free_resources_section<?php echo $i?>" onchange="isVideo('<?php echo $i?>')" />[Allowed: MP4, WebM,Ogg]	
										<span class="text-danger free_resources_section<?php echo $i?>_err"></span>
										<input  type="hidden" id="old_free_resources_section<?php echo $i?>" value="<?php echo site_url(FREE_RESOURCES_VIDEO_PATH.$old_section);?>"/>
                                </div>
								</div>
								<?php
								}else if($section_type=='audio'){
										?>
								<div>
								 <div class="col-md-6">
								
								 <?php if(!empty($old_section)){?>
									     <audio controls  id="previewAudio<?php echo $i?>" class="previewAudio"src="<?php echo site_url(FREE_RESOURCES_AUDIO_PATH.$old_section);?>"></audio>
										
									 <?php 
									 }else{?>
									   <audio controls  id="previewAudio<?php echo $i?>" class="previewAudio"></audio>
									 <?php 
									 }?>
								 </div>
								<div class="col-md-6">
					              <input type="file"  class="form-control free_resources_section" id="free_resources_section<?php echo $i?>" name="free_resources_section<?php echo $i?>"  onchange="isAudio('<?php echo $i?>')"/>[Allowed: MP3, WAV,OGG]
								  <span class="text-danger free_resources_section<?php echo $i?>_err"></span> 
								  <input type="hidden" id="old_free_resources_section<?php echo $i?>" value="<?php echo site_url(FREE_RESOURCES_AUDIO_PATH.$old_section);?>"/>  
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
							<input type="hidden" class="old_section" value="<?php echo $old_section?>" name="old_section<?php echo $i?>" id="old_section<?php echo $i?>">
						<?php 
						}?>
					</div>
		
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20 submit_btn">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
				</div>
          	</div>
            <?php echo form_close(); ?>
			<!---EmployeeTierId Data --->
			<div id="EmployeeTierIdData" style="display:none">
				<div class="col-md-12 employeeTierDiv">
				   <div class="col-md-2">
						<div class="form-group">
							<label  class="control-label"><span class="sn">Text</span> Section </label>
							<div class="form-group">
							   <input type="text" name=""  class="form-control chknum1 section_no" placeholder="section number" onchange="checkSectionNumber($(this))" />
							   <span class="text-danger "></span>		
                               <input type="hidden" class="section_type" value="text"> 
							   <input type="hidden" class="old_section">							   
							</div>
					    </div>
				    </div>
					<div class="col-md-8">
						<div class="form-group section">
			            <textarea  rows="4" cols="100" placeholder="Add Text" class="form-control free_resources_section"></textarea>
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

<?php ob_start(); ?>
<script>
$('#freeresourse_edit_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;		
		var content_type_id=$('#content_type_id').val();
		var title=$('#title').val();
		var image=$('#image').val();
		var free_resources_topic=$('#free_resources_topic').val();
		var total_section=$('#total_section').val();
		var description=$('#description').val();
		var section_no1=$('#section_no1').val();
		
		var old_image=$('#old_image').val();
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

		if(old_image =="" && image == "")
		{			
			$(".image_err").html('The Image field is required.');
			flag=0;
		} else { $(".image_err").html(''); }
		var oldFreeResource = '<?php echo count($free_resources_test_list);  ?>';
		if(free_resources_topic == "" && oldFreeResource == 0)
		{			
			$(".free_resources_topic_err").html('The Topic field is required.');
			flag=0;
		} else { $(".free_resources_topic_err").html(''); }

		if(description == "")
		{			
			$(".description_err").html('The Topic field is required.');
			flag=0;
		} else { $(".description_err").html(''); }		
		

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
          
			if(typeof CKEDITOR.instances["free_resources_section"+i] !== 'undefined' && CKEDITOR.instances["free_resources_section"+i].getData().replace(/(<([^>]+)>)/ig,"").trim() == "") {	
				$('.free_resources_section'+i+"_err").html('The Text field is required.');
				flag=0;
				$("#comm_err").text("");
			}
			else if(($('#old_free_resources_section'+i).val()=="" || $('#old_free_resources_section'+i).val()==undefined) &&  $('#free_resources_section'+i).attr("type") == "file") {	

				if($('#free_resources_section'+i).val() =="")
				{
					$('.free_resources_section'+i+"_err").html('The File Input is required.');
				 $("#comm_err").text("");
				 flag=0;
				}
				else{
					$('.free_resources_section'+i+"_err").html('');
				// $("#comm_err").text("");
				// flag=1;
				}				
			}		
			else {
				$('.free_resources_section'+i+"_err").html("");
				//flag=1;
				
			}	
		}	

		if(flag == 1)
		{
			this.submit();			
		} 
       
    });
	</script>
<script>
	
    function deletefreeResourcesTestType(free_resources_id,test_module_id){
        $.ajax({
            url: "<?php echo site_url('adminController/Free_resources/ajax_delete_free_resources_test');?>",
            async : true,
            type: 'post',
            data: {free_resources_id:free_resources_id, test_module_id:test_module_id},
            dataType: 'json',
            success: function(response){
                if(response==1){
                    window.location.href=window.location.href
                }             
            }
        });
    }
	var DEMO_IMAGE_URL='<?php echo site_url(FREE_RESOURCES_IMAGE_PATH."no-image.png");?>';
	function AddRow(type){
		
		var employeeTierIdDataHtml=$("#EmployeeTierIdData").html();
		$("#EmployeeTierId").append(employeeTierIdDataHtml);
		var total =$("#EmployeeTierId .employeeTierDiv").length;
		
		i=1;
		$("#EmployeeTierId .employeeTierDiv").each(function(){
			
			$(this).attr('id','employeeTierDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeRow("'+i+'")');
			$(this).find('.free_resources_section').attr('name','free_resources_section'+i);
			$(this).find('.free_resources_section').attr('id','free_resources_section'+i);
			
			$(this).find('.section_no').attr('name','section_no'+i);
			$(this).find('.section_no').attr('id','section_no'+i);
			$(this).find('.section_no').next("span").addClass('section_no'+i+'_err');
			$(this).find('.section_type').attr('name','section_type'+i);
			$(this).find('.section_type').attr('id','section_type'+i);
			$(this).find('.old_section').attr('name','old_section'+i);
			$(this).find('.old_section').attr('id','old_section'+i);
			
			$(this).find('.previewImg').attr('id','previewImg'+i);
			$(this).find('.previewVideo').attr('id','previewVideo'+i);
			$(this).find('.previewAudio').attr('id','previewAudio'+i);
			if(i==total){
				
				$(this).find('.sn').text(type);
			    $(this).find('.sn').css('text-transform', 'capitalize');
				$(this).find('.section_type').val(type);
				html='';
				if(type=='text'){
				   CKEDITOR.replace('free_resources_section'+i);
				   $(this).find('#free_resources_section'+i).next("span").addClass('free_resources_section'+i+'_err');
				}else if(type=='image'){
					 var id='free_resources_section'+i;
					 var imgid='previewImg'+i;
					 html ='<div><div class="col-md-6"><img src="'+DEMO_IMAGE_URL+'" height="150" width="150" id="'+imgid+'" class="previewImg"></div><div class="col-md-6">';
					 html +='<input type="file"  id="'+id+'" name="'+id+'" class="form-control free_resources_section" onchange="isImage('+i+')"/>[Allowed: jpg, png,jpeg]<span class="text-danger '+id+'_err"></span></div></div>';
					 $(this).find('.section').html(html);
					 
				
				}else if(type=='video'){
					 var id='free_resources_section'+i;
					 var vid='previewVideo'+i;
					 html='<div><div class="col-md-6"><video controls  id="'+vid+'" height="150" width="150" class="previewVideo"></video></div><div class="col-md-6">';
					 html +='<input type="file"  id="'+id+'" name="'+id+'" class="form-control free_resources_section" onchange="isVideo('+i+')"/>[Allowed: MP4, WebM,Ogg] <span class="text-danger '+id+'_err"></span></div></div>';
					 $(this).find('.section').html(html);
				}else if(type=='audio'){
					
					 var id='free_resources_section'+i;
					 var vid='previewAudio'+i;
					 html='<div><div class="col-md-6"><audio controls  id="'+vid+'" height="150" width="150" class="previewAudio"></audio></div><div class="col-md-6">';
					 html +='<input type="file" id="'+id+'" name="'+id+'" class="form-control free_resources_section" onchange="isAudio('+i+')"/>[Allowed: MP3, WAV,OGG]<span class="text-danger '+id+'_err"></span></div></div>';
					 $(this).find('.section').html(html);
				}
			    
			}
			i++;
		});
		var length =$("#EmployeeTierId .employeeTierDiv").length;
		$("#total_section").val(length);
	}
	
	function removeRow(j){
		
		$("#employeeTierDiv-"+j).remove();
		var i=1;
		$("#EmployeeTierId .employeeTierDiv").each(function(){
			
			$(this).attr('id','employeeTierDiv-'+i);
			$(this).find('.remove-div').attr('onclick','removeRow("'+i+'")');
			$(this).find('.free_resources_section').attr('name','free_resources_section'+i);
			$(this).find('.free_resources_section').attr('id','free_resources_section'+i);
			$(this).find('.section_type').attr('name','section_type'+i);
			type=$(this).find('.section_type').val();
			
			if(type=='image'){
				$(this).find('.free_resources_section').attr('onchange','isImage("'+i+'")');
			}else if(type=='video'){
				$(this).find('.free_resources_section').attr('onchange','isVideo("'+i+'")');
			}else if(type=='audio'){
				$(this).find('.free_resources_section').attr('onchange','isAudio("'+i+'")');
			}
			$(this).find('.section_no').attr('name','section_no'+i);
			$(this).find('.section_no').attr('id','section_no'+i);
			$(this).find('.section_type').attr('name','section_type'+i);
			$(this).find('.previewImg').attr('id','section_type'+i);
			$(this).find('.previewVideo').attr('id','section_type'+i);
			$(this).find('.previewAudio').attr('id','section_type'+i);
			$(this).find('.old_section').attr('name','old_section'+i);
			
			$(this).find('.old_section').attr('id','old_section'+i);
			$(this).find('.previewImg').attr('id','previewImg'+i);
			$(this).find('.previewVideo').attr('id','previewVideo'+i);
			$(this).find('.previewAudio').attr('id','previewAudio'+i);
			
		    i++;
		});
		var length =$("#EmployeeTierId .employeeTierDiv").length;
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
	$("#EmployeeTierId .employeeTierDiv").each(function(){
		type=$(this).find('.section_type').val();
		if(type=='text'){
			CKEDITOR.replace('free_resources_section'+i);
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
	FREE_RESOURCES_IMAGE_TYPES='<?php echo FREE_RESOURCES_IMAGE_TYPES ?>';
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
		alert('Allowed type only: <?php echo FREE_RESOURCES_IMAGE_TYPES ?>');
		$('#free_resources_section'+i).val('');
		$("#thumbnailPreview").attr("src",DEMO_IMAGE_URL);;
	}
    
}

function isImage(i){
	
	var file=$('#free_resources_section'+i)[0].files[0];
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
		$('#free_resources_section'+i).val('');
		$("#previewImg"+i).attr("src",DEMO_IMAGE_URL);;
	}
    
}
function isVideo(i){
	
	var file=$('#free_resources_section'+i)[0].files[0];
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
		$('#free_resources_section'+i).val('');
		$("#previewVideo"+i).attr("src",'');
	}
    
}
function isAudio(i){
	
	var file=$('#free_resources_section'+i)[0].files[0];
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
		$('#free_resources_section'+i).val('');
		$("#previewAudio"+i).attr("src",'');
	} 
}
</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>