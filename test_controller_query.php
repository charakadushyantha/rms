<?php
/**
 * Test the exact query the controller should be using
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>🔍 Testing Controller Query</h2>";

// Test 1: Simple SELECT * (what controller should use now)
echo "<h3>Test 1: Simple SELECT * FROM module_visibility</h3>";
$result1 = $conn->query("SELECT * FROM module_visibility");
echo "<p><strong>Result:</strong> " . $result1->num_rows . " modules found</p>";

if ($result1->num_rows == 45) {
    echo "<p style='color: green;'>✅ Query returns all 45 modules!</p>";
} else {
    echo "<p style='color: red;'>❌ Query only returns " . $result1->num_rows . " modules</p>";
}

// Test 2: With ORDER BY (what was failing before)
echo "<h3>Test 2: SELECT * FROM module_visibility ORDER BY section, module_name</h3>";
$result2 = $conn->query("SELECT * FROM module_visibility ORDER BY section ASC, module_name ASC");
if ($result2) {
    echo "<p><strong>Result:</strong> " . $result2->num_rows . " modules found</p>";
    
    if ($result2->num_rows == 45) {
        echo "<p style='color: green;'>✅ ORDER BY query works now!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ ORDER BY only returns " . $result2->num_rows . " modules</p>";
    }
} else {
    echo "<p style='color: red;'>❌ ORDER BY query failed: " . $conn->error . "</p>";
}

// Test 3: Check for NULL values
echo "<h3>Test 3: Checking for NULL values</h3>";
$null_check = $conn->query("SELECT COUNT(*) as count FROM module_visibility WHERE module_name IS NULL OR module_name = ''");
$null_count = $null_check->fetch_assoc();
echo "<p><strong>Modules with NULL/empty module_name:</strong> " . $null_count['count'] . "</p>";

if ($null_count['count'] > 0) {
    echo "<p style='color: orange;'>⚠️ Found " . $null_count['count'] . " modules with NULL/empty names</p>";
    echo "<p>This might be causing the ORDER BY to fail!</p>";
    
    // Show which ones
    $null_modules = $conn->query("SELECT module_key FROM module_visibility WHERE module_name IS NULL OR module_name = ''");
    echo "<p><strong>Modules with NULL names:</strong></p>";
    echo "<ul>";
    while ($row = $null_modules->fetch_assoc()) {
        echo "<li>" . $row['module_key'] . "</li>";
    }
    echo "</ul>";
}

$conn->close();

// Clear OPcache
echo "<h3>Clearing PHP Cache</h3>";
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<p>✅ OPcache cleared</p>";
} else {
    echo "<p>ℹ️ OPcache not enabled</p>";
}

clearstatcache();
echo "<p>✅ File stat cache cleared</p>";

echo "<br><br>";
echo "<div style='padding: 20px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #92400e;'>⚠️ IMPORTANT</h3>";
echo "<p style='color: #92400e;'>If Test 1 shows 45 modules but Module Manager still shows 11:</p>";
echo "<ol style='color: #92400e;'>";
echo "<li><strong>Stop Apache</strong> in XAMPP Control Panel</li>";
echo "<li>Wait 5 seconds</li>";
echo "<li><strong>Start Apache</strong> again</li>";
echo "<li>Then open Module Manager</li>";
echo "</ol>";
echo "</div>";

echo "<br>";
echo "<div style='padding: 20px; margin: 20px 0;'>";
echo "<a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Open Module Manager →</a>";
echo " ";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
