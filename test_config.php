<?php
// Simple test to verify configuration loads without errors
// DELETE THIS FILE AFTER TESTING!

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Configuration Load...</h2>";

try {
    // Define BASEPATH
    define('BASEPATH', dirname(__FILE__) . '/system/');
    define('APPPATH', dirname(__FILE__) . '/application/');
    
    echo "✅ BASEPATH and APPPATH defined<br>";
    
    // Load environment
    require_once('application/config/environment.php');
    echo "✅ Environment loaded<br>";
    
    // Load constants
    require_once('application/config/constants.php');
    echo "✅ Constants loaded<br>";
    
    echo "<br><h3>Configuration Values:</h3>";
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th style='padding:10px;'>Constant</th><th style='padding:10px;'>Value</th></tr>";
    echo "<tr><td style='padding:10px;'>APP_ENVIRONMENT</td><td style='padding:10px;'>" . APP_ENVIRONMENT . "</td></tr>";
    echo "<tr><td style='padding:10px;'>APP_URL</td><td style='padding:10px;'>" . APP_URL . "</td></tr>";
    echo "<tr><td style='padding:10px;'>BASE_URL</td><td style='padding:10px;'>" . BASE_URL . "</td></tr>";
    echo "<tr><td style='padding:10px;'>LOGIN_URL</td><td style='padding:10px;'>" . LOGIN_URL . "</td></tr>";
    echo "</table>";
    
    echo "<br><h3 style='color:green;'>✅ All configuration loaded successfully!</h3>";
    echo "<p>The site should now work correctly.</p>";
    
} catch (Exception $e) {
    echo "<h3 style='color:red;'>❌ Error: " . $e->getMessage() . "</h3>";
}

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ DELETE THIS FILE:</strong> test_config.php";
echo "</p>";
?>
