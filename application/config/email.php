<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Email Configuration
|--------------------------------------------------------------------------
| Configure email settings for the application
|
| IMPORTANT: For Gmail, you need to:
| 1. Enable 2-Factor Authentication on your Google Account
| 2. Generate an App Password: https://myaccount.google.com/apppasswords
| 3. Use the App Password instead of your regular password
|
| Alternative: Use a different SMTP service like SendGrid, Mailgun, etc.
*/

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';  // Don't include ssl:// prefix
$config['smtp_port']   = 465;
$config['smtp_timeout'] = 60;
$config['smtp_user']   = SENDER_EMAIL;  // Defined in constants.php
$config['smtp_pass']   = SENDER_PASSWORD;  // Use App Password for Gmail
$config['smtp_crypto'] = 'ssl';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['mailtype']    = 'html';
$config['validation']  = TRUE;
$config['crlf']        = "\r\n";
$config['wordwrap']    = TRUE;
