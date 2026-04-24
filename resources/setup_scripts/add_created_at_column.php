<?php
/**
 * Add created_at column to candidate_details table
 * Run this file from browser: http://localhost/rms/add_created_at_column.php
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

echo "<!DOCTYPE html><html><head><title>Add Created At Column</title></head><body>";
echo "<h2>Adding created_at Column to candidate_details Table</h2>";
echo "<hr>";

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color:green;'>✓ Database connection successful!</p>";

// Check if column exists
$result = $conn->query("SHOW COLUMNS FROM candidate_details LIKE 'cd_created_at'");

if ($result->num_rows > 0) {
    echo "<p style='color:orange;'>⚠ Column 'cd_created_at' already exists!</p>";
} else {
    // Add the column
    $sql = "ALTER TABLE candidate_details ADD COLUMN cd_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER cd_interview_status";
    
    if ($conn->query($sql)) {
        echo "<p style='color:green;'>✓ Column 'cd_created_at' added successfully!</p>";
        
        // Update existing records with random dates in the past month
        $update_sql = "UPDATE candidate_details 
                      SET cd_created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 30) DAY)
                      WHERE cd_created_at IS NULL OR cd_created_at = '0000-00-00 00:00:00'";
        
        if ($conn->query($update_sql)) {
            echo "<p style='color:green;'>✓ Existing records updated with timestamps!</p>";
        }
    } else {
        echo "<p style='color:red;'>✗ Error adding column: " . $conn->error . "</p>";
    }
}

$conn->close();

echo "<hr>";
echo "<p><a href='index.php/A_dashboard/Asele_candidate_view'>Go to Selected Candidates Page</a></p>";
echo "<p style='color:red;'><strong>Note:</strong> Delete this file after running!</p>";
echo "</body></html>";
