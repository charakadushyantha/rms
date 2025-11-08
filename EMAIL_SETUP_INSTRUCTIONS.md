# Email Setup Instructions

## Problem
The application shows: "Your Account has been Created but Activation mail is not sent to Admin due to error"

## Root Cause
Gmail has updated its security policies and no longer allows simple password authentication for SMTP.

## Solutions

### Option 1: Use Gmail App Password (Recommended)

1. **Enable 2-Factor Authentication** on your Google Account:
   - Go to https://myaccount.google.com/security
   - Enable 2-Step Verification

2. **Generate an App Password**:
   - Go to https://myaccount.google.com/apppasswords
   - Select "Mail" and "Windows Computer" (or Other)
   - Click "Generate"
   - Copy the 16-character password

3. **Update the password in `application/config/constants.php`**:
   ```php
   define('SENDER_EMAIL','your-email@gmail.com');
   define('SENDER_PASSWORD','xxxx xxxx xxxx xxxx'); // Use the App Password here
   ```

### Option 2: Use a Different Email Service

Instead of Gmail, consider using:

#### SendGrid (Free tier: 100 emails/day)
```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'apikey';
$config['smtp_pass'] = 'YOUR_SENDGRID_API_KEY';
$config['smtp_crypto'] = 'tls';
```

#### Mailgun (Free tier: 5,000 emails/month)
```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.mailgun.org';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'postmaster@your-domain.mailgun.org';
$config['smtp_pass'] = 'YOUR_MAILGUN_PASSWORD';
$config['smtp_crypto'] = 'tls';
```

### Option 3: Use PHP mail() Function (For Testing Only)

Update `application/config/email.php`:
```php
$config['protocol'] = 'mail';
$config['mailtype'] = 'html';
```

**Note**: This requires your server to have a mail server configured (like Postfix or Sendmail).

## Debugging

To see detailed error messages:

1. Check the log file at `application/logs/log-YYYY-MM-DD.php`
2. Look for entries starting with "ERROR - Email sending failed:"

## Testing Email Configuration

Create a test file `test_email.php` in your root directory:

```php
<?php
require_once('application/config/constants.php');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'ssl://smtp.gmail.com';
$config['smtp_port']   = 465;
$config['smtp_user']   = SENDER_EMAIL;
$config['smtp_pass']   = SENDER_PASSWORD;
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['mailtype']    = 'html';

$CI =& get_instance();
$CI->load->library('email', $config);

$CI->email->from(SENDER_EMAIL, 'Test');
$CI->email->to(SENDER_EMAIL);
$CI->email->subject('Test Email');
$CI->email->message('This is a test email.');

if($CI->email->send()) {
    echo "Email sent successfully!";
} else {
    echo "Email failed to send.<br>";
    echo $CI->email->print_debugger();
}
?>
```

## Changes Made

1. ✅ Created `application/config/email.php` for centralized email configuration
2. ✅ Updated `sendmail()` method to use the config file and added error logging
3. ✅ Added detailed error logging to help debug email issues
4. ✅ Improved email HTML formatting

## Next Steps

1. Update your Gmail credentials with an App Password
2. Test account creation
3. Check `application/logs/` for any error messages if it still fails
4. Consider using a dedicated email service for production
