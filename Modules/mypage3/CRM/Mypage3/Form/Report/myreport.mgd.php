<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Mypage3_Form_Report_myreport',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'myreport',
      'description' => 'myreport (org.mypage3)',
      'class_name' => 'CRM_Mypage3_Form_Report_myreport',
      'report_url' => 'mypage3/myreport',
      'component' => 'CiviEvent',
    ),
  ),
);
