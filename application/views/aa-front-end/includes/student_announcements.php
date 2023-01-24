<div id="ann_div">

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

            </div>


<script type="text/javascript">
   $(document).ready(function(){
  //alert('refresing')
    setInterval(function(){
      //alert();
      //console.log('kk')
    refresh_announcements();
          $("<?php echo $idd;?>").load(window.location.href + " <?php echo $idd;?>" );
    }, 60000);// 60000=1m ,300000=5m

  })

   function refresh_announcements()
    {
     //alert('p')
      $.ajax({
        url: "<?php echo site_url('our_students/ajax_announcements');?>",
        type: 'post',
                     
        success: function(response){
       // alert(response)  
        $('#ann_div').html(response);              
        },
        beforeSend: function(){
         // $('.complaintBtnDiv_pro').show(); 
        //  $('#reg_button').prop('disabled', true);
        }
    });

    }

</script>
