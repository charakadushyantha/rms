<?php
// Simple diagnostic to check what's happening
// DELETE THIS FILE AFTER CHECKING!

echo "<h2>Environment Diagnostic</h2>";

echo "<h3>Server Variables:</h3>";
echo "HTTP_HOST: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'NOT SET') . "<br>";
echo "SERVER_NAME: " . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'NOT SET') . "<br>";
echo "REQUEST_URI: " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'NOT SET') . "<br>";

echo "<h3>Detection Test:</h3>";
$current_domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
echo "Current Domain: <strong>" . $current_domain . "</strong><br>";

if (strpos($current_domain, 'lankantech.com') !== false) {
    echo "✅ Domain contains 'lankantech.com' - Should use PRODUCTION<br>";
} else {
    echo "❌ Domain does NOT contain 'lankantech.com' - Will use DEVELOPMENT<br>";
}

echo "<h3>Expected:</h3>";
echo "For production, HTTP_HOST should be: <strong>rms.lankantech.com</strong><br>";

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ DELETE THIS FILE:</strong> diagnose.php";
echo "</p>";
?>
