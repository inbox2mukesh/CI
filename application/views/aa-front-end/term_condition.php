<section class="bg-lighter terms">
		<div class="container">
			<div class="section-title mb-10">
				<?php if(!empty($GET_CONTENTS->error_message->data)) { ?>
				<h2 class="text-uppercase font-weight-300 font-28 mt-0"><span class="text-red font-weight-500">  <?php echo $GET_CONTENTS->error_message->data->content_title;?></span></h2> </div>
				<div class=""><?php echo $GET_CONTENTS->error_message->data->content_desc;?></div>
				<?php } else { ?>
					<h2 class="text-uppercase font-weight-300 font-28 mt-0"><span class="text-red font-weight-500">
					<?php echo $GET_CONTENTS->error_message->message ; ?>
				<?php } ?>
				</span></h2>
		</div>
</section>