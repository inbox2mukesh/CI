<section>
	<div class="container">			
	<div class="head-title font-weight-400 text-uppercase">Latest <span class="text-red font-weight-600">News</span></div>
			<div class="row">
				<div class="col-md-8">							
					<div class="lt-news-head clearfix mb-20">
						<div class="input-group pull-right">
							<div class="form-group has-feedback has-clear">
								<input type="text" placeholder="Search" class="form-control search-input" name="searchText" id="searchText" onchange="searchNews()" onInput="checkStr(this.value)">
								<span id="clear_btn" class="form-control-clear fa fa-close form-control-feedback hidden"></span>
							</div>
							<span class="input-group-btn">
								<button type="submit" class="btn search-button"><i class="fa fa-search text-black"></i></button>
							</span>
						</div>
						<?php if($uri){ ?>
						<span class="lt-news-reset"><a href="<?php echo base_url('latest_news');?>" ><i class="fa fa-refresh text-red"></i> Reset all news</a></span>
						<?php } ?>
					</div>

					<div class="resp">					
					<?php 
						foreach ($newsData->error_message->data  as $d) { 
						$date=date_create($d->news_date);
                        $news_date = date_format($date,"M d, Y");
                        if($d->is_pinned==1){
                        	$pin = '<span class="text-red"><i class="fa fa-thumb-tack"></i></span>';
                        }else{
                        	$pin ='';
                        }
					//	echo $d->URLslug;
					?>
					<a href="<?php echo base_url('news_article/'.$d->URLslug);?>"> 
						<div class="news-panel-info">
							<div class="disc">
								<img src="<?php echo base_url('uploads/news/'.$d->card_image);?>" alt="" title="" class="pull-right img-responsive ml-15">
									<h3><?php echo $pin;?> <?php echo $d->title;?></h3> <span class="date"><?php echo $news_date;?></span>
									<p> <?php echo  substr(strip_tags($d->body), 0,120);?></p>
							</div>
						</div>				
					</a>
					<?php } ?>
					<!--Start Pagination-->
					<div class="text-center">
						<nav aria-label="Page navigation example">
							<!-- <ul class="pagination"> -->
							<?php echo $this->pagination->create_links(); ?>   
							<!-- </ul> -->
						</nav>
					</div>
				</div>
					<!-- <div class="text-center">
						<nav aria-label="Page navigation example">
							<ul class="pagination">
								<li class="page-item">
									<a class="page-link" href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> <span class="sr-only">Previous</span> </a>
								</li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
									<a class="page-link" href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> <span class="sr-only">Next</span> </a>
								</li>
							</ul>
						</nav>
					</div> -->
				</div>
				<div class="col-md-4">
					<?php include('new_pinned_tag_section.php');?>
				</div>
			</div>
		</div>
</section>
<script type="text/javascript">	
		function searchNews(){			
			var html='';
    		var searchText  = $("#searchText").val();
	    	$.ajax({
		        url: "<?php echo site_url('latest_news/getSearchedNews');?>",
		        async : true,
		        type: 'post',
		        data: {searchText: searchText},
		        dataType: 'json',                
		        success: function(data){ 
		            if(data.length>0){
			            for(i=0; i<data.length; i++){
			                if(data[i]['is_pinned']==1){
			                    pin= '<span class="text-red"><i class="fa fa-thumb-tack"></i></span>';
			                }else{
			                    pin='';
			                }
			                var id = data[i]['URLslug'];	
			                imagePath='<?php echo base_url();?>' + 'uploads/news/' +data[i]['card_image'];
			                href= '<?php echo base_url();?>' + 'news_article/' + id;
			                body = data[i]['body'];							
			                body= $(body).text().substring(0,120);
							news_date= data[i]['news_date']; 
			                html += '<div class="news-panel-info"><div class="disc"><a href='+href+'> <img src='+imagePath+' alt="'+data[i]['title']+'" title="'+data[i]['title']+'" class="pull-right img-responsive ml-15"><h3>'+pin+' '+data[i]['title']+'</h3> <span class="date">'+news_date+'</span><p> '+body+'</p></a></div></div>';             
			            } 
		            	$('.resp').html(html);
		            }else{
		            	html='<div class="img-text"><h4> No Result...</h4><div class="ft-btn text-center btn btn-blue btn-circled btn-sm mt-5" onclick="reload_page();">Show all News <i class="fa fa-chevron-right font-10"></i></div></div>';
		            	$('.resp').html(html);
		            }
	            } 
	    	});
		}
		function reload_page(){
			window.location.href='<?php echo current_url(); ?>'
		}
</script>
<script>
$('.has-clear input[type="text"]').on('input propertychange', function() {
  var $this = $(this);
  var visible = Boolean($this.val());
  $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
}).trigger('propertychange');
//$('#clear_btn').removeClass('hidden');

$('.form-control-clear').click(function() {
  $(this).siblings('input[type="text"]').val('')
	$('#clear_btn').addClass('hidden')
    .trigger('propertychange').focus();
});
	 function checkStr(str)
	 {
		 if(str.length>0)
			 {
				 $('#clear_btn').removeClass('hidden');
			 }
		 else
			 {
				 $('#clear_btn').addClass('hidden');
			 }
	 }
 </script>