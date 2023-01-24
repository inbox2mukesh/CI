

	<!--Start FAQ Section-->

	<section class="bg-lighter">

		<div class="container faq">

			<h2 class="font-weight-300 text-uppercase text-center"><?php echo $title1;?> <span class="text-red font-weight-600"><?php echo $title2;?></span></h2>

			<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">

				<?php

					$i=0; 

					foreach ($faqData->error_message->data as $d) {

					$collapseId= 'collapse'.$d->id;

					if($i==0){

						$in='in';

						$aria_expanded='true';

					}else{

						$in='';

						$aria_expanded='false';

					}

				?>					

				<div class="panel panel-default mb-10">

					<div class="panel-heading" role="tab" id="<?php echo $d->id;?>">

						<h4 class="panel-title">

      					<a role="button" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#'.$collapseId;?>" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="<?php echo $collapseId;?>">

       					<p style="padding: 0px;margin: 0px 10px 0px 0px;"><?php echo $d->question; ?></p>

      					</a>

    					</h4> 

    				</div>

					<div id="<?php echo $collapseId;?>" class="panel-collapse collapse <?php echo $in; ?>" role="tabpanel" aria-labelledby="<?php echo $d->id; ?>">

						<div class="panel-body"> <?php echo $d->answer; ?> </div>

					</div>

				</div>

				<?php $i++; } ?>

				

			</div>

		</div>

	</section>

	<!--End FAQ Section-->

