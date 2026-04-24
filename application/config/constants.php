<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('TABLE_PREFIX', 'npb_');
define('RANDOM_CHAR','0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('RANDOM_CHAR_NUM','0123456789');
define('API_KEY', 'FIHCOM@786');
define('API_USER', 'admin');
define('API_PASS', '1234');

//define('gloginclientId','538066901125-a31neb1tp54a625ns8ukvc2ep1rbj7h8.apps.googleusercontent.com');
//define('gloginclientSecret','b4lJzIvW7epyZ3lpkLbXANp4');
define('gloginclientId','763107246984-u2vkj7mtoq4aekevfd11n76q1pintijq.apps.googleusercontent.com');
define('gloginclientSecret','N5YwDag5_Ize-qIlCc8LdLj2');
//define('gloginredirecturl','http://eclickprojects.com/instant-scouting/code/v1/userauthgoogle');
//define('gloginredirecturl','https://www.bestphpwebsites.com/qeip-llc/register/userauthgoogle');
define('gloginredirecturl','https://fih.com/register/userauthgoogle');

//define('EMAIL_FROM',                            'noreply@eclickprojects.com');		// e.g. info@luxlifecars.com noreply@hawsabah.sa
define('EMAIL_FROM',                            'team@fih.com');
define('EMAIL_BCC',                            	'Your bcc email');		// e.g. email@example.com
define('FROM_NAME',                             'FIH.com');	// Your system name
define('EMAIL_PASS',                            'Your email password');	// Your email password
define('PROTOCOL',                             	'smtp');				// mail, sendmail, smtp
define('SMTP_HOST',                             'smtp.gmail.com');		// your smtp host e.g. smtp.gmail.com
define('SMTP_PORT',                             '587');					// your smtp port e.g. 25, 587

define('SMTP_USER',                             'fihsocial@gmail.com');	
define('SMTP_PASS',                             'Qdy2aNQmtqYfeLSQ9YnHpq');
//define('SMTP_USER',                             'eclicknoreply@gmail.com');	
//define('SMTP_PASS',                             'eclick@@321');
define('MAIL_PATH',                             '/usr/sbin/sendmail');
define('SMTP_CRYPTO',                           'TLS');
define('SMTP_TIMEOUT',                          '30');
define('SMTP_SECURE',                          'ssl');

//plaid----------------------------------------------
/*define('PLAID_URL',                          'https://sandbox.plaid.com');
define('PLAID_CLIENT_ID',                    '5fac02f2ff7ece00122ba94b');
define('PLAID_CLIENT_SECRET',                '494a6512ba52fb478f3a153274f906');
define('PLAID_CLIENT_NAME',                     'Qeip llc');
define('PLAID_WEBHOOK',                     'https://www.bestphpwebsites.com/qeip-llc/plaidwebhook');
//define('PLAID_WEBHOOK',                     'https://localhost/qeip-llc/plaidwebhook');

/*define('PLAID_URL',                          'https://development.plaid.com');
define('PLAID_CLIENT_ID',                    '607779a09d70d400105ed583');
define('PLAID_CLIENT_SECRET',                '9abb4beec19a3dc41957823ac03b09');
define('PLAID_CLIENT_NAME',                  'Fih.com');
define('PLAID_WEBHOOK',                     'https://www.fih.com/plaidwebhook');*/

define('PLAID_URL',                          'https://production.plaid.com');
define('PLAID_CLIENT_ID',                    '607779a09d70d400105ed583');
define('PLAID_CLIENT_SECRET',                '9421daa6bc52708019808ccef76be9');
define('PLAID_CLIENT_NAME',                  'Fih.com');
define('PLAID_WEBHOOK',                     'https://www.fih.com/plaidwebhook');

define('PERSONA_TEMPLATE_ID',                     'tmpl_DhApX6bWebdQd85887WP7iHX');
define('PERSONA_ENVIRONMENT',                     'production');
// define('CAPTCHAKEY',                     '6LccsN0dAAAAAJ-Wsz78vPsU3Om7hJWjIF2LlhlU');
// define('CAPTCHASECRET',                     '6LccsN0dAAAAAG6J55Bht6imAm4enYKLELverOpt');

define('CAPTCHAKEY',                     '6LdteKwkAAAAAGODLOrKRcQPGW6x_a8-hl1Hbz_q');
define('CAPTCHASECRET',                     '6LdteKwkAAAAAMCAlb45piROXysPFrspc66F83Qe');

////Plaid and Persona login are neil@qeip.com with Krish@2021 as the password