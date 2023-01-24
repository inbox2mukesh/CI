<?php 
if(!empty($All_TSMT->error_message->data))
 {
foreach($All_TSMT->error_message->data as $p){ ?>
        <div class="col-md-3 col-sm-6 video-gallery hide">
          <div class="video-box mt-5">
            <div class="embed-responsive embed-responsive-16by9">
              <!--<video src="video/ocean.mp4" controls></video>-->
              <iframe class="testimonial-video" src="<?php echo $p->url;?>" height="80%" width="100%"></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 r-lecture">
                <div class="lecture-video-box mt-5">    
                <a href="#vd<?php echo $p->id?>"><img src=" <?php echo $p->screenshot?>" alt=""></a>
                </div>                
                <div class="disc">
                  <p class="font-weight-600"><?php echo $p->title?></p>
                  <p class="font-weight-600 font-13 text-italic"><?php echo $p->test_module_name?></p>
                  <p class="font-12 text-italic font-weight-600">Date: <?php echo $p->modified?></p>
                </div>              
                <div id="vd<?php echo $p->id?>" class="vd-overlay">
                    <div class="vpopup">
                      <h2><?php echo $p->title?></h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content">
                            <div class="lg-video embed-responsive embed-responsive-16by9">
                            <!--<video autoplay preload="auto" loop="loop" muted="muted" controls disablepictureinpicture controlslist="nodownload noplaybackrate">
                            <source src="<?php echo $p->url?>"> 
                            </video>-->
                            <iframe width="100%"  src="<?php echo $p->url?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                       </div>
                    </div>
                </div>
              </div>
<?php } } else {?>


 <div class="col-md-4 col-sm-6">
          
            <h3>No Result Found</h3>
          
        </div>
  <?php } ?>