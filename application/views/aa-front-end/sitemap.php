<?php
$html = file_get_contents(site_url());
$doc = new DOMDocument();
@$doc -> loadHTML($html);
$xp = new DOMXPath($doc);
// Only pull back A tags with an href attribute starting with "http".
$res = $xp -> query('//a[starts-with(@href, "http")]/@href');
if ($res -> length > 0)
{  
    foreach ($res as $node)
    {    
      if (strpos($node -> nodeValue, site_url()) !== false) { 
        if($node -> nodeValue !=site_url()."sitemap")
        {
          $values[] = $node->nodeValue;   
        }   
       
        }
    }
  
    $ress=array_unique($values);   
   
}
?>
<section class="bg-lighter">
<div class="container sitemap-content">
<h2>Sitemap</h2>
<ul>
  <?php 
  sort($ress);
  foreach($ress as $p){?>
<li><i class="fa fa-angle-double-right mr-5"></i> <a href="<?php echo $p?>">
<?php //echo $p;
if($p == base_url())
{
  echo "Home";
}
else {
  echo ucfirst(str_replace(base_url(),"",$p));
}


?>
</a>
<?php }?>
<!-- <li><a href="https://westernoverseas.ca/visa-services">Visa & Immigration Services</a></li>
<li><a href="https://westernoverseas.ca/online-courses">Online-courses</a></li>
<li><a href="https://westernoverseas.ca/practice-packs">Practice-packs</a></li>
<li><a href="https://westernoverseas.ca/free-resources">Article & Tutorials</a></li>
<li><a href="https://westernoverseas.ca/latest-news">Latest Immigration News</a></li>
<li><a href="https://westernoverseas.ca/why-canada">Why-canada</a></li>
<li><a href="https://westernoverseas.ca/gallery">Image Gallery</a></li>
<li><a href="https://westernoverseas.ca/videos">Video Gallery</a></li>
<li><a href="https://westernoverseas.ca/contact-us">Contact</a></li>
<li><a href="https://westernoverseas.ca/faq">FAQ</a></li>
<li><a href="https://westernoverseas.ca/become-agent">Join Agent Network</a></li>
<li><a href="https://westernoverseas.ca/term-condition">Terms and Condition</a></li> -->

 
</ul>  
</div>
</section>
