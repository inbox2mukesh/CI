<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body style="position: relative; width: 230mm; margin:auto; color: #000; background: #FFFFFF; font-family: 'Open Sans', sans-serif; border: solid 4px #d72a22;">
<div style="background-color:#d72a22; width: 100%; display:inline-flex; clear: both;">
<div style="float: left; width:52%; padding: 13px 10px;">
  <img width="300px" src="<?php echo base_url(LOGO_PTE); ?>" alt=""/>
  </div>
  <div style="width:40%; float: right; text-align: right; padding-right:10px; padding-top:65px; font-size:16px;font-weight:bold; color: #fff;"><?php echo $RT_report_data->error_message->data->test_module_name;?> Academic  |  Score Report    
  </div>
</div>

<div style="width:100%; float: left; padding:30px 0px 0px 0px; margin:0px; clear: both;">
  <div style="clear: both; width: 100%; display: flow-root; position: relative;">
    <div style="float:left; width:30%; text-align: left;">
      <?php
        if($RT_report_data->error_message->data->gender_name=='Male'){
          $img = MALE;
        }elseif($RT_report_data->error_message->data->gender_name=='Female'){
           $img = FEMALE;
        }else{ 
          $img=MALE;      
        }
      ?>
      <img src="<?php echo base_url($img);?>">       
    </div>
    <div style=" width:48%; float: left; padding:48px 0px 0px 0px;">
      
<div style="font-size:30px; font-weight: bold; padding:5px 0px; 5px 0px;"><?php echo $RT_report_data->error_message->data->fname.' '.$RT_report_data->error_message->data->lname;?></div>
<div style="padding:4px 0px;">
  <span style="font-size: 14px;font-weight:400; ">Test Taker ID:</span> 
  <span style="padding: 0px; margin: 0px;font-size: 14px; font-weight: bold;"><?php echo $RT_report_data->error_message->data->Test_Taker_ID;?></span>
</div>
<div style="padding:0px 0px;">
  <span style="font-size: 14px;font-weight:400; ">  Registration ID:</span> 
  <span style="padding: 0px; margin: 0px;font-size: 14px; font-weight: bold;"> <?php echo $RT_report_data->error_message->data->Registration_ID;?></span>
</div>
</div>
      
<div style="float: right; width:22%; margin: 0px;">      
  <div style="background-color: #131945; padding: 8px 15px; font-size: 16px; border-radius: 20px 20px 0px 0px; color: #fff; text-align: center;">Overall Score</div> 
  <div style="background-color: #d72a22; border-radius: 0px 0px 50px 50px; padding: 20px 10px 30px 10px; margin: 0px; text-align: center; font-size:52px; color: #fff; font-weight: bold; line-height: 50px; "><?php echo $RT_report_data->error_message->data->oa;?>    
  </div>
</div>
</div>
    
<div class="communication">   
<div style="font-size:20px; font-weight: bold; padding-bottom:20px; padding-top:20px; margin: 0px;">Communicative Skills</div>
<div style="padding: 0px; margin: 0px; clear: both; width: 100%;">
  <div style="width:23%; float: left; margin-left:1%; margin-right:1%;">
  <div style="padding: 10px; border: solid 5px #c42a23; font-size:34px; text-align: center; font-weight: bold; border-radius:50%; height:75px; width:75px; line-height:75px; margin: auto;">
    <?php
      $listening = $RT_report_data->error_message->data->listening; 
      echo $listening;
      ?>        
    </div>
    <div style="font-size: 16px; font-weight: bold; margin-top:15px; text-align: center;">Listening </div>        
  </div>
        
<div style="width:23%; float: left; margin-left:1%; margin-right:1%;">
  <div style="padding: 10px; border: solid 5px #c42a23; font-size:34px; text-align: center; font-weight: bold; border-radius:50%; height:75px; width:75px; line-height:75px; margin: auto;">
    <?php
      $reading = $RT_report_data->error_message->data->reading;
      echo $reading;
      ?>        
  </div>
  <div style="font-size: 16px; font-weight: bold; margin-top:15px; text-align: center;">Reading</div>
</div>
        
<div style="width:23%; float: left; margin-left:1%; margin-right:1%;">
  <div style="padding: 10px; border: solid 5px #c42a23; font-size:34px; text-align: center; font-weight: bold; border-radius:50%; height:75px; width:75px; line-height:75px; margin: auto;">
    <?php
    $speaking = $RT_report_data->error_message->data->speaking;
    echo $speaking;
    ?>
  </div>
<div style="font-size: 16px; font-weight: bold; margin-top:15px; text-align: center;">Speaking
</div>
</div>

<div style="width:23%; float: left;">
  <div style="padding: 10px; border: solid 5px #c42a23; font-size:34px; text-align: center; font-weight: bold; border-radius:50%; height:75px; width:75px; line-height:75px; margin: auto;">
    <?php
      $writing = $RT_report_data->error_message->data->writing;
      echo $writing;
      ?>        
  </div>
  <div style="font-size: 16px; font-weight: bold; margin-top:15px; text-align: center;">Writing</div>
</div>

</div>
</div>
</div>
    
<div style="padding:10px 20px 40px 20px; clear: both; display:-webkit-box;">  
  <div style="float: left; width:45%">
  <div style="width:100%;">
  <div style="font-size:18px; font-weight: bold; margin-bottom:20px; margin-top:20px;">Skills Breakdown</div>
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
  <div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right;">Listening</div>
  <div style="width: 13%; float: left; font-weight: bold;font-size: 12px; text-align: center">
      <?php
      $listening = $RT_report_data->error_message->data->listening; 
      echo $listening;
      ?>        
  </div>
  <div style="float: right; width: 51%">
    <div style="height: 12px; background-color: #131945; margin-top:3px; width:<?php echo $listening;?>%"></div>
  </div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Reading</div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center">
<?php
$reading = $RT_report_data->error_message->data->reading; 
echo $reading;
?>        
</div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #131945; margin-top:3px; width:<?php echo $reading;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Speaking  </div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px;  text-align: center">
  <?php
  $speaking = $RT_report_data->error_message->data->speaking; 
  echo $speaking;
  ?>
</div>
<div style="float: right; width: 51%">
<div style="height: 12px;background-color:#131945;margin-top:3px;width:<?php echo $speaking;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px;margin-bottom:9px;display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size:12px;font-weight:400; text-align: right; padding-right:0px;">Writing</div>
<div style="width:13%; float: left; font-weight:bold;font-size: 12px; text-align: center">
<?php
$writing = $RT_report_data->error_message->data->writing; 
echo $writing;
?>  
</div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #131945; margin-top:3px; width:<?php echo $writing;?>%"></div>
</div> 
</div>      
      
<div style="font-size:18px; font-weight: bold; margin-bottom:20px; margin-top:20px;">Enabling Skills</div> 

<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Grammar</div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->gr;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->gr;?>%"></div>
</div> 
</div>  

<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Oral Fluency  </div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->of;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->of;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Pronunciation</div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->pr;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->pr;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Listening</div>
<div style="width: 13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->listening;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->listening;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Spelling</div>
<div style="width: 13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->sp;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->sp;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Vocabulary</div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->vo;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->vo;?>%"></div>
</div> 
</div>
      
<div class="gridtb" style="margin-top:9px; margin-bottom:9px; display: flow-root; clear: both;">
<div style="width:36%; float:left;font-size: 12px; font-weight:400; text-align: right; padding-right:0px;">Written Discourse</div>
<div style="width:13%; float: left; font-weight: bold;font-size: 12px; text-align: center"><?php echo $RT_report_data->error_message->data->wd;?></div>
<div style="float: right; width: 51%">
<div style="height: 12px; background-color: #d72a22; margin-top:3px; width:<?php echo $RT_report_data->error_message->data->wd;?>%"></div>
</div> 
</div>
      
</div>
</div>
      
<div style="float:right; width:50%; margin-left: 30px;">
<div style="width:100%;">
<div style="font-size:18px; font-weight: bold; margin-bottom:20px; margin-top:20px;">Test Centre Information</div>
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Test Date:</div>   
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"><?php echo $RT_report_data->error_message->data->Date_of_Test;?> </div>  
</div>
        
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Report Issue Date:
</div>    
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"> <?php echo $RT_report_data->error_message->data->Date_of_Report;?></div>  
</div>
        
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Test Centre Country:</div>   
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"><?php echo $RT_report_data->error_message->data->Test_Centre_ID;?> </div>  
</div>
        
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Test Centre ID:</div>    
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"> <?php echo $RT_report_data->error_message->data->Test_Centre_ID;?></div> 
</div>
        
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Test Centre:</div>   
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"> Western Overseas</div> 
</div>        
        
<div style="font-size:18px; font-weight: bold; margin-bottom:20px; margin-top:20px;">Candidate Information
</div>
        
<div class="gridtb" style="margin-top:10px; margin-bottom:10px; display: flow-root;">
<div style="width:40%; float:left;font-size: 12px; font-weight:400; text-align: right;">Date of Birth:</div>   
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;">
<?php 
  $dob = str_replace("-","/",$RT_report_data->error_message->data->dob);
  echo $dob;
?></div> 
</div>
        
<div class="gridtb" style="margin-top:10px;margin-bottom:10px;display:flow-root;">
<div style="width:40%;float:left;font-size:12px;font-weight:400;text-align:right;">Country of Citizenship:
</div>    
<div style="float: right; width:59%;font-size: 12px;font-weight:400; text-align:left; font-weight: bold;"> <?php echo $RT_report_data->error_message->data->country_name;?></div>  
</div>
        
<div class="gridtb" style="margin-top:10px;margin-bottom:10px;display:flow-root;">
<div style="width:40%;float:left;font-size:12px; font-weight:400;text-align:right;">Country of Residence: </div>   
<div style="float: right; width:59%;font-size:12px;font-weight:400;text-align:left; font-weight: bold;"><?php echo $RT_report_data->error_message->data->country_name;?></div> 
</div>
        
<div class="gridtb" style="margin-top:10px;margin-bottom:10px;display:flow-root;">
<div style="width:40%;float:left;font-size:12px;font-weight:400;text-align:right;">Gender: </div>   
<div style="float:right;width:59%;font-size:12px;font-weight:400;text-align:left; font-weight:bold;">
<?php
  if($RT_report_data->error_message->data->gender_name=='Male'){
    $gender_name = 'Male';
  }elseif($RT_report_data->error_message->data->gender_name=='Female'){
    $gender_name = 'Female';
  }else{ 
    $gender_name='N/A';
  }
  echo $gender_name;?></div>  
</div>
        
<div class="gridtb" style="margin-top:10px;margin-bottom:10px; display:flow-root;">
<div style="width:40%; float:left;font-size:12px;font-weight:400;text-align:right;">Email: </div>    
<div style="float:right;width:59%;font-size:12px;font-weight:400;text-align:left; font-weight:bold;"><?php echo $RT_report_data->error_message->data->email;?></div>  
</div>
      
</div>
</div>
</div>
    
<div style="width:100%;color:#fff;text-align:center;background-color:#d72a22;display: flow-root;clear:both;font-weight:bold;">
<div style="padding:14px;line-height:20px;font-size:12px;">This is a Score Report generated on the basis of Practice Test conducted by Western Overseas and is not valid for any immigration purposes.</div>
</div>

</body>
</html>