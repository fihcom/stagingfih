<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// Paypal library configuration
// ------------------------------------------------------------------------

// PayPal environment, Sandbox or Live
$config['sandbox'] = false; // FALSE for live environment
// PayPal business email
$config['business'] = 'sb-uc6vn1906342@business.example.com';
// What is the default currency?
$config['paypal_lib_currency_code'] = 'USD';
// Where is the button located at?
$config['paypal_lib_button_path'] = 'assets/frontend/images/';
// If (and where) to log ipn response in a file
$config['paypal_lib_ipn_log'] = true;
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
//team@fih.com
//