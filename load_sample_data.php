<?php
/**
 * Load Sample Data Script
 * Run this file from browser: http://localhost/rms/load_sample_data.php
 * Or from command line: php load_sample_data.php
 */

// Load CodeIgniter bootstrap
require_once 'index.php';

// Get CI instance
$CI =& get_instance();

// Load database
$CI->load->database();

echo "<h2>Loading Sample Data for RMS Application</h2>";
echo "<hr>";

// Read SQL file
$sql_file = 'sample_data.sql';
if (!file_exists($sql_file)) {
    die("<p style='color:red;'>Error: sample_data.sql file not found!</p>");
}

$sql = file_get_contents($sql_file);

// Split into individual queries
$queries = array_filter(array_map('trim', explode(';', $sql)));

$success_count = 0;
$error_count = 0;
$errors = [];

echo "<h3>Executing SQL Queries...</h3>";
echo "<pre>";

foreach ($queries as $query) {
    // Skip comments and empty queries
    if (empty($query) || strpos($query, '--') === 0) {
        continue;
    }
    
    try {
        if ($CI->db->query($query)) {
            $success_count++;
            echo "✓ Query executed successfully\n";
        } else {
            $error_count++;
            $error = $CI->db->error();
            $errors[] = $error['message'];
            echo "✗ Query failed: " . $error['message'] . "\n";
        }
    } catch (Exception $e) {
        $error_count++;
        $errors[] = $e->getMessage();
        echo "✗ Exception: " . $e->getMessage() . "\n";
    }
}

echo "</pre>";
echo "<hr>";

echo "<h3>Summary</h3>";
echo "<p><strong>Successful queries:</strong> $success_count</p>";
echo "<p><strong>Failed queries:</strong> $error_count</p>";

if ($error_count > 0) {
    echo "<h4 style='color:red;'>Errors:</h4>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<h3>Test Credentials</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
echo "<tr><th>Role</th><th>Username</th><th>Password</th></tr>";
echo "<tr><td>Admin</td><td>johndoe</td><td>admin123</td></tr>";
echo "<tr><td>Recruiter</td><td>sarah_rec</td><td>recruiter123</td></tr>";
echo "<tr><td>Recruiter</td><td>mike_rec</td><td>recruiter123</td></tr>";
echo "<tr><td>Interviewer</td><td>david_int</td><td>interviewer123</td></tr>";
echo "<tr><td>Interviewer</td><td>emma_int</td><td>interviewer123</td></tr>";
echo "</table>";

echo "<hr>";
echo "<h3>Sample Data Loaded</h3>";
echo "<ul>";
echo "<li><strong>Total Candidates:</strong> 120</li>";
echo "<li><strong>Selected:</strong> 15</li>";
echo "<li><strong>In Progress:</strong> 25</li>";
echo "<li><strong>Shortlisted:</strong> 40</li>";
echo "<li><strong>Rejected:</strong> 20</li>";
echo "<li><strong>Hold:</strong> 20</li>";
echo "<li><strong>Calendar Events:</strong> 13 interviews (5 past, 8 upcoming)</li>";
echo "</ul>"

echo "<hr>";
echo "<p><a href='index.php/Login'>Go to Login Page</a></p>";
echo "<p><strong>Note:</strong> Delete this file (load_sample_data.php) after loading data for security.</p>";
?>
