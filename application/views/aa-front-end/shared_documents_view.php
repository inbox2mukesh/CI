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
              <li><span class="font-weight-600">CLASSROOM ID:</span><?php echo $_SESSION['classroom_name'];?></li>
              <li><span class="font-weight-600">VALIDITY:</span><?php echo $_SESSION['classroom_Validity'];?></li>
              <li><span class="font-weight-600">DAYS LEFT:</span><?php echo $_SESSION['classroom_daysleft'];?></li>
            </ul>
          </div>
          <div class="content-part">
          	<?php
          	$doc_title="";
						$data1=$allSharedDocsDesc->error_message->data;

						$con_type_val="";
					  foreach($data1->ContentType as $con_type)
			      {
			      	$con_type_val.=$con_type->content_type_name.', ';
			      }
          	?>
					<div class="text-right mb-10"><a href="<?php echo site_url('our_students/shared_documents')?>"><span class="btn btn-default btn-sm"><i class="fa fa-angle-left mr-5"></i>Back</span></a></div>
							<!-- <div class="top-title mb-5"><?php //echo $data1->Content->title;;?> </div>
						<p class="font-weight-600 mb-5">Topic: <?php //echo rtrim($con_type_val,', ');?></p>
						<p><?php //echo $data1->Content->created;?>  </p> -->
						<?php
						foreach($data1->ContentDesc as $ContentDesc)
            {

            	if($ContentDesc->type == 'text')
							{
							?>
								<?php echo ucfirst($ContentDesc->section)?>
						<?php }
						if($ContentDesc->type == 'image')
							{
                $filename=base_url().'uploads/classroom_documents/image/'.$ContentDesc->section;
                $file_parts = pathinfo($filename);
                if($file_parts['extension'] =='pptx' || $file_parts['extension'] =='ppt' )
                {
                // echo $pptfile=base_url().''."uploads/classroom_documents/image/".$ContentDesc->section;
                // echo $pptfile= base64_encode($pptfile);
                  ?>
                  <div class="pdf-main-widget">

               <div class="pdf-cont">

                  <div class="pdf-heading" style="display:none">
                      <div class="top-title mb-5"><?php echo $data1->Content->title;;?> </div>
                      <div class="closed-pdf" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></div>
                   </div>

                 <main>
                   <h3>Open a PDF file</h3>
                   <canvas class="pdf-viewer hidden"></canvas>
                 </main>

                 <div class="right-side-main">
                      <div class="top-title mb-5"><?php echo $data1->Content->title;;?> </div>
                      <p class="font-weight-600 mb-5">Topic: <?php echo rtrim($con_type_val,', ');?></p>
                      <p><?php echo $data1->Content->created;?></p>
                      <div class="open-pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> View PDF</div>
                </div>

                 <div class="pdf-footer" style="display:none">
                   <ul style="margin-bottom:3px!important">
                     <li style="display:none;">
                       <button id="openPDF">
                         <span>Open</span> <i class="fa fa-folder-open"></i>	</button>
                       <input type="file" id="inputFile" hidden>
                     </li>

                     <!-- <li class="closed-pdf" style="display:none;">
                       <i class="fa fa-times-circle"></i>
                     </li> -->

                     <li class="pdf-pagination">
                       <button id="previous"><i class="fa fa-chevron-left"></i></button>
                       <span id="current_page">0 of 0</span>
                       <button id="next"><i class="fa fa-chevron-right"></i></button>
                     </li>
                    	<li style="display:none;">
                       <span id="zoomValue">150%</span>
                       <input type="range" id="zoom" name="cowbell" min="100" max="300" value="150" step="50" disabled>
                     </li>
                   </ul>
                 </div>
               </div>

               </div>

              <?php

                }
                else
                {
                  ?>
                 <div>
                  <img src="<?php echo base_url();?>uploads/classroom_documents/image/<?php echo $ContentDesc->section?>" class="img-fullwidth mt-20 mb-20 img-shd">
                </div>
                  <?php
                }

							?>

						<?php }
						if($ContentDesc->type == 'video')
							{
							?>
								<div class="embed-responsive embed-responsive-16by9 mt-20 mb-20 text-center">
						<video src="<?php echo base_url();?>uploads/classroom_documents/video/<?php echo $ContentDesc->section?>" controls disablepictureinpicture controlslist="nodownload noplaybackrate"></video>
						</div>
						<?php }

if($ContentDesc->type == 'audio')
{
  ?>


<template>
<style>
  .img-shd{border-radius: 10px;}
  #audio-player-container .audioplay-widget h5{font-size:16px!important;margin-bottom:10px}
  #audio-player-container button{padding:0;border:0;cursor:pointer;outline:none;}
  #audio-player-container {box-shadow: 0 0px 5px rgb(0 0 0 / 22%);    margin:0px auto 20px;    padding: 15px 20px;    border-radius: 8px;    width: 480px;}
  #audio-player-container::before{position:absolute;content:'';z-index:-1}
  #audio-player-container #volume-slider::-webkit-slider-runnable-track {background: rgba(0 0 0 / 80%);}
  #audio-player-container #volume-slider::-moz-range-track {background: rgba(0 0 0 / 80%);}
  #audio-player-container #volume-slider::-ms-fill-upper {background: rgba(0 0 0 / 80%);}
  #audio-player-container #volume-slider::before {    width: var(--volume-before-width);    background: #000;}
  #audio-player-container input[type="range"]{position:relative;-webkit-appearance:none;margin:0;padding:0;height:19px;margin:0;outline:none;width:300px}
  #audio-player-container input[type="range"]::-webkit-slider-runnable-track {width: 100%;height: 3px;cursor: pointer; background: linear-gradient(to right, rgba(255, 0, 0, 0.8) var(--buffered-width), rgba(255, 0, 0, 0.8) var(--buffered-width));}
  #audio-player-container input[type="range"]::before{position:absolute;content:"";top:8px;left:0;    width:var(--seek-before-width);height:3px;background-color:red;cursor:pointer}
  #audio-player-container input#seek-slider::before { position: absolute;  content: "";  top: 4px;  left: 0;  width: var(--seek-before-width);  height: 10px;
  background:  linear-gradient(to right, rgba(255, 0, 0, 0.8), rgba(255, 0, 0, 0.8)); cursor: pointer; border-radius: 8px; }
  #audio-player-container input#seek-slider::-webkit-slider-runnable-track{border-radius:8px;width:100%;height:10px;cursor:pointer;background:#999}
  #audio-player-container input#seek-slider::-webkit-slider-thumb{position:relative;-webkit-appearance:none;box-sizing:content-box;border:1px solid #999;height:px;width:0;border-radius:8px;background-color:#fff;cursor:pointer;margin:-7px 0 0;opacity:0}
  #audio-player-container input[type="range"]::-webkit-slider-thumb{position:relative;-webkit-appearance:none;box-sizing:content-box;border:1px solid #999;height:15px;width:4px;border-radius:8px;background-color:#fff;cursor:pointer;margin:-7px 0 0}
  #audio-player-container .heading-txt h5{font-size:16px!important;padding:0;margin:0 0 10px}
  #audio-player-container .heading-txt{margin-bottom:20px}
  #audio-player-container .vl-area {  margin: 15px 0;  display: flex;    gap: 0 6px;    align-items: center;}
  #audio-player-container  button#play-icon{border: 1px solid #fff;  background:#db261f;background:#db261f;padding:14px 35px;color:#fff;border-radius:4px;line-height:0;text-align:center;width:120px;font-size:15px;margin-right:50px}
  #audio-player-container  button#play-icon.display {   background: #db261f;    background: #fff;    padding: 14px 35px;    color: #fff;    border-radius: 4px;    line-height: 0;    text-align: center;    width: 120px;    font-size: 15px;    margin-right: 50px;    border: 1px solid red;    color: #000;}
  #audio-player-container #play-icon span:nth-child(2){display:none}
  #audio-player-container #play-icon.display span:nth-child(2){display:block}
  #audio-player-container  #play-icon.display span:nth-child(1){display:none}
  #audio-player-container #cpb span:nth-child(2){display:none}
  #audio-player-container #cpb.pausetxt span:nth-child(2){display:block}
  #audio-player-container  #cpb.pausetxt span:nth-child(1){display:none}
  #audio-player-container #cpb{margin:-6px 0 0 176px;font-size:14px;color:#666;text-transform:capitalize}
  #audio-player-container #mute-icon { background: url(https://westernoverseas.ca/newca/testfl/volume.png) no-repeat 0 0; width: 16px;   height: 16px; }
  #audio-player-container #mute-icon.mute {  background: url(https://westernoverseas.ca/newca/testfl/muted.png) no-repeat 0 0!important; }


@media screen and (min-width: 220px) and (max-width:600px) {
	#audio-player-container button#play-icon{width: auto;}
	#audio-player-container .vl-area{display: inherit;}
	#audio-player-container input[type="range"]{width: 100%; margin-top: 5px;}
	#audio-player-container{width:80%;}
	#audio-player-container #cpb{margin:5px 0px;}
	}


</style>

<div id="audio-player-container">
        <div class="heading-txt">
            <h5>Audio</h5>
            <div>Click on play and adjust your volumn.</div>
        </div>
        <audio src="<?php echo base_url();?>uploads/classroom_documents/audio/<?php echo $ContentDesc->section?>" preload="metadata" loop=""></audio>
        <div class="vl-area">
            <output id="volume-output" style="display:none">100</output>
            <button id="mute-icon"></button>
            <input type="range" id="volume-slider" max="100" value="100">
        </div>
        <div class="pp-area">
            <button id="play-icon"><span>Play</span><span>Pause</span></button>
            <span id="current-time" class="time" style="display:none">0:00</span>
            <input type="range" id="seek-slider" max="100" value="0">
            <div id="cpb"><span>click Play Button</span><span>Playing Audio</span></div>
            <span id="duration" class="time" style="display:none">0:00</span>
        </div>
  </div>
</template>
<audio-player data-src2="<?php echo base_url();?>uploads/classroom_documents/audio/<?php echo $ContentDesc->section?>"></audio-player>

<script type="module">
  import lottieWeb from 'https://cdn.skypack.dev/lottie-web';
  class AudioPlayer extends HTMLElement {
      constructor() {
        super();
        const template = document.querySelector('template');
        const templateContent = template.content;
        const shadow = this.attachShadow({ mode: 'open' });
        shadow.appendChild(templateContent.cloneNode(true));
      }
      connectedCallback() {
        everything(this);
      }
  }

  const everything = function (element) {

    const shadow = element.shadowRoot;

    const audioPlayerContainer = shadow.getElementById('audio-player-container');
    const playIconContainer = shadow.getElementById('play-icon');


    const seekSlider = shadow.getElementById('seek-slider');
    const volumeSlider = shadow.getElementById('volume-slider');
    const cpb = shadow.getElementById('cpb');

    const muteIconContainer = shadow.getElementById('mute-icon');
    const audio = shadow.querySelector('audio');
    const durationContainer = shadow.getElementById('duration');
    const currentTimeContainer = shadow.getElementById('current-time');
    const outputContainer = shadow.getElementById('volume-output');
    let playState = 'play';
    let muteState = 'unmute';
    let raf = null;

    audio.src = element.getAttribute('data-src2');

    const playAnimation = lottieWeb.loadAnimation({
      container: playIconContainer,
      renderer: 'svg',
      loop: false,
      autoplay: false,
      name: "Play Animation"
    });

    const muteAnimation = lottieWeb.loadAnimation({
      container: muteIconContainer,
      renderer: 'svg',
      loop: false,
      autoplay: false,
      name: "Mute Animation" });


    playAnimation.goToAndStop(14, true);

    const whilePlaying = () => {
      seekSlider.value = Math.floor(audio.currentTime);
      currentTimeContainer.textContent = calculateTime(seekSlider.value);
      audioPlayerContainer.style.setProperty('--seek-before-width', `${seekSlider.value / seekSlider.max * 100}%`);
      raf = requestAnimationFrame(whilePlaying);
    };

    const showRangeProgress = rangeInput => {
      if (rangeInput === seekSlider)
      audioPlayerContainer.style.setProperty('--seek-before-width', rangeInput.value / rangeInput.max * 100 + '%');
      else
      audioPlayerContainer.style.setProperty('--volume-before-width', rangeInput.value / rangeInput.max * 100 + '%');
    };

    const calculateTime = secs => {
      const minutes = Math.floor(secs / 60);
      const seconds = Math.floor(secs % 60);
      const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
      return `${minutes}:${returnedSeconds}`;
    };

    const displayDuration = () => {
      durationContainer.textContent = calculateTime(audio.duration);
    };

    const setSliderMax = () => {
      seekSlider.max = Math.floor(audio.duration);
    };

    const displayBufferedAmount = () => {
      const bufferedAmount = Math.floor(audio.buffered.end(audio.buffered.length - 1));
      audioPlayerContainer.style.setProperty('--buffered-width', `${bufferedAmount / seekSlider.max * 100}%`);
    };

    if (audio.readyState > 0) {
      displayDuration();
      setSliderMax();
      displayBufferedAmount();
    } else {
      audio.addEventListener('loadedmetadata', () => {
        displayDuration();
        setSliderMax();
        displayBufferedAmount();
      });
    }

    playIconContainer.addEventListener('click', () => {

      if (playState === 'play') {
        audio.play();
        playAnimation.playSegments([14, 27], true);
        requestAnimationFrame(whilePlaying);
        playState = 'pause';
        playIconContainer.classList.add('display');
        cpb.classList.add('pausetxt');

      } else {
        audio.pause();
        playAnimation.playSegments([0, 14], true);
        cancelAnimationFrame(raf);
        playState = 'play';
        playIconContainer.classList.remove('display');
        cpb.classList.remove('pausetxt');
      }
    });

    muteIconContainer.addEventListener('click', () => {
      if (muteState === 'unmute') {
        muteAnimation.playSegments([0, 15], true);
        audio.muted = true;
        muteState = 'mute';
        muteIconContainer.classList.add('mute');
      } else {
        muteAnimation.playSegments([15, 25], true);
        audio.muted = false;
        muteState = 'unmute';
        muteIconContainer.classList.remove('mute');
      }
    });

    audio.addEventListener('progress', displayBufferedAmount);

    seekSlider.addEventListener('input', e => {
      showRangeProgress(e.target);
      currentTimeContainer.textContent = calculateTime(seekSlider.value);
      if (!audio.paused) {
        cancelAnimationFrame(raf);
      }
    });

    seekSlider.addEventListener('change', () => {
      audio.currentTime = seekSlider.value;
      if (!audio.paused) {
        requestAnimationFrame(whilePlaying);
      }
    });

    volumeSlider.addEventListener('input', e => {
      const value = e.target.value;
      showRangeProgress(e.target);
      outputContainer.textContent = value;
      audio.volume = value / 100;
    });

  };

  customElements.define('audio-player', AudioPlayer);

</script>

  <?php
}

					} ?>

							<?php  ?>
					</div>

        </div>
        <!-- End Content Part -->
      </div>
    </div>
  </section>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

  <script src="<?php //echo base_url('resources-f/js/pdf-index.js');?>"></script>
  <script src="<?php echo base_url('resources-f/js/pdf-index2.js');?>"></script>



  <script>
		$(document).ready(function(){


			$(".open-pdf").click(function(){
				$(".pdf-cont").addClass("active");
        $(".popbg").remove();
				$("body").after("<div class='popbg'></div>");
        $(".closed-pdf").css("display","block");
        $(".pdf-heading").css("display","flex");
        $(".open-pdf").css("display","none");
        $("body").addClass("pdf-body");
        $(".popbg").on("click", function(){
          $(".pdf-cont").toggleClass("mactive");

        })
			});

      $(".pdf-viewer").click(function(){
				$(".pdf-cont").addClass("active");
        $(".popbg").remove();
				$("body").after("<div class='popbg'></div>");
        $(".closed-pdf").css("display","block");
        $(".pdf-heading").css("display","flex");
        $(".open-pdf").css("display","none");
        $("body").addClass("pdf-body");
        $(".popbg").on("click", function(){
          $(".pdf-cont").toggleClass("mactive");

        })
			});

			$(".closed-pdf > i").click(function(){
				$(".pdf-cont").removeClass("active");
				$(".popbg").remove();
        $(".closed-pdf").css("display","none");
        $(".pdf-heading").css("display","none");
        $(".open-pdf").css("display","block");
        $("body").removeClass("pdf-body")
			});

      setTimeout(function () {
        $(".pdf-cont").removeClass("mactive");
        var height1 = $(".pdf-viewer").prop('height');
        var width1 = $(".pdf-viewer").prop('width');
          if ( width1 > height1 ){
            $(".pdf-viewer").removeClass("pv-pdf");
            $(".pdf-viewer").addClass("lv-pdf");
          } else {
            $(".pdf-viewer").removeClass("lv-pdf");
            $(".pdf-viewer").addClass("pv-pdf");
          }
        },700)
		});





	</script>