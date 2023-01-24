  <!--START GRID ITEM -->
             <?php 
            if(count($ALL_RT->error_message->data)>0){ 
      foreach($ALL_RT->error_message->data as $p){
       $venue="In all branches";  
        foreach($p->Info as $ven_list)
        {
          if(!empty($ven_list->venue))
          {
           $venue=$ven_list->venue;
          }

        }
         
          $id = base64_encode($p->id);
          $bg='blue-box';
                  
          //time
          if($p->time_slot1 and $p->time_slot2 and $p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2.' | '.$p->time_slot3;
          }elseif($p->time_slot1 and $p->time_slot2 and !$p->time_slot3){
              $t = $p->time_slot1.' | '.$p->time_slot2;
          }elseif($p->time_slot1 and !$p->time_slot2){
              $t = $p->time_slot1;
          }else{
              $t = $p->time_slot1;
          } 

          
  ?>
          <div class="grid-card-container">
            <div class="grid-card">
              <div class="ierltest-box mb-30 text-white evn-box">
                <div class="striped font-14">
                  <p class="font-14 font-weight-500"><?php echo substr($p->title, 0,31);?></p>
                  <p class="font-10 font-weight-500"><?php echo $p->test_module_name?></p>
                </div>
                <ul>
                  <li class="font-weight-500 font-13"><i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo $venue;?></li>
                  <li class="text-lt-gray hide">Patiala-Sangrur, Bypass, Phase I, Urban Estate, Patiala, Punjab 147002</li>
                  <li> <i class="fa fa-calendar font-13" aria-hidden="true"></i> <span class="font-12">Date</span>: <span class="font-12"> <?php 
            $date=date_create($p->date);
            echo $date = date_format($date,"M d, Y");
          ?></span> </li>
                  <li> <i class="fa fa-clock-o font-13" aria-hidden="true"></i> <span class="font-12">Time:</span> <span class="font-12"><?php echo $t;?></span> </li>
                </ul>
                <div class="ft-btn"> <span class="font-16 mr-20 font-weight-600">Rs.  <?php echo $p->amount;?></span> <a class="btn btn-white btn-sm" href="<?php echo base_url('book_reality_test/index/'.$id);?>">Book Now</a> </div>
              </div>
            </div>
          </div>
          <!--END GRID ITEM -->
        <?php } } else {
          ?>
         <div class="grid-card-container">
            <div class="grid-card">
                    <h2 class="text-red">No Reality Test Found</h2>
                    
                  
                  
                  </div></div>
       <?php }?>