<?php

class CRM_Mypage2_BAO_Utills  {


  static function getContactDetailById($contactId,$returnArray = array()) {
    
   $params = array(
	  'version' => 3,
	  'id' => $contactId);
   
    $contactData = civicrm_api( 'contact','get',$params); 

    return $contactData;	
  }


}

