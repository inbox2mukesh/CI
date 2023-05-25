<div class="row">
    <div class="col-md-12">
                <div class="box box-flex-widget">
                        <div class="box-header bg-danger">
                            <h3 class="box-title text-primary">Error Log Filter</h3>
                                <div class="box-tools box-rl-ui"></div>
                                
                        </div>
                        <?php echo validation_errors(); ?>

                        <?php echo form_open('',array('name'=>'logfilter','id'=>'logfilter','method'=>'post'))?>
                        <div class="box-body">
                            <div class="col-md-4">	
                                <label for="dateTime" class="control-label"><span class="text-danger">*</span>Date Time </label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="dateTime" id="dateTime" class="form-control user_activity_report_datetimepicker input-ui-100 removeerrmessage" value="">                                   
                                    <span class="text-danger dateTime_err"></span>
                                </div>
                            </div> 
                        </div>
                        <div class="box-footer">
				            <div class="col-md-12">
            	                <button type="button" class="btn btn-danger sbm rd-20" onclick="validateform();"><i class="fa fa-check"></i> <?php echo SAVE_LABEL;?></button>
                                <?php echo form_close();?>
                                <button type="submit" class="btn btn-warning sbm rd-20" id="reset" name="reset"><i class="fa fa-refresh"></i> <?php echo RESET_LABEL;?></button>
				            </div>
          	            </div>
                        
                </div>
    </div>
</div>
<div class="row">
        <div class="col-md-12">
            <div class="box box-flex-widget">
                <div class="box-header bg-danger">
                    <h3 class="box-title text-primary">All Students</h3>
                    <div class="box-tools box-rl-ui">
                    </div>
                                    </div>
                <div class="table-ui-scroller">
                
                    <table class="table table-striped table-bordered table-sm">
                        <thead>                            
                        <tr>
                            <th class="th-0">Sr.</th>                            
                            <th class="th-1">URL</th>
                            <th class="th-2">IP Address</th>
                            <th class="th-2">User Agent</th>
                            <th class="th-3">Date & Time</th>                          
                        </tr>
                        </thead>
                        <tbody id="myTable">
                          <?php
                          $r = 0; 
                          foreach($list as $key => $lists) { $r++;?>
                            <tr>
                                <td><?php echo $r ; ?></td>
                                <td><?php echo $lists['error_log_url'] ; ?></td>
                                <td><?php echo $lists['ip_address'] ; ?></td>
                                <td><?php echo $lists['user_agent'] ; ?></td>
                                <td><?php echo date('d-m-Y h:i:s',strtotime($lists['log_date'])) ; ?></td>
                            </tr>
                            <?php } ?>
                                            </tbody>
                    </table>
                 
                </div>
                </div>
                <!--end:table:ui -->
            </div>
        </div>
    </div>
<?php ob_start();?> 
<script type="text/javascript">
    $('.user_activity_report_datetimepicker').on('dp.change', function(e){ 
		var dt=$(this).val();
		var dtp=dt.split(" ");	
		$(".noBackDatep").val('');	
		$(".noBackDatep").datepicker("destroy");
		$(".noBackDatep").datepicker({					
				startDate:dtp[0],
				autoclose: true,					
			});		
		
	})

 	$(".user_activity_report_datetimepicker").datetimepicker({
        format: 'DD-MM-YYYY',
		minDate:caDate
    });
    function validateform()
    {
        
        if($('#dateTime').val() == '')
        {
            $('.dateTime_err').html('Please select date time');
        }
        else{
            $('.dateTime_err').empty();
            $('#logfilter').submit();
        }
    }
    // $('#reset').click(function(){
    //     $('#logfilter')[0].reset();
    // });
</script>
<?php global $customJs;
$customJs=ob_get_clean();
?> 