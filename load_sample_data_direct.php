<?php
/**
 * Load Sample Data Script - Direct Database Connection
 * Run this file from browser: http://localhost/rms/load_sample_data_direct.php
 */

// Database configuration - Update these if needed
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

echo "<!DOCTYPE html><html><head><title>Load Sample Data</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} table{border-collapse:collapse;} th,td{border:1px solid #ddd;padding:10px;text-align:left;}</style>";
echo "</head><body>";

echo "<h2>Loading Sample Data for RMS Application</h2>";
echo "<hr>";

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color:green;'>✓ Database connection successful!</p>";

// Read SQL file
$sql_file = 'sample_data.sql';
if (!file_exists($sql_file)) {
    die("<p style='color:red;'>Error: sample_data.sql file not found!</p>");
}

$sql = file_get_contents($sql_file);

// Remove comments and split into queries
$lines = explode("\n", $sql);
$query = '';
$success_count = 0;
$error_count = 0;
$errors = [];

echo "<h3>Executing SQL Queries...</h3>";
echo "<div style='max-height:400px;overflow-y:auto;border:1px solid #ccc;padding:10px;background:#f5f5f5;'>";

foreach ($lines as $line) {
    $line = trim($line);
    
    // Skip comments and empty lines
    if (empty($line) || substr($line, 0, 2) == '--') {
        continue;
    }
    
    $query .= $line . ' ';
    
    // Check if query is complete
    if (substr(trim($line), -1) == ';') {
        $query = trim($query);
        
        if (!empty($query)) {
            if ($conn->query($query)) {
                $success_count++;
                echo "<span style='color:green;'>✓</span> Query executed successfully<br>";
            } else {
                $error_count++;
                $error_msg = $conn->error;
                $errors[] = $error_msg;
                echo "<span style='color:red;'>✗</span> Query failed: " . htmlspecialchars($error_msg) . "<br>";
            }
        }
        
        $query = '';
    }
}

echo "</div>";
echo "<hr>";

echo "<h3>Summary</h3>";
echo "<p><strong>Successful queries:</strong> <span style='color:green;font-size:20px;'>$success_count</span></p>";
echo "<p><strong>Failed queries:</strong> <span style='color:" . ($error_count > 0 ? 'red' : 'green') . ";font-size:20px;'>$error_count</span></p>";

if ($error_count > 0) {
    echo "<h4 style='color:red;'>Errors:</h4>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
}

// Get actual counts from database
$result = $conn->query("SELECT COUNT(*) as total FROM candidate_details");
$total = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected'");
$selected = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='In Process'");
$in_progress = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Shortlisted'");
$shortlisted = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Rejected'");
$rejected = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Hold'");
$hold = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as total FROM calendar_events");
$events = $result->fetch_assoc()['total'];

echo "<hr>";
echo "<h3>Database Statistics</h3>";
echo "<table>";
echo "<tr><th>Category</th><th>Count</th></tr>";
echo "<tr><td>Total Candidates</td><td style='font-size:18px;font-weight:bold;'>$total</td></tr>";
echo "<tr><td>Selected</td><td>$selected</td></tr>";
echo "<tr><td>In Progress</td><td>$in_progress</td></tr>";
echo "<tr><td>Shortlisted</td><td>$shortlisted</td></tr>";
echo "<tr><td>Rejected</td><td>$rejected</td></tr>";
echo "<tr><td>Hold</td><td>$hold</td></tr>";
echo "<tr><td>Calendar Events</td><td>$events</td></tr>";
echo "</table>";

echo "<hr>";
echo "<h3>Test Credentials</h3>";
echo "<table>";
echo "<tr><th>Role</th><th>Username</th><th>Password</th></tr>";
echo "<tr><td>Admin</td><td><strong>johndoe</strong></td><td><strong>admin123</strong></td></tr>";
echo "<tr><td>Recruiter</td><td><strong>sarah_rec</strong></td><td><strong>recruiter123</strong></td></tr>";
echo "<tr><td>Recruiter</td><td><strong>mike_rec</strong></td><td><strong>recruiter123</strong></td></tr>";
echo "<tr><td>Interviewer</td><td><strong>david_int</strong></td><td><strong>interviewer123</strong></td></tr>";
echo "<tr><td>Interviewer</td><td><strong>emma_int</strong></td><td><strong>interviewer123</strong></td></tr>";
echo "</table>";

echo "<hr>";
echo "<p><a href='index.php/Login' style='background:#4e73df;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Login Page</a></p>";
echo "<p style='color:red;'><strong>Security Note:</strong> Delete this file (load_sample_data_direct.php) after loading data!</p>";

$conn->close();

echo "</body></html>";
