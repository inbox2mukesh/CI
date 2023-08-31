<style>
	/* Marketing Popup */
#marketingpopup .modal-dialog {background: none;width: 90%; max-width: 650px;border-radius: 10px;position: relative;margin-top: 0 !important;
    margin-bottom: 0 !important;box-shadow: none;height:100%;animation: opt-animation3 0.1s;margin: 0 auto;}
#marketingpopup .modal-dialog .modal-content {padding: 0;box-shadow: none;border: none;height: 100%;position: relative;display: flex;flex-direction: column;justify-content: center;background: none;}
#marketingpopup .modal-dialog .modal-header {border: none;padding: 0;position: relative;}
#marketingpopup .modal-dialog .modal-header .close { margin-top: -1px;font-size: 3rem;color: #000;font-weight: 300;opacity: 9;position: absolute;right: 25px !important;top: 25px;background: #fff;width: 40px;height: 40px;border-radius: 25px;z-index: 9;box-shadow: 0px 0px 4px 0px #000;line-height: 26px;}
.modal-body {position: relative;padding: 15px;}
#marketingpopup .marketingpopup-slider .marketing-inner-cont {background: #fff;padding: 5px;border-radius: 15px;text-align: center;display: block !important;}
#marketingpopup .marketingpopup-slider .marketing-inner-cont .marketing-img-cont {width: 100%;display: block;}
.marketing-img-cont img { min-height: 30vh;}
#marketingpopup .marketingpopup-slider .marketing-inner-cont h2 {text-align: center;font-size: 1.5rem;margin: 0;padding: 15px;text-transform: capitalize;}
#marketingpopup .marketingpopup-slider .marketing-inner-cont p {line-height: 30px;font-size: 1rem;word-wrap: break-word;padding: 8px;}
#marketingpopup .marketingpopup-slider .marketing-inner-cont a { margin: 20px auto 0;display: inline-flex !important;background: #d9070a; width: 100%;max-width: 200px;color: white;padding: 15px !important;font-size: 16px !important;text-transform: uppercase;font-weight: bold !important;white-space: normal;justify-content: center;margin-bottom: 25px;}
.marketing{overflow: hidden;}
@keyframes opt-animation3 {
    0% {
        opacity: 0;
        transform: scale(0.70);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
@-webkit-keyframes opt-animation3 {
    0% {
        opacity: 0;
        transform: scale(0.70);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
@-moz-keyframes opt-animation3 {
    0% {
        opacity: 0;
        transform: scale(0.70);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
@-o-keyframes opt-animation3 {
    0% {
        opacity: 0;
        transform: scale(0.70);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
<!-- marketingpopup -->
<?php 
if(count($marketingPopupsData)>0){ 
    //foreach($marketingPopupsData as $p)
    //{
    	
?>
<div class="modal fade modal-vcenter" id="marketingpopup" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg opacity-animate3">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close " data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="marketingpopup-slider" data-fullscreen="true">
						<div class="marketing-inner-cont">
							<div class="marketing-img-cont">
								<img src="<?php echo site_url('uploads/marketing_popups/'.$marketingPopupsData['image']);?>" alt="marketing" alt="">
							</div>
							<h2 class="marketing-heading"><?php echo $marketingPopupsData['title'];?></h2>
							<p class="marketing-para"><?php echo $marketingPopupsData['desc']; ?></p>
							<a href="<?php $marketingPopupsData['link'];?>" target="_blank" class="btn marketing-link">Read More</a>
						</div>							
					</div>					
				</div>
			</div>
		</div>
	</div>
	<script>		
		$(document).ready(function(){       
			$('#marketingpopup').modal('show');

			window.onload = function () {
				$("html").addClass("marketing");
				$("body").addClass("body-marketing");
			}

			$(document).on("click", "#marketingpopup .close", function(){
				$(".modal").removeClass("in");
				$(".modal").removeAttr("style");
				$(".modal-backdrop").removeClass("in");
				$("html").removeClass("marketing");
				$("body").removeClass("body-marketing");
			})			
		}); 	
	</script>	
	<?php set_cookie('MarketingPopUp','no','86400'); }//}?>