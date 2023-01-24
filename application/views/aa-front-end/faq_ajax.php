<?php 
if(!empty($allFaq->error_message->data))
{
    $i=0;
    foreach ($allFaq->error_message->data as $p) { 
      if($i==0){
        $in='in';
      }else{
        $in='';
      }
  ?>
            <div class="panel">
              <div class="panel-title">
                <a data-parent="#accordion1" data-toggle="collapse" href="<?php echo '#accordion-'.$p->id ?>" aria-expanded="true"> <span class="open-sub"></span><?php echo $p->question;?></a>
              </div>
              <div id="<?php echo 'accordion-'.$p->id ?>" class="panel-collapse collapse <?php echo $in;?>" role="tablist" aria-expanded="true">
                <div class="panel-content">
                  <p><?php echo $p->answer;?></p>
                </div>
              </div>
            </div>
             <?php $i++;} } else {
              ?>
              No FAQ'S found
              <?php 
             }?>          
            