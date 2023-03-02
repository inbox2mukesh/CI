<?php
$content = $FREE_RESOURCE_SECTION->error_message->data->basic->content;
$Course = $FREE_RESOURCE_SECTION->error_message->data->basic->Course;
foreach ($content as $content_data) {
  $content_title = $content_data->title;
  $content_description = $content_data->description;
  $content_image = $content_data->image;
  $content_created = $content_data->created;
  $content_content_type_name = $content_data->content_type_name;
}
?>
<section>
  <div class="container free-resources">
    <!-- <div class="head-title font-weight-400 text-uppercase mb-20">Articles <span class="text-red font-weight-600">Post</span></div> -->
    <div class="row">
      <div class="col-md-8">
        <div class="post-info">
          <!-- <img src="<?php echo $content_image; ?>" class="img-fullwidth"> -->
          <div class="title-heading text-uppercase mt-10">
            <?php echo $content_title; ?></div>
          <div class="font-weight-600 font-12 text-italic">
            <?php echo strtoupper($content_content_type_name); ?>
            <span class="text-theme-colored">(<?php
                                              $type = "";
                                              foreach ($Course as $pp) {
                                                $type .= $pp->topic . ', ';
                                              }
                                              echo rtrim($type, ', ') ?>)</span>
          </div>
          <div class="date"><?php echo $content_created; ?></div>
          <?php //echo ucfirst($content_description);
          ?>
          <?php
          /*echo "<pre>";
				print_r($FREE_RESOURCE_SECTION);
				die();*/
          if (!empty($FREE_RESOURCE_SECTION->error_message->data->allSection)) {
            foreach ($FREE_RESOURCE_SECTION->error_message->data->allSection as $sec_d) {
              if ($sec_d->type == 'text') {
          ?>
                <?php echo ucfirst($sec_d->section) ?>
              <?php }
              if ($sec_d->type == 'image') { ?>
                <img src="<?php echo base_url(); ?>uploads/free_resources/image/<?php echo $sec_d->section ?>" class="img-fullwidth mt-20">
              <?php }
              if ($sec_d->type == 'video') {  ?>
                <div class="embed-responsive embed-responsive-16by9 mt-30 mb-15">
                  <video src="<?php echo base_url(); ?>uploads/free_resources/video/<?php echo $sec_d->section ?>" controls controlsList="nodownload" controlsList="noplaybackrate" disablepictureinpicture></video>
                </div>
              <?php }
              if ($sec_d->type == 'audio') {
              ?>
                <template>
                  <style>
                    #audio-player-container .audioplay-widget h5 {
                      font-size: 16px !important;
                      margin-bottom: 10px
                    }

                    #audio-player-container button {
                      padding: 0;
                      border: 0;
                      cursor: pointer;
                      outline: none;
                    }

                    #audio-player-container {
                      box-shadow: 0 0px 5px rgb(0 0 0 / 22%);
                      margin: 0px auto 20px;
                      padding: 15px 20px;
                      border-radius: 8px;
                      width: 480px;
                    }

                    #audio-player-container::before {
                      position: absolute;
                      content: '';
                      z-index: -1
                    }

                    #audio-player-container #volume-slider::-webkit-slider-runnable-track {
                      background: rgba(0 0 0 / 80%);
                    }

                    #audio-player-container #volume-slider::-moz-range-track {
                      background: rgba(0 0 0 / 80%);
                    }

                    #audio-player-container #volume-slider::-ms-fill-upper {
                      background: rgba(0 0 0 / 80%);
                    }

                    #audio-player-container #volume-slider::before {
                      width: var(--volume-before-width);
                      background: #000;
                    }

                    #audio-player-container input[type="range"] {
                      position: relative;
                      -webkit-appearance: none;
                      margin: 0;
                      padding: 0;
                      height: 19px;
                      margin: 0;
                      outline: none;
                      width: 300px
                    }

                    #audio-player-container input[type="range"]::-webkit-slider-runnable-track {
                      width: 100%;
                      height: 3px;
                      cursor: pointer;
                      background: linear-gradient(to right, rgba(255, 0, 0, 0.8) var(--buffered-width), rgba(255, 0, 0, 0.8) var(--buffered-width));
                    }

                    #audio-player-container input[type="range"]::before {
                      position: absolute;
                      content: "";
                      top: 8px;
                      left: 0;
                      width: var(--seek-before-width);
                      height: 3px;
                      background-color: red;
                      cursor: pointer
                    }

                    #audio-player-container input#seek-slider::before {
                      position: absolute;
                      content: "";
                      top: 4px;
                      left: 0;
                      width: var(--seek-before-width);
                      height: 10px;
                      background: linear-gradient(to right, rgba(255, 0, 0, 0.8), rgba(255, 0, 0, 0.8));
                      cursor: pointer;
                      border-radius: 8px;
                    }

                    #audio-player-container input#seek-slider::-webkit-slider-runnable-track {
                      border-radius: 8px;
                      width: 100%;
                      height: 10px;
                      cursor: pointer;
                      background: #999
                    }

                    #audio-player-container input#seek-slider::-webkit-slider-thumb {
                      position: relative;
                      -webkit-appearance: none;
                      box-sizing: content-box;
                      border: 1px solid #999;
                      height: px;
                      width: 0;
                      border-radius: 8px;
                      background-color: #fff;
                      cursor: pointer;
                      margin: -7px 0 0;
                      opacity: 0
                    }

                    #audio-player-container input[type="range"]::-webkit-slider-thumb {
                      position: relative;
                      -webkit-appearance: none;
                      box-sizing: content-box;
                      border: 1px solid #999;
                      height: 15px;
                      width: 4px;
                      border-radius: 8px;
                      background-color: #fff;
                      cursor: pointer;
                      margin: -7px 0 0
                    }

                    #audio-player-container .heading-txt h5 {
                      font-size: 16px !important;
                      padding: 0;
                      margin: 0 0 10px
                    }

                    #audio-player-container .heading-txt {
                      margin-bottom: 20px
                    }

                    #audio-player-container .vl-area {
                      margin: 15px 0;
                      display: flex;
                      gap: 0 6px;
                      align-items: center;
                    }

                    #audio-player-container button#play-icon {
                      border: 1px solid #fff;
                      background: #db261f;
                      background: #db261f;
                      padding: 14px 35px;
                      color: #fff;
                      border-radius: 4px;
                      line-height: 0;
                      text-align: center;
                      width: 120px;
                      font-size: 15px;
                      margin-right: 50px
                    }

                    #audio-player-container button#play-icon.display {
                      background: #db261f;
                      background: #fff;
                      padding: 14px 35px;
                      color: #fff;
                      border-radius: 4px;
                      line-height: 0;
                      text-align: center;
                      width: 120px;
                      font-size: 15px;
                      margin-right: 50px;
                      border: 1px solid red;
                      color: #000;
                    }

                    #audio-player-container #play-icon span:nth-child(2) {
                      display: none
                    }

                    #audio-player-container #play-icon.display span:nth-child(2) {
                      display: block
                    }

                    #audio-player-container #play-icon.display span:nth-child(1) {
                      display: none
                    }

                    #audio-player-container #cpb span:nth-child(2) {
                      display: none
                    }

                    #audio-player-container #cpb.pausetxt span:nth-child(2) {
                      display: block
                    }

                    #audio-player-container #cpb.pausetxt span:nth-child(1) {
                      display: none
                    }

                    #audio-player-container #cpb {
                      margin: -6px 0 0 176px;
                      font-size: 14px;
                      color: #666;
                      text-transform: capitalize
                    }

                    #audio-player-container #mute-icon {
                      background: url(https://westernoverseas.ca/newca/testfl/volume.png) no-repeat 0 0;
                      width: 16px;
                      height: 16px;
                    }

                    #audio-player-container #mute-icon.mute {
                      background: url(https://westernoverseas.ca/newca/testfl/muted.png) no-repeat 0 0 !important;
                    }

                    @media screen and (min-width: 220px) and (max-width:600px) {
                      #audio-player-container button#play-icon {
                        width: auto;
                      }

                      #audio-player-container .vl-area {
                        display: inherit;
                      }

                      #audio-player-container input[type="range"] {
                        width: 100%;
                        margin-top: 5px;
                      }

                      #audio-player-container {
                        width: 80%;
                      }

                      #audio-player-container #cpb {
                        margin: 5px 0px;
                      }
                    }
                  </style>
                  <div id="audio-player-container">
                    <div class="heading-txt">
                      <h5>Audio</h5>
                      <div>Click on play and adjust your volumn.</div>
                    </div>
                    <audio src="<?php echo base_url(); ?>uploads/free_resources/audio/<?php echo $sec_d->section ?>" preload="metadata" loop=""></audio>
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
                <audio-player data-src2="<?php echo base_url(); ?>uploads/free_resources/audio/<?php echo $sec_d->section ?>"></audio-player>
                <script type="module">
                  import lottieWeb from 'https://cdn.skypack.dev/lottie-web';
                  class AudioPlayer extends HTMLElement {
                    constructor() {
                      super();
                      const template = document.querySelector('template');
                      const templateContent = template.content;
                      const shadow = this.attachShadow({
                        mode: 'open'
                      });
                      shadow.appendChild(templateContent.cloneNode(true));
                    }
                    connectedCallback() {
                      everything(this);
                    }
                  }
                  const everything = function(element) {
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
                      name: "Mute Animation"
                    });
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
              ?>
          <?php }
          } ?>
          <br>
        </div>
      </div>
      <div class="col-md-4">
        <div class="rt-sidebar mob-display">
          <div class="news-articles">
            <h3>More Articles</h3>
            <ul>
              <?php
               if(count($FREE_RESOURCE_SECTION_LIMITED->error_message->data) >0)
               {
              foreach ($FREE_RESOURCE_SECTION_LIMITED->error_message->data as $p) { ?>
                <li><a href="<?php echo base_url() ?>articles/post/<?php echo $p->URLslug; ?>"><?php echo ucfirst($p->title); ?><p><?php echo $p->created; ?></p></a></li>
              <?php }} else{?>
                <li>No test Material found</li>
                <?php }?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Latest Post Section Section -->