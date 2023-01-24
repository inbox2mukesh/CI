<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-3 left-sidebar mob-display">
					<?php include('includes/category_sidebar.php');?> 
				</div>
		<div class="col-sm-12 col-md-9">
					<div class="section-title mb-10">
						<h2 class="text-uppercase font-weight-300 font-28 mt-0">ALL OFFERS</h2> </div>
			<div class="announcement">
					
						<div class="panel-group toggle">
							<?php 
	$i=0;    
    foreach($allOffers->error_message->data as $p){

    if($segment==''){
    	if($i==0){
	    	$in='in';
	    } else{
	    	$in='';
	    }
    }elseif($segment==$p->id){
	    	$in='in'; 
    }else{
    	$in='';
    } 
	         
 ?>
							<div class="panel">
								<div class="panel-heading">
									<div class="panel-title"> <a data-toggle="collapse" href="<?php echo '#toggle'.$p->id;?>" class=""><span class="open-sub"></span>
<div class="date-bar">
<div class="title"><?php echo $p->created;?></div><span class="mb-inline"><?php echo $p->subject;?> </span>
</div></a> </div>
								</div>
								<div id="<?php echo 'toggle'.$p->id;?>" class="panel-collapse collapse <?php echo $in;?>">
									<div class="panel-body"> 
<?php 
				if($p->media_file){
			?>
										<img src="<?php echo site_url('uploads/offers/'.$p->media_file);?>" class="pull-left col-md-5 img-mob-wdth n-pl" alt="<?php echo $p->subject;?>" title="<?php echo $p->subject;?>">
										<?php } ?>
										<p><?php echo $p->body;?></p>
									</div>
								</div>
							</div>
							<?php $i++;} ?>
									
					
							
						
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>