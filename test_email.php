<?php
// Quick email test script
define('BASEPATH', TRUE);

// Load CodeIgniter constants
require_once('application/config/constants.php');

echo "<h2>Email Configuration Test</h2>";
echo "<p><strong>SMTP Host:</strong> ssl://smtp.gmail.com</p>";
echo "<p><strong>SMTP Port:</strong> 465</p>";
echo "<p><strong>Email:</strong> " . SENDER_EMAIL . "</p>";
echo "<p><strong>Password:</strong> " . (SENDER_PASSWORD ? str_repeat('*', strlen(SENDER_PASSWORD)) : 'NOT SET') . "</p>";

echo "<hr>";
echo "<h3>Testing SMTP Connection...</h3>";

// Test SMTP connection
$smtp = @fsockopen('ssl://smtp.gmail.com', 465, $errno, $errstr, 30);

if ($smtp) {
    echo "<p style='color: green;'>✓ SMTP connection successful!</p>";
    fclose($smtp);
} else {
    echo "<p style='color: red;'>✗ SMTP connection failed: $errstr ($errno)</p>";
    echo "<p>This could mean:</p>";
    echo "<ul>";
    echo "<li>Your server doesn't have SSL/TLS support enabled</li>";
    echo "<li>Port 465 is blocked by firewall</li>";
    echo "<li>PHP openssl extension is not enabled</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<h3>PHP Configuration:</h3>";
echo "<p><strong>OpenSSL:</strong> " . (extension_loaded('openssl') ? '✓ Enabled' : '✗ Disabled') . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

echo "<hr>";
echo "<h3>Common Issues & Solutions:</h3>";
echo "<ol>";
echo "<li><strong>Gmail App Password Required:</strong><br>";
echo "Gmail no longer accepts regular passwords. You need to:<br>";
echo "- Enable 2FA: <a href='https://myaccount.google.com/security' target='_blank'>https://myaccount.google.com/security</a><br>";
echo "- Generate App Password: <a href='https://myaccount.google.com/apppasswords' target='_blank'>https://myaccount.google.com/apppasswords</a><br>";
echo "- Update SENDER_PASSWORD in application/config/constants.php</li>";
echo "<li><strong>OpenSSL Not Enabled:</strong><br>";
echo "Edit php.ini and uncomment: extension=openssl</li>";
echo "<li><strong>Alternative:</strong> Use a different SMTP service (SendGrid, Mailgun, etc.)</li>";
echo "</ol>";
?>
