<div class="head-title">
  <h2 class="text-uppercase font-weight-300 font-20">SHARED  <span class="text-theme-color-2 font-weight-500">DOCUMENTS</span></h2>
</div>
<div class="text-right"> <a class="btn view-all-btn btn-sm" href="<?php echo base_url('our_students/shared_documents');?>">View All Documents</a></div> 
<?php if(count($sharedDocs->error_message->data)>0){ ?>
<div class="row">
  <?php      
      foreach($sharedDocs->error_message->data as $p){        
  ?> 

   <div class="col-md-2">
    <div class="doc-panel mt-20">
    <a href="<?php echo $p->doc_file_link;?>" target="_blank"><div class="document">
    <img src="<?php echo base_url('resources-f/images/doc-icn.png');?>">
    </div></a>
    <div class="info"><?php echo $p->doc_title;?></div>
    <div class="text-red font-10 text-italic text-center"><?php echo $p->created;?></div>
    </div>
  </div>
<?php } ?>
</div>
<?php }else{ ?>
<div class="classwork-section text-red text-center font-weight-300 font-18 mt-10">
No documents available now!
</div>
<?php } ?>