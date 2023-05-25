<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('get_meta_tag')){
    function get_meta_tag($page)
    { 
        if(DEFAULT_COUNTRY == 38)  
        {
           return get_meta_tag_data($page,DEFAULT_COUNTRY);    
        }
        else if(DEFAULT_COUNTRY == 13)
        {
            return get_meta_tag_data($page,DEFAULT_COUNTRY);
        }
        else if(DEFAULT_COUNTRY == 101)
        {
            return get_meta_tag_data($page,DEFAULT_COUNTRY);
        }
        else {
            return get_meta_tag_data($page,DEFAULT_COUNTRY);
        }       
    }
}
if(!function_exists('get_meta_tag_data')){
    function get_meta_tag_data($page,$country_id)
    {
        if($country_id ==38)
        {
            if($page=='contact-us'){
                $meta = '               
                <meta name="description" content="Fulfill your dreams of studying and living in Canada with Western Overseas. Visit our St. Sydney and Mississauga cities situated offices for complete guidance. " />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Immigrate to Canada through Western Overseas | Contact today</title>
                ';
            }
           else if($page=='faq'){
                $meta = '               
                <meta name="description" content="Land on a single platform to get an answer to every Canada visa query & clear doubts you have been struggling with for a long time. Western Overseas rules here." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Get your answer to the most frequently asked questions </title>
                ';
            }
            else if($page=='gallery'){
                $meta = '               
                <meta name="description" content="Rejoice in the beautiful moments & achievements of Western Overseas, making the company a giant face in the immigration world. We are trusted VISA consultants." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Capture beautiful memories of Western Overseas here!</title>
                ';
            }
            else if($page=='videos'){
                $meta = '               
                <meta name="description" content="Explore the VISA world by watching the latest videos uploaded by Western Overseas. Know what people have to say about us. Reach us today!" />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Watch the latest videos by Western Overseas | VISA World</title>
                ';
            }
            else if($page=='why-canada'){
                $meta = '               
                <meta name="description" content="Dig-out core reasons inspiring students to study in Canada. We put the light over grounds good enough to see Canada as an opportunistic country for education. " />
                <meta name="keywords" content="scholarship in canada, canada immigration consultants, minimum bank balance for canada student visa, canada study visa processing time, canada student visa processing time, how much bank balance is required for canada student visa" />
                <meta name="author" content="" />
                <title>Why Canada for study | Know reasons from Education experts</title>
                ';
            }
            else if($page=='become-agent'){
                $meta = '               
                <meta name="description" content="If you are a potential VISA agent & looking for a trusted tie-up with an expert immigration firm Western Overseas welcomes you. Apply now at our online portal." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Unite with Western Overseas for high visa success in Canada</title>
                ';
            }
            else if($page=='online-courses'){
                $meta = '               
                <meta name="description" content="Choose from upcoming IELTS online programs at a discounted price & enhance your skills to crack the exam with desired bands. Slots are limited. Book today!" />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Bumper & exclusive Online IELTS coaching | Western Overseas </title>
                ';
            }
            else if($page=='practice-packs'){
                $meta = '               
                <meta name="Immerse in IELTS preparation with Western Overseas and buy the best course depending on your English level. We help you master the IELTS exam. Join us today!" />
                <meta name="" />
                <meta name="author" content="" />
                <title>Practice IELTS with Western Overseas to brush up your skills</title>
                ';
            }
            else if($page=='term-condition'){
                $meta = '               
                <meta name="We believe in serving transparent VISA and IELTS services. Know what terms and conditions we work on and be informed in all manners before enrolling with us. " />
                <meta name="" />
                <meta name="author" content="" />
                <title>Know our terms and conditions | Western Overseas </title>
                ';
            }
            else if($page=='visa-services'){
                $meta = '               
                <meta name="Immigrating to Canada won`t be a big deal anymore. We offer various visa services to satisfy different needs of immigration in Canada. Look into our expertise!" />
                <meta name="" />
                <meta name="author" content="" />
                <title>Western Overseas | Deals in different visa domains | Canada</title>
                ';
            }
            else if($page=='about-online-coaching'){
                $meta = '               
                <meta name="Explore our online experts` tailored programs for IELTS, PTE, TOEFL, and CELPIP to start a smooth journey for English learning and commence studying in Canada." />
                <meta name="" />
                <meta name="author" content="" />
                <title>Peerless online English learning packs by Western Overseas</title>
                ';
            }
            else if($page=='articles'){
                $meta = '               
                <meta name="Western Overseas devotes itself to letting students be upgraded via expert-written articles for IELTS, PTE, TOEFL, CELPIP, & foreign languages. Read them today!" />
                <meta name="" />
                <meta name="author" content="" />
                <title>Get English proficiency tests insights at Western Overseas</title>
                ';
            }
            else if($page=='test-preparation-material'){
                $meta = '               
                <meta name="Do you want access to the latest study material to prepare for IELTS, PTE, TOEFL, and CELPIP? Western Overseas offers you this great opportunity. Grab today!" />
                <meta name="" />
                <meta name="author" content="" />
                <title>Up-to-date test preparation material from experts in Canada</title>
                ';
            }
            else if($page=='news'){
                $meta = '               
                <meta name="There is no other place than Western Overseas to grab the latest news and updates in the immigration world, Canada. We are a trusted source of information." />
                <meta name="" />
                <meta name="author" content="" />
                <title>Trust Western Overseas for Canada immigration updates</title>
                ';
            }
        else{
                $meta = '                
                <meta name="description" content="Western Overseas is an established immigration firm serving clients with quality visa services in different categories. Approach us for the best visa solution." />
                <meta name="keywords" content="VISA, Canada, Study abroad, Immigration" />
                <meta name="author" content="" />
                <title>Western Overseas Regulated Canadian Immigration Consultant</title>
                ';
            } 
                return $meta;          
        }  
        else if($country_id ==13)
        {
            $meta = '                
                    <meta name="description" content="Western Overseas is one of the best immigration consultants Australia. If you planning to immigrate to Australia then we are all set to help you out." />
                    <meta name="keywords" content="Immigration Consultant " />
                    <meta name="author" content="" />
                    <title>Best Immigration Consultants in Australia | Western Overseas</title>
                    ';
                return $meta;    
        } 
        else if($country_id ==101)
        {
                $meta = '                
                <meta name="description" content="" />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title></title>
                ';
                if($page=='about-online-coaching'){
                    $meta = '               
                    <meta name="description" content="Are you Confused about choosing IELTS, PTE, TOEFL, and Duolingo? No worries! Western overseas online coaching is the best approach to studying online." />
                    <meta name="keywords" content="IELTS online coaching, PTE online coaching, TOEFL online coaching" />
                    <title>IELTS Online Coaching Near Me to Get a high band score</title>
                    ';
                }            
                else if($page=='online-courses'){
                    $meta = '               
                    <meta name="description" content="IELTS practice test online is available for learners who want to enhance their English communication skills and t achieve high band scores in the IELTS test." />
                    <meta name="keywords" content="IELTS practice test online, ielts online course, ielts Online test" />
                    <meta name="author" content="" />
                    <title>Ace Your IELTS Practice Test Online: Top Strategies</title>
                    ';
                }
                else if($page=='articles'){
                    $meta = '               
                    <meta name="description" content="Ielts online updates is an intensive way to keep candidates up to date for IELTS, PTE, and other proficiency tests. Read articles, to learn more from experts." />
                    <meta name="keywords" content="Ielts online updates" />
                    <meta name="author" content="" />
                    <title>Get Online News and Updates | Western Overseas</title>
                    ';
                }
                else if($page=='test-preparation-material'){
                    $meta = '               
                    <meta name="description" content="The IELTS Preparation Materials are accessible online to help students to practice at home. Also, students will understand the pattern and structure of exams." />
                    <meta name="" />
                    <meta name="keywords" content="IELTS Preparation Materials, IELTS test  Materials" />
                    <title>The Best IELTS Preparation Materials | Western Overseas</title>
                    ';
                }
                else if($page=='news'){
                    $meta = '               
                    <meta name="description" content="Ielts online updates is an intensive way to keep candidates up to date for IELTS, PTE, and other proficiency tests. Read articles, to learn more from experts." />
                    <meta name="keywords" content="Ielts online updates" />
                    <title>Get Online News and Updates | Western Overseas</title>
                    ';
                }
                else{
                    $meta = '                
                    <meta name="description" content="Western Overseas offers a wide range of IELTS Online Coaching courses. Also, we offer PTE, TOEFL, DUOLINGO, and all foreign language courses. Let’s Enrol today!" />
                    <meta name="keywords" content="IELTS online coaching, PTE online coaching, TOEFL online coaching, Ielts Online" />
                    <meta name="author" content="" />
                    <title>Get Started IELTS Online Coaching | Western Overseas</title>
                    ';
                } 
                return $meta; 
        } 
    }   
}

if(!function_exists('dynamic_meta_tag_data'))
{
    function dynamic_meta_tag_data($page,$page_url)
    {
        $ci = &get_instance();
        $ci->load->model('Url_slug_model');
        $content = $ci->Url_slug_model->getmetaDetails($page,$page_url);
        // pr($content);
        $description='';
        if(!empty($content))
        {
            $description = $content[0]['seo_desc'];
            $keywords = $content[0]['seo_keywords'];
            $title = $content[0]['seo_title'];
        }
        return $meta = '<meta name="description" content="'.$description.'" />
                <meta name="keywords" content="'.$keywords.'" />
                <meta name="author" content="" />
                <title>'.$title.'</title>
                ';

    }
}
?>