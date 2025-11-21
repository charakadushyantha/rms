<?php
// Integration Setup Script
// This script will create all necessary tables for integrations

// Define BASEPATH
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');

// Load environment
require_once('application/config/environment.php');

echo "<h2>Integration Setup</h2>";
echo "<p>Creating integration tables...</p>";

// Database connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "✅ Connected to database<br>";

// Read SQL file
$sql_file = file_get_contents('database_migrations/add_integrations_tables.sql');

// Split by semicolon and execute each statement
$statements = array_filter(array_map('trim', explode(';', $sql_file)));

$success_count = 0;
$error_count = 0;

foreach ($statements as $statement) {
    if (empty($statement)) continue;
    
    if ($conn->query($statement) === TRUE) {
        $success_count++;
    } else {
        echo "⚠️ Error: " . $conn->error . "<br>";
        $error_count++;
    }
}

echo "<br><h3>Results:</h3>";
echo "✅ Successful: $success_count<br>";
if ($error_count > 0) {
    echo "⚠️ Errors: $error_count<br>";
}

// Verify tables
echo "<br><h3>Verifying Tables:</h3>";
$tables = array(
    'video_platform_config',
    'video_meetings',
    'assessment_platform_config',
    'candidate_assessments',
    'background_check_config',
    'background_checks',
    'ats_platform_config',
    'ats_sync_logs',
    'integration_webhooks',
    'integration_usage_stats'
);

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "✅ $table<br>";
    } else {
        echo "❌ $table<br>";
    }
}

$conn->close();

echo "<br><h3>Setup Complete!</h3>";
echo "<p>Now try accessing:</p>";
echo "<ul>";
echo "<li><a href='http://localhost/rms/Video_integrations'>Video Integrations</a></li>";
echo "<li><a href='http://localhost/rms/Assessment_integrations'>Assessment Integrations</a></li>";
echo "<li><a href='http://localhost/rms/Background_check'>Background Check</a></li>";
echo "<li><a href='http://localhost/rms/Ats_integrations'>ATS Integrations</a></li>";
echo "</ul>";

echo "<p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ DELETE THIS FILE:</strong> setup_integrations.php";
echo "</p>";
?>
