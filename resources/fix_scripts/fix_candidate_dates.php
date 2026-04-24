<?php
/**
 * Fix Candidate Creation Dates
 * This will spread the dates across the past 30 days
 * Run: http://localhost/rms/fix_candidate_dates.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

echo "<!DOCTYPE html><html><head><title>Fix Candidate Dates</title>";
echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .info{color:blue;}</style>";
echo "</head><body>";

echo "<h2>Fixing Candidate Creation Dates</h2>";
echo "<hr>";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p class='success'>✓ Connected to database</p>";

// Get all selected candidates
$result = $conn->query("SELECT cd_id, cd_name FROM candidate_details WHERE cd_status='Selected' ORDER BY cd_id");
$candidates = [];
while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
}

$total = count($candidates);
echo "<p class='info'>Found $total selected candidates</p>";

// Distribute dates:
// - 2 today
// - 5 this week (last 7 days)
// - 15 this month (last 30 days)
// - Rest older than 30 days

$updated = 0;
$today_count = 0;
$week_count = 0;
$month_count = 0;

foreach ($candidates as $index => $candidate) {
    $days_ago = 0;
    
    if ($index < 2) {
        // Today (2 candidates)
        $days_ago = 0;
        $today_count++;
        $label = "Today";
    } elseif ($index < 7) {
        // This week (5 more candidates = 7 total)
        $days_ago = rand(1, 6);
        $week_count++;
        $label = "This week ($days_ago days ago)";
    } elseif ($index < 15) {
        // This month (8 more candidates = 15 total)
        $days_ago = rand(7, 29);
        $month_count++;
        $label = "This month ($days_ago days ago)";
    } else {
        // Older (rest of candidates)
        $days_ago = rand(30, 90);
        $label = "Older ($days_ago days ago)";
    }
    
    // Calculate the date
    $new_date = date('Y-m-d H:i:s', strtotime("-$days_ago days"));
    
    // Update the database
    $sql = "UPDATE candidate_details SET cd_created_at = '$new_date' WHERE cd_id = " . $candidate['cd_id'];
    
    if ($conn->query($sql)) {
        $updated++;
        echo "<p class='success'>✓ Updated: <strong>" . $candidate['cd_name'] . "</strong> → $label ($new_date)</p>";
    } else {
        echo "<p style='color:red;'>✗ Failed to update: " . $candidate['cd_name'] . "</p>";
    }
}

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<ul>";
echo "<li><strong>Total updated:</strong> $updated candidates</li>";
echo "<li><strong>Today:</strong> $today_count candidates</li>";
echo "<li><strong>This week:</strong> " . ($week_count + $today_count) . " candidates</li>";
echo "<li><strong>This month:</strong> " . ($month_count + $week_count + $today_count) . " candidates</li>";
echo "</ul>";

// Show new statistics
echo "<h3>New Statistics</h3>";

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND DATE(cd_created_at) = CURDATE()");
$today = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND YEARWEEK(cd_created_at, 1) = YEARWEEK(CURDATE(), 1)");
$this_week = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected' AND MONTH(cd_created_at) = MONTH(CURDATE()) AND YEAR(cd_created_at) = YEAR(CURDATE())");
$this_month = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM candidate_details WHERE cd_status='Selected'");
$total_selected = $result->fetch_assoc()['count'];

echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
echo "<tr><th>Period</th><th>Count</th></tr>";
echo "<tr><td>Today</td><td><strong>$today</strong></td></tr>";
echo "<tr><td>This Week</td><td><strong>$this_week</strong></td></tr>";
echo "<tr><td>This Month</td><td><strong>$this_month</strong></td></tr>";
echo "<tr style='background:#f0f0f0;'><td>Total Selected</td><td><strong>$total_selected</strong></td></tr>";
echo "</table>";

$conn->close();

echo "<hr>";
echo "<p><a href='index.php/A_dashboard/Asele_candidate_view' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>View Selected Candidates Page</a></p>";
echo "<p style='color:red;'><strong>Note:</strong> Delete this file after running!</p>";
echo "</body></html>";
