<?php

require_once 'braintree.civix.php';

/**
 * Implementation of hook_civicrm_config().
 */
function braintree_civicrm_config(&$config) {
  _braintree_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_install().
 */
function braintree_civicrm_install() {
  return _braintree_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall().
 */
function braintree_civicrm_uninstall() {
  return _braintree_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable().
 */
function braintree_civicrm_enable() {
  return _braintree_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable().
 */
function braintree_civicrm_disable() {
  return _braintree_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function braintree_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _braintree_civix_civicrm_upgrade($op, $queue);
}



/**
 * Implementation of hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function braintree_civicrm_managed(&$entities) {
  $entities[] = array(
    'module' => 'com.paymentprocessor.braintree',
    'name' => 'braintree',
    'entity' => 'PaymentProcessorType',
    'params' => array(
      'version' => 3,
      'name' => 'braintree',
      'title' => 'Braintree',
      'description' => 'Braintree Payment Processor',
      'class_name' => 'Payment_Braintree',
      'billing_mode' => 1,
      'user_name_label' => 'Merchant Id',
      'password_label' => 'Public Key',
      'signature_label' => 'Private Key',
      'url_site_default'=> NULL,
      'url_recur_default' => NULL,
      'url_site_test_default' => NULL,
      'url_recur_test_default' => NULL,
      'is_recur' => 1,
      'payment_type' => 1
    ),
  );

  return _braintree_civix_civicrm_managed($entities);
}
