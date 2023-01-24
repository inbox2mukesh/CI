<style>
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
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open_multipart('adminController/enquiry_purpose/edit/'.$enquiry_purpose['id']); ?>
			<div class="box-body">
				<div class="">
					
					<div class="col-md-4">
						<label for="enquiry_purpose_name" class="control-label">Enquiry Purpose Name<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="enquiry_purpose_name" value="<?php echo ($this->input->post('enquiry_purpose_name') ? $this->input->post('enquiry_purpose_name') : $enquiry_purpose['enquiry_purpose_name']); ?>" class="form-control input-ui-100" id="enquiry_purpose_name" maxlength="50"/>
							<span class="text-danger"><?php echo form_error('enquiry_purpose_name');?></span>
						</div>
					</div>	
                    
                    <?php
                    $division_id =$this->input->post('division_id');
        			?>
                     <div class="col-md-4">
						<label for="division_id" class="control-label">Division<span class="text-danger">*</span></label>
						<?php
							$total=count($enquiryPurposeDivisions);
							#pr($eventTypeDivisions);
							foreach ($enquiryPurposeDivisions as $c){
								
								if($total > 1){

									if($this->Role_model->_has_access_('enquiry_purpose','delete_enquiry_purpose_division_')){
										echo '<button type="button" class="btn  btn-md  btn-success del" onclick=deleteEnquiryPurposeDivisions('.$c["enquiry_purpose_id"].','.$c["division_id"].')>
									'.$c['division_name'].'<i class="fa fa-close cross-icn"></i></button>';
									}else{
										echo '<button type="button" class="btn  btn-md  btn-success del" onclick=deleteEnquiryPurposeDivisions('.$c["enquiry_purpose_id"].','.$c["division_id"].')>
									'.$c['division_name'].'</button>';
									}
								
								}else{
									
								 echo '<button type="button" class="btn  btn-md  btn-success del">
								'.$c['division_name'].'</button>';
								} 
						    } 
						?>
						<div class="form-group">
							<select name="division_id[]" id="division_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" multiple="multiple" data-actions-box="true">
								<option value=""  disabled="disabled">Select Division</option>
								<?php 
								foreach($all_division as $b){
									if(in_array(strtolower($b['division_name']),array('visa','academy'))){
										$selected = in_array($b['id'],$division_id) ? ' selected="selected"' : "";
										echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('division_id[]');?></span>
						</div>
					</div>
					<div class="col-md-4">
            <label for="image" class="control-label">Service Image<span class="text-danger">*</span></label><?php echo WEBP_ALLOWED_TYPES_LABEL;?>
            <div class="form-group">
				<?php
				$required="";
				if(empty($enquiry_purpose['image']))
				{
					$required="required";
				}
				?>
              <input type="file" name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control input-ui-100" id="image" <?php echo $required;?>  onchange="validate_file_type_Webp(this.id)"/>              
              <span class="text-danger image_err"><?php echo form_error('image');?></span>
			  
			  <?php 
								if(isset($enquiry_purpose['image'])){      
                                    echo '<div>
                                            <a href="'.site_url(SERVICE_IMAGE_PATH.$enquiry_purpose['image']).'" target="_blank">'.OPEN_FILE.'</a>
                                        </div>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
								<input type="hidden" value="<?php echo SERVICE_IMAGE_PATH.''.$enquiry_purpose['image'];?>" name="hid_image"/>
            </div>
          </div>
		  <div class="col-md-12">
            <label for="about_service" class="control-label">About service</label>
            <div class="form-group has-feedback">
              <textarea name="about_service" class="form-control myckeditor" id="about_service"><?php echo ($this->input->post('about_service') ? $this->input->post('about_service') : $enquiry_purpose['about_service']); ?></textarea>
              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
            </div>
          </div>
					<?php 
					$active=$enquiry_purpose['active'];
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$active=$this->input->post('active');
					}
					?>	
                    <div class="col-md-6">
						<div class="form-group form-checkbox">							
							<input type="checkbox" name="active" value="1"  id="active" <?php if($active == 1){?>checked="checked" <?php }?>/>	
							<label for="active" class="control-label">Active</label>
						</div>
					</div>	
				</div>
			</div>
			<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20">
					 <?php echo UPDATE_LABEL;?>
				</button>
                &nbsp; 
                <button type="button" class="btn btn-reset rd-20" onclick="return location.replace('<?php echo site_url('adminController/enquiry_purpose/index'); ?>');">
					<?php echo CANCEL_LABEL;?>
				</button>
	        </div>			
			</div>		
			<?php echo form_close(); ?>
		</div>
    </div>
</div>
<script>
function deleteEnquiryPurposeDivisions(enquiry_purpose_id,division_id){
	
        $.ajax({
            url: "<?php echo site_url('adminController/enquiry_purpose/delete_enquiry_purpose_division_');?>",
            async : true,
            type: 'post',
            data: {division_id:division_id,enquiry_purpose_id:enquiry_purpose_id},
            dataType: 'json',
            success: function(response){
				
                if(response==1){
					
                    window.location.href=window.location.href
                }             
            }
        });
    }
</script>