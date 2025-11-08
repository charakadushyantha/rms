<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Alternative Email Configuration (Port 587 with TLS)
|--------------------------------------------------------------------------
| If port 465 with SSL doesn't work, try this configuration instead.
| 
| To use this:
| 1. Rename email.php to email_backup.php
| 2. Rename this file to email.php
|
*/

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';
$config['smtp_port']   = 587;  // Using TLS port instead of SSL
$config['smtp_timeout'] = 60;
$config['smtp_user']   = SENDER_EMAIL;
$config['smtp_pass']   = SENDER_PASSWORD;
$config['smtp_crypto'] = 'tls';  // Using TLS instead of SSL
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['mailtype']    = 'html';
$config['validation']  = TRUE;
$config['crlf']        = "\r\n";
$config['wordwrap']    = TRUE;
