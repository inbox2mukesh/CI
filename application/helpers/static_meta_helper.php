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
                <meta name="description" content="Fulfill your dreams of studying and living in Canada with Western Overseas. Visit our St. Sydney and Mississauga cities situated offices for complete guidance." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Contact us today to Immigrate to Canada | Western Overseas</title>
                ';
            }
           else if($page=='faq'){
                $meta = '               
                <meta name="description" content="If you are struggling to know Canada immigration queries. Such as online coaching, visa-related queries, foreign language, etc. Sign up today to read FAQs." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Get your answer to the most frequently asked questions</title>
                ';
            }
            else if($page=='gallery'){
                $meta = '               
                <meta name="description" content="Enjoy the achievements of Western Overseas in the gallery and video section. Western Overseas has a great presence with trust in the immigration world." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Highlights of beautiful memories at Western Overseas!</title>
                ';
            }
            else if($page=='videos'){
                $meta = '               
                <meta name="description" content="Western Overseas have countless success stories of individuals and organizations in various fields and industries. Scroll down our pages to know more about us." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Watch the latest success stories achieved | Western Overseas</title>
                ';
            }
            else if($page=='why-canada'){
                $meta = '               
                <meta name="description" content="Canada is a well-known country for a high-quality education to improve the standards of living. It is a safe country to enjoy benefits and peaceful experiences. " />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Canada for Higher Education | Exclusive courses Available!</title>
                ';
            }
            else if($page=='become-agent'){
                $meta = '               
                <meta name="description" content="If you are a potential VISA agent & looking for a tie-up with an expert immigration firm then Western Overseas welcomes you. Apply now at our online portal." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Become an agent partner to achieve success in Immigration</title>
                ';
            }
            else if($page=='online-courses'){
                $meta = '               
                <meta name="description" content="Western Overseas offers exclusive courses to prepare for your proficiency tests. Choose any one of the best courses at a discounted price & enhance your skills." />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>Find the best Quality Online Courses | Western Overseas</title>
                ';
            }
            else if($page=='practice-packs'){
                $meta = '               
                <meta name="description" content="Get familiar with the test format of English proficiency tests that helps you to score high and master your skills in Grammar, fluency, and lexical resources!" />
                <meta name="keywords" content="practice packs, ielts practice pack" />
                <meta name="author" content="" />
                <title>Unlock Your Potential with Practice Packs! Western Overseas</title>
                ';
            }
            else if($page=='term-condition'){
                $meta = '               
                <meta name="description" content="We believe in serving transparent VISA and IELTS services. Know what terms and conditions we work on and be informed in all manners before enrolling with us." />
                <meta name="" />
                <meta name="author" content="" />
                <title>Terms & conditions | Western Overseas</title>
                ';
            }
            else if($page=='visa-services'){
                $meta = '               
                <meta name="Immigrating to Canada won`t be a big deal anymore. We offer various visa services to satisfy different needs of immigration in Canada. Look into our expertise!" />
                <meta name="keywords" content="visa service, study visa, travel visa, work visa" />
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
                <meta name="description" content="- Discover our latest articles to upgrade your knowledge of foreign languages and English proficiency exams. Read today to explore the best information" />
                <meta name="keywords" content="" />
                <meta name="author" content="" />
                <title>The Best Articles of All - To Prepare for proficiency tests</title>
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
                <meta name="description" content="Nowadays it’s difficult to find the right information due to huge resources but we are a trusted source of information to grab the latest news and updates." />
                <meta name="" />
                <meta name="author" content="" />
                <title>Nowadays it’s difficult to find the right information due to huge resources but we are a trusted source of information to grab the latest news and updates.</title>
                ';
            }
            else if($page=='about-online-pack'){
                $meta = '               
                <meta name="description" content="Explore our online experts tailored programs for IELTS, PTE, TOEFL, and CELPIP to start a smooth journey for English learning and other proficiency tests." />
                <meta name="" />
                <meta name="author" content="" />
                <title>Affordable online packs to Achieve a high score | Western Overseas</title>
                ';
            }
        else{
                $meta = '                
                <meta name="description" content="Western Overseas is an established immigration firm serving clients with quality visa services in different categories. Approach us for the best visa solution." />
                <meta name="keywords" content="immigration Consultant Canada, Canada student visa processing time, Canada study visa processing time" />
                <meta name="author" content="" />
                <title>Certified Immigration Consultant Canada | Western Overseas</title>
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
                
        } 
        return $meta; 
    }   
}

if(!function_exists('dynamic_meta_tag_data'))
{
    function dynamic_meta_tag_data($page,$page_url)
    {
        $ci = &get_instance();
        $ci->load->model('Url_slug_model');
        $content = $ci->Url_slug_model->getmetaDetails($page,$page_url);
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