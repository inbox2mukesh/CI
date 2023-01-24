<section>
    <div class="container">
      <div class="section-title">
        <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0"><?php echo $title;?>  </h2> </div>
      <div class="filter-ylw-box">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="form-group" id="search-icn">
              <input type="text" name="fname" class="fstinput" placeholder="Search"  onkeyup="searchRecentResult();" id="rr_search">
              <button type="submit"><i class="fa fa-search"></i></button>
              <!--                         <div class="validation">Wrong</div>--></div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="form-group">
              <select class="selectpicker form-control" data-live-search="true" onchange="searchRecentResult();" id="rr_content_type">
                <option value="">Select Course</option>

                <?php foreach($AllTestModule_RR->error_message->data as $p)
{ ?>
                <option value="<?php echo $p->test_module_id?>"><?php echo $p->test_module_name?></option>
              <?php }?>
               
              </select>
            </div>
            <!--<div class="validation">Wrong</div>--></div>
          <div class="col-md-12"> <span class="text-left font-weight-600 pull-left hide"  id="flter-btm-info"> <i class="fa fa-spinner fa-spin mr-10"></i> Loading...Please Wait </span> <span class="pull-right font-weight-600" id="down"><a href="<?php echo site_url();?>recent_results">Clear All </a></span> </div>
        </div>
      </div>
      <div class="row popup-gallery" id="rr_section">
  <?php
    foreach($All_RR->error_message->data as $p){
      $img_url = site_url('uploads/recent_results/'.$p->image);
  ?>
        <div class="col-md-4 col-sm-6">
          <div class="shdw mb-30">
            <a href="<?php echo $img_url;?>"><img src="<?php echo $img_url;?>" alt="" title="" class="photo-glry img-rounded"></a>
          </div>
        </div>
            <?php } ?> 
        
      
      
      </div>
    </div>
    <script>
    $(document).ready(function() {
      $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        mainClass: 'mfp-img-mobile',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
      });
    });
    </script>
  </section>

  <script>
 
  function searchRecentResult()
  { 
  
    var rr_content_type  = $("#rr_content_type").val();
    var rr_search  = $("#rr_search").val();
      
       $.ajax({
          url: "<?php echo site_url('recent_results/searchRecentResult');?>",
          async : true,
          type: 'post',
          data: {rr_content_type:rr_content_type,rr_search:rr_search},
          success: function(data){
         
            if(data!=''){
              $('#flter-btm-info').addClass('hide');
               $('#rr_section').html(data);
            }else{
              $('#flter-btm-info').addClass('hide');
              
              $('#rr_section').html(data);
            }          
          },
          beforeSend: function(){
            
            $('#flter-btm-info').removeClass('hide');
            
          },
      });
  
  
    
    

  }
</script>