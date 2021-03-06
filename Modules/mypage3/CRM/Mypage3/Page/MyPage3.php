<?php

require_once 'CRM/Core/Page.php';

class CRM_Mypage3_Page_MyPage3 extends CRM_Core_Page {
  function run() {
	   
    CRM_Utils_System::setTitle(ts('My Page View'));

    $session =& CRM_Core_Session::singleton( );
    $loggedInUserId = $session->get('userID');
	
    $params = array(
	  'version' => 3,
	  'id' => $loggedInUserId);

    $contactData 	= civicrm_api('contact','get',$params ); 
   
    $params['return']	= 'custom_9';
    $contactCustomData  = civicrm_api('contact','get',$params); 

    $this->assign('contactData', $contactData["values"][$loggedInUserId]);
    $this->assign('contactCustomData', $contactCustomData["values"][$loggedInUserId]);	

    parent::run();
  }
}
