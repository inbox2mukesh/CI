<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    
                </div>
            </div>
            
			
			<?php echo form_close(); ?>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                       
						<th>Description</th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
					//$sessiontypeList=getSessionType();
					$sr=0;
					if(!empty($generalInfo))
					{
					foreach($generalInfo as $p){ $zero=0;$one=1;$pk='id'; $table='counseling_sessions_general_info';$sr++; ?>
                    <tr>
						
						<td><?php echo ucfirst($p['description']); ?></td>
                        
						<td><a href="<?php echo site_url('adminController/counseling_session/general_edit/'.$p['id']);?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"><span class="fa fa-pencil"></span> </a>
                        </td>
                    </tr>
                    <?php } } else {?>
                    	<tr>
                    		<td colspan="7">No record found</td>
                    	</tr>
                    <?php } ?>
                </tbody>
                </table>
                             
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