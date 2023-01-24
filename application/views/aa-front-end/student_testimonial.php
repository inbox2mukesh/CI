<section>
    <div class="container">
      <div class="section-title">
        <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0"><?php echo $title;?> </h2> </div>
      <div class="filter-ylw-box">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="form-group" id="search-icn">
              <input type="text" name="fname" class="fstinput" placeholder="Search" onkeyup="searchTestimonial();" id="testimonial_select">
              <button type="submit"><i class="fa fa-search"></i></button>
              <!--                         <div class="validation">Wrong</div>--></div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="form-group">
              <select class="selectpicker form-control" data-live-search="true" onchange="searchTestimonial();" id="testtype_select">
                <option value="">Select course</option>
               <?php
                  foreach($TSMT_COURSE->error_message->data as $p){
                  ?>
                  <option value="<?php echo $p->test_module_id;?>"><?php echo $p->test_module_name;?></option>
                  <?php } ?>
              </select>
            </div>
            <!--                       <div class="validation">Wrong</div>--></div>
          <div class="col-md-12" > <span class="text-left font-weight-600 pull-left hide" id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i>Loading...Please Wait </span> <span class="pull-right font-weight-600" id="down"><a href="<?php site_url();?>student_testimonial/">Clear All </a></span> </div>
        </div>
      </div>
      <div class="row recorded-lecture" id="testimonial_section">
        <?php 
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
<?php } ?>       
       
     
      </div>
    </div>
  </section>
  <script>
 function searchTestimonial()
  { 
  //alert('hhh')

    var testtype_select  = $("#testtype_select").val(); 
    var search  = $("#testimonial_select").val();
     $.ajax({
          url: "<?php echo site_url('student_testimonial/searchTestimonial');?>",
          async : true,
          type: 'post',
          data: {testtype_select:testtype_select,testimonial_select:search},
          success: function(data){
        //  alert(data)
            //  return false;
            if(data!=''){
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.success-res').show();*/
              $('#testimonial_section').html(data);
            }else{
              $('#flter-btm-info').addClass('hide');
              /*$('.processing-res').hide();
              $('.no-res').show();
              $('.success-res').hide();*/
              $('#testimonial_section').html(data);
            }          
          },
          beforeSend: function(){            
            $('#flter-btm-info').removeClass('hide');             
          },
      });   
}
</script>