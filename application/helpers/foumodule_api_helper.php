<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function fetch_fourmodule_pack_id($test_module_name,$programe_name,$pack_type)
{
// echo $pack_type;
     if($pack_type == 0)// 0=domestic/inter
     {
         if($test_module_name =="PTE")
         {
             $fourmodule_pack_id=FOURMODULE_PTE_INDIAN;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && $programe_name =="Academic")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_ACD_INDIAN;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && $programe_name =="General Training")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_GT_INDIAN;
         }
         else if($test_module_name =="FLIP" )
         {
             $fourmodule_pack_id=FOURMODULE_FLIP_INDIAN;
         }
         else if($test_module_name =="CELPIP" )
         {
             $fourmodule_pack_id=FOURMODULE_CELPIP_INDIAN;
         }
         else if($test_module_name =="TOEFL" )
         {
             $fourmodule_pack_id=FOURMODULE_TOEFL_INDIAN;
         }
             
     }
     else {// 1=international
       //  echo $test_module_name.' '.$programe_name;
         if($test_module_name =="PTE")
         {
             $fourmodule_pack_id=FOURMODULE_PTE_INTERNATIONAL;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && strtolower($programe_name) =="academic")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_ACD_INTERNATIONAL;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && strtolower($programe_name) =="general training")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_GT_INTERNATIONAL;
         }
         else if($test_module_name =="FLIP" )
         {
             $fourmodule_pack_id=FOURMODULE_FLIP_INTERNATIONAL;
         }
         else if($test_module_name =="CELPIP" )
         {
             $fourmodule_pack_id=FOURMODULE_CELPIP_INTERNATIONAL;
         }
         else if($test_module_name =="TOEFL" )
         {
             $fourmodule_pack_id=FOURMODULE_TOEFL_INTERNATIONAL;
         }
     }
     
     return $fourmodule_pack_id; 
}
?>