<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                  <?php if($this->Role_model->_has_access_('lead_management','crs_list')){?>
                    <a href="<?php echo site_url('adminController/lead_management/crs_list'); ?>" class="btn btn-danger btn-sm">List</a> <?php } ?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<br>
<div class="panel panel-default">
	<div class="panel-heading">Basic Detail </div>
	<div class="panel-body">
	<div class="col-md-5">
	
	<table class="table">

    <tr>
      <th scope="col">User Name</th>
      <td scope="col"><?php echo ucfirst($immigration_tools[0]['fname']).' '.ucfirst($immigration_tools[0]['lname']);?></td>
     
    </tr>
	<tr>
      <th scope="col">Email Address</th>
      <td scope="col"><?php echo $immigration_tools[0]['email'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Phone No.</th>
      <td scope="col"><?php echo $immigration_tools[0]['country_code']?> <?php echo $immigration_tools[0]['phone']?></td>
     
    </tr>
	
	<tr>
      <th scope="col">Created On</th>
      <td scope="col"><?php echo $immigration_tools[0]['created'];?></td>
     
    </tr>
	<tr>
      <th scope="col">CRS Total</th>
      <td scope="col"><b class="text-green"><?php echo $immigration_tools[0]['grand_total_crs'];?></b></td>
     
    </tr>
  
</table>
	
	
	
	
	
	
	<!--
	
	<dl class="dl-horizontal">
	<dt>User name</dt>
	<dd><?php echo $immigration_tools[0]['fname'].' '.$immigration_tools[0]['lname'];?></dd>
	</dl>
	<dl class="dl-horizontal">
	<dt >Email Address</dt>
	<dd><?php echo $immigration_tools[0]['email']?></dd>
	</dl>
	<dl class="dl-horizontal">
	<dt >Phone No.</dt>
	<dd><?php echo $immigration_tools[0]['country_code']?> <?php echo $immigration_tools[0]['phone']?></dd>
	</dl>
	<dl class="dl-horizontal">
	<dt >CRS Total</dt>
	<dd><?php echo $immigration_tools[0]['grand_total_crs']?></dd>
	</dl>
	<dl class="dl-horizontal">
	<dt >Created On</dt>
	<dd><?php echo $immigration_tools[0]['created']?></dd>
	</dl>-->
	
		
	</div>
	</div>
</div>
<h3>Points Breakdown</h3>
<!--A category-->
<div class="panel panel-default">
	<div class="panel-heading">CORE / HUMAN CAPITAL FACTORS </div>
	<div class="panel-body">
	<div class="col-md-8">
	<?php // echo "<pre>"; print_r($immigration_tools);?>
	<table class="table">
 <tr>
 <th>Title</th>
 <th>Value</th>
 <th>Points</th>
 </tr>
    <tr>
      <th scope="col">Marital Status</th>
      <td scope="col"><?php echo $immigration_tools[0]['marital_title'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Age</th>
      <td scope="col"><?php echo $immigration_tools[0]['age'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['age_point'];?> </td>
     
    </tr>
	<tr>
      <th scope="col">Education Level </th>
      <td scope="col"><?php echo $immigration_tools[0]['education_title']?> </td>
      <td scope="col"><?php echo $immigration_tools[0]['e_point']?></td>
     
    </tr>
	<tr>
      <th scope="col">CRS Total</th>
      <td scope="col"><?php echo $immigration_tools[0]['grand_total_crs'];?></td>
     
    </tr>
	
	<tr>
      <th scope="col" colspan="3"><h4><b>English Language Test Score</b></h4></th>   
     
    </tr>
	<tr>
      <th scope="col">Listening</th>
      <td scope="col" ><?php echo $immigration_tools[0]['Listening_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['Listening_points'];?></td> 
     
    </tr>
	<tr>
      <th scope="col">Reading</th>
       <td scope="col" ><?php echo $immigration_tools[0]['Reading_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['Reading_points'];?></td>
    </tr>
	<tr>
      <th scope="col">Writing</th>
     <td scope="col" ><?php echo $immigration_tools[0]['writing_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['writing_points'];?></td>
     </tr>
	<tr>
      <th scope="col">Speaking</th>
      <td scope="col" ><?php echo $immigration_tools[0]['speaking_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['speaking_points'];?></td>
     </tr>
  <tr>
      <th scope="col" colspan="3"><h4><b>French Language Test Score</b></h4></th>   
     
    </tr>
	<tr>
      <th scope="col">Listening</th>
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_Listening_title'])) { echo"N/A";} else { echo $immigration_tools[0]['f_Listening_title'];}?></td> 
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_Listening_points'])) { echo"0";} else { echo $immigration_tools[0]['f_Listening_points'];}?> </td> 
     
    </tr>
	<tr>
      <th scope="col">Reading</th>
       <td scope="col" ><?php if(empty($immigration_tools[0]['f_Reading_title'])) { echo"N/A";} else { echo $immigration_tools[0]['f_Reading_title'];}?> </td> 
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_Reading_points'])) { echo"0";} else { echo $immigration_tools[0]['f_Reading_points'];}?> </td>
    </tr>
	<tr>
      <th scope="col">Writing</th>
     <td scope="col" ><?php if(empty($immigration_tools[0]['f_writing_title'])) { echo"N/A";} else { echo $immigration_tools[0]['f_writing_title'];}?></td> 
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_writing_points'])) { echo"0";} else { echo $immigration_tools[0]['f_writing_points'];}?></td>
     </tr>
	<tr>
      <th scope="col">Speaking</th>
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_speaking_title'])) { echo"N/A";} else { echo $immigration_tools[0]['f_speaking_title'];}?></td> 
      <td scope="col" ><?php if(empty($immigration_tools[0]['f_speaking_points'])) { echo"0";} else { echo $immigration_tools[0]['f_speaking_points'];}?></td>
     </tr>
</table>
	
		
	</div>
	</div>
</div>

<!--B category-->
<div class="panel panel-default">
	<div class="panel-heading">Spouse Or Common-Law Partner Factors (If Applicable)</div>
	<div class="panel-body">
	<div class="col-md-8">
	<?php // echo "<pre>"; print_r($immigration_tools);?>
	<table class="table">
 <tr>
 <th>Title</th>
 <th>Value</th>
 <th>Points</th>
 </tr>
    <tr>
      <th scope="col">Spouse / Common-Law Partner Education Level</th>
      <td scope="col"><?php echo $immigration_tools[0]['spouse_edu_title'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['spouse_edu_points'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Spouse / Common-Law Partner Canadian Work Experience</th>
      <td scope="col"><?php echo $immigration_tools[0]['spouse_exp_title'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['spouse_exp_points'];?></td>
     
    </tr>
	
	
	<tr>
      <th scope="col" colspan="3"><h4><b>Spouse's English Or French Score</b></h4></th>   
     
    </tr>
	<tr>
      <th scope="col">Listening</th>
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_Listening_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_Listening_points'];?></td> 
     
    </tr>
	<tr>
      <th scope="col">Reading</th>
       <td scope="col" ><?php echo $immigration_tools[0]['spouse_Reading_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_Reading_points'];?></td>
    </tr>
	<tr>
      <th scope="col">Writing</th>
     <td scope="col" ><?php echo $immigration_tools[0]['spouse_writing_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_writing_points'];?></td>
     </tr>
	<tr>
      <th scope="col">Speaking</th>
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_speaking_title'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['spouse_speaking_points'];?></td>
     </tr>
  
</table>
	
		
	</div>
	</div>
</div>
<!--end-->
<!--c category-->
<div class="panel panel-default">
	<div class="panel-heading">Skill Transferability Factors</div>
	<div class="panel-body">
	<div class="col-md-8">
	<?php // echo "<pre>"; print_r($immigration_tools);?>
	<table class="table">
 <tr>
 <th>Title</th>
 <th>Value</th>
 <th>Points</th>
 </tr>
    <tr>
      <th scope="col">Work Experience </th>
      <td scope="col"><?php echo $immigration_tools[0]['exp_title'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['exp_points'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Foreign Work Experience </th>
      <td scope="col"><?php echo $immigration_tools[0]['foreign_experience_title'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['foreign_experience_points'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Canadian Trade Certificate </th>
	  <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['trade_certificat_title'];?></td> 
    </tr>
	<tr>
      <th scope="col">Official Language And Level Of Education</th>
	  <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['totallanguage_education_score'];?></td> 
    </tr>
	<tr>
      <th scope="col">Canadian Work Experience And Level Of Education</th>
	  <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['totaleducation_canadianexperience'];?></td> 
    </tr>
	<tr>
      <th scope="col">Official Language And Foreign Work Experience</th>
	  <th scope="col">&nbsp;</th>
      <td scope="col" ><?php echo $immigration_tools[0]['totallanguage_foreignexperience'];?></td> 
    </tr>
	<tr>
      <th scope="col">Canadian And Foreign Work Experience</th>
	  <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['totalcanadianforeignexperience'];?></td> 
    </tr>
	<tr>
      <th scope="col">Official Language And Trade Certificate</th>
	  <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['totaltradeCertificate'];?></td> 
    </tr>
	
  
</table>
	
		
	</div>
	</div>
</div>
<!--end-->
<!--d category-->
<div class="panel panel-default">
	<div class="panel-heading">Additional Points</div>
	<div class="panel-body">
	<div class="col-md-8">
	<?php // echo "<pre>"; print_r($immigration_tools);?>
	<table class="table">
 <tr>
 <th>Title</th>
 <th>Value</th>
 <th>Points</th>
 </tr>
    <tr>
      <th scope="col">Provincial Or Territorial Nomination </th>
      <td scope="col"><?php echo $immigration_tools[0]['provincial_nomination_text'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['provincial_nomination_ponits'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Arranged Employment  </th>
      <td scope="col"><?php echo $immigration_tools[0]['arranged_employment_text'];?></td>
      <td scope="col"><?php echo $immigration_tools[0]['arranged_employment_points'];?></td>
     
    </tr>
	<tr>
      <th scope="col">Education In Canada </th>
      <td scope="col" ><?php echo $immigration_tools[0]['education_in_canada_text'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['education_in_canada_points'];?></td> 
    </tr>
	<tr>
      <th scope="col">Relative In Canada </th>
      <td scope="col"><?php echo $immigration_tools[0]['relative_in_canada_text'];?></td> 
      <td scope="col" ><?php echo $immigration_tools[0]['relative_in_canada_points'];?></td> 
    </tr>
	<tr>
      <th scope="col">French Language</th>
      <th scope="col">&nbsp;</th>
      <td scope="col"><?php echo $immigration_tools[0]['totalFrench_score'];?></td> 
    </tr>
	
	
  
</table>
	
		
	</div>
	</div>
</div>
<!--end-->
        </div>
    </div>
</div>