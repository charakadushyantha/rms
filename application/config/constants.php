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


/* USER DEFINED CONSTANTS FOR APPLICATION */
// Load environment configuration first (if not already loaded)
if (!defined('APP_ENVIRONMENT')) {
    require_once(APPPATH . 'config/environment.php');
}

// Use APP_URL from environment.php (auto-detects production vs development)
if (!defined('BASE_URL')) {
    define('BASE_URL', rtrim(APP_URL, '/'));
}

if (!defined('COMPANY_LOGO')) define('COMPANY_LOGO',BASE_URL.'/Assets/Recruiter_Dashboard/img/logo/CompanyLogo.png');
if (!defined('COMPANY_NAME')) define('COMPANY_NAME',BASE_URL.'/Assets/Recruiter_Dashboard/img/logo/CompanyName.png');
if (!defined('TAB_LOGO')) define('TAB_LOGO',BASE_URL.'/Assets/Recruiter_Dashboard/img/logo/tablogo.png');
if (!defined('SENDER_EMAIL')) define('SENDER_EMAIL','charakaucsc@gmail.com'); // Enter Email Address Bot Email Address
if (!defined('SENDER_PASSWORD')) define('SENDER_PASSWORD','hekunrvfdftkapkf'); // Enter Email id Password real one MIT@UCSC@2020

// for assets
if (!defined('REC_ASSETS_PATH')) define('REC_ASSETS_PATH',BASE_URL.'/Assets/Recruiter_Dashboard');
if (!defined('ADMIN_ASSETS_PATH')) define('ADMIN_ASSETS_PATH',BASE_URL.'/Assets/Admin_Dashboard');
if (!defined('CAL_ASSETS_PATH')) define('CAL_ASSETS_PATH',BASE_URL.'/Assets/Calendar_script/fullcalendar');
if (!defined('SIGN_LOGIN_ASSETS_PATH')) define('SIGN_LOGIN_ASSETS_PATH',BASE_URL.'/Assets/login_page');

// TBLs
if (!defined('TBL_USERS')) define('TBL_USERS','users');
if (!defined('TBL_CANDIDATE_DETAILS')) define('TBL_CANDIDATE_DETAILS','candidate_details');
if (!defined('TBL_CALENDAR')) define('TBL_CALENDAR','calendar_events');
if (!defined('TBL_PROFILE')) define('TBL_PROFILE','profile_info'); // profile INFO TABLE



//Controller
if (!defined('LOGIN_URL')) define('LOGIN_URL',BASE_URL.'/index.php/Login');
if (!defined('SIGNUP_URL')) define('SIGNUP_URL',BASE_URL.'/index.php/Login/signup');
if (!defined('FORGOT_PASSWORD_URL')) define('FORGOT_PASSWORD_URL',BASE_URL.'/index.php/Login/forgotpassword');
if (!defined('RESET_PASSWORD_URL')) define('RESET_PASSWORD_URL',BASE_URL.'/index.php/Login/reset_password');

if (!defined('R_DASHBOARD_URL')) define('R_DASHBOARD_URL',BASE_URL.'/index.php/R_dashboard');
if (!defined('R_CALENDAR_URL')) define('R_CALENDAR_URL',BASE_URL.'/index.php/R_dashboard/Rcalendar_view');
if (!defined('R_CANDIDATE_URL')) define('R_CANDIDATE_URL',BASE_URL.'/index.php/R_dashboard/Rcandidate_view');
if (!defined('R_AC_DETAILS_URL')) define('R_AC_DETAILS_URL',BASE_URL.'/index.php/R_dashboard/Raccount_details_view');
if (!defined('R_SCANDIDATE_URL')) define('R_SCANDIDATE_URL',BASE_URL.'/index.php/R_dashboard/Rscandidate_view');
if (!defined('R_SCHEDULE_URL')) define('R_SCHEDULE_URL',BASE_URL.'/index.php/R_dashboard/Rschedule_view');
if (!defined('R_STATUS_URL')) define('R_STATUS_URL',BASE_URL.'/index.php/R_dashboard/Rstatus_view');
if (!defined('R_LOGOUT_URL')) define('R_LOGOUT_URL',BASE_URL.'/index.php/R_dashboard/logout');



if (!defined('A_DASHBOARD_URL')) define('A_DASHBOARD_URL',BASE_URL.'/index.php/A_dashboard');
if (!defined('A_CALENDAR_URL')) define('A_CALENDAR_URL',BASE_URL.'/index.php/A_dashboard/Acalendar_view');
if (!defined('A_RECRUITER_URL')) define('A_RECRUITER_URL',BASE_URL.'/index.php/A_dashboard/Arecruiter_view');
if (!defined('A_AC_DETAILS_URL')) define('A_AC_DETAILS_URL',BASE_URL.'/index.php/A_dashboard/Aaccount_details_view');
if (!defined('A_SCANDIDATE_URL')) define('A_SCANDIDATE_URL',BASE_URL.'/index.php/A_dashboard/Ascandidate_view');
if (!defined('A_HISTORY_URL')) define('A_HISTORY_URL',BASE_URL.'/index.php/A_dashboard/Ahistory_view');
if (!defined('A_TIMESHEET_URL')) define('A_TIMESHEET_URL',BASE_URL.'/index.php/A_dashboard/Atime_sheet_view');
if (!defined('A_LOGOUT_URL')) define('A_LOGOUT_URL',BASE_URL.'/index.php/A_dashboard/logout');


/*
|--------------------------------------------------------------------------
| Google OAuth Configuration
|--------------------------------------------------------------------------
| Configure Google OAuth 2.0 for social login
|
| To setup:
| 1. Go to https://console.cloud.google.com/
| 2. Create project > Enable Google+ API
| 3. Create OAuth 2.0 Client ID
| 4. Add redirect URI: http://localhost/rms/index.php/Login/google_callback
| 5. Copy Client ID and Secret below
|
*/

// Google OAuth Client ID (Get from Google Cloud Console)
if (!defined('GOOGLE_CLIENT_ID')) define('GOOGLE_CLIENT_ID', '211766688118-sid64ufknl82qceqlaneefmsk5rdo1vt.apps.googleusercontent.com');

// Google OAuth Client Secret (Get from Google Cloud Console)
if (!defined('GOOGLE_CLIENT_SECRET')) define('GOOGLE_CLIENT_SECRET', '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');

// Enable/Disable Google Login (Set to TRUE after configuring credentials)
if (!defined('GOOGLE_LOGIN_ENABLED')) define('GOOGLE_LOGIN_ENABLED', TRUE);
