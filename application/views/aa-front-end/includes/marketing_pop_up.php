<script type="text/javascript">
  $(document).ready(function(){
$("#myModal").modal('show');
}); 
</script>
<?php
$homePopUp = get_cookie('homePopUp');

  if(count($mPopupData->error_message->data)>0 and $homePopUp!='no'){ 
    foreach($mPopupData->error_message->data as $p)
    {
    	//print_r($p);
?>

<div class="main-modal">
	<div id="myModal" class="modal fade Pop">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-body">
				
					<div class="modal-img-info">
						<button type="button" class="m-close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
						<a href="<?php echo $p->link;?>" target="_blank"><img src="<?php echo site_url('uploads/marketing_popups/'.$p->image);?>"></a>
					</div>
					<div class="m-title"><?php echo $p->title;?></div>
					<div class="m-modal-info" id="scroll-style">						
						<p> <?php echo $p->desc;?></p>
						
					
					</div>
					<div class="text-center mt-20">
						<a href="<?php echo $p->link;?>" target="_blank" class="btn btn-red btn-mdl text-uppercase">CONTINUE</a>
						</div>
				</div>
			</div>
		</div>
	</div>
		</div>

<?php set_cookie('homePopUp','no','86400'); }} ?>