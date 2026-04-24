<?php
echo "<h2>PHP Configuration Check</h2>";

echo "<h3>OpenSSL Extension:</h3>";
if (extension_loaded('openssl')) {
    echo "<p style='color: green;'>✓ OpenSSL is ENABLED</p>";
} else {
    echo "<p style='color: red;'>✗ OpenSSL is DISABLED</p>";
    echo "<p><strong>Fix:</strong> Edit php.ini and uncomment: extension=openssl</p>";
    echo "<p>Location: C:\\xampp\\php\\php.ini</p>";
}

echo "<h3>Socket Functions:</h3>";
if (function_exists('fsockopen')) {
    echo "<p style='color: green;'>✓ fsockopen is available</p>";
} else {
    echo "<p style='color: red;'>✗ fsockopen is not available</p>";
}

echo "<h3>SMTP Connection Test:</h3>";
echo "<p>Testing connection to smtp.gmail.com:465...</p>";

$smtp = @fsockopen('smtp.gmail.com', 465, $errno, $errstr, 10);
if ($smtp) {
    echo "<p style='color: green;'>✓ Can connect to smtp.gmail.com:465</p>";
    fclose($smtp);
} else {
    echo "<p style='color: red;'>✗ Cannot connect: $errstr ($errno)</p>";
}

echo "<h3>Alternative Port Test:</h3>";
echo "<p>Testing connection to smtp.gmail.com:587...</p>";

$smtp587 = @fsockopen('smtp.gmail.com', 587, $errno587, $errstr587, 10);
if ($smtp587) {
    echo "<p style='color: green;'>✓ Can connect to smtp.gmail.com:587</p>";
    echo "<p><strong>Recommendation:</strong> Use port 587 with TLS instead of 465</p>";
    fclose($smtp587);
} else {
    echo "<p style='color: red;'>✗ Cannot connect: $errstr587 ($errno587)</p>";
}

echo "<h3>DNS Resolution Test:</h3>";
$ip = gethostbyname('smtp.gmail.com');
if ($ip != 'smtp.gmail.com') {
    echo "<p style='color: green;'>✓ Can resolve smtp.gmail.com to: $ip</p>";
} else {
    echo "<p style='color: red;'>✗ Cannot resolve smtp.gmail.com</p>";
    echo "<p>This might be a DNS or network issue</p>";
}

echo "<h3>PHP Version:</h3>";
echo "<p>" . phpversion() . "</p>";

echo "<h3>Loaded Extensions:</h3>";
$extensions = get_loaded_extensions();
if (in_array('openssl', $extensions)) {
    echo "<p style='color: green;'>OpenSSL version: " . OPENSSL_VERSION_TEXT . "</p>";
}
?>
