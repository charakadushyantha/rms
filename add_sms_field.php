<?php
/**
 * Add send_sms field to interviews table
 * Run this file once: http://localhost/rms/add_sms_field.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cmsadver_rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Adding send_sms field to interviews table...</h2>";

// Check if column already exists
$check_sql = "SHOW COLUMNS FROM `interviews` LIKE 'send_sms'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "<p style='color: orange;'>✓ Column 'send_sms' already exists in interviews table.</p>";
} else {
    // Add the column
    $sql = "ALTER TABLE `interviews` 
            ADD COLUMN `send_sms` TINYINT(1) DEFAULT 0 COMMENT 'Send SMS notification' 
            AFTER `send_whatsapp`";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✓ Successfully added 'send_sms' column to interviews table!</p>";
    } else {
        echo "<p style='color: red;'>✗ Error adding column: " . $conn->error . "</p>";
    }
}

echo "<hr>";
echo "<h3>Current interviews table structure:</h3>";

// Show table structure
$structure_sql = "DESCRIBE interviews";
$structure_result = $conn->query($structure_sql);

if ($structure_result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr style='background: #667eea; color: white;'>";
    echo "<th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th>";
    echo "</tr>";
    
    while($row = $structure_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['Field'] . "</strong></td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

$conn->close();

echo "<hr>";
echo "<p><strong>Done!</strong> You can now delete this file.</p>";
echo "<p><a href='interview/create_interview'>Go to Create Interview Form</a></p>";
?>
