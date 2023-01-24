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
                  <a href="<?php echo site_url('adminController/counseling_session/index/'); ?>" class="btn btn-danger btn-sm">Counseling Session List
				  </a>
               </div>
            </div>
          	<div class="box-body">
			<?php
				$session_type=$counseling_session_group['session_type'];
				//$sessiontypeList=getSessionType();
				//pr($counseling_session);
				?>
          		<div class="row clearfix">		
					
					<div class="col-md-4">
						<label for="department_name" class="control-label">Session Type:<?php echo ucfirst($counseling_session_group['session_type'])?></label>
						<div class="form-group">
	
						</div>
					</div>
					
					<div class="col-md-4">
						<label for="department_name" class="control-label">Date(From:To) <?php echo date('d-m-Y ',strtotime($counseling_session_group['session_date_from'])); ?> : <?php echo date('d-m-Y ',strtotime($counseling_session_group['session_date_to'])); ?></label>
						<div class="form-group">
	
						</div>
					</div>
					
					<?php if(!empty($counseling_session_group['zoom_link'])){?>
					<div class="col-md-4">
						<label for="department_name" class="control-label">Meeting Link:<a href="<?php echo $counseling_session_group['zoom_link']; ?>" target="_blank" data-toggle="tooltip" title="Click to View" >Link</a>
						</label>
						<div class="form-group">
	
						</div>
					</div>
					<?php }?>
						
                  
                   
					</div>
			</div>
      	</div>
    </div>
</div>
<?php 
$this->load->view('counseling_session/counseling_session_list');
?>

