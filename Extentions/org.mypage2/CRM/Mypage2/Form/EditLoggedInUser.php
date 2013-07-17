<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 *
 */
class CRM_Mypage2_Form_EditLoggedInUser extends CRM_Core_Form {
  function buildQuickForm() {
   
    //get current user session	
    CRM_Utils_System::setTitle(ts('My Page Edit Form'));
    $session =& CRM_Core_Session::singleton( );
    $loggedInUserId = $session->get( 'userID' );
	
    $params = array(
	  'version' => 3,
	  'id' => $loggedInUserId);

    $contactData 	= civicrm_api( 'contact','get',$params ); 
   
    $params['return']	= 'custom_9';
    $contactCustomData  = civicrm_api( 'contact','get',$params); 

    $defaults['first_name'] = $contactData["values"][$loggedInUserId]['first_name'];
    $defaults['middle_name'] = $contactData["values"][$loggedInUserId]['middle_name'];
    $defaults['last_name'] = $contactData["values"][$loggedInUserId]['last_name'];
    $defaults['email'] = $contactData["values"][$loggedInUserId]['email'];
    $defaults['phone'] = $contactData["values"][$loggedInUserId]['phone'];
    $defaults['custom_9'] = $contactCustomData["values"][$loggedInUserId]['custom_9'];

    // first_name
    $this->addElement('text', 'first_name', ts('First Name'));
      
    //middle_name
    $this->addElement('text', 'middle_name', ts('Middle Name'));

      // last_name
    $this->addElement('text', 'last_name', ts('Last Name'));

    $this->addElement('text', 'custom_9', ts('Ni Numbers'));	

    $this->addElement('text', 'email', ts('Email'));	

    $this->addElement('text', 'phone', ts('Phone'));	

    $this->setDefaults($defaults);
 
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  function postProcess() {

    $values = $this->exportValues();
    $session =& CRM_Core_Session::singleton( );
    $loggedInUserId = $session->get( 'userID' );
    $params = array(
	  'first_name' => $values["first_name"],
	  'middle_name' => $values["middle_name"],
	  'last_name' => $values["last_name"],
          'custom_9' => $values["custom_9"],
          'id' => $loggedInUserId,
	  'version' => 3,
     );

    $result = civicrm_api('contact','create',$params);

    $paramsEmail = array(
	  'email' => $values["email"],
	  'is_primary' =>1,
          'contact_id' => $loggedInUserId,
	  'version' => 3,
     );

    $result = civicrm_api('email','create',$paramsEmail);

    $paramsPhone = array(
	  'phone' => $values["phone"],
	  'is_primary' =>1,
          'contact_id' => $loggedInUserId,
	  'version' => 3,
     );

    $result = civicrm_api('phone','create',$paramsPhone);

    CRM_Core_Session::setStatus(ts('Contact updated %1', array(
      1 => $values["first_name"]
    )));
   drupal_goto('civicrm/mypage2/view');
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
