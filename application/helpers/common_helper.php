<?php 

// ----------------------EMAIL content for OTP to be send for verification------------------------------------------
if(!function_exists('otp_send_verification_email')){
    
    function otp_send_verification_email($otp=null)
    {
        $tobeSend = [];
        $content = 'Thank you for your association with Western Overseas Immigration.To complete the verification process, please enter the following One-Time Password (OTP) in the verification field provided:<br><br>';
        if(!empty($otp)|| $otp != null)
        {
            $content .= '<b>OTP : '.$otp.'</b><br><br>';
        }
        $content .= 'Please note that this OTP is valid for 10 minutes only. If you have not attempted to verify your account, please ignore this email.<br><br>';
        $content .= 'If you encounter any issues with the verification process or have any questions, please do not hesitate to reach out to our customer support team at support@westernoverseas.online.';
        $tobeSend['subject'] ='Your One-Time Password (OTP) for Verification';
        $tobeSend['content'] =$content;   
        return $tobeSend;     
    }
}

// ----------------------EMAIL content for Enquiry------------------------------------------
if(!function_exists('enquiry_email')){
    
    function enquiry_email($enquiryid=null)
    {
        $tobeSend = [];
        $content = 'Thank you for contacting us.We appreciate your interest in our products/services and are pleased to have the opportunity to assist you.<br><br>';
        $content .= 'Our team has received your enquiry and we will be reviewing it shortly. We strive to respond to all enquiries ASAP.<br><br>';
        if(!empty($enquiryid)|| $enquiryid != null)
        {
            $content .= 'Please note the enquiry id for future reference.<br><br><b>Enquiry Id : '.$enquiryid.'</b><br><br>';
        }        
        $tobeSend['subject'] ='Thank You for Your Enquiry';
        $tobeSend['content'] =$content;     
        return $tobeSend;   
    }
}


// ----------------------Admin reply for Enquiry------------------------------------------
if(!function_exists('admin_enquiry_reply_email')){
    
    function admin_enquiry_reply_email($enquiryid=null,$admin_reply=null)
    {
        $tobeSend = [];
        $content = 'Thank you for contacting Western Overseas Immigration. We appreciate your interest in our products/services, and we are happy to provide you with the information you requested.<br>';
        $content .= 'After reviewing your enquiry, we have gathered the following details to assist you:<br><br>';
        if(!empty($enquiryid)|| $enquiryid != null)
        {
            $content .= '<b>Enquiry Id : '.$enquiryid.'</b><br><br>';
        } 
        if(!empty($admin_reply)|| ($admin_reply != null))
        {
            $content .= $admin_reply.'<br><br>';
        }        
        $tobeSend['subject'] =' Response to Your Enquiry -'.$enquiryid;
        $tobeSend['content'] =$content;
        $tobeSend['email_footer_content'] ='If you have any further questions or concerns, please do not hesitate to reach out to us. We are always here to help you.';    
        return $tobeSend;    
    }
}
// ----------------------forgot password------------------------------------------
if(!function_exists('forgot_password_email')){
    
    function forgot_password_email($password = null)
    {
        $tobeSend = [];
        $content = 'We hope this email finds you in good health. We are writing to inform you that your account password for Western Overseas Immigration has been successfully reset. Your new password is:<br>';
        // if(!empty($password)|| $password != null)
        // {
        //     $content .= '<b>Password : '.$password.'</b></br>';
        // }       
        $tobeSend['subject'] =' Your New Password for '.COMPANY;
        $tobeSend['content'] =$content; 
        return $tobeSend;     
    }
}

// ----------------------Registration------------------------------------------
if(!function_exists('student_registration')){
    
    function student_registration()
    {
        $tobeSend = [];
        $content = 'We are pleased to inform you that your registration with western Overseas Immigration has been successfully done. You can now login to the portal with your login credentials and use the services.<br>';
        // if(!empty($data))
        // {
        //     $content .= '<b>Username : '.$password.'</b></br>';
        //     $content .= '<b>Password : '.$password.'</b></br>';
        // }       
        $tobeSend['subject'] ='Congratulations! You have successfully registered with '.COMPANY;
        $tobeSend['email_footer_content'] = 'If you have any questions or concerns, please do not hesitate to contact us.';
        $tobeSend['content'] =$content; 
        return $tobeSend;     
    }
}
// ----------------------Package Purchase------------------------------------------
if(!function_exists('package_purchase')){
    
    function package_purchase($package_name = null)
    {
        $tobeSend = [];
        $content = 'You have successfully subscribed for the package at Western Overseas Immigration. Please check details of the package as follows:<br>';    
        $tobeSend['subject'] ='Thank you for purchasing '.$package_name.' on '.COMPANY;
        $tobeSend['email_footer_content'] = "We want to ensure that you have a seamless experience while using our platform. If you have any questions or concerns about your purchase, please don't hesitate to reach out to our customer support team.";
        $tobeSend['content'] =$content; 
        return $tobeSend;     
    }
}
// ----------------------Session booked------------------------------------------
if(!function_exists('session_booked')){
    
    function session_booked()
    {
        $tobeSend = [];
        $content = 'We are pleased to inform you that your counseling session with Western Overseas Immigration has been confirmed. Following is the reference number for it followed by the session details.<br>';    
        $tobeSend['subject'] ='Your Counseling Session is Confirmed!';        
        $tobeSend['content'] =$content; 
        return $tobeSend;     
    }
}

// ----------------------Package Purchase update------------------------------------------
if(!function_exists('package_purchase_update')){
    
    function package_purchase_update($startdate = null,$enddate=null)
    {
        $tobeSend = []; 
        $content = 'I hope this email finds you in good health.I am writing to inform you that we have updated your package subscription dates as per your request.<br><br>';
        $content .= 'Your new subscription start date is <b>'.$startdate.'</b> and the end date is <b>'.$enddate.'</b>. Please make a note of these dates to avoid any confusion in the future.<br><br>';    
        $content .= 'If you have any queries or concerns regarding your package subscription, please feel free to contact us.';
        $tobeSend['subject'] ='Update to Your Package Subscription Dates';
        $tobeSend['email_footer_text'] ='Thank you for choosing our services.';
        $tobeSend['content'] =$content; 
        return $tobeSend;     
    }
}
