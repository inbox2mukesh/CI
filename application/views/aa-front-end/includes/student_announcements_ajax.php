<?php
$count=count($announcements->error_message->data); 
if(!empty($announcements->error_message->data))
{
?>
<div class="announcement-box mb-30">
              <div class="row">
                <!-- <div class="col-md-3 text-center"><span class="font-weight-600">ANNOUNCEMENT: </span></div> -->
                <div class="col-md-12">
                  <marquee width="100%" direction="left" scrollamount="6" onmouseover="this.stop()" onmouseout="this.start()"> 

<ul>
<li>
          <?php   
          $i=1;  
        
            foreach($announcements->error_message->data as $p)
            {      
                
              ?><a href="<?php echo base_url('our_students/announcements/'.$p->id);?>"><?php echo ucfirst($p->subject);?><span class="font-12 ml-5  bold" style="color:#4263a1"><i><b><?php echo $p->created;?></b></span></i></a> <?php if($count !=$i){?> &nbsp; | &nbsp; <?php }?> 
              <?php $i++; } ?>
              </li>
          
        </ul>

                   </marquee>
                </div>
              </div>
            </div>
            <?php }?>