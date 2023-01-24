<style>
        .mns-80
        {
          margin-top: 40px !important;
        }
        .box-white {
    background-color: #fefaee;
      }
      .custom_hide{
        display: none !important;
      }
      .timing-box{padding: 20px;background-color: #EDEDED;border-radius: 6px;margin-top: 30px;}

      /* img::before{position: relative;} */

      </style>

<section>
    <!-- Section: COURSES -->
    <div class="container">
      <?php 
    if(count($WEB_MEDIA_URL->error_message->data))
    {
      ?>
      <div class="vd-border">
        <div class="owl-carousel-slider image-border">

        <?php 
 foreach($WEB_MEDIA_URL->error_message->data as $p){
        ?>

<div class="item"><img src="<?php echo base_url();?>/<?php echo WEB_MEDIA_IMAGE_PATH;?>/<?php echo $p->image;?>" alt="" class="img-fullwidth mb-ht"> </div>
<?php }?>

          <!--
          <div class="item hide"><img src="<?php //echo site_url('resources-f/images/about_us/abt-slider-2.JPG');?>" class="img-fullwidth mb-ht"></div>-->
        </div>
      </div>
    <?php }?>
      <!--Start Grid Container-->

      <?php 
        
        include('home/product_marquee_short.php');?>
      
      <!--End Grid Container--> 
      <!--Start Grid Container-->
      <?php   include('home/about_us_short.php');?>
      <!--End Grid Container--> 
     
      <div class="mt-30">
        <div class="about-sub-info"> <img src="<?php echo site_url('resources-f/images/about_us/coaching.jpg');?>" class="mr-15 img-responsive col-md-5 pl-0">
          <div class="disc">
            <div class="title-bar">IELTS | PTE | Spoken English Coaching</div>
            <p> At Western Overseas we believe in providing the best possible quality of education to our students. Our faculty is rich with certified trainers from IDP, British Council and Pearson. They are not only provided with training by these reputed organizations but also go through intensive internal training to become masters of their craft. At Western Overseas students find the best tips and strategies catered to prepare them for the highest achievable score in these language proficiency tests. We provide students with the most advanced technologies in the classroom, with high-end computer labs, digital classrooms and resources, live online classes and online practice portals that students can use anytime for the optimal learning experience. Our curriculum is designed in a manner that doesn't rush students but caters to their needs in their own pace and time. We also specialize in providing one to one attention to our each and every student and changing our teaching techniques that best fit these students. At Western Overseas students find updated practice material, specialised training and a confidence inspiring environment.</p>
          </div>
        </div>
        <div class="about-sub-info"> <img src="<?php echo site_url('resources-f/images/about_us/visa-consultant.jpg');?>" class="pull-left mr-15 img-responsive col-md-5 pl-0">
          <div class="disc">
            <div class="title-bar">Study Visa Consultants</div>
            <p> Millions of students every aspire to go abroad for their further studies. However, this journey is not as easy as it seems. It requires hard work, a huge amount of resources and a trustworthy study visa consultant. Most of the students are not sure about their visa consultants, whether they are genuine or not. Here at Western Overseas we are promising to provide accurate advice about study visas related to the students' profile. Our team is not rich with certified and experienced consultants but we also have official tie-ups with highly reputed colleges and universities in Canada, Australia, New Zealand, USA, UK, Portugal, Ireland, Poland, Singapore, Cyprus, Sweden, Germany, France, Czech Republic, Switzerland, South Africa, Lithuania, Denmark and South Korea. In Western Overseas we have a team of dedicated counselors who have good experience of their field. Students can visit any of our offices for guidance where our experienced counselors will handle their query and explain all the steps in the process with full transparency. We guide our students in each and every step of the visa process and provide the smooth pathway to study abroad that begins with the counseling and ends with the pre-departure assistance.</p>
          </div>
        </div>
        <div class="about-sub-info"> <img src="<?php echo site_url('resources-f/images/about_us/reality-test.jpg');?>" class="pull-left mr-15 img-responsive col-md-5 pl-0">
          <div class="disc">
            <div class="title-bar">Reality Test</div>
            <p>Every year thousands of students appear for their IELTS or PTE tests for the first time. This experience can be daunting and many succumb to pressure and fear. Recognizing this and in the pursuit of enriching students with confidence, Western Overseas conceptualised the phenomenon known as Reality Test. A test designed to replicate the environment, experience and conduction of the real exam. This provided students with an opportunity to face the real exam-like environment and gain invaluable experience and confidence before they feel ready for the actual test. Soon Reality Test became the new favourite in the market and today Western Overseas, the Pioneer of Reality Test, is renowned for helping thousands of students all over the country through IELTS Reality Test, CD-IELTS Reality Test and PTE Reality Test.</p>
          </div>
        </div>
        <div class="about-sub-info"> <img src="<?php echo site_url('resources-f/images/about_us/online-classes.jpg');?>" class="pull-left mr-15 img-responsive col-md-5 pl-0">
          <div class="disc">
            <div class="title-bar">Online Classes</div>
            <p>When people trust in a business it is important for that business to uphold the beliefs of its customer and provide solutions even in the most grimmest of times. When the entire world was stopped in its tracks, Western Overseas worked day and night to create the online infrastructure to reach people sitting in their homes and provide them with a quality solution for their IELTS and PTE coaching. Western Overseas became the most successful in the entire industry to try its hands at online coaching and went on to connect with thousands of students not only in India but throughout the globe. Today Western Overseas Online is a trending name in the industry.</p>
          </div>
        </div>
        <div class="about-sub-info"> <img src="<?php echo site_url('resources-f/images/about_us/virtual-workshop.jpg');?>" class="pull-left mr-15 img-responsive col-md-5 pl-0">
          <div class="disc">
            <div class="title-bar">Virtual Workshops</div>
            <p>We at Western Overseas believe in connecting with and helping as many aspirants as possible. A physical business has its limitation and to break this limitation and help those spread all over the world, we introduced the concept of Virtual Workshops. A free service where hundreds of students connect in every event and get the best tips for IELTS and PTE, and best counselling for their study visa needs.</p>
          </div>
        </div>
      </div>
      <!-- end main-content -->
    </div>
  </section>