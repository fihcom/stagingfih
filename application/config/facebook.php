<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
|
| To get an facebook app details you have to create a Facebook app
| at Facebook developers panel (https://developers.facebook.com)
|
|  facebook_app_id               string   Your Facebook App ID.
|  facebook_app_secret           string   Your Facebook App Secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)
|  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)
|  facebook_permissions          array    Your required permissions.
|  facebook_graph_version        string   Specify Facebook Graph version. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.
*/
//$config['facebook_app_id']              = '1414603712058284';
//$config['facebook_app_secret']          = '50aaa658a4c484f72ab8327eea8c2cc6';
//$config['facebook_app_id']              = '812136082872945';
//$config['facebook_app_secret']          = '3601d941832a820711af107e3133304a';
$config['facebook_app_id']              = '458870781864893';
$config['facebook_app_secret']          = '10c2576766b2cc41b88b8b5dc33babef';

//$config['facebook_app_id']              = '2782714752025660';
//$config['facebook_app_secret']          = '56c97b1fe3c40824ff34fc728e8cbb40';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'userauthfb';
$config['facebook_logout_redirect_url'] = 'login/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.6';
$config['facebook_auth_on_load']        = TRUE;
