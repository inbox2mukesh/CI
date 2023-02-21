<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          
 *
 **/
class Sitemap extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();         
    }
    
    function index()
    {          
        $headers = array(
           'API-KEY:'.WOSA_API_KEY,   
       );
       $this->load->helper('xml');
       $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
       $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));     
       $data['faqData'] = json_decode($this->_curlGetData(base_url(GET_ALL_FAQ_URL), $headers));        
       $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
      // header('Content-type: text/xml');
      $data['title'] = 'Sitemap';
       $this->load->view('aa-front-end/includes/header',$data);
    
        $this->load->view("aa-front-end/sitemap");
       $this->load->view('aa-front-end/includes/footer');
     //   $this->load->view('aa-front-end/sitemap');
    
    }   
    function createSiteMap()
    {
        //create all website links only take ancher tags
        $html = file_get_contents(site_url());
        $docm = new DOMDocument();
        @$docm -> loadHTML($html);
        $xp = new DOMXPath($docm);
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
    }
}
