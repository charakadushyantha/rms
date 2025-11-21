<?php
/**
 * Clear PHP Cache and Test Module Manager
 */

echo "<h2>🔄 Clearing PHP Cache</h2>";

// Clear OPcache if available
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<p>✅ OPcache cleared</p>";
} else {
    echo "<p>ℹ️ OPcache not enabled</p>";
}

// Clear file stat cache
clearstatcache();
echo "<p>✅ File stat cache cleared</p>";

echo "<br>";
echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46; margin: 0 0 10px 0;'>✅ Cache Cleared!</h3>";
echo "<p style='color: #065f46; margin: 0;'>Now test the Module Manager:</p>";
echo "<p style='margin: 10px 0;'><a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Open Module Manager →</a></p>";
echo "</div>";

echo "<h3>🔍 Quick Test</h3>";
echo "<p>Let's verify the controller can load the data:</p>";

// Simulate what the controller does
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM module_visibility ORDER BY section ASC, module_name ASC");
$count = $result->num_rows;

echo "<p><strong>Modules found:</strong> $count</p>";

if ($count > 11) {
    echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #065f46;'>✅ Database Query Works!</h3>";
    echo "<p style='color: #065f46;'>Found $count modules. The controller should be able to load them.</p>";
    echo "</div>";
} else {
    echo "<div style='padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #991b1b;'>❌ Problem!</h3>";
    echo "<p style='color: #991b1b;'>Only found $count modules. Run update_module_visibility_complete.php first.</p>";
    echo "</div>";
}

$conn->close();

echo "<br><br>";
echo "<h3>📋 Next Steps</h3>";
echo "<ol>";
echo "<li>Click 'Open Module Manager' button above</li>";
echo "<li>Press Ctrl+F5 to hard refresh</li>";
echo "<li>You should see 45 modules (not 11)</li>";
echo "</ol>";

echo "<br>";
echo "<div style='padding: 20px; margin: 20px 0; border-top: 2px solid #e5e7eb;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
