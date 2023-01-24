<?php if(count($All_PRODUCTS->error_message->data)>0){ ?>
<div class="logo-box box-white mns-80 ">
<div class="grid-container">
						<div class="logo-grid-flex-cont3">
						 <?php 
          foreach($All_PRODUCTS->error_message->data as $p){
            $img = site_url().'uploads/our_products/'.$p->image;
        ?>
							<!--Start Items-->
							<div class="logo-grid-card-container">
								<div class="thumb-grid-card">
									<a href="javascript:void()" target="_blank"><img class="img-responsive" src="<?php echo $img;?>" alt="<?php echo $p->title;?>" ></a>
									<div class="sl-text"><?php echo $p->title;?></div>
								</div>
							</div>
							<!-- End Grid Item-->
							        <?php } ?>
							<!--Start Items-->
							
							
						</div>
					</div>
					</div>
					<?php } ?>
					
					
					