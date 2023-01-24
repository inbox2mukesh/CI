<?php 
         if(count($REC_LEC_URL->error_message->data)>0){ 
        $i=1;
foreach($REC_LEC_URL->error_message->data as $p){

        ?>         
           <?php include('includes/classroom_recorded_lecture_withoutrefresh_html.php');?>
        <?php $i++;} } else {
          ?>
           <div class="col-md-12">
              <div class="info">
              <div class="text-red font-weight-500">No recorded lectures found!</div>  
            </div>
          </div>
          <?php
        }?>




<!--Video Modal-->
<script>

$(document).ready(function() { 

    $(".rcd-lecture").each(function(i){		

          $(this).addClass("c-"+i);		

          $(this).children().eq(0).click(function(){	

            $(".c-"+i).find(".video-popup-widget").css("display","block");	

            $("body").append("<div class='video-overlay'></div>");

              $('.media-start').get(i).currentTime = 0;
    
          });

        });	

  });


$(".video-popup-widget .close-tag").click(function(){
 
    //alert("ds,fhsdkj");
  
    $('.media-start').each(function(i){
      
    $(".video-popup-widget").css("display","none");

        $(".video-overlay").remove();

        $(this).get(i).currentTime = 0;

    })

})

</script>
<!--End Video Modal-->
