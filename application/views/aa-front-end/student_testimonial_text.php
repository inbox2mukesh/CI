<section>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-3 left-sidebar mob-display">
          <?php include('includes/category_sidebar.php');?> 
        </div>
      <div class="col-sm-12 col-md-9">
          <div class="section-title mb-10">
            <h2 class="text-uppercase font-weight-300 font-28 mt-0">Our <span class="text-red font-weight-500">  Testimonials</span></h2> </div>
         
        <?php
     //   echo "pp";
     //  echo "<pre>"; 
    //print_r($All_TXT_TSMT->error_message->data);
    foreach($All_TXT_TSMT->error_message->data as $p){
?>


          <div class="testimonial mt-20">
            <div class="testimonial-content">
              <div class="testimonial-icon"> <i class="fa fa-quote-left"></i> </div>
              <p class="description"><?php echo $p->testimonial_text;?></p>
            </div>
            <div class="about">
               <?php if($p->image){ ?>
    <div class="pull-left"> <img width="75" height="75" src="<?php echo base_url(TESTIMONIAL_USER_FILE_PATH.$p->image);?>" class="image-border"> 
    </div>
  <?php } ?>
              <div class="title"> <span><?php echo $p->name;?></span>
                <p><?php echo $p->designation_name;?></p> <span class="font-12 font-weight-400"><?php echo $p->tsmt_date;?></span> </div>
            </div>
          </div>
          <?php } ?>
        
          <div class="hide">
            <nav>
              <ul class="pagination theme-colored pull-right xs-pull-center mb-xs-40">
                <li>
                  <a href="#" aria-label="Previous"> <span aria-hidden="true">«</span> </a>
                </li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">...</a></li>
                <li>
                  <a href="#" aria-label="Next"> <span aria-hidden="true">»</span> </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>