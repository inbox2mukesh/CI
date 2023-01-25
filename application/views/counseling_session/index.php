<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                    if(ENVIRONMENT=='development' or ENVIRONMENT=='testing')
                    {
                    ?>
                <a href="<?php echo site_url('adminController/ERP_settings/empty_counselling'); ?>" class="btn btn-danger btn-sm">Empty Data</a> 
                <?php }?>
                    <a href="<?php echo site_url('adminController/counseling_session/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                </div>
            </div>
            
			
			<?php echo form_close(); ?>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<th>Session Type</th>
						<th>Price</th>						
						<th>Date(from:to)</th>
						<th>Meeting Link</th>
						<th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
					//$sessiontypeList=getSessionType();
					$sr=0;
					if(!empty($counseling_session))
					{
					foreach($counseling_session as $p){ $zero=0;$one=1;$pk='id'; $table='counseling_sessions_group';$sr++; ?>
                    <tr>
						<td><?php echo $sr; ?></td>
						<td><?php echo ucfirst($p['session_type']); ?></td>
                        <td><?php echo ucfirst($p['amount']); ?></td>
						 <td><?php echo date('d-m-Y ',strtotime($p['session_date_from'])); ?> : <?php echo date('d-m-Y ',strtotime($p['session_date_to'])); ?></td>
						 <td>
                            <?php if(!empty($p['zoom_link'])){ ?>
                            <a href="<?php echo $p['zoom_link']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >Conference Link</a>
                            <?php }else{ echo 'NA';}?>                       
                        </td>
                        
                        <td>
                            <?php 
                            if($p['active']==1){
								
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete('.$p['id'].','.$zero.',"'.$table.'","'.$pk.'") >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Click to Activate" onclick=activate_deactivete('.$p['id'].','.$one.',"'.$table.'","'.$pk.'") >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
						    <?php 
							if($p['session_type']=='online-demo-session' || $p['session_type']=='online-counselling-session'){
							?>
							
						    <a href="javascript:void(0)" onclick="CopyToClipboard('<?php echo $p['zoom_link']?>', true, 'zoom link copied')" title="copy zoom link"><span class="fa fa-clone"></span> </a>
                            <?php 
							}?>
							<a href="<?php echo site_url('adminController/counseling_session/view_details_/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span> </a> 
							<!--<a href="<?php echo site_url('adminController/counseling_session/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                            <a href="<?php echo site_url('adminController/counseling_session/remove_sessions_group/'.$p['id']); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash"></span> </a>-->
                        </td>
                    </tr>
                    <?php } } else {?>
                    	<tr>
                    		<td colspan="7">No record found</td>
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
$(document).ready(function() {
	
	var today = new Date();
	$('#session_date_new').daterangepicker(
	{    
		locale: {
		  format: 'YYYY-MM-DD'
		},
		//minDate:"<?php echo $session_date_from?>",
		//maxDate:'<?php echo $session_date_to?>',
	}, 
	function(start, end, label) {
		
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
})
function counseling_session_activate_deactivete(id,active,table){
    var idd = '#'+id;
    $.ajax({

        url: "<?php echo site_url('adminController/Counseling_session/activate_deactivete_');?>",
        async : true,
        type: 'post',
        data: {id: id,active: active,table: table},
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
</script>