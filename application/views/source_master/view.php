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
           
            <div class="box-body">
             
                    <input type="hidden" name="source_id_hidden" id="source_id_hidden" value="<?php echo $source_master['id']; ?>" >
                    <div class="col-md-12">
                        <label for="source_name" class="control-label"><span class="text-danger">*</span>Source Name :<?php echo $source_master['source_name']?></label>
                        <div class="form-group">
                          
                        </div>
                    </div>			
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="active" class="control-label">Active:</label>
							<?php 
							echo $source_master['active'] == 1 ? 'Yes' : 'No';
							?>
                        </div>
                    </div>
				
		            <div id="OMALLData">
                        <?php
						$j=1;
						foreach($source_om as $key=>$val){
							
							$select_origin_type=$val['origin_type'];
							$select_origin=$val['origin'];
							$select_medium=$val['medium'];
							$origin_array=$origin_pack[$select_origin_type]['origin'];
							$medium_array=$origin_array[$select_origin]['medium'];
							
							
						?>
						<div class="OMitemdata" id="OMitemdata-<?php echo $key?>">

						<div class="col-md-12">
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
										<select name="origin_type[]" class="form-control origin_type selectpicker selectpicker-ui-100"  data-live-search="true"  id="origin_type-<?php echo $key?>" onchange="getOrigin('<?php echo $key?>')" disabled>
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
										<select name="origin[]" class="form-control origin selectpicker selectpicker-ui-100"  data-live-search="true" id="origin-<?php echo $key?>" onchange="getMedium('<?php echo $key?>')" disabled>
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

								<div class="col-md-5">
									<div class="form-group">
										<label for="medium" class="control-label"><span class="text-danger">*</span>Medium</label>
										<select class="form-control medium selectpicker selectpicker-ui-100 origin-typ-and-origin-<?php echo $select_origin_type?>-<?php echo $select_origin?>" data-live-search="true"
											multiple="multiple" data-actions-box="true" required id="medium-<?php echo $key?>" name="medium<?php echo $key?>[]" onchange="updateMedium('<?php echo $key?>','<?php echo $select_origin_type?>','<?php echo $select_origin?>')" disabled>
											<option value="" disabled="disabled">Select Medium</option>
											<?php 
											    foreach($medium_array as $key2 => $op2): 
												$selected='';
												if($select_medium==$key2){
													
													$selected='selected="selected"';
												?>
												    <option value="<?php echo $key2; ?>" <?php echo $selected?>><?php echo $op2; ?></option>
                                                <?php 												
												}
											      
											?>
											<?php endforeach; ?>
										</select>
										<span class="text-danger medium_err" id="medium_err-<?php echo $key?>"><?php echo form_error('medium'); ?></span>
									</div>
								</div>
		                    </div>
						<?php 
						$j++;
						}
						?>					
                    </div>		
					</div>		
				
            </div>
        </div>
    </div>
</div>
