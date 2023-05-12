<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }
*{margin:0px;padding:0px;}
body {background-color: #fff;font: 13px/20px normal Helvetica, Arial, sans-serif;color: #4F5155;}
img{max-width: 100%;}
a {color: #003399;background-color: transparent;font-weight: normal;}
.page-not-found-cont h1 {color: #444;background-color: transparent;border-bottom: 1px solid #D0D0D0;font-size: 32px;font-weight: normal;margin: 0 0 14px 0;padding: 14px 15px 30px 15px;text-align: center;font-weight: bold;}
#container {display: flex;flex-direction: column;justify-content: center; width: 100%;height: 100vh;}
.page-not-found-cont {display: flex;flex-direction: column;justify-content: center; margin: 0 auto; max-width: 350px;}
.page-not-found-cont p {text-align: center;font-size: 25px;line-height: 30px; margin: 0;}
.page-not-found-cont .logo {text-align: center;display: flex;justify-content: center;padding: 10px 0;}
.not-fount-button-cont {display: flex;justify-content: space-around;padding: 15px;}
.not-fount-button-cont a {padding: 10px 35px;border: 1px solid #ccc;border-radius: 100px;text-decoration: none;font-size: 14px;color: #fff;background: #626262;}
.not-fount-button-cont a.home-btn {background: #d72a22;}
.not-fount-button-cont a:hover{background:#000}
</style>
</head>
<body>
	<div id="container">
		<div class="page-not-found-cont">
			<div class="logo"><img src="<?php echo LOGO ; ?>" alt=""></div>
			<img src="resources-f/images/no-data-found.webp" alt="">
			<h1><?php echo $heading; ?></h1>
			<p><?php echo $message; ?></p>
			<div class="not-fount-button-cont">
				<a href="<?php echo site_url();?>" class="home-btn">Go Home</a>
				<a href="<?php echo site_url('contact-us');?>" class="contact-btn">Contact Us</a>
			</div>			
		</div>
	</div>
</body>
</html>