<?php
/**
 * Add Multiple Interviewers Support
 * Run this file once: http://localhost/rms/add_multiple_interviewers_support.php
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

echo "<h2>Adding Multiple Interviewers Support...</h2>";
echo "<hr>";

// Step 1: Add fields to interview_config table
echo "<h3>Step 1: Updating interview_config table</h3>";

$fields_to_add = [
    [
        'name' => 'allow_multiple_interviewers',
        'definition' => "TINYINT(1) DEFAULT 0 COMMENT 'Allow multiple interviewers per interview'",
        'after' => 'timezone'
    ],
    [
        'name' => 'max_interviewers',
        'definition' => "INT(11) DEFAULT 3 COMMENT 'Maximum number of interviewers'",
        'after' => 'allow_multiple_interviewers'
    ]
];

foreach ($fields_to_add as $field) {
    // Check if column exists
    $check_sql = "SHOW COLUMNS FROM `interview_config` LIKE '{$field['name']}'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        echo "<p style='color: orange;'>✓ Column '{$field['name']}' already exists.</p>";
    } else {
        $sql = "ALTER TABLE `interview_config` ADD COLUMN `{$field['name']}` {$field['definition']} AFTER `{$field['after']}`";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>✓ Successfully added '{$field['name']}' column!</p>";
        } else {
            echo "<p style='color: red;'>✗ Error adding '{$field['name']}': " . $conn->error . "</p>";
        }
    }
}

// Step 2: Update existing configuration
echo "<hr>";
echo "<h3>Step 2: Updating existing configuration</h3>";

$update_sql = "UPDATE `interview_config` SET 
               `allow_multiple_interviewers` = 0, 
               `max_interviewers` = 3 
               WHERE `id` = 1";

if ($conn->query($update_sql) === TRUE) {
    echo "<p style='color: green;'>✓ Configuration updated with default values!</p>";
} else {
    echo "<p style='color: orange;'>Note: " . $conn->error . "</p>";
}

// Step 3: Modify interviews table to support multiple interviewers
echo "<hr>";
echo "<h3>Step 3: Updating interviews table</h3>";

// Check current column type
$check_column_sql = "SHOW COLUMNS FROM `interviews` LIKE 'assigned_interviewer'";
$column_result = $conn->query($check_column_sql);

if ($column_result->num_rows > 0) {
    $column_info = $column_result->fetch_assoc();
    
    // Check if it's already TEXT type
    if (strpos(strtolower($column_info['Type']), 'text') !== false) {
        echo "<p style='color: orange;'>✓ Column 'assigned_interviewer' is already TEXT type.</p>";
    } else {
        // Modify to TEXT to support comma-separated values
        $modify_sql = "ALTER TABLE `interviews` 
                      MODIFY COLUMN `assigned_interviewer` TEXT NULL 
                      COMMENT 'Assigned interviewer(s) - comma-separated for multiple'";
        
        if ($conn->query($modify_sql) === TRUE) {
            echo "<p style='color: green;'>✓ Successfully modified 'assigned_interviewer' column to support multiple interviewers!</p>";
        } else {
            echo "<p style='color: red;'>✗ Error modifying column: " . $conn->error . "</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Column 'assigned_interviewer' not found in interviews table!</p>";
}

// Step 4: Show current configuration
echo "<hr>";
echo "<h3>Step 4: Current Configuration</h3>";

$config_sql = "SELECT allow_multiple_interviewers, max_interviewers FROM interview_config WHERE id = 1";
$config_result = $conn->query($config_sql);

if ($config_result && $config_result->num_rows > 0) {
    $config = $config_result->fetch_assoc();
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr style='background: #667eea; color: white;'>";
    echo "<th>Setting</th><th>Value</th><th>Description</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong>Allow Multiple Interviewers</strong></td>";
    echo "<td>" . ($config['allow_multiple_interviewers'] ? '<span style="color: green;">✓ Enabled</span>' : '<span style="color: red;">✗ Disabled</span>') . "</td>";
    echo "<td>Enable panel interviews with multiple interviewers</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong>Maximum Interviewers</strong></td>";
    echo "<td><strong>" . $config['max_interviewers'] . "</strong></td>";
    echo "<td>Maximum number of interviewers per interview</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p style='color: orange;'>No configuration found. Please set up interview configuration first.</p>";
}

$conn->close();

echo "<hr>";
echo "<h2 style='color: green;'>✅ Migration Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Go to <a href='Setup/interview_configuration' target='_blank'>Interview Configuration</a></li>";
echo "<li>Enable 'Allow Multiple Interviewers' toggle</li>";
echo "<li>Set maximum number of interviewers (default: 3)</li>";
echo "<li>Save configuration</li>";
echo "<li>Go to <a href='interview/create_interview' target='_blank'>Create Interview</a> to test!</li>";
echo "</ol>";
echo "<hr>";
echo "<p><strong>Done!</strong> You can now delete this file.</p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    padding: 20px;
    max-width: 900px;
    margin: 0 auto;
}
h2 {
    color: #667eea;
}
h3 {
    color: #764ba2;
    margin-top: 20px;
}
table {
    width: 100%;
    margin-top: 15px;
}
th, td {
    text-align: left;
    padding: 12px;
}
tr:nth-child(even) {
    background: #f8f9fa;
}
a {
    color: #667eea;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
}
</style>
