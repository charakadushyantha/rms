# Email Troubleshooting Guide

## Current Status
Error: "Your Account has been Created but Activation mail is not sent to Admin due to error"

## Step-by-Step Debugging

### Step 1: Test SMTP Connection
1. Open your browser and go to: `http://localhost/rms/test_email.php`
2. This will show if your server can connect to Gmail's SMTP server
3. Check if OpenSSL is enabled

### Step 2: Check Error Logs
After trying to create an account, check these files:
1. `application/logs/log-YYYY-MM-DD.php` - CodeIgniter logs
2. `email_error.log` (in root directory) - Detailed email errors

### Step 3: Common Issues & Solutions

#### Issue 1: Gmail Authentication Failed
**Symptoms:** "SMTP Error: Could not authenticate"

**Solution:**
```php
// In application/config/constants.php
define('SENDER_EMAIL','your-email@gmail.com');
define('SENDER_PASSWORD','xxxx xxxx xxxx xxxx'); // 16-character App Password
```

**How to get App Password:**
1. Go to https://myaccount.google.com/security
2. Enable "2-Step Verification"
3. Go to https://myaccount.google.com/apppasswords
4. Select "Mail" and "Other (Custom name)"
5. Copy the 16-character password
6. Paste it in constants.php (with or without spaces)

#### Issue 2: OpenSSL Not Enabled
**Symptoms:** "Unable to connect via TLS" or "SSL operation failed"

**Solution:**
1. Open `php.ini` file (in XAMPP: `C:\xampp\php\php.ini`)
2. Find this line: `;extension=openssl`
3. Remove the semicolon: `extension=openssl`
4. Restart Apache
5. Verify: Run `test_email.php` to check if OpenSSL is enabled

#### Issue 3: Port 465 Blocked
**Symptoms:** "Connection timeout" or "Could not connect to SMTP host"

**Solution - Try Port 587 with TLS:**
```php
// In application/config/email.php
$config['smtp_host']   = 'smtp.gmail.com'; // Remove ssl://
$config['smtp_port']   = 587;
$config['smtp_crypto'] = 'tls';
```

#### Issue 4: Firewall/Antivirus Blocking
**Symptoms:** Connection timeout

**Solution:**
1. Temporarily disable firewall/antivirus
2. If it works, add exception for PHP/Apache
3. Or use alternative SMTP service

### Step 4: Alternative Solutions

#### Option A: Use SendGrid (Recommended for Production)
Free tier: 100 emails/day

1. Sign up at https://sendgrid.com
2. Get API Key
3. Update `application/config/email.php`:
```php
$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.sendgrid.net';
$config['smtp_port']   = 587;
$config['smtp_user']   = 'apikey';
$config['smtp_pass']   = 'YOUR_SENDGRID_API_KEY';
$config['smtp_crypto'] = 'tls';
```

#### Option B: Use Mailtrap (For Testing)
Perfect for development/testing

1. Sign up at https://mailtrap.io
2. Get credentials from inbox settings
3. Update `application/config/email.php`:
```php
$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.mailtrap.io';
$config['smtp_port']   = 2525;
$config['smtp_user']   = 'your_mailtrap_username';
$config['smtp_pass']   = 'your_mailtrap_password';
$config['smtp_crypto'] = 'tls';
```

#### Option C: Use PHP mail() (Local Testing Only)
```php
// In application/config/email.php
$config['protocol'] = 'mail';
$config['mailtype'] = 'html';
```
**Note:** Requires mail server (Postfix/Sendmail) configured on your system

### Step 5: Verify Configuration

Run this command to check your current settings:
```bash
php -r "echo 'OpenSSL: ' . (extension_loaded('openssl') ? 'Enabled' : 'Disabled') . PHP_EOL;"
```

### Step 6: Test Email Manually

Create `manual_test.php` in root:
```php
<?php
define('BASEPATH', TRUE);
require_once('index.php');

$CI =& get_instance();
$CI->load->library('email');

$CI->email->from('your-email@gmail.com', 'Test');
$CI->email->to('your-email@gmail.com');
$CI->email->subject('Test Email');
$CI->email->message('This is a test.');

if($CI->email->send()) {
    echo "Success!";
} else {
    echo $CI->email->print_debugger();
}
?>
```

## Quick Checklist

- [ ] Enabled 2FA on Gmail account
- [ ] Generated App Password
- [ ] Updated SENDER_PASSWORD in constants.php
- [ ] OpenSSL extension enabled in php.ini
- [ ] Restarted Apache after php.ini changes
- [ ] Checked application/logs/ for errors
- [ ] Checked email_error.log for details
- [ ] Ran test_email.php to verify connection
- [ ] Firewall/antivirus not blocking port 465/587

## Still Not Working?

1. Check `email_error.log` in the root directory
2. Check `application/logs/log-YYYY-MM-DD.php`
3. Try using port 587 instead of 465
4. Try using Mailtrap for testing
5. Consider using SendGrid for production

## Need More Help?

Share the contents of:
- `email_error.log`
- Last 20 lines of `application/logs/log-YYYY-MM-DD.php`
- Output from `test_email.php`
