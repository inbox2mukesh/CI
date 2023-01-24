<?php
if ($_SESSION['classroom_id'] and count($allSharedDocs->error_message->data) > 0) { ?>
  <?php
  //  echo "<pre>"; 
  foreach ($allSharedDocs->error_message->data as $p) {
    $con_type_val = "";
    foreach ($p->ContentType as $con_type) {
      //echo $con_type;
      $con_type_val .= $con_type->content_type_name . ', ';
    }
  ?>
<?php include('includes/classroom_material_html.php');?>
  <?php }
} else { ?>
  <div class="col-md-12">
   
      <div class="info">
        <div class="text-red font-weight-500"> No classroom material is available now!</div>
      </div>
   
  </div>
<?php } ?>
