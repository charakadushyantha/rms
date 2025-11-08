<?php
/**
 * Add created_at column to users table
 * Run: http://localhost/rms/add_created_at_column.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Adding created_at Column to Users Table</h1>";
echo "<hr>";

// Check if column already exists
$check = $conn->query("SHOW COLUMNS FROM users LIKE 'u_created_at'");

if ($check->num_rows > 0) {
    echo "<p style='color: orange;'>⚠️ Column 'u_created_at' already exists!</p>";
} else {
    // Add the column
    $sql = "ALTER TABLE users ADD COLUMN u_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER u_status";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✅ Successfully added 'u_created_at' column!</p>";
        
        // Update existing records with current timestamp
        $update = "UPDATE users SET u_created_at = NOW() WHERE u_created_at IS NULL OR u_created_at = '0000-00-00 00:00:00'";
        $conn->query($update);
        
        echo "<p style='color: green;'>✅ Updated existing records with current timestamp</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
    }
}

// Verify the column
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'u_created_at'");
if ($result->num_rows > 0) {
    echo "<hr>";
    echo "<h3>✅ Column Verified</h3>";
    $column = $result->fetch_assoc();
    echo "<pre>";
    print_r($column);
    echo "</pre>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<p><a href='A_dashboard/Arecruiter_view' style='display: inline-block; background: #667eea; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold;'>→ Go to Manage Recruiters</a></p>";
echo "<p style='margin-top: 20px;'><small>You can delete this file after running it.</small></p>";

$conn->close();
?>

<style>
body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
h1 { color: #333; }
a { color: #667eea; text-decoration: none; font-weight: bold; }
pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
</style>
