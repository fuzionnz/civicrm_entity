<?php

/**
 * @file
 * Api information provided by CiviCRM Entity Price Set Field module
 */

/**
 * @mainpage
 * API Reference Documentation for the CiviCRM Entity Price Set Field module.
 *
 * There are 3 hooks available.
 *
 * The form can be altered via hook_form_alter().
 *
 * The confirmation page and thank you page are theme functions that work with pre_process functions according to standard Drupal conventions
 *
 * To override theme function implement
 * Confirmation Page
 * MYTHEME_civicrm_entity_price_set_field_price_field_display_form_confirmation_page($variables) in your theme
 * Thank you page
 * MYTHEME_civicrm_entity_price_set_field_price_field_display_form_thank_you_page($variables)
 */


/**
 * Add payment processor handlers for CiviCRM Entity Price Set Field
 * The API supports the following keys
 *
 *
 * -- payment_processor_type the unique name of the payment processor type (the name column of the civicrm_payment_processor_type table)
 * -- callback -- The function to invoke that makes the call to the payment processor
 *
 * see civicrm_entity_price_set_field_transact_payment_processing($display, $processor, $processor_type, $price_set_data, $entity_type, $entity, $contacts, $form_state)
 * in includes/civicrm_entity_price_set_field.transaction.inc for an example callback using the CiviCRM API Contribution transact action
 *
 * It really can be anything, doesn't necessarily have to use a CiviCRM Payment Processor.
 *
 * @return array
 */
function hook_civicrm_entity_price_set_field_processor_info() {
  return array(
    'dummy' => array(
      'payment_processor_type' => 'Dummy',
      'callback' => 'civicrm_entity_price_set_field_transact_payment_processing',
    ),
  );
}

/**
 * Alter the CiviCRM payment processor handler info
 *
 * @param $info
 */
function hook_civicrm_entity_price_set_field_processor_info_alter(&$info) {
  $info['dummy']['callback'] = 'mymodule_function_name';
}

/**
 * Alter the $total array which contains the total and each line item
 *
 * @param $total
 */
function hook_civicrm_entity_price_set_field_calculate_total($total) {
  // add 10%
  $total['total'] = $total['total'] * 1.10;
  foreach ($total['line_items'] as $index => $price_fields) {
    foreach ($price_fields as $pf_id => $line_item) {
      $line_item['line_total'] = $line_item['unit_price'] = $line_item['unit_price'] * 1.10;
    }
  }
}