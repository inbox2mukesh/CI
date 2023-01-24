<?php if (count($announcements->error_message->data) > 0) { ?>
						<?php if ($_SESSION['classroom_id']) { ?>
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<?php
								$i = 0;
								foreach ($announcements->error_message->data as $p) {
									/* if ($segment2 == '') {
										if ($i == 0) {
											$in = 'in';
										} else {
											$in = '';
										}
									} elseif ($segment2 == $p->id) {
										$in = 'in';
									} else {
										$in = '';
									} */
                  $in = '';
                  if($open == 1 && $i == 0)
{
  $in = 'in';
}
$custom_class="";
									if(empty($p->media_file) and empty($p->body)){
										$custom_class="no-panel-body";
									}

								?>
									<div class="panel">
										<div class="panel-heading">
											<div class="panel-title <?php echo $custom_class;?>"> <a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#toggle' . $p->id; ?>" class=""><span class="open-sub"></span>
													<div class="date-bar">
														<div class="title"><?php echo $p->created; ?></div><span class="mb-inline"><?php echo $p->subject; ?> </span>
													</div>
												</a> </div>
										</div>
										<?php
											if($p->media_file or $p->body){
										?>
										<div id="<?php echo 'toggle' . $p->id; ?>" class="panel-collapse collapse <?php echo $in;?>">
											<div class="panel-body"> <?php
																		if ($p->media_file) {
																			//str_replace("./","",ANNOUNCEMENT_FILE_PATH);
																		?>
								<img src="<?php echo site_url(str_replace("./","",ANNOUNCEMENT_FILE_PATH). '' . $p->media_file); ?>" class="pull-left img-responsive col-md-5 no-padding-left">
												<?php } ?>
												<?php echo $p->body; ?>
											</div>
										</div>
										<?php }?>
									</div>
								<?php $i++;
								} ?>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="info">
							<h2 class="text-red">No Announcement Found</h2>
						</div>
					<?php
					} ?>