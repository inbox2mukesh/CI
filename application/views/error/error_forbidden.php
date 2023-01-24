<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
     <meta name="description" content="" />
     <meta name="author" content="" />

     <!-- Title -->
     <title>Sorry, This Page Can&#39;t Be Access by you</title>
     <link rel="stylesheet" href="<?php echo site_url('resources/css/font-awesome.css');?>" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"  />
</head>
<body class="bg-light text-dark py-5">
     <div class="container py-5">
          <div class="row">
               <div class="col-md-2 text-center">
                    <p class="text-info"><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Status Code: 403</p>
               </div>
               <div class="col-md-10">
                    <h3 class="text-danger">OPPsss.. ACCESS DENIED!</h3>
                    <p class="text-info">Sorry, your access is denied on this module due to security reasons.<br/>Please go back to the previous page to continue browsing or Login again.</p>
                    <a class="btn btn-warning" href="javascript:history.back()">Go Back</a>
                    <a class="btn btn-danger" href="<?php echo base_url('adminController/Login/logout');?>">Go to Login</a>
               </div>
          </div>
     </div>
     <div id="footer" class="text-center">
         <a href="<?php echo COMPANY_URL;?>" class="text-danger"><?php echo COMPANY;?></a>
     </div>
</body>
</html>