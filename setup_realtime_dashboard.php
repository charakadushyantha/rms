<?php
/**
 * Quick Setup for Real-Time Dashboard
 * Run this once: http://localhost/rms/setup_realtime_dashboard.php
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "<h1>🚀 Real-Time Dashboard Setup</h1>";
echo "<hr>";

// Read SQL file
$sql_file = 'Database/realtime_dashboard_schema.sql';
if (!file_exists($sql_file)) {
    die("❌ SQL file not found: $sql_file");
}

$sql = file_get_contents($sql_file);

// Remove comments
$sql = preg_replace('/--.*$/m', '', $sql);
$sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

// Split by semicolon but keep multi-line statements together
$queries = [];
$current_query = '';
$lines = explode("\n", $sql);

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) continue;
    
    $current_query .= $line . ' ';
    
    if (substr($line, -1) === ';') {
        $queries[] = trim($current_query);
        $current_query = '';
    }
}

$success_count = 0;
$error_count = 0;

foreach ($queries as $query) {
    if (empty($query)) continue;
    
    // Execute query
    if ($conn->query($query)) {
        $success_count++;
        
        // Extract table name
        if (preg_match('/CREATE TABLE.*?`(\w+)`/i', $query, $matches)) {
            echo "✅ Created table: <strong>{$matches[1]}</strong><br>";
        } elseif (preg_match('/INSERT INTO.*?`(\w+)`/i', $query, $matches)) {
            echo "✅ Inserted data into: <strong>{$matches[1]}</strong><br>";
        }
    } else {
        $error_count++;
        // Only show error if it's not "already exists"
        if (strpos($conn->error, 'already exists') === false && !empty($conn->error)) {
            echo "⚠️ Error: " . htmlspecialchars($conn->error) . "<br>";
            echo "Query: " . htmlspecialchars(substr($query, 0, 100)) . "...<br>";
        }
    }
}

echo "<hr>";
echo "<h2>✅ Setup Complete!</h2>";
echo "<p>Successfully executed $success_count queries</p>";

if ($error_count > 0) {
    echo "<p>⚠️ $error_count error(s) (might be tables already exist)</p>";
}

// Check if tables exist
echo "<h3>Verification:</h3>";
$tables = [
    'pipeline_stages',
    'candidate_pipeline', 
    'hiring_decisions',
    'decision_votes',
    'interview_panels',
    'interviewer_availability',
    'pipeline_activity_log',
    'dashboard_metrics'
];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "✅ Table <strong>$table</strong> exists<br>";
    } else {
        echo "❌ Table <strong>$table</strong> NOT found<br>";
    }
}

// Check if we have pipeline stages
$result = $conn->query("SELECT COUNT(*) as count FROM pipeline_stages");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<br><p>📊 Pipeline stages: <strong>{$row['count']}</strong></p>";
} else {
    echo "<br><p>⚠️ Could not count pipeline stages</p>";
}

// Add some sample data if candidates table exists
$result = $conn->query("SHOW TABLES LIKE 'candidates'");
if ($result->num_rows > 0) {
    // Check if we have candidates
    $result = $conn->query("SELECT id, name FROM candidates LIMIT 5");
    if ($result->num_rows > 0) {
        echo "<h3>Adding sample pipeline data...</h3>";
        
        while ($candidate = $result->fetch_assoc()) {
            // Add to pipeline (random stage)
            $stage_id = rand(1, 5);
            $urgency = ['low', 'medium', 'high'][rand(0, 2)];
            
            $conn->query("INSERT INTO candidate_pipeline (candidate_id, stage_id, urgency_level, moved_at) 
                         VALUES ({$candidate['id']}, $stage_id, '$urgency', NOW())
                         ON DUPLICATE KEY UPDATE stage_id = stage_id");
            
            echo "✅ Added <strong>{$candidate['name']}</strong> to pipeline<br>";
        }
    }
}

echo "<hr>";
echo "<h3>🎉 Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ Database tables created</li>";
echo "<li>🎯 <strong>Access dashboard:</strong> <a href='realtime_dashboard' style='font-size:18px; color:#667eea;'>Click Here to Open Dashboard</a></li>";
echo "<li>📖 Read documentation: <a href='REALTIME_DASHBOARD_README.md'>REALTIME_DASHBOARD_README.md</a></li>";
echo "</ol>";

echo "<hr>";
echo "<div style='background:#e3f2fd; padding:20px; border-radius:8px; margin:20px 0;'>";
echo "<h3>🔗 Dashboard URL:</h3>";
echo "<p style='font-size:20px;'><strong><a href='realtime_dashboard'>http://localhost/rms/realtime_dashboard</a></strong></p>";
echo "</div>";

echo "<p><strong>You can delete this file after setup is complete.</strong></p>";

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 { color: #333; }
    code {
        background: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
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
