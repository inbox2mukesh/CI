<?php 
$session_type=$counseling_session_group['session_type'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
		    <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo 'Counseling Session Time Slot List';?></h3>
            	<div class="box-tools">
                    <?php if($GLOBALS['csg_Active'] == 1){?>
                    <a href="<?php echo site_url('adminController/counseling_session/addTimeSlotSingleDate_/'.$counseling_session_group['id']); ?>" class="btn btn-danger btn-sm">Add Time Slot</a> 
                    <?php }?>
                </div>
            </div>
			
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<th>Price</th>	
						<th>DateTime | Day</th>						
						<th>Meeting Link</th>
                        <th>Duration</th>
						<th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
					//$sessiontypeList=getSessionType();
					$sr=0;
					
					foreach($counseling_session as $p){ $zero=0;$one=1;$pk='id'; $table='counseling_sessions';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
						<td><?php echo ucfirst($p['amount']); ?></td>
						 <td><?php echo date('d-m-y h:i A',strtotime($p['session_date_time'])); ?> | <?php echo $p['dayname']; ?></td>
						
						 <td>
                            <?php if(!empty($p['zoom_link'])){ ?>
                            <a href="<?php echo $p['zoom_link']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >Conference Link</a>
                            <?php }else{ echo 'NA';}?>                       
                        </td>
                        <td><?php echo ucfirst($p['duration']); ?></td>
                       
						
                        <td>
                            <?php 
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=counseling_session_activate_deactivete('.$p['id'].','.$zero.',"'.$table.'","'.$p['counseling_sessions_group_id'].'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to Activate" onclick=counseling_session_activate_deactivete('.$p['id'].','.$one.',"'.$table.'","'.$p['counseling_sessions_group_id'].'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
							<?php 
							if($session_type=='online-demo-session' || $session_type=='online-counselling-session'){
							?>
							 <a href="javascript:void(0)" onclick="CopyToClipboard('<?php echo $p['zoom_link']?>', true, 'zoom link copied')" title="copy zoom link"><span class="fa fa-clone"></span> </a>
							<?php 
							}?>
<?php if($p['active'] == 1) {?>

                            <a href="<?php echo site_url('adminController/Counseling_session/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a>
                            <?php }?>
							
							<!--<a href="<?php echo site_url('adminController/Counseling_session/view_details_/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span> </a>
							
                            <a href="<?php echo site_url('adminController/Counseling_session/remove/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>-->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-3.2.1.js');?>"></script>
<script>
function counseling_session_activate_deactivete(id,active,table,counseling_sessions_group_id){
    var idd = '#'+id;
    $.ajax({

        url: "<?php echo site_url('adminController/Counseling_session/activate_deactivete_');?>",
        async : true,
        type: 'post',
        data: {id: id,active: active,table: table,counseling_sessions_group_id:counseling_sessions_group_id},
        dataType: 'json',
        success: function(response){
            if(response==1){
                window.location.href=window.location.href

            }else{
                $(idd).html('');
            }               
        }

    });
}
$(document).ready(function() {
	
	var today = new Date();
	$('#session_date_new').daterangepicker(
	{    
		locale: {
		  format: 'YYYY-MM-DD'
		},
		minDate:"<?php echo $session_date_from?>",
		maxDate:'<?php echo $session_date_to?>',
	}, 
	function(start, end, label) {
		
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
})
</script>