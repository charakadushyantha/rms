<?php
/**
 * Database Diagnostic Script
 * Run: http://localhost/rms/check_database.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

echo "<!DOCTYPE html><html><head><title>Database Check</title>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#4CAF50;color:white;}</style>";
echo "</head><body>";

echo "<h2>Database Diagnostic Report</h2>";
echo "<hr>";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color:green;'>✓ Connected to database: <strong>$db_name</strong></p>";

// Check candidate_details table structure
echo "<h3>1. Candidate Details Table Structure</h3>";
$result = $conn->query("DESCRIBE candidate_details");
echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while ($row = $result->fetch_assoc()) {
    $highlight = ($row['Field'] == 'cd_created_at') ? ' style="background:#ffffcc;"' : '';
    echo "<tr$highlight>";
    echo "<td><strong>" . $row['Field'] . "</strong></td>";
    echo "<td>" . $row['Type'] . "</td>";
    echo "<td>" . $row['Null'] . "</td>";
    echo "<td>" . $row['Key'] . "</td>";
    echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
    echo "<td>" . $row['Extra'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check if cd_created_at exists
$has_created_at = false;
$result = $conn->query("SHOW COLUMNS FROM candidate_details LIKE 'cd_created_at'");
$has_created_at = ($result->num_rows > 0);

echo "<p><strong>cd_created_at column exists:</strong> " . ($has_created_at ? '<span style="color:green;">YES ✓</span>' : '<span style="color:red;">NO ✗</span>') . "</p>";

// Count candidates by status
echo "<h3>2. Candidate Statistics</h3>";
$result = $conn->query("SELECT cd_status, COUNT(*) as count FROM candidate_details GROUP BY cd_status");
echo "<table><tr><th>Status</th><th>Count</th></tr>";
$total = 0;
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['cd_status'] . "</td><td>" . $row['count'] . "</td></tr>";
    $total += $row['count'];
}
echo "<tr style='background:#f0f0f0;font-weight:bold;'><td>TOTAL</td><td>$total</td></tr>";
echo "</table>";

// If cd_created_at exists, show time-based stats
if ($has_created_at) {
    echo "<h3>3. Time-Based Statistics (Selected Candidates)</h3>";
    
    // Today
    $result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND DATE(cd_created_at) = CURDATE()");
    $today = $result->fetch_assoc()['count'];
    
    // This week
    $result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND YEARWEEK(cd_created_at, 1) = YEARWEEK(CURDATE(), 1)");
    $this_week = $result->fetch_assoc()['count'];
    
    // This month
    $result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND MONTH(cd_created_at) = MONTH(CURDATE()) AND YEAR(cd_created_at) = YEAR(CURDATE())");
    $this_month = $result->fetch_assoc()['count'];
    
    // Total selected
    $result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected'");
    $total_selected = $result->fetch_assoc()['count'];
    
    echo "<table>";
    echo "<tr><th>Period</th><th>Count</th></tr>";
    echo "<tr><td>Today</td><td>$today</td></tr>";
    echo "<tr><td>This Week</td><td>$this_week</td></tr>";
    echo "<tr><td>This Month</td><td>$this_month</td></tr>";
    echo "<tr style='background:#f0f0f0;font-weight:bold;'><td>Total Selected</td><td>$total_selected</td></tr>";
    echo "</table>";
    
    // Show sample dates
    echo "<h3>4. Sample Created Dates (First 10 Selected)</h3>";
    $result = $conn->query("SELECT cd_name, cd_created_at FROM candidate_details WHERE cd_status='Selected' ORDER BY cd_created_at DESC LIMIT 10");
    echo "<table><tr><th>Name</th><th>Created At</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['cd_name'] . "</td><td>" . $row['cd_created_at'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<div style='background:#fff3cd;padding:15px;border-left:4px solid #ffc107;'>";
    echo "<h3>⚠ Action Required</h3>";
    echo "<p>The <code>cd_created_at</code> column is missing. Time-based statistics will not work.</p>";
    echo "<p><a href='add_created_at_column.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Column Now</a></p>";
    echo "</div>";
}

$conn->close();

echo "<hr>";
echo "<p><a href='index.php/A_dashboard/Asele_candidate_view'>← Back to Selected Candidates</a></p>";
echo "</body></html>";
