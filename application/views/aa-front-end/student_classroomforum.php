<section class="lt-bg-lighter">
    <div class="container">
      <div class="content-wrapper">
        <!-- Left sidebar -->
          <?php include('includes/student_profile_sidebar_classroom.php');?>
        <!-- End Left sidebar -->
        <!-- Start Content Part -->
        <div class="content-aside classroom-dash-box">
          <div class="announcement-bar text-center">
            <ul>
              <li><span class="font-weight-600">CLASSROOM ID:</span> <?php echo $_SESSION['classroom_name'];?></li>
              <li><span class="font-weight-600">VALIDITY:</span> <?php echo $_SESSION['classroom_Validity'];?></li>
              <li><span class="font-weight-600">DAYS LEFT:</span> <?php echo $_SESSION['classroom_daysleft'];?></li>
            </ul>
          </div>      
          <!-- start announcement -->
          <div class="content-part">
            <div class="top-title mb-20">Classroom Forum</div>
              <div class="classwork-section">
              <?php echo $this->session->flashdata('flsh_msg'); ?>
                <div class="create-post">
                  <div class="post-info p-load">
                    <div class="font-18 text-uppercase mb-10">Create <span class="red-text">Post</span></div>
                      <form action="<?php echo site_url();?>our_students/student_class_post" method="post" enctype="multipart/form-data" id="studentPostForm" onsubmit="return Send_Complaints();"  >
                        <div class="form-group">
                          <textarea placeholder="Write your message here" rows="4" class="txtarea validatewordlimit" name="post_text" id="post_text" data-count=500 data-min=3></textarea>
                            <div class="valid-validation post_text_err  post_text_error"></div> 
                          </div>
                        <div class="row">
                          <div class="col-md-12 mb-10 font-14"> Attach File(s)</div>
                            <div class="col-md-6 text-left">
                              <div class="lt-red-box">
                                <input id="post_image" name="post_image" class="" type="file"> </div>
                              <p class="font-12 mt-5">
                                <span class="name">Supported File Format</span>: .jpg, png and pdf</p>
                                <div class="valid-validation post_image_error"></div> 
                            </div>
                            <div class="col-md-6 text-right"> 
                              <button type="submit" class="btn btn-red post-btn" onclick="return Send_Complaints();" >POST</button>
                            </div>
                      </form>
                  </div>
              </div>
           <?php 
           $stud_id="";
          if($this->session->userdata('student_login_data')->id)
          {
            $stud_id=$this->session->userdata('student_login_data')->id;
          }
          if(count($stdPost->error_message->data)>0){ 
          foreach($stdPost->error_message->data as $p)
          {
            $all_reply=$p->Reply;
            $post_id=$p->post_id;
            if($stud_id == $p->student_id)
            {
              $postBy="You";
            }
            else
             {
                $postBy=$p->by_student_fname.' '.$p->by_student_lname.' ('.$p->by_UID.')';
             }
          ?>
          <div class="posted mt-20 p-load">
            <div class="post-info"><div class="font-16 mb-15">Posted by <?php echo $postBy;?>: <span class="text-red"><?php echo $p->created ?></span>
            </div>
            <div class="cmnt-box"> <?php echo ucfirst($p->post_text);?></div>
            <?php 
            if(!empty($p->post_image)) 
            {  ?>
            <div class="lt-red-box mt-20"> 
              <span class="mr-5">
                <?php
                $post_image=$p->post_image;
                $exp=explode('student_post',$p->post_image);
                $p=explode('.',ltrim($exp[1],'/'));
                if(strtolower($p[1]) !="png" AND strtolower($p[1]) !="jpg" AND strtolower($p[1]) !="jpeg")
                { ?>
                <a href="<?php echo $post_image;?>" class="image-popup-vertical-fit"  title="" style="color: blue;"><?php echo OPEN_FILE;?></a>
                <?php } else {?>
                 <a class="image-popup-vertical-fit" href="<?php echo $post_image;?>" title="">
                    <img src="<?php echo $post_image;?>" class="img-rounded w-h-60">
                 </a><?php }?>
                </span>
              </div><?php }?>
              <form action="<?php echo site_url();?>our_students/student_class_post_comment" method="post" enctype="multipart/form-data" id="" onsubmit="return Send_post_comment(<?php echo $post_id?>);"  >
              <div class="form-group mt-20">
                      <textarea placeholder="Write your message here" rows="3" class="txtarea hide showbtn_<?php echo $post_id?> post_reply_text<?php echo $post_id?>" name="post_reply_text" id="post_reply_text"></textarea>
                      <div class="valid-validation post_reply_text_error<?php echo $post_id?>"></div> 
                    </div>
                    <input type="hidden" class="post_id<?php echo $post_id?>" name="post_id" id="post_id" value="<?php echo $post_id?>"/>
                    <div class="mt-15 text-right"> 
                       <button type="submit" class="btn btn-warning showbtn_<?php echo $post_id?> hide btn_subcomment<?php echo $post_id?>" >Add Comment</button>   
                       <button type="button" data-id="<?php echo $post_id?>" class="btn btn-warning action_comment_btn btn_comment<?php echo $post_id?>"  >Comment</button>   
                    </div>
            </form>
              <hr>
              <!--All comments section-->
          
              <div class="list">  
              <?php 
             
              // <div class="chat-panel mt-20 cmnt-element">
            foreach($all_reply as $re_val) {
             ?>   
               <div class="chat-panel mt-20 ">
                  <div class="chat-info"><?php echo ucfirst($re_val->post_reply_text);?></div>
                  <div class="mt-5 font-11 text-left">Comment added by <?php echo $re_val->by_admin_fname.''.$re_val->by_student_fname.' '.$re_val->by_admin_lname.' '.$re_val->by_student_lname?> (<?php echo $re_val->by_admin_employeeCode .''.$re_val->by_UID?>): <span class="posted-date text-right"><?php echo $re_val->created?></span> </div>
                </div>
              <?php }?>     
              </div>
              <!--Ends All comments section-->
            </div>
          </div>
        <?php } } else {?>
        <div class="posted mt-20 p-load">
          <div class="post-info">
            <h4>No Post Found</h4>
          </div>
        </div>
        <?php 
        }?>
        </div>
          <!-- end classwork post section -->
          <!-- End Document section -->
              <div class="mt-20 text-center hide"> <a href="#" class="btn btn-red btn-md">Load More Posts</a> </div>
              </div>
      </div><!-- end announcement -->       
    </div><!-- End Content Part -->
  </div>
</section>
  <?php 
  $idd = '#'.$_SESSION["firstId"];
?> 
<script src="<?php echo site_url('resources-f/js/jquery.min.js');?>"></script>
<script type="text/javascript">
$('.validatewordlimit').keydown(function (e) {
  var max = $(this).data('count');
  var min = $(this).data('min');
  var id			= $(this).attr('id');
   var id_err 		= id+'_err'; //create class for message display
   var post_text =$(this).val();
   post_text=post_text.trim();
  var len = post_text.split(' ');
  len		= len.length;
  var char = max - len;
  $("."+id_err).text('Entered Word : '+len);
  if (len >= max) {
    $("."+id_err).text('Maximum length should '+ max +' words ');
    if (e.keyCode != 46 && e.keyCode != 8 ) return false;
  } 
  else {
   // $("."+id_err).text('Maximum length should '+ max +' words ');
  }  return true;
  });
  $('.validatewordlimit').change(function (e) {
  var max = $(this).data('count');
  var min = $(this).data('min');
  var id			= $(this).attr('id');
   var id_err 		= id+'_err'; //create class for message display
   var post_text =$(this).val();
   post_text=post_text.trim()
  var len = post_text.split(' ');
  len		= len.length;
  var char = max - len;
  $("."+id_err).text('Entered Word : '+len);
  if (len >= max) {
    $("."+id_err).text('Maximum length should be '+ max +' words ');
    $(this).focus()
    if (e.keyCode != 46 && e.keyCode != 8 ) return false;
  } 
   if(len <3)
  {
    $("."+id_err).text('Minimum length should '+ min +' words ');
    $(this).focus()
    return false;
  }
  //return true;
  

  });
  function Send_Complaints()
    {
    var post_text = $("#post_text").val();
    post_text=post_text.trim()
    var len = post_text.split(' ');
    len		= len.length;
    var attachment_file = $("#post_image").val().split('\\').pop();     
    if(len<3){
      $("#post_text").focus();
      $(".post_text_error").text("Minimum length should 3 words ");
      return false;        
    }
//lert(len)
    //return false;     
    if(attachment_file !="")
    {
    if(validate(attachment_file) == 1)
    {
    $(".post_image_error").text('');
    }else{
    $("#post_image").val('');
    $("#post_image").focus();
    $(".post_image_error").text("File Format not supported!");
    return false;
    }
    }

   /* var form = document.getElementById('studentPostForm'); //id of form
    var formdata = new FormData(form);
 $.ajax({
        url: "<?php //echo site_url('our_students/student_class_post');?>",
           type: 'post',
       // data: form_data,   
     data: formdata,
        processData: false,
        contentType: false, 
        success: function(response)
    { 
     alert(response)
          if(response.status==1)
      {
         //$('#modal-register').modal('hide');
        // $('#modal-reg-OTP').modal('show');  
          window.location.href = "<?php// echo site_url('our_students/student_classroomForum');?>";       
          }
      else
      {
           window.location.href = "<?php //echo site_url('our_students/student_classroomForum');?>";  
          }                  
        },
    });*/
  }
  function validate(file) {
    //alert(file)
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["jpg" , "jpeg", "png",'pdf'];
    if (arrayExtensions.lastIndexOf(ext) == -1) {
      return -1;
        //$("#image").val("");
    }
  else {
    return 1;
  }
}
function Send_post_comment(postid)
{
  var post_reply_text = $(".post_reply_text"+postid).val();
  if(post_reply_text == ''){
     $(".post_reply_text"+postid).focus();
    $(".post_reply_text_error"+postid).text("Please enter you message!");
    return false;
    }
   else if(post_reply_text!='' && post_reply_text.length<=250)
   {
    $(".post_reply_text_error"+postid).text('');
   }
    else{
    $(".post_reply_text"+postid).focus();
    $(".post_reply_text_error"+postid).text("Please enter you message upto 250 chars!");
    return false;
    }
  //return false;
}


$(document).on('click','.action_comment_btn',function(){
  var postid=$(this).attr('data-id');
   $(".showbtn_"+postid).removeClass("hide");
   $(this).addClass("hide");
	// var id=$(this).prev().attr('id')	
  //   var id_err 		= id+'_err';
  //   $("."+id_err).html("");  
});
 </script>

<script>
	$(document).ready(function() {
		$('.image-popup-vertical-fit').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-img-mobile',
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300
			}
		});
	});
	</script>


<?php
 $postBy=null;
?>