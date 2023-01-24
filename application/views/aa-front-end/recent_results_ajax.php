  <?php
 if(!empty($All_RR->error_message->data ))
 {
    foreach($All_RR->error_message->data as $p){
      $img_url = site_url('uploads/recent_results/'.$p->image);
 
  ?>
        <div class="col-md-4 col-sm-6">
          <div class="shdw mb-30">
            <a href="<?php echo $img_url;?>"><img src="<?php echo $img_url;?>" alt="" title="" class="photo-glry img-rounded"></a>
          </div>
        </div>
            <?php } } else {?>

 <div class="col-md-4 col-sm-6">
          
            <h3>No Result Found</h3>
          
        </div>
              <?php }?> 