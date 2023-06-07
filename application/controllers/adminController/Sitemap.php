<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Sitemap extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();         
    }    
       
    function updateSiteMap()
    {
         //access control start
         $cn = $this->router->fetch_class().''.'.php';
         $mn = $this->router->fetch_method();
         if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
         //access control ends
        //create all website links only take ancher tags
        $values=[];
        $urlarr = [site_url(),site_url().'articles',site_url().'test-preparation-material'];
        for($i=0;$i<count($urlarr);$i++){
                    $html = file_get_contents($urlarr[$i]);
                    $docm = new DOMDocument();
                    @$docm -> loadHTML($html);
                    $xp = new DOMXPath($docm);
                    // Only pull back A tags with an href attribute starting with "http".
                    $res = $xp -> query('//a[starts-with(@href, "http")]//@href');                    
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
                    
        }
        //--------ends----------
        //--------Create Xml file for generated links----------
        $dom = new DOMDocument();
		$dom->encoding = 'utf-8';
		$dom->xmlVersion = '1.0';
		$dom->formatOutput = true;
        $xml_file_name = 'sitemap.xml';
        $root = $dom->createElement('urlset');
        $attr_xmlns = new DOMAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $attr_xmlnsxsi = new DOMAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $attr_schemaLocation = new DOMAttr('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$root->setAttributeNode($attr_xmlns);
		$root->setAttributeNode($attr_xmlnsxsi);
		$root->setAttributeNode($attr_schemaLocation);
        sort($ress);
        foreach($ress as $val)
        {
            $label_url = $dom->createElement('url');
            $child_node_loc = $dom->createElement('loc', $val);    
            $label_url->appendChild($child_node_loc);    
            $child_node_lastmod = $dom->createElement('lastmod', '2023-02-01T10:25:21+00:00');    
            $label_url->appendChild($child_node_lastmod);    
            $child_node_gpriority = $dom->createElement('priority', '1.00');    
            $label_url->appendChild($child_node_gpriority);            
            $root->appendChild($label_url);
        }	
		$dom->appendChild($root);
	    $dom->save($xml_file_name);
	//echo "$xml_file_name has been successfully created";
    //--------ends----------
    $succ='<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>SUCCESS:</strong> Successfully updated sitemap.<a href="#" class="alert-link"></a>.
    </div>';
    $this->session->set_flashdata('flsh_msg', $succ);
    redirect('adminController/ERP_settings/settings');

    }
}
