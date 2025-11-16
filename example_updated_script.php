<?php
/**
 * Example: Updated Script Using Central Database Configuration
 * 
 * This shows how your scripts will look after migration.
 * Compare this with your old scripts to see the difference.
 */

// BEFORE (Old way - hardcoded credentials):
/*
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cmsadver_rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/

// AFTER (New way - central config):
require_once __DIR__ . '/config/database.php';

try {
    $conn = getDatabaseConnection();
    
    // Your database operations here
    $result = $conn->query("SELECT COUNT(*) as total FROM users");
    
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Total users: " . $row['total'];
    }
    
    $conn->close();
    
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

// Benefits of the new approach:
// 1. One line to include config instead of 4-5 lines
// 2. Automatic error handling
// 3. Change credentials once, applies everywhere
// 4. Environment-aware (dev/staging/production)
// 5. Secure (credentials in .env, not in code)
