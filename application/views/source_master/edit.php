<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>
				<div class="box-tools pull-right">
                    <?php 
                      if($this->Role_model->_has_access_('source_master','index')){
                    ?>
                    <a href="<?php echo site_url('adminController/source_master/index'); ?>" class="btn btn-danger btn-sm">Source List</a><?php } ?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php echo form_open('adminController/source_master/edit/' . $source_master['id'],'id="source_master_edit"'); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <input type="hidden" name="source_id_hidden" id="source_id_hidden" value="<?php echo $source_master['id']; ?>" >
                    <div class="col-md-6">
                        <label for="source_name" class="control-label"><span class="text-danger">*</span>Source Name</label>
                        <div class="form-group">
                            <input type="text" name="source_name" value="<?php echo ($this->input->post('source_name') ? $this->input->post('source_name') : $source_master['source_name']); ?>" class="form-control input-ui-100" id="source_name" />
                            <span class="text-danger source_name_err"><?php echo form_error('source_name'); ?></span>
                        </div>
                    </div>			
                    <div class="col-md-12">
                        <div class="form-group form-checkbox">                           
                            <input type="checkbox" name="active" value="1" <?php echo ($source_master['active'] == 1 ? 'checked="checked"' : ''); ?> id='active' />	
							<label for="active" class="control-label">Active</label>						
						</div>
                    </div>
                    <div class="col-md-12" style="margin-bottom:10px;">
					    <button type="button" class="btn btn-success rd-20" onclick="AddOM()">
                            <i class="fa fa-plush"></i>Add Origin & Medium
                        </button>
                    </div>
		            <div id="OMALLData">
                        <?php
						$selectAllMedium=array();
						foreach($source_om as $key=>$val){
							
							$select_origin_type=$val['origin_type'];
							$select_origin=$val['origin'];
							$select_medium=$val['medium'];
							$selectAllMedium[$select_origin_type.'-'.$select_origin][]=$select_medium;
							
						}
						$j=1;
						foreach($source_om as $key=>$val){
							
							$select_origin_type=$val['origin_type'];
							$select_origin=$val['origin'];
							$select_medium=$val['medium'];
							$origin_array=$origin_pack[$select_origin_type]['origin'];
							$medium_array=$origin_array[$select_origin]['medium'];
							$selectMediumArray=$selectAllMedium[$select_origin_type.'-'.$select_origin];
							#pr($selectMediumArray);
							
						?>
						<div  class="col-md-12 OMitemdata" id="OMitemdata-<?php echo $key?>">
							   <div class="col-md-1">
									<div class="form-group">
									<label for="active" class="control-label sn" id="sn-<?php echo $key?>">
									<?php echo $j?>
									</label>
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label for="active" class="control-label"><span class="text-danger">*</span>Origin Type</label>
										<select name="origin_type[]" class="form-control origin_type selectpicker"  data-live-search="true"  id="origin_type-<?php echo $key?>" onchange="getOrigin('<?php echo $key?>')">
											<option value="">Select Origin Type</option>
											<?php 
											    foreach($origin_pack as $ot => $op): 
												$selected='';
												if($select_origin_type==$ot){
													
												$selected='selected="selected"';
												}
											    ?>
												<option value="<?php echo $ot; ?>" <?php echo $selected?>><?php echo $op['name']; ?></option>
                                              	
											<?php endforeach; ?>
										</select>
										<span class="text-danger origin_type_err"><?php echo form_error('origin_type'); ?></span>
									</div>
								</div>						

								<div class="col-md-3">
									<div class="form-group">
										<label for="origin" class="control-label"><span class="text-danger">*</span>Origin </label>
										<select name="origin[]" class="form-control origin selectpicker"  data-live-search="true" id="origin-<?php echo $key?>" onchange="getMedium('<?php echo $key?>')">
											<option value="">Select Origin</option>
											<?php 
											    foreach($origin_array as $key1 => $op1): 
												$selected='';
												if($select_origin==$key1){
													
													$selected='selected="selected"';
												}
											    
											?>
											<option value="<?php echo $key1; ?>" <?php echo $selected?>><?php echo $op1['name']; ?></option>
											<?php endforeach; ?>
										</select>
										<span class="text-danger origin_err"><?php echo form_error('origin'); ?></span>
									</div>
								</div>						

								<div class="col-md-3">
									<div class="form-group">
										<label for="medium" class="control-label"><span class="text-danger">*</span>Medium</label>
										<select class="form-control medium selectpicker origin-typ-and-origin-<?php echo $select_origin_type?>-<?php echo $select_origin?>" data-live-search="true"
											multiple="multiple" data-actions-box="true" required id="medium-<?php echo $key?>" name="medium<?php echo $key?>[]" onchange="updateMedium('<?php echo $key?>','<?php echo $select_origin_type?>','<?php echo $select_origin?>')">
											<option value="" disabled="disabled">Select Medium</option>
											<?php 
											    foreach($medium_array as $key2 => $op2): 
												$selected='';
												if($select_medium==$key2){
													
													$selected='selected="selected"';
												?>
												    <option value="<?php echo $key2; ?>" <?php echo $selected?>><?php echo $op2; ?></option>
                                                <?php 												
												}else if(!in_array($key2,$selectMediumArray)){
												?>
												    <option value="<?php echo $key2; ?>"><?php echo $op2; ?></option>
												<?php 	
												}
											      
											?>
											<?php endforeach; ?>
										</select>
										<span class="text-danger medium_err" id="medium_err-<?php echo $key?>"><?php echo form_error('medium'); ?></span>
									</div>
								</div>
								<div class="col-md-2" style="margin-top:24px;">
									<button class="btn btn-danger margin-left-10 removeRow" type="button" id="removeRow<?php echo $key?>" onclick="removeRow('<?php echo $key?>')"><i class="glyphicon glyphicon-minus"></i>
									</button>
								</div>
		</div>
						<?php 
						$j++;
						}
						?>					
                    </div>					
                </div>
            </div>
            <div class="box-footer">
			<div class="col-md-12">
                <button type="submit" class="btn btn-danger sbm rd-20">
                    <i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL; ?>
                </button>
            </div>	
			</div>				
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--------Clone Html---------->
	<div class="OMData" id="OMDatahtml" style="display:none">
		<div  class="col-md-12">
		<div class="OMitemdata" style="background-color: #f5f5f5!important;clear:both;padding: 10px;display: flex;margin-bottom:10px;">
		   <div class="col-md-1">
				<div class="form-group">
					<label for="active" class="control-label sn"></label>
				</div>
            </div>	
		    <div class="col-md-3">
				<div class="form-group">
					<label for="active" class="control-label"><span class="text-danger">*</span>Origin Type</label>
					<select name="origin_type[]" class="form-control origin_type "  data-live-search="true">
						<option value="">Select Origin Type</option>
					    <!--<?php foreach($origin_pack as $key => $op): if(in_array($key, ['rap', 'op'])):?>
						<option value="<?php echo $key; ?>"><?php echo $op['name']; ?></option>
						<?php endif; endforeach; ?>-->
						
					</select>
					<span class="text-danger origin_type_err"><?php echo form_error('origin_type'); ?></span>
				</div>
            </div>						

			<div class="col-md-3">
				<div class="form-group">
					<label for="origin" class="control-label"><span class="text-danger">*</span>Origin </label>
					<select name="origin[]" class="form-control origin"  data-live-search="true">
						<option value="">Select Origin</option>
					</select>
					<span class="text-danger origin_err"><?php echo form_error('origin'); ?></span>
				</div>
			</div>						

			<div class="col-md-3">
				<div class="form-group">
					<label for="medium" class="control-label"><span class="text-danger">*</span>Medium</label>
					<select class="form-control medium"  data-live-search="true"
                        multiple="multiple" data-actions-box="true" required>
						<option value="" disabled="disabled">Select Medium</option>
					</select>
					<span class="text-danger medium_err"><?php echo form_error('medium'); ?></span>
				</div>
			</div>
			<div class="col-md-2" style="margin-top:24px;">
				<button class="btn btn-danger margin-left-10 removeRow" type="button"><i class="glyphicon glyphicon-minus"></i>
				</button>
			</div>
		</div>
		</div>
	</div>	
<!--------Clone Html--------->
<?php ob_start(); ?>
<script>
    var origin_pack = [];
    origin_pack = JSON.parse('<?php echo json_encode($origin_pack) ?>');
	var originTypeKeyArray=[];
	originTypeKeyArray['rap']='rap';
	originTypeKeyArray['op']='op';
	selectAllMedium = {};
    function AddOM(){
		OMDatahtml=$("#OMDatahtml").html();
		$("#OMALLData").append(OMDatahtml);
		i = 0;
		j = 1;
		total = $("#OMALLData .OMitemdata").length;
        $("#OMALLData .OMitemdata").each(function() {
			
			$(this).find(".origin_type").attr('id', 'origin_type-' + i);
            $(this).find('.origin_type').attr('onchange', 'getOrigin("'+i+'")');
			$(this).find(".origin").attr('id', 'origin-' + i);
            $(this).find('.origin').attr('onchange', 'getMedium("'+i+'")');
			$(this).find(".medium").attr('id', 'medium-' + i);
			$(this).find(".medium").attr('name', 'medium' + i+'[]');
			$(this).find(".medium_err").attr('id', 'medium_err-'+i);
			$(this).find(".removeRow").attr('id', 'removeRow' + i);
			$(this).find('.removeRow').attr('onclick', 'removeRow("'+i+'")');
			$(this).find('.sn').attr('id', 'sn-' + i);
			$('#sn-'+i).text(j);
			$(this).attr('id','OMitemdata-'+i);
			if(j==total){
				
				$('#origin-'+i).html('<option value="">Select Origin</option>');
		        $('#medium-'+i).html('<option value="" disabled="disabled">Select Medium</option>');
		        $('#medium-'+i).selectpicker("refresh");
		        $('#origin-'+i).selectpicker("refresh");
				var originTypeSelectBox = '<option value="">Select Origin Type</option>';
				$.each(origin_pack, function(index, row) {
					//if (originTypeKeyArray.hasOwnProperty(index) == true) {
					    originTypeSelectBox += '<option value="' + index + '">' + row['name'] + '</option>';
					//}
				});
				$('#origin_type-'+i).html(originTypeSelectBox);
			    $('#origin_type-'+i).selectpicker("refresh");
			}
			
			i++;
			j++;
			
		});
	    updateList();
    }
	function removeRow(i){
		
		$('#OMitemdata-'+i).remove();
		updateList();
	}
	function updateList(){
		i = 0;
		j = 1;
        $("#OMALLData .OMitemdata").each(function() {
			
			$(this).find(".origin_type").attr('id', 'origin_type-' + i);
            $(this).find('.origin_type').attr('onchange', 'getOrigin("'+i+'")');
			$(this).find(".origin").attr('id', 'origin-' + i);
            $(this).find('.origin').attr('onchange', 'getMedium("'+i+'")');
			$(this).find(".medium").attr('id', 'medium-' + i);
			$(this).find(".medium").attr('name', 'medium' + i+'[]');
			$(this).find(".medium_err").attr('id', 'medium_err-'+i);
			$(this).attr('id','OMitemdata-'+i);
			$(this).find(".removeRow").attr('id', 'removeRow' + i);
			$(this).find('.removeRow').attr('onclick', 'removeRow("'+i+'")');
			$(this).find('.sn').attr('id', 'sn-' + i);
			$('#sn-'+i).text(j);
			j++;
			i++;
		});	
	}
	function getOrigin(i) {
		
		$('#origin-'+i).html('<option value="">Select Origin</option>');
		$('#medium-'+i).html('<option value="" disabled="disabled">Select Medium</option>');
		$('#medium-'+i).selectpicker("refresh");
		$('#origin-'+i).selectpicker("refresh");
		label=$('#origin_type-'+i).val();
        if (label){
			origin=origin_pack[label]['origin'];
			var originSelectBox = '<option value="">Select Origin</option>';
            $.each(origin, function(index, row) {
				
                originSelectBox += '<option value="' + index + '">' + row['name'] + '</option>';
            });
            $('#origin-'+i).html(originSelectBox);
			$('#origin-'+i).selectpicker("refresh");
        }
    }
	function getMedium(i) {
		
		var origin_type=$('#origin_type-'+i).val();
		$('#medium-'+i).html('<option value="" disabled="disabled">Select Medium</option>');
		$('#medium-'+i).selectpicker("refresh");
		
		label=$('#origin-'+i).val();
        if (label && origin_type){
			
			$('#medium-'+i).attr('class','');
			$('#medium-'+i).addClass('form-control');
			$('#medium-'+i).addClass('medium');
			$('#medium-'+i).addClass('selectpicker');
			$('#medium-'+i).addClass('origin-typ-and-origin-'+origin_type+'-'+label);
			selectAllMedium = {};
		    $('.origin-typ-and-origin-'+origin_type+'-'+label+' option:selected').each(function() {
				var txt = $(this).text();
				var val = $(this).val();
				selectAllMedium[val] = txt;
		    });
		    $('#medium-'+i).attr('onchange', 'updateMedium("'+i+'","'+origin_type+'","'+label+'")');
			medium=origin_pack[origin_type]['origin'][label]['medium'];
			var mediumSelectBox = '<option value="" disabled="disabled">Select Medium</option>';
            $.each(medium, function(index, row) {
				if (selectAllMedium.hasOwnProperty(index) == false) {
					
                    mediumSelectBox += '<option value="' + index + '">' + row + '</option>';
				}
            });
            $('#medium-'+i).html(mediumSelectBox);
			$('#medium-'+i).selectpicker("refresh");
        }
    }
	function updateMedium(i,origin_type,origin){
		
		selectAllMedium = {};
		$('.origin-typ-and-origin-'+origin_type+'-'+label+' option:selected').each(function() {
			var txt = $(this).text();
			var val = $(this).val();
			selectAllMedium[val] = txt;
		});
		medium=origin_pack[origin_type]['origin'][origin]['medium'];
		i = 0;
		$("#OMALLData .OMitemdata").each(function() {
			var isClass=$('#medium-'+i).hasClass('origin-typ-and-origin-'+origin_type+'-'+origin);
			if(isClass){
				
				selectMedium = {};
				isSelectMedium=false;
				$('#medium-'+i+' option:selected').each(function() {
					var txt = $(this).text();
					var val = $(this).val();
					selectMedium[val] = txt;
					isSelectMedium=true;
				});
				var mediumSelectBox = '<option value="" disabled="disabled">Select Medium</option>';
				$.each(medium, function(index, row) {
					var selected='';
					if(selectMedium.hasOwnProperty(index) == true){
						selected='selected="selected"';
						mediumSelectBox += '<option value="' + index + '" '+selected+'>' + row + '</option>';
					}
					else if (selectAllMedium.hasOwnProperty(index) == false) {
						
						mediumSelectBox += '<option value="' + index + '">' + row + '</option>';
					}
                });
				$('#medium-'+i).html(mediumSelectBox);
			    $('#medium-'+i).selectpicker("refresh");
				if(isSelectMedium){
					$('#medium_err-'+i).next().html('');
				}else{
					$('#medium_err-'+i).next().html('This field is required.');
				}
				
			}
			i++;
		})
	}
	$(document).ready(function() {
	$('.selectpicker').selectpicker().change(function(){
        $(this).valid()
    });
    $("#source_master_edit").validate({
		ignore: "",
        rules: {
            source_name: {
                required: true,
				maxlength: 50,
				remote:{
					url: WOSA_ADMIN_URL+'source_master/ajax_check_source_duplicacy',
					type: "post",
					data: {
						source_name	: function () {
							return $("#source_name").val();
						},
						source_id:function () {
							return $("#source_id_hidden").val();
						},
					}
                },
                
            },
        },
        messages : {
            source_name: {
                required: "Please enter source name",
                maxlength: "source name can be maximum 50 characters",
				remote:'The source_name is already in use!'
            },
			
        },
		errorPlacement: function(error, element) {
			
			var idkey = element.attr("id").replace("medium-", "");
			if (element.attr("id") == 'medium-'+idkey)
			    error.insertAfter('#medium_err-'+idkey);
		    else
			error.insertAfter(element);
	    },
    });
});
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>