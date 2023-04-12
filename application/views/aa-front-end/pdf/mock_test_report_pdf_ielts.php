<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,maximum-scale=1.0">
<title></title>
</head>
<body style=" height: 297mm; width: 210mm; border: solid 4px #000000; font-family: 'Open Sans', sans-serif; margin: auto; font-size: 14px;">
  <table width="100%" style="background-color: #ffeeee; background-image: url(<?php echo base_url(WATER_MARK);?>); background-repeat: repeat; padding:40px 20px;">
<tr>
  <td>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="76%" align="left" style="font-size:38pt; font-weight:bold; padding: 0px; margin: 0px; line-height:56px;"><?php echo $RT_report_data->error_message->data->test_module_name;?></td>
  <td width="24%" align="right" valign="bottom">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td align="center" style="font-size:18pt; height:58px; font-weight:bold; border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align: middle;"> <?php echo $RT_report_data->error_message->data->Test_Type;?></td>
  </tr>
</table>
</td>
</tr>

<tr>
  <td colspan="2" align="left" style="font-size:18pt; font-weight:bold; padding:10px 0px 11pt 0px; margin: 0px; text-transform: uppercase; line-height:24px;"> Practice Test Report Form </td>
  </tr>
  </tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
  <td width="8%" rowspan="3" align="right" valign="top" style="font-size:15pt;; font-weight: bold; line-height:20px;">Note</td>
  <td width="2%" align="center" valign="top" style="line-height:20px;padding: 4px 0px;">&#8226;</td>
  <td width="90%" align="left" valign="top" style="font-size: 12pt; font-weight: bold; line-height:20px; padding:4px 0px;">Admission to undergraduate and post graduate courses should be based on the Academic Reading and Writing Modules.</td>     
</tr>
<tr>
  <td align="center" valign="top" style="line-height:20px; padding: 4px 0px;">&#8226;</td>
  <td align="left" valign="top" style="font-size: 12pt; font-weight: bold; line-height:20px;padding: 4px 0px;">General TRAINING Reading and Writing Modules are not designed to test the full range of language skills required for academic purpose.</td>
</tr>
<tr>
  <td align="center" valign="top" style="line-height: 20px;padding: 4px 0px;">&#8226;</td>
  <td align="left" valign="top" style="font-size: 12pt; font-weight: bold; line-height: 20px;padding:6px 0px;">It is recommended that the candidate's language ability as indicated in this Test Report Form be re-assessed after two years from the date of the test.</td>
</tr>
</table> 
      
<table width="100%" cellpadding="0" cellspacing="12">
<tr>
  <td width="17%" align="right" valign="middle" style="font-size:12pt; font-weight: bold; line-height:20px;">Center Number</td>
  <td width="17%" align="left" style="font-size:14pt; height:53px; font-weight:bold; border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align: middle;"><?php echo $RT_report_data->error_message->data->Centre_Number;?></td>        
  <td width="10%" align="right" valign="middle" style="font-size:12pt; font-weight: bold; line-height:20px;">Date</td>
  <td width="19%" align="left" style="font-size:14pt; height:53px; font-weight:bold; border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align: middle;">
      <?php echo $RT_report_data->error_message->data->Date_of_Test;?>
  </td>        
  <td width="21%" align="right" valign="middle" style="font-size: 12pt; font-weight: bold; line-height:20px;">Candidate Number</td>
  <td width="16%" align="left"  style="font-size:14pt; height:53px; font-weight:bold; border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align: middle;"><?php echo $RT_report_data->error_message->data->Candidate_Number;?></td>      
  </tr>     
 </table>
      
<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0px;">
  <tr>
    <td height="55" style="font-size:18pt;; font-weight:bold; text-transform: uppercase; line-height:55px;">Candidate Details
    </td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="80%" valign="top">
  <table width="100%" border="0" cellspacing="16" cellpadding="0">
<tr>
  <td width="26%" align="right" valign="middle" style="font-size:12pt; font-weight:bold; line-height:20px;">First Name</td>
  <td width="74%" valign="top">       
  <table width="100%" border="0" cellspacing="0" cellpadding="0">  
  <tr>
    <td style="font-size:14pt; height:53px; font-weight:400; border:solid 1px #666666; background-color:#d5c9c9; opacity: 0.8;padding:0px 10px; vertical-align: middle;">
      <?php echo $RT_report_data->error_message->data->fname.' '.$RT_report_data->error_message->data->lname;?>        
    </td>
  </tr> 
</table>
</td>
</tr>
<tr>
<td width="26%" align="right" valign="middle" style="font-size:12pt; font-weight:bold; line-height:20px;">Candidate ID</td>
<td width="74%" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
<tr>
<td style="font-size:14pt; height:53px; font-weight:400; border:solid 1px #666666; background-color:#d5c9c9; opacity: 0.8;padding:0px 10px; vertical-align: middle;"><?php echo $RT_report_data->error_message->data->Candidate_ID;?></td>
</tr> 
</table>
</td>
</tr>
</table>
</td>
    
    <?php
      if($RT_report_data->error_message->data->gender_name=='Male'){
        $img = MALE;
      }elseif($RT_report_data->error_message->data->gender_name=='Female'){

         $img = FEMALE;

      }else{ 
        $img=MALE;      
      }
      ?>
      <td width="20%" align="center" valign="top"><img src="<?php echo base_url($img);?>"></td>
    </tr>
  </tbody>
</table> 
      
      
<table width="100%" border="0" cellpadding="0" cellspacing="16">
  <tr>
     <td width="22%" align="right" style="font-size:14pt; font-weight:bold; line-height: 20px;">Date of Birth</td>    
    <td width="14%">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td  style="font-size:12pt; height:53px; font-weight:bold; border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align: middle;"><?php 
      $dob = str_replace("-","/",$RT_report_data->error_message->data->dob);
      echo $dob;
      ?></td>
    </tr> 
</table>
      
</td>
  <td width="15%" align="right" style="font-size:12pt;font-weight:bold;line-height: 20px;">Sex (M/F)</td>
  <td width="10%" align="center" style="font-size:12pt;height:53px;font-weight:bold; border:solid 1px #666666;margin: 0px;padding:0px 10px;vertical-align: middle;">
      <?php
      if($RT_report_data->error_message->data->gender_name=='Male'){
        $gender_name = 'Male';
      }elseif($RT_report_data->error_message->data->gender_name=='Female'){
         $gender_name = 'Female';
      }else{
 
        $gender_name='N/A';
      }
      echo $gender_name;      
      ?>        
</td>
<td width="16%" align="right" style="font-size:12pt;font-weight:bold;line-height: 20px;">Scheme Code</td>
<td width="23%" style="font-size:12pt;height:53px; font-weight:bold;border:solid 1px #666666;margin:0px;padding:0px 10px; vertical-align: middle;">Private Candidate</td>
</tr>
        
<tr>
<td align="right" style="font-size:12pt;font-weight:bold;line-height:20px;">Country or Region Country</td>
<td colspan="5">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
<tr>
<td  style="font-size:12pt;height:53px;font-weight:bold;border:solid 1px #666666;margin: 0px; padding:0px 10px; vertical-align:middle;"><?php echo $RT_report_data->error_message->data->country_name;?> </td>
</tr> 
</table>
</td>
</tr>
</table>
</td>
</tr>
  
   <tr>
    <td align="right" style="font-size:12pt;font-weight:bold;line-height:20px;">Country of Nationality</td>        
     <td colspan="5">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td >
      
        
     <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td  style="font-size:12pt;height:53px;font-weight:bold;border:solid 1px #666666;margin:0px; padding:0px 10px; vertical-align:middle;"><?php echo $RT_report_data->error_message->data->country_name;?></td>
    </tr>
 
</table>
    </td>
    </tr>

</table>
</td>
  </tr>
  <tr>
    <td align="right" style="font-size:12pt;font-weight:bold">First Language</td>        
     <td colspan="5">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td  style="font-size:12pt; height:53px;font-weight:bold;border:solid 1px #666666;margin:0px;padding:0px 10px;vertical-align: middle;">English</td>
    </tr>
 
</table>
    </td>
    </tr>
</table>
      
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td height="55" style="font-size:18pt;font-weight:bold;text-transform:uppercase; line-height:55px;padding: 0px 0px 6px 0px">
     Test Result
    </td>
  </tr>
</table>
      <?php //print_r($RT_report_data); ?>
<table width="100%" cellpadding="0" cellspacing="10">
  <tr>
    <td width="10%" align="right" valign="middle" style="font-size:11pt; font-weight: bold; line-height:16px;">Listening</td>
     <td width="8%" align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td align="center"  style="font-size:12pt;height:53px;font-weight:bold;border:solid 1px #666666;background-color:#d5c9c9;padding:0px 10px;vertical-align: middle;"><?php
        $listening = $RT_report_data->error_message->data->listening; 
      echo $listening;
      ?></td>
    </tr>
 
</table>
</td>
        
    <td width="10%" align="right" valign="middle" style="font-size:11pt; font-weight: bold; line-height:16px;">Reading </td>
   <td width="8%" align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td align="center"  style="font-size:12pt; height:53px; font-weight:bold; border:solid 1px #666666; background-color:#d5c9c9; padding:0px 10px; vertical-align: middle;"> 
    <?php
      $reading = $RT_report_data->error_message->data->reading;
      echo $reading;
    ?>        
</td>
</tr>
 
</table>
</td>
        
    <td width="10%" align="right" valign="middle" style="font-size:11pt;font-weight: bold;line-height:16px;">Writing</td>
     <td width="8%" align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td align="center" style="font-size:12pt;height:53px;font-weight:bold; border:solid 1px #666666;background-color:#d5c9c9;padding:0px 10px;vertical-align: middle;"> <?php
      $writing = $RT_report_data->error_message->data->writing; 
      echo $writing;
      ?></td>
    </tr>
 
</table>
</td>
        
    <td width="10%" align="right" valign="middle" style="font-size:11pt;font-weight: bold; line-height:16px;">Speaking</td>
    <td width="8%" align="center" valign="middle" style="font-size:12pt;height:53px; font-weight:bold;border:solid 1px #666666;background-color:#d5c9c9;padding:0px 10px; vertical-align:middle;">
    <?php
      $speaking = $RT_report_data->error_message->data->speaking; 
      echo $speaking;
      ?>
    </td>
        
    <td width="20%" align="right" valign="middle" style="font-size: 11pt; font-weight: bold; line-height:16px;">Overall Band Score</td>
   <td width="8%" align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">  
    <tr>
      <td align="center" style="font-size:12pt;height:53px;font-weight:bold;border:solid 1px #666666;background-color:#d5c9c9;padding:0px 10px;vertical-align: middle;"> <?php
      $oa = $RT_report_data->error_message->data->oa; 
      echo $oa;
      ?></td>
    </tr>
 
</table>
</td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-top:40px;">
<tr>
<td width="23%" height="140" align="center" valign="top" style="border:solid 1px #000000;margin:0px;font-size: 10pt; font-weight:bold;line-height:11pt;padding:8px;">Validation Stamp<br/>
<img src="<?php echo base_url(STAMP); ?>">
</td>
<td width="10%" align="right" valign="bottom" style="font-size:12pt;font-weight:bold;">Date</td>
<td width="16%" valign="bottom" style="border-bottom:solid 1px #666666; margin: 0px; padding: 2px 5px; font-size: 18px;">  <?php echo $RT_report_data->error_message->data->Date_of_Report;?> </td>
<td width="27%" align="right" valign="bottom" style="font-size:12pt;font-weight:bold;">Administrator's Signature</td>
<td width="24%" align="right" valign="bottom" style="border-bottom:solid 1px #666666; margin: 0px;">
<img src="<?php echo base_url(MOCK_TEST_SIGNATURE);?>">
</td>
</tr>
<tr>
<td height="100px" colspan="5" align="right" valign="bottom"><img src="<?php echo base_url(LOGO_IELTS); ?>"></td>
</tr> 
</table>    
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="85" align="center" valign="bottom" style="font-size:12pt; font-weight: bold; line-height:22px;">This is a Test Report Form generated on the basis of Practice Test conducted by Western Overseas and is not valid for any immigration purposes</td>
</tr>      
</table>      
</td>
</tr>
</table>
</body>
</html>
