<?php
/**
 * Database Migration Script
 * Adds profile_picture column to user tables
 * 
 * Run this file once by accessing: http://localhost/rms/add_profile_picture_column.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Adding profile_picture column to user tables...</h2>";

// First, let's find all tables in the database
echo "<h3>Detecting tables in database...</h3>";
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

$user_tables = array();
while ($row = $tables_result->fetch_array()) {
    $table_name = $row[0];
    echo "<p>Found table: <strong>$table_name</strong></p>";
    
    // Look for user-related tables
    if (stripos($table_name, 'user') !== false) {
        $user_tables[] = $table_name;
    }
}

echo "<h3>User-related tables found: " . implode(', ', $user_tables) . "</h3>";

// Try to add profile_picture column to each user table
foreach ($user_tables as $table) {
    echo "<h4>Processing table: $table</h4>";
    
    // Check if table has u_email or similar column
    $columns_query = "SHOW COLUMNS FROM `$table`";
    $columns_result = $conn->query($columns_query);
    
    $has_email = false;
    $email_column = '';
    $has_profile_pic = false;
    
    while ($col = $columns_result->fetch_assoc()) {
        echo "<p style='margin-left: 20px;'>- Column: {$col['Field']}</p>";
        
        if (stripos($col['Field'], 'email') !== false) {
            $has_email = true;
            $email_column = $col['Field'];
        }
        if ($col['Field'] == 'profile_picture') {
            $has_profile_pic = true;
        }
    }
    
    if ($has_profile_pic) {
        echo "<p style='color: orange;'>⚠ profile_picture column already exists in $table</p>";
        continue;
    }
    
    // Add profile_picture column
    if ($has_email) {
        $sql = "ALTER TABLE `$table` 
                ADD COLUMN `profile_picture` VARCHAR(255) NULL DEFAULT NULL 
                AFTER `$email_column`";
    } else {
        $sql = "ALTER TABLE `$table` 
                ADD COLUMN `profile_picture` VARCHAR(255) NULL DEFAULT NULL";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✓ Successfully added profile_picture column to $table</p>";
    } else {
        echo "<p style='color: red;'>✗ Error adding column to $table: " . $conn->error . "</p>";
    }
}

// Create uploads/profiles directory if it doesn't exist
$upload_dir = 'uploads/profiles';
if (!is_dir($upload_dir)) {
    if (mkdir($upload_dir, 0777, true)) {
        echo "<p style='color: green;'>✓ Created uploads/profiles directory</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to create uploads/profiles directory</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ uploads/profiles directory already exists</p>";
}

// Create .htaccess file to allow image access
$htaccess_content = "Options +Indexes\nAllow from all";
$htaccess_file = $upload_dir . '/.htaccess';

if (!file_exists($htaccess_file)) {
    if (file_put_contents($htaccess_file, $htaccess_content)) {
        echo "<p style='color: green;'>✓ Created .htaccess file in uploads/profiles</p>";
    }
}

$conn->close();

echo "<h3 style='color: green;'>Migration completed!</h3>";
echo "<p><a href='index.php'>← Back to Application</a></p>";
?>
