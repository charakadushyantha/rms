<?php
/**
 * Test Database Connection
 * Run this first to verify your database is accessible
 */

echo "<h2>🔍 Testing Database Connection</h2>";

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

echo "<p><strong>Attempting to connect to:</strong></p>";
echo "<ul>";
echo "<li>Host: $host</li>";
echo "<li>Username: $username</li>";
echo "<li>Database: $database</li>";
echo "</ul>";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo "<div style='padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #991b1b; margin: 0 0 10px 0;'>❌ Connection Failed!</h3>";
    echo "<p style='color: #991b1b; margin: 0;'>Error: " . $conn->connect_error . "</p>";
    echo "</div>";
    
    echo "<h3>💡 Possible Solutions:</h3>";
    echo "<ol>";
    echo "<li>Make sure XAMPP MySQL is running</li>";
    echo "<li>Check if database name is 'rmsdb' (or update the script)</li>";
    echo "<li>Verify MySQL username is 'root' with no password</li>";
    echo "</ol>";
    die();
}

echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46; margin: 0 0 10px 0;'>✅ Connection Successful!</h3>";
echo "<p style='color: #065f46; margin: 0;'>Connected to database: <strong>$database</strong></p>";
echo "</div>";

// Check if module_visibility table exists
$table_check = $conn->query("SHOW TABLES LIKE 'module_visibility'");

if ($table_check->num_rows > 0) {
    echo "<div style='padding: 20px; background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #1e40af; margin: 0 0 10px 0;'>✅ Table 'module_visibility' exists</h3>";
    
    // Check current structure
    $columns = $conn->query("SHOW COLUMNS FROM module_visibility");
    echo "<p style='color: #1e40af;'><strong>Current columns:</strong></p>";
    echo "<ul style='color: #1e40af;'>";
    while ($col = $columns->fetch_assoc()) {
        echo "<li>" . $col['Field'] . " (" . $col['Type'] . ")</li>";
    }
    echo "</ul>";
    
    // Count current modules
    $count_result = $conn->query("SELECT COUNT(*) as total FROM module_visibility");
    $count = $count_result->fetch_assoc();
    echo "<p style='color: #1e40af;'><strong>Current modules in table:</strong> " . $count['total'] . "</p>";
    
    echo "</div>";
    
    echo "<div style='padding: 20px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #92400e; margin: 0 0 10px 0;'>📋 Next Step</h3>";
    echo "<p style='color: #92400e; margin: 0;'>Everything looks good! Now run the update script:</p>";
    echo "<p style='margin: 10px 0;'><a href='update_module_visibility_complete.php' style='display: inline-block; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Run Update Script →</a></p>";
    echo "</div>";
    
} else {
    echo "<div style='padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #991b1b; margin: 0 0 10px 0;'>❌ Table 'module_visibility' does NOT exist</h3>";
    echo "<p style='color: #991b1b; margin: 0;'>You need to create the table first.</p>";
    echo "<p style='margin: 10px 0;'><a href='create_modules_table.php' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Create Table First →</a></p>";
    echo "</div>";
}

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; margin: 20px 0; border-top: 2px solid #e5e7eb;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
