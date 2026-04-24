<?php
/**
 * Simple Dashboard Installer
 * Run: http://localhost/rms/install_dashboard.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Installing Real-Time Dashboard...</h1>";

// Read and execute SQL file
$sql_file = 'Database/realtime_dashboard_schema.sql';
$sql = file_get_contents($sql_file);

// Use multi_query to execute all at once
if ($conn->multi_query($sql)) {
    echo "<p>✅ SQL executed successfully!</p>";
    
    // Clear all results
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    
} else {
    echo "<p>❌ Error: " . $conn->error . "</p>";
}

// Verify tables
echo "<h2>Checking tables...</h2>";
$tables = ['pipeline_stages', 'candidate_pipeline', 'hiring_decisions', 'decision_votes', 
           'interview_panels', 'interviewer_availability', 'pipeline_activity_log', 'dashboard_metrics'];

$all_good = true;
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "✅ $table<br>";
    } else {
        echo "❌ $table<br>";
        $all_good = false;
    }
}

if ($all_good) {
    echo "<hr>";
    echo "<h2 style='color:green;'>✅ Installation Complete!</h2>";
    echo "<p style='font-size:20px;'><a href='realtime_dashboard' style='color:#667eea; font-weight:bold;'>→ Open Dashboard</a></p>";
} else {
    echo "<hr>";
    echo "<h2 style='color:red;'>⚠️ Some tables missing</h2>";
    echo "<p>Please import manually via phpMyAdmin:</p>";
    echo "<ol>";
    echo "<li>Open phpMyAdmin</li>";
    echo "<li>Select 'rmsdb' database</li>";
    echo "<li>Click 'Import' tab</li>";
    echo "<li>Choose file: Database/realtime_dashboard_schema.sql</li>";
    echo "<li>Click 'Go'</li>";
    echo "</ol>";
}

$conn->close();
?>
<style>
body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
a { color: #667eea; text-decoration: none; font-weight: bold; }
</style>
