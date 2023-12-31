<?php
if (!empty($test_preparation_material->error_message->data) && isset($test_preparation_material->error_message->data) ) {
  foreach ($test_preparation_material->error_message->data as $p) {
    ?>
      <div class="col-md-4 col-sm-6">

<a href="<?php echo base_url()?>test-preparation-material/<?php echo $p->URLslug; ?>">

  <div class="latest-img">

    <div class="img-area"> <img src="<?php echo $p->image;?>" class="img-responsive" alt=""> </div>

    <div class="img-text">

      <h4><?php echo ucwords($p->title);?></h4>

      <div class="font-weight-600 font-12 text-italic">

        <?php echo strtoupper($p->content_type_name);?> <span class="text-theme-colored">(<?php echo $p->topic;?>)</span>

      </div>

      <div class="date mt-10"><?php echo $p->created;?></div>

      <p><?php echo ucfirst($p->description);?></p>

    </div>

  </div>

</a>

</div>
    <?php }
} else { ?>

  <div class="grid-card-container">
    <div class="grid-card">
      <h2 class="text-red">No Post Found</h2>
    </div>
  </div>
<?php } ?>