<?php 
	//$datetime = DateTime::createFromFormat('Y-m-d', $mailData2['date']);
	//$dayname = $datetime->format('l');	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- <title>Online CD-IELTS Acknowledgement</title> -->
</head>

<body style="position: relative; width: 230mm; margin:auto; color: #000; background: #FFFFFF; font-family: 'Open Sans', sans-serif;">
  
  <div><img src="<?php echo base_url('resources/img/wo-logo.png');?>" /></div>
  <div style="margin-top:30px; margin-bottom:20px; font-size:24px; font-weight:600; color:#e9171c; text-align:center;">TEST ACKNOWLEDGEMENT</div>
  
  <div style="font-size:18px; text-align:center; line-height:28px; font-weight:600;">Your <?php echo $mailData2['title'];?> REALITY TEST with WESTERN OVERSEAS is confirmed for <?php echo $dayname;?>, <?php echo $mailData2['date2'];?></div>
  
  <div style="font-size:16px; text-align:left; line-height:26px; font-weight:600; margin-top:30px;margin-bottom:10px;">NAME:<?php echo $mailData2['fname'].' '.$mailData2['lname'];?></div>
    <div style="font-size:16px; text-align:left; line-height:26px; font-weight:600;margin-bottom:10px;">UID:<?php echo $mailData2['UID'];?></div>
	  <div style="font-size:16px; text-align:left; line-height:26px; font-weight:600;margin-bottom:10px;">REGISTRATION ID:<?php echo $mailData2['pass_id'];?></div>
	  <div style="font-size:16px; text-align:left; line-height:26px; font-weight:600; margin-top:30px;margin-bottom:10px;">USERNAME: **********</div>
	  <div style="font-size:16px; text-align:left; line-height:26px; font-weight:600; margin-bottom:10px;">PASSWORD: **********</div>
	  
   <div style="font-size:15px; text-align:left; line-height:24px; margin-top:30px;">
     Thank you for choosing to take your <strong><?php echo $mailData2['title'];?> REALITY TEST</strong> with WESTERN OVERSEAS
STUDY ABROAD PVT LTD. Your place has now been confirmed and please note that your exam will be held over two
separate sessions. You must attend both test sessions to complete the    </div>


   <div style="font-size:15px; font-weight:600; color:#000; text-align:left; line-height:20px; margin-top:30px; background-color:#99cc00; padding:6px 10px;">
    Your Listening, Reading, Writing Test will be held on <?php echo $dayname;?>, <?php echo $mailData2['date2'];?> from <?php echo $mailData2['time_slot'];?> </div>
	
	 <div style="font-size:15px; font-weight:600; color:#000; text-align:left; line-height:20px; margin-top:30px; background-color:#99cc00; padding:6px 10px;">
Your Speaking Test will be held on <?php echo $dayname;?>, <?php echo $mailData2['date2'];?> from 02:00 PM </div>

   <div style="font-size:15px; font-weight:600; text-align:left; line-height:24px; margin-top:30px; margin-bottom:10px;">You must submit Listening, Reading, Writing Tests within 24 hours.</div>
   <div style="font-size:15px; font-weight:600;  text-align:left; line-height:24px;">You must join the session for your Speaking on the mentioned time.</div>
   
      <div style="font-size:14px; text-align:left; line-height:24px; margin-top:30px; margin-bottom:10px;">Please call on our helpline no. <strong>7496973611, 7419700363 </strong>for any required assistance.</div>
	  
	
    <div style="font-size:20px; text-align:left; line-height:26px; font-weight:600; margin-top:30px;margin-bottom:10px;">  Test Taker Rules and Instructions</div>
		
    <div style="font-size:14px; text-align:left; line-height:20px; font-weight:600; margin-top:20px;margin-bottom:20px;">  Test Taker Rules and Instructions</div>
	
	
 <div style="font-size:14px; text-align:left; line-height:20px; font-weight:400;">
	You will require a computer or a laptop to do this Reality Test. You can use Cyber Cafes if you don’t possess one. The
Test can run on a mobile phone but we will not be responsible for any technical issues you may face on your phone.<br />
<br />

You will require a Google Chrome browser, please don’t use any other browser for issue-free experience, decent internet
connection and a good headphone with attached microphone.<br />
<br />

For best results, please use a dedicated microphone and not inbuilt system microphone.<br />
<br />

You will be given 24 hours to complete this test.<br />
<br />

The test will be in a single sitting of 3 hours. If you open the test multiple times, only the first attempt will be assessed.
If for any reason your test crashes, close the test, login again and restart the test from The Pending Test tab. Do Not Start
a New Test.<br />
<br />

If there are any technical issues, please close the test and contact with our team immediately.<br />
<br />

Make sure you check that your headphones and microphone is working properly before you begin the test.<br />
<br />

When putting on the headset please make sure that microphone is on your left hand side, dropped down parallel to the
level of your mouth and is two fingers width away from your mouth.<br />
<br />

Your test scores will be released within 2 working days. To check your scores please visit westernoverseas.online or
ieltsrealitytest.com. You will be able to download your scores by logging in.

	
	</div>
	
 <div style="font-size:14px; text-align:left; line-height:20px; font-weight:600; padding:6px 10px; text-align:center; border:solid 1px #666; text-align: center; margin-top:100px;
 margin-bottom:50px;">westernoverseas.online | ieltsrealitytest.com | pterealitytest.com | western-overseas.com</div>
	
</body>
</html>
