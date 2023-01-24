<style type="text/css">
        .copy-notification {
            color: #ffffff;
            background-color: rgba(0,0,0,0.8);
            padding: 20px;
            border-radius: 30px;
            position: fixed;
            top: 50%;
			z-index:999999;
            left: 50%;
            width: 150px;
            margin-top: -30px;
            margin-left: -85px;
            display: none;
            text-align:center;
        }
		.comment {
	
}
a.morelink {
	text-decoration:none;
	outline: none;
}
.morecontent span {
	display: none;

}
    </style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $stitle;?></h3>	                       
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/discount/special'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
                
                <div class="col-md-6">
						<label for="center_id" class="control-label"> Search</label>
						<div class="form-group">
				<input type="text" name="txtSearch" value="<?php echo $this->input->post('txtSearch'); ?>" placeholder="discount name / discount code / phone / email" class="form-control" id="txtSearch"  />
						</div>
					</div>
                    <div class="col-md-6"><label for="center_id" class="control-label"> </label><div class="form-group"><a href="javascript:void(0);" class="btn btn-success btn-sm" id="clearSel">Clear</a></div></div>
			</div>
            <div class="row clearfix">
            <div class="col-md-4" style="margin-bottom:25px;margin-top:25px; font-weight:bold; font-size:16px;">
            Or
            </div>
            </div>
       	<div class="row clearfix">
            <div class="col-md-4">
						<label for="waiver_type" class="control-label"> Applied to Country</label>
						<div class="form-group">
							<select name="country_id[]" id="country_id" class="form-control selectpicker ccode1 disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option data-subtext="" value="">Select country</option>
								<?php 
								foreach($all_country_currency_code as $p)
								{	
							
									if(in_array($p['country_id'],$this->input->post('country_id'))) {
									echo '<option  value="'.$p['country_id'].'" selected>'.$p['name'].'</option>';
									} else {
									echo '<option value="'.$p['country_id'].'">'.$p['name'].'</option>';
									}
									
								} 
								?>
							</select>
							
						</div>
					</div>	
       			 <div class="col-md-4">
						<label for="appliedProducts" class="control-label"> Products</label>
						<div class="form-group">
							<select name="appliedProducts" id="appliedProducts1" class="form-control selectpicker disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >			
                           
								<option value="">Select Product</option>
								<option value="1" <?php if($this->input->post('appliedProducts')==1) echo "selected";?>>Inhouse pack</option>
								<option value="2" <?php if($this->input->post('appliedProducts')==2) echo "selected";?>>Online pack</option>
								<option value="3" <?php if($this->input->post('appliedProducts')==3) echo "selected";?>>Practice Pack</option>
                                <option value="4" <?php if($this->input->post('appliedProducts')==4) echo "selected";?>>Reality Test</option>
                                <option value="5" <?php if($this->input->post('appliedProducts')==5) echo "selected";?>>Exam Booking</option>
							</select>
						
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="appliedBranches" class="control-label"> Branches</label>
						<div class="form-group">
						<input type="hidden" name="branchids" id="branchids" value="" />
                            <select name="appliedBranches[]" id="appliedBranches1" class="form-control selectpicker disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b)
								{
									
									if(in_array($b['center_id'],$this->input->post('appliedBranches'))) {
									echo '<option value="'.$b['center_id'].'" selected>'.$b['center_name'].'</option>';
									} else {
									echo '<option value="'.$b['center_id'].'">'.$b['center_name'].'</option>';
									}
								} 
								?>
							</select>
							
						</div>
					</div>	
                    
                    <div class="col-md-4">
						<label for="appliedTestType" class="control-label"> Test Type</label>
						<div class="form-group">
							<?php 
								if($this->input->post('appliedTestType')){ 
									?>
                        <input type="hidden" name="testtypeids" id="testtypeids" value="<?php echo implode(",",$this->input->post('appliedTestType'))?>" />
                    <?php }else{ ?>
                    	<input type="hidden" name="testtypeids" id="testtypeids"  />
                    <?php } ?>
							<select name="appliedTestType[]" id="appliedTestType1" class="form-control selectpicker disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Test Type</option>
								<?php 
								foreach($all_testtype_list as $b)
								{
									//$selected = ($b['test_module_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
									
									if(in_array($b['test_module_id'],$this->input->post('appliedTestType'))) {
									echo '<option value="'.$b['test_module_id'].'" selected>'.$b['test_module_name'].'</option>';
									} else {
									echo '<option value="'.$b['test_module_id'].'" >'.$b['test_module_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('appliedTestType');?></span>
						</div>
					</div>		
                    
                    
					<div class="col-md-4">
						<label for="appliedPackages" class="control-label"> Packages / Packs</label>
						<div class="form-group">
							<?php if($this->input->post('appliedPackages')){ ?>
                        <input type="hidden" name="packageids" id="packageids" value="<?php echo implode(",",$this->input->post('appliedPackages'))?>" />
                    <?php }else{ ?>
                    	<input type="hidden" name="packageids" id="packageids"  />
                    <?php } ?>
							<select name="appliedPackages[]" id="appliedPackages1" class="form-control selectpicker disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
								<option value="">Select Type</option>

							</select>
				
						</div>
					</div>
                   
                    <div class="col-md-4">
						<label for="status" class="control-label"> Status</label>
						<div class="form-group">
							<select name="status" id="dstatus" class="form-control selectpicker disbled selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
								<option value="">Select Status</option>
								<option value="1" <?php if(!empty($this->input->post('status')) && 1 == $this->input->post('status'))  echo ' selected="selected"'; else echo ''; ?>>Active</option>
								<option value="0" <?php if(!empty($this->input->post('status')) && 0 == $this->input->post('status')) echo 'selected="selected"'; echo ''; ?>>Inactive</option>
                                <option value="2" <?php if(!empty($this->input->post('status')) && 2 == $this->input->post('status')) echo 'selected="selected"'; echo ''; ?>>Scheduled</option>

							</select>
							
						</div>
					</div>
				

					<div class="col-md-4">
						<label for="date_from" class="control-label">Start Date <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="start_date" value="<?php echo $this->input->post('start_date'); ?>" autocomplete="off" class="has-datepicker form-control disbled" id="start_date" /><span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="date_to" class="control-label">End Date <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="end_date" value="<?php echo $this->input->post('end_date'); ?>" autocomplete="off" class="has-datepicker form-control disbled" id="end_date" /><span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>	
					<?php 
						$today = date('d-m-Y');
						$yesterday = date('d-m-Y', strtotime($today. ' - 1 days'));
						$tomarrow  = date('d-m-Y', strtotime($today. ' + 1 days'));
					?>


				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
            		<i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
            	</button>
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
                    <a href="<?php echo site_url('adminController/discount/add'); ?>" class="btn btn-danger btn-sm">New Discount Code</a>                                       
                </div>                
            </div>
            <?php
			
			 echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
						<th><?php echo SR;?></th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Duration</th>
                        <th>Max Discount</th>
                        <th>Products</th>
                        <th>Branches</th>
                        <th>Test Type</th>
                        <th width="20%">Packages/Packs</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $json = json_decode($discount);
					
                        $sr=0; foreach($json as $c){ $zero=0;$one=1;$pk='id'; $table='discount';$sr++; ?>                    
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php echo $c->disc_name; ?></td>
                        <td><?php echo $c->name; ?></td>
                        <td><?php echo date("M d, Y",strtotime($c->start_date)).'  '.$c->start_time.'<Br>'.date("M d, Y",strtotime($c->end_date)).'  '.$c->end_time; ?></td>  
                        <td><?php echo $c->max_discount;
						if($c->discount_type=="Amount") {
						echo ' '.$c->currency_code;
						} if($c->discount_type=="Percentage") {
						echo ' %';
						} ?></td>
                        <td>
                        <?php 
                                foreach ($c->Product as $p=>$val) {
                                    echo $val.', ';
                                }
                            ?>
                        </td>
                        <td><?php 
                                foreach ($c->Branch as $b) {
                                    echo $b->center_name.', ';
                                }
                            ?></td>	
                        <td><?php 
                                foreach ($c->TestType as $t) {
                                    echo $t->test_module_name.', ';
                                }
                            ?></td>
                        <td>
                        <div class="comment more">
                         <?php 
	
                                foreach ($c->Package as $pkg) {
								if($pkg->discounted_amount==$pkg->amount || $pkg->discounted_amount=="null") {
                                    echo $pkg->package_name.'|'.$pkg->discounted_amount.'|'.$pkg->duration.', ';
									} else {
									 echo $pkg->package_name.'|'.$pkg->discounted_amount.'|'.$pkg->amount.'|'.$pkg->duration.', ';
									}
                                }
                            ?>
                            </div>
                            </td>
                        <td id="cp<?php echo $c->id?>"><?php echo $c->discount_code; ?></td>
                        <td nowrap="nowrap">
                        
                             <?php 
							 $endtime=strtotime($c->end_date." ".$c->end_time);
							 $currenttime=time();
							// echo date('d-m-Y H:i',$endtime)."----".date('d-m-Y H:i',$currenttime);
							if($c->is_schedule==1) {
								if($endtime>$currenttime) {
									if($c->active==2){
								echo '<a href="javascript:void(0)" id='.$c->id.' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete_schedule('.$c->id.','.$zero.',"'.$table.'","'.$pk.'")><span class="fa fa-clock-o"></span> </a>';
									} else {
									$one=2;
								echo '<span class="text-danger"><a href="javascript:void(0);" id='.$c->id.' data-toggle="tooltip" title="Click to Schdule" onclick=activate_deactivete_schedule('.$c->id.','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
									}
								} else {
								$one=2;
								echo '<span class="text-danger">'.DEACTIVE.'</span>';
								}
							} else {
							if($endtime>$currenttime) {
									if($c->active==1){
										echo '<span class="text-success"><a href="javascript:void(0);" id='.$c->id.' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$c->id.','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
									}else{
										echo '<span class="text-danger"><a href="javascript:void(0);" id='.$c->id.' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$c->id.','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
									}
								} else {
								echo '<span class="text-danger">'.DEACTIVE.'</span>';
								}
							}
                            ?> 
                                                       
                        </td>
                        <td nowrap>
                        <a href="javascript:void(0)" onclick="CopyToClipboard('<?php echo $c->discount_code?>', true, 'Discount code copied')"><span class="fa fa-clone"></span> </a>
                         <a href="javascript:void(0)" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#modal-viewDiscount" onclick="getDiscountDetails(this.id);" id="<?php echo $c->id;?>" title="Full Details"><span class="fa fa-eye"></span> </a>
                             <?php /*?><a href="<?php echo site_url('adminController/discount/edit/'.$c->id); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>              <?php */?>
                            <a href="#" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#modal-editDates" onclick="editDiscountDates(this.id);" id="<?php echo $c->id;?>" title="Edit Dates"><span class="fa fa-calendar-o"></span> </a>
                        </td>
						
                    </tr>
                    <?php } ?>
                    
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-viewDiscount" style="display: none;">
          <div class="modal-dialog" style="width:1000px !important;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info"><?php echo $stitle;?></h4>
                <h5 class="msg_withdrawl"></h5>
              </div>

              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">            
                           
                            

                            <div class="discount_details"></div>
                            
                        </div>
                    </div>
                </div>
              </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            Close
            </button>
           
            </div>

            </div>
          </div>
        </div>
        
 <style>
.datepicker{ z-index:99999 !important; }
</style>
        <div class="modal fade" id="modal-editDates" style="display: none;">
          <div class="modal-dialog" style="width:1000px !important;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info"><?php echo $stitle;?></h4>
                <h5 class="msg_withdrawl"></h5>
              </div>

              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">            
                           
                            

                            <div class="discount_dates"></div>
                            
                        </div>
                    </div>
                </div>
              </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            Close
            </button>
           
            </div>

            </div>
          </div>
        </div>
        

<script src="<?php echo site_url('resources/js/jquerynew-1.9.1.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap-datepickernew.css');?>">
<script src="<?php echo site_url('resources/js/jquerynew2.min.js');?>"></script>
<script src="<?php echo site_url('resources/js/bootstrap-datepickernew.js');?>"></script>
<?php if(!empty($this->input->post('appliedTestType'))) {?>
                    <script>
					$(document).ready(function() {
					
					$("#appliedTestType1").change();
					});
					</script>
                    
                    <?php }?>  
<script>

function convertTime12To24(time) {
    var hours   = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM    = time.match(/\s(.*)$/)[1];
    if (AMPM === "PM" && hours < 12) hours = hours + 12;
    if (AMPM === "AM" && hours === 12) hours = hours - 12;
    var sHours   = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    return (sHours + ":" + sMinutes);
}

   $(document).ready(function() {     


  $.validator.addMethod('greaterThan', function(value, element) {

            var dateFrom = $("#start_date1").val();
            var dateTo = $('#end_date1').val();
			
			 var timeFrom = $("#start_time1").val();
            var timeTo = $('#end_time1').val();
			
			mySDate = dateFrom.split("-");
			var timeFrom=convertTime12To24(timeFrom);
			mySTime = timeFrom.split(":");
		var newSDate = new Date( mySDate[2], mySDate[1] - 1, mySDate[0], mySTime[0], mySTime[1]);
		
		myEDate = dateTo.split("-");
		var timeTo=convertTime12To24(timeTo);
		myETime = timeTo.split(":");
		var newEDate = new Date( myEDate[2], myEDate[1] - 1, myEDate[0], myETime[0], myETime[1]);


            return newEDate.getTime() > newSDate.getTime();

}, "Please check your dates. The start date must be before the end date.");

$(document).on("click", ".btnUpdate", function() {

$("#frmDDiscount").validate({
 ignore: [],
		rules: {

			"start_date1": {
				required: true,
			},
			"start_time1": {
				required: true,
			},
			"end_date1": {
	        required: true,
	      },
			"end_time1": {
			greaterThan: "#start_time1",
				required: true,
			},


						
		},
	errorPlacement: function(error, element) {
	 if  (element.attr("name") == "start_time1" )
        error.insertAfter(".start_time_err");
	 else if  (element.attr("name") == "end_time1" )
        error.insertAfter(".end_time_err");
   else
        error.insertAfter(element);
},
	 
		messages: {

			start_date1:"Please enter start date",
			start_time1:"Please select start time",
			end_date1: {
            required: "Please enter start date",
            greaterThan: jQuery.format("Please check your dates. The start date must be before the end date."),
        },
			end_time1:"Please select end time",
	
			
		},
		//perform an AJAX post to ajax.php
		submitHandler: function(form) {
			
			var discount_id=$("#discount_id").val();
var start_date=$("#start_date1").val();
var start_time=$("#start_time1").val();
var end_date=$("#end_date1").val();
var end_time=$("#end_time1").val();
$.ajax({
        url: "<?php echo site_url('adminController/discount/ajax_edit_dates');?>",
        async : true,
        type: 'post',
        data: {discount_id: discount_id,start_date: start_date,start_time:start_time,end_date: end_date,end_time:end_time},
        dataType: 'json',                
        success: function(data){
		$("#smsg").html("Successfully data saved !!");
		$("#smsg").show();
		setTimeout(function(){ $(".close").trigger("click"); window.location.reload(); }, 3000);
		
		}
	});
			}
		
	});
});
});
</script>
  <script> 
	// set default dates
var start = new Date();
// set end date to max one year period:
var end = new Date(new Date().setYear(start.getFullYear()+1));


	   var $j_custom = jQuery.noConflict(true);
	$j_custom(function() {
    $j_custom("body").delegate(".noBackDate", "focusin", function(){
        $j_custom(this).datepicker({ 
	format: 'dd-mm-yyyy',
	startDate : start,
    endDate   : end,
	autoclose: true,
    });
    });
});
</script>      
<SCRIPT>
$(document).ready(function() {
	var showChar = 100;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreelipses">'+ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
});
</SCRIPT>
